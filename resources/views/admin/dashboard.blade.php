<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Jadwal Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --nb-black: #000000;
            --nb-white: #FFFFFF;
            --nb-offwhite: #F8F7F4;
            --nb-yellow: #FFE66D;
            --nb-red: #FF6B6B;
            --nb-teal: #4ECDC4;
            --nb-pink: #F38181;
            --nb-green: #95E1D3;
            --nb-purple: #A66CFF;
            --nb-orange: #FFB347;
            --nb-blue: #6BB5FF;
            --nb-gray: #E8E8E8;
            --nb-dark: #1A1A2E;
            --nb-border: 3px solid #000;
            --nb-border-thick: 4px solid #000;
            --nb-shadow: 6px 6px 0px #000;
            --nb-shadow-sm: 4px 4px 0px #000;
            --nb-shadow-lg: 8px 8px 0px #000;
            --nb-shadow-hover: 10px 10px 0px #000;
            --nb-radius: 12px;
            --nb-radius-sm: 8px;
            --font-display: 'Space Grotesk', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background: var(--nb-offwhite);
            color: var(--nb-black);
            line-height: 1.6;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 0;
        }

        /* Top Bar */
        .top-bar {
            background: var(--nb-white);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: var(--nb-border);
            position: sticky;
            top: 0;
            z-index: 500;
            box-shadow: var(--nb-shadow-sm);
        }

        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .top-bar-toggle {
            display: none;
            background: var(--nb-white);
            border: var(--nb-border);
            font-size: 1.2rem;
            color: var(--nb-black);
            cursor: pointer;
            padding: 8px 12px;
            border-radius: var(--nb-radius-sm);
            box-shadow: var(--nb-shadow-sm);
            transition: all 0.15s ease;
        }

        .top-bar-toggle:hover {
            background: var(--nb-yellow);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .top-bar-toggle:active {
            transform: translate(2px, 2px);
            box-shadow: none;
        }

        .top-bar-left h4 {
            font-family: var(--font-display);
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 0;
            letter-spacing: -0.3px;
            text-transform: uppercase;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .top-bar-date {
            font-family: var(--font-display);
            font-size: 0.85rem;
            color: var(--nb-dark);
            font-weight: 600;
        }

        .top-bar-right .dropdown-toggle {
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 10px 16px;
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--nb-black);
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
            box-shadow: var(--nb-shadow-sm);
        }

        .top-bar-right .dropdown-toggle:hover {
            background: var(--nb-yellow);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .top-bar-right .dropdown-toggle::after {
            display: none;
        }

        .top-bar-right .dropdown-menu {
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            box-shadow: var(--nb-shadow);
            padding: 8px;
            min-width: 180px;
            background: var(--nb-white);
        }

        .top-bar-right .dropdown-item {
            border-radius: var(--nb-radius-sm);
            padding: 10px 14px;
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--nb-black);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.15s ease;
        }

        .top-bar-right .dropdown-item:hover {
            background: var(--nb-yellow);
            color: var(--nb-black);
        }

        .top-bar-right .dropdown-item.text-danger {
            color: var(--nb-red);
        }

        .top-bar-right .dropdown-item.text-danger:hover {
            background: var(--nb-red);
            color: var(--nb-white);
        }

        .top-bar-right .dropdown-divider {
            margin: 4px 0;
            border-color: var(--nb-gray);
        }

        .maintenance-badge-top {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--nb-red);
            color: var(--nb-white);
            font-family: var(--font-display);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .content-wrapper {
            padding: 28px 32px;
        }

        .page-title-section {
            margin-bottom: 28px;
        }

        .page-title-section h4 {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 6px;
            letter-spacing: -0.3px;
            text-transform: uppercase;
        }

        .page-title-section p {
            font-family: var(--font-body);
            font-size: 0.95rem;
            color: var(--nb-dark);
            margin-bottom: 0;
            font-weight: 500;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--nb-white);
            border-radius: var(--nb-radius);
            box-shadow: var(--nb-shadow);
            padding: 22px 24px;
            transition: all 0.2s ease;
            border: var(--nb-border);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: var(--nb-black);
        }

        .stat-card:nth-child(1)::before {
            background: var(--nb-blue);
        }

        .stat-card:nth-child(2)::before {
            background: var(--nb-green);
        }

        .stat-card:nth-child(3)::before {
            background: var(--nb-orange);
        }

        .stat-card:nth-child(4)::before {
            background: var(--nb-red);
        }

        .stat-card:hover {
            transform: translate(-3px, -3px);
            box-shadow: var(--nb-shadow-hover);
        }

        .stat-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .stat-card-label {
            font-family: var(--font-display);
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--nb-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--nb-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
        }

        .stat-card-icon.blue {
            background: var(--nb-blue);
            color: var(--nb-white);
        }

        .stat-card-icon.green {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .stat-card-icon.amber {
            background: var(--nb-orange);
            color: var(--nb-black);
        }

        .stat-card-icon.rose {
            background: var(--nb-red);
            color: var(--nb-white);
        }

        .stat-card-value {
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--nb-black);
            letter-spacing: -0.5px;
            line-height: 1.2;
            text-shadow: 3px 3px 0 var(--nb-gray);
        }

        .stat-card-footer {
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stat-card-footer small {
            font-family: var(--font-body);
            font-size: 0.78rem;
            color: var(--nb-dark);
            font-weight: 600;
        }

        .pending-badge {
            background: var(--nb-red);
            color: var(--nb-white);
            font-family: var(--font-display);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: var(--nb-radius-sm);
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .stat-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .stat-card-link:hover {
            color: inherit;
        }

        /* System Status */
        .system-status-card {
            background: var(--nb-white);
            border-radius: var(--nb-radius);
            box-shadow: var(--nb-shadow);
            padding: 24px;
            margin-bottom: 28px;
            border: var(--nb-border);
        }

        .system-status-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .system-status-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .status-dot {
            width: 14px;
            height: 14px;
            border-radius: 0;
            flex-shrink: 0;
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
        }

        .status-dot.normal {
            background: var(--nb-green);
        }

        .status-dot.maintenance {
            background: var(--nb-red);
        }

        .system-status-info h5 {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .system-status-info p {
            font-family: var(--font-body);
            font-size: 0.88rem;
            color: var(--nb-dark);
            margin-bottom: 0;
            font-weight: 500;
        }

        .system-status-right .btn-maintenance {
            padding: 10px 20px;
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            border: var(--nb-border);
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-maintenance.primary {
            background: var(--nb-purple);
            color: var(--nb-white);
            border-color: var(--nb-black);
        }

        .btn-maintenance.primary:hover {
            background: var(--nb-pink);
            color: var(--nb-black);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-maintenance.success {
            background: var(--nb-teal);
            color: var(--nb-black);
            border-color: var(--nb-black);
        }

        .btn-maintenance.success:hover {
            background: var(--nb-green);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        /* Table Card */
        .table-card {
            background: var(--nb-white);
            border-radius: var(--nb-radius);
            box-shadow: var(--nb-shadow);
            border: var(--nb-border);
            margin-bottom: 28px;
            overflow: hidden;
        }

        .table-card-header {
            padding: 20px 24px;
            border-bottom: var(--nb-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            background: var(--nb-purple);
        }

        .table-card-header h5 {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: var(--nb-white);
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-card-header h5 i {
            font-size: 1rem;
        }

        .table-card-body {
            padding: 0;
        }

        .table-clean {
            width: 100%;
            border-collapse: collapse;
            font-family: var(--font-body);
            font-size: 0.88rem;
        }

        .table-clean thead {
            background: var(--nb-offwhite);
        }

        .table-clean thead th {
            padding: 14px 24px;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--nb-black);
            border-bottom: var(--nb-border);
            text-align: left;
            white-space: nowrap;
        }

        .table-clean tbody tr {
            transition: all 0.15s ease;
            border-bottom: 1px solid var(--nb-gray);
        }

        .table-clean tbody tr:hover {
            background: var(--nb-yellow);
            transform: scale(1.01);
        }

        .table-clean tbody td {
            padding: 14px 24px;
            color: var(--nb-black);
            font-weight: 500;
            vertical-align: middle;
        }

        .table-clean tbody tr:nth-child(even) {
            background: var(--nb-offwhite);
        }

        .table-clean tbody tr:nth-child(even):hover {
            background: var(--nb-yellow);
        }

        .ip-badge {
            display: inline-block;
            background: var(--nb-dark);
            color: var(--nb-white);
            font-family: 'SF Mono', 'Fira Code', monospace;
            font-size: 0.78rem;
            padding: 4px 12px;
            border-radius: var(--nb-radius-sm);
            font-weight: 600;
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        /* Quick Actions */
        .quick-actions-card {
            background: var(--nb-white);
            border-radius: var(--nb-radius);
            box-shadow: var(--nb-shadow);
            border: var(--nb-border);
            margin-bottom: 28px;
            overflow: hidden;
        }

        .quick-actions-header {
            padding: 16px 24px;
            background: var(--nb-teal);
            border-bottom: var(--nb-border);
        }

        .quick-actions-header h5 {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .quick-actions-body {
            padding: 24px;
        }

        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .quick-action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 16px;
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            border: var(--nb-border);
            background: var(--nb-white);
            color: var(--nb-black);
            transition: all 0.15s ease;
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .quick-action-btn:hover {
            background: var(--nb-yellow);
            transform: translate(-3px, -3px);
            box-shadow: var(--nb-shadow);
            color: var(--nb-black);
        }

        .quick-action-btn.primary-solid {
            background: var(--nb-purple);
            border-color: var(--nb-black);
            color: var(--nb-white);
        }

        .quick-action-btn.primary-solid:hover {
            background: var(--nb-pink);
            color: var(--nb-black);
        }

        .quick-action-btn i {
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 1400px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .quick-actions-grid {
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

            .system-status-bar {
                flex-direction: column;
                align-items: flex-start;
            }

            .quick-actions-grid {
                grid-template-columns: repeat(2, 1fr);
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
                font-size: 1.8rem;
            }

            .stat-card-icon {
                width: 38px;
                height: 38px;
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

            .quick-actions-grid {
                grid-template-columns: 1fr;
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
                <h4>Dashboard</h4>
                @if ($isMaintenance)
                    <span class="maintenance-badge-top"><i class="fas fa-tools"></i> Maintenance Mode</span>
                @endif
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
                <h4>Selamat Datang, {{ session('username') }}</h4>
                <p>Berikut adalah ringkasan sistem informasi jadwal kuliah hari ini.</p>
            </div>

            <div class="stats-grid">
                <a href="{{ url('/admin/manage-schedule') }}" class="stat-card-link">
                    <div class="stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Total Jadwal</span>
                            <div class="stat-card-icon blue"><i class="fas fa-calendar"></i></div>
                        </div>
                        <div class="stat-card-value">{{ $stats['total_jadwal'] }}</div>
                        <div class="stat-card-footer"><small>Jadwal perkuliahan aktif</small></div>
                    </div>
                </a>
                <a href="{{ url('/admin/manage-rooms') }}" class="stat-card-link">
                    <div class="stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Total Ruangan</span>
                            <div class="stat-card-icon green"><i class="fas fa-door-open"></i></div>
                        </div>
                        <div class="stat-card-value">{{ $stats['total_ruangan'] }}</div>
                        <div class="stat-card-footer"><small>Ruang kelas tersedia</small></div>
                    </div>
                </a>
                <a href="{{ url('/admin/manage-schedule') }}" class="stat-card-link">
                    <div class="stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Total Kelas</span>
                            <div class="stat-card-icon amber"><i class="fas fa-users"></i></div>
                        </div>
                        <div class="stat-card-value">{{ $stats['total_kelas'] }}</div>
                        <div class="stat-card-footer"><small>Kelas terdaftar</small></div>
                    </div>
                </a>
                <a href="{{ url('/admin/saran') }}" class="stat-card-link">
                    <div class="stat-card">
                        <div class="stat-card-top">
                            <span class="stat-card-label">Kritik & Saran</span>
                            <div class="stat-card-icon rose"><i class="fas fa-comments"></i></div>
                        </div>
                        <div class="stat-card-value">{{ $stats['total_saran'] }}</div>
                        <div class="stat-card-footer">
                            @if ($stats['pending_saran'] > 0)
                                <span class="pending-badge"><i class="fas fa-circle" style="font-size:0.4rem;"></i>
                                    {{ $stats['pending_saran'] }} baru</span>
                            @else
                                <small>Tidak ada pesan baru</small>
                            @endif
                        </div>
                    </div>
                </a>
            </div>

            <div class="system-status-card">
                <div class="system-status-bar">
                    <div class="system-status-left">
                        <div class="status-dot {{ $isMaintenance ? 'maintenance' : 'normal' }}"></div>
                        <div class="system-status-info">
                            <h5>{{ $isMaintenance ? 'MAINTENANCE MODE' : 'NORMAL MODE' }}</h5>
                            <p>
                                @if ($isMaintenance)
                                    Sistem dalam mode maintenance.
                                @else
                                    Sistem berjalan normal. Semua fitur tersedia.
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="system-status-right">
                        @if ($superadminVerified)
                            <a href="{{ url('/admin/maintenance') }}"
                                class="btn-maintenance {{ $isMaintenance ? 'success' : 'primary' }}">
                                <i class="fas fa-cog"></i>
                                {{ $isMaintenance ? 'Nonaktifkan Maintenance' : 'Kelola Maintenance' }}
                            </a>
                        @else
                            <span class="btn-maintenance {{ $isMaintenance ? 'success' : 'primary' }}"
                                style="opacity: 0.4; cursor: not-allowed; pointer-events: none;"
                                title="Verifikasi email terlebih dahulu">
                                <i class="fas fa-cog"></i>
                                {{ $isMaintenance ? 'Nonaktifkan Maintenance' : 'Kelola Maintenance' }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="table-card">
                <div class="table-card-header">
                    <h5><i class="fas fa-history"></i> Aktivitas Terbaru</h5>
                    @if (count($activities) > 0)
                        <small style="color:var(--nb-white); font-size:0.78rem; opacity:0.9;">{{ count($activities) }}
                            aktivitas tercatat</small>
                    @endif
                </div>
                <div class="table-card-body">
                    <div style="overflow-x: auto;">
                        <table class="table-clean" id="activitiesTable">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>User</th>
                                    <th>Aksi</th>
                                    <th>IP Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activities as $activity)
                                    <tr>
                                        <td>{{ $activity->created_at ?? '' }}</td>
                                        <td>{{ $activity->username ?? '' }}</td>
                                        <td>{{ $activity->action ?? '' }}</td>
                                        <td><span class="ip-badge">{{ $activity->ip_address ?? '' }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            style="text-align:center; color:var(--nb-dark); padding:32px; font-weight:600;">
                                            <i class="fas fa-inbox me-2"></i> Belum ada aktivitas tercatat
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
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
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
        @if (count($activities) > 0)
            $(document).ready(function() {
                $('#activitiesTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/id.json"
                    },
                    "order": [
                        [0, 'asc']
                    ],
                    "pageLength": 10,
                    "lengthChange": false,
                    "searching": false,
                    "info": false,
                    "dom": '<"d-flex justify-content-between align-items-center px-3 py-2 border-bottom border-nb-gray"f>t<"d-flex justify-content-between align-items-center px-3 py-2"ip>',
                    "pagingType": "simple_numbers"
                });
            });
        @endif
    </script>
</body>

</html>
