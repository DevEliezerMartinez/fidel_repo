<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Ruta principal para redirigir al login si no está autenticado
Route::get('/', function () {
    return redirect('/login');
});

// Ruta para el dashboard, pasando los datos desde el EventController
Route::get('/dashboard', [EventController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Ruta para panorama_gral que maneja la consulta de eventos (también usando el EventController)
Route::get('/panorama_gral', [EventController::class, 'index'])->middleware(['auth'])->name('panorama_gral');

// Rutas de administración de usuarios y eventos
Route::get('/adminUsuarios', [EventController::class, 'sh1'])->middleware(['auth'])->name('adminUsuarios');
Route::get('/adminEventos', [EventController::class, 'sh2'])->middleware(['auth'])->name('adminEventos');

// Ruta para mostrar los detalles de un evento específico
Route::get('/detallesEvento/{id}', [EventController::class, 'show'])->middleware(['auth'])->name('detallesEvento');

// Ruta para administración de usuarios (método en AdminController)
Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');

// Rutas para el perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
