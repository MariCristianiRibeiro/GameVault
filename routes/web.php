<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesenvolvedoraController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\JogoController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\PlataformaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::get('/registro', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/registro', [RegisteredUserController::class, 'store'])->name('register.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pesquisa', [PesquisaController::class, 'index'])->name('pesquisa.index');

    Route::resource('plataformas', PlataformaController::class)->except('show');
    Route::resource('generos', GeneroController::class)->except('show');
    Route::resource('desenvolvedoras', DesenvolvedoraController::class)->except('show');
    Route::resource('jogos', JogoController::class);
});
