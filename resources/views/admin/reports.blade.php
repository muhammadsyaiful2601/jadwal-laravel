<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-hover: rgba(255, 255, 255, 0.06);
            --sidebar-active: rgba(255, 255, 255, 0.12);
            --canvas-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --border-subtle: #e2e8f0;
            --border-light: #f1f5f9;
            --accent: #2563eb;
            --accent-light: #dbeafe;
            --success-light: #d1fae5;
            --success-text: #059669;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--canvas-bg);
            color: var(--text-primary);
            line-height: 1.6;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-header-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .page-header-subtitle {
            font-size: 0.9375rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .card {
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-subtle);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            margin-bottom: 20px;
        }

        .card-body {
            padding: 24px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary-custom {
            background: var(--accent);
            color: white;
        }

        .btn-primary-custom:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }

        .btn-secondary-custom {
            background: var(--canvas-bg);
            color: var(--text-secondary);
            border: 1px solid var(--border-subtle);
        }

        .btn-secondary-custom:hover {
            background: var(--border-light);
        }

        .btn-success-custom {
            background: #059669;
            color: white;
        }

        .btn-success-custom:hover {
            background: #047857;
        }

        .filter-section {
            display: flex;
            gap: 12px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-group label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .form-select,
        .form-control {
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.875rem;
            color: var(--text-primary);
            background: white;
        }

        .form-select:focus,
        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .table {
            width: 100%;
            margin-bottom: 0;
        }

        .table thead th {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 12px 16px;
            background: var(--canvas-bg);
            border-bottom: 1px solid var(--border-subtle);
            border-top: none;
        }

        .table tbody td {
            padding: 16px;
            font-size: 0.875rem;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: var(--canvas-bg);
        }

        .badge {
            font-size: 0.6875rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .badge-scheduled {
            background: var(--accent-light);
            color: var(--accent);
        }

        .badge-completed {
            background: var(--success-light);
            color: var(--success-text);
        }

        .export-section {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 10px;
            }

            .filter-section {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>

<body>
    @include('components.admin.sidebar')

    <div class="main-content">
        <!-- Mobile Sidebar -->
        <div class="collapse d-md-none mb-4" id="mobileSidebar">
            <div class="card">
                <div class="card-body p-3">
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ url('/admin/dashboard') }}"><i class="fas fa-tachometer-alt"></i>
                            Dashboard</a>
                        <a class="nav-link" href="{{ url('/admin/manage-schedule') }}"><i class="fas fa-calendar"></i>
                            Kelola Jadwal</a>
                        <a class="nav-link" href="{{ url('/admin/manage-rooms') }}"><i class="fas fa-door-open"></i>
                            Kelola Ruangan</a>
                        <a class="nav-link" href="{{ url('/admin/manage-semester') }}"><i
                                class="fas fa-calendar-alt"></i> Kelola Semester</a>
                        <a class="nav-link" href="{{ url('/admin/manage-settings') }}"><i class="fas fa-cog"></i>
                            Pengaturan</a>
                        <a class="nav-link" href="{{ url('/admin/manage-users') }}"><i class="fas fa-users"></i> Kelola
                            Admin</a>
                        <a class="nav-link active" href="{{ url('/admin/reports') }}"><i class="fas fa-chart-bar"></i>
                            Laporan</a>
                        <a class="nav-link" href="{{ url('/admin/saran') }}"><i class="fas fa-comments"></i> Kritik &
                            Saran</a>
                        <a class="nav-link" href="{{ url('/admin/maintenance') }}"><i class="fas fa-tools"></i>
                            Maintenance</a>
                        <hr>
                        <a class="nav-link" href="{{ url('/admin/profile') }}"><i class="fas fa-user"></i> Profile</a>
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

        <!-- Top Bar -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <button class="btn btn-light d-md-none me-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#mobileSidebar">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h4 class="d-inline">Laporan</h4>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="text-muted"><i class="far fa-calendar-alt me-1"></i> {{ date('d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-header">
            <h1 class="page-header-title">Laporan Jadwal</h1>
            <p class="page-header-subtitle">Kelola dan export laporan jadwal kuliah</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert"
                style="border-radius: 8px;">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem;">Filter Laporan</h5>
                <form method="GET" action="{{ url('/admin/reports') }}">
                    <div class="filter-section">
                        <div class="filter-group">
                            <label>Kelas</label>
                            <select name="prodi" class="form-select">
                                <option value="">Semua Kelas</option>
                                @foreach ($prodis as $kelas)
                                    <option value="{{ $kelas }}"
                                        {{ request('prodi') == $kelas ? 'selected' : '' }}>
                                        {{ $kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Semester</label>
                            <select name="semester_id" class="form-select">
                                <option value="">Semua Semester</option>
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->id }}"
                                        {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->tahun_akademik }} - {{ ucfirst($semester->semester) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-filter me-1"></i> Terapkan Filter
                        </button>
                    </div>
                </form>

                <div class="export-section">
                    <a href="{{ url('/admin/reports/export?format=pdf' . (request('prodi') ? '&prodi=' . request('prodi') : '') . (request('semester_id') ? '&semester_id=' . request('semester_id') : '')) }}"
                        class="btn btn-danger">
                        <i class="fas fa-file-pdf me-1"></i> Export PDF
                    </a>
                    <a href="{{ url('/admin/reports/export?format=excel' . (request('prodi') ? '&prodi=' . request('prodi') : '') . (request('semester_id') ? '&semester_id=' . request('semester_id') : '')) }}"
                        class="btn btn-success-custom">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </a>
                    <button onclick="window.print()" class="btn btn-secondary-custom">
                        <i class="fas fa-print me-1"></i> Print
                    </button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
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
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @forelse($schedules as $schedule)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $schedule->kelas }}</td>
                                    <td>{{ $schedule->hari }}</td>
                                    <td>{{ $schedule->jam_ke }}</td>
                                    <td>{{ $schedule->waktu }}</td>
                                    <td>{{ $schedule->mata_kuliah }}</td>
                                    <td>{{ $schedule->dosen }}</td>
                                    <td>{{ $schedule->ruang }}</td>
                                    <td>{{ $schedule->semester }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox me-2"></i>Tidak ada data jadwal
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
