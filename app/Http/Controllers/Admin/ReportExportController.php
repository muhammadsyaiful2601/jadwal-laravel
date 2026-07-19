 <?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportExportController extends Controller
{
    public function export(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $check = $this->checkSuperadminVerified($request);
        if ($check !== true) {
            return $check;
        }

        $format = $request->query('format', 'pdf');
        $prodi = $request->query('prodi');
        $semesterId = $request->query('semester_id');

        // Get schedules
        $query = DB::table('schedules');

        if ($prodi) {
            $query->where('kelas', $prodi);
        }

        if ($semesterId) {
            $semester = DB::table('semester_settings')->where('id', $semesterId)->first();
            if ($semester) {
                $query->where('tahun_akademik', $semester->tahun_akademik)
                    ->where('semester', $semester->semester);
            }
        }

        $schedules = $query->orderBy('kelas')->orderBy('hari')->orderBy('jam_ke')->get();

        // Get stats
        $stats = [];
        $stats['total_jadwal'] = $query->count();
        $stats['total_kelas'] = $query->distinct('kelas')->count('kelas');
        $stats['total_ruang_digunakan'] = $query->distinct('ruang')->count('ruang');

        if ($format === 'excel') {
            return $this->exportExcel($schedules);
        }

        return $this->exportPdf($schedules, $stats);
    }

    private function exportPdf($schedules, $stats)
    {
        $institusiNama = DB::table('settings')->where('setting_key', 'institusi_nama')->value('setting_value') ?? 'Institusi';
        $programStudi = DB::table('settings')->where('setting_key', 'program_studi')->value('setting_value') ?? '';

        $pdf = Pdf::loadView('admin.exports.report-pdf', compact(
            'schedules',
            'stats',
            'institusiNama',
            'programStudi'
        ));

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan-jadwal-' . date('Y-m-d') . '.pdf');
    }

    private function exportExcel($schedules)
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="laporan-jadwal-' . date('Y-m-d') . '.csv"',
        ];

        $columns = ['No', 'Kelas', 'Hari', 'Jam Ke', 'Waktu', 'Mata Kuliah', 'Dosen', 'Ruangan', 'Semester', 'Tahun Akademik'];
        $content = implode(',', $columns) . "\n";

        $csvData = [];
        foreach ($schedules as $i => $s) {
            $csvData[] = [
                $i + 1,
                $s->kelas,
                $s->hari,
                $s->jam_ke,
                $s->waktu,
                $s->mata_kuliah,
                $s->dosen,
                $s->ruang,
                $s->semester,
                $s->tahun_akademik,
            ];
        }

        foreach ($csvData as $row) {
            $escapedRow = array_map(function ($field) {
                return '"' . str_replace('"', '""', $field) . '"';
            }, $row);
            $content .= implode(',', $escapedRow) . "\n";
        }

        // Add BOM for Excel UTF-8
        $content = "\xEF\xBB\xBF" . $content;

        return response($content, 200, $headers);
    }
}
