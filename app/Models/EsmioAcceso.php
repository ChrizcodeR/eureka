<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EsmioAcceso extends Model
{
    protected $table = 'esmio_accesos';
    
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

