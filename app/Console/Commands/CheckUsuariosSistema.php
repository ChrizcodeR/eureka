<?php

namespace App\Console\Commands;

use App\Models\UsuarioSistema;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CheckUsuariosSistema extends Command
{
    protected $signature = 'usuarios:check';
    protected $description = 'Verifica y muestra información de los usuarios del sistema';

    public function handle(): int
    {
        $usuarios = UsuarioSistema::all();

        if ($usuarios->isEmpty()) {
            $this->info('No hay usuarios en la base de datos.');
            return Command::SUCCESS;
        }

        $this->info('Usuarios del sistema:');
        $this->newLine();

        foreach ($usuarios as $usuario) {
            $this->line("ID: {$usuario->id}");
            $this->line("Email: {$usuario->email}");
            $this->line("Nombre: " . ($usuario->nombre ?? 'Sin nombre'));
            $this->line("Activo: " . ($usuario->activo ? 'Sí' : 'No'));
            $this->line("Password Hash: " . (substr($usuario->password, 0, 20) . '...'));
            $this->line("Password válido: " . (str_starts_with($usuario->password, '$2y$') || str_starts_with($usuario->password, '$2a$') || str_starts_with($usuario->password, '$2b$') ? 'Sí' : 'No'));
            $this->newLine();
        }

        return Command::SUCCESS;
    }
}
