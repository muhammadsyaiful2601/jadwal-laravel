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
            --canvas-bg: #f1f5f9;
            --card-bg: #ffffff;
            --card-radius: 16px;
            --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.05);
            --card-shadow-hover: 0 4px 16px rgba(0, 0, 0, 0.08);
            --corporate-blue: #1d4ed8;
            --corporate-blue-hover: #1e3a8a;
            --zinc-900: #18181b;
            --zinc-800: #27272a;
            --zinc-700: #3f3f46;
            --zinc-600: #52525b;
            --zinc-500: #71717a;
            --zinc-400: #a1a1aa;
            --zinc-300: #d4d4d8;
            --zinc-200: #e4e4e7;
            --zinc-100: #f4f4f5;
            --zinc-50: #fafafa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--canvas-bg);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 0;
        }

        /* Top Bar */
        .top-bar {
            background: var(--card-bg);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--zinc-100);
            position: sticky;
            top: 0;
            z-index: 500;
        }

        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .top-bar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--zinc-600);
            cursor: pointer;
            padding: 4px;
        }

        .top-bar-left h4 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--zinc-800);
            margin-bottom: 0;
            letter-spacing: -0.3px;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .top-bar-date {
            font-size: 0.85rem;
            color: var(--zinc-500);
            font-weight: 500;
        }

        .top-bar-right .dropdown-toggle {
            background: var(--zinc-50);
            border: 1px solid var(--zinc-200);
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--zinc-700);
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .top-bar-right .dropdown-toggle:hover {
            background: var(--zinc-100);
            border-color: var(--zinc-300);
        }

        .top-bar-right .dropdown-toggle::after {
            display: none;
        }

        .top-bar-right .dropdown-menu {
            border-radius: 12px;
            border: 1px solid var(--zinc-200);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            padding: 6px;
            min-width: 180px;
        }

        .top-bar-right .dropdown-item {
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.85rem;
            color: var(--zinc-700);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-bar-right .dropdown-item:hover {
            background: var(--zinc-50);
        }

        .top-bar-right .dropdown-item.text-danger:hover {
            background: #fef2f2;
        }

        .top-bar-right .dropdown-divider {
            margin: 4px 0;
            border-color: var(--zinc-100);
        }

        .content-wrapper {
            padding: 28px 32px;
        }

        .page-title-section {
            margin-bottom: 28px;
        }

        .page-title-section h4 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--zinc-800);
            margin-bottom: 4px;
            letter-spacing: -0.3px;
        }

        .page-title-section p {
            font-size: 0.88rem;
            color: var(--zinc-500);
            margin-bottom: 0;
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0, 0, 0, 0.02);
            margin-bottom: 20px;
        }

        .card-body {
            padding: 24px;
        }

        /* Table Card */
        .table-card {
            background: var(--card-bg);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0, 0, 0, 0.02);
            margin-bottom: 28px;
        }

        .table-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--zinc-100);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .table-card-header h5 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--zinc-800);
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-card-header h5 i {
            color: var(--zinc-400);
            font-size: 0.9rem;
        }

        .table-card-body {
            padding: 0;
        }

        .table-clean {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .table-clean thead {
            background: var(--zinc-50);
        }

        .table-clean thead th {
            padding: 12px 24px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: var(--zinc-500);
            border-bottom: 1px solid var(--zinc-100);
            text-align: left;
            white-space: nowrap;
        }

        .table-clean tbody tr {
            transition: background 0.12s ease;
        }

        .table-clean tbody tr:hover {
            background: var(--zinc-50);
        }

        .table-clean tbody tr:not(:last-child) td {
            border-bottom: 1px solid var(--zinc-100);
        }

        .table-clean tbody td {
            padding: 12px 24px;
            color: var(--zinc-700);
            font-weight: 400;
            vertical-align: middle;
        }

        .table-clean tbody tr:nth-child(even) {
            background: rgba(0, 0, 0, 0.015);
        }

        .table-clean tbody tr:nth-child(even):hover {
            background: var(--zinc-50);
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
            color: var(--zinc-700);
        }

        .form-select,
        .form-control {
            border: 1px solid var(--zinc-200);
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.875rem;
            color: var(--zinc-800);
            background: white;
        }

        .form-select:focus,
        .form-control:focus {
            outline: none;
            border-color: var(--corporate-blue);
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary-custom {
            background: var(--corporate-blue);
            color: white;
        }

        .btn-primary-custom:hover {
            background: var(--corporate-blue-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(29, 78, 216, 0.15);
        }

        .btn-secondary-custom {
            background: var(--zinc-50);
            color: var(--zinc-700);
            border: 1px solid var(--zinc-200);
        }

        .btn-secondary-custom:hover {
            background: var(--zinc-100);
        }

        .btn-success-custom {
            background: #16a34a;
            color: white;
        }

        .btn-success-custom:hover {
            background: #15803d;
        }

        .export-section {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .top-bar-toggle {
                display: block;
            }

            .top-bar {
                padding: 14px 20px;
            }

            .content-wrapper {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding: 16px;
            }

            .top-bar {
                padding: 12px 16px;
            }

            .top-bar-date {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    @include('components.admin.sidebar')

    <div class="main-content">
        <header class="top-bar">
            <div class="top-bar-left">
                <button class="top-bar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>Laporan</h4>
            </div>
            <div class="top-bar-right">
                <span class="top-bar-date"><i class="far fa-calendar-alt me-1"></i> {{ date('d F Y') }}</span>
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i>
                        {{ session('username') }}
                        <i class="fas fa-chevron-down" style="font-size:0.7rem; opacity:0.6;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ url('/admin/profile') }}"><i class="fas fa-user"></i>
                                Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ url('/logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100"
                                    style="display:flex; align-items:center; gap:10px;">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="content-wrapper">
            <div class="page-title-section">
                <h4>Laporan Jadwal</h4>
                <p>Kelola dan export laporan jadwal kuliah</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert"
                    style="border-radius: 8px;">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-card">
                <div class="table-card-header">
                    <h5><i class="fas fa-filter"></i> Filter Laporan</h5>
                </div>
                <div class="table-card-body">
                    <form method="GET" action="{{ url('/admin/reports') }}" style="padding: 24px;">
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

                    <div style="padding: 0 24px 24px;">
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
            </div>

            <div class="table-card">
                <div class="table-card-header">
                    <h5><i class="fas fa-table"></i> Data Jadwal</h5>
                </div>
                <div class="table-card-body">
                    <div style="overflow-x: auto;">
                        <table class="table-clean">
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
                                        <td colspan="9"
                                            style="text-align:center; color:var(--zinc-400); padding:32px;">
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
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const s = document.getElementById('sidebar');
                const o = document.getElementById('sidebarOverlay');
                if (s.classList.contains('show')) {
                    s.classList.remove('show');
                    o.classList.remove('show');
                }
            }
        });
    </script>
</body>

</html>
