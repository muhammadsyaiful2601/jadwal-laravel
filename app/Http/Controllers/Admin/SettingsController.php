<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Katalog provider & model AI (beserta flag GRATIS dan status API key)
     * tidak lagi hardcoded di sini — diambil langsung dari kelas provider:
     * \App\Services\Ai\AiScheduleImportService::providersCatalog()
     * sehingga penambahan provider/model baru cukup di satu tempat.
     */

    public function index(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Get all settings
        $settings = [];
        $settingsData = DB::table('settings')->get();
        foreach ($settingsData as $setting) {
            $settings[$setting->setting_key] = $setting->setting_value;
        }

        // Get maintenance status
        $maintenanceStatus = DB::table('settings')
            ->where('setting_key', 'maintenance_mode')
            ->value('setting_value');
        $isMaintenance = ($maintenanceStatus == '1');

        // Check if superadmin
        $isSuperAdmin = $request->session()->get('role') === 'superadmin';

        // Session timeout settings
        $sessionTimeoutMinutes = $settings['session_timeout_minutes'] ?? 30;
        $sessionAutoLogoutEnabled = $settings['session_auto_logout_enabled'] ?? '1';

        // Model AI & API key untuk fitur Import Jadwal AI (superadmin di halaman ini).
        // Katalog (label, model + flag GRATIS, status API key db/.env) dari kelas provider.
        $aiCatalog = \App\Services\Ai\AiScheduleImportService::providersCatalog();

        // Provider aktif (dari tabel ai_api_configs)
        $aiProvider = \App\Models\AiApiConfig::activeProviderKey();
        if (!isset($aiCatalog[$aiProvider])) {
            $aiProvider = 'gemini';
        }

        // Info limit penggunaan AI
        $aiUsage = (new \App\Services\Ai\AiScheduleImportService())->getUsageInfo();

        return view('admin.manage-settings', compact(
            'settings',
            'isMaintenance',
            'isSuperAdmin',
            'sessionTimeoutMinutes',
            'sessionAutoLogoutEnabled',
            'aiCatalog',
            'aiProvider',
            'aiUsage'
        ));
    }

    public function update(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        // Update all settings from form
        $settingsToUpdate = [
            'tahun_akademik',
            'institusi_nama',
            'institusi_lokasi',
            'program_studi',
            'jurusan',
            'admin_email',
            'running_text_enabled',
            'running_text_content',
            'running_text_speed',
            'running_text_color',
            'running_text_bg_color',
            'max_login_attempts',
            'session_timeout_minutes',
            'session_auto_logout_enabled',
            'header_logo_type',
            'header_title_1',
            'header_title_2',
        ];

        foreach ($settingsToUpdate as $key) {
            $value = $request->input($key, '');

            // Handle checkbox for running_text_enabled
            if ($key === 'running_text_enabled') {
                $value = $request->has('running_text_enabled') ? '1' : '0';
            }

            // Handle checkbox for session_auto_logout_enabled
            if ($key === 'session_auto_logout_enabled') {
                $value = $request->has('session_auto_logout_enabled') ? '1' : '0';
            }

            DB::table('settings')->updateOrInsert(
                ['setting_key' => $key],
                [
                    'setting_value' => $value,
                    'updated_at' => now(),
                ]
            );
        }

        // Invalidate all cache to ensure settings changes are immediately visible
        if (\Illuminate\Support\Facades\Cache::getStore() instanceof \Illuminate\Cache\NullStore) {
            // Do nothing if cache is disabled
        } else {
            \Illuminate\Support\Facades\Cache::flush();
        }

        $this->logActivity($request->session()->get('user_id'), 'Update Settings', 'Memperbarui pengaturan sistem');

        return redirect('/admin/manage-settings')->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function resetData(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        // Check if superadmin
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-settings')->with('error', 'Akses ditolak! Hanya superadmin yang dapat melakukan aksi ini.');
        }

        try {
            DB::beginTransaction();

            // Delete all schedules
            DB::table('schedules')->delete();

            // Delete all activity logs
            DB::table('activity_logs')->delete();

            DB::commit();

            $this->logActivity($request->session()->get('user_id'), 'Reset Data Jadwal', 'Menghapus semua data jadwal dan log');

            return redirect('/admin/manage-settings')->with('success', 'Semua data jadwal berhasil direset!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/admin/manage-settings')->with('error', 'Gagal reset data: ' . $e->getMessage());
        }
    }

    public function clearLogs(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        // Check if superadmin
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-settings')->with('error', 'Akses ditolak! Hanya superadmin yang dapat melakukan aksi ini.');
        }

        try {
            DB::table('activity_logs')->delete();

            $this->logActivity($request->session()->get('user_id'), 'Hapus Log Aktivitas', 'Menghapus semua log aktivitas');

            return redirect('/admin/manage-settings')->with('success', 'Semua log aktivitas berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('/admin/manage-settings')->with('error', 'Gagal menghapus log: ' . $e->getMessage());
        }
    }

    public function backupDatabase(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        // Check if superadmin
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-settings')->with('error', 'Akses ditolak! Hanya superadmin yang dapat melakukan aksi ini.');
        }

        try {
            $dbHost = env('DB_HOST', '127.0.0.1');
            $dbPort = env('DB_PORT', '3306');
            $dbName = env('DB_DATABASE', 'jadwal_kampus');
            $dbUser = env('DB_USERNAME', 'root');
            $dbPass = env('DB_PASSWORD', '');

            $backupDir = storage_path('app/backups');
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            $filename = 'backup_' . $dbName . '_' . date('Y-m-d_His') . '.sql';
            $filePath = $backupDir . '/' . $filename;

            // Build mysqldump command
            $command = sprintf(
                'mysqldump --host=%s --port=%s --user=%s %s %s > "%s" 2>&1',
                escapeshellarg($dbHost),
                escapeshellarg($dbPort),
                escapeshellarg($dbUser),
                !empty($dbPass) ? '--password=' . escapeshellarg($dbPass) : '',
                escapeshellarg($dbName),
                $filePath
            );

            // On Windows, try finding mysqldump in common paths
            if (PHP_OS_FAMILY === 'Windows') {
                // Try default XAMPP/WAMP MySQL paths
                $possiblePaths = [
                    'C:\\xampp\\mysql\\bin\\mysqldump.exe',
                    'C:\\wamp64\\bin\\mysql\\mysql*\\bin\\mysqldump.exe',
                    'C:\\wamp\\bin\\mysql\\mysql*\\bin\\mysqldump.exe',
                    'C:\\laragon\\bin\\mysql\\mysql*\\bin\\mysqldump.exe',
                ];

                $mysqldumpPath = null;
                foreach ($possiblePaths as $path) {
                    if (strpos($path, '*') !== false) {
                        // Use glob to find version folders
                        $globPath = str_replace('mysql*', 'mysql*', $path);
                        $matches = glob($path);
                        if (!empty($matches)) {
                            $mysqldumpPath = $matches[0];
                            break;
                        }
                    } elseif (file_exists($path)) {
                        $mysqldumpPath = $path;
                        break;
                    }
                }

                if ($mysqldumpPath) {
                    $command = sprintf(
                        '"%s" --host=%s --port=%s --user=%s %s %s > "%s" 2>&1',
                        $mysqldumpPath,
                        escapeshellarg($dbHost),
                        escapeshellarg($dbPort),
                        escapeshellarg($dbUser),
                        !empty($dbPass) ? '--password=' . escapeshellarg($dbPass) : '',
                        escapeshellarg($dbName),
                        $filePath
                    );
                }
            }

            $output = null;
            $returnVar = null;
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                // Fallback: try PHP-based backup using PDO
                return $this->phpBackup($dbName, $backupDir, $filename, $request);
            }

            if (!file_exists($filePath) || filesize($filePath) === 0) {
                throw new \Exception('File backup gagal dibuat atau kosong.');
            }

            $this->logActivity($request->session()->get('user_id'), 'Backup Database', 'Backup database berhasil: ' . $filename);

            return redirect('/admin/manage-settings')->with('success', 'Backup database berhasil dibuat!');
        } catch (\Exception $e) {
            // Fallback: PHP-based backup
            return $this->phpBackup($dbName ?? env('DB_DATABASE', 'jadwal_kampus'), $backupDir ?? storage_path('app/backups'), $filename ?? 'backup_fallback_' . date('Y-m-d_His') . '.sql', $request);
        }
    }

    private function phpBackup($dbName, $backupDir, $filename, $request)
    {
        try {
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            $filePath = $backupDir . '/' . $filename;
            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_' . $dbName;

            $sql = "-- PHP Database Backup\n";
            $sql .= "-- Database: " . $dbName . "\n";
            $sql .= "-- Tanggal: " . date('Y-m-d H:i:s') . "\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            foreach ($tables as $table) {
                $tableName = $table->$tableKey;

                // Get create table
                $createTable = DB::select("SHOW CREATE TABLE `$tableName`");
                $sql .= "\n\n-- Table structure for table `$tableName`\n";
                $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
                $createStmt = $createTable[0]->{'Create Table'};
                $sql .= $createStmt . ";\n\n";

                // Get data
                $rows = DB::table($tableName)->get();
                if (count($rows) > 0) {
                    $sql .= "-- Data for table `$tableName`\n";
                    $columns = array_keys((array)$rows[0]);
                    $colNames = '`' . implode('`, `', $columns) . '`';

                    $values = [];
                    foreach ($rows as $row) {
                        $row = (array)$row;
                        $escapedValues = array_map(function ($val) {
                            if ($val === null) return 'NULL';
                            return "'" . str_replace("'", "''", $val) . "'";
                        }, $row);
                        $values[] = '(' . implode(', ', $escapedValues) . ')';
                    }

                    $sql .= "INSERT INTO `$tableName` ($colNames) VALUES\n";
                    $sql .= implode(",\n", $values) . ";\n";
                }
            }

            $sql .= "\nSET FOREIGN_KEY_CHECKS=1;\n";

            file_put_contents($filePath, $sql);

            $this->logActivity($request->session()->get('user_id'), 'Backup Database (PHP)', 'Backup database berhasil: ' . $filename);

            return redirect('/admin/manage-settings')->with('success', 'Backup database berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect('/admin/manage-settings')->with('error', 'Gagal backup database: ' . $e->getMessage());
        }
    }

    public function clearCache(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        // Check if superadmin
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-settings')->with('error', 'Akses ditolak! Hanya superadmin yang dapat melakukan aksi ini.');
        }

        try {
            // Clear application cache
            \Illuminate\Support\Facades\Artisan::call('cache:clear');

            // Clear route cache
            \Illuminate\Support\Facades\Artisan::call('route:clear');

            // Clear view cache
            \Illuminate\Support\Facades\Artisan::call('view:clear');

            // Clear configuration cache
            \Illuminate\Support\Facades\Artisan::call('config:clear');

            $this->logActivity($request->session()->get('user_id'), 'Clear Cache', 'Menghapus semua cache sistem');

            return redirect('/admin/manage-settings')->with('success', 'Semua cache berhasil dibersihkan!');
        } catch (\Exception $e) {
            return redirect('/admin/manage-settings')->with('error', 'Gagal membersihkan cache: ' . $e->getMessage());
        }
    }

    public function backupHistory(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Check if superadmin
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-settings')->with('error', 'Akses ditolak! Hanya superadmin yang dapat melihat riwayat backup.');
        }

        $backupDir = storage_path('app/backups');
        $backups = [];

        if (is_dir($backupDir)) {
            $files = glob($backupDir . '/backup_*.sql');

            foreach ($files as $file) {
                $backups[] = [
                    'filename' => basename($file),
                    'path' => $file,
                    'size' => filesize($file),
                    'size_formatted' => $this->formatBytes(filesize($file)),
                    'created_at' => date('Y-m-d H:i:s', filemtime($file)),
                ];
            }

            // Sort by newest first
            usort($backups, function ($a, $b) {
                return strcmp($b['created_at'], $a['created_at']);
            });
        }

        return view('admin.backup-history', compact('backups'));
    }

    public function downloadBackup(Request $request, $filename)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Check if superadmin
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-settings')->with('error', 'Akses ditolak!');
        }

        $backupDir = storage_path('app/backups');
        $filePath = $backupDir . '/' . $filename;

        // Security check: ensure filename is valid and file exists
        if (!preg_match('/^backup_.+\.sql$/', $filename) || !file_exists($filePath)) {
            return redirect('/admin/backup-history')->with('error', 'File backup tidak ditemukan!');
        }

        $this->logActivity($request->session()->get('user_id'), 'Download Backup', 'Mengunduh backup: ' . $filename);

        return response()->download($filePath);
    }

    public function deleteBackup(Request $request, $filename)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Check if superadmin
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-settings')->with('error', 'Akses ditolak!');
        }

        $backupDir = storage_path('app/backups');
        $filePath = $backupDir . '/' . $filename;

        // Security check
        if (!preg_match('/^backup_.+\.sql$/', $filename) || !file_exists($filePath)) {
            return redirect('/admin/backup-history')->with('error', 'File backup tidak ditemukan!');
        }

        try {
            unlink($filePath);

            $this->logActivity($request->session()->get('user_id'), 'Hapus Backup', 'Menghapus backup: ' . $filename);

            return redirect('/admin/backup-history')->with('success', 'Backup berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('/admin/backup-history')->with('error', 'Gagal menghapus backup: ' . $e->getMessage());
        }
    }

    /**
     * [SUPERADMIN ONLY] Simpan pilihan provider & model AI untuk Import Jadwal AI.
     *
     * Provider & model disimpan di tabel "ai_api_configs" (satu baris per provider,
     * kolom is_active menandai provider aktif) dan dipakai oleh AiScheduleImportService,
     * meng-override default di config/services.php.
     */
    public function updateAiModel(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        // [SUPERADMIN ONLY] Hanya role superadmin yang boleh mengubah provider/model AI
        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-settings')
                ->with('error', 'Akses ditolak! Hanya superadmin yang dapat mengubah provider AI.');
        }

        $request->validate([
            'ai_model' => 'required|string',
            'ai_model_custom' => 'nullable|string|max:100',
        ]);

        // ---- DETEKSI OTOMATIS TIPE API (PROVIDER) DARI NAMA MODEL ----
        // Superadmin cukup memasukkan/memilih nama model; sistem mengenali
        // provider-nya sendiri: gemini-* -> Gemini, gpt-* -> OpenAI, claude-* -> Claude.
        $selected = trim((string) $request->input('ai_model'));
        $custom = trim((string) $request->input('ai_model_custom', ''));
        $model = $custom !== '' ? $custom : $selected;

        if ($model === '' || strtolower($model) === 'custom') {
            return redirect('/admin/manage-settings')
                ->with('error', 'Pilih salah satu model atau isi nama model custom terlebih dahulu.');
        }

        // Buang prefix "models/" bila ada, lalu identifikasi provider dari nama model
        $model = preg_replace('#^models/#i', '', $model) ?? $model;
        $model = trim($model, "/ \t\n\r");

        if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9._:\-]{1,99}$/', $model)) {
            return redirect('/admin/manage-settings')
                ->with('error', 'Nama model hanya boleh huruf, angka, titik, titik dua, dan tanda hubung (contoh: gemini-3.6-flash, gpt-4o).');
        }

        $detected = \App\Services\Ai\AiScheduleImportService::detectProviderForModel($model);

        if ($detected === null) {
            return redirect('/admin/manage-settings')
                ->with('error', "Tipe API model \"{$model}\" tidak dikenali. Gunakan nama model resmi, contoh: gemini-3.6-flash, gpt-4o, atau claude-sonnet-4.");
        }

        $provider = $detected;

        try {
            // Simpan provider aktif + model untuk provider tersebut (tabel ai_api_configs)
            \App\Models\AiApiConfig::setActiveProvider($provider);
            \App\Models\AiApiConfig::updateOrCreate(
                ['provider' => $provider],
                ['model' => $model]
            );

            // Invalidate cache agar perubahan langsung terpakai (pola sama dengan update())
            if (\Illuminate\Support\Facades\Cache::getStore() instanceof \Illuminate\Cache\NullStore) {
                // Cache dinonaktifkan, tidak perlu flush
            } else {
                \Illuminate\Support\Facades\Cache::flush();
            }

            $this->logActivity(
                $request->session()->get('user_id'),
                'Update Provider AI',
                "Provider AI untuk Import Jadwal AI diubah menjadi: {$provider} ({$model})"
            );

            return redirect('/admin/manage-settings')
                ->with('success', "Provider {$provider} dengan model {$model} berhasil disimpan!");
        } catch (\Exception $e) {
            return redirect('/admin/manage-settings')
                ->with('error', 'Gagal menyimpan provider AI: ' . $e->getMessage());
        }
    }

    /**
     * [SUPERADMIN ONLY] Simpan / hapus API key AI langsung dari Pengaturan
     * Sistem (tersimpan TERENKRIPSI di tabel settings, override nilai .env).
     */
    public function updateAiApiKey(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-settings')
                ->with('error', 'Akses ditolak! Hanya superadmin yang dapat mengelola API key AI.');
        }

        $provider = trim((string) $request->input('ai_key_provider', ''));
        $known = [
            'gemini' => \App\Services\Ai\Providers\GeminiProvider::class,
            'openai' => \App\Services\Ai\Providers\OpenAiProvider::class,
            'anthropic' => \App\Services\Ai\Providers\AnthropicProvider::class,
        ];

        if (!isset($known[$provider])) {
            return redirect('/admin/manage-settings')
                ->with('error', 'Provider API key tidak dikenali.');
        }

        $label = $known[$provider]::providerLabel();

        // Tombol "Hapus" -> kembalikan ke .env
        if ($request->input('action') === 'delete') {
            try {
                $known[$provider]::deleteDbApiKey();
                $this->logActivity(
                    $request->session()->get('user_id'),
                    'Hapus API Key AI',
                    "API key {$label} dihapus dari Pengaturan Sistem (kembali memakai .env)"
                );

                return redirect('/admin/manage-settings')
                    ->with('success', "API key {$label} berhasil dihapus. Sistem kembali memakai nilai dari file .env (bila ada).");
            } catch (\Exception $e) {
                return redirect('/admin/manage-settings')
                    ->with('error', 'Gagal menghapus API key: ' . $e->getMessage());
            }
        }

        // Simpan key baru
        $apiKey = trim((string) $request->input('ai_api_key', ''));

        if ($apiKey === '') {
            return redirect('/admin/manage-settings')
                ->with('error', "API key {$label} tidak boleh kosong.");
        }

        if (strlen($apiKey) < 8) {
            return redirect('/admin/manage-settings')
                ->with('error', "API key {$label} terlihat tidak valid (terlalu pendek). Periksa kembali.");
        }

        try {
            $known[$provider]::storeDbApiKey($apiKey);

            $masked = '••••' . substr($apiKey, -4);
            $this->logActivity(
                $request->session()->get('user_id'),
                'Simpan API Key AI',
                "API key {$label} diperbarui dari Pengaturan Sistem ({$masked})"
            );

            return redirect('/admin/manage-settings')
                ->with('success', "API key {$label} berhasil disimpan (terenkripsi) dan langsung dipakai sistem!");
        } catch (\Exception $e) {
            return redirect('/admin/manage-settings')
                ->with('error', 'Gagal menyimpan API key: ' . $e->getMessage());
        }
    }

    /**
     * [SUPERADMIN ONLY] Simpan limit penggunaan AI (jumlah scan per periode).
     */
    public function updateAiUsage(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-settings')
                ->with('error', 'Akses ditolak! Hanya superadmin yang dapat mengubah limit penggunaan AI.');
        }

        $request->validate([
            'ai_usage_limit' => 'required|integer|min:0|max:1000000',
            'ai_usage_period' => 'required|in:daily,monthly,total',
        ]);

        $limit = (int) $request->input('ai_usage_limit');
        $period = trim((string) $request->input('ai_usage_period'));

        try {
            // Limit & counter tersimpan per provider pada tabel ai_api_configs
            // (berlaku untuk provider yang sedang aktif).
            $row = \App\Models\AiApiConfig::active();
            $row->usage_limit = $limit;
            $row->usage_period = $period;
            // Reset counter karena periode/limit berubah
            $row->usage_count = 0;
            $row->usage_period_key = null;
            $row->save();

            if (\Illuminate\Support\Facades\Cache::getStore() instanceof \Illuminate\Cache\NullStore) {
                // Cache dinonaktifkan, tidak perlu flush
            } else {
                \Illuminate\Support\Facades\Cache::flush();
            }

            $this->logActivity(
                $request->session()->get('user_id'),
                'Update Limit AI',
                "Limit penggunaan AI diubah menjadi {$limit} per periode {$period}"
            );

            return redirect('/admin/manage-settings')
                ->with('success', 'Limit penggunaan AI berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect('/admin/manage-settings')
                ->with('error', 'Gagal menyimpan limit AI: ' . $e->getMessage());
        }
    }

    /**
     * [SUPERADMIN ONLY] Reset counter penggunaan AI.
     */
    public function resetAiUsage(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        if ($request->session()->get('role') !== 'superadmin') {
            return redirect('/admin/manage-settings')
                ->with('error', 'Akses ditolak! Hanya superadmin yang dapat mereset penggunaan AI.');
        }

        try {
            $row = \App\Models\AiApiConfig::active();
            $row->usage_count = 0;
            $row->usage_period_key = null;
            $row->save();

            $this->logActivity(
                $request->session()->get('user_id'),
                'Reset Penggunaan AI',
                'Counter penggunaan AI direset oleh superadmin'
            );

            return redirect('/admin/manage-settings')
                ->with('success', 'Penggunaan AI berhasil direset.');
        } catch (\Exception $e) {
            return redirect('/admin/manage-settings')
                ->with('error', 'Gagal mereset penggunaan AI: ' . $e->getMessage());
        }
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    private function logActivity($userId, $action, $description)
    {
        DB::table('activity_logs')->insert([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
