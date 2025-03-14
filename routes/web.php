<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PanelPasswordController;
use App\Http\Controllers\ResellerClientController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ResellerManagementController;
use App\Http\Controllers\Admin\PanelUploadController;
use App\Http\Controllers\Admin\ResellerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
});

// Admin Routes - Consolidated into a single route group
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle-active', [UserManagementController::class, 'toggleActive'])->name('users.toggle-active');
    Route::get('/users/{user}/activity', [UserManagementController::class, 'activity'])->name('users.activity');
    Route::get('/users/{user}/subscription', [UserManagementController::class, 'subscription'])->name('users.subscription');
    Route::post('/users/{user}/subscription', [UserManagementController::class, 'updateSubscription'])->name('users.subscription.update');
    
    // Reseller Management
    Route::get('/reseller-management', [ResellerManagementController::class, 'index'])->name('resellers.index');
    Route::get('/resellers', [ResellerController::class, 'index'])->name('resellers.table');
    Route::get('/resellers/management', [UserController::class, 'resellerManagement'])->name('resellers.management');
    Route::get('/resellers/analytics', [UserController::class, 'resellerAnalytics'])->name('resellers.analytics');
    Route::get('/resellers/{reseller}', [ResellerController::class, 'show'])->name('resellers.show');
    Route::post('/resellers/{reseller}/client-limit', [ResellerController::class, 'updateClientLimit'])->name('resellers.client-limit');
    Route::post('/resellers/{reseller}/update-limit', [ResellerController::class, 'updateClientLimit'])->name('resellers.update-limit');
    Route::post('/resellers/{reseller}/remove-client/{client}', [ResellerController::class, 'removeClient'])->name('resellers.remove-client');
    Route::get('/resellers/{reseller}/clients', [ResellerManagementController::class, 'clients'])->name('resellers.clients');
    Route::resource('resellers', ResellerManagementController::class)->except(['index', 'show']);
    
    // Panel Upload
    Route::get('/panel-upload', [PanelUploadController::class, 'index'])->name('panel-upload.index');
    Route::post('/panel-upload', [PanelUploadController::class, 'store'])->name('panel-upload.store');
    Route::delete('/panel-upload/{file}', [PanelUploadController::class, 'destroy'])->name('panel-upload.destroy');
    Route::get('/panel/download/{file}', [PanelUploadController::class, 'download'])->name('panel.download');
    Route::post('/panel/upload', [PanelUploadController::class, 'store'])->name('panel.upload');
    
    // Download Management
    Route::get('/downloads', [AdminController::class, 'manageDownloads'])->name('downloads.manage');
    Route::post('/downloads', [AdminController::class, 'storeDownload'])->name('downloads.store');
    Route::get('/downloads/{download}/edit', [AdminController::class, 'editDownload'])->name('downloads.edit');
    Route::put('/downloads/{download}', [AdminController::class, 'updateDownload'])->name('downloads.update');
    Route::delete('/downloads/{download}', [AdminController::class, 'destroyDownload'])->name('downloads.delete');
    
    // Admin Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});

// Include Authentication Routes
require __DIR__ . '/auth.php';
