<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Landing page
Route::get('/', function () {
    return view('pages.welcome');
});

// Auth routes updated
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (require login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard', [
            'memberCount' => 1,
            'consultationCount' => 0,
            'reportCount' => 0,
            'alertCount' => 0,
            'members' => collect([]),
            'recentConsultations' => collect([]),
        ]);
    })->name('dashboard');
});
