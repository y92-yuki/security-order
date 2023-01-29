<?php

use App\Http\Controllers\Auth\Owner\AuthenticatedSessionController;
use App\Http\Controllers\Auth\Owner\ConfirmablePasswordController;
use App\Http\Controllers\Auth\Owner\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\Owner\EmailVerificationPromptController;
use App\Http\Controllers\Auth\Owner\NewPasswordController;
use App\Http\Controllers\Auth\Owner\PasswordController;
use App\Http\Controllers\Auth\Owner\PasswordResetLinkController;
use App\Http\Controllers\Auth\Owner\RegisteredUserController;
use App\Http\Controllers\Auth\Owner\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\ManufacturerController;

Route::middleware('guest:owner')->prefix('owner')->name('owner.')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth:owner')->prefix('owner')->name('owner.')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});

Route::middleware('auth:owner')->prefix('owner')->name('owner.')->group(function () {
    Route::get('manufacturer/index', [ManufacturerController::class, 'index'])->name('manufacturer.index');
    Route::get('manufacturer/create', [ManufacturerController::class, 'create'])->name('manufacturer.create');
    Route::post('manufacturer/store', [ManufacturerController::class, 'store'])->name('manufacturer.store');
    Route::get('manufacturer/show/{manufacturer}', [ManufacturerController::class, 'show'])->name('manufacturer.show');
});