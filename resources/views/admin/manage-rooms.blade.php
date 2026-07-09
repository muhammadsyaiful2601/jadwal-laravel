<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Ruangan - Admin Panel</title>
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

        .room-name {
            font-weight: 600;
            color: var(--zinc-900);
        }

        .capacity-badge {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 3px 14px;
            border-radius: 8px;
        }

        .facility-badge {
            display: inline-block;
            background: var(--zinc-100);
            color: var(--zinc-600);
            font-size: 0.72rem;
            font-weight: 500;
            padding: 2px 10px;
            border-radius: 6px;
            margin: 1px 2px;
        }

        .facility-more {
            display: inline-block;
            background: var(--zinc-50);
            color: var(--zinc-500);
            font-size: 0.72rem;
            font-weight: 500;
            padding: 2px 10px;
            border-radius: 6px;
            border: 1px solid var(--zinc-200);
        }

        .photo-thumb {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
            cursor: pointer;
            border: 1px solid var(--zinc-100);
            transition: opacity 0.15s ease;
        }

        .photo-thumb:hover {
            opacity: 0.8;
        }

        .photo-none {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: var(--zinc-100);
            color: var(--zinc-400);
            font-size: 0.75rem;
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

        .action-btn.danger-text {
            border-color: var(--zinc-200);
            color: var(--zinc-500);
            background: var(--card-bg);
        }

        .action-btn.danger-text:hover {
            border-color: #fca5a5;
            color: #dc2626;
            background: #fef2f2;
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

        /* Upload box */
        .upload-box {
            border: 2px dashed var(--zinc-200);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .upload-box:hover {
            border-color: var(--corporate-blue);
            background: var(--zinc-50);
        }

        .upload-box i {
            font-size: 2rem;
            color: var(--zinc-400);
            display: block;
            margin-bottom: 8px;
        }

        /* Photo Preview */
        .foto-preview {
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
            border-radius: 10px;
            margin-top: 10px;
        }

        /* DataTables */
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
            max-height: 65vh;
            overflow-y: auto;
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
        @if (session('success'))
            <div class="alert-flash success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert-flash error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
    </div>

    @include('components.admin.sidebar')

    <div class="main-content">
        <header class="top-bar">
            <div class="top-bar-left">
                <button class="top-bar-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
                <h4>Kelola Ruangan</h4>
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
                <h4>Kelola Ruangan</h4>
                <p>Atur dan kelola ruangan untuk jadwal perkuliahan</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total Ruangan</span>
                        <div class="stat-card-icon blue"><i class="fas fa-door-open"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $totalRooms }}</div>
                    <div class="stat-card-footer"><small>Ruangan terdaftar</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Dengan Foto</span>
                        <div class="stat-card-icon green"><i class="fas fa-camera"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $withPhoto }}</div>
                    <div class="stat-card-footer"><small>Memiliki foto</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total Kapasitas</span>
                        <div class="stat-card-icon amber"><i class="fas fa-users"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $totalCapacity }}</div>
                    <div class="stat-card-footer"><small>Kursi tersedia</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Digunakan</span>
                        <div class="stat-card-icon rose"><i class="fas fa-calendar-check"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $usedCount }}</div>
                    <div class="stat-card-footer"><small>Ruangan aktif</small></div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="actions-bar">
                <div style="font-size:0.88rem;color:var(--zinc-600);">
                    <strong style="color:var(--zinc-800);">{{ count($rooms) }}</strong> ruangan tersedia
                </div>
                <button class="btn-primary-solid" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Tambah Ruangan
                </button>
            </div>

            <!-- Data Table -->
            <div class="table-card">
                <div class="table-card-header">
                    <h5><i class="fas fa-list"></i> Daftar Ruangan</h5>
                </div>
                <div class="table-card-body">
                    <div style="overflow-x: auto;">
                        <table class="table-clean" id="roomsTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ruangan</th>
                                    <th>Foto</th>
                                    <th>Deskripsi</th>
                                    <th>Kapasitas</th>
                                    <th>Fasilitas</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($rooms as $room)
                                    <tr>
                                        <td style="color:var(--zinc-400);">{{ $no++ }}</td>
                                        <td><span class="room-name">{{ $room->nama_ruang }}</span></td>
                                        <td>
                                            @if ($room->foto_path)
                                                <img src="{{ asset('uploads/rooms/' . $room->foto_path) }}"
                                                    class="photo-thumb" alt="Foto {{ $room->nama_ruang }}"
                                                    onclick="viewPhoto('{{ asset('uploads/rooms/' . $room->foto_path) }}', '{{ $room->nama_ruang }}')"
                                                    title="Klik untuk perbesar">
                                            @else
                                                <span class="photo-none"><i class="fas fa-image"></i></span>
                                            @endif
                                        </td>
                                        <td
                                            style="color:var(--zinc-500);max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                            {{ $room->deskripsi ?: '-' }}
                                        </td>
                                        <td>
                                            @if ($room->kapasitas > 0)
                                                <span class="capacity-badge">{{ $room->kapasitas }}</span>
                                            @else
                                                <span style="color:var(--zinc-400);">-</span>
                                            @endif
                                        </td>
                                        <td style="max-width:180px;">
                                            @if ($room->fasilitas)
                                                @php
                                                    $fasilitas = explode(',', $room->fasilitas);
                                                    $display = array_slice($fasilitas, 0, 3);
                                                @endphp
                                                @foreach ($display as $fas)
                                                    @php $fas = trim($fas); @endphp
                                                    @if (!empty($fas))
                                                        <span class="facility-badge">{{ $fas }}</span>
                                                    @endif
                                                @endforeach
                                                @if (count($fasilitas) > 3)
                                                    <span class="facility-more">+{{ count($fasilitas) - 3 }}</span>
                                                @endif
                                            @else
                                                <span style="color:var(--zinc-400);">-</span>
                                            @endif
                                        </td>
                                        <td style="color:var(--zinc-500);">
                                            {{ date('d/m/Y', strtotime($room->created_at)) }}</td>
                                        <td>
                                            <div class="action-group">
                                                <button class="action-btn"
                                                    onclick='editRoom(@json($room))' title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                @if ($room->foto_path)
                                                    <a href="{{ url('/admin/manage-rooms/delete-photo/' . $room->id) }}"
                                                        class="action-btn danger-text"
                                                        onclick="return confirm('Yakin hapus foto ini?')"
                                                        title="Hapus Foto">
                                                        <i class="fas fa-image"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ url('/admin/manage-rooms/delete/' . $room->id) }}"
                                                    class="action-btn danger"
                                                    onclick="return confirm('Yakin hapus ruangan ini?')"
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
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modal-content-modern">
                <form method="POST" enctype="multipart/form-data" action="{{ url('/admin/manage-rooms/store') }}">
                    @csrf
                    <div class="modal-header-modern d-flex align-items-center justify-content-between">
                        <h5 class="modal-title" style="font-weight:700;font-size:1rem;">
                            <i class="fas fa-plus me-2" style="color:var(--corporate-blue);"></i> Tambah Ruangan Baru
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body-modern">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label
                                        style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Nama
                                        Ruangan <span style="color:#dc2626;">*</span></label>
                                    <input type="text" name="nama_ruang" class="form-control" required
                                        style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;"
                                        placeholder="Contoh: R.101, Lab. Komputer 1">
                                </div>
                                <div class="mb-3">
                                    <label
                                        style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Kapasitas</label>
                                    <input type="number" name="kapasitas" class="form-control"
                                        style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;"
                                        placeholder="Jumlah maksimal orang" min="0">
                                </div>
                                <div class="mb-3">
                                    <label
                                        style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Fasilitas</label>
                                    <textarea name="fasilitas" class="form-control" rows="2"
                                        style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;"
                                        placeholder="Pisahkan dengan koma (AC, Proyektor, Papan Tulis)"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label
                                        style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="4"
                                        style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;"
                                        placeholder="Deskripsi ruangan..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label
                                        style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Foto
                                        Ruangan</label>
                                    <div class="upload-box" onclick="document.getElementById('fotoInput').click()">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p style="color:var(--zinc-500);font-size:0.85rem;margin-bottom:4px;">Klik
                                            untuk upload foto</p>
                                        <small style="color:var(--zinc-400);font-size:0.75rem;">Format: JPG, PNG, GIF,
                                            WebP - Maks 2MB</small>
                                        <input type="file" name="foto" id="fotoInput" class="d-none"
                                            accept="image/*" onchange="previewFoto(this, 'addFotoPreview')">
                                    </div>
                                    <div id="addFotoPreview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer-modern">
                        <button type="button" class="action-btn" data-bs-dismiss="modal"
                            style="width:auto;padding:8px 20px;">Batal</button>
                        <button type="submit" name="add_room" class="btn-primary-solid" style="padding:8px 20px;">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modal-content-modern">
                <form method="POST" enctype="multipart/form-data" id="editForm"
                    action="{{ url('/admin/manage-rooms/update') }}">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-header-modern d-flex align-items-center justify-content-between">
                        <h5 class="modal-title" style="font-weight:700;font-size:1rem;">
                            <i class="fas fa-edit me-2" style="color:var(--corporate-blue);"></i> Edit Ruangan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body-modern">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label
                                        style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Nama
                                        Ruangan <span style="color:#dc2626;">*</span></label>
                                    <input type="text" name="nama_ruang" id="edit_nama_ruang"
                                        class="form-control" required
                                        style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                                </div>
                                <div class="mb-3">
                                    <label
                                        style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Kapasitas</label>
                                    <input type="number" name="kapasitas" id="edit_kapasitas" class="form-control"
                                        min="0"
                                        style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;">
                                </div>
                                <div class="mb-3">
                                    <label
                                        style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Fasilitas</label>
                                    <textarea name="fasilitas" id="edit_fasilitas" class="form-control" rows="2"
                                        style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label
                                        style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Deskripsi</label>
                                    <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="4"
                                        style="padding:10px 14px;border:1.5px solid var(--zinc-200);border-radius:10px;font-size:0.85rem;font-family:'Inter',sans-serif;width:100%;"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label
                                        style="font-size:0.82rem;font-weight:600;color:var(--zinc-700);margin-bottom:6px;display:block;">Foto
                                        Ruangan</label>
                                    <div id="currentFoto" class="mb-2"></div>
                                    <div class="upload-box"
                                        onclick="document.getElementById('editFotoInput').click()">
                                        <i class="fas fa-sync-alt"></i>
                                        <p style="color:var(--zinc-500);font-size:0.85rem;margin-bottom:4px;">Klik
                                            untuk ganti foto</p>
                                        <small style="color:var(--zinc-400);font-size:0.75rem;">Biarkan kosong jika
                                            tidak ingin mengubah</small>
                                        <input type="file" name="foto" id="editFotoInput" class="d-none"
                                            accept="image/*" onchange="previewFoto(this, 'editFotoPreview')">
                                    </div>
                                    <div id="editFotoPreview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer-modern">
                        <button type="button" class="action-btn" data-bs-dismiss="modal"
                            style="width:auto;padding:8px 20px;">Batal</button>
                        <button type="submit" name="edit_room" class="btn-primary-solid" style="padding:8px 20px;">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Photo Modal -->
    <div class="modal fade" id="viewPhotoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content modal-content-modern">
                <div class="modal-header-modern d-flex align-items-center justify-content-between">
                    <h5 class="modal-title" id="photoTitle" style="font-weight:700;font-size:0.95rem;">Foto Ruangan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body-modern text-center">
                    <img id="viewPhotoImg" src="" alt=""
                        style="max-width:100%;max-height:500px;border-radius:10px;">
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

        $(document).ready(function() {
            $('#roomsTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/id.json"
                },
                "pageLength": 10,
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Semua"]
                ],
                "responsive": false,
                "autoWidth": false
            });
        });

        function editRoom(room) {
            document.getElementById('edit_id').value = room.id;
            document.getElementById('edit_nama_ruang').value = room.nama_ruang;
            document.getElementById('edit_deskripsi').value = room.deskripsi || '';
            document.getElementById('edit_kapasitas').value = room.kapasitas || '';
            document.getElementById('edit_fasilitas').value = room.fasilitas || '';

            const currentFotoDiv = document.getElementById('currentFoto');
            if (room.foto_path) {
                currentFotoDiv.innerHTML = `
                    <p style="font-size:0.8rem;color:var(--zinc-500);margin-bottom:6px;">Foto saat ini:</p>
                    <img src="{{ asset('uploads/rooms/') }}/${room.foto_path}"
                         class="foto-preview"
                         alt="Foto ${room.nama_ruang}"
                         onclick="viewPhoto('{{ asset('uploads/rooms/') }}/${room.foto_path}', '${room.nama_ruang}')"
                         style="cursor:pointer;">
                `;
            } else {
                currentFotoDiv.innerHTML = '<p style="font-size:0.8rem;color:var(--zinc-400);">Tidak ada foto</p>';
            }

            document.getElementById('editFotoPreview').innerHTML = '';

            const modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        }

        function previewFoto(input, previewId) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2MB');
                    input.value = '';
                    return;
                }
                const allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowed.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPG, PNG, GIF, atau WebP.');
                    input.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div style="border:1px solid var(--zinc-200);border-radius:10px;padding:8px;margin-top:8px;">
                            <img src="${e.target.result}" class="img-thumbnail" style="max-height:150px;border-radius:8px;">
                            <small style="display:block;margin-top:4px;color:var(--zinc-500);">${file.name} (${(file.size / 1024).toFixed(1)} KB)</small>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        }

        function viewPhoto(src, title) {
            document.getElementById('viewPhotoImg').src = src;
            document.getElementById('photoTitle').textContent = 'Foto: ' + title;
            const modal = new bootstrap.Modal(document.getElementById('viewPhotoModal'));
            modal.show();
        }

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
