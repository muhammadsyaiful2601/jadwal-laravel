<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
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

        return view('admin.manage-settings', compact(
            'settings',
            'isMaintenance',
            'isSuperAdmin'
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
            'fakultas',
            'admin_email',
            'running_text_enabled',
            'running_text_content',
            'running_text_speed',
            'running_text_color',
            'running_text_bg_color',
            'max_login_attempts',
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

            return response()->download($filePath)->deleteFileAfterSend(true);
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

            return response()->download($filePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return redirect('/admin/manage-settings')->with('error', 'Gagal backup database: ' . $e->getMessage());
        }
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
