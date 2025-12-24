<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorreoAcceso extends Model
{
    protected $table = 'correo_accesos';
    
    protected $fillable = [
        'plataforma',
        'url',
        'user',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}

