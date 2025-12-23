<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    
    protected $fillable = [
        'nombre_completo',
        'numero_cedula',
        'imagen',
        'imagen_descargada',
        'fecha_descarga',
        'busqueda_realizada',
        'fecha_busqueda',
    ];

    protected $casts = [
        'imagen_descargada' => 'boolean',
        'fecha_descarga' => 'datetime',
        'busqueda_realizada' => 'boolean',
        'fecha_busqueda' => 'datetime',
    ];
}
