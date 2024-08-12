<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminSessionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController as UserSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// 一般ユーザー用ルート
Route::middleware(['guest'])->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [UserSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [UserSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// 管理者用ルート
Route::middleware('guest:admin')->group(function () {
    Route::get('admin/login', [AdminSessionController::class, 'create'])
        ->name('admin.login');

    Route::post('admin/login', [AdminSessionController::class, 'store']);
});

// 認証済みユーザー用ルート
Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class])
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');

    Route::post('logout', [UserSessionController::class, 'destroy'])
        ->name('logout');
});

// 管理者用認証済みルート
Route::middleware('auth:admin')->group(function () {
    Route::post('admin/logout', [AdminSessionController::class, 'destroy'])
        ->name('admin.logout');
});
