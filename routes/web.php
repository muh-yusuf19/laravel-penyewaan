<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\BorrowController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Car
    Route::get('/car', [CarController::class, 'index'])->name('car.index');
    Route::get('/car/create', [CarController::class, 'create'])->name('car.create');
    Route::post('/car/store', [CarController::class, 'store'])->name('car.store');
    Route::get('/car/{car}/edit', [CarController::class, 'edit'])->name('car.edit');
    Route::patch('/car/update/{car}', [CarController::class, 'update'])->name('car.update');
    Route::delete('/car/delete/{car}', [CarController::class, 'destroy'])->name('car.delete');

    // Peminjaman
    Route::get('/peminjaman', [BorrowController::class, 'index'])->name('borrow.index');
    Route::get('/peminjaman/buat', [BorrowController::class, 'create'])->name('borrow.create');
    Route::post('/peminjaman/store', [BorrowController::class, 'store'])->name('borrow.store');
    Route::delete('/peminjaman/delete/{borrow}', [BorrowController::class, 'destroy'])->name('borrow.delete');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
