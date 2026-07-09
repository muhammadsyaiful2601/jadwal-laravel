@php
    $pageTitle = 'Kritik & Saran - Admin';
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kritik & Saran - Admin</title>
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

        .stat-card-icon.total {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .stat-card-icon.pending {
            background: #fffbeb;
            color: #d97706;
        }

        .stat-card-icon.read {
            background: #f0fdf4;
            color: #16a34a;
        }

        .stat-card-icon.responded {
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

        /* Filter Bar */
        .filter-card {
            background: var(--card-bg);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            padding: 20px 24px;
            margin-bottom: 24px;
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .filter-inline {
            display: flex;
            align-items: flex-end;
            gap: 16px;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-group label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--zinc-600);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .filter-group select,
        .filter-group input {
            padding: 10px 14px;
            border: 1.5px solid var(--zinc-200);
            border-radius: 10px;
            font-size: 0.85rem;
            font-family: 'Inter', sans-serif;
            color: var(--zinc-700);
            background: var(--card-bg);
            outline: none;
            transition: all 0.15s ease;
            min-width: 180px;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            border-color: var(--corporate-blue);
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
        }

        .btn-filter {
            padding: 10px 24px;
            background: var(--corporate-blue);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .btn-filter:hover {
            background: var(--corporate-blue-hover);
        }

        /* Superadmin Alert */
        .superadmin-alert {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 18px 22px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .superadmin-alert-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .superadmin-alert-left .alert-icon {
            width: 40px;
            height: 40px;
            background: #fef3c7;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #d97706;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .superadmin-alert-left h6 {
            font-size: 0.88rem;
            font-weight: 600;
            color: #92400e;
            margin-bottom: 2px;
        }

        .superadmin-alert-left p {
            font-size: 0.8rem;
            color: #a16207;
            margin-bottom: 0;
        }

        .btn-destructive {
            padding: 8px 18px;
            border: 1.5px solid #fca5a5;
            background: #fef2f2;
            color: #b91c1c;
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

        .btn-destructive:hover {
            background: #fee2e2;
            border-color: #f87171;
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
            padding: 12px 20px;
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
            transition: background 0.15s ease;
            cursor: pointer;
        }

        .table-clean tbody tr:hover {
            background: var(--zinc-50);
        }

        .table-clean tbody tr:not(:last-child) td {
            border-bottom: 1px solid var(--zinc-100);
        }

        .table-clean tbody td {
            padding: 14px 20px;
            color: var(--zinc-700);
            font-weight: 400;
            vertical-align: middle;
        }

        /* Sender Name */
        .sender-name {
            font-weight: 600;
            color: var(--zinc-900);
            font-size: 0.9rem;
        }

        .sender-email {
            font-size: 0.78rem;
            color: var(--zinc-400);
            display: block;
            margin-top: 2px;
        }

        /* New Badge */
        .badge-new {
            display: inline-block;
            background: #ffe4e6;
            color: #be123c;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 20px;
            margin-left: 8px;
            vertical-align: middle;
            letter-spacing: 0.2px;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-badge.pending {
            background: #fffbeb;
            color: #92400e;
        }

        .status-badge.read {
            background: #f0fdf4;
            color: #166534;
        }

        .status-badge.responded {
            background: #f5f3ff;
            color: #6d28d9;
        }

        /* Action Buttons */
        .action-group {
            display: flex;
            gap: 6px;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1.5px solid var(--zinc-200);
            background: var(--card-bg);
            color: var(--zinc-500);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .action-btn:hover {
            border-color: var(--corporate-blue);
            color: var(--corporate-blue);
            background: #f8faff;
        }

        .action-btn.danger {
            border-color: var(--zinc-200);
            color: var(--zinc-500);
        }

        .action-btn.danger:hover {
            border-color: #fca5a5;
            color: #dc2626;
            background: #fef2f2;
        }

        /* Message Cell */
        .message-cell {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--zinc-500);
            font-size: 0.82rem;
        }

        .date-cell {
            white-space: nowrap;
            color: var(--zinc-500);
            font-size: 0.82rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--zinc-300);
            margin-bottom: 16px;
            display: block;
        }

        .empty-state h5 {
            font-weight: 600;
            color: var(--zinc-600);
            margin-bottom: 6px;
        }

        .empty-state p {
            color: var(--zinc-400);
            font-size: 0.88rem;
            margin-bottom: 0;
        }

        /* Pagination */
        .pagination-modern {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 16px 24px;
            border-top: 1px solid var(--zinc-100);
        }

        .pagination-modern .page-item {
            list-style: none;
        }

        .pagination-modern .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1.5px solid var(--zinc-200);
            background: var(--card-bg);
            color: var(--zinc-600);
            font-size: 0.82rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s ease;
            font-family: 'Inter', sans-serif;
        }

        .pagination-modern .page-link:hover {
            border-color: var(--corporate-blue);
            color: var(--corporate-blue);
            background: #f8faff;
        }

        .pagination-modern .page-item.active .page-link {
            background: var(--corporate-blue);
            border-color: var(--corporate-blue);
            color: white;
        }

        .pagination-modern .page-item.disabled .page-link {
            opacity: 0.4;
            pointer-events: none;
        }

        .pagination-info {
            font-size: 0.78rem;
            color: var(--zinc-400);
            margin-left: 12px;
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

        /* Notification */
        #notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .notification-modern {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            min-width: 320px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notification-modern.success {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .notification-modern.error {
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
        }

        .confirmation-display {
            background: #fef2f2;
            border: 2px dashed #fca5a5;
            border-radius: 10px;
            padding: 16px;
            text-align: center;
            margin-bottom: 16px;
        }

        .confirmation-display code {
            font-size: 1.2rem;
            font-weight: 700;
            color: #dc2626;
            letter-spacing: 2px;
            font-family: 'SF Mono', 'Fira Code', monospace;
        }

        .input-confirm {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--zinc-200);
            border-radius: 10px;
            font-size: 0.85rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: all 0.15s ease;
        }

        .input-confirm:focus {
            border-color: var(--corporate-blue);
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
        }

        .input-confirm.is-valid {
            border-color: #22c55e;
            background: #f0fdf4;
        }

        .input-confirm.is-invalid {
            border-color: #ef4444;
            background: #fef2f2;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid {
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

            .filter-inline {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group select,
            .filter-group input {
                min-width: auto;
                width: 100%;
            }

            .superadmin-alert {
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

            .message-cell {
                max-width: 100px;
            }
        }
    </style>
</head>

<body>
    <div id="notification-container">
        @if (session('success'))
            <div class="notification-modern success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="margin-left:auto;"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="notification-modern error alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="margin-left:auto;"></button>
            </div>
        @endif
    </div>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    @include('components.admin.sidebar')

    <div class="main-content">
        <header class="top-bar">
            <div class="top-bar-left">
                <button class="top-bar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>Kritik & Saran</h4>
            </div>
            <div class="top-bar-right">
                <span class="top-bar-date"><i class="far fa-calendar-alt me-1"></i> {{ date('d F Y') }}</span>
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i>
                        {{ $currentUsername }}
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
                <h4>Kritik & Saran</h4>
                <p>Kelola kritik dan saran dari pengguna</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total</span>
                        <div class="stat-card-icon total"><i class="fas fa-comments"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['total'] }}</div>
                    <div class="stat-card-footer"><small>Total masukan</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Pending</span>
                        <div class="stat-card-icon pending"><i class="fas fa-clock"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['pending'] }}</div>
                    <div class="stat-card-footer"><small>Menunggu ditinjau</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Sudah Dibaca</span>
                        <div class="stat-card-icon read"><i class="fas fa-check-circle"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['read_count'] }}</div>
                    <div class="stat-card-footer"><small>Telah ditinjau</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Ditanggapi</span>
                        <div class="stat-card-icon responded"><i class="fas fa-reply"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['responded'] }}</div>
                    <div class="stat-card-footer"><small>Sudah direspons</small></div>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="filter-card">
                <form method="GET" class="filter-inline">
                    <div class="filter-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="read" {{ $status === 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                            <option value="responded" {{ $status === 'responded' ? 'selected' : '' }}>Ditanggapi
                            </option>
                        </select>
                    </div>
                    <div class="filter-group" style="flex:1; min-width:200px;">
                        <label>Cari</label>
                        <input type="text" name="search" placeholder="Cari nama, email, atau pesan..."
                            value="{{ $search }}">
                    </div>
                    <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Filter</button>
                </form>
            </div>

            <!-- Superadmin Alert -->
            @if ($currentUserRole === 'superadmin' && $totalSuggestions > 0)
                <div class="superadmin-alert">
                    <div class="superadmin-alert-left">
                        <div class="alert-icon"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <h6>Superadmin Action</h6>
                            <p>Anda dapat menghapus semua {{ $totalSuggestions }} data kritik & saran sekaligus.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-destructive" data-bs-toggle="modal"
                        data-bs-target="#deleteAllModal">
                        <i class="fas fa-trash-alt"></i> Hapus Semua Data
                    </button>
                </div>
            @endif

            <!-- Suggestions Table -->
            <div class="table-card">
                <div class="table-card-header">
                    <h5><i class="fas fa-list"></i> Daftar Kritik & Saran</h5>
                    @if ($totalSuggestions > 0)
                        <small style="color:var(--zinc-400); font-size:0.78rem;">
                            Halaman {{ $page }} dari {{ $totalPages }}
                        </small>
                    @endif
                </div>
                <div class="table-card-body">
                    @if (empty($suggestions))
                        <div class="empty-state">
                            <i class="fas fa-comments"></i>
                            <h5>Tidak ada kritik dan saran</h5>
                            <p>Belum ada kritik dan saran yang masuk</p>
                        </div>
                    @else
                        <div style="overflow-x: auto;">
                            <table class="table-clean">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="18%">Pengirim</th>
                                        <th width="22%">Pesan</th>
                                        <th width="12%">Status</th>
                                        <th width="15%">Tanggal</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suggestions as $index => $suggestion)
                                        @php
                                            $isUnread = $suggestion->status === 'pending';
                                            $message = e($suggestion->message);
                                            $messagePreview =
                                                strlen($message) > 60 ? substr($message, 0, 60) . '...' : $message;
                                        @endphp
                                        <tr onclick="openDetail({{ $suggestion->id }})"
                                            data-id="{{ $suggestion->id }}">
                                            <td style="color:var(--zinc-400); font-size:0.82rem;">
                                                {{ $offset + $index + 1 }}</td>
                                            <td>
                                                <span class="sender-name">
                                                    {{ e($suggestion->name) }}
                                                    @if ($isUnread)
                                                        <span class="badge-new">BARU</span>
                                                    @endif
                                                </span>
                                                <span
                                                    class="sender-email">{{ $suggestion->email ?: 'Tidak ada email' }}</span>
                                            </td>
                                            <td>
                                                <div class="message-cell" title="{{ $message }}">
                                                    {{ $messagePreview }}</div>
                                            </td>
                                            <td>
                                                @php
                                                    $statusText = [
                                                        'pending' => 'Pending',
                                                        'read' => 'Sudah Dibaca',
                                                        'responded' => 'Ditanggapi',
                                                    ];
                                                @endphp
                                                <span class="status-badge {{ $suggestion->status }}">
                                                    @if ($suggestion->status === 'pending')
                                                        <i class="fas fa-clock" style="font-size:0.65rem;"></i>
                                                    @elseif($suggestion->status === 'read')
                                                        <i class="fas fa-check" style="font-size:0.65rem;"></i>
                                                    @else
                                                        <i class="fas fa-reply" style="font-size:0.65rem;"></i>
                                                    @endif
                                                    {{ $statusText[$suggestion->status] }}
                                                </span>
                                            </td>
                                            <td><span
                                                    class="date-cell">{{ date('d/m/Y H:i', strtotime($suggestion->created_at)) }}</span>
                                            </td>
                                            <td>
                                                <div class="action-group">
                                                    <button type="button" class="action-btn"
                                                        onclick="event.stopPropagation(); openDetail({{ $suggestion->id }})"
                                                        title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @if ($currentUserRole === 'superadmin')
                                                        <button type="button" class="action-btn danger"
                                                            onclick="event.stopPropagation(); confirmDelete({{ $suggestion->id }})"
                                                            title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($totalPages > 1)
                            <nav class="pagination-modern">
                                <ul style="display:flex;align-items:center;gap:6px;margin:0;padding:0;">
                                    <li class="page-item {{ $page <= 1 ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="?page={{ $page - 1 }}&status={{ $status }}&search={{ urlencode($search) }}">
                                            <i class="fas fa-chevron-left" style="font-size:0.7rem;"></i>
                                        </a>
                                    </li>
                                    @for ($i = 1; $i <= $totalPages; $i++)
                                        <li class="page-item {{ $i === $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="?page={{ $i }}&status={{ $status }}&search={{ urlencode($search) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item {{ $page >= $totalPages ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="?page={{ $page + 1 }}&status={{ $status }}&search={{ urlencode($search) }}">
                                            <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    @foreach ($suggestions as $suggestion)
        <div class="modal fade" id="detailModal{{ $suggestion->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content modal-content-modern">
                    <div class="modal-header-modern d-flex align-items-center justify-content-between">
                        <h5 class="modal-title" style="font-weight:700;font-size:1rem;">
                            <i class="fas fa-comment-dots me-2" style="color:var(--corporate-blue);"></i> Detail
                            Kritik & Saran
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body-modern">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h6
                                    style="font-size:0.8rem;font-weight:600;color:var(--zinc-500);text-transform:uppercase;letter-spacing:0.3px;margin-bottom:12px;">
                                    Informasi Pengirim</h6>
                                <table style="width:100%;font-size:0.88rem;">
                                    <tr>
                                        <td style="color:var(--zinc-500);padding:4px 0;width:90px;">Nama</td>
                                        <td style="font-weight:600;color:var(--zinc-800);">:
                                            {{ e($suggestion->name) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--zinc-500);padding:4px 0;">Email</td>
                                        <td style="color:var(--zinc-700);">: {{ $suggestion->email ?: 'Tidak ada' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--zinc-500);padding:4px 0;">IP</td>
                                        <td>: <span class="ip-badge"
                                                style="display:inline-block;background:var(--zinc-100);color:var(--zinc-600);font-family:monospace;font-size:0.78rem;padding:2px 10px;border-radius:6px;">{{ $suggestion->ip_address }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--zinc-500);padding:4px 0;">Tanggal</td>
                                        <td style="color:var(--zinc-700);">:
                                            {{ date('d F Y H:i', strtotime($suggestion->created_at)) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6
                                    style="font-size:0.8rem;font-weight:600;color:var(--zinc-500);text-transform:uppercase;letter-spacing:0.3px;margin-bottom:12px;">
                                    Status</h6>
                                <form method="POST" action="{{ url('/admin/saran/update-status') }}"
                                    id="statusForm{{ $suggestion->id }}">
                                    @csrf
                                    <input type="hidden" name="suggestion_id" value="{{ $suggestion->id }}">
                                    <input type="hidden" name="action" value="update_status">
                                    <div class="mb-3">
                                        <select name="status" class="form-select"
                                            style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                                            @if ($suggestion->status === 'pending')
                                                <option value="pending" selected>Pending</option>
                                            @endif
                                            <option value="read"
                                                {{ $suggestion->status === 'read' ? 'selected' : '' }}>Sudah Dibaca
                                            </option>
                                            <option value="responded"
                                                {{ $suggestion->status === 'responded' ? 'selected' : '' }}>Ditanggapi
                                            </option>
                                        </select>
                                        @if ($suggestion->status !== 'pending')
                                            <small
                                                style="color:var(--zinc-400);font-size:0.78rem;margin-top:4px;display:block;">
                                                <i class="fas fa-info-circle"></i> Status tidak bisa dikembalikan ke
                                                pending.
                                            </small>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            style="font-size:0.82rem;font-weight:500;color:var(--zinc-600);margin-bottom:6px;display:block;">Tanggapan
                                            (opsional)</label>
                                        <textarea name="response" rows="3"
                                            style="width:100%;padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;outline:none;transition:all 0.15s ease;"
                                            placeholder="Masukkan tanggapan...">{{ $suggestion->response ?? '' }}</textarea>
                                    </div>
                                    <div style="display:flex;gap:10px;">
                                        <button type="submit"
                                            style="padding:10px 20px;background:var(--corporate-blue);color:white;border:none;border-radius:10px;font-size:0.82rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">
                                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                                        </button>
                                        @if ($currentUserRole === 'superadmin')
                                            <button type="button"
                                                style="padding:10px 20px;border:1.5px solid #fca5a5;background:#fef2f2;color:#b91c1c;border-radius:10px;font-size:0.82rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;"
                                                onclick="confirmDelete({{ $suggestion->id }})">
                                                <i class="fas fa-trash me-2"></i> Hapus
                                            </button>
                                        @endif
                                    </div>
                                </form>
                                @if ($suggestion->responded_by)
                                    <div
                                        style="margin-top:16px;padding-top:16px;border-top:1px solid var(--zinc-100);">
                                        <small style="color:var(--zinc-500);display:block;"><strong>Ditanggapi
                                                oleh:</strong> {{ $suggestion->responder_name }}</small>
                                        <small style="color:var(--zinc-500);display:block;"><strong>Tanggal:</strong>
                                            {{ date('d F Y H:i', strtotime($suggestion->responded_at)) }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr style="border-color:var(--zinc-100);margin:20px 0;">
                        <h6 style="font-size:0.85rem;font-weight:600;color:var(--zinc-700);margin-bottom:10px;">Pesan
                        </h6>
                        <div
                            style="background:var(--zinc-50);border:1px solid var(--zinc-100);border-radius:12px;padding:16px 20px;font-size:0.88rem;color:var(--zinc-700);line-height:1.6;">
                            {!! nl2br(e($suggestion->message)) !!}
                        </div>
                        @if (!empty($suggestion->response))
                            <h6
                                style="font-size:0.85rem;font-weight:600;color:var(--zinc-700);margin-top:20px;margin-bottom:10px;">
                                Tanggapan</h6>
                            <div
                                style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:16px 20px;font-size:0.88rem;color:#166534;line-height:1.6;">
                                {!! nl2br(e($suggestion->response)) !!}
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer-modern d-flex justify-content-end">
                        <button type="button" class="btn-filter" data-bs-dismiss="modal"
                            style="padding:8px 20px;font-size:0.82rem;">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Delete All Modal -->
    <div class="modal fade" id="deleteAllModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-modern">
                <div class="modal-header-modern d-flex align-items-center justify-content-between"
                    style="border-color:#fecaca;">
                    <h5 class="modal-title" style="font-weight:700;font-size:1rem;color:#b91c1c;">
                        <i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Penghapusan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body-modern">
                    <div class="text-center mb-4">
                        <i class="fas fa-trash-alt"
                            style="font-size:3rem;color:#fca5a5;margin-bottom:12px;display:block;"></i>
                        <h5 style="font-weight:700;color:#b91c1c;font-size:1.1rem;">PERINGATAN!</h5>
                    </div>
                    <div
                        style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:16px;margin-bottom:20px;">
                        <h6 style="font-size:0.85rem;font-weight:600;color:#991b1b;margin-bottom:8px;"><i
                                class="fas fa-exclamation-circle me-2"></i>Tindakan ini akan:</h6>
                        <ul style="margin-bottom:0;padding-left:20px;font-size:0.85rem;color:#991b1b;">
                            <li>Menghapus <strong>SEMUA {{ $totalSuggestions }} data</strong> kritik & saran</li>
                            <li>Data yang dihapus <strong>TIDAK DAPAT DIPULIHKAN</strong></li>
                            <li>Statistik akan direset ke 0</li>
                            <li>Riwayat respons juga akan terhapus</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <label
                            style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:8px;display:block;">Masukkan
                            konfirmasi berikut:</label>
                        <div class="confirmation-display">
                            <code id="randomConfirmationText"></code>
                        </div>
                        <small style="color:var(--zinc-400);font-size:0.78rem;display:block;margin-bottom:8px;">
                            <i class="fas fa-info-circle me-1"></i>Ketik teks di atas dengan tepat (huruf kapital)
                            untuk mengaktifkan tombol hapus
                        </small>
                        <div style="display:flex;gap:8px;">
                            <input type="text" id="deleteAllConfirm" class="input-confirm"
                                placeholder="Ketik teks konfirmasi..." autocomplete="off" style="flex:1;">
                            <button type="button" class="action-btn" onclick="copyConfirmationText()"
                                title="Salin"><i class="fas fa-copy"></i></button>
                            <button type="button" class="action-btn" onclick="regenerateConfirmationText()"
                                title="Buat baru"><i class="fas fa-redo"></i></button>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-top:6px;">
                            <small style="color:var(--zinc-400);font-size:0.75rem;"><i
                                    class="fas fa-shield-alt me-1"></i>Teks diacak setiap kali untuk keamanan</small>
                            <small style="color:var(--zinc-400);font-size:0.75rem;"><span id="charCount">0</span>
                                karakter</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-modern d-flex justify-content-between">
                    <button type="button" class="btn-filter"
                        style="background:var(--zinc-100);color:var(--zinc-600);padding:8px 20px;font-size:0.82rem;"
                        data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Batal
                    </button>
                    <form method="POST" action="{{ url('/admin/saran/update-status') }}" id="deleteAllForm">
                        @csrf
                        <input type="hidden" name="action" value="delete_all">
                        <input type="hidden" name="confirm_delete_all" id="confirm_delete_all" value="0">
                        <button type="submit" class="btn-destructive" id="confirmDeleteAllBtn" disabled
                            style="padding:8px 20px;">
                            <i class="fas fa-trash-alt me-2"></i> Ya, Hapus Semua!
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form method="POST" action="{{ url('/admin/saran/update-status') }}" id="deleteForm" style="display:none;">
        @csrf
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="suggestion_id" id="deleteSuggestionId" value="">
    </form>

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

        function openDetail(id) {
            const modal = new bootstrap.Modal(document.getElementById('detailModal' + id));
            modal.show();
        }

        function confirmDelete(id) {
            if (confirm('Yakin ingin menghapus saran ini?')) {
                document.getElementById('deleteSuggestionId').value = id;
                document.getElementById('deleteForm').submit();
            }
        }

        function generateRandomString(length) {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = '';
            for (let i = 0; i < length; i++) result += chars.charAt(Math.floor(Math.random() * chars.length));
            return result;
        }

        function regenerateConfirmationText() {
            const text = generateRandomString(8);
            document.getElementById('randomConfirmationText').textContent = text;
            document.getElementById('deleteAllConfirm').value = '';
            document.getElementById('confirmDeleteAllBtn').disabled = true;
            document.getElementById('confirm_delete_all').value = '0';
            document.getElementById('charCount').textContent = '0';
            document.getElementById('deleteAllConfirm').classList.remove('is-valid', 'is-invalid');
        }

        function copyConfirmationText() {
            const text = document.getElementById('randomConfirmationText').textContent;
            navigator.clipboard.writeText(text).then(function() {
                const btn = document.querySelector('.input-group .action-btn');
                if (btn) {
                    const original = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-check"></i>';
                    setTimeout(() => {
                        btn.innerHTML = original;
                    }, 1500);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            regenerateConfirmationText();

            $('#deleteAllConfirm').on('input', function() {
                const expected = $('#randomConfirmationText').text();
                const input = $(this).val();
                const match = input === expected;

                if (match) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                    $('#confirmDeleteAllBtn').prop('disabled', false);
                    $('#confirm_delete_all').val('1');
                } else {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                    $('#confirmDeleteAllBtn').prop('disabled', true);
                    $('#confirm_delete_all').val('0');
                }
                $('#charCount').text(input.length);
            });

            setTimeout(() => {
                $('.notification-modern').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>

</html>
