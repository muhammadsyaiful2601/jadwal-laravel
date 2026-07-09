<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return redirect('/login');
        }

        $type = $request->query('type', 'jadwal');

        switch ($type) {
            case 'jadwal':
                return $this->exportJadwal();
            case 'ruangan':
                return $this->exportRuangan();
            case 'aktivitas':
                return $this->exportAktivitas();
            default:
                return redirect('/admin/reports')->with('error', 'Tipe ekspor tidak valid!');
        }
    }

    private function exportJadwal()
    {
        $data = DB::table('schedules')
            ->select(
                'kelas',
                'hari',
                'jam_ke',
                'waktu',
                'mata_kuliah',
                'dosen',
                'ruang',
                'semester',
                'tahun_akademik'
            )
            ->orderBy('kelas')
            ->orderBy('hari')
            ->orderBy('jam_ke')
            ->get()
            ->toArray();

        $filename = "jadwal_kuliah_" . date('Y-m-d') . ".csv";
        $headers = ['Kelas', 'Hari', 'Jam Ke', 'Waktu', 'Mata Kuliah', 'Dosen', 'Ruang', 'Semester', 'Tahun Akademik'];

        return $this->generateCsv($data, $headers, $filename, function ($row) {
            return [
                $row->kelas,
                $row->hari,
                $row->jam_ke,
                $row->waktu,
                $row->mata_kuliah,
                $row->dosen,
                $row->ruang,
                $row->semester,
                $row->tahun_akademik
            ];
        });
    }

    private function exportRuangan()
    {
        $data = DB::table('rooms')
            ->select('nama_ruang', 'deskripsi', 'created_at')
            ->orderBy('nama_ruang')
            ->get()
            ->toArray();

        $filename = "ruangan_" . date('Y-m-d') . ".csv";
        $headers = ['Nama Ruangan', 'Deskripsi', 'Tanggal Dibuat'];

        return $this->generateCsv($data, $headers, $filename, function ($row) {
            return [
                $row->nama_ruang,
                $row->deskripsi,
                $row->created_at
            ];
        });
    }

    private function exportAktivitas()
    {
        $data = DB::table('activity_logs as a')
            ->select('a.created_at', 'u.username', 'a.action', 'a.description', 'a.ip_address')
            ->leftJoin('users as u', 'a.user_id', '=', 'u.id')
            ->orderByDesc('a.created_at')
            ->get()
            ->toArray();

        $filename = "aktivitas_" . date('Y-m-d') . ".csv";
        $headers = ['Waktu', 'Username', 'Aksi', 'Deskripsi', 'IP Address'];

        return $this->generateCsv($data, $headers, $filename, function ($row) {
            return [
                $row->created_at,
                $row->username,
                $row->action,
                $row->description,
                $row->ip_address
            ];
        });
    }

    private function generateCsv($data, $headers, $filename, $callback)
    {
        $content = implode(',', $headers) . "\n";

        foreach ($data as $row) {
            $rowData = $callback($row);
            $escapedRow = array_map(function ($field) {
                return '"' . str_replace('"', '""', $field) . '"';
            }, $rowData);
            $content .= implode(',', $escapedRow) . "\n";
        }

        return Response::make($content, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
