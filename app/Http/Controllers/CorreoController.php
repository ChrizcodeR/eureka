<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\MailConfig;
use App\Models\EmailTemplate;

class CorreoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }
        if (($request->session()->get('user_role') ?? 'admin') !== 'root') {
            return redirect()->route('dashboard')->with('error', 'No autorizado');
        }

        $config = MailConfig::first();

        if (!EmailTemplate::where('clave', 'envio_contrasena')->exists()) {
            $defaultHtml = <<<'HTML'
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Acceso al Sistema</title>
  <style>
    body{font-family:Inter,Arial,sans-serif;color:#111827;background:#f9fafb;margin:0;padding:24px}
    .container{max-width:640px;margin:auto;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;padding:24px}
    h2{margin:0 0 12px 0;color:#111827}
    p{margin:8px 0}
    .btn{display:inline-block;background:#4f46e5;color:#fff;padding:10px 16px;border-radius:8px;text-decoration:none}
    .meta{color:#6b7280;font-size:12px;margin-top:16px}
    .kbd{font-family:ui-monospace,Menlo,Consolas,monospace;background:#f3f4f6;border:1px solid #e5e7eb;border-radius:6px;padding:4px 8px}
  </style>
  </head>
<body>
  <div class="container">
    <h2>Tu acceso al sistema</h2>
    <p>Hola <strong>{{nombre}}</strong>, se ha creado tu acceso.</p>
    <p><strong>Usuario:</strong> <span class="kbd">{{usuario}}</span></p>
    <p><strong>Contraseña:</strong> <span class="kbd">{{contrasena}}</span></p>
    <p>Puedes ingresar en el siguiente enlace:</p>
    <p><a class="btn" href="{{url_acceso}}" target="_blank">Entrar</a></p>
    <p class="meta">Si no solicitaste este acceso, ignora este mensaje.</p>
  </div>
</body>
</html>
HTML;

            EmailTemplate::create([
                'nombre' => 'Envío de Contraseña',
                'clave' => 'envio_contrasena',
                'asunto' => 'Tu acceso al sistema',
                'html' => $defaultHtml,
                'activo' => true,
            ]);
        }

        $templates = EmailTemplate::orderBy('created_at', 'desc')->get();

        return view('configuracion.correo', compact('config', 'templates'));
    }

    public function saveConfig(Request $request)
    {
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }
        if (($request->session()->get('user_role') ?? 'admin') !== 'root') {
            return redirect()->route('dashboard')->with('error', 'No autorizado');
        }

        $data = $request->validate([
            'host' => ['nullable','string','max:255'],
            'port' => ['nullable','integer','min:1','max:65535'],
            'encryption' => ['nullable','string','in:tls,ssl,null'],
            'username' => ['nullable','string','max:255'],
            'password' => ['nullable','string'],
            'from_address' => ['nullable','email'],
            'from_name' => ['nullable','string','max:255'],
            'activo' => ['nullable','boolean'],
        ]);

        $config = MailConfig::first();
        if (!$config) $config = new MailConfig();

        $config->host = $data['host'] ?? $config->host;
        $config->port = $data['port'] ?? $config->port;
        $config->encryption = $data['encryption'] ?? $config->encryption;
        $config->username = $data['username'] ?? $config->username;
        if (array_key_exists('password', $data) && $data['password'] !== null && $data['password'] !== '') {
            $config->password = Crypt::encryptString($data['password']);
        }
        $config->from_address = $data['from_address'] ?? $config->from_address;
        $config->from_name = $data['from_name'] ?? $config->from_name;
        $config->activo = $request->has('activo') ? true : false;
        $config->save();

        return redirect()->route('configuracion.correo.index')->with('success', 'Configuración de correo guardada');
    }

    public function storeTemplate(Request $request)
    {
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }
        if (($request->session()->get('user_role') ?? 'admin') !== 'root') {
            return redirect()->route('dashboard')->with('error', 'No autorizado');
        }

        $data = $request->validate([
            'nombre' => ['required','string','max:255'],
            'clave' => ['required','string','max:255','unique:email_templates,clave'],
            'asunto' => ['required','string','max:255'],
            'html' => ['required','string'],
            'activo' => ['nullable','boolean'],
        ]);

        EmailTemplate::create([
            'nombre' => $data['nombre'],
            'clave' => strtolower($data['clave']),
            'asunto' => $data['asunto'],
            'html' => $data['html'],
            'activo' => $request->has('activo') ? true : false,
        ]);

        return redirect()->route('configuracion.correo.index')->with('success', 'Plantilla creada');
    }

    public function updateTemplate(Request $request, $id)
    {
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }
        if (($request->session()->get('user_role') ?? 'admin') !== 'root') {
            return redirect()->route('dashboard')->with('error', 'No autorizado');
        }

        $template = EmailTemplate::findOrFail($id);
        $data = $request->validate([
            'nombre' => ['required','string','max:255'],
            'clave' => ['required','string','max:255','unique:email_templates,clave,' . $id],
            'asunto' => ['required','string','max:255'],
            'html' => ['required','string'],
            'activo' => ['nullable','boolean'],
        ]);

        $template->update([
            'nombre' => $data['nombre'],
            'clave' => strtolower($data['clave']),
            'asunto' => $data['asunto'],
            'html' => $data['html'],
            'activo' => $request->has('activo') ? true : false,
        ]);

        return redirect()->route('configuracion.correo.index')->with('success', 'Plantilla actualizada');
    }

    public function destroyTemplate(Request $request, $id)
    {
        if (!$request->session()->get('authenticated')) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 401);
        }
        if (($request->session()->get('user_role') ?? 'admin') !== 'root') {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $template = EmailTemplate::findOrFail($id);
        $template->delete();

        return response()->json(['success' => true]);
    }

    public function testSend(Request $request)
    {
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }
        if (($request->session()->get('user_role') ?? 'admin') !== 'root') {
            return redirect()->route('dashboard')->with('error', 'No autorizado');
        }

        $data = $request->validate([
            'to_email' => ['required','email'],
            'template_id' => ['required','integer','exists:email_templates,id'],
        ]);

        $config = MailConfig::first();
        if (!$config || !$config->activo) {
            return back()->with('error', 'Configuración de correo no disponible o inactiva');
        }

        $template = EmailTemplate::findOrFail($data['template_id']);

        try {
            $password = $config->password ? Crypt::decryptString($config->password) : null;
        } catch (\Throwable $e) {
            $password = null;
        }

        $mailer = ['transport' => 'smtp'];
        $mailer['host'] = $config->host ?? '';
        $mailer['port'] = $config->port ?? 587;
        $mailer['encryption'] = ($config->encryption === 'null') ? null : ($config->encryption ?: null);
        $mailer['username'] = $config->username ?? '';
        $mailer['password'] = $password ?? '';
        $mailer['timeout'] = null;

        config(['mail.default' => 'smtp']);
        config(['mail.mailers.smtp' => $mailer]);
        config(['mail.from.address' => $config->from_address ?? $config->username ?? 'no-reply@example.com']);
        config(['mail.from.name' => $config->from_name ?? 'Eureka']);

        try {
            Mail::send([], [], function ($message) use ($data, $template) {
                $message->to($data['to_email']);
                $message->subject($template->asunto);
                $message->setBody($template->html, 'text/html');
            });
            return redirect()->route('configuracion.correo.index')->with('success', 'Correo de prueba enviado');
        } catch (\Throwable $e) {
            return back()->with('error', 'Error al enviar: ' . $e->getMessage());
        }
    }
}
