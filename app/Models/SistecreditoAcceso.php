<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SistecreditoAcceso extends Model
{
    protected $table = 'sistecredito_accesos';
    
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

