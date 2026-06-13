<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth','role:admin'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('dashboard');
        });

    });


Route::middleware(['auth','role:mahasiswa'])
    ->group(function () {

        Route::get('/krs', function () {
            return "KRS Mahasiswa";
        });

    });


Route::middleware(['auth'])->group(function () {
    Route::resource('mahasiswa', MahasiswaController::class);
});


// Dashboard admin
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth'])->name('dashboard');

// Dashboard admin untuk mahasiswa
Route::middleware(['auth'])->group(function () {
    Route::resource('mahasiswa', MahasiswaController::class);
});

// Dashboard admin untuk dosen
Route::middleware(['auth'])->group(function () {
    Route::resource('dosen', DosenController::class);
});