<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParallelScheduleController extends Controller
{
    public function index(Request $request)
    {
        // Check if user is authenticated
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        // Get active semester
        $activeSemester = \App\Models\SemesterSetting::getActiveSemester();
        $tahunAkademikAktif = $activeSemester['tahun_akademik'] ?? date('Y');
        $semesterAktif = $activeSemester['semester'] ?? 'GANJIL';

        // Get all tahun akademik
        $tahunList = \App\Models\SemesterSetting::getAllTahunAkademik();
        if (!in_array($tahunAkademikAktif, $tahunList)) {
            array_unshift($tahunList, $tahunAkademikAktif);
        }

        // Get filters from request
        $filterTahun = $request->query('filter_tahun', $tahunAkademikAktif);
        $filterSemester = $request->query('filter_semester', $semesterAktif);

        // List parallel entries, joined with their base schedules, filtered by base semester/tahun.
        $query = DB::table('parallel_schedules')
            ->join('schedules', 'parallel_schedules.schedule_id', '=', 'schedules.id')
            ->select(
                'parallel_schedules.id as parallel_id',
                'parallel_schedules.schedule_id',
                'parallel_schedules.kelas as parallel_kelas',
                'parallel_schedules.created_at as parallel_created_at',
                'schedules.kelas as base_kelas',
                'schedules.hari',
                'schedules.jam_ke',
                'schedules.waktu',
                'schedules.mata_kuliah',
                'schedules.dosen',
                'schedules.ruang',
                'schedules.semester',
                'schedules.tahun_akademik'
            );

        if ($filterTahun != 'all') {
            $query->where('schedules.tahun_akademik', $filterTahun);
        }
        if ($filterSemester != 'all') {
            $query->where('schedules.semester', $filterSemester);
        }

        $entries = $query->orderBy('schedules.tahun_akademik', 'desc')
            ->orderBy('schedules.semester')
            ->orderBy('schedules.hari')
            ->orderBy('schedules.jam_ke')
            ->get();

        // Rooms for reference (kept for template compatibility).
        $rooms = DB::table('rooms')->orderBy('nama_ruang')->pluck('nama_ruang')->toArray();

        // Prepare time slots for JavaScript (kept for template compatibility).
        $timeSlots = [];
        for ($i = 1; $i <= 10; $i++) {
            $slot = $this->getTimeSlotByJamKe($i);
            $timeSlots[$i] = $slot ? implode(' - ', $slot) : 'Tidak tersedia';
        }

        // All parallel records (count for delete-all display).
        $schedules = DB::table('parallel_schedules')->get();

        return view('admin.manage-parallel', compact(
            'entries',
            'schedules',
            'rooms',
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

        if (!$request->ajax()) {
            return back()->with('error', 'Permintaan tidak valid.');
        }

        try {
            $request->validate([
                'schedule_id' => 'required|integer|exists:schedules,id',
                'kelas' => 'required|string',
            ]);

            $schedule = DB::table('schedules')->where('id', $request->input('schedule_id'))->first();
            if (!$schedule) {
                return response()->json(['success' => false, 'message' => 'Jadwal dasar tidak ditemukan.']);
            }

            $newKelasList = \App\Models\ParallelSchedule::normalizeKelasList($request->input('kelas'));
            if (empty($newKelasList)) {
                return response()->json(['success' => false, 'message' => 'Minimal satu kelas tambahan harus diisi.']);
            }

            // Merge with any classes already assigned to this base schedule.
            $existing = DB::table('parallel_schedules')->where('schedule_id', $schedule->id)->first();
            $existingList = $existing ? \App\Models\ParallelSchedule::normalizeKelasList($existing->kelas) : [];
            $allKelasList = array_values(array_unique(array_merge($existingList, $newKelasList)));

            // Check conflicts for the newly requested classes.
            $conflicts = $this->checkParallelConflict($newKelasList, $schedule);

            if (!empty($conflicts)) {
                return response()->json([
                    'success' => false,
                    'message' => implode("<br>", $conflicts)
                ]);
            }

            $kelas = implode(', ', $allKelasList);

            if ($existing) {
                DB::table('parallel_schedules')->where('id', $existing->id)->update([
                    'kelas' => $kelas,
                    'updated_at' => now(),
                ]);
                $parallelId = $existing->id;
            } else {
                $parallelId = DB::table('parallel_schedules')->insertGetId([
                    'schedule_id' => $schedule->id,
                    'kelas' => $kelas,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $this->logActivity(
                $request->session()->get('user_id'),
                'Tambah Jadwal Paralel',
                "Jadwal ID {$schedule->id} ({$schedule->mata_kuliah}) diparalelkan untuk kelas: $kelas"
            );

            return response()->json([
                'success' => true,
                'message' => 'Kelas paralel berhasil ditambahkan!',
                'data' => [
                    'id' => $parallelId,
                    'schedule_id' => $schedule->id,
                    'kelas' => $kelas,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
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
                $parallel = DB::table('parallel_schedules')->where('id', $id)->first();
                if ($parallel) {
                    $this->logActivity(
                        $request->session()->get('user_id'),
                        'Hapus Jadwal Paralel',
                        "Jadwal base ID {$parallel->schedule_id}, kelas paralel: {$parallel->kelas}"
                    );
                }
                DB::table('parallel_schedules')->where('id', $id)->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Jadwal paralel berhasil dihapus!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        DB::table('parallel_schedules')->where('id', $id)->delete();
        $this->logActivity($request->session()->get('user_id'), 'Hapus Jadwal Paralel', "ID: $id");

        return redirect('/admin/manage-parallel')->with('success', 'Jadwal paralel berhasil dihapus!');
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
                $totalData = DB::table('parallel_schedules')->count();
                DB::table('parallel_schedules')->delete();

                $this->logActivity($request->session()->get('user_id'), 'Hapus Semua Jadwal Paralel', "Semua jadwal paralel dihapus, total: $totalData data");

                return response()->json([
                    'success' => true,
                    'message' => "Semua jadwal paralel ($totalData data) berhasil dihapus!"
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        $totalData = DB::table('parallel_schedules')->count();
        DB::table('parallel_schedules')->delete();
        $this->logActivity($request->session()->get('user_id'), 'Hapus Semua Jadwal Paralel', "Semua jadwal paralel dihapus, total: $totalData data");

        return redirect('/admin/manage-parallel')->with('success', "Semua jadwal paralel ($totalData data) berhasil dihapus!");
    }

    /**
     * Remove a single class from an existing parallel assignment.
     */
    public function removeClass(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return response()->json(['success' => false, 'message' => 'Sesi berakhir.']);
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return response()->json(['success' => false, 'message' => 'Tidak diizinkan.']);
        }

        try {
            $request->validate([
                'schedule_id' => 'required|integer|exists:schedules,id',
                'kelas' => 'required|string',
            ]);

            $parallel = DB::table('parallel_schedules')->where('schedule_id', $request->input('schedule_id'))->first();
            if (!$parallel) {
                return response()->json(['success' => false, 'message' => 'Data paralel tidak ditemukan.']);
            }

            $kelasToRemove = strtoupper(trim($request->input('kelas')));
            $current = \App\Models\ParallelSchedule::normalizeKelasList($parallel->kelas);
            $remaining = array_values(array_filter($current, function ($k) use ($kelasToRemove) {
                return $k !== $kelasToRemove;
            }));

            if (count($remaining) === 0) {
                // No classes left -> remove the whole parallel assignment.
                DB::table('parallel_schedules')->where('id', $parallel->id)->delete();
            } else {
                DB::table('parallel_schedules')->where('id', $parallel->id)->update([
                    'kelas' => implode(', ', $remaining),
                    'updated_at' => now(),
                ]);
            }

            $this->logActivity(
                $request->session()->get('user_id'),
                'Hapus Kelas Paralel',
                "Kelas $kelasToRemove dihapus dari jadwal base ID {$parallel->schedule_id}"
            );

            return response()->json([
                'success' => true,
                'message' => "Kelas $kelasToRemove berhasil dihapus dari jadwal paralel!",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
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

    /**
     * Check whether any of the newly added classes conflicts for the given base schedule.
     * Returns an array of conflict message strings.
     */
    private function checkParallelConflict(array $newKelasList, $schedule)
    {
        $conflicts = [];
        list($mulai, $selesai) = array_pad(explode(' - ', (string) $schedule->waktu), 2, '');
        if ($mulai === '' || $selesai === '') {
            return ['Waktu jadwal dasar tidak valid.'];
        }
        $startTime = strtotime($mulai);
        $endTime = strtotime($selesai);

        foreach ($newKelasList as $kelas) {
            // Cannot be the same class as the base schedule's own class.
            if (strtoupper(trim($kelas)) === strtoupper(trim($schedule->kelas))) {
                $conflicts[] = "Kelas $kelas adalah kelas utama dari jadwal ini, tidak perlu ditambahkan.";
                continue;
            }

            // Check against regular schedules of the same class on the overlapping time.
            $regular = DB::table('schedules')
                ->where('kelas', $kelas)
                ->where('hari', $schedule->hari)
                ->where('semester', $schedule->semester)
                ->where('tahun_akademik', $schedule->tahun_akademik)
                ->where('id', '!=', $schedule->id)
                ->get();

            foreach ($regular as $r) {
                list($rMulai, $rSelesai) = array_pad(explode(' - ', (string) $r->waktu), 2, '');
                if ($rMulai === '' || $rSelesai === '') continue;
                if ($startTime < strtotime($rSelesai) && $endTime > strtotime($rMulai)) {
                    $conflicts[] = "Kelas $kelas sudah ada jadwal hari {$r->hari} jam {$r->jam_ke} ({$r->waktu}) - {$r->mata_kuliah}";
                }
            }

            // Check against other parallel schedules of the same class on the overlapping time.
            $otherParallels = DB::table('parallel_schedules')
                ->join('schedules', 'parallel_schedules.schedule_id', '=', 'schedules.id')
                ->where('schedules.hari', $schedule->hari)
                ->where('schedules.semester', $schedule->semester)
                ->where('schedules.tahun_akademik', $schedule->tahun_akademik)
                ->where('parallel_schedules.schedule_id', '!=', $schedule->id)
                ->get(['parallel_schedules.kelas as pk', 'schedules.waktu as pw', 'schedules.jam_ke as pj', 'schedules.mata_kuliah as pm']);

            foreach ($otherParallels as $op) {
                $opKelasList = \App\Models\ParallelSchedule::normalizeKelasList($op->pk);
                if (!in_array($kelas, $opKelasList)) continue;

                list($opMulai, $opSelesai) = array_pad(explode(' - ', (string) $op->pw), 2, '');
                if ($opMulai === '' || $opSelesai === '') continue;
                if ($startTime < strtotime($opSelesai) && $endTime > strtotime($opMulai)) {
                    $conflicts[] = "Kelas $kelas sudah dipakai jadwal paralel {$op->pm} hari {$schedule->hari} jam {$op->pj} ({$op->pw})";
                }
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