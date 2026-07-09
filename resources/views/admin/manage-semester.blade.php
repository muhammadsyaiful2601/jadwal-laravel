<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Semester - Admin Panel</title>
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

        /* Content */
        .content-wrapper {
            padding: 28px 32px;
        }

        .page-title-section {
            margin-bottom: 24px;
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

        /* Actions Bar */
        .actions-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            background: var(--card-bg);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            padding: 18px 24px;
            margin-bottom: 24px;
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .btn-primary-solid {
            padding: 10px 22px;
            background: var(--corporate-blue);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary-solid:hover {
            background: var(--corporate-blue-hover);
            color: white;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            padding: 22px 24px;
            transition: all 0.2s ease;
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .stat-card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-2px);
        }

        .stat-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .stat-card-label {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--zinc-500);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .stat-card-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .stat-card-icon.blue {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .stat-card-icon.emerald {
            background: #ecfdf5;
            color: #059669;
        }

        .stat-card-icon.amber {
            background: #fffbeb;
            color: #d97706;
        }

        .stat-card-icon.purple {
            background: #f5f3ff;
            color: #7c3aed;
        }

        .stat-card-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--zinc-900);
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .stat-card-footer {
            margin-top: 8px;
        }

        .stat-card-footer small {
            font-size: 0.78rem;
            color: var(--zinc-400);
        }

        /* Active Semester Status Bar */
        .status-bar-card {
            background: var(--card-bg);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            padding: 0;
            margin-bottom: 28px;
            border: 1px solid rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        .status-bar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            padding: 20px 24px;
            border-left: 6px solid var(--corporate-blue);
        }

        .status-bar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .status-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: #eff6ff;
            color: var(--corporate-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .status-info h5 {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--zinc-500);
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .status-info h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--zinc-800);
            margin-bottom: 2px;
        }

        .status-info small {
            font-size: 0.78rem;
            color: var(--zinc-400);
        }

        .status-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 6px 18px;
            border-radius: 20px;
        }

        /* Semester Cards Grid */
        .semester-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .semester-item {
            background: var(--card-bg);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            padding: 24px;
            border: 1px solid var(--zinc-100);
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
        }

        .semester-item:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-2px);
        }

        .semester-item.active {
            border-color: #bfdbfe;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.05), inset 0 0 0 1px var(--corporate-blue);
        }

        .semester-item-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .semester-item-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--zinc-800);
            margin-bottom: 2px;
        }

        .semester-item-sub {
            font-size: 0.88rem;
            color: var(--zinc-500);
            font-weight: 400;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 4px 14px;
            border-radius: 20px;
        }

        .badge-status.active {
            background: #ecfdf5;
            color: #059669;
        }

        .badge-status.inactive {
            background: var(--zinc-100);
            color: var(--zinc-500);
        }

        .semester-item-stats {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: var(--zinc-50);
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .semester-item-stats i {
            color: var(--zinc-400);
            font-size: 0.95rem;
        }

        .semester-item-stats .stat-text {
            font-size: 0.85rem;
        }

        .semester-item-stats .stat-text strong {
            color: var(--zinc-800);
            font-weight: 600;
        }

        .semester-item-stats .stat-text small {
            color: var(--zinc-400);
            display: block;
            font-size: 0.75rem;
        }

        .semester-item-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .btn-outline-sm {
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            border: 1.5px solid var(--zinc-200);
            background: var(--card-bg);
            color: var(--zinc-700);
        }

        .btn-outline-sm:hover {
            border-color: var(--corporate-blue);
            color: var(--corporate-blue);
            background: #f8faff;
        }

        .btn-outline-sm.success {
            border-color: #bbf7d0;
            color: #16a34a;
            background: var(--card-bg);
        }

        .btn-outline-sm.success:hover {
            background: #f0fdf4;
            border-color: #86efac;
        }

        .btn-outline-sm.danger {
            border-color: #fca5a5;
            color: #dc2626;
            background: var(--card-bg);
        }

        .btn-outline-sm.danger:hover {
            background: #fef2f2;
            border-color: #f87171;
        }

        .btn-outline-sm:disabled {
            opacity: 0.5;
            cursor: default;
        }

        /* Info Box */
        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 28px;
        }

        .info-box h6 {
            font-size: 0.88rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-box ul {
            margin-bottom: 0;
            padding-left: 20px;
            font-size: 0.82rem;
            color: #1e40af;
        }

        .info-box ul li {
            margin-bottom: 4px;
        }

        /* Alert flash */
        .alert-flash {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.88rem;
        }

        .alert-flash.success {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .alert-flash.error {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        /* Modal */
        .modal-content-modern {
            border-radius: 16px;
            border: none;
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
        }

        .modal-header-modern {
            padding: 20px 24px;
            border-bottom: 1px solid var(--zinc-100);
        }

        .modal-body-modern {
            padding: 24px;
        }

        .modal-footer-modern {
            padding: 16px 24px;
            border-top: 1px solid var(--zinc-100);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .semester-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

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

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }

            .semester-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .status-bar-inner {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-card-value {
                font-size: 1.5rem;
            }

            .stat-card-icon {
                width: 36px;
                height: 36px;
                font-size: 1rem;
            }

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
    <div id="notification-container">
        @if (session('success'))
            <div class="alert-flash success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert-flash error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
    </div>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    @include('components.admin.sidebar')

    <div class="main-content">
        <header class="top-bar">
            <div class="top-bar-left">
                <button class="top-bar-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
                <h4>Kelola Semester</h4>
                @if ($isMaintenance ?? false)
                    <span
                        style="display:inline-flex;align-items:center;gap:6px;background:#fef2f2;color:#b91c1c;font-size:0.75rem;font-weight:600;padding:4px 12px;border-radius:20px;border:1px solid #fecaca;">
                        <i class="fas fa-tools"></i> Maintenance
                    </span>
                @endif
            </div>
            <div class="top-bar-right">
                <span class="top-bar-date"><i class="far fa-calendar-alt me-1"></i> {{ date('d F Y') }}</span>
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i> {{ session('username') }}
                        <i class="fas fa-chevron-down" style="font-size:0.7rem; opacity:0.6;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ url('/admin/dashboard') }}"><i
                                    class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/profile') }}"><i class="fas fa-user"></i>
                                Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ url('/logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100"
                                    style="display:flex;align-items:center;gap:10px;">
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
                <h4>Kelola Semester</h4>
                <p>Atur dan kelola semester akademik</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total Semester</span>
                        <div class="stat-card-icon blue"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $semesters->count() }}</div>
                    <div class="stat-card-footer"><small>Semester terdaftar</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Semester Aktif</span>
                        <div class="stat-card-icon emerald"><i class="fas fa-check-circle"></i></div>
                    </div>
                    <div class="stat-card-value">1</div>
                    <div class="stat-card-footer"><small>Sedang berjalan</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Jadwal Aktif</span>
                        <div class="stat-card-icon amber"><i class="fas fa-calendar-check"></i></div>
                    </div>
                    <div class="stat-card-value">
                        @php
                            $activeSchedules = 0;
                            if ($activeSemester) {
                                $activeSchedules = DB::table('schedules')
                                    ->where('tahun_akademik', $activeSemester->tahun_akademik)
                                    ->where('semester', $activeSemester->semester)
                                    ->count();
                            }
                            echo $activeSchedules;
                        @endphp
                    </div>
                    <div class="stat-card-footer"><small>Kuliah semester ini</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Sedang Aktif</span>
                        <div class="stat-card-icon purple"><i class="fas fa-clock"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $semesters->where('is_active', true)->count() }}</div>
                    <div class="stat-card-footer"><small>Semester berjalan</small></div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="actions-bar">
                <div style="font-size:0.88rem;color:var(--zinc-600);">
                    <strong style="color:var(--zinc-800);">{{ $semesters->count() }}</strong> semester akademik
                </div>
                <button class="btn-primary-solid" data-bs-toggle="modal" data-bs-target="#addSemesterModal">
                    <i class="fas fa-plus"></i> Tambah Semester
                </button>
            </div>

            <!-- Active Semester Status Bar -->
            @if ($activeSemester)
                <div class="status-bar-card">
                    <div class="status-bar-inner">
                        <div class="status-bar-left">
                            <div class="status-icon"><i class="fas fa-star"></i></div>
                            <div class="status-info">
                                <h5>Semester Aktif</h5>
                                <h3>{{ $activeSemester->semester }} - {{ $activeSemester->tahun_akademik }}</h3>
                                <small>Semester yang ditampilkan di halaman utama</small>
                            </div>
                        </div>
                        <div class="status-badge-pill">
                            <i class="fas fa-calendar-check"></i>
                            @php
                                $jumlah_jadwal = DB::table('schedules')
                                    ->where('tahun_akademik', $activeSemester->tahun_akademik)
                                    ->where('semester', $activeSemester->semester)
                                    ->count();
                                echo $jumlah_jadwal . ' Jadwal';
                            @endphp
                        </div>
                    </div>
                </div>
            @endif

            <!-- Semester Cards -->
            @if ($semesters->count() > 0)
                <div class="semester-grid">
                    @foreach ($semesters as $semester)
                        @php
                            $jumlah_jadwal = DB::table('schedules')
                                ->where('tahun_akademik', $semester->tahun_akademik)
                                ->where('semester', $semester->semester)
                                ->count();
                        @endphp
                        <div class="semester-item {{ $semester->is_active ? 'active' : '' }}">
                            <div class="semester-item-top">
                                <div>
                                    <div class="semester-item-title">{{ $semester->semester }}</div>
                                    <div class="semester-item-sub">{{ $semester->tahun_akademik }}</div>
                                </div>
                                <span class="badge-status {{ $semester->is_active ? 'active' : 'inactive' }}">
                                    @if ($semester->is_active)
                                        <i class="fas fa-check-circle" style="font-size:0.65rem;"></i>
                                    @endif
                                    {{ $semester->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>

                            <div class="semester-item-stats">
                                <i class="fas fa-calendar-check"></i>
                                <div class="stat-text">
                                    <strong>{{ $jumlah_jadwal }} jadwal</strong>
                                    <small>Kuliah terdaftar</small>
                                </div>
                            </div>

                            <div class="semester-item-actions">
                                @if (!$semester->is_active)
                                    <form method="POST"
                                        action="{{ url('/admin/manage-semester/set-active/' . $semester->id) }}"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-outline-sm success">
                                            <i class="fas fa-check"></i> Set Aktif
                                        </button>
                                    </form>
                                    <a href="{{ url('/admin/manage-semester/delete/' . $semester->id) }}"
                                        class="btn-outline-sm danger"
                                        onclick="return confirm('Yakin hapus semester {{ $semester->semester }} {{ $semester->tahun_akademik }}?')">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                @else
                                    <span class="btn-outline-sm success" style="opacity:0.8;cursor:default;">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert-flash" style="background:#eff6ff;color:#1e40af;border-left:4px solid #3b82f6;">
                    <i class="fas fa-info-circle"></i> Belum ada data semester. Silakan tambah semester baru.
                </div>
            @endif

            <!-- Info Box -->
            <div class="info-box">
                <h6><i class="fas fa-info-circle"></i> Informasi Semester</h6>
                <ul>
                    <li>Hanya satu semester yang dapat aktif pada satu waktu</li>
                    <li>Semester yang aktif akan ditampilkan di halaman utama</li>
                    <li>Jadwal kuliah akan difilter berdasarkan semester aktif</li>
                    <li>Pastikan jadwal sudah dimasukkan untuk semester yang akan diaktifkan</li>
                    <li>Semester aktif tidak dapat dihapus</li>
                    <li>Semester yang sudah dihapus tidak dapat dikembalikan</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Add Semester Modal -->
    <div class="modal fade" id="addSemesterModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-modern">
                <form method="POST" action="{{ url('/admin/manage-semester/store') }}">
                    @csrf
                    <div class="modal-header-modern d-flex align-items-center justify-content-between">
                        <h5 class="modal-title" style="font-weight:700;font-size:1rem;">
                            <i class="fas fa-plus me-2" style="color:var(--corporate-blue);"></i> Tambah Semester Baru
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body-modern">
                        <div class="mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Tahun
                                Akademik</label>
                            <input type="text" class="form-control" id="tahun_akademik" name="tahun_akademik"
                                required placeholder="Contoh: 2024/2025" pattern="\d{4}/\d{4}"
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                            <small
                                style="color:var(--zinc-400);font-size:0.78rem;margin-top:4px;display:block;">Format:
                                YYYY/YYYY</small>
                        </div>
                        <div class="mb-3">
                            <label
                                style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Semester</label>
                            <select class="form-control" id="semester" name="semester" required
                                style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                                <option value="GANJIL">GANJIL</option>
                                <option value="GENAP">GENAP</option>
                            </select>
                        </div>
                        <div
                            style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:14px;font-size:0.82rem;color:#92400e;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Pastikan jadwal sudah dimasukkan untuk semester ini sebelum mengaktifkannya
                        </div>
                    </div>
                    <div class="modal-footer-modern">
                        <button type="button" class="btn-outline-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="add_semester" class="btn-primary-solid"
                            style="padding:8px 20px;">
                            <i class="fas fa-save"></i> Simpan Semester
                        </button>
                    </div>
                </form>
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

        // Auto-generate tahun akademik
        document.addEventListener('DOMContentLoaded', function() {
            const tahunInput = document.getElementById('tahun_akademik');
            if (tahunInput && !tahunInput.value) {
                const y = new Date().getFullYear();
                tahunInput.value = `${y}/${y + 1}`;
            }
            if (tahunInput) {
                tahunInput.addEventListener('input', function(e) {
                    let v = e.target.value.replace(/\D/g, '');
                    if (v.length > 4) v = v.substring(0, 4) + '/' + v.substring(4, 8);
                    e.target.value = v;
                });
            }
            // Auto-hide notifications
            setTimeout(function() {
                const c = document.getElementById('notification-container');
                if (c) {
                    c.style.transition = 'opacity 0.5s ease';
                    c.style.opacity = '0';
                    setTimeout(() => {
                        c.style.display = 'none';
                    }, 500);
                }
            }, 5000);
        });
    </script>
</body>

</html>
