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

        $request->validate([
            'kelas' => 'required|string',
            'hari' => 'required|string',
            'semester' => 'required|string',
            'tahun_akademik' => 'required|string',
            'groups' => 'required|array|min:1',
            'groups.*.mata_kuliah' => 'required|string',
            'groups.*.dosen' => 'required|string',
            'groups.*.ruang' => 'required|string',
            'groups.*.jam_ke_list' => 'required|array|min:1',
        ]);

        $kelas = $request->input('kelas');
        $hari = $request->input('hari');
        $semester = $request->input('semester');
        $tahunAkademik = $request->input('tahun_akademik');
        $groups = $request->input('groups');

        $entries = [];
        $conflictMessages = [];
        $usedJamKe = [];

        foreach ($groups as $group) {
            $mataKuliah = trim($group['mata_kuliah']);
            $dosen = trim($group['dosen']);
            $ruang = trim($group['ruang']);
            $jamKeList = array_map('intval', $group['jam_ke_list']);

            foreach ($jamKeList as $jamKe) {
                if (in_array($jamKe, $usedJamKe)) {
                    $conflictMessages[] = "Slot '$mataKuliah': Jam ke-$jamKe sudah digunakan di slot lain pada hari yang sama.";
                } else {
                    $usedJamKe[] = $jamKe;
                }

                $slot = $this->getTimeSlotByJamKe($jamKe);
                if (!$slot) {
                    $conflictMessages[] = "Jam ke-$jamKe tidak valid.";
                    continue;
                }

                list($mulai, $selesai) = $slot;
                $waktu = "$mulai - $selesai";

                $conflicts = $this->checkScheduleConflict(
                    $kelas,
                    $hari,
                    $mulai,
                    $selesai,
                    $semester,
                    $tahunAkademik,
                    $dosen,
                    $ruang
                );

                if (!empty($conflicts)) {
                    $conflictMessages[] = "Mata kuliah '$mataKuliah' jam ke-$jamKe ($waktu): " . implode(', ', $conflicts);
                } else {
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
                    ];
                }
            }
        }

        if (!empty($conflictMessages)) {
            return back()->with('error', "Terdapat bentrok jadwal:<br>" . implode("<br>", $conflictMessages));
        }

        if (empty($entries)) {
            return back()->with('error', 'Tidak ada data valid untuk disimpan.');
        }

        DB::transaction(function () use ($entries) {
            foreach ($entries as $entry) {
                DB::table('schedules')->insert(array_merge($entry, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        });

        $this->logActivity(
            $request->session()->get('user_id'),
            'Tambah Massal Jadwal (Multi Slot)',
            "Kelas: $kelas, Hari: $hari, " . count($entries) . " slot dari " . count($groups) . " mata kuliah"
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
