<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\PrintReportController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SuggestionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterSuperadminController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index']);
Route::post('/submit-suggestion', [LandingPageController::class, 'submitSuggestion']);

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register Superadmin routes
Route::get('/register-superadmin', [RegisterSuperadminController::class, 'showRegisterForm'])->name('register.superadmin');
Route::post('/register-superadmin', [RegisterSuperadminController::class, 'register']);

// Admin Dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index']);

// Maintenance routes
Route::get('/admin/maintenance', [MaintenanceController::class, 'index']);
Route::post('/admin/maintenance/toggle', [MaintenanceController::class, 'toggle']);
Route::post('/admin/maintenance/update-message', [MaintenanceController::class, 'updateMessage']);

// Schedule routes
Route::get('/admin/manage-schedule', [ScheduleController::class, 'index']);
Route::post('/admin/manage-schedule/store', [ScheduleController::class, 'store']);
Route::post('/admin/manage-schedule/update/{id}', [ScheduleController::class, 'update'])->name('schedule.update');
Route::get('/admin/manage-schedule/delete/{id}', [ScheduleController::class, 'destroy']);
Route::post('/admin/manage-schedule/delete-all', [ScheduleController::class, 'destroyAll']);
Route::post('/admin/manage-schedule/store-bulk', [ScheduleController::class, 'storeBulk']);

// Room routes
Route::get('/admin/manage-rooms', [RoomController::class, 'index']);
Route::post('/admin/manage-rooms/store', [RoomController::class, 'store']);
Route::post('/admin/manage-rooms/update/{id}', [RoomController::class, 'update']);
Route::get('/admin/manage-rooms/delete/{id}', [RoomController::class, 'destroy']);
Route::get('/admin/manage-rooms/delete-photo/{id}', [RoomController::class, 'deletePhoto']);

// Semester routes
Route::get('/admin/manage-semester', [SemesterController::class, 'index']);
Route::post('/admin/manage-semester/store', [SemesterController::class, 'store']);
Route::post('/admin/manage-semester/set-active/{id}', [SemesterController::class, 'setActive']);
Route::get('/admin/manage-semester/delete/{id}', [SemesterController::class, 'destroy']);

// Settings routes
Route::get('/admin/manage-settings', [SettingsController::class, 'index']);
Route::post('/admin/manage-settings/update', [SettingsController::class, 'update']);
Route::get('/admin/manage-settings/reset-data', [SettingsController::class, 'resetData']);
Route::get('/admin/manage-settings/clear-logs', [SettingsController::class, 'clearLogs']);
Route::get('/admin/manage-settings/backup-database', [SettingsController::class, 'backupDatabase']);

// User management routes
Route::get('/admin/manage-users', [UserController::class, 'index']);
Route::post('/admin/manage-users/store', [UserController::class, 'store']);
Route::post('/admin/manage-users/update', [UserController::class, 'update']);
Route::get('/admin/manage-users/delete', [UserController::class, 'destroy']);
Route::get('/admin/manage-users/reset-lockout', [UserController::class, 'resetLockout']);
Route::get('/admin/manage-users/cancel-lockout', [UserController::class, 'cancelLockout']);

// Reports routes
Route::get('/admin/reports', [ReportsController::class, 'index']);

// Profile routes
Route::get('/admin/profile', [ProfileController::class, 'index']);
Route::post('/admin/profile/update', [ProfileController::class, 'update']);

// Print Report routes
Route::get('/admin/print-report', [PrintReportController::class, 'index']);

// Export routes
Route::get('/admin/export', [ExportController::class, 'export']);

// Suggestion (Kritik & Saran) routes
Route::get('/admin/saran', [SuggestionController::class, 'index']);
Route::post('/admin/saran/update-status', [SuggestionController::class, 'updateStatus']);
