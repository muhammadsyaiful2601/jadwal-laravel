<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Jadwal Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
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

        .maintenance-badge-top {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid #fecaca;
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

        .stat-card-icon.green {
            background: #f0fdf4;
            color: #16a34a;
        }

        .stat-card-icon.amber {
            background: #fffbeb;
            color: #d97706;
        }

        .stat-card-icon.rose {
            background: #fff1f2;
            color: #e11d48;
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
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stat-card-footer small {
            font-size: 0.78rem;
            color: var(--zinc-400);
        }

        .stat-card-footer .pending-badge {
            background: #fef2f2;
            color: #b91c1c;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
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
            background: var(--card-bg);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            padding: 20px 24px;
            margin-bottom: 28px;
            border: 1px solid rgba(0, 0, 0, 0.02);
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
            width: 12px;
            height: 12px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .status-dot.normal {
            background: #22c55e;
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.15);
        }

        .status-dot.maintenance {
            background: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15);
        }

        .system-status-info h5 {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--zinc-800);
            margin-bottom: 2px;
        }

        .system-status-info p {
            font-size: 0.82rem;
            color: var(--zinc-500);
            margin-bottom: 0;
        }

        .system-status-right .btn-maintenance {
            padding: 8px 20px;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Inter', sans-serif;
        }

        .btn-maintenance.primary {
            background: var(--corporate-blue);
            color: white;
        }

        .btn-maintenance.primary:hover {
            background: var(--corporate-blue-hover);
        }

        .btn-maintenance.success {
            background: #16a34a;
            color: white;
        }

        .btn-maintenance.success:hover {
            background: #15803d;
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

        .ip-badge {
            display: inline-block;
            background: var(--zinc-100);
            color: var(--zinc-600);
            font-family: 'SF Mono', 'Fira Code', monospace;
            font-size: 0.78rem;
            padding: 2px 10px;
            border-radius: 6px;
            font-weight: 500;
        }

        /* Quick Actions */
        .quick-actions-card {
            background: var(--card-bg);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0, 0, 0, 0.02);
            margin-bottom: 28px;
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
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            border: 1.5px solid var(--zinc-200);
            background: var(--card-bg);
            color: var(--zinc-700);
            transition: all 0.15s ease;
            font-family: 'Inter', sans-serif;
        }

        .quick-action-btn:hover {
            border-color: var(--corporate-blue);
            color: var(--corporate-blue);
            background: #f8faff;
            transform: translateY(-1px);
        }

        .quick-action-btn.primary-solid {
            background: var(--corporate-blue);
            border-color: var(--corporate-blue);
            color: white;
        }

        .quick-action-btn.primary-solid:hover {
            background: var(--corporate-blue-hover);
            border-color: var(--corporate-blue-hover);
            color: white;
        }

        .quick-action-btn i {
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 1200px) {
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
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total Jadwal</span>
                        <div class="stat-card-icon blue"><i class="fas fa-calendar"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['total_jadwal'] }}</div>
                    <div class="stat-card-footer"><small>Jadwal perkuliahan aktif</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total Ruangan</span>
                        <div class="stat-card-icon green"><i class="fas fa-door-open"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['total_ruangan'] }}</div>
                    <div class="stat-card-footer"><small>Ruang kelas tersedia</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total Kelas</span>
                        <div class="stat-card-icon amber"><i class="fas fa-users"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['total_kelas'] }}</div>
                    <div class="stat-card-footer"><small>Kelas terdaftar</small></div>
                </div>
                <div class="stat-card">
                    <a href="{{ url('/admin/saran') }}" class="stat-card-link">
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
                    </a>
                </div>
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
                        <a href="{{ url('/admin/maintenance') }}"
                            class="btn-maintenance {{ $isMaintenance ? 'success' : 'primary' }}">
                            <i class="fas fa-cog"></i>
                            {{ $isMaintenance ? 'Nonaktifkan Maintenance' : 'Kelola Maintenance' }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="table-card">
                <div class="table-card-header">
                    <h5><i class="fas fa-history"></i> Aktivitas Terbaru</h5>
                    @if (count($activities) > 0)
                        <small style="color:var(--zinc-400); font-size:0.78rem;">{{ count($activities) }} aktivitas
                            tercatat</small>
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
                                            style="text-align:center; color:var(--zinc-400); padding:32px;">
                                            <i class="fas fa-inbox me-2"></i>Belum ada aktivitas tercatat
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="quick-actions-card">
                <div class="table-card-header">
                    <h5><i class="fas fa-bolt"></i> Aksi Cepat</h5>
                </div>
                <div class="quick-actions-body">
                    <div class="quick-actions-grid">
                        <a href="{{ url('/admin/manage-schedule?action=add') }}"
                            class="quick-action-btn primary-solid"><i class="fas fa-plus"></i> Tambah Jadwal</a>
                        <a href="{{ url('/admin/manage-rooms?action=add') }}" class="quick-action-btn"><i
                                class="fas fa-plus"></i> Tambah Ruangan</a>
                        <a href="{{ url('/admin/maintenance') }}" class="quick-action-btn"><i
                                class="fas fa-cog"></i> Maintenance</a>
                        <a href="{{ url('/admin/export') }}" class="quick-action-btn"><i
                                class="fas fa-download"></i> Export Jadwal</a>
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
                    "dom": '<"d-flex justify-content-between align-items-center px-3 py-2 border-bottom border-zinc-100"f>t<"d-flex justify-content-between align-items-center px-3 py-2"ip>',
                    "pagingType": "simple_numbers"
                });
            });
        @endif
    </script>
</body>

</html>
