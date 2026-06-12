<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::post('/logout', [RegisterController::class, 'logout'])->name('logout');

// ── DASHBOARD (AUTH REQUIRED) ─────────────────────────
Route::middleware('auth')->group(function () {
   Route::get('/forgot-password',
    [ForgotPasswordController::class, 'showLinkRequestForm']
)->name('password.request');

Route::post('/forgot-password',
    [ForgotPasswordController::class, 'sendResetLinkEmail']
)->name('password.email');

Route::get('/reset-password/{token}',
    [ResetPasswordController::class, 'showResetForm']
)->name('password.reset');

Route::post('/reset-password',
    [ResetPasswordController::class, 'reset']
)->name('password.update');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Roadmap
    Route::get('/roadmap', [DashboardController::class, 'roadmap'])->name('roadmap');
    Route::post('/roadmap/{roadmapId}/enroll', [DashboardController::class, 'enroll'])->name('roadmap.enroll');
    Route::get('/roadmap/{roadmapId}/stage/{stageId}', [DashboardController::class, 'stage'])->name('roadmap.stage');
    Route::post('/roadmap/{roadmapId}/stage/{stageId}/complete', [DashboardController::class, 'completeStage'])->name('roadmap.complete');

    // Quiz Routes
    Route::get('/roadmap/{roadmapId}/stage/{stageId}/quiz', [DashboardController::class, 'quiz'])
    ->name('roadmap.quiz');
    Route::post('/roadmap/{roadmapId}/stage/{stageId}/quiz/submit', [DashboardController::class, 'submitQuiz'])
    ->name('roadmap.quiz.submit');
    Route::get('/roadmap/{roadmapId}/stage/{stageId}/quiz/{attemptId}/result', [DashboardController::class, 'quizResult'])
    ->name('roadmap.quiz.result');

    // Target Belajar 
    Route::get('/target',              [DashboardController::class, 'target'])->name('target');
    Route::get('/target/create',       [DashboardController::class, 'targetCreate'])->name('target.create');
    Route::post('/target',             [DashboardController::class, 'targetStore'])->name('target.store');
    Route::get('/target/{id}/edit',    [DashboardController::class, 'targetEdit'])->name('target.edit');
    Route::put('/target/{id}',         [DashboardController::class, 'targetUpdate'])->name('target.update');
    Route::delete('/target/{id}',      [DashboardController::class, 'targetDestroy'])->name('target.destroy');
    
    // Progress
    Route::get('/progress', [DashboardController::class, 'progress'])->name('progress');

    // Settings
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');

    // Pengaturan
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::put('/pengaturan/password', [PengaturanController::class, 'updatePassword'])->name('pengaturan.password');
});