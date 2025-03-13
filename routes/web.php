<?php

use App\Http\Controllers\CustomDiscordAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PanelPasswordController;
use App\Http\Controllers\ResellerClientController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DiscordAuthController;
use App\Http\Controllers\SetDiscordUsernameController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

// Reseller Client Login
Route::post('/client/login', [ResellerClientController::class, 'login'])->name('client.login');

// Protected Routes (Requires Authentication)
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/email', [SettingsController::class, 'updateEmail'])->name('settings.email.update');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
    Route::post('/settings/panel-password', [SettingsController::class, 'updatePanelPassword'])->name('settings.panel-password.update');

    // Panel Password Verification
    Route::get('/panel-password/verify', [PanelPasswordController::class, 'show'])->name('panel.password.verify.show');
    Route::post('/panel-password/verify', [PanelPasswordController::class, 'verify'])->name('panel.password.verify');

    // Downloads
    Route::get('/downloads', [DashboardController::class, 'downloads'])->name('downloads');

    // Reseller Routes
    Route::middleware(['is.reseller'])->prefix('reseller')->name('reseller.')->group(function () {
        Route::get('/dashboard', [ResellerClientController::class, 'dashboard'])->name('dashboard');
        Route::resource('clients', ResellerClientController::class);
    });

    // Premium User Routes with Panel Password Protection
    Route::middleware(['isPremium', 'panel.password'])->group(function () {
        Route::get('/paid-panel', function () {
            return view('paid-panel');
        })->name('paid.panel');
    });

    // Normal User Routes
    Route::middleware(['isNormal'])->group(function () {
        Route::get('/free-panel', function () {
            return view('free-panel');
        })->name('free.panel');
    });

    // Others Role Routes
    Route::middleware(['isOthers'])->prefix('others')->name('others.')->group(function () {
        Route::get('/dashboard', function () {
            return view('others-dashboard');
        })->name('dashboard');
    });

    // Admin Routes with Panel Password Protection
    Route::middleware(['isAdmin', 'panel.password'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // User Management
        Route::resource('users', UserController::class);
        
        // Reseller Management
        Route::get('/resellers', [UserController::class, 'resellerManagement'])->name('resellers.management');
        Route::get('/resellers/analytics', [UserController::class, 'resellerAnalytics'])->name('resellers.analytics');
        Route::get('/resellers/{reseller}', [App\Http\Controllers\Admin\ResellerController::class, 'show'])->name('resellers.show');
        Route::put('/resellers/{reseller}/update-limit', [App\Http\Controllers\Admin\ResellerController::class, 'updateClientLimit'])->name('resellers.update-limit');
        Route::delete('/resellers/{reseller}/clients/{clientId}', [App\Http\Controllers\Admin\ResellerController::class, 'removeClient'])->name('resellers.remove-client');
        
        // Download Management
        Route::get('/downloads', [AdminController::class, 'manageDownloads'])->name('downloads.manage');
        Route::get('/downloads/{download}/edit', [AdminController::class, 'editDownload'])->name('downloads.edit');
        Route::post('/downloads', [AdminController::class, 'storeDownload'])->name('downloads.store');
        Route::put('/downloads/{download}', [AdminController::class, 'updateDownload'])->name('downloads.update');
        Route::delete('/downloads/{download}', [AdminController::class, 'destroyDownload'])->name('downloads.delete');
    });
});

// Discord Authentication Routes
Route::get('/auth/discord', [DiscordAuthController::class, 'redirect'])->name('discord.login');
Route::get('/auth/discord/callback', [DiscordAuthController::class, 'callback'])->name('discord.callback');

// Discord Username Setting Routes
Route::get('/auth/discord/set-username', [SetDiscordUsernameController::class, 'show'])
    ->name('discord.username.show')
    ->middleware('auth');
Route::post('/auth/discord/set-username', [SetDiscordUsernameController::class, 'store'])
    ->name('discord.username.store')
    ->middleware('auth');

// Include Authentication Routes
require __DIR__ . '/auth.php';
