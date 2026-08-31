<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'semesterAktif'
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
