<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Laporan dan Statistik - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sidebar {
            background: linear-gradient(135deg, #2c3e50, #4a6491);
            color: white;
            min-height: 100vh;
            position: fixed;
            width: 250px;
            z-index: 1000;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .navbar-custom {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .content-wrapper {
            padding-top: 20px;
        }

        .page-header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .stat-card {
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: white;
            margin-bottom: 20px;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
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

        .stat-card-warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .nav-tabs .nav-link {
            color: #495057;
            border: none;
            border-bottom: 2px solid transparent;
        }

        .nav-tabs .nav-link.active {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            font-weight: 600;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: fixed;
                min-height: 100vh;
                display: none;
                z-index: 1050;
                top: 0;
                left: 0;
            }

            .sidebar.mobile-show {
                display: block;
            }

            .main-content {
                margin-left: 0;
                padding: 10px;
                width: 100%;
                overflow-x: hidden;
            }

            .navbar-custom {
                position: sticky;
                top: 0;
                z-index: 1030;
                padding: 10px 0;
            }

            .page-header {
                padding: 15px;
                margin: 0 -10px 15px -10px;
                width: calc(100% + 20px);
                border-radius: 0;
            }

            .page-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .table-container {
                padding: 10px;
                margin: 0 -10px;
                width: calc(100% + 20px);
                border-radius: 0;
            }

            .btn-group .btn {
                padding: 0.25rem 0.4rem;
                font-size: 0.75rem;
            }

            body {
                overflow-x: hidden;
                max-width: 100vw;
            }

            .modal-dialog {
                margin: 10px !important;
                max-width: calc(100% - 20px) !important;
            }
        }

        @media (max-width: 575.98px) {
            .main-content {
                padding: 10px 8px;
            }

            .page-header h5 {
                font-size: 1.1rem;
            }

            .table-container {
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar (Desktop) -->
        <div class="sidebar d-none d-md-block">
            <div class="p-4">
                <h3 class="mb-4"><i class="fas fa-calendar-alt"></i> Admin Panel</h3>
                <div class="user-info mb-4">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3">
                            {{ strtoupper(substr(session('username'), 0, 1)) }}
                        </div>
                        <div>
                            <h6 class="mb-0">{{ session('username') }}</h6>
                            <small class="text-muted">{{ ucfirst(session('role')) }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                    href="{{ url('/admin/dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->is('admin/manage-schedule') ? 'active' : '' }}"
                    href="{{ url('/admin/manage-schedule') }}">
                    <i class="fas fa-calendar"></i> Kelola Jadwal
                </a>
                <a class="nav-link {{ request()->is('admin/manage-rooms') ? 'active' : '' }}"
                    href="{{ url('/admin/manage-rooms') }}">
                    <i class="fas fa-door-open"></i> Kelola Ruangan
                </a>
                <a class="nav-link {{ request()->is('admin/manage-semester') ? 'active' : '' }}"
                    href="{{ url('/admin/manage-semester') }}">
                    <i class="fas fa-calendar-alt"></i> Kelola Semester
                </a>
                <a class="nav-link {{ request()->is('admin/manage-settings') ? 'active' : '' }}"
                    href="{{ url('/admin/manage-settings') }}">
                    <i class="fas fa-cog"></i> Pengaturan
                </a>
                <a class="nav-link {{ request()->is('admin/manage-users') ? 'active' : '' }}"
                    href="{{ url('/admin/manage-users') }}">
                    <i class="fas fa-users"></i> Kelola Admin
                </a>
                <a class="nav-link {{ request()->is('admin/reports') ? 'active' : '' }}"
                    href="{{ url('/admin/reports') }}">
                    <i class="fas fa-chart-bar"></i> Laporan
                </a>
                <div class="mt-4"></div>
                <a class="nav-link {{ request()->is('admin/profile') ? 'active' : '' }}"
                    href="{{ url('/admin/profile') }}">
                    <i class="fas fa-user"></i> Profile
                </a>
                <form action="{{ url('/logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-custom mb-4">
                <div class="container-fluid">
                    <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse"
                        data-bs-target="#mobileSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0">Laporan dan Statistik</h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-3 d-none d-md-block">{{ date('d F Y') }}</span>
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                {{ session('username') }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ url('/admin/profile') }}">
                                        <i class="fas fa-user me-2"></i>Profile
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ url('/logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item text-danger border-0 bg-transparent">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Mobile Sidebar -->
            <div class="collapse d-md-none mb-4" id="mobileSidebar">
                <div class="card">
                    <div class="card-body">
                        <nav class="nav flex-column">
                            <a class="nav-link" href="{{ url('/admin/dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                            <a class="nav-link" href="{{ url('/admin/manage-schedule') }}">
                                <i class="fas fa-calendar"></i> Kelola Jadwal
                            </a>
                            <a class="nav-link" href="{{ url('/admin/manage-rooms') }}">
                                <i class="fas fa-door-open"></i> Kelola Ruangan
                            </a>
                            <a class="nav-link" href="{{ url('/admin/manage-semester') }}">
                                <i class="fas fa-calendar-alt"></i> Kelola Semester
                            </a>
                            <a class="nav-link" href="{{ url('/admin/manage-settings') }}">
                                <i class="fas fa-cog"></i> Pengaturan
                            </a>
                            <a class="nav-link" href="{{ url('/admin/manage-users') }}">
                                <i class="fas fa-users"></i> Kelola Admin
                            </a>
                            <a class="nav-link active" href="{{ url('/admin/reports') }}">
                                <i class="fas fa-chart-bar"></i> Laporan
                            </a>
                            <hr>
                            <a class="nav-link" href="{{ url('/admin/profile') }}">
                                <i class="fas fa-user"></i> Profile
                            </a>
                            <form action="{{ url('/logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content-wrapper">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Laporan dan Statistik Sistem</h5>
                            <p class="text-muted mb-0">Analisis dan visualisasi data jadwal kuliah</p>
                        </div>
                    </div>
                </div>

                <!-- Statistik Ringkas -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="stat-card stat-card-primary">
                            <h3><i class="fas fa-calendar-alt"></i></h3>
                            <h4>{{ $stats['total_jadwal'] }}</h4>
                            <p class="mb-0">Total Jadwal</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card stat-card-success">
                            <h3><i class="fas fa-users"></i></h3>
                            <h4>{{ $stats['total_kelas'] }}</h4>
                            <p class="mb-0">Total Kelas</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card stat-card-info">
                            <h3><i class="fas fa-door-open"></i></h3>
                            <h4>{{ $stats['total_ruang_digunakan'] }}</h4>
                            <p class="mb-0">Ruangan Digunakan</p>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="row mb-4">
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-bar me-2"></i>Jadwal per Kelas
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="kelasChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-pie me-2"></i>Jadwal per Hari
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="hariChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Detail -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-table me-2"></i>Data Detail Statistik
                                </h5>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="statTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="kelas-tab" data-bs-toggle="tab"
                                            data-bs-target="#kelas-pane" type="button" role="tab">
                                            <i class="fas fa-users me-2"></i>Per Kelas
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="hari-tab" data-bs-toggle="tab"
                                            data-bs-target="#hari-pane" type="button" role="tab">
                                            <i class="fas fa-calendar-day me-2"></i>Per Hari
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="ruangan-tab" data-bs-toggle="tab"
                                            data-bs-target="#ruangan-pane" type="button" role="tab">
                                            <i class="fas fa-door-open me-2"></i>Per Ruangan
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="aktivitas-tab" data-bs-toggle="tab"
                                            data-bs-target="#aktivitas-pane" type="button" role="tab">
                                            <i class="fas fa-history me-2"></i>Aktivitas User
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="statTabContent">
                                    <div class="tab-pane fade show active" id="kelas-pane" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tableKelas">
                                                <thead>
                                                    <tr>
                                                        <th>Kelas</th>
                                                        <th>Jumlah Jadwal</th>
                                                        <th>Persentase</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalKelas = array_sum(
                                                            array_column($stats['per_kelas'], 'total'),
                                                        );
                                                    @endphp
                                                    @foreach ($stats['per_kelas'] as $item)
                                                        @php
                                                            $percentage =
                                                                $totalKelas > 0
                                                                    ? ($item->total / $totalKelas) * 100
                                                                    : 0;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $item->kelas }}</td>
                                                            <td>{{ $item->total }}</td>
                                                            <td>
                                                                <div class="progress" style="height: 20px;">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        style="width: {{ $percentage }}%;"
                                                                        aria-valuenow="{{ $percentage }}"
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
                                    </div>
                                    <div class="tab-pane fade" id="hari-pane" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tableHari">
                                                <thead>
                                                    <tr>
                                                        <th>Hari</th>
                                                        <th>Jumlah Jadwal</th>
                                                        <th>Persentase</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalHari = array_sum(
                                                            array_column($stats['per_hari'], 'total'),
                                                        );
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
                                                            $percentage =
                                                                $totalHari > 0 ? ($item->total / $totalHari) * 100 : 0;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $item->hari }}</td>
                                                            <td>{{ $item->total }}</td>
                                                            <td>
                                                                <div class="progress" style="height: 20px;">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        style="width: {{ $percentage }}%; background-color: {{ $colors[$item->hari] ?? '#36a2eb' }};"
                                                                        aria-valuenow="{{ $percentage }}"
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
                                    </div>
                                    <div class="tab-pane fade" id="ruangan-pane" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tableRuangan">
                                                <thead>
                                                    <tr>
                                                        <th>Ruangan</th>
                                                        <th>Jumlah Jadwal</th>
                                                        <th>Persentase</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalRuangan = array_sum(
                                                            array_column($stats['per_ruangan'], 'total'),
                                                        );
                                                    @endphp
                                                    @foreach ($stats['per_ruangan'] as $item)
                                                        @php
                                                            $percentage =
                                                                $totalRuangan > 0
                                                                    ? ($item->total / $totalRuangan) * 100
                                                                    : 0;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $item->ruang }}</td>
                                                            <td>{{ $item->total }}</td>
                                                            <td>
                                                                <div class="progress" style="height: 20px;">
                                                                    <div class="progress-bar bg-info"
                                                                        role="progressbar"
                                                                        style="width: {{ $percentage }}%;"
                                                                        aria-valuenow="{{ $percentage }}"
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
                                    </div>
                                    <div class="tab-pane fade" id="aktivitas-pane" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tableAktivitas">
                                                <thead>
                                                    <tr>
                                                        <th>Username</th>
                                                        <th>Jumlah Aktivitas</th>
                                                        <th>Persentase</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalAktivitas = array_sum(
                                                            array_column($stats['aktivitas_user'], 'total'),
                                                        );
                                                    @endphp
                                                    @foreach ($stats['aktivitas_user'] as $item)
                                                        @php
                                                            $percentage =
                                                                $totalAktivitas > 0
                                                                    ? ($item->total / $totalAktivitas) * 100
                                                                    : 0;
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="user-avatar me-2"
                                                                        style="width: 30px; height: 30px; font-size: 0.8rem;">
                                                                        {{ strtoupper(substr($item->username, 0, 1)) }}
                                                                    </div>
                                                                    {{ $item->username }}
                                                                </div>
                                                            </td>
                                                            <td>{{ $item->total }}</td>
                                                            <td>
                                                                <div class="progress" style="height: 20px;">
                                                                    <div class="progress-bar bg-warning"
                                                                        role="progressbar"
                                                                        style="width: {{ $percentage }}%;"
                                                                        aria-valuenow="{{ $percentage }}"
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ekspor Laporan -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-file-export me-2"></i>Ekspor Laporan
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-3 col-md-6 mb-3">
                                        <div class="d-grid gap-2">
                                            <a href="{{ url('/admin/export?type=jadwal') }}" class="btn btn-success">
                                                <i class="fas fa-file-excel me-2"></i>Ekspor Data Jadwal
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-6 mb-3">
                                        <div class="d-grid gap-2">
                                            <a href="{{ url('/admin/export?type=ruangan') }}" class="btn btn-info">
                                                <i class="fas fa-file-excel me-2"></i>Ekspor Data Ruangan
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-6 mb-3">
                                        <div class="d-grid gap-2">
                                            <a href="{{ url('/admin/export?type=aktivitas') }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-file-excel me-2"></i>Ekspor Data Aktivitas
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-6 mb-3">
                                        <div class="d-grid gap-2">
                                            <a href="{{ url('/admin/print-report') }}" target="_blank"
                                                class="btn btn-secondary">
                                                <i class="fas fa-print me-2"></i>Cetak Laporan Lengkap
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Informasi:</strong> Data akan diekspor dalam format Excel (XLSX) dan
                                            dapat diunduh langsung.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('#tableKelas, #tableHari, #tableRuangan, #tableAktivitas').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/id.json"
                },
                "pageLength": 10,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false
            });
        });

        // Chart Jadwal per Kelas
        const kelasCtx = document.getElementById('kelasChart').getContext('2d');
        const kelasLabels = {!! json_encode(array_column($stats['per_kelas'], 'kelas')) !!};
        const kelasData = {!! json_encode(array_column($stats['per_kelas'], 'total')) !!};

        new Chart(kelasCtx, {
            type: 'bar',
            data: {
                labels: kelasLabels,
                datasets: [{
                    label: 'Jumlah Jadwal',
                    data: kelasData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Jadwal: ${context.parsed.y}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Chart Jadwal per Hari
        const hariCtx = document.getElementById('hariChart').getContext('2d');
        const hariLabels = {!! json_encode(array_column($stats['per_hari'], 'hari')) !!};
        const hariData = {!! json_encode(array_column($stats['per_hari'], 'total')) !!};

        new Chart(hariCtx, {
            type: 'doughnut',
            data: {
                labels: hariLabels,
                datasets: [{
                    label: 'Jumlah Jadwal',
                    data: hariData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
