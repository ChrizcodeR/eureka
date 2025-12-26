<?php

namespace App\Http\Controllers;

use App\Models\UsuarioSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class UsuarioSistemaController extends Controller
{
    /**
     * Muestra la lista de usuarios del sistema
     */
    public function index(Request $request)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        $search = $request->get('search');
        $perPage = $request->get('per_page', 10);

        $query = UsuarioSistema::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $perPage = in_array($perPage, [5, 10, 25, 50, 100]) ? (int)$perPage : 10;
        $usuarios = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        $hasRoleColumn = Schema::hasColumn('usuarios_sistema', 'role');
        $hasRoot = $hasRoleColumn ? UsuarioSistema::where('role', 'root')->exists() : false;

        return view('configuracion.usuarios-sistema', compact('usuarios', 'search', 'perPage', 'hasRoleColumn', 'hasRoot'));
    }

    /**
     * Almacena un nuevo usuario del sistema
     */
    public function store(Request $request)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios_sistema,email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'activo' => 'boolean',
            'role' => 'required|in:admin,root',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'Este email ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'role.required' => 'El rol es obligatorio',
            'role.in' => 'Rol inválido',
        ]);

        $role = $request->role;
        if (($request->session()->get('user_role') ?? 'admin') !== 'root') {
            $role = 'admin';
        }

        UsuarioSistema::create([
            'nombre' => mb_strtoupper($request->nombre, 'UTF-8'),
            'email' => $request->email,
            'password' => $request->password, // El mutator del modelo se encargará del hash
            'activo' => $request->has('activo') ? true : false,
            'role' => $role,
        ]);

        return redirect()->route('configuracion.usuarios-sistema.index')
            ->with('success', 'Usuario del sistema creado exitosamente');
    }

    /**
     * Actualiza un usuario del sistema existente
     */
    public function update(Request $request, $id)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        $usuario = UsuarioSistema::findOrFail($id);

        $rules = [
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:usuarios_sistema,email,' . $id,
            'activo' => 'boolean',
            'role' => 'required|in:admin,root',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        $request->validate($rules, [
            'nombre.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'Este email ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'role.required' => 'El rol es obligatorio',
            'role.in' => 'Rol inválido',
        ]);

        $data = [
            'nombre' => mb_strtoupper($request->nombre, 'UTF-8'),
            'email' => $request->email,
            'activo' => $request->has('activo') ? true : false,
            'role' => $request->role,
        ];

        if (($request->session()->get('user_role') ?? 'admin') !== 'root') {
            $data['role'] = 'admin';
            if ($usuario->role === 'root') {
                return redirect()->route('configuracion.usuarios-sistema.index')
                    ->with('error', 'No tienes permisos para modificar un usuario root');
            }
        }

        if ($request->filled('password')) {
            $data['password'] = $request->password; // El mutator del modelo se encargará del hash
        }

        $usuario->update($data);

        return redirect()->route('configuracion.usuarios-sistema.index')
            ->with('success', 'Usuario del sistema actualizado exitosamente');
    }

    /**
     * Elimina un usuario del sistema
     */
    public function destroy($id)
    {
        // Verificar autenticación
        if (!request()->session()->get('authenticated')) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 401);
        }

        $usuario = UsuarioSistema::findOrFail($id);
        if ((request()->session()->get('user_role') ?? 'admin') !== 'root' && $usuario->role === 'root') {
            return response()->json(['success' => false, 'message' => 'No tienes permisos para eliminar un usuario root'], 403);
        }
        $usuario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario del sistema eliminado exitosamente'
        ]);
    }

    public function bootstrapRoot(Request $request)
    {
        if (!Schema::hasTable('usuarios_sistema')) {
            return redirect()->route('configuracion.usuarios-sistema.index')->with('error', 'Tabla no disponible');
        }

        try {
            if (!Schema::hasColumn('usuarios_sistema', 'role')) {
                Schema::table('usuarios_sistema', function (Blueprint $table) {
                    $table->string('role')->default('admin')->index();
                });
            }

            if (UsuarioSistema::where('role', 'root')->exists()) {
                return redirect()->route('configuracion.usuarios-sistema.index')->with('error', 'Ya existe un usuario root');
            }

            $existing = UsuarioSistema::whereRaw('LOWER(email) = ?', ['root@panel.com'])->first();
            if ($existing) {
                $existing->update([
                    'nombre' => 'ROOT',
                    'password' => 'root123',
                    'activo' => true,
                    'role' => 'root',
                ]);
            } else {
                UsuarioSistema::create([
                    'nombre' => 'ROOT',
                    'email' => 'root@panel.com',
                    'password' => 'root123',
                    'activo' => true,
                    'role' => 'root',
                ]);
            }

            return redirect()->route('configuracion.usuarios-sistema.index')->with('success', 'Usuario root creado: root@panel.com / root123');
        } catch (\Throwable $e) {
            return redirect()->route('configuracion.usuarios-sistema.index')->with('error', 'Error al crear root: ' . $e->getMessage());
        }
    }
    public function resetPassword(Request $request, $id)
    {
        if (!Schema::hasTable('usuarios_sistema')) {
            return redirect()->route('login')->with('error', 'Tabla no disponible');
        }

        try {
            $usuario = UsuarioSistema::findOrFail($id);
            $nuevo = $request->get('nuevo', 'root123');
            $usuario->update([
                'password' => $nuevo,
                'activo' => true,
            ]);

            return redirect()->route('login')->with('success', 'Contraseña restablecida. Nuevo acceso: ' . ($usuario->email ?? '') . ' / ' . $nuevo);
        } catch (\Throwable $e) {
            return redirect()->route('login')->with('error', 'Error al restablecer: ' . $e->getMessage());
        }
    }
}
