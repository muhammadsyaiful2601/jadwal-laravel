<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Kelola Admin - Admin Panel</title>
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
            --accent-hover: #1d4ed8;
            --accent-light: #dbeafe;
            --success-light: #d1fae5;
            --success-text: #059669;
            --danger-soft: #fee2e2;
            --danger-text: #dc2626;
            --warning-soft: #fef3c7;
            --warning-text: #b45309;
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
            -webkit-font-smoothing: antialiased;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
            background: var(--canvas-bg);
        }

        /* Top Bar */
        .topbar {
            background: var(--card-bg);
            padding: 16px 28px;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-title h4 {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-date {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .topbar-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px 6px 6px;
            border-radius: 100px;
            border: 1px solid var(--border-subtle);
            background: white;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .topbar-profile:hover {
            background: var(--canvas-bg);
            border-color: #cbd5e1;
        }

        .topbar-profile .user-avatar {
            width: 32px;
            height: 32px;
            font-size: 0.8rem;
        }

        .topbar-profile span {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .topbar-profile i {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Cards */
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

        /* Page Header */
        .page-header {
            margin-bottom: 24px;
        }

        .page-header-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 4px;
            letter-spacing: -0.02em;
        }

        .page-header-subtitle {
            font-size: 0.9375rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .account-info {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .account-info i {
            color: #6366f1;
            font-size: 0.875rem;
        }

        /* Buttons */
        .btn-add-admin {
            background: #1e293b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add-admin:hover {
            background: #0f172a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        }

        .btn-add-admin:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Table Controls */
        .table-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-light);
        }

        .table-controls-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .show-entries {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .show-entries select {
            border: 1px solid var(--border-subtle);
            border-radius: 6px;
            padding: 4px 28px 4px 10px;
            font-size: 0.875rem;
            color: var(--text-primary);
            background: white;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 14px;
        }

        .table-search {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-search label {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 0;
        }

        .table-search input {
            border: 1px solid var(--border-subtle);
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 0.875rem;
            width: 220px;
            color: var(--text-primary);
            transition: all 0.2s ease;
        }

        .table-search input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Table */
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

        .table tbody tr {
            transition: background 0.15s ease;
        }

        .table tbody tr:hover {
            background: var(--canvas-bg);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* User Info Cell */
        .user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-cell .avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .user-cell .username {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Badges */
        .badge {
            font-size: 0.6875rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .badge-you {
            background: var(--accent-light);
            color: var(--accent);
            padding: 2px 8px;
            font-size: 0.6875rem;
            font-weight: 600;
            border-radius: 4px;
            margin-left: 6px;
        }

        .badge-role {
            padding: 3px 12px;
            font-size: 0.6875rem;
            font-weight: 600;
            border-radius: 6px;
            background: var(--canvas-bg);
            color: var(--text-secondary);
            letter-spacing: 0.02em;
        }

        .badge-role.superadmin {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .badge-status {
            padding: 3px 10px;
            font-size: 0.6875rem;
            font-weight: 600;
            border-radius: 6px;
            background: var(--success-light);
            color: var(--success-text);
        }

        .badge-protected {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #fef3c7;
            color: var(--warning-text);
            padding: 2px 8px;
            font-size: 0.6875rem;
            font-weight: 600;
            border-radius: 4px;
            margin-left: 4px;
            cursor: help;
        }

        .badge-lockout {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--danger-soft);
            color: var(--danger-text);
            padding: 2px 8px;
            font-size: 0.6875rem;
            font-weight: 600;
            border-radius: 4px;
            margin-left: 4px;
        }

        .status-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 4px;
        }

        /* Action Buttons */
        .action-btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid transparent;
            background: transparent;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.15s ease;
            font-size: 0.875rem;
        }

        .action-btn:hover {
            background: var(--canvas-bg);
            border-color: var(--border-subtle);
            color: var(--text-primary);
        }

        .action-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }

        .action-btn.danger:hover {
            background: var(--danger-soft);
            border-color: #fecaca;
            color: var(--danger-text);
        }

        .action-group {
            display: flex;
            gap: 4px;
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-top: 1px solid var(--border-light);
        }

        .pagination-info {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .pagination {
            gap: 6px;
            margin: 0;
        }

        .pagination .page-link {
            border: 1px solid var(--border-subtle);
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
            background: white;
            transition: all 0.15s ease;
        }

        .pagination .page-item.active .page-link {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        .pagination .page-link:hover {
            background: var(--canvas-bg);
            border-color: #cbd5e1;
            color: var(--text-primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 10px;
            }

            .topbar {
                padding: 12px 16px;
            }

            .topbar-right .topbar-date {
                display: none;
            }
        }

        @media (max-width: 575.98px) {
            .main-content {
                padding: 10px 8px;
            }

            .page-header-title {
                font-size: 1.125rem;
            }
        }
    </style>
</head>

<body>
    @include('components.admin.sidebar')

    <div class="main-content flex-grow-1">
        <!-- Mobile Sidebar -->
        <div class="collapse d-md-none mb-4" id="mobileSidebar">
            <div class="card">
                <div class="card-body p-3">
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
                        <a class="nav-link active" href="{{ url('/admin/manage-users') }}">
                            <i class="fas fa-users"></i> Kelola Admin
                        </a>
                        <a class="nav-link" href="{{ url('/admin/reports') }}">
                            <i class="fas fa-chart-bar"></i> Laporan
                        </a>
                        <a class="nav-link" href="{{ url('/admin/saran') }}">
                            <i class="fas fa-comments"></i> Kritik & Saran
                        </a>
                        <a class="nav-link" href="{{ url('/admin/maintenance') }}">
                            <i class="fas fa-tools"></i> Maintenance
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

        <!-- Top Bar -->
        <div class="topbar">
            <div class="topbar-title">
                <button class="btn btn-light d-md-none me-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mobileSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>Kelola Admin</h4>
                @if (!$isSuperAdmin)
                    <span class="badge bg-info ms-2">Mode Terbatas</span>
                @endif
            </div>
            <div class="topbar-right">
                <span class="topbar-date"><i class="far fa-calendar-alt me-1"></i> {{ date('d F Y') }}</span>
                <div class="dropdown">
                    <button class="topbar-profile dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ strtoupper(substr(session('username'), 0, 1)) }}
                        </div>
                        <span>{{ session('username') }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ url('/admin/profile') }}">
                                <i class="fas fa-user me-2"></i>Profile
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ url('/logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger border-0 bg-transparent">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-header-title">Daftar Admin</h1>
                <p class="page-header-subtitle">Kelola pengguna dengan akses admin</p>
                <div class="account-info">
                    <i class="fas fa-info-circle"></i>
                    {{ $active_count ?? 0 }} akun aktif dari {{ count($users) }} total akun
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert"
                    style="border-radius: 8px;">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert"
                    style="border-radius: 8px;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (!$isSuperAdmin)
                <div class="card" style="border: 1px solid #dbeafe; background: #eff6ff;">
                    <div class="card-body" style="padding: 16px 20px;">
                        <h6 style="font-weight: 600; color: #1e40af; margin-bottom: 8px;">
                            <i class="fas fa-info-circle me-2"></i>Informasi Hak Akses
                        </h6>
                        <p class="mb-0" style="font-size: 0.875rem; color: #1e3a8a;">
                            Sebagai <strong>Admin Biasa</strong>, Anda dapat: Melihat daftar admin, mengaktifkan akun
                            non-aktif, mengedit username dan email akun sendiri.
                            <strong>Tidak dapat:</strong> mengedit superadmin, menghapus admin, menambah admin baru.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Data Table -->
            <div class="card">
                <!-- Desktop View - Table -->
                <div class="table-responsive d-none d-md-block">
                    <div class="table-controls">
                        <div class="table-controls-left">
                            <span class="show-entries">Show</span>
                            <select>
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                            </select>
                            <span class="show-entries">entries</span>
                        </div>
                        <div class="table-search">
                            <label>Search:</label>
                            <input type="text" id="searchInput" placeholder="Cari admin...">
                        </div>
                    </div>
                    <table class="table" id="usersTableDesktop" style="margin-bottom: 0;">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Terakhir Login</th>
                                <th style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($users as $user)
                                @php
                                    $is_protected = false;
                                    $protection_reason = '';
                                    $can_edit = true;
                                    $can_delete = true;
                                    $can_change_password = false;
                                    $is_locked = false;
                                    $lockout_info = '';

                                    if (
                                        isset($user->locked_until) &&
                                        $user->locked_until &&
                                        strtotime($user->locked_until) > time()
                                    ) {
                                        $is_locked = true;
                                        $remaining = strtotime($user->locked_until) - time();
                                        $lockout_info = $this->formatLockoutTime($remaining);
                                    }

                                    if (!$isSuperAdmin) {
                                        if ($user->role == 'superadmin') {
                                            $is_protected = true;
                                            $protection_reason = 'Superadmin - hanya dapat dilihat';
                                            $can_edit = false;
                                            $can_delete = false;
                                            $can_change_password = false;
                                        }

                                        if ($user->id != $currentUserId) {
                                            $can_delete = false;
                                        }

                                        if ($user->id == $currentUserId) {
                                            $can_change_password = true;
                                        }
                                    } else {
                                        $can_change_password = true;
                                    }

                                    if ($user->other_active_count == 0 && $user->is_active) {
                                        $is_protected = true;
                                        $protection_reason = 'Akun aktif terakhir';
                                        $can_delete = false;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <div class="user-cell">
                                            <div class="avatar">{{ strtoupper(substr($user->username, 0, 1)) }}</div>
                                            <span class="username">{{ $user->username }}</span>
                                            @if ($user->id == $currentUserId)
                                                <span class="badge-you">Anda</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $user->email ?? '-' }}</td>
                                    <td>
                                        <span
                                            class="badge-role {{ $user->role == 'superadmin' ? 'superadmin' : '' }}">
                                            {{ strtoupper($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="status-group">
                                            <span
                                                class="badge-status">{{ $user->is_active ? 'AKTIF' : 'NONAKTIF' }}</span>
                                            @if ($is_protected && $user->is_active)
                                                <span class="badge-protected" data-bs-toggle="tooltip"
                                                    title="{{ $protection_reason }}">
                                                    <i class="fas fa-shield-alt"></i>
                                                </span>
                                            @endif
                                            @if ($is_locked)
                                                <span class="badge-lockout"
                                                    title="Terkunci sampai {{ date('d/m/Y H:i', strtotime($user->locked_until)) }}">
                                                    <i class="fas fa-lock"></i> Terkunci
                                                </span>
                                            @elseif($user->failed_attempts > 0)
                                                <span class="badge-lockout"
                                                    title="Percobaan gagal: {{ $user->failed_attempts }}">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    {{ $user->failed_attempts }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $user->last_login ? date('d/m/Y H:i', strtotime($user->last_login)) : '-' }}
                                    </td>
                                    <td>
                                        <div class="action-group">
                                            <button class="action-btn" onclick="editUser({{ json_encode($user) }})"
                                                {{ !$can_edit ? 'disabled' : '' }}
                                                @if (!$can_edit) title="{{ $protection_reason }}" @endif>
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            @if ($can_change_password)
                                                <a href="{{ url('/admin/change-password?id=' . $user->id) }}"
                                                    class="action-btn" title="Ganti Password">
                                                    <i class="fas fa-key"></i>
                                                </a>
                                            @else
                                                <button class="action-btn" disabled
                                                    title="Hanya dapat mengganti password sendiri">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                            @endif

                                            @if ($isSuperAdmin)
                                                @if ($is_locked)
                                                    <a href="{{ url('/admin/manage-users?cancel_lockout=' . $user->id) }}"
                                                        class="action-btn"
                                                        onclick="return confirm('Batalkan lockout untuk akun ini?')"
                                                        title="Batalkan Lockout">
                                                        <i class="fas fa-unlock-alt"></i>
                                                    </a>
                                                @elseif($user->failed_attempts > 0)
                                                    <a href="{{ url('/admin/manage-users?reset_lockout=' . $user->id) }}"
                                                        class="action-btn"
                                                        onclick="return confirm('Reset lockout untuk akun ini?')"
                                                        title="Reset Lockout">
                                                        <i class="fas fa-redo"></i>
                                                    </a>
                                                @endif
                                            @endif

                                            @if ($can_delete && $isSuperAdmin)
                                                <a href="{{ url('/admin/manage-users?delete=' . $user->id) }}"
                                                    class="action-btn danger"
                                                    onclick="return confirm('Yakin hapus admin ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @else
                                                <button class="action-btn" disabled
                                                    title="Hanya superadmin yang dapat menghapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-wrapper">
                        <span class="pagination-info">Showing 1 to {{ count($users) }} of {{ count($users) }}
                            entries</span>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- Mobile View -->
                <div class="d-block d-md-none p-3" id="mobileUserList">
                    @foreach ($users as $user)
                        @php
                            $is_protected = false;
                            $protection_reason = '';
                            $can_edit = true;
                            $can_delete = true;
                            $can_change_password = false;
                            $is_locked = false;

                            if (
                                isset($user->locked_until) &&
                                $user->locked_until &&
                                strtotime($user->locked_until) > time()
                            ) {
                                $is_locked = true;
                            }

                            if (!$isSuperAdmin) {
                                if ($user->role == 'superadmin') {
                                    $is_protected = true;
                                    $protection_reason = 'Superadmin - hanya dapat dilihat';
                                    $can_edit = false;
                                    $can_delete = false;
                                    $can_change_password = false;
                                }

                                if ($user->id != $currentUserId) {
                                    $can_delete = false;
                                }

                                if ($user->id == $currentUserId) {
                                    $can_change_password = true;
                                }
                            } else {
                                $can_change_password = true;
                            }

                            if ($user->other_active_count == 0 && $user->is_active) {
                                $is_protected = true;
                                $protection_reason = 'Akun aktif terakhir';
                                $can_delete = false;
                            }
                        @endphp
                        <div class="card mb-3" style="border: 1px solid var(--border-subtle); border-radius: 10px;">
                            <div class="card-body" style="padding: 16px;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="user-cell">
                                        <div class="avatar" style="width: 36px; height: 36px; font-size: 0.875rem;">
                                            {{ strtoupper(substr($user->username, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong style="font-weight: 600;">{{ $user->username }}</strong>
                                            @if ($user->id == $currentUserId)
                                                <span class="badge-you">Anda</span>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="badge-role {{ $user->role == 'superadmin' ? 'superadmin' : '' }}">
                                        {{ strtoupper($user->role) }}
                                    </span>
                                </div>

                                <div class="mb-2">
                                    <small style="color: var(--text-muted); font-weight: 500;">Email:</small>
                                    <div class="small" style="font-weight: 400;">{{ $user->email ?? '-' }}</div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <span
                                            class="badge-status">{{ $user->is_active ? 'AKTIF' : 'NONAKTIF' }}</span>
                                        @if ($is_protected && $user->is_active)
                                            <span class="badge-protected" title="{{ $protection_reason }}">
                                                <i class="fas fa-shield-alt"></i>
                                            </span>
                                        @endif
                                    </div>
                                    <small style="color: var(--text-muted); font-weight: 500;">
                                        {{ $user->last_login ? date('d/m/Y H:i', strtotime($user->last_login)) : '-' }}
                                    </small>
                                </div>

                                <div class="action-group mt-3">
                                    <button class="action-btn" onclick="editUser({{ json_encode($user) }})"
                                        {{ !$can_edit ? 'disabled' : '' }}>
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    @if ($can_change_password)
                                        <a href="{{ url('/admin/change-password?id=' . $user->id) }}"
                                            class="action-btn" title="Ganti Password">
                                            <i class="fas fa-key"></i>
                                        </a>
                                    @else
                                        <button class="action-btn" disabled>
                                            <i class="fas fa-key"></i>
                                        </button>
                                    @endif

                                    @if ($isSuperAdmin)
                                        @if ($is_locked)
                                            <a href="{{ url('/admin/manage-users?cancel_lockout=' . $user->id) }}"
                                                class="action-btn" onclick="return confirm('Batalkan lockout?')"
                                                title="Batalkan Lockout">
                                                <i class="fas fa-unlock-alt"></i>
                                            </a>
                                        @elseif($user->failed_attempts > 0)
                                            <a href="{{ url('/admin/manage-users?reset_lockout=' . $user->id) }}"
                                                class="action-btn" onclick="return confirm('Reset lockout?')"
                                                title="Reset Lockout">
                                                <i class="fas fa-redo"></i>
                                            </a>
                                        @endif
                                    @endif

                                    @if ($can_delete && $isSuperAdmin)
                                        <a href="{{ url('/admin/manage-users?delete=' . $user->id) }}"
                                            class="action-btn danger"
                                            onclick="return confirm('Yakin hapus admin ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @else
                                        <button class="action-btn" disabled>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Floating Action Button for Mobile -->
            @if ($isSuperAdmin)
                <div class="d-block d-md-none" style="position: fixed; bottom: 24px; right: 24px; z-index: 100;">
                    <button class="btn-add-admin" data-bs-toggle="modal" data-bs-target="#addModal"
                        style="width: 56px; height: 56px; border-radius: 50%; padding: 0; justify-content: center;">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Tambah (hanya untuk superadmin) -->
    @if ($isSuperAdmin)
        <div class="modal fade" id="addModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content"
                    style="border: none; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
                    <form method="POST" action="{{ url('/admin/manage-users/store') }}">
                        @csrf
                        <div class="modal-header"
                            style="border-bottom: 1px solid var(--border-light); padding: 20px 24px;">
                            <h5 class="modal-title" style="font-weight: 700; font-size: 1.125rem;">Tambah Admin Baru
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" style="padding: 24px;">
                            <div class="mb-3">
                                <label
                                    style="font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; display: block;">Username</label>
                                <input type="text" name="username" class="form-control" required
                                    style="border-radius: 8px; border: 1px solid var(--border-subtle); padding: 8px 12px;">
                            </div>
                            <div class="mb-3">
                                <label
                                    style="font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; display: block;">Password</label>
                                <input type="password" name="password" class="form-control" required minlength="6"
                                    style="border-radius: 8px; border: 1px solid var(--border-subtle); padding: 8px 12px;">
                                <small style="color: var(--text-muted); font-size: 0.75rem;">Minimal 6 karakter</small>
                            </div>
                            <div class="mb-3">
                                <label
                                    style="font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; display: block;">Email</label>
                                <input type="email" name="email" class="form-control"
                                    style="border-radius: 8px; border: 1px solid var(--border-subtle); padding: 8px 12px;">
                            </div>
                            <div class="mb-3">
                                <label
                                    style="font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; display: block;">Role</label>
                                <select name="role" class="form-select" required
                                    style="border-radius: 8px; border: 1px solid var(--border-subtle); padding: 8px 12px;">
                                    <option value="admin">Admin</option>
                                    <option value="superadmin">Superadmin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer"
                            style="border-top: 1px solid var(--border-light); padding: 16px 24px;">
                            <button type="button" class="btn" data-bs-dismiss="modal"
                                style="background: var(--canvas-bg); color: var(--text-secondary); border: 1px solid var(--border-subtle); border-radius: 8px; font-weight: 600; padding: 8px 16px;">Batal</button>
                            <button type="submit" class="btn"
                                style="background: #1e293b; color: white; border: none; border-radius: 8px; font-weight: 600; padding: 8px 16px;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="border: none; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
                <form method="POST" action="{{ url('/admin/manage-users/update') }}">
                    @csrf
                    <div class="modal-header"
                        style="border-bottom: 1px solid var(--border-light); padding: 20px 24px;">
                        <h5 class="modal-title" style="font-weight: 700; font-size: 1.125rem;">Edit Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="padding: 24px;">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label
                                style="font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; display: block;">Username</label>
                            <input type="text" name="username" id="edit_username" class="form-control" required
                                style="border-radius: 8px; border: 1px solid var(--border-subtle); padding: 8px 12px;">
                        </div>
                        <div class="mb-3">
                            <label
                                style="font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; display: block;">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control"
                                style="border-radius: 8px; border: 1px solid var(--border-subtle); padding: 8px 12px;">
                        </div>

                        <div class="mb-3">
                            <label
                                style="font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; display: block;">Role</label>
                            <select name="role" id="edit_role" class="form-select" required
                                style="border-radius: 8px; border: 1px solid var(--border-subtle); padding: 8px 12px;">
                                <option value="admin">Admin</option>
                                <option value="superadmin">Superadmin</option>
                            </select>
                        </div>

                        <div class="mb-3 form-check" style="display: flex; align-items: center; gap: 8px;">
                            <input type="checkbox" name="is_active" id="edit_is_active" class="form-check-input"
                                style="border-radius: 4px;">
                            <label class="form-check-label" for="edit_is_active"
                                style="font-weight: 600; font-size: 0.875rem;">Aktif</label>
                        </div>

                        <div id="protection_info" class="alert alert-info d-none"
                            style="border-radius: 8px; border: 1px solid #bfdbfe; background: #eff6ff;">
                            <small style="color: #1e40af;">
                                <i class="fas fa-info-circle me-1"></i>
                                <span id="protection_message"></span>
                            </small>
                        </div>

                        <div id="last_active_warning" class="alert alert-warning d-none"
                            style="border-radius: 8px; border: 1px solid #fde68a; background: #fffbeb;">
                            <small style="color: #92400e;">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                <span id="last_active_message"></span>
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid var(--border-light); padding: 16px 24px;">
                        <button type="button" class="btn" data-bs-dismiss="modal"
                            style="background: var(--canvas-bg); color: var(--text-secondary); border: 1px solid var(--border-subtle); border-radius: 8px; font-weight: 600; padding: 8px 16px;">Batal</button>
                        <button type="submit" class="btn"
                            style="background: #1e293b; color: white; border: none; border-radius: 8px; font-weight: 600; padding: 8px 16px;">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            if ($(window).width() >= 768) {
                $('#usersTableDesktop').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/id.json"
                    },
                    "pageLength": 10,
                    "autoWidth": false,
                    "columnDefs": [{
                        "orderable": false,
                        "targets": [6]
                    }]
                });
            }

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            $(window).resize(function() {
                if ($(window).width() < 768) {
                    $('.modal').modal('hide');
                }
            });

            if ($(window).width() < 768) {
                $('.modal').on('show.bs.modal', function() {
                    $('.modal-dialog').css({
                        'margin': '10px',
                        'max-width': 'calc(100% - 20px)'
                    });
                });
            }
        });

        function editUser(user) {
            document.getElementById('edit_id').value = user.id;
            document.getElementById('edit_username').value = user.username;
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_role').value = user.role;
            document.getElementById('edit_is_active').checked = user.is_active == 1;

            const protectionInfo = document.getElementById('protection_info');
            const protectionMessage = document.getElementById('protection_message');
            const lastActiveWarning = document.getElementById('last_active_warning');
            const lastActiveMessage = document.getElementById('last_active_message');
            const isActiveCheckbox = document.getElementById('edit_is_active');
            const roleSelect = document.getElementById('edit_role');
            const currentUserRole = '{{ $currentUserRole }}';
            const currentUserId = {{ $currentUserId }};
            const isSuperAdmin = currentUserRole === 'superadmin';

            protectionInfo.classList.add('d-none');
            lastActiveWarning.classList.add('d-none');
            isActiveCheckbox.disabled = false;
            roleSelect.disabled = false;

            document.getElementById('edit_username').disabled = false;
            document.getElementById('edit_email').disabled = false;

            if (user.role === 'superadmin' && !isSuperAdmin) {
                protectionInfo.classList.remove('d-none');
                protectionMessage.textContent = 'Admin biasa tidak dapat mengedit akun superadmin.';

                document.getElementById('edit_username').disabled = true;
                document.getElementById('edit_email').disabled = true;
                roleSelect.disabled = true;
                isActiveCheckbox.disabled = true;

                if (user.is_active == 0) {
                    protectionMessage.textContent = 'Admin biasa dapat mengaktifkan akun superadmin yang non-aktif.';
                    isActiveCheckbox.disabled = false;
                    isActiveCheckbox.checked = true;
                }
            }

            if (user.other_active_count == 0 && user.is_active == 1) {
                isActiveCheckbox.checked = true;
                isActiveCheckbox.disabled = true;
                lastActiveWarning.classList.remove('d-none');
                lastActiveMessage.textContent = 'PERINGATAN: Ini adalah akun aktif terakhir. Tidak dapat dinonaktifkan.';
            }

            if (user.id == currentUserId) {
                roleSelect.disabled = true;
                isActiveCheckbox.disabled = true;

                @if (isset($isLastActive) && $isLastActive)
                    isActiveCheckbox.checked = true;
                    lastActiveWarning.classList.remove('d-none');
                    lastActiveMessage.textContent =
                        'PERINGATAN: Anda adalah akun aktif terakhir. Tidak dapat dinonaktifkan.';
                @else
                    protectionInfo.classList.remove('d-none');
                    protectionMessage.textContent = 'Anda hanya dapat mengubah username dan email akun sendiri.';
                @endif
            }

            if (!isSuperAdmin) {
                roleSelect.querySelector('option[value="superadmin"]').disabled = true;

                if (user.role !== 'superadmin' && user.is_active == 0) {
                    isActiveCheckbox.disabled = false;
                    isActiveCheckbox.checked = true;
                    protectionInfo.classList.remove('d-none');
                    protectionMessage.textContent = 'Admin biasa dapat mengaktifkan akun admin yang non-aktif.';
                }
            }

            const bootstrapModal = new bootstrap.Modal(document.getElementById('editModal'));
            bootstrapModal.show();
        }
    </script>
</body>

</html>
