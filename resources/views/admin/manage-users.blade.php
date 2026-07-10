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
            color: var(--zinc-800);
        }

        /* Badges */
        .badge {
            font-size: 0.6875rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-you {
            background: #dbeafe;
            color: #1d4ed8;
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
            background: var(--zinc-100);
            color: var(--zinc-700);
            letter-spacing: 0.02em;
        }

        .badge-role.superadmin {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid var(--zinc-200);
        }

        .badge-status {
            padding: 3px 10px;
            font-size: 0.6875rem;
            font-weight: 600;
            border-radius: 6px;
            background: #d1fae5;
            color: #059669;
        }

        .badge-protected {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #fef3c7;
            color: #b45309;
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
            background: #fee2e2;
            color: #dc2626;
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
            color: var(--zinc-500);
            cursor: pointer;
            transition: all 0.15s ease;
            font-size: 0.875rem;
            text-decoration: none;
        }

        .action-btn:hover {
            background: var(--zinc-50);
            border-color: var(--zinc-200);
            color: var(--zinc-800);
        }

        .action-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }

        .action-btn.edit {
            color: #475569;
        }

        .action-btn.edit:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #1e293b;
        }

        .action-btn.password {
            color: #475569;
        }

        .action-btn.password:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #1e40af;
        }

        .action-btn.danger {
            color: #dc2626;
        }

        .action-btn.danger:hover {
            background: #fee2e2;
            border-color: #fecaca;
            color: #dc2626;
        }

        .action-group {
            display: flex;
            gap: 4px;
        }

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
                <h4>Kelola Admin</h4>
                @if (!$isSuperAdmin)
                    <span class="maintenance-badge-top"><i class="fas fa-info-circle"></i> Mode Terbatas</span>
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
            <!-- Page Header -->
            <div class="page-title-section">
                <h4>Daftar Admin</h4>
                <p>Kelola pengguna dengan akses admin</p>
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

            <!-- Action Button Row -->
            <div class="d-flex justify-content-end mb-3">
                @if ($isSuperAdmin)
                    <button class="btn-add-admin" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus"></i> Tambah Admin
                    </button>
                @endif
            </div>

            <!-- Data Table -->
            <div class="table-card">
                <!-- Desktop View - Table -->
                <div class="table-responsive d-none d-md-block">
                    <div class="table-card-header">
                        <h5><i class="fas fa-users"></i> Daftar Admin</h5>
                    </div>
                    <div class="table-card-body">
                        <table class="table-clean" id="usersTableDesktop">
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
                                                <div class="avatar">{{ strtoupper(substr($user->username, 0, 1)) }}
                                                </div>
                                                <span class="username">{{ $user->username }}</span>
                                                @if ($user->id == $currentUserId)
                                                    <span class="badge-you">Anda</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if ($user->email ?? false)
                                                {{ $user->email }}
                                                @if ($user->role !== 'superadmin' && $isSuperAdmin)
                                                    @if ($user->email_verified_at)
                                                        <span class="badge-status"
                                                            style="background: #d1fae5; color: #059669; font-size: 0.65rem; padding: 2px 6px; margin-left: 4px;">
                                                            <i class="fas fa-check-circle"></i> Terverifikasi
                                                        </span>
                                                    @else
                                                        <span class="badge-status"
                                                            style="background: #fef3c7; color: #b45309; font-size: 0.65rem; padding: 2px 6px; margin-left: 4px;">
                                                            <i class="fas fa-clock"></i> Belum Verifikasi
                                                        </span>
                                                    @endif
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
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
                                                <button class="action-btn edit"
                                                    onclick="editUser({{ json_encode($user) }})"
                                                    {{ !$can_edit ? 'disabled' : '' }}
                                                    @if (!$can_edit) title="{{ $protection_reason }}" @endif
                                                    title="Edit Admin">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                @if ($can_change_password)
                                                    <a href="{{ url('/admin/change-password?id=' . $user->id) }}"
                                                        class="action-btn password" title="Ganti Password">
                                                        <i class="fas fa-key"></i>
                                                    </a>
                                                @else
                                                    <button class="action-btn password" disabled
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
                                                    @if ($user->role !== 'superadmin' && !$user->email_verified_at && $user->email)
                                                        <a href="{{ url('/admin/manage-users/send-verification?verify=' . $user->id) }}"
                                                            class="action-btn" style="color: #16a34a;"
                                                            onclick="return confirm('Kirim link verifikasi ke email {{ $user->email }}?')"
                                                            title="Kirim Verifikasi">
                                                            <i class="fas fa-paper-plane"></i>
                                                        </a>
                                                    @endif
                                                @endif

                                                @if ($can_delete && $isSuperAdmin)
                                                    <a href="{{ url('/admin/manage-users?delete=' . $user->id) }}"
                                                        class="action-btn danger"
                                                        onclick="return confirm('Yakin hapus admin ini?')"
                                                        title="Hapus Admin">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                @else
                                                    <button class="action-btn danger" disabled
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
                        <div class="card mb-3" style="border: 1px solid var(--zinc-200); border-radius: 12px;">
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
                                    <small style="color: var(--zinc-500); font-weight: 500;">Email:</small>
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
                                    <small style="color: var(--zinc-500); font-weight: 500;">
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
                            style="border-bottom: 1px solid var(--zinc-100); padding: 20px 24px;">
                            <h5 class="modal-title" style="font-weight: 700; font-size: 1.125rem;">Tambah Admin Baru
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" style="padding: 24px;">
                            <div class="mb-3">
                                <label
                                    style="font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; display: block;">Username</label>
                                <input type="text" name="username" class="form-control" required
                                    style="border-radius: 8px; border: 1px solid var(--zinc-200); padding: 8px 12px;">
                            </div>
                            <div class="mb-3">
                                <label
                                    style="font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; display: block;">Password</label>
                                <input type="password" name="password" class="form-control" required minlength="6"
                                    style="border-radius: 8px; border: 1px solid var(--zinc-200); padding: 8px 12px;">
                                <small style="color: var(--zinc-500); font-size: 0.75rem;">Minimal 6 karakter</small>
                            </div>
                            <div class="mb-3">
                                <label
                                    style="font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; display: block;">Email</label>
                                <input type="email" name="email" class="form-control"
                                    style="border-radius: 8px; border: 1px solid var(--zinc-200); padding: 8px 12px;">
                            </div>
                            <div class="mb-3">
                                <label
                                    style="font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; display: block;">Role</label>
                                <select name="role" class="form-select" required
                                    style="border-radius: 8px; border: 1px solid var(--zinc-200); padding: 8px 12px;">
                                    <option value="admin">Admin</option>
                                    <option value="superadmin">Superadmin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid var(--zinc-100); padding: 16px 24px;">
                            <button type="button" class="btn" data-bs-dismiss="modal"
                                style="background: var(--zinc-50); color: var(--zinc-700); border: 1px solid var(--zinc-200); border-radius: 8px; font-weight: 600; padding: 8px 16px;">Batal</button>
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
                    <div class="modal-header" style="border-bottom: 1px solid var(--zinc-100); padding: 20px 24px;">
                        <h5 class="modal-title" style="font-weight: 700; font-size: 1.125rem;">Edit Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="padding: 24px;">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label
                                style="font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; display: block;">Username</label>
                            <input type="text" name="username" id="edit_username" class="form-control" required
                                style="border-radius: 8px; border: 1px solid var(--zinc-200); padding: 8px 12px;">
                        </div>
                        <div class="mb-3">
                            <label
                                style="font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; display: block;">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control"
                                style="border-radius: 8px; border: 1px solid var(--zinc-200); padding: 8px 12px;">
                        </div>

                        <div class="mb-3">
                            <label
                                style="font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; display: block;">Role</label>
                            <select name="role" id="edit_role" class="form-select" required
                                style="border-radius: 8px; border: 1px solid var(--zinc-200); padding: 8px 12px;">
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
                    <div class="modal-footer" style="border-top: 1px solid var(--zinc-100); padding: 16px 24px;">
                        <button type="button" class="btn" data-bs-dismiss="modal"
                            style="background: var(--zinc-50); color: var(--zinc-700); border: 1px solid var(--zinc-200); border-radius: 8px; font-weight: 600; padding: 8px 16px;">Batal</button>
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
            $('#usersTableDesktop').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/id.json",
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Selanjutnya"
                    }
                },
                "pageLength": 10,
                "autoWidth": false,
                "columnDefs": [{
                    "orderable": false,
                    "targets": [6]
                }],
                "dom": '<"row"<"col-sm-12"tr>>rt<"row"<"col-sm-5"i><"col-sm-7"p>>'
            });

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
                protectionMessage.textContent = 'Superadmin - hanya dapat dilihat';
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
