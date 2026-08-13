<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Setting;
use App\Models\Room;
use App\Models\SemesterSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    public function submitSuggestion(Request $request)
    {
        $response = ['success' => false, 'message' => ''];

        $name = trim($request->input('name', ''));
        $email = trim($request->input('email', ''));
        $message = trim($request->input('message', ''));

        // Validasi
        if (empty($name)) {
            $response['message'] = 'Nama wajib diisi';
        } elseif (strlen($name) < 2) {
            $response['message'] = 'Nama minimal 2 karakter';
        } elseif (empty($message)) {
            $response['message'] = 'Pesan wajib diisi';
        } elseif (strlen($message) < 10) {
            $response['message'] = 'Pesan minimal 10 karakter';
        } else {
            try {
                // Clean inputs
                $name = htmlspecialchars($name);
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                $message = htmlspecialchars($message);

                // Get IP and user agent
                $ip_address = $request->ip() ?? 'UNKNOWN';
                $user_agent = $request->userAgent() ?? 'UNKNOWN';

                DB::table('suggestions')->insert([
                    'name' => $name,
                    'email' => $email,
                    'message' => $message,
                    'ip_address' => $ip_address,
                    'user_agent' => $user_agent,
                    'created_at' => now(),
                ]);

                $response['success'] = true;
                $response['message'] = 'Terima kasih atas kritik dan saran Anda! Pesan telah berhasil dikirim.';
            } catch (\Exception $e) {
                $response['message'] = 'Terjadi kesalahan sistem. Silakan coba lagi nanti.';
            }
        }

        return response()->json($response);
    }

    public function index(Request $request)
    {
        // Get active semester
        $activeSemester = SemesterSetting::getActive();
        $tahunAkademik = $activeSemester?->tahun_akademik ?? '2025/2026';
        $semesterAktif = $activeSemester?->semester ?? 'GANJIL';

        // Get institution settings
        $institusiNama = Setting::getValue('institusi_nama', 'Politeknik Negeri Padang');
        $institusiLokasi = Setting::getValue('institusi_lokasi', 'PSDKU Tanah Datar');
        $programStudi = Setting::getValue('program_studi', 'D3 Sistem Informasi');
        $jurusan = Setting::getValue('jurusan', '');

        // Get header settings
        $headerLogotype = Setting::getValue('header_logo_type', 'kampus');
        $headerTitle1 = Setting::getValue('header_title_1', $institusiNama);
        $headerTitle2 = Setting::getValue('header_title_2', $institusiLokasi);

        // Check maintenance mode
        $maintenanceMode = Setting::getValue('maintenance_mode', '0');
        $maintenanceMessage = Setting::getValue('maintenance_message', '');

        // Get running text settings
        $runningTextEnabled = Setting::getValue('running_text_enabled', '0');
        $runningTextContent = Setting::getValue('running_text_content', '');
        $runningTextSpeed = Setting::getValue('running_text_speed', 'normal');
        $runningTextColor = Setting::getValue('running_text_color', '#ffffff');
        $runningTextBgColor = Setting::getValue('running_text_bg_color', '#4361ee');

        // Get all semesters for dropdown
        $allSemesters = SemesterSetting::orderBy('tahun_akademik', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        // Get unique class list from schedules that have data in active semester
        $kelasList = Schedule::activeSemester($tahunAkademik, $semesterAktif)
            ->select('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas')
            ->toArray();

        // If kelas list is empty, get all classes
        if (empty($kelasList)) {
            $kelasList = Schedule::select('kelas')
                ->distinct()
                ->orderBy('kelas')
                ->pluck('kelas')
                ->toArray();
        }

        // Determine selected day and class from request
        $hariSelected = $request->input('hari', now()->dayOfWeekIso);
        $kelasSelected = $request->input('kelas', $kelasList[0] ?? 'A1');
        $tampilSemuaHari = $request->boolean('semua_hari');
        $tampilSemuaKelas = $request->boolean('semua_kelas');

        // If today is weekend, default to Monday
        $hariSekarang = now()->dayOfWeekIso; // 1=Monday, 7=Sunday
        if ($hariSekarang >= 6) {
            if (!$request->has('hari')) {
                $hariSelected = 1;
            }
        }

        // Ensure selected class is valid
        if (!in_array($kelasSelected, $kelasList) && !empty($kelasList)) {
            $kelasSelected = $kelasList[0];
        }

        // Convert day number to text
        $hariMap = Schedule::DAY_MAP;
        $hariTeks = $request->has('hari') ? ($hariMap[$hariSelected] ?? 'SENIN') : 'SENIN';

        // Build query for schedules
        $query = Schedule::activeSemester($tahunAkademik, $semesterAktif);

        if ($tampilSemuaHari && $tampilSemuaKelas) {
            // All days, all classes
            $query->orderByRaw("FIELD(hari, 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT')", [])
                ->orderBy('kelas')
                ->orderBy('jam_ke');
        } elseif ($tampilSemuaHari) {
            // All days, specific class
            $query->byKelas($kelasSelected)
                ->orderByRaw("FIELD(hari, 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT')", [])
                ->orderBy('jam_ke');
        } elseif ($tampilSemuaKelas) {
            // Specific day, all classes
            $query->byHari($hariTeks)
                ->orderBy('kelas')
                ->orderBy('jam_ke');
        } else {
            // Specific day and class
            $query->byHari($hariTeks)
                ->byKelas($kelasSelected)
                ->orderBy('jam_ke');
        }

        $jadwal = $query->get();

        // Group schedules by day (for "all days" view)
        $jadwalPerHari = [];
        if ($tampilSemuaHari && $jadwal->isNotEmpty()) {
            $jadwalPerHari = $jadwal->groupBy('hari');
        }

        // Find current and next schedule
        $jamSekarang = now()->format('H:i');
        $hariSekarangTeks = $hariMap[$hariSekarang] ?? null;

        $jadwalBerlangsung = null;
        $jadwalBerikutnya = null;
        $waktuTungguDetik = 0;
        $selisihHari = 0;
        $targetHari = '';
        $jadwalMendatang = []; // Array untuk menyimpan jadwal yang akan datang

        if ($hariSekarangTeks) {
            // Find ongoing schedule
            $jadwalBerlangsung = Schedule::activeSemester($tahunAkademik, $semesterAktif)
                ->byHari($hariSekarangTeks)
                ->when(!$tampilSemuaKelas, fn($q) => $q->byKelas($kelasSelected))
                ->whereRaw("? BETWEEN SUBSTRING_INDEX(waktu, ' - ', 1) AND SUBSTRING_INDEX(waktu, ' - ', -1)", [$jamSekarang])
                ->orderBy('jam_ke')
                ->first();

            // Find next schedules - search from today through following days
            $hariOrder = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT'];
            $currentIndex = array_search($hariSekarangTeks, $hariOrder);
            $schedulesFound = 0;
            $maxSchedules = 5; // Get up to 5 upcoming schedules

            for ($i = 0; $i < 10 && $schedulesFound < $maxSchedules; $i++) {
                $nextIndex = ($currentIndex + $i) % 5;
                $nextDay = $hariOrder[$nextIndex];

                $nextQuery = Schedule::activeSemester($tahunAkademik, $semesterAktif)
                    ->byHari($nextDay);

                if (!$tampilSemuaKelas) {
                    $nextQuery->byKelas($kelasSelected);
                }

                if ($i == 0) {
                    // Same day - find schedules that start after current time
                    $nextQuery->whereRaw("SUBSTRING_INDEX(waktu, ' - ', 1) > ?", [$jamSekarang])
                        ->orderByRaw("SUBSTRING_INDEX(waktu, ' - ', 1)", []);
                } else {
                    // Different day - get all schedules
                    $nextQuery->orderByRaw("SUBSTRING_INDEX(waktu, ' - ', 1)", []);
                }

                $jadwalNextDay = $nextQuery->get();

                foreach ($jadwalNextDay as $schedule) {
                    if ($schedulesFound >= $maxSchedules) break;

                    // Calculate waiting time
                    $waktuDetik = 0;
                    if (str_contains($schedule->waktu, ' - ')) {
                        $waktuParts = explode(' - ', $schedule->waktu);
                        if (count($waktuParts) >= 2) {
                            $waktuMulai = $waktuParts[0];
                            $waktuMulaiParts = explode(':', $waktuMulai);
                            $jamMulai = (int) ($waktuMulaiParts[0] ?? 0);
                            $menitMulai = (int) ($waktuMulaiParts[1] ?? 0);

                            $waktuTarget = now()->setTime($jamMulai, $menitMulai, 0)->addDays($i);
                            $waktuSekarang = now();
                            $waktuDetik = max(0, $waktuTarget->diffInSeconds($waktuSekarang));
                        }
                    }

                    $jadwalMendatang[] = [
                        'schedule' => $schedule,
                        'waktu_tunggu_detik' => $waktuDetik,
                        'selisih_hari' => $i,
                        'target_hari' => $nextDay,
                    ];

                    $schedulesFound++;

                    // Set the first one as jadwalBerikutnya
                    if ($schedulesFound == 1) {
                        $jadwalBerikutnya = $schedule;
                        $targetHari = $nextDay;
                        $selisihHari = $i;
                        $waktuTungguDetik = $waktuDetik;
                    }
                }
            }
        }

        // Get room data for popup
        $ruanganMap = Room::pluck('foto_path', 'nama_ruang')->toArray();

        // Get admin data for contact modal
        $adminList = DB::table('users')
            ->where('is_active', true)
            ->orderBy('role', 'desc')
            ->orderBy('username', 'asc')
            ->get(['id', 'username', 'role', 'foto', 'phone', 'email']);

        // Add hariSekarangTeks for view
        $hariSekarangTeks = $hariMap[$hariSekarang] ?? null;

        return view('landing.index', compact(
            'institusiNama',
            'institusiLokasi',
            'programStudi',
            'jurusan',
            'tahunAkademik',
            'semesterAktif',
            'maintenanceMode',
            'maintenanceMessage',
            'runningTextEnabled',
            'runningTextContent',
            'runningTextSpeed',
            'runningTextColor',
            'runningTextBgColor',
            'allSemesters',
            'kelasList',
            'hariSelected',
            'kelasSelected',
            'tampilSemuaHari',
            'tampilSemuaKelas',
            'hariMap',
            'hariTeks',
            'jadwal',
            'jadwalPerHari',
            'jadwalBerlangsung',
            'jadwalBerikutnya',
            'waktuTungguDetik',
            'selisihHari',
            'targetHari',
            'ruanganMap',
            'hariSekarang',
            'hariSekarangTeks',
            'headerLogotype',
            'headerTitle1',
            'headerTitle2',
            'jadwalMendatang',
            'adminList'
        ));
    }
}
