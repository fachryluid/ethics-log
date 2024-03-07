<?php

use App\Constants\UserRole;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViolationController;
use Illuminate\Support\Facades\Route;

Route::name('public.')->group(function () {
    Route::get('/', [PublicController::class, 'index'])->name('index');
    Route::post('/violation/store', [PublicController::class, 'violation_store'])->middleware(['auth', 'verified', 'roles:' . UserRole::USER])->name('violation.store');
});

Route::name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'login_index'])->name('login.index');
    Route::post('/login/authenticate', [AuthController::class, 'login_authenticate'])->name('login.authenticate');
    Route::get('/register', [AuthController::class, 'register_index'])->name('register.index');
    Route::post('/register/submit', [AuthController::class, 'register_submit'])->name('register.submit');
});

Route::name('verification.')->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'show'])->middleware('auth')->name('notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verify');
    Route::post('/email/resend', [VerificationController::class, 'resend'])->middleware(['auth', 'throttle:6,1'])->name('send');
});

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::prefix('master')->name('master.')->middleware(['roles:' . UserRole::ADMIN])->group(function () {
        Route::resource('/users', UserController::class)->names('user');
        Route::put('/users/{user}/update/password', [UserController::class, 'update_password'])->name('user.update.password');
    });
    Route::resource('/violations', ViolationController::class)->middleware(['roles:' . UserRole::USER . ',' . UserRole::ADMIN])->names('violations');
    Route::prefix('admins')->name('admins.')->middleware(['roles:' . UserRole::MANAGER])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/store', [AdminController::class, 'store'])->name('store');
        Route::get('/{user}', [AdminController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{user}/update', [AdminController::class, 'update'])->name('update');
        Route::put('/{user}/update/password', [AdminController::class, 'update_password'])->name('update.password');
        Route::delete('/{user}/destroy', [AdminController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('reports')->name('reports.')->middleware(['roles:' . UserRole::MANAGER])->group(function () {
        Route::get('/users', [ReportController::class, 'users'])->name('users');
        Route::get('/users/pdf/preview', [ReportController::class, 'users_pdf_preview'])->name('users.pdf.preview');
    });
    Route::prefix('profile')->name('profile.')->middleware([])->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::put('/avatar', [ProfileController::class, 'avatar'])->name('avatar');
    });
    Route::prefix('security')->name('security.')->middleware([])->group(function () {
        Route::get('/', [SecurityController::class, 'index'])->name('index');
        Route::put('/update/password', [SecurityController::class, 'update_password'])->name('update.password');
    });
    Route::prefix('setting')->name('setting.')->middleware([])->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/update', [SettingController::class, 'update'])->name('update');
        Route::get('/load-file/auth-bg', [FileController::class, 'loadFileAuthBg']);
        Route::get('/load-file/report-logo', [FileController::class, 'loadFileReportLogo']);
        Route::get('/load-file/app-logo', [FileController::class, 'loadFileAppLogo']);
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
