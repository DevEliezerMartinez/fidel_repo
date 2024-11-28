<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
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

Route::get('detallesEvento/reservacionEvento/{eventId}/{mesa}', [EventController::class, 'reservacionEvento'])
    ->name('reservacionEvento');
    
Route::get('/events/{eventId}', [EventController::class, 'showDetalles']);
Route::put('/events/{eventId}', [EventController::class, 'updateInfo'])->name('events.update');

// Ruta para administración de usuarios (método en AdminController)
Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');

Route::post('/usuarios/crear', [UserController::class, 'store'])->name('usuarios.store');

// Ruta para mostrar el formulario de edición (retorna los datos del usuario en formato JSON)
Route::get('/usuarios/{user}/edit', [UserController::class, 'editJson'])->name('usuarios.edit');

Route::get('/eventos_master/{id}', [EventController::class, 'eventosMaster'])->name('eventos.master');


// Ruta para actualizar el usuario
Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');

Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

Route::post('/events', [EventController::class, 'store'])->name('events.store');

Route::put('/events/{event}/toggle-status', [EventController::class, 'toggleStatus']);

Route::get('/locations', [LocationController::class, 'index']);
Route::post('/reservar', [ReservaController::class, 'reservar'])->name('reservar');
Route::get('/ticket/reserva/{id}', [ReservaController::class, 'showTicket'])->name('showTicket');
Route::get('/ticket/{id}/download', [TicketController::class, 'downloadTicket'])->name('ticket.download');

// Rutas para el perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
