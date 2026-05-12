<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\LabReportController;
use App\Http\Controllers\AdminController;

Route::get('/', function () { return view('pages.welcome'); });

Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login']);
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('pages.dashboard', [
            'memberCount'         => \App\Models\FamilyMember::where('user_id', auth()->id())->count() + 1,
            'consultationCount'   => \App\Models\Consultation::where('user_id', auth()->id())->count(),
            'reportCount'         => \App\Models\LabReport::where('user_id', auth()->id())->count(),
            'alertCount'          => \App\Models\FamilyMember::where('user_id', auth()->id())->where('status', 'alert')->count(),
            'members'             => \App\Models\FamilyMember::where('user_id', auth()->id())->get(),
            'recentConsultations' => \App\Models\Consultation::where('user_id', auth()->id())->latest()->take(3)->get(),
        ]);
    })->name('dashboard');

    // Family
    Route::get('/family',         [FamilyMemberController::class, 'index'])->name('family');
    Route::post('/family',        [FamilyMemberController::class, 'store']);
    Route::put('/family/{id}',    [FamilyMemberController::class, 'update']);
    Route::delete('/family/{id}', [FamilyMemberController::class, 'destroy']);

    // Consultations
    Route::get('/consultation/new',      [ConsultationController::class, 'index'])->name('consultation.new');
    Route::post('/consultation/send',    [ConsultationController::class, 'send'])->name('consultation.send');
    Route::get('/consultations',         [ConsultationController::class, 'history'])->name('consultations');
    Route::get('/consultations/{id}/pdf', [ConsultationController::class, 'exportPdf'])->name('consultations.pdf');
    Route::delete('/consultations/{id}', [ConsultationController::class, 'destroy'])->name('consultations.destroy');

    // Lab Reports
    Route::get('/lab-reports',          [LabReportController::class, 'index'])->name('lab-reports');
    Route::post('/lab-reports',         [LabReportController::class, 'store']);
    Route::get('/lab-reports/{id}',     [LabReportController::class, 'show']);
    Route::delete('/lab-reports/{id}',  [LabReportController::class, 'destroy']);

    // Coming soon
    $soon = fn() => back()->with('info', 'Coming soon!');
    Route::get('/health-records', $soon)->name('health-records');
    Route::get('/settings',                      [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
Route::post('/settings/profile',             [\App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.profile');
Route::post('/settings/health',              [\App\Http\Controllers\SettingsController::class, 'updateHealth'])->name('settings.health');
Route::post('/settings/password',            [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.password');
Route::post('/settings/notifications',       [\App\Http\Controllers\SettingsController::class, 'updateNotifications'])->name('settings.notifications');
Route::post('/settings/delete-account',      [\App\Http\Controllers\SettingsController::class, 'deleteAccount'])->name('settings.delete');
    Route::get('/forgot-password',$soon)->name('password.request');

    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('users.toggleAdmin');
        Route::get('/consultations', [AdminController::class, 'consultations'])->name('consultations');
        Route::get('/lab-reports', [AdminController::class, 'labReports'])->name('labReports');
    });

});
