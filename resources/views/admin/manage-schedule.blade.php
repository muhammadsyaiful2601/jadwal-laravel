<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal - Admin Panel</title>
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

        /* Page Actions Bar */
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

        .actions-bar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .actions-bar-left .data-count-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 4px 14px;
            border-radius: 20px;
        }

        .semester-info {
            font-size: 0.82rem;
            color: var(--zinc-500);
        }

        .semester-info strong {
            color: var(--zinc-700);
            font-weight: 600;
        }

        .actions-bar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
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

        .btn-outline-secondary-custom {
            padding: 10px 22px;
            background: var(--card-bg);
            color: var(--zinc-700);
            border: 1.5px solid var(--zinc-200);
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

        .btn-outline-secondary-custom:hover {
            border-color: var(--zinc-300);
            background: var(--zinc-50);
        }

        .btn-destructive-outline {
            padding: 10px 22px;
            background: var(--card-bg);
            color: #dc2626;
            border: 1.5px solid #fca5a5;
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

        .btn-destructive-outline:hover {
            background: #fef2f2;
            border-color: #f87171;
        }

        .btn-destructive-outline:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Filter Card */
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
            min-width: 200px;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            border-color: var(--corporate-blue);
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
        }

        /* Active Filter Bar */
        .active-filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 12px;
            padding: 8px 14px;
            background: #eff6ff;
            border-radius: 8px;
            border: 1px solid #bfdbfe;
            font-size: 0.82rem;
            color: #1e40af;
        }

        .active-filter-bar .filter-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 6px;
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
            padding: 12px 18px;
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
            padding: 12px 18px;
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

        .class-badge {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 2px 12px;
            border-radius: 6px;
        }

        .room-badge {
            display: inline-block;
            background: #f0fdf4;
            color: #15803d;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 2px 12px;
            border-radius: 6px;
        }

        .semester-badge {
            display: inline-block;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 6px;
        }

        .semester-badge.ganjil {
            background: #fffbeb;
            color: #92400e;
        }

        .semester-badge.genap {
            background: #f0fdf4;
            color: #166534;
        }

        .time-slot-badge {
            display: inline-block;
            background: var(--zinc-100);
            color: var(--zinc-600);
            font-size: 0.78rem;
            padding: 2px 10px;
            border-radius: 6px;
            font-weight: 500;
        }

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

        /* DataTables override */
        .dataTables_wrapper .dataTables_length {
            padding: 14px 18px;
            float: left;
            font-size: 0.82rem;
            color: var(--zinc-600);
        }

        .dataTables_wrapper .dataTables_length select {
            padding: 4px 8px;
            border: 1.5px solid var(--zinc-200);
            border-radius: 8px;
            font-size: 0.82rem;
            font-family: 'Inter', sans-serif;
            color: var(--zinc-700);
            outline: none;
            margin: 0 6px;
        }

        .dataTables_wrapper .dataTables_filter {
            padding: 14px 18px;
            float: right;
            font-size: 0.82rem;
            color: var(--zinc-600);
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 6px 12px;
            border: 1.5px solid var(--zinc-200);
            border-radius: 8px;
            font-size: 0.82rem;
            font-family: 'Inter', sans-serif;
            color: var(--zinc-700);
            outline: none;
            margin-left: 8px;
            min-width: 180px;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--corporate-blue);
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
        }

        .dataTables_wrapper .dataTables_info {
            padding: 14px 18px;
            float: left;
            font-size: 0.78rem;
            color: var(--zinc-400);
            clear: both;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding: 14px 18px;
            float: right;
            font-size: 0.82rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            margin: 0 2px;
            border: 1.5px solid var(--zinc-200);
            border-radius: 8px;
            color: var(--zinc-600);
            cursor: pointer;
            display: inline-block;
            transition: all 0.15s ease;
            font-size: 0.82rem;
            background: var(--card-bg);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            border-color: var(--corporate-blue);
            color: var(--corporate-blue);
            background: #f8faff;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--corporate-blue);
            border-color: var(--corporate-blue);
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4;
            cursor: default;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            border-color: var(--zinc-200);
            color: var(--zinc-600);
            background: var(--card-bg);
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

        /* Modal */
        .modal-content-custom {
            border-radius: 16px;
            border: none;
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
        }

        .modal-header-custom {
            padding: 20px 24px;
            border-bottom: 1px solid var(--zinc-100);
        }

        .modal-body-custom {
            padding: 24px;
            max-height: 65vh;
            overflow-y: auto;
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

            .actions-bar {
                flex-direction: column;
                align-items: flex-start;
            }

            .actions-bar-right {
                width: 100%;
            }

            .actions-bar-right .btn-primary-solid,
            .actions-bar-right .btn-outline-secondary-custom,
            .actions-bar-right .btn-destructive-outline {
                flex: 1;
                justify-content: center;
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

            .dataTables_wrapper .dataTables_filter input {
                min-width: 120px;
            }
        }
    </style>
</head>

<body>
    <div id="notification-container">
        @if (session('message'))
            <div class="alert-flash success">
                <i class="fas fa-check-circle"></i> {{ session('message') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert-flash error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
    </div>

    @include('components.admin.sidebar')

    <div class="main-content">
        <header class="top-bar">
            <div class="top-bar-left">
                <button class="top-bar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>Kelola Jadwal Kuliah</h4>
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
                <h4>Kelola Jadwal Kuliah</h4>
                <p>Atur dan kelola jadwal perkuliahan untuk semua kelas</p>
            </div>

            <!-- Actions Bar -->
            <div class="actions-bar">
                <div class="actions-bar-left">
                    <span class="data-count-badge">
                        <i class="fas fa-database" style="font-size:0.7rem;"></i> {{ count($schedules) }} data
                    </span>
                    <span class="semester-info">
                        Semester Aktif: <strong>{{ $semesterAktif }} - {{ $tahunAkademikAktif }}</strong>
                    </span>
                </div>
                <div class="actions-bar-right">
                    <button class="btn-destructive-outline" data-bs-toggle="modal" data-bs-target="#deleteAllModal"
                        {{ count($schedules) == 0 ? 'disabled' : '' }} id="btnDeleteAll">
                        <i class="fas fa-trash-alt"></i> Hapus Semua
                    </button>
                    <button class="btn-outline-secondary-custom" data-bs-toggle="modal" data-bs-target="#bulkAddModal">
                        <i class="fas fa-layer-group"></i> Tambah Massal
                    </button>
                    <button class="btn-primary-solid" data-bs-toggle="modal" data-bs-target="#addModal"
                        id="btnAddSchedule">
                        <i class="fas fa-plus"></i> Tambah Jadwal
                    </button>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="filter-card">
                <form method="GET" class="filter-inline">
                    <div class="filter-group">
                        <label>Tahun Akademik</label>
                        <select name="filter_tahun" onchange="this.form.submit()">
                            <option value="all">Semua Tahun Akademik</option>
                            @foreach ($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ $filterTahun == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Semester</label>
                        <select name="filter_semester" onchange="this.form.submit()">
                            <option value="all">Semua Semester</option>
                            <option value="GANJIL" {{ $filterSemester == 'GANJIL' ? 'selected' : '' }}>GANJIL</option>
                            <option value="GENAP" {{ $filterSemester == 'GENAP' ? 'selected' : '' }}>GENAP</option>
                        </select>
                    </div>
                    <div class="filter-group" style="justify-content:flex-end;">
                        <a href="{{ url('/admin/manage-schedule') }}" class="btn-outline-secondary-custom"
                            style="padding:10px 22px;text-decoration:none;">
                            <i class="fas fa-redo"></i> Reset Filter
                        </a>
                    </div>
                </form>
                @if ($filterTahun != 'all' || $filterSemester != 'all')
                    <div class="active-filter-bar">
                        <i class="fas fa-filter"></i>
                        Filter Aktif:
                        @if ($filterTahun != 'all')
                            <span class="filter-tag">Tahun: {{ $filterTahun }}</span>
                        @endif
                        @if ($filterSemester != 'all')
                            <span class="filter-tag">Semester: {{ $filterSemester }}</span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total Jadwal</span>
                        <div class="stat-card-icon blue"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                    <div class="stat-card-value">{{ count($schedules) }}</div>
                    <div class="stat-card-footer"><small>Jadwal terdaftar</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total Kelas</span>
                        <div class="stat-card-icon green"><i class="fas fa-users"></i></div>
                    </div>
                    <div class="stat-card-value">{{ count($kelasList) }}</div>
                    <div class="stat-card-footer"><small>Kelas terdaftar</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total Ruangan</span>
                        <div class="stat-card-icon amber"><i class="fas fa-door-open"></i></div>
                    </div>
                    <div class="stat-card-value">{{ count($rooms) }}</div>
                    <div class="stat-card-footer"><small>Ruangan tersedia</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Tahun Akademik</span>
                        <div class="stat-card-icon purple"><i class="fas fa-graduation-cap"></i></div>
                    </div>
                    <div class="stat-card-value">{{ count($tahunList) }}</div>
                    <div class="stat-card-footer"><small>Tahun aktif</small></div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-card">
                <div class="table-card-header">
                    <h5><i class="fas fa-list"></i> Daftar Jadwal Kuliah</h5>
                </div>
                <div class="table-card-body">
                    @if (count($schedules) == 0)
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h5>Belum ada data jadwal</h5>
                            <p>Mulai dengan menambahkan jadwal baru</p>
                            <button class="btn-primary-solid" data-bs-toggle="modal" data-bs-target="#addModal"
                                style="margin-top:12px;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    @else
                        <div style="overflow-x: auto;">
                            <table class="table-clean" id="scheduleTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kelas</th>
                                        <th>Hari</th>
                                        <th>Jam Ke</th>
                                        <th>Waktu</th>
                                        <th>Mata Kuliah</th>
                                        <th>Dosen</th>
                                        <th>Ruang</th>
                                        <th>Semester</th>
                                        <th>Tahun</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($schedules as $schedule)
                                        <tr>
                                            <td style="color:var(--zinc-400);">{{ $no++ }}</td>
                                            <td><span class="class-badge">{{ $schedule->kelas }}</span></td>
                                            <td style="font-weight:500;">{{ $schedule->hari }}</td>
                                            <td>{{ $schedule->jam_ke }}</td>
                                            <td><span class="time-slot-badge">{{ $schedule->waktu }}</span></td>
                                            <td>{{ $schedule->mata_kuliah }}</td>
                                            <td>{{ $schedule->dosen }}</td>
                                            <td><span class="room-badge">{{ $schedule->ruang }}</span></td>
                                            <td>
                                                <span class="semester-badge {{ strtolower($schedule->semester) }}">
                                                    {{ $schedule->semester }}
                                                </span>
                                            </td>
                                            <td style="color:var(--zinc-500);">{{ $schedule->tahun_akademik }}</td>
                                            <td>
                                                <div class="action-group">
                                                    <button class="action-btn"
                                                        onclick='editSchedule(@json($schedule))'
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="{{ url('/admin/manage-schedule/delete/' . $schedule->id) }}"
                                                        class="action-btn danger"
                                                        onclick="return confirm('Yakin hapus jadwal ini?')"
                                                        title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Include modals from original file -->
    @include('admin.schedule-modals')

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

        @if (count($schedules) > 0)
            $(document).ready(function() {
                $('#scheduleTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/id.json"
                    },
                    "order": [
                        [0, 'asc']
                    ],
                    "pageLength": 10,
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "Semua"]
                    ]
                });
            });
        @endif

        // Auto-hide notifications
        setTimeout(function() {
            const container = document.getElementById('notification-container');
            if (container) {
                container.style.transition = 'opacity 0.5s ease';
                container.style.opacity = '0';
                setTimeout(() => {
                    container.style.display = 'none';
                }, 500);
            }
        }, 5000);
    </script>
</body>

</html>
