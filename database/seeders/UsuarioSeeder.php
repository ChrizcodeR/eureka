<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            [
                'nombre_completo' => 'Juan Carlos Pérez García',
                'numero_cedula' => '1234567890',
            ],
            [
                'nombre_completo' => 'María Fernanda López Rodríguez',
                'numero_cedula' => '0987654321',
            ],
            [
                'nombre_completo' => 'Pedro Antonio Martínez Silva',
                'numero_cedula' => '1122334455',
            ],
            [
                'nombre_completo' => 'Ana Sofía González Ramírez',
                'numero_cedula' => '5544332211',
            ],
            [
                'nombre_completo' => 'Carlos Eduardo Sánchez Torres',
                'numero_cedula' => '6677889900',
            ],
            [
                'nombre_completo' => 'Laura Patricia Hernández Cruz',
                'numero_cedula' => '9988776655',
            ],
            [
                'nombre_completo' => 'Diego Alejandro Morales Vargas',
                'numero_cedula' => '4455667788',
            ],
            [
                'nombre_completo' => 'Valentina Isabel Rojas Méndez',
                'numero_cedula' => '3344556677',
            ],
            [
                'nombre_completo' => 'Santiago Miguel Castro Flores',
                'numero_cedula' => '2233445566',
            ],
            [
                'nombre_completo' => 'Camila Andrea Jiménez Ortiz',
                'numero_cedula' => '7788990011',
            ],
        ];

        foreach ($usuarios as $usuario) {
            Usuario::create($usuario);
        }
    }
}
