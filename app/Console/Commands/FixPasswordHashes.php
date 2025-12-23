<?php

namespace App\Console\Commands;

use App\Models\UsuarioSistema;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class FixPasswordHashes extends Command
{
    protected $signature = 'usuarios:fix-passwords {--email= : Email del usuario a corregir} {--password= : Nueva contraseña}';
    protected $description = 'Corrige hashes de contraseñas inválidos en usuarios del sistema';

    public function handle(): int
    {
        $email = $this->option('email');
        $newPassword = $this->option('password');

        if ($email && $newPassword) {
            // Corregir un usuario específico
            $usuario = UsuarioSistema::where('email', $email)->first();
            
            if (!$usuario) {
                $this->error("Usuario con email '{$email}' no encontrado.");
                return Command::FAILURE;
            }

            $passwordHash = $usuario->getAttributes()['password'] ?? $usuario->password;
            $isValidHash = str_starts_with($passwordHash, '$2y$') || 
                          str_starts_with($passwordHash, '$2a$') || 
                          str_starts_with($passwordHash, '$2b$');

            if ($isValidHash) {
                $this->info("El usuario '{$email}' ya tiene un hash válido.");
                return Command::SUCCESS;
            }

            // Actualizar con nuevo hash
            $usuario->password = $newPassword;
            $usuario->save();

            $this->info("Contraseña corregida para el usuario '{$email}'.");
            return Command::SUCCESS;
        }

        // Listar usuarios con hashes inválidos
        $usuarios = UsuarioSistema::all();
        $invalidUsers = [];

        foreach ($usuarios as $usuario) {
            $passwordHash = $usuario->getAttributes()['password'] ?? $usuario->password;
            $isValidHash = str_starts_with($passwordHash, '$2y$') || 
                          str_starts_with($passwordHash, '$2a$') || 
                          str_starts_with($passwordHash, '$2b$');

            if (!$isValidHash) {
                $invalidUsers[] = $usuario;
            }
        }

        if (empty($invalidUsers)) {
            $this->info('Todos los usuarios tienen hashes válidos.');
            return Command::SUCCESS;
        }

        $this->warn('Usuarios con hashes inválidos:');
        foreach ($invalidUsers as $usuario) {
            $this->line("  - ID: {$usuario->id} | Email: {$usuario->email} | Nombre: " . ($usuario->nombre ?? 'Sin nombre'));
        }

        $this->newLine();
        $this->info('Para corregir un usuario, usa:');
        $this->line('  php artisan usuarios:fix-passwords --email=usuario@ejemplo.com --password=nueva_contraseña');

        return Command::SUCCESS;
    }
}
