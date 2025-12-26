<?php

namespace App\Http\Controllers;

use App\Models\UsuarioSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login
     */
    public function showLoginForm()
    {
        // Si ya está autenticado, redirigir al dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('login');
    }

    /**
     * Procesa el login
     */
    public function login(Request $request)
    {
        // Validar los datos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'password.required' => 'La contraseña es obligatoria',
        ]);

        // Buscar el usuario en la tabla usuarios_sistema (case-insensitive)
        $usuario = UsuarioSistema::whereRaw('LOWER(email) = ?', [strtolower($request->email)])->first();

        // Verificar si el usuario existe
        if (!$usuario) {
            return back()->with('error', 'Las credenciales no son correctas.');
        }

        // Verificar si el usuario está activo
        if (!$usuario->activo) {
            return back()->with('error', 'Tu cuenta está inactiva. Contacta al administrador.');
        }

        // Obtener el password directamente desde los atributos
        $passwordHash = $usuario->getAttributes()['password'] ?? $usuario->password;

        // Verificar que el hash sea válido antes de intentar verificar
        $isValidHash = str_starts_with($passwordHash, '$2y$') ||
                       str_starts_with($passwordHash, '$2a$') ||
                       str_starts_with($passwordHash, '$2b$');

        if (!$isValidHash) {
            \Log::error('Password hash inválido para usuario', [
                'email' => $usuario->email,
                'id' => $usuario->id,
                'hash_preview' => substr($passwordHash, 0, 30)
            ]);
            return back()->with('error', 'La contraseña de este usuario necesita ser restablecida. Contacta al administrador.');
        }

        // Verificar la contraseña
        try {
            if (!Hash::check($request->password, $passwordHash)) {
                return back()->with('error', 'Las credenciales no son correctas.');
            }
        } catch (\RuntimeException $e) {
            \Log::error('Error al verificar contraseña', [
                'email' => $usuario->email,
                'error' => $e->getMessage(),
                'hash_preview' => substr($passwordHash, 0, 30)
            ]);
            return back()->with('error', 'Error al verificar la contraseña. Contacta al administrador.');
        }

        // Si todo es correcto, crear sesión
        $request->session()->put('authenticated', true);
        $request->session()->put('user_email', $usuario->email);
        $request->session()->put('user_nombre', $usuario->nombre);
        $request->session()->put('user_id', $usuario->id);
        $request->session()->put('user_role', $usuario->role ?? 'admin');

        return redirect()->route('dashboard');
    }

    /**
     * Muestra el dashboard
     */
    public function dashboard(Request $request)
    {
        // Verificar si está autenticado
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        return view('dashboard');
    }

    /**
     * Cierra la sesión
     */
    public function logout(Request $request)
    {
        // Limpiar la sesión
        $request->session()->flush();

        return redirect()->route('login');
    }
}
