<?php

namespace App\Http\Controllers;

use App\Models\UsuarioSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        return view('configuracion.usuarios-sistema', compact('usuarios', 'search', 'perPage'));
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
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'Este email ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        UsuarioSistema::create([
            'nombre' => mb_strtoupper($request->nombre, 'UTF-8'),
            'email' => $request->email,
            'password' => $request->password, // El mutator del modelo se encargará del hash
            'activo' => $request->has('activo') ? true : false,
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
        ]);

        $data = [
            'nombre' => mb_strtoupper($request->nombre, 'UTF-8'),
            'email' => $request->email,
            'activo' => $request->has('activo') ? true : false,
        ];

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
        $usuario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario del sistema eliminado exitosamente'
        ]);
    }
}
