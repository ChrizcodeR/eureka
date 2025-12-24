<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SumaspayAcceso extends Model
{
    protected $table = 'sumaspay_accesos';
    
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

