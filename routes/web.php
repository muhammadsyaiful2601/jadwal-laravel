<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\ParallelScheduleController;
use App\Http\Controllers\Admin\ProfileController;
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

// Import Jadwal AI (Gemini)
Route::post('/admin/manage-schedule/import-ai', [ScheduleController::class, 'importAi'])->name('schedule.import-ai');
Route::post('/admin/manage-schedule/import-ai/validate', [ScheduleController::class, 'importAiValidate'])->name('schedule.import-ai.validate');
Route::post('/admin/manage-schedule/import-ai/store', [ScheduleController::class, 'importAiStore'])->name('schedule.import-ai.store');

// Parallel schedule routes
Route::get('/admin/manage-parallel', [ParallelScheduleController::class, 'index']);
Route::post('/admin/manage-parallel/store', [ParallelScheduleController::class, 'store']);
Route::get('/admin/manage-parallel/delete/{id}', [ParallelScheduleController::class, 'destroy']);
Route::post('/admin/manage-parallel/delete-all', [ParallelScheduleController::class, 'destroyAll']);
Route::post('/admin/manage-parallel/remove-class', [ParallelScheduleController::class, 'removeClass']);

// Room routes
Route::get('/admin/manage-rooms', [RoomController::class, 'index']);
Route::post('/admin/manage-rooms/store', [RoomController::class, 'store']);
Route::post('/admin/manage-rooms/update/{id?}', [RoomController::class, 'update']);
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
// [SUPERADMIN ONLY] Pilihan provider & model AI untuk fitur Import Jadwal AI
Route::post('/admin/manage-settings/ai-model', [SettingsController::class, 'updateAiModel'])->name('settings.ai-model');
// [SUPERADMIN ONLY] Simpan/hapus API key AI langsung dari Pengaturan Sistem (tanpa edit .env)
Route::post('/admin/manage-settings/ai-api-key', [SettingsController::class, 'updateAiApiKey'])->name('settings.ai-api-key');
// [SUPERADMIN ONLY] Limit penggunaan AI + reset counter
Route::post('/admin/manage-settings/ai-usage', [SettingsController::class, 'updateAiUsage'])->name('settings.ai-usage');
Route::post('/admin/manage-settings/ai-usage-reset', [SettingsController::class, 'resetAiUsage'])->name('settings.ai-usage-reset');
Route::get('/admin/manage-settings/reset-data', [SettingsController::class, 'resetData']);
Route::get('/admin/manage-settings/clear-logs', [SettingsController::class, 'clearLogs']);
Route::get('/admin/manage-settings/clear-cache', [SettingsController::class, 'clearCache']);
Route::get('/admin/manage-settings/backup-database', [SettingsController::class, 'backupDatabase']);
Route::get('/admin/backup-history', [SettingsController::class, 'backupHistory']);
Route::get('/admin/backup-history/download/{filename}', [SettingsController::class, 'downloadBackup']);
Route::get('/admin/backup-history/delete/{filename}', [SettingsController::class, 'deleteBackup']);

// User management routes
Route::get('/admin/manage-users', [UserController::class, 'index']);
Route::post('/admin/manage-users/store', [UserController::class, 'store']);
Route::post('/admin/manage-users/update', [UserController::class, 'update']);
Route::get('/admin/manage-users/delete', [UserController::class, 'destroy']);
Route::get('/admin/manage-users/reset-lockout', [UserController::class, 'resetLockout']);
Route::get('/admin/manage-users/cancel-lockout', [UserController::class, 'cancelLockout']);
Route::get('/admin/manage-users/send-verification', [UserController::class, 'sendVerification']);

// Profile routes
Route::get('/admin/profile', [ProfileController::class, 'index']);
Route::post('/admin/profile/update', [ProfileController::class, 'update']);

// Change Password routes (superadmin only)
Route::get('/admin/change-password', [ProfileController::class, 'changePassword']);
Route::post('/admin/change-password', [ProfileController::class, 'updatePassword']);

// Forgot Password routes
Route::get('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgotForm']);
Route::post('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLink']);
Route::get('/reset-password/otp', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetOtpForm']);
Route::post('/reset-password/otp', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetPasswordWithOtp']);
Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm']);
Route::post('/reset-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetPassword']);

// Email Verification routes
Route::post('/admin/profile/send-verification', [\App\Http\Controllers\Auth\VerificationController::class, 'sendVerificationEmail']);
Route::post('/admin/profile/verify-otp', [\App\Http\Controllers\Auth\VerificationController::class, 'verifyEmailWithOtp']);
Route::post('/admin/profile/update-email', [\App\Http\Controllers\Auth\VerificationController::class, 'updateEmail']);
Route::get('/verify-email/{token}', [\App\Http\Controllers\Auth\VerificationController::class, 'verifyEmail']);

// Suggestion (Kritik & Saran) routes
Route::get('/admin/saran', [SuggestionController::class, 'index']);
Route::post('/admin/saran/update-status', [SuggestionController::class, 'updateStatus']);
Route::post('/admin/saran/mark-read', [SuggestionController::class, 'markAsRead']);
