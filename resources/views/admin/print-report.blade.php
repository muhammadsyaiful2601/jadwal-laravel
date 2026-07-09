<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Lengkap - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            .container {
                max-width: 100% !important;
            }

            body {
                font-size: 12px;
            }

            .table {
                font-size: 10px;
            }

            .page-break {
                page-break-before: always;
            }
        }

        @page {
            size: A4;
            margin: 20mm;
        }

        .header-print {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .footer-print {
            border-top: 1px solid #ccc;
            padding-top: 10px;
            margin-top: 20px;
            font-size: 10px;
        }

        table {
            font-size: 11px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .print-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .print-info {
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .badge-print {
            padding: 3px 8px;
            font-size: 10px;
        }

        .stat-card-print {
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            color: white;
            margin-bottom: 15px;
        }

        .stat-card-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .stat-card-success {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .stat-card-info {
            background: linear-gradient(135deg, #17a2b8, #20c997);
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <!-- Header -->
        <div class="header-print">
            <div class="print-title">
                <h4>LAPORAN LENGKAP SISTEM JADWAL KULIAH</h4>
                <p>Politeknik Negeri Padang - PSDKU Tanah Datar</p>
            </div>

            <div class="row">
                <div class="col-6">
                    <p class="mb-1"><strong>Tanggal Cetak:</strong> {{ date('d F Y H:i:s') }}</p>
                    <p class="mb-1"><strong>Dicetak oleh:</strong> {{ $currentUser->username }}</p>
                    <p class="mb-0"><strong>Role:</strong> {{ strtoupper($currentUser->role) }}</p>
                </div>
            </div>
        </div>

        <!-- Statistik Ringkas -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card-print stat-card-primary">
                    <h5><i class="fas fa-calendar-alt"></i></h5>
                    <h3>{{ $stats['total_jadwal'] }}</h3>
                    <p class="mb-0">Total Jadwal</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card-print stat-card-success">
                    <h5><i class="fas fa-users"></i></h5>
                    <h3>{{ $stats['total_kelas'] }}</h3>
                    <p class="mb-0">Total Kelas</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card-print stat-card-info">
                    <h5><i class="fas fa-door-open"></i></h5>
                    <h3>{{ $stats['total_ruang_digunakan'] }}</h3>
                    <p class="mb-0">Ruangan Digunakan</p>
                </div>
            </div>
        </div>

        <!-- Jadwal per Kelas -->
        <div class="mb-4">
            <h5 class="border-bottom pb-2 mb-3">
                <i class="fas fa-users me-2"></i>Jadwal per Kelas
            </h5>
            <table class="table table-bordered table-sm">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Kelas</th>
                        <th width="20%">Jumlah Jadwal</th>
                        <th width="45%">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                        $totalKelas = array_sum(array_column($stats['per_kelas'], 'total'));
                    @endphp
                    @foreach ($stats['per_kelas'] as $item)
                        @php
                            $percentage = $totalKelas > 0 ? ($item->total / $totalKelas) * 100 : 0;
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->kelas }}</td>
                            <td>{{ $item->total }}</td>
                            <td>
                                <div class="progress" style="height: 15px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;"
                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ number_format($percentage, 1) }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Jadwal per Hari -->
        <div class="mb-4">
            <h5 class="border-bottom pb-2 mb-3">
                <i class="fas fa-calendar-day me-2"></i>Jadwal per Hari
            </h5>
            <table class="table table-bordered table-sm">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Hari</th>
                        <th width="20%">Jumlah Jadwal</th>
                        <th width="45%">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                        $totalHari = array_sum(array_column($stats['per_hari'], 'total'));
                        $colors = [
                            'SENIN' => '#ff6384',
                            'SELASA' => '#36a2eb',
                            'RABU' => '#ffce56',
                            'KAMIS' => '#4bc0c0',
                            'JUMAT' => '#9966ff',
                        ];
                    @endphp
                    @foreach ($stats['per_hari'] as $item)
                        @php
                            $percentage = $totalHari > 0 ? ($item->total / $totalHari) * 100 : 0;
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->hari }}</td>
                            <td>{{ $item->total }}</td>
                            <td>
                                <div class="progress" style="height: 15px;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $percentage }}%; background-color: {{ $colors[$item->hari] ?? '#36a2eb' }};"
                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ number_format($percentage, 1) }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Jadwal per Ruangan -->
        <div class="mb-4">
            <h5 class="border-bottom pb-2 mb-3">
                <i class="fas fa-door-open me-2"></i>Jadwal per Ruangan
            </h5>
            <table class="table table-bordered table-sm">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Ruangan</th>
                        <th width="20%">Jumlah Jadwal</th>
                        <th width="45%">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                        $totalRuangan = array_sum(array_column($stats['per_ruangan'], 'total'));
                    @endphp
                    @foreach ($stats['per_ruangan'] as $item)
                        @php
                            $percentage = $totalRuangan > 0 ? ($item->total / $totalRuangan) * 100 : 0;
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->ruang }}</td>
                            <td>{{ $item->total }}</td>
                            <td>
                                <div class="progress" style="height: 15px;">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}"
                                        aria-valuemin="0" aria-valuemax="100">
                                        {{ number_format($percentage, 1) }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Aktivitas User -->
        <div class="mb-4">
            <h5 class="border-bottom pb-2 mb-3">
                <i class="fas fa-history me-2"></i>Top 10 Aktivitas User
            </h5>
            <table class="table table-bordered table-sm">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Username</th>
                        <th width="20%">Jumlah Aktivitas</th>
                        <th width="50%">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                        $totalAktivitas = array_sum(array_column($stats['aktivitas_user'], 'total'));
                    @endphp
                    @foreach ($stats['aktivitas_user'] as $item)
                        @php
                            $percentage = $totalAktivitas > 0 ? ($item->total / $totalAktivitas) * 100 : 0;
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->total }}</td>
                            <td>
                                <div class="progress" style="height: 15px;">
                                    <div class="progress-bar bg-warning" role="progressbar"
                                        style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}"
                                        aria-valuemin="0" aria-valuemax="100">
                                        {{ number_format($percentage, 1) }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer-print">
            <div class="row">
                <div class="col-6">
                    <p class="mb-0"><strong>Catatan:</strong></p>
                    <p class="mb-0">1. Dokumen ini dicetak dari sistem manajemen jadwal kuliah</p>
                    <p class="mb-0">2. Hanya untuk keperluan internal dan audit</p>
                    <p class="mb-0">3. Data yang ditampilkan adalah data terkini</p>
                </div>
                <div class="col-6 text-end">
                    <p class="mb-0">Politeknik Negeri Padang</p>
                    <p class="mb-0">Fakultas Teknik - D3 Sistem Informasi</p>
                    <p class="mb-0">PSDKU Tanah Datar</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container no-print mt-3">
        <div class="text-center">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Cetak Dokumen
            </button>
            <a href="{{ url('/admin/reports') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Laporan
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto print saat halaman dimuat (opsional)
        // window.onload = function() {
        //     window.print();
        // };
    </script>
</body>

</html>
