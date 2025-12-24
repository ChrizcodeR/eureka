<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddiAcceso extends Model
{
    protected $table = 'addi_accesos';
    
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

