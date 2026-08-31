<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Paralel - Admin Panel</title>
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
            overflow-x: hidden;
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

        .top-bar-left h4 {
            font-family: var(--font-display);
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .top-bar-date {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--nb-dark);
            background: var(--nb-offwhite);
            border: var(--nb-border);
            padding: 8px 14px;
            border-radius: var(--nb-radius-sm);
            box-shadow: var(--nb-shadow-sm);
        }

        .dropdown-toggle {
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 8px 14px;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.8rem;
            color: var(--nb-black);
            cursor: pointer;
            box-shadow: var(--nb-shadow-sm);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .content-wrapper {
            padding: 28px 32px;
            max-width: 1500px;
            margin: 0 auto;
        }

        .page-title-section {
            margin-bottom: 24px;
        }

        .page-title-section h4 {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.6rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .page-title-section p {
            font-family: var(--font-body);
            font-size: 0.95rem;
            color: var(--nb-dark);
            margin-bottom: 0;
            font-weight: 500;
        }

        /* Actions Bar */
        .actions-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            background: var(--nb-white);
            border-radius: var(--nb-radius);
            box-shadow: var(--nb-shadow);
            padding: 20px 24px;
            margin-bottom: 24px;
            border: var(--nb-border);
        }

        .actions-bar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .data-count-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--nb-blue);
            color: var(--nb-white);
            font-family: var(--font-display);
            font-size: 0.78rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .semester-info {
            font-family: var(--font-body);
            font-size: 0.82rem;
            color: var(--nb-dark);
            font-weight: 600;
        }

        .semester-info strong {
            color: var(--nb-black);
            font-weight: 700;
        }

        .actions-bar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-primary-solid {
            padding: 12px 24px;
            background: var(--nb-purple);
            color: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary-solid:hover {
            background: var(--nb-pink);
            color: var(--nb-black);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-outline-secondary-custom {
            padding: 12px 24px;
            background: var(--nb-white);
            color: var(--nb-black);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-outline-secondary-custom:hover {
            background: var(--nb-gray);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-destructive-outline {
            padding: 12px 24px;
            background: var(--nb-white);
            color: var(--nb-red);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-destructive-outline:hover {
            background: var(--nb-red);
            color: var(--nb-white);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-destructive-outline:disabled,
        .btn-outline-secondary-custom:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: var(--nb-shadow-sm);
        }

        /* Filter Card */
        .filter-card {
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius);
            box-shadow: var(--nb-shadow-sm);
            padding: 20px 24px;
            margin-bottom: 24px;
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
            font-family: var(--font-display);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-group select {
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 10px 14px;
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--nb-black);
            background: var(--nb-white);
            outline: none;
            cursor: pointer;
            box-shadow: var(--nb-shadow-sm);
        }

        .active-filter-bar {
            margin-top: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            background: var(--nb-offwhite);
            border: 2px solid var(--nb-black);
            border-radius: var(--nb-radius-sm);
            padding: 10px 14px;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .filter-tag {
            background: var(--nb-yellow);
            border: 2px solid var(--nb-black);
            border-radius: var(--nb-radius-sm);
            padding: 4px 10px;
            font-family: var(--font-display);
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: var(--nb-shadow-sm);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius);
            box-shadow: var(--nb-shadow);
            padding: 18px 20px;
        }

        .stat-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .stat-card-label {
            font-family: var(--font-display);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--nb-dark);
        }

        .stat-card-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--nb-shadow-sm);
        }

        .stat-card-icon.blue {
            background: var(--nb-blue);
            color: var(--nb-white);
        }

        .stat-card-icon.purple {
            background: var(--nb-purple);
            color: var(--nb-white);
        }

        .stat-card-icon.green {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .stat-card-value {
            font-family: var(--font-display);
            font-size: 1.8rem;
            font-weight: 700;
        }

        .stat-card-footer small {
            color: var(--nb-dark);
            font-weight: 600;
        }

        /* Table Card */
        .table-card {
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius);
            box-shadow: var(--nb-shadow);
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
            background: var(--nb-yellow);
        }

        .table-card-header h5 {
            font-family: var(--font-display);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .table-card-body {
            padding: 0;
            overflow-x: auto;
        }

        .table-card-body table {
            width: 100%;
            border-collapse: collapse;
            min-width: 980px;
        }

        .table-card-body thead th {
            background: var(--nb-dark);
            color: var(--nb-white);
            font-family: var(--font-display);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            text-align: left;
            border-right: 2px solid rgba(255, 255, 255, 0.1);
        }

        .table-card-body tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--nb-gray);
            border-right: 1px solid var(--nb-gray);
            font-size: 0.86rem;
            vertical-align: middle;
        }

        .table-card-body tbody tr:hover {
            background: var(--nb-offwhite);
        }

        .class-badge {
            display: inline-flex;
            background: var(--nb-purple);
            color: var(--nb-white);
            border: 2px solid var(--nb-black);
            border-radius: 6px;
            padding: 4px 10px;
            font-weight: 700;
            font-size: 0.78rem;
            box-shadow: var(--nb-shadow-sm);
            margin: 2px;
        }

        .time-slot-badge {
            display: inline-block;
            background: var(--nb-yellow);
            border: 2px solid var(--nb-black);
            border-radius: 6px;
            padding: 4px 10px;
            font-family: var(--font-display);
            font-size: 0.78rem;
            font-weight: 700;
            box-shadow: var(--nb-shadow-sm);
        }

        .room-badge {
            display: inline-block;
            background: var(--nb-green);
            border: 2px solid var(--nb-black);
            border-radius: 6px;
            padding: 4px 10px;
            font-family: var(--font-display);
            font-size: 0.78rem;
            font-weight: 700;
            box-shadow: var(--nb-shadow-sm);
        }

        .semester-badge {
            display: inline-block;
            border-radius: 6px;
            padding: 4px 10px;
            font-family: var(--font-display);
            font-size: 0.72rem;
            font-weight: 700;
            border: 2px solid var(--nb-black);
            text-transform: uppercase;
        }

        .semester-badge.ganjil {
            background: var(--nb-orange);
            color: var(--nb-black);
        }

        .semester-badge.genap {
            background: var(--nb-blue);
            color: var(--nb-white);
        }

        .action-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-btn {
            width: 38px;
            height: 38px;
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            background: var(--nb-white);
            color: var(--nb-black);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--nb-shadow-sm);
            transition: all 0.15s ease;
            font-size: 0.85rem;
            text-decoration: none;
        }

        .action-btn:hover {
            background: var(--nb-yellow);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .action-btn.danger {
            color: var(--nb-red);
        }

        .action-btn.danger:hover {
            background: var(--nb-red);
            color: var(--nb-white);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .alert-flash {
            display: flex;
            align-items: center;
            gap: 12px;
            border: var(--nb-border);
            border-radius: var(--nb-radius);
            padding: 14px 18px;
            margin-bottom: 20px;
            font-weight: 600;
            box-shadow: var(--nb-shadow-sm);
        }

        .alert-flash.success {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .alert-flash.error {
            background: var(--nb-red);
            color: var(--nb-white);
        }

        #notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 420px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--nb-dark);
            opacity: 0.3;
            margin-bottom: 14px;
        }

        .empty-state h5 {
            font-family: var(--font-display);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .empty-state p {
            color: var(--nb-dark);
            font-weight: 500;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding: 14px 16px;
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            font-weight: 600;
            font-size: 0.85rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 8px 12px;
            margin-left: 6px;
        }

        .dataTables_wrapper .dataTables_paginate {
            text-align: center;
        }

        .dataTables_wrapper .dataTables_info {
            font-weight: 600;
            font-size: 0.82rem;
        }

        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
            }

            .top-bar-toggle {
                display: inline-flex;
            }

            .top-bar-date {
                display: none;
            }

            .content-wrapper {
                padding: 20px 16px;
            }
        }
    </style>
</head>

<body>
    @if (session('success'))
        <div class="alert-flash success" style="margin:20px 32px 0;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert-flash error" style="margin:20px 32px 0;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div id="notification-container"></div>

    @include('components.admin.sidebar')

    <div class="main-content">
        <header class="top-bar">
            <div class="top-bar-left">
                <button class="top-bar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>Kelola Jadwal Paralel</h4>
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
                <h4>Jadwal Paralel</h4>
                <p>Kelola jadwal perkuliahan yang dipakai bersama oleh beberapa kelas pada satu hari</p>
            </div>

            <!-- Actions Bar -->
            <div class="actions-bar">
                <div class="actions-bar-left">
                    <span class="data-count-badge">
                        <i class="fas fa-database" style="font-size:0.7rem;"></i> {{ count($entries) }} data
                    </span>
                    <span class="semester-info">
                        Semester Aktif: <strong>{{ $semesterAktif }} - {{ $tahunAkademikAktif }}</strong>
                    </span>
                </div>
                <div class="actions-bar-right">
                    <button class="btn-destructive-outline" data-bs-toggle="modal" data-bs-target="#deleteAllModal"
                        {{ count($entries) == 0 ? 'disabled' : '' }} id="btnDeleteAll">
                        <i class="fas fa-trash-alt"></i> Hapus Semua
                    </button>
                    <a class="btn-outline-secondary-custom" href="{{ url('/admin/manage-schedule') }}"
                        style="text-decoration:none;">
                        <i class="fas fa-calendar"></i> Tambah dari Kelola Jadwal
                    </a>
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
                        <a href="{{ url('/admin/manage-parallel') }}" class="btn-outline-secondary-custom"
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
                        <span class="stat-card-label">Total Jadwal Paralel</span>
                        <div class="stat-card-icon blue"><i class="fas fa-layer-group"></i></div>
                    </div>
                    <div class="stat-card-value">{{ count($entries) }}</div>
                    <div class="stat-card-footer"><small>Jadwal terdaftar</small></div>
                </div>
                @php
                    $totalKelas = 0;
                    foreach ($entries as $e) {
                        $totalKelas += count(array_filter(array_map('trim', explode(',', $e->parallel_kelas))));
                    }
                @endphp
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total Kelas</span>
                        <div class="stat-card-icon purple"><i class="fas fa-users"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $totalKelas }}</div>
                    <div class="stat-card-footer"><small>Kelas digabung</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Hari</span>
                        <div class="stat-card-icon green"><i class="fas fa-calendar-day"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $entries->unique('hari')->count() }}</div>
                    <div class="stat-card-footer"><small>Hari terisi</small></div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-card">
                <div class="table-card-header">
                    <h5><i class="fas fa-layer-group me-2"></i> Data Jadwal Paralel</h5>
                </div>
                <div class="table-card-body">
                    @if (count($entries) > 0)
                        <table id="parallelTable" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kelas Utama</th>
                                    <th>Kelas Paralel</th>
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
                                @foreach ($entries as $entry)
                                    @php
                                        $kelasArr = array_filter(array_map('trim', explode(',', $entry->parallel_kelas)));
                                    @endphp
                                    <tr>
                                        <td style="color:var(--nb-dark); font-weight:600;">{{ $no++ }}
                                        </td>
                                        <td><span class="class-badge">{{ $entry->base_kelas }}</span></td>
                                        <td>
                                            @foreach ($kelasArr as $k)
                                                <span class="class-badge" style="background:var(--nb-orange);">{{ $k }}</span>
                                            @endforeach
                                        </td>
                                        <td style="font-weight:600;">{{ $entry->hari }}</td>
                                        <td style="font-weight:600;">{{ $entry->jam_ke }}</td>
                                        <td><span class="time-slot-badge">{{ $entry->waktu }}</span></td>
                                        <td style="font-weight:600;">{{ $entry->mata_kuliah }}</td>
                                        <td style="font-weight:500;">{{ $entry->dosen }}</td>
                                        <td><span class="room-badge">{{ $entry->ruang }}</span></td>
                                        <td>
                                            <span class="semester-badge {{ strtolower($entry->semester) }}">
                                                {{ $entry->semester }}
                                            </span>
                                        </td>
                                        <td style="font-weight:600;">{{ $entry->tahun_akademik }}</td>
                                        <td>
                                            <div class="action-group">
                                                <a href="{{ url('/admin/manage-parallel/delete/' . $entry->parallel_id) }}"
                                                    class="action-btn danger"
                                                    onclick="return confirm('Yakin hapus jadwal paralel ini?')"
                                                    title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-layer-group"></i>
                            <h5>Belum Ada Data</h5>
                            <p>Belum ada jadwal paralel. Gunakan tombol "Paralel" pada menu Kelola Jadwal untuk
                                menambahkan kelas paralel pada jadwal yang sudah ada.</p>
                            <a class="btn-primary-solid" style="margin-top:12px;text-decoration:none;"
                                href="{{ url('/admin/manage-schedule') }}">
                                <i class="fas fa-calendar"></i> Buka Kelola Jadwal
                            </a>
                        </div>
                    @endif
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

        @if (count($entries) > 0)
            $(document).ready(function() {
                $('#parallelTable').DataTable({
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

    <!-- Include modals -->
    @include('admin.parallel-modals')
</body>

</html>