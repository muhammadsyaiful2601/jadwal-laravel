<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Ai\AbstractAiProvider;
use App\Services\Ai\AiScheduleImportService;
use App\Services\Ai\AiUsageLimitExceededException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\Setting;
use App\Models\SemesterSetting;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        // Check if user is authenticated
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Get active semester
        $activeSemester = SemesterSetting::getActiveSemester();
        $tahunAkademikAktif = $activeSemester['tahun_akademik'] ?? date('Y');
        $semesterAktif = $activeSemester['semester'] ?? 'GANJIL';

        // Get all tahun akademik
        $tahunList = SemesterSetting::getAllTahunAkademik();
        if (!in_array($tahunAkademikAktif, $tahunList)) {
            array_unshift($tahunList, $tahunAkademikAktif);
        }

        // Get filters from request
        $filterTahun = $request->query('filter_tahun', $tahunAkademikAktif);
        $filterSemester = $request->query('filter_semester', $semesterAktif);

        // Get schedules with filters
        $query = DB::table('schedules');
        if ($filterTahun != 'all') {
            $query->where('tahun_akademik', $filterTahun);
        }
        if ($filterSemester != 'all') {
            $query->where('semester', $filterSemester);
        }
        $schedules = $query->orderBy('tahun_akademik', 'desc')
            ->orderBy('semester')
            ->orderBy('kelas')
            ->orderBy('hari')
            ->orderBy('jam_ke')
            ->get();

        // Get all rooms
        $rooms = DB::table('rooms')->orderBy('nama_ruang')->pluck('nama_ruang')->toArray();

        // Get all distinct classes
        $kelasList = DB::table('schedules')->distinct()->pluck('kelas')->toArray();

        // Map schedule_id => parallel classes (for the "Paralel" button/badge)
        $parallelMap = DB::table('parallel_schedules')
            ->pluck('kelas', 'schedule_id')
            ->map(function ($kelas) {
                return array_filter(array_map('trim', explode(',', (string) $kelas)));
            })
            ->toArray();

        // Prepare time slots for JavaScript
        $timeSlots = [];
        for ($i = 1; $i <= 10; $i++) {
            $slot = $this->getTimeSlotByJamKe($i);
            $timeSlots[$i] = $slot ? implode(' - ', $slot) : 'Tidak tersedia';
        }

        // Info penggunaan AI (untuk banner kuota di modal Import Jadwal AI)
        $aiUsage = (new AiScheduleImportService())->getUsageInfo();

        return view('admin.manage-schedule', compact(
            'schedules',
            'rooms',
            'kelasList',
            'parallelMap',
            'tahunList',
            'timeSlots',
            'filterTahun',
            'filterSemester',
            'tahunAkademikAktif',
            'semesterAktif',
            'aiUsage'
        ));
    }

    public function store(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        if ($request->ajax()) {
            try {
                $request->validate([
                    'kelas' => 'required|string',
                    'hari' => 'required|string',
                    'jam_ke' => 'required|integer|min:1|max:10',
                    'waktu_mulai' => 'required',
                    'waktu_selesai' => 'required',
                    'mata_kuliah' => 'required|string',
                    'dosen' => 'required|string',
                    'ruang' => 'required|string',
                    'semester' => 'required|string',
                    'tahun_akademik' => 'required|string',
                ]);

                $waktu = $request->input('waktu_mulai') . " - " . $request->input('waktu_selesai');

                // Validasi urutan waktu: jam selesai harus lebih besar dari jam mulai
                if (strtotime($request->input('waktu_selesai')) <= strtotime($request->input('waktu_mulai'))) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Waktu selesai (' . $request->input('waktu_selesai') . ') harus lebih besar dari waktu mulai (' . $request->input('waktu_mulai') . ').'
                    ]);
                }

                // Check conflicts
                $conflicts = $this->checkScheduleConflict(
                    $request->input('kelas'),
                    $request->input('hari'),
                    $request->input('waktu_mulai'),
                    $request->input('waktu_selesai'),
                    $request->input('semester'),
                    $request->input('tahun_akademik'),
                    $request->input('dosen'),
                    $request->input('ruang')
                );

                if (!empty($conflicts)) {
                    return response()->json([
                        'success' => false,
                        'message' => implode("<br>", $conflicts)
                    ]);
                }

                $scheduleId = DB::table('schedules')->insertGetId([
                    'kelas' => $request->input('kelas'),
                    'hari' => $request->input('hari'),
                    'jam_ke' => $request->input('jam_ke'),
                    'waktu' => $waktu,
                    'mata_kuliah' => $request->input('mata_kuliah'),
                    'dosen' => $request->input('dosen'),
                    'ruang' => $request->input('ruang'),
                    'semester' => $request->input('semester'),
                    'tahun_akademik' => $request->input('tahun_akademik'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Log activity
                $this->logActivity(
                    $request->session()->get('user_id'),
                    'Tambah Jadwal',
                    "Kelas: {$request->input('kelas')}, Matkul: {$request->input('mata_kuliah')}, Hari: {$request->input('hari')}"
                );

                // Get the created schedule
                $schedule = DB::table('schedules')->where('id', $scheduleId)->first();

                return response()->json([
                    'success' => true,
                    'message' => 'Jadwal berhasil ditambahkan!',
                    'data' => $schedule
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        // Non-AJAX fallback
        return $this->storeLegacy($request);
    }

    // Legacy method for non-AJAX fallback
    private function storeLegacy(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string',
            'hari' => 'required|string',
            'jam_ke' => 'required|integer|min:1|max:10',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'mata_kuliah' => 'required|string',
            'dosen' => 'required|string',
            'ruang' => 'required|string',
            'semester' => 'required|string',
            'tahun_akademik' => 'required|string',
        ]);

        $waktu = $request->input('waktu_mulai') . " - " . $request->input('waktu_selesai');

        // Validasi urutan waktu: jam selesai harus lebih besar dari jam mulai
        if (strtotime($request->input('waktu_selesai')) <= strtotime($request->input('waktu_mulai'))) {
            return back()->with('error', 'Waktu selesai harus lebih besar dari waktu mulai.')->withInput();
        }

        $conflicts = $this->checkScheduleConflict(
            $request->input('kelas'),
            $request->input('hari'),
            $request->input('waktu_mulai'),
            $request->input('waktu_selesai'),
            $request->input('semester'),
            $request->input('tahun_akademik'),
            $request->input('dosen'),
            $request->input('ruang')
        );

        if (!empty($conflicts)) {
            return back()->with('error', implode("<br>", $conflicts))->withInput();
        }

        DB::table('schedules')->insert([
            'kelas' => $request->input('kelas'),
            'hari' => $request->input('hari'),
            'jam_ke' => $request->input('jam_ke'),
            'waktu' => $waktu,
            'mata_kuliah' => $request->input('mata_kuliah'),
            'dosen' => $request->input('dosen'),
            'ruang' => $request->input('ruang'),
            'semester' => $request->input('semester'),
            'tahun_akademik' => $request->input('tahun_akademik'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->logActivity(
            $request->session()->get('user_id'),
            'Tambah Jadwal',
            "Kelas: {$request->input('kelas')}, Matkul: {$request->input('mata_kuliah')}, Hari: {$request->input('hari')}"
        );

        return redirect('/admin/manage-schedule')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        if ($request->ajax()) {
            try {
                $request->validate([
                    'kelas' => 'required|string',
                    'hari' => 'required|string',
                    'jam_ke' => 'required|integer|min:1|max:10',
                    'waktu_mulai' => 'required',
                    'waktu_selesai' => 'required',
                    'mata_kuliah' => 'required|string',
                    'dosen' => 'required|string',
                    'ruang' => 'required|string',
                    'semester' => 'required|string',
                    'tahun_akademik' => 'required|string',
                ]);

                $waktu = $request->input('waktu_mulai') . " - " . $request->input('waktu_selesai');

                // Validasi urutan waktu: jam selesai harus lebih besar dari jam mulai
                if (strtotime($request->input('waktu_selesai')) <= strtotime($request->input('waktu_mulai'))) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Waktu selesai (' . $request->input('waktu_selesai') . ') harus lebih besar dari waktu mulai (' . $request->input('waktu_mulai') . ').'
                    ]);
                }

                // Check conflicts (excluding current schedule)
                $conflicts = $this->checkScheduleConflict(
                    $request->input('kelas'),
                    $request->input('hari'),
                    $request->input('waktu_mulai'),
                    $request->input('waktu_selesai'),
                    $request->input('semester'),
                    $request->input('tahun_akademik'),
                    $request->input('dosen'),
                    $request->input('ruang'),
                    $id
                );

                if (!empty($conflicts)) {
                    return response()->json([
                        'success' => false,
                        'message' => implode("<br>", $conflicts)
                    ]);
                }

                DB::table('schedules')->where('id', $id)->update([
                    'kelas' => $request->input('kelas'),
                    'hari' => $request->input('hari'),
                    'jam_ke' => $request->input('jam_ke'),
                    'waktu' => $waktu,
                    'mata_kuliah' => $request->input('mata_kuliah'),
                    'dosen' => $request->input('dosen'),
                    'ruang' => $request->input('ruang'),
                    'semester' => $request->input('semester'),
                    'tahun_akademik' => $request->input('tahun_akademik'),
                    'updated_at' => now(),
                ]);

                $this->logActivity($request->session()->get('user_id'), 'Edit Jadwal', "ID: $id");

                return response()->json([
                    'success' => true,
                    'message' => 'Jadwal berhasil diperbarui!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        // Non-AJAX fallback
        return $this->updateLegacy($request, $id);
    }

    // Legacy method for non-AJAX fallback
    private function updateLegacy(Request $request, $id)
    {
        $request->validate([
            'kelas' => 'required|string',
            'hari' => 'required|string',
            'jam_ke' => 'required|integer|min:1|max:10',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'mata_kuliah' => 'required|string',
            'dosen' => 'required|string',
            'ruang' => 'required|string',
            'semester' => 'required|string',
            'tahun_akademik' => 'required|string',
        ]);

        $waktu = $request->input('waktu_mulai') . " - " . $request->input('waktu_selesai');

        // Validasi urutan waktu: jam selesai harus lebih besar dari jam mulai
        if (strtotime($request->input('waktu_selesai')) <= strtotime($request->input('waktu_mulai'))) {
            return back()->with('error', 'Waktu selesai harus lebih besar dari waktu mulai.')->withInput();
        }

        $conflicts = $this->checkScheduleConflict(
            $request->input('kelas'),
            $request->input('hari'),
            $request->input('waktu_mulai'),
            $request->input('waktu_selesai'),
            $request->input('semester'),
            $request->input('tahun_akademik'),
            $request->input('dosen'),
            $request->input('ruang'),
            $id
        );

        if (!empty($conflicts)) {
            return back()->with('error', implode("<br>", $conflicts))->withInput();
        }

        DB::table('schedules')->where('id', $id)->update([
            'kelas' => $request->input('kelas'),
            'hari' => $request->input('hari'),
            'jam_ke' => $request->input('jam_ke'),
            'waktu' => $waktu,
            'mata_kuliah' => $request->input('mata_kuliah'),
            'dosen' => $request->input('dosen'),
            'ruang' => $request->input('ruang'),
            'semester' => $request->input('semester'),
            'tahun_akademik' => $request->input('tahun_akademik'),
            'updated_at' => now(),
        ]);

        $this->logActivity($request->session()->get('user_id'), 'Edit Jadwal', "ID: $id");

        return redirect('/admin/manage-schedule')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        if ($request->ajax()) {
            try {
                DB::table('schedules')->where('id', $id)->delete();

                $this->logActivity($request->session()->get('user_id'), 'Hapus Jadwal', "ID: $id");

                return response()->json([
                    'success' => true,
                    'message' => 'Jadwal berhasil dihapus!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        // Non-AJAX fallback
        DB::table('schedules')->where('id', $id)->delete();

        $this->logActivity($request->session()->get('user_id'), 'Hapus Jadwal', "ID: $id");

        return redirect('/admin/manage-schedule')->with('success', 'Jadwal berhasil dihapus!');
    }

    public function destroyAll(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        if ($request->ajax()) {
            try {
                $totalData = DB::table('schedules')->count();

                DB::table('schedules')->delete();

                $this->logActivity($request->session()->get('user_id'), 'Hapus Semua Jadwal', "Semua jadwal dihapus, total: $totalData data");

                return response()->json([
                    'success' => true,
                    'message' => "Semua jadwal ($totalData data) berhasil dihapus!"
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        // Non-AJAX fallback
        $totalData = DB::table('schedules')->count();

        DB::table('schedules')->delete();

        $this->logActivity($request->session()->get('user_id'), 'Hapus Semua Jadwal', "Semua jadwal dihapus, total: $totalData data");

        return redirect('/admin/manage-schedule')->with('success', "Semua jadwal ($totalData data) berhasil dihapus!");
    }

    public function storeBulk(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        if ($request->ajax()) {
            try {
                $schedules = $request->input('schedules', []);

                if (empty($schedules) || !is_array($schedules)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada data jadwal yang dikirim.'
                    ]);
                }

                $entries = [];
                $conflictMessages = [];
                $successCount = 0;

                foreach ($schedules as $index => $schedule) {
                    // Validate each schedule
                    if (
                        empty($schedule['kelas']) || empty($schedule['hari']) ||
                        empty($schedule['jam_ke']) || empty($schedule['waktu_mulai']) ||
                        empty($schedule['waktu_selesai']) || empty($schedule['mata_kuliah']) ||
                        empty($schedule['dosen']) || empty($schedule['ruang'])
                    ) {
                        $conflictMessages[] = "Data jadwal ke-" . ($index + 1) . ": Semua field harus diisi";
                        continue;
                    }

                    $kelas = trim($schedule['kelas']);
                    $hari = trim($schedule['hari']);
                    $jamKe = intval($schedule['jam_ke']);
                    $waktuMulai = trim($schedule['waktu_mulai']);
                    $waktuSelesai = trim($schedule['waktu_selesai']);
                    $mataKuliah = trim($schedule['mata_kuliah']);
                    $dosen = trim($schedule['dosen']);
                    $ruang = trim($schedule['ruang']);
                    $semester = trim($schedule['semester']);
                    $tahunAkademik = trim($schedule['tahun_akademik']);
                    $waktu = "$waktuMulai - $waktuSelesai";

                    // Validate jam_ke range
                    if ($jamKe < 1 || $jamKe > 10) {
                        $conflictMessages[] = "Data jadwal ke-" . ($index + 1) . ": Jam ke-$jamKe tidak valid (harus 1-10)";
                        continue;
                    }

                    // Validasi urutan waktu: jam selesai harus lebih besar dari jam mulai
                    if (strtotime($waktuSelesai) <= strtotime($waktuMulai)) {
                        $conflictMessages[] = "Data jadwal ke-" . ($index + 1) . " ($mataKuliah): Waktu selesai ($waktuSelesai) harus lebih besar dari waktu mulai ($waktuMulai)";
                        continue;
                    }

                    // Check conflicts
                    $conflicts = $this->checkScheduleConflict(
                        $kelas,
                        $hari,
                        $waktuMulai,
                        $waktuSelesai,
                        $semester,
                        $tahunAkademik,
                        $dosen,
                        $ruang
                    );

                    if (!empty($conflicts)) {
                        $conflictMessages[] = "Data jadwal ke-" . ($index + 1) . " ($mataKuliah): " . implode(', ', $conflicts);
                        continue;
                    }

                    $entries[] = [
                        'kelas' => $kelas,
                        'hari' => $hari,
                        'jam_ke' => $jamKe,
                        'waktu' => $waktu,
                        'mata_kuliah' => $mataKuliah,
                        'dosen' => $dosen,
                        'ruang' => $ruang,
                        'semester' => $semester,
                        'tahun_akademik' => $tahunAkademik,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($conflictMessages)) {
                    return response()->json([
                        'success' => false,
                        'message' => "Terdapat kesalahan pada beberapa data:<br>" . implode("<br>", $conflictMessages),
                        'conflicts' => $conflictMessages
                    ]);
                }

                if (empty($entries)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada data valid untuk disimpan.'
                    ]);
                }

                DB::transaction(function () use ($entries) {
                    foreach ($entries as $entry) {
                        DB::table('schedules')->insert($entry);
                    }
                });

                $this->logActivity(
                    $request->session()->get('user_id'),
                    'Tambah Massal Jadwal',
                    "Berhasil menambahkan " . count($entries) . " jadwal sekaligus"
                );

                return response()->json([
                    'success' => true,
                    'message' => "Berhasil menambahkan " . count($entries) . " jadwal sekaligus!",
                    'count' => count($entries)
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        // Non-AJAX fallback
        $schedules = $request->input('schedules', []);

        if (empty($schedules) || !is_array($schedules)) {
            return back()->with('error', 'Tidak ada data jadwal yang dikirim.');
        }

        $entries = [];
        $conflictMessages = [];

        foreach ($schedules as $index => $schedule) {
            if (
                empty($schedule['kelas']) || empty($schedule['hari']) ||
                empty($schedule['jam_ke']) || empty($schedule['waktu_mulai']) ||
                empty($schedule['waktu_selesai']) || empty($schedule['mata_kuliah']) ||
                empty($schedule['dosen']) || empty($schedule['ruang'])
            ) {
                $conflictMessages[] = "Data jadwal ke-" . ($index + 1) . ": Semua field harus diisi";
                continue;
            }

            $kelas = trim($schedule['kelas']);
            $hari = trim($schedule['hari']);
            $jamKe = intval($schedule['jam_ke']);
            $waktuMulai = trim($schedule['waktu_mulai']);
            $waktuSelesai = trim($schedule['waktu_selesai']);
            $mataKuliah = trim($schedule['mata_kuliah']);
            $dosen = trim($schedule['dosen']);
            $ruang = trim($schedule['ruang']);
            $semester = trim($schedule['semester']);
            $tahunAkademik = trim($schedule['tahun_akademik']);
            $waktu = "$waktuMulai - $waktuSelesai";

            // Validate jam_ke range
            if ($jamKe < 1 || $jamKe > 10) {
                $conflictMessages[] = "Data jadwal ke-" . ($index + 1) . ": Jam ke-$jamKe tidak valid (harus 1-10)";
                continue;
            }

            // Validasi urutan waktu: jam selesai harus lebih besar dari jam mulai
            if (strtotime($waktuSelesai) <= strtotime($waktuMulai)) {
                $conflictMessages[] = "Data jadwal ke-" . ($index + 1) . " ($mataKuliah): Waktu selesai ($waktuSelesai) harus lebih besar dari waktu mulai ($waktuMulai)";
                continue;
            }

            $conflicts = $this->checkScheduleConflict(
                $kelas,
                $hari,
                $waktuMulai,
                $waktuSelesai,
                $semester,
                $tahunAkademik,
                $dosen,
                $ruang
            );

            if (!empty($conflicts)) {
                $conflictMessages[] = "Data jadwal ke-" . ($index + 1) . " ($mataKuliah): " . implode(', ', $conflicts);
                continue;
            }

            $entries[] = [
                'kelas' => $kelas,
                'hari' => $hari,
                'jam_ke' => $jamKe,
                'waktu' => $waktu,
                'mata_kuliah' => $mataKuliah,
                'dosen' => $dosen,
                'ruang' => $ruang,
                'semester' => $semester,
                'tahun_akademik' => $tahunAkademik,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($conflictMessages)) {
            return back()->with('error', "Terdapat kesalahan:<br>" . implode("<br>", $conflictMessages));
        }

        if (empty($entries)) {
            return back()->with('error', 'Tidak ada data valid untuk disimpan.');
        }

        DB::transaction(function () use ($entries) {
            foreach ($entries as $entry) {
                DB::table('schedules')->insert($entry);
            }
        });

        $this->logActivity(
            $request->session()->get('user_id'),
            'Tambah Massal Jadwal',
            "Berhasil menambahkan " . count($entries) . " jadwal sekaligus"
        );

        return redirect('/admin/manage-schedule')->with('success', "Berhasil menambahkan " . count($entries) . " jadwal sekaligus.");
    }

    /* ==========================================================
     |  IMPORT JADWAL AI (Gemini 1.5 Flash)
     |  - importAi         : scan file -> ekstraksi AI -> cek bentrok
     |  - importAiValidate : validasi ulang satu baris hasil edit inline
     |  - importAiStore    : simpan baris-baris yang valid ke database
     |  - checkClash       : deteksi bentrok ruangan & dosen
     |  - resolveJamKe     : mapping jam mulai -> jam_ke (1-10)
     * ========================================================== */

    public function importAi(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi telah berakhir. Silakan login ulang.',
            ], 401);
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        try {
            $request->validate([
                'file' => 'required|file|max:10240',
            ]);

            $file = $request->file('file');
            $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
            $allowed = ['pdf', 'xlsx', 'csv', 'png', 'jpg', 'jpeg'];

            if (!in_array($extension, $allowed)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format file tidak didukung. Gunakan: ' . implode(', ', $allowed) . '.',
                ]);
            }

            // 1) Kirim file ke provider AI aktif (Gemini / OpenAI / Anthropic)
            $service = new AiScheduleImportService();
            $items = $service->extractSchedules($file->getRealPath(), $extension);
            $usage = $service->getUsageInfo();

            if (empty($items)) {
                return response()->json([
                    'success' => false,
                    'message' => 'AI tidak menemukan data jadwal pada dokumen tersebut.',
                ]);
            }

            // 2) Semester aktif sebagai konteks pengecekan bentrok
            $activeSemester = SemesterSetting::getActiveSemester();
            $tahunAkademik = $activeSemester['tahun_akademik'] ?? date('Y');
            $semester = $activeSemester['semester'] ?? 'GANJIL';

            // 3) Cek bentrok setiap baris hasil ekstraksi
            $data = [];
            foreach ($items as $item) {
                $clash = $this->checkClash(
                    $item['kelas'],
                    $item['hari'],
                    $item['jam_mulai'],
                    $item['jam_selesai'],
                    $semester,
                    $tahunAkademik,
                    $item['dosen'],
                    $item['ruangan']
                );

                $data[] = [
                    'kelas' => $item['kelas'],
                    'hari' => $item['hari'],
                    'jam_mulai' => $item['jam_mulai'],
                    'jam_selesai' => $item['jam_selesai'],
                    'matakuliah' => $item['matakuliah'],
                    'ruangan' => $item['ruangan'],
                    'dosen' => $item['dosen'],
                    'jam_ke' => $this->resolveJamKe($item['jam_mulai']),
                    'semester' => $semester,
                    'tahun_akademik' => $tahunAkademik,
                    'status' => empty($clash) ? 'valid' : 'bentrok',
                    'pesan_error' => empty($clash) ? null : implode(' | ', $clash),
                ];
            }

            $summary = [
                'total' => count($data),
                'valid' => count(array_filter($data, fn ($row) => $row['status'] === 'valid')),
                'bentrok' => count(array_filter($data, fn ($row) => $row['status'] === 'bentrok')),
            ];

            $this->logActivity(
                $request->session()->get('user_id'),
                'Import Jadwal AI',
                "Scan AI file {$file->getClientOriginalName()}: {$summary['total']} baris ({$summary['valid']} valid, {$summary['bentrok']} bentrok)"
            );

            return response()->json([
                'success' => true,
                'message' => 'Scan AI selesai.',
                'summary' => $summary,
                'data' => $data,
                'usage' => $usage,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
            ]);
        } catch (AiUsageLimitExceededException $e) {
            // Limit penggunaan AI tercapai -> beri notifikasi yang jelas
            $usage = (new AiScheduleImportService())->getUsageInfo();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'usage' => $usage,
                'limit_reached' => true,
            ]);
        } catch (\Throwable $e) {
            Log::error('Import Jadwal AI gagal: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses file: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Validasi ulang satu baris jadwal hasil edit inline pada modal preview.
     */
    public function importAiValidate(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi telah berakhir. Silakan login ulang.',
            ], 401);
        }

        try {
            $item = $request->input('item', []);

            if (!is_array($item) || empty($item)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data jadwal tidak valid.',
                ]);
            }

            $hari = AbstractAiProvider::normalizeHari($item['hari'] ?? '');
            $jamMulai = AbstractAiProvider::normalizeJam($item['jam_mulai'] ?? '');
            $jamSelesai = AbstractAiProvider::normalizeJam($item['jam_selesai'] ?? '');

            $clash = $this->checkClash(
                trim((string) ($item['kelas'] ?? '')),
                $hari,
                $jamMulai,
                $jamSelesai,
                trim((string) ($item['semester'] ?? '')),
                trim((string) ($item['tahun_akademik'] ?? '')),
                trim((string) ($item['dosen'] ?? '')),
                trim((string) ($item['ruangan'] ?? ''))
            );

            return response()->json([
                'success' => true,
                'hari' => $hari,
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'jam_ke' => $this->resolveJamKe($jamMulai),
                'status' => empty($clash) ? 'valid' : 'bentrok',
                'pesan_error' => empty($clash) ? null : implode(' | ', $clash),
            ]);
        } catch (\Throwable $e) {
            Log::error('Validasi Import Jadwal AI gagal: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memvalidasi data: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Simpan baris-baris jadwal yang telah divalidasi user di modal preview.
     */
    public function importAiStore(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi telah berakhir. Silakan login ulang.',
            ], 401);
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        try {
            $rows = $request->input('schedules', []);

            if (empty($rows) || !is_array($rows)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data jadwal valid yang dikirim.',
                ]);
            }

            $entries = [];
            $errors = [];

            foreach (array_values($rows) as $index => $row) {
                $kelas = trim((string) ($row['kelas'] ?? ''));
                $hari = AbstractAiProvider::normalizeHari($row['hari'] ?? '');
                $jamMulai = AbstractAiProvider::normalizeJam($row['jam_mulai'] ?? '');
                $jamSelesai = AbstractAiProvider::normalizeJam($row['jam_selesai'] ?? '');
                $mataKuliah = trim((string) ($row['matakuliah'] ?? ''));
                $dosen = trim((string) ($row['dosen'] ?? ''));
                $ruangan = trim((string) ($row['ruangan'] ?? ''));
                $semester = trim((string) ($row['semester'] ?? ''));
                $tahunAkademik = trim((string) ($row['tahun_akademik'] ?? ''));

                $jamKe = (int) ($row['jam_ke'] ?? 0);
                if ($jamKe < 1 || $jamKe > 10) {
                    $jamKe = $this->resolveJamKe($jamMulai);
                }

                // 1) Cek bentrok terhadap database
                $clash = $this->checkClash($kelas, $hari, $jamMulai, $jamSelesai, $semester, $tahunAkademik, $dosen, $ruangan);

                // 2) Cek bentrok antar baris dalam batch import yang sama
                if (empty($clash)) {
                    foreach ($entries as $entry) {
                        if (strcasecmp($entry['hari'], $hari) !== 0) {
                            continue;
                        }

                        $sameRoom = strcasecmp($entry['ruang'], $ruangan) === 0;
                        $sameDosen = strcasecmp($entry['dosen'], $dosen) === 0;

                        if (!$sameRoom && !$sameDosen) {
                            continue;
                        }

                        list($existingMulai, $existingSelesai) = explode(' - ', $entry['waktu']);

                        if (strtotime($jamMulai) < strtotime($existingSelesai) && strtotime($jamSelesai) > strtotime($existingMulai)) {
                            $clash[] = $sameRoom
                                ? "Ruangan {$ruangan} dipakai baris lain dalam import ini ({$entry['hari']} {$entry['waktu']})"
                                : "Dosen {$dosen} dibentrokkan baris lain dalam import ini ({$entry['hari']} {$entry['waktu']})";
                        }
                    }
                }

                if (!empty($clash)) {
                    $errors[] = 'Baris ke-' . ($index + 1) . " ({$mataKuliah}): " . implode(' | ', $clash);
                    continue;
                }

                $entries[] = [
                    'kelas' => $kelas,
                    'hari' => $hari,
                    'jam_ke' => $jamKe,
                    'waktu' => "{$jamMulai} - {$jamSelesai}",
                    'mata_kuliah' => $mataKuliah,
                    'dosen' => $dosen,
                    'ruang' => $ruangan,
                    'semester' => $semester,
                    'tahun_akademik' => $tahunAkademik,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($errors)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terdapat bentrok/kesalahan pada data yang dikirim:<br>' . implode('<br>', $errors),
                    'conflicts' => $errors,
                ]);
            }

            if (empty($entries)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data valid untuk disimpan.',
                ]);
            }

            DB::transaction(function () use ($entries) {
                foreach ($entries as $entry) {
                    DB::table('schedules')->insert($entry);
                }
            });

            $this->logActivity(
                $request->session()->get('user_id'),
                'Import Jadwal AI',
                'Berhasil menyimpan ' . count($entries) . ' jadwal hasil scan AI'
            );

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menyimpan ' . count($entries) . ' jadwal hasil Import AI!',
                'count' => count($entries),
            ]);
        } catch (\Throwable $e) {
            Log::error('Simpan Import Jadwal AI gagal: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Cek bentrok untuk hasil Import Jadwal AI:
     * a. Ruangan yang sama pada hari & rentang jam yang tumpang tindih.
     * b. Dosen yang sama mengajar di kelas lain pada hari & rentang jam yang tumpang tindih.
     *
     * @return array Daftar pesan error bentrok (array kosong = tidak bentrok)
     */
    private function checkClash($kelas, $hari, $jamMulai, $jamSelesai, $semester, $tahunAkademik, $dosen, $ruangan)
    {
        $kelas = trim((string) $kelas);
        $hari = strtoupper(trim((string) $hari));
        $jamMulai = trim((string) $jamMulai);
        $jamSelesai = trim((string) $jamSelesai);
        $dosen = trim((string) $dosen);
        $ruangan = trim((string) $ruangan);

        // Validasi kelengkapan data hasil ekstraksi AI
        $errors = [];
        if ($kelas === '') {
            $errors[] = 'Kelas wajib diisi (silakan edit baris ini)';
        }
        if ($hari === '') {
            $errors[] = 'Hari wajib diisi';
        }
        if ($jamMulai === '' || $jamSelesai === '') {
            $errors[] = 'Jam mulai & jam selesai wajib diisi';
        }
        if ($dosen === '') {
            $errors[] = 'Nama dosen wajib diisi';
        }
        if ($ruangan === '') {
            $errors[] = 'Ruangan wajib diisi';
        }
        if (!empty($errors)) {
            return $errors;
        }

        $startTime = strtotime($jamMulai);
        $endTime = strtotime($jamSelesai);

        if ($startTime === false || $endTime === false) {
            return ['Format jam tidak valid'];
        }

        if ($endTime <= $startTime) {
            return ["Jam selesai ({$jamSelesai}) harus lebih besar dari jam mulai ({$jamMulai})"];
        }

        // (a) Bentrok ruangan: ruangan sama, hari sama, waktu tumpang tindih
        $roomSchedules = DB::table('schedules')
            ->where('ruang', $ruangan)
            ->where('hari', $hari)
            ->where('semester', $semester)
            ->where('tahun_akademik', $tahunAkademik)
            ->get();

        foreach ($roomSchedules as $schedule) {
            list($existingMulai, $existingSelesai) = explode(' - ', $schedule->waktu);

            if ($startTime < strtotime($existingSelesai) && $endTime > strtotime($existingMulai)) {
                $errors[] = "Ruangan {$ruangan} sudah dipakai kelas {$schedule->kelas} pada hari {$schedule->hari} jam {$schedule->jam_ke} ({$schedule->waktu}) - {$schedule->mata_kuliah}";
            }
        }

        // (b) Bentrok dosen: dosen sama mengajar di kelas lain, hari sama, waktu tumpang tindih
        $lecturerQuery = DB::table('schedules')
            ->where('dosen', $dosen)
            ->where('hari', $hari)
            ->where('semester', $semester)
            ->where('tahun_akademik', $tahunAkademik);

        if ($kelas !== '') {
            $lecturerQuery->where('kelas', '!=', $kelas);
        }

        $lecturerSchedules = $lecturerQuery->get();

        foreach ($lecturerSchedules as $schedule) {
            list($existingMulai, $existingSelesai) = explode(' - ', $schedule->waktu);

            if ($startTime < strtotime($existingSelesai) && $endTime > strtotime($existingMulai)) {
                $errors[] = "Dosen {$dosen} sudah mengajar kelas {$schedule->kelas} pada hari {$schedule->hari} jam {$schedule->jam_ke} ({$schedule->waktu}) - {$schedule->mata_kuliah}";
            }
        }

        return array_values(array_unique($errors));
    }

    /**
     * Konversi jam mulai menjadi nomor slot jam_ke (1-10)
     * berdasarkan pemetaan slot waktu yang dipakai sistem.
     */
    private function resolveJamKe($jamMulai)
    {
        $time = trim((string) $jamMulai);

        if ($time === '') {
            return 1;
        }

        // 1) Cocokkan persis dengan jam mulai slot
        for ($i = 1; $i <= 10; $i++) {
            $slot = $this->getTimeSlotByJamKe($i);
            if ($slot && $slot[0] === $time) {
                return $i;
            }
        }

        $timestamp = strtotime($time);
        if ($timestamp === false) {
            return 1;
        }

        // 2) Cari slot yang memuat jam tersebut
        for ($i = 1; $i <= 10; $i++) {
            $slot = $this->getTimeSlotByJamKe($i);
            if ($slot && $timestamp >= strtotime($slot[0]) && $timestamp <= strtotime($slot[1])) {
                return $i;
            }
        }

        // 3) Fallback: slot dengan jam mulai terdekat
        $best = 1;
        $bestDiff = PHP_INT_MAX;
        for ($i = 1; $i <= 10; $i++) {
            $slot = $this->getTimeSlotByJamKe($i);
            if (!$slot) {
                continue;
            }
            $diff = abs($timestamp - strtotime($slot[0]));
            if ($diff < $bestDiff) {
                $bestDiff = $diff;
                $best = $i;
            }
        }

        return $best;
    }

    private function getTimeSlotByJamKe($jamKe)
    {
        $mapping = [
            1 => ['07:30', '08:20'],
            2 => ['08:20', '09:10'],
            3 => ['09:10', '10:00'],
            4 => ['10:00', '10:50'],
            5 => ['10:50', '11:40'],
            6 => ['11:40', '12:30'],
            7 => ['13:10', '14:00'],
            8 => ['14:00', '14:50'],
            9 => ['14:50', '15:40'],
            10 => ['15:40', '16:30'],
        ];

        return $mapping[$jamKe] ?? null;
    }

    private function checkScheduleConflict($kelas, $hari, $mulai, $selesai, $semester, $tahunAkademik, $dosen, $ruang, $excludeId = null)
    {
        $conflicts = [];

        // Convert time to comparable format
        $startTime = strtotime($mulai);
        $endTime = strtotime($selesai);

        // Check class conflict (same class, same day, overlapping time)
        $query = DB::table('schedules')
            ->where('kelas', $kelas)
            ->where('hari', $hari)
            ->where('semester', $semester)
            ->where('tahun_akademik', $tahunAkademik);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $existingSchedules = $query->get();

        foreach ($existingSchedules as $schedule) {
            list($existingMulai, $existingSelesai) = explode(' - ', $schedule->waktu);
            $existingStart = strtotime($existingMulai);
            $existingEnd = strtotime($existingSelesai);

            // Check time overlap
            if ($startTime < $existingEnd && $endTime > $existingStart) {
                $conflicts[] = "Bentrok dengan jadwal kelas {$schedule->kelas} hari {$schedule->hari} jam {$schedule->jam_ke} ({$schedule->waktu}) - {$schedule->mata_kuliah}";
            }
        }

        // Check room conflict (same room, same day, overlapping time)
        $query = DB::table('schedules')
            ->where('ruang', $ruang)
            ->where('hari', $hari)
            ->where('semester', $semester)
            ->where('tahun_akademik', $tahunAkademik);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $roomSchedules = $query->get();

        foreach ($roomSchedules as $schedule) {
            list($existingMulai, $existingSelesai) = explode(' - ', $schedule->waktu);
            $existingStart = strtotime($existingMulai);
            $existingEnd = strtotime($existingSelesai);

            if ($startTime < $existingEnd && $endTime > $existingStart) {
                $conflicts[] = "Ruang $ruang sudah digunakan kelas {$schedule->kelas} pada hari {$schedule->hari} jam {$schedule->jam_ke} ({$schedule->waktu})";
            }
        }

        // Check lecturer conflict (same lecturer, same day, overlapping time)
        $query = DB::table('schedules')
            ->where('dosen', $dosen)
            ->where('hari', $hari)
            ->where('semester', $semester)
            ->where('tahun_akademik', $tahunAkademik);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $lecturerSchedules = $query->get();

        foreach ($lecturerSchedules as $schedule) {
            list($existingMulai, $existingSelesai) = explode(' - ', $schedule->waktu);
            $existingStart = strtotime($existingMulai);
            $existingEnd = strtotime($existingSelesai);

            if ($startTime < $existingEnd && $endTime > $existingStart) {
                $conflicts[] = "Dosen $dosen sudah mengajar kelas {$schedule->kelas} pada hari {$schedule->hari} jam {$schedule->jam_ke} ({$schedule->waktu})";
            }
        }

        // Check parallel assignment conflict (same class included in a parallel schedule on overlapping time)
        $parallelRows = DB::table('parallel_schedules')
            ->join('schedules', 'parallel_schedules.schedule_id', '=', 'schedules.id')
            ->where('schedules.hari', $hari)
            ->where('schedules.semester', $semester)
            ->where('schedules.tahun_akademik', $tahunAkademik)
            ->where(function ($q) use ($kelas) {
                $q->where('parallel_schedules.kelas', 'LIKE', '%' . $kelas . '%');
            })
            ->get(['parallel_schedules.kelas as pk', 'schedules.waktu as pw', 'schedules.jam_ke as pj', 'schedules.mata_kuliah as pm']);

        foreach ($parallelRows as $p) {
            $pClasses = \App\Models\ParallelSchedule::normalizeKelasList($p->pk);
            if (!in_array($kelas, $pClasses)) {
                continue;
            }
            list($existingMulai, $existingSelesai) = explode(' - ', $p->pw);
            $existingStart = strtotime($existingMulai);
            $existingEnd = strtotime($existingSelesai);

            if ($startTime < $existingEnd && $endTime > $existingStart) {
                $conflicts[] = "Kelas $kelas sudah dipakai jadwal paralel {$p->pm} hari $hari jam {$p->pj} ({$p->pw})";
            }
        }

        return array_unique($conflicts);
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
