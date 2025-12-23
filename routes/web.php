<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuarioSistemaController;

// Ruta pública para buscar usuario por cédula
Route::get('/', [UsuarioController::class, 'publicSearch'])->name('public.search');
Route::post('/buscar', [UsuarioController::class, 'publicSearchPost'])->name('public.search.post');
Route::get('/descargar-imagen/{cedula}', [UsuarioController::class, 'publicDownloadImage'])->name('public.downloadImage');

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (requiere autenticación)
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

// Usuarios (requiere autenticación)
Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::get('/api/usuarios', [UsuarioController::class, 'apiIndex'])->name('usuarios.api');
Route::get('/usuarios/plantilla', [UsuarioController::class, 'downloadTemplate'])->name('usuarios.template');
Route::get('/usuarios/{id}/descargar-imagen', [UsuarioController::class, 'downloadImage'])->name('usuarios.downloadImage');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
Route::post('/usuarios/importar', [UsuarioController::class, 'import'])->name('usuarios.import');
Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

// Configuración - Usuarios del Sistema (requiere autenticación)
Route::get('/configuracion/usuarios-sistema', [UsuarioSistemaController::class, 'index'])->name('configuracion.usuarios-sistema.index');
Route::post('/configuracion/usuarios-sistema', [UsuarioSistemaController::class, 'store'])->name('configuracion.usuarios-sistema.store');
Route::put('/configuracion/usuarios-sistema/{id}', [UsuarioSistemaController::class, 'update'])->name('configuracion.usuarios-sistema.update');
Route::delete('/configuracion/usuarios-sistema/{id}', [UsuarioSistemaController::class, 'destroy'])->name('configuracion.usuarios-sistema.destroy');
