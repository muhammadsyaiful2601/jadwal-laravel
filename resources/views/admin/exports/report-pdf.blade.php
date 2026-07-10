<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Jadwal Kuliah</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #1e293b;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #1d4ed8;
        }

        .header h1 {
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 5px 0;
            color: #0f172a;
        }

        .header p {
            font-size: 11px;
            color: #475569;
            margin: 2px 0;
        }

        .stats-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding: 10px 15px;
            background: #f1f5f9;
            border-radius: 6px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-item .label {
            font-size: 8px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-item .value {
            font-size: 14px;
            font-weight: 700;
            color: #1d4ed8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #1d4ed8;
            color: white;
            padding: 8px 6px;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: left;
        }

        td {
            padding: 6px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9px;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            font-size: 8px;
            color: #94a3b8;
        }

        .page-number {
            position: fixed;
            bottom: 10px;
            right: 10px;
            font-size: 8px;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN JADWAL KULIAH</h1>
        <p>{{ $institusiNama }} - {{ $programStudi }}</p>
        <p>Periode: {{ date('d F Y') }}</p>
    </div>

    <div class="stats-row">
        <div class="stat-item">
            <div class="label">Total Jadwal</div>
            <div class="value">{{ $stats['total_jadwal'] }}</div>
        </div>
        <div class="stat-item">
            <div class="label">Total Kelas</div>
            <div class="value">{{ $stats['total_kelas'] }}</div>
        </div>
        <div class="stat-item">
            <div class="label">Ruangan Digunakan</div>
            <div class="value">{{ $stats['total_ruang_digunakan'] }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Jam Ke</th>
                <th>Waktu</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Ruangan</th>
                <th>Semester</th>
                <th>Tahun Akademik</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $s->kelas }}</td>
                    <td>{{ $s->hari }}</td>
                    <td>{{ $s->jam_ke }}</td>
                    <td>{{ $s->waktu }}</td>
                    <td>{{ $s->mata_kuliah }}</td>
                    <td>{{ $s->dosen }}</td>
                    <td>{{ $s->ruang }}</td>
                    <td>{{ $s->semester }}</td>
                    <td>{{ $s->tahun_akademik }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align:center; padding:20px; color:#94a3b8;">
                        Tidak ada data jadwal
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }} | Sistem Informasi Jadwal Kuliah</p>
    </div>
    <div class="page-number">
        Halaman {PAGE_NUM} dari {PAGE_COUNT}
    </div>
</body>

</html>
