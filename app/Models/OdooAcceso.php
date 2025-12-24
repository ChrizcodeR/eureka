<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OdooAcceso extends Model
{
    protected $table = 'odoo_accesos';
    
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

