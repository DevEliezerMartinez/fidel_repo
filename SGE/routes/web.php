<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('panorama_gral');
})->middleware(['auth', 'verified'])->name('dashboard');


// Ruta de /panorama_gral que muestra una vista
Route::get('/panorama_gral', function () {
    return view('panorama_gral');
})->middleware(['auth']); // La ruta está protegida por autenticación

    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
