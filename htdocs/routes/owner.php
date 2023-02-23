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
use App\Http\Controllers\Owner\CategoryController;
use App\Http\Controllers\Owner\ProductController;

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

// メーカー管理機能
Route::middleware('auth:owner')->prefix('owner')->name('owner.manufacturer.')->group(function () {
    Route::get('manufacturer/index', [ManufacturerController::class, 'index'])->name('index');
    Route::get('manufacturer/create', [ManufacturerController::class, 'create'])->name('create');
    Route::post('manufacturer/store', [ManufacturerController::class, 'store'])->name('store');
    Route::get('manufacturer/show/{manufacturer}', [ManufacturerController::class, 'show'])->name('show');
    Route::get('manufacturer/edit/{manufacturer}', [ManufacturerController::class, 'edit'])->name('edit');
    Route::post('manufacturer/update',[ManufacturerController::class, 'update'])->name('update');
    Route::post('manufacturer/toggle-display', [ManufacturerController::class, 'toggleDisplay'])->name('toggle_display');
    Route::post('manufacturer/destroy', [ManufacturerController::class, 'destroy'])->name('destroy');
});

// カテゴリー管理機能
Route::middleware('auth:owner')->prefix('owner')->name('owner.category.')->group(function () {
    Route::get('category/index', [CategoryController::class, 'index'])->name('index');
    Route::get('category/create', [CategoryController::class, 'create'])->name('create');
    Route::post('category/store', [CategoryController::class, 'store'])->name('store');
    Route::get('category/show/{category}', [CategoryController::class, 'show'])->name('show');
    Route::get('category/edit/{category}', [CategoryController::class, 'edit'])->name('edit');
    Route::post('category/update',[CategoryController::class, 'update'])->name('update');
    Route::post('category/toggle-display', [CategoryController::class, 'toggleDisplay'])->name('toggle_display');
    Route::post('category/destroy', [CategoryController::class, 'destroy'])->name('destroy');
});

// 商品管理機能
Route::middleware('auth:owner')->prefix('owner')->name('owner.product.')->group(function () {
    Route::get('product/index', [ProductController::class, 'index'])->name('index');
    Route::get('product/create', [ProductController::class, 'create'])->name('create');
    Route::post('product/store', [ProductController::class, 'store'])->name('store');
    Route::get('product/show/{id}', [ProductController::class, 'show'])->name('show');
    Route::get('product/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::post('product/update',[ProductController::class, 'update'])->name('update');
    Route::post('product/toggle-selling', [ProductController::class, 'toggleSelling'])->name('toggle_selling');
    Route::post('product/destroy', [ProductController::class, 'destroy'])->name('destroy');
});