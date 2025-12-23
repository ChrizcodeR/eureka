<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UsuarioSistema extends Model
{
    protected $table = 'usuarios_sistema';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'activo',
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function setPasswordAttribute($value): void
    {
        // Solo hashear si el valor no está vacío y no está ya hasheado
        if (!empty($value)) {
            // Verificar si ya está hasheado (los hashes de bcrypt siempre empiezan con $2y$)
            if (!str_starts_with($value, '$2y$') && !str_starts_with($value, '$2a$') && !str_starts_with($value, '$2b$')) {
                $this->attributes['password'] = Hash::make($value);
            } else {
                // Si ya está hasheado, guardarlo tal cual
                $this->attributes['password'] = $value;
            }
        }
    }
}
