<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Setting;
use App\Models\Room;
use App\Models\SemesterSetting;
use App\Models\Visitor;
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
        // Catat kunjungan pengunjung (unique per IP per jam)
        Visitor::recordVisit($request->ip(), $request->userAgent());

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

        // Find current and next schedule (real-time, handles weekend & midnight-crossing)
        $hariSekarangTeks = $hariMap[$hariSekarang] ?? null; // null saat Sabtu/Minggu

        $jadwalBerlangsung = null;
        $jadwalBerikutnya = null;
        $waktuTungguDetik = 0;
        $selisihHari = 0;
        $targetHari = '';
        $jadwalMendatang = []; // Array untuk menyimpan jadwal yang akan datang

        $hariOrder = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT'];
        $today = now();
        $todayIso = (int) $today->dayOfWeekIso; // 1=Senin .. 5=Jumat, 6=Sabtu, 7=Minggu

        // Hari efektif untuk pencarian. Saat weekend (Sabtu/Minggu) tidak ada kuliah
        // berlangsung, dan jadwal berikutnya dihitung mulai dari Senin.
        $currentScheduleDay = $hariSekarangTeks ?: 'SENIN';
        $currentIndex = array_search($currentScheduleDay, $hariOrder);
        if ($currentIndex === false) {
            $currentIndex = 0;
        }

        // Helper: selisih hari kalender dari hari ini sampai target weekday (1=Senin..5=Jumat)
        $daysUntil = function (int $target) use ($todayIso): int {
            if ($todayIso <= 5) {
                return $target >= $todayIso
                    ? $target - $todayIso
                    : (7 - $todayIso) + $target; // pekan depan
            }
            // Weekend (6=Sabtu, 7=Minggu): mundur ke hari Senin dst.
            return (7 - $todayIso) + $target;
        };

        // --- 1. Cari jadwal yang sedang berlangsung (hanya hari kerja) ---
        if ($hariSekarangTeks) {
            $schedulesToday = Schedule::activeSemester($tahunAkademik, $semesterAktif)
                ->byHari($hariSekarangTeks)
                ->when(!$tampilSemuaKelas, fn($q) => $q->byKelas($kelasSelected))
                ->orderBy('jam_ke')
                ->get();

            foreach ($schedulesToday as $sch) {
                [$mulai, $selesai] = array_pad(explode(' - ', (string) $sch->waktu), 2, '');
                if ($mulai === '' || $selesai === '') continue;

                $startTime = \Illuminate\Support\Carbon::createFromTimeString($mulai);
                $endTime = \Illuminate\Support\Carbon::createFromTimeString($selesai);

                if ($startTime->gt($endTime)) {
                    // Jadwal melewati tengah malam (mis. 23:11 - 00:31)
                    $isOngoing = $today->gte($startTime) || $today->lte($endTime);
                } else {
                    $isOngoing = $today->between($startTime, $endTime);
                }

                if ($isOngoing) {
                    $jadwalBerlangsung = $sch;
                    break;
                }
            }
        }

        // --- 2. Cari jadwal berikutnya (real-time, dengan hitungan countdown yang benar) ---
        $schedulesFound = 0;
        $maxSchedules = 5; // Ambil hingga 5 jadwal mendatang

        for ($i = 0; $i < 10 && $schedulesFound < $maxSchedules; $i++) {
            $nextIndex = ($currentIndex + $i) % 5;
            $nextDay = $hariOrder[$nextIndex];
            $targetWeekday = $nextIndex + 1; // 1=Senin .. 5=Jumat

            $nextQuery = Schedule::activeSemester($tahunAkademik, $semesterAktif)
                ->byHari($nextDay);

            if (!$tampilSemuaKelas) {
                $nextQuery->byKelas($kelasSelected);
            }

            $scheduleList = $nextQuery->orderBy('jam_ke')->get();

            foreach ($scheduleList as $schedule) {
                if ($schedulesFound >= $maxSchedules) break;

                $waktuDetik = 0;
                $selisihHariSchedule = $i;
                [$mulai] = array_pad(explode(' - ', (string) $schedule->waktu), 2, '');
                if ($mulai !== '') {
                    [$jamMulai, $menitMulai] = array_pad(array_map('intval', explode(':', $mulai)), 2, 0);

                    // Hitung selisih hari kalender dari hari ini ke hari jadwal
                    $offsetDays = $daysUntil($targetWeekday);
                    $targetWaktu = $today->copy()->addDays($offsetDays)->setTime($jamMulai, $menitMulai, 0);
                    $selisihHariSchedule = $offsetDays;
                    // diff = targetWaktu - today (positif jika jadwal masih akan datang)
                    // Cast ke int (diffInSeconds Carbon mengembalikan float / mikrodetik).
                    $waktuDetik = max(0, (int) $today->diffInSeconds($targetWaktu, false));
                }

                // Lewati jadwal yang waktunya sudah lewat (tidak akan datang lagi)
                if ($waktuDetik <= 0) continue;

                $jadwalMendatang[] = [
                    'schedule' => $schedule,
                    'waktu_tunggu_detik' => (int) $waktuDetik,
                    'selisih_hari' => $selisihHariSchedule,
                    'target_hari' => $nextDay,
                ];

                $schedulesFound++;
            }
        }

        // Jadwal berikutnya = jadwal dengan waktu tunggu paling cepat (bukan urutan tersimpan)
        if (!empty($jadwalMendatang)) {
            usort($jadwalMendatang, fn($a, $b) => $a['waktu_tunggu_detik'] <=> $b['waktu_tunggu_detik']);
            $jadwalBerikutnya = $jadwalMendatang[0]['schedule'];
            $targetHari = $jadwalMendatang[0]['target_hari'];
            $selisihHari = $jadwalMendatang[0]['selisih_hari'];
            $waktuTungguDetik = $jadwalMendatang[0]['waktu_tunggu_detik'];
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
