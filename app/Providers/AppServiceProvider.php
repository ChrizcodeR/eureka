<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\UsuarioSistema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (Schema::hasTable('usuarios_sistema')) {
                if (!Schema::hasColumn('usuarios_sistema', 'role')) {
                    Schema::table('usuarios_sistema', function (Blueprint $table) {
                        $table->string('role')->default('admin')->index();
                    });
                }

                $hasRoot = Schema::hasColumn('usuarios_sistema', 'role')
                    ? UsuarioSistema::where('role', 'root')->exists()
                    : false;

                if (!$hasRoot) {
                    $existing = UsuarioSistema::whereRaw('LOWER(email) = ?', ['root@panel.com'])->first();
                    if (!$existing) {
                        UsuarioSistema::create([
                            'nombre' => 'ROOT',
                            'email' => 'root@panel.com',
                            'password' => 'root123',
                            'activo' => true,
                            'role' => 'root',
                        ]);
                    }
                }
            }
        } catch (\Throwable $e) {
        }
    }
}
