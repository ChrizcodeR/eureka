<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuarioSistemaController;
use App\Http\Controllers\AccesoController;
use App\Http\Controllers\ConsolaController;
use App\Http\Controllers\CorreoController;

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
Route::get('/configuracion/usuarios-sistema/bootstrap-root', [UsuarioSistemaController::class, 'bootstrapRoot'])->name('configuracion.usuarios-sistema.bootstrap-root');
Route::get('/configuracion/usuarios-sistema/reset-password/{id}', [UsuarioSistemaController::class, 'resetPassword'])->name('configuracion.usuarios-sistema.reset');

// Log de Accesos (requiere autenticación)
Route::get('/accesos', [AccesoController::class, 'index'])->name('accesos.index');
Route::get('/accesos/create', [AccesoController::class, 'create'])->name('accesos.create');
Route::post('/accesos', [AccesoController::class, 'store'])->name('accesos.store');
Route::get('/accesos/plantilla', [AccesoController::class, 'downloadTemplate'])->name('accesos.template');
Route::post('/accesos/importar', [AccesoController::class, 'import'])->name('accesos.import');
Route::get('/accesos/{id}/edit', [AccesoController::class, 'edit'])->name('accesos.edit');
Route::get('/accesos/{id}/password', [AccesoController::class, 'getPassword'])->name('accesos.password');
Route::put('/accesos/{id}', [AccesoController::class, 'update'])->name('accesos.update');
Route::delete('/accesos/{id}', [AccesoController::class, 'destroy'])->name('accesos.destroy');

// Configuración - Consola SQL (requiere autenticación)
Route::get('/configuracion/consola', [ConsolaController::class, 'index'])->name('configuracion.consola.index');
Route::post('/configuracion/consola', [ConsolaController::class, 'execute'])->name('configuracion.consola.execute');
Route::get('/configuracion/consola/columns', [ConsolaController::class, 'columns'])->name('configuracion.consola.columns');

// Configuración - Servidor de Correo
Route::get('/configuracion/correo', [CorreoController::class, 'index'])->name('configuracion.correo.index');
Route::post('/configuracion/correo/config', [CorreoController::class, 'saveConfig'])->name('configuracion.correo.save');
Route::post('/configuracion/correo/plantillas', [CorreoController::class, 'storeTemplate'])->name('configuracion.correo.templates.store');
Route::put('/configuracion/correo/plantillas/{id}', [CorreoController::class, 'updateTemplate'])->name('configuracion.correo.templates.update');
Route::delete('/configuracion/correo/plantillas/{id}', [CorreoController::class, 'destroyTemplate'])->name('configuracion.correo.templates.destroy');
Route::post('/configuracion/correo/test', [CorreoController::class, 'testSend'])->name('configuracion.correo.test');
