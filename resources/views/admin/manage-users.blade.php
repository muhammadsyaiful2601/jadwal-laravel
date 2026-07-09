<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Kelola Admin - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #2c3e50, #4a6491);
            color: white;
            min-height: 100vh;
            position: fixed;
            width: 250px;
            z-index: 1000;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .navbar-custom {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .content-wrapper {
            padding-top: 20px;
        }

        .page-header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .protection-badge {
            font-size: 0.7rem;
            padding: 2px 6px;
            margin-left: 5px;
        }

        .protection-tooltip {
            position: relative;
            cursor: help;
        }

        .protection-tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            white-space: nowrap;
            z-index: 1000;
        }

        .row-protected {
            background-color: #fff8e1 !important;
        }

        .row-locked {
            background-color: #ffe6e6 !important;
        }

        .btn-add-disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-eye {
            background-color: #20c997;
            border-color: #20c997;
            color: white;
        }

        .btn-eye:hover {
            background-color: #1ba87e;
            border-color: #1ba87e;
            color: white;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: fixed;
                min-height: 100vh;
                display: none;
                z-index: 1050;
                top: 0;
                left: 0;
            }

            .sidebar.mobile-show {
                display: block;
            }

            .main-content {
                margin-left: 0;
                padding: 10px;
                width: 100%;
                overflow-x: hidden;
            }

            .navbar-custom {
                position: sticky;
                top: 0;
                z-index: 1030;
                padding: 10px 0;
            }

            .page-header {
                padding: 15px;
                margin: 0 -10px 15px -10px;
                width: calc(100% + 20px);
                border-radius: 0;
            }

            .page-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .table-container {
                padding: 10px;
                margin: 0 -10px;
                width: calc(100% + 20px);
                border-radius: 0;
            }

            .btn-group .btn {
                padding: 0.25rem 0.4rem;
                font-size: 0.75rem;
            }

            body {
                overflow-x: hidden;
                max-width: 100vw;
            }

            .modal-dialog {
                margin: 10px !important;
                max-width: calc(100% - 20px) !important;
            }
        }

        @media (max-width: 575.98px) {
            .main-content {
                padding: 10px 8px;
            }

            .page-header h5 {
                font-size: 1.1rem;
            }

            .table-container {
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar (Desktop) -->
        <div class="sidebar d-none d-md-block">
            <div class="p-4">
                <h3 class="mb-4"><i class="fas fa-calendar-alt"></i> Admin Panel</h3>
                <div class="user-info mb-4">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3">
                            {{ strtoupper(substr(session('username'), 0, 1)) }}
                        </div>
                        <div>
                            <h6 class="mb-0">{{ session('username') }}</h6>
                            <small class="text-muted">{{ ucfirst(session('role')) }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                    href="{{ url('/admin/dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->is('admin/manage-schedule') ? 'active' : '' }}"
                    href="{{ url('/admin/manage-schedule') }}">
                    <i class="fas fa-calendar"></i> Kelola Jadwal
                </a>
                <a class="nav-link {{ request()->is('admin/manage-rooms') ? 'active' : '' }}"
                    href="{{ url('/admin/manage-rooms') }}">
                    <i class="fas fa-door-open"></i> Kelola Ruangan
                </a>
                <a class="nav-link {{ request()->is('admin/manage-semester') ? 'active' : '' }}"
                    href="{{ url('/admin/manage-semester') }}">
                    <i class="fas fa-calendar-alt"></i> Kelola Semester
                </a>
                <a class="nav-link {{ request()->is('admin/manage-settings') ? 'active' : '' }}"
                    href="{{ url('/admin/manage-settings') }}">
                    <i class="fas fa-cog"></i> Pengaturan
                </a>
                <a class="nav-link {{ request()->is('admin/manage-users') ? 'active' : '' }}"
                    href="{{ url('/admin/manage-users') }}">
                    <i class="fas fa-users"></i> Kelola Admin
                </a>
                <a class="nav-link {{ request()->is('admin/reports') ? 'active' : '' }}"
                    href="{{ url('/admin/reports') }}">
                    <i class="fas fa-chart-bar"></i> Laporan
                </a>
                <div class="mt-4"></div>
                <a class="nav-link {{ request()->is('admin/profile') ? 'active' : '' }}"
                    href="{{ url('/admin/profile') }}">
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

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-custom mb-4">
                <div class="container-fluid">
                    <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse"
                        data-bs-target="#mobileSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0">Kelola Admin</h4>
                        @if (!$isSuperAdmin)
                            <span class="badge bg-info ms-2">Mode Terbatas</span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-3 d-none d-md-block">{{ date('d F Y') }}</span>
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                {{ session('username') }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ url('/admin/profile') }}">
                                        <i class="fas fa-user me-2"></i>Profile
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ url('/logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item text-danger border-0 bg-transparent">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Mobile Sidebar -->
            <div class="collapse d-md-none mb-4" id="mobileSidebar">
                <div class="card">
                    <div class="card-body">
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

            <!-- Content -->
            <div class="content-wrapper">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Daftar Admin</h5>
                            <p class="text-muted mb-0">Kelola pengguna dengan akses admin</p>
                            <small class="text-info">
                                <i class="fas fa-info-circle"></i>
                                {{ $active_count ?? 0 }} akun aktif dari {{ count($users) }} total akun
                                @if (!$isSuperAdmin)
                                    <span class="badge bg-warning ms-2">Hanya dapat melihat dan mengaktifkan akun
                                        non-aktif</span>
                                @endif
                            </small>
                        </div>
                        @if ($isSuperAdmin)
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="fas fa-plus me-2"></i>Tambah Admin
                            </button>
                        @else
                            <button class="btn btn-primary btn-add-disabled" disabled
                                title="Hanya superadmin yang dapat menambah admin">
                                <i class="fas fa-plus me-2"></i>Tambah Admin
                            </button>
                        @endif
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Info untuk admin biasa -->
                @if (!$isSuperAdmin)
                    <div class="alert alert-info mb-3">
                        <h6><i class="fas fa-info-circle me-2"></i>Informasi Hak Akses</h6>
                        <p class="mb-0">Sebagai <strong>Admin Biasa</strong>, Anda dapat:</p>
                        <ul class="mb-0">
                            <li>Melihat daftar semua admin</li>
                            <li>Mengaktifkan akun admin biasa yang non-aktif</li>
                            <li>Mengedit username dan email akun sendiri</li>
                            <li><strong>Tidak dapat:</strong> mengedit superadmin, menonaktifkan superadmin, menghapus
                                admin, menambah admin baru</li>
                        </ul>
                    </div>
                @endif

                <!-- Data Table -->
                <div class="table-container">
                    <!-- Desktop View - Table -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover" id="usersTableDesktop">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status & Lockout</th>
                                    <th>Terakhir Login</th>
                                    <th>Aksi</th>
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
                                        $can_view_activity = false;
                                        $is_locked = false;
                                        $lockout_info = '';

                                        // Cek apakah akun terkunci
                                        if (
                                            isset($user->locked_until) &&
                                            $user->locked_until &&
                                            strtotime($user->locked_until) > time()
                                        ) {
                                            $is_locked = true;
                                            $remaining = strtotime($user->locked_until) - time();
                                            $lockout_info = $this->formatLockoutTime($remaining);
                                        }

                                        // Cek proteksi untuk admin biasa
                                        if (!$isSuperAdmin) {
                                            if ($user->role == 'superadmin') {
                                                $is_protected = true;
                                                $protection_reason = 'Superadmin - hanya dapat dilihat';
                                                $can_edit = false;
                                                $can_delete = false;
                                                $can_change_password = false;
                                                $can_view_activity = false;
                                            }

                                            if ($user->id != $currentUserId) {
                                                $can_delete = false;
                                            }

                                            if ($user->id == $currentUserId) {
                                                $can_change_password = true;
                                            }

                                            $can_view_activity = false;
                                        } else {
                                            $can_change_password = true;

                                            if ($user->id != $currentUserId) {
                                                $can_view_activity = true;
                                            }
                                        }

                                        // Cek proteksi akun aktif terakhir
                                        if ($user->other_active_count == 0 && $user->is_active) {
                                            $is_protected = true;
                                            $protection_reason = 'Akun aktif terakhir';
                                            $can_delete = false;
                                        }
                                    @endphp
                                    <tr
                                        class="{{ $user->id == $currentUserId ? 'table-info' : '' }} {{ $is_protected ? 'row-protected' : '' }} {{ $is_locked ? 'row-locked' : '' }}">
                                        <td>{{ $no++ }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-2"
                                                    style="width: 30px; height: 30px; font-size: 0.8rem;">
                                                    {{ strtoupper(substr($user->username, 0, 1)) }}
                                                </div>
                                                {{ $user->username }}
                                                @if ($user->id == $currentUserId)
                                                    <span class="badge bg-info protection-badge">Anda</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $user->email ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $user->role == 'superadmin' ? 'danger' : 'primary' }}">
                                                {{ strtoupper($user->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <span
                                                    class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }}">
                                                    {{ $user->is_active ? 'AKTIF' : 'NONAKTIF' }}
                                                </span>
                                                @if ($is_protected && $user->is_active)
                                                    <span class="badge bg-warning protection-badge protection-tooltip"
                                                        data-tooltip="{{ $protection_reason }}"
                                                        data-bs-toggle="tooltip" title="{{ $protection_reason }}">
                                                        <i class="fas fa-shield-alt"></i>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="lockout-info">
                                                @if ($is_locked)
                                                    <span class="badge bg-danger"
                                                        title="Terkunci sampai {{ date('d/m/Y H:i', strtotime($user->locked_until)) }}">
                                                        <i class="fas fa-lock"></i> Terkunci
                                                    </span>
                                                @elseif($user->failed_attempts > 0)
                                                    <span class="badge bg-warning"
                                                        title="Percobaan gagal: {{ $user->failed_attempts }}">
                                                        <i class="fas fa-exclamation-triangle"></i> Gagal:
                                                        {{ $user->failed_attempts }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $user->last_login ? date('d/m/Y H:i', strtotime($user->last_login)) : '-' }}
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-warning"
                                                    onclick="editUser({{ json_encode($user) }})"
                                                    {{ !$can_edit ? 'disabled' : '' }}
                                                    @if (!$can_edit) title="{{ $protection_reason }}" @endif>
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                @if ($can_change_password)
                                                    <a href="{{ url('/admin/change-password?id=' . $user->id) }}"
                                                        class="btn btn-sm btn-info" title="Ganti Password">
                                                        <i class="fas fa-key"></i>
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-info" disabled
                                                        title="Hanya dapat mengganti password sendiri">
                                                        <i class="fas fa-key"></i>
                                                    </button>
                                                @endif

                                                @if ($isSuperAdmin)
                                                    @if ($is_locked)
                                                        <a href="{{ url('/admin/manage-users?cancel_lockout=' . $user->id) }}"
                                                            class="btn btn-sm btn-warning"
                                                            onclick="return confirm('Batalkan lockout untuk akun ini?')"
                                                            title="Batalkan Lockout">
                                                            <i class="fas fa-unlock-alt"></i>
                                                        </a>
                                                    @elseif($user->failed_attempts > 0)
                                                        <a href="{{ url('/admin/manage-users?reset_lockout=' . $user->id) }}"
                                                            class="btn btn-sm btn-info"
                                                            onclick="return confirm('Reset lockout untuk akun ini?')"
                                                            title="Reset Lockout">
                                                            <i class="fas fa-redo"></i>
                                                        </a>
                                                    @endif
                                                @endif

                                                @if ($can_delete && $isSuperAdmin)
                                                    <a href="{{ url('/admin/manage-users?delete=' . $user->id) }}"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Yakin hapus admin ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-danger" disabled
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

                    <!-- Mobile View -->
                    <div class="d-block d-md-none" id="mobileUserList">
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
                            <div
                                class="card mb-3 {{ $user->id == $currentUserId ? 'border-info' : '' }} {{ $is_protected ? 'border-warning' : '' }} {{ $is_locked ? 'border-danger' : '' }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2"
                                                style="width: 35px; height: 35px; font-size: 0.9rem;">
                                                {{ strtoupper(substr($user->username, 0, 1)) }}
                                            </div>
                                            <div>
                                                <strong>{{ $user->username }}</strong>
                                                @if ($user->id == $currentUserId)
                                                    <span class="badge bg-info ms-1">Anda</span>
                                                @endif
                                            </div>
                                        </div>
                                        <span
                                            class="badge bg-{{ $user->role == 'superadmin' ? 'danger' : 'primary' }}">
                                            {{ strtoupper($user->role) }}
                                        </span>
                                    </div>

                                    <div class="mb-2">
                                        <small class="text-muted">Email:</small>
                                        <div class="small">{{ $user->email ?? '-' }}</div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }}">
                                                {{ $user->is_active ? 'AKTIF' : 'NONAKTIF' }}
                                            </span>
                                            @if ($is_protected && $user->is_active)
                                                <span class="badge bg-warning ms-1" title="{{ $protection_reason }}">
                                                    <i class="fas fa-shield-alt"></i>
                                                </span>
                                            @endif
                                        </div>
                                        <small
                                            class="text-muted">{{ $user->last_login ? date('d/m/Y H:i', strtotime($user->last_login)) : '-' }}</small>
                                    </div>

                                    @if ($is_locked)
                                        <div class="alert alert-danger py-2 mb-2">
                                            <small><i class="fas fa-lock me-1"></i> Terkunci:
                                                {{ $lockout_info }}</small>
                                        </div>
                                    @endif

                                    <div class="d-flex flex-wrap gap-1 mt-3">
                                        <button class="btn btn-sm btn-warning"
                                            onclick="editUser({{ json_encode($user) }})"
                                            {{ !$can_edit ? 'disabled' : '' }}>
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        @if ($can_change_password)
                                            <a href="{{ url('/admin/change-password?id=' . $user->id) }}"
                                                class="btn btn-sm btn-info" title="Ganti Password">
                                                <i class="fas fa-key"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-info" disabled>
                                                <i class="fas fa-key"></i>
                                            </button>
                                        @endif

                                        @if ($isSuperAdmin)
                                            @if ($is_locked)
                                                <a href="{{ url('/admin/manage-users?cancel_lockout=' . $user->id) }}"
                                                    class="btn btn-sm btn-warning"
                                                    onclick="return confirm('Batalkan lockout?')"
                                                    title="Batalkan Lockout">
                                                    <i class="fas fa-unlock-alt"></i>
                                                </a>
                                            @elseif($user->failed_attempts > 0)
                                                <a href="{{ url('/admin/manage-users?reset_lockout=' . $user->id) }}"
                                                    class="btn btn-sm btn-info"
                                                    onclick="return confirm('Reset lockout?')" title="Reset Lockout">
                                                    <i class="fas fa-redo"></i>
                                                </a>
                                            @endif
                                        @endif

                                        @if ($can_delete && $isSuperAdmin)
                                            <a href="{{ url('/admin/manage-users?delete=' . $user->id) }}"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus admin ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-danger" disabled>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah (hanya untuk superadmin) -->
    @if ($isSuperAdmin)
        <div class="modal fade" id="addModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ url('/admin/manage-users/store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Admin Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required minlength="6">
                                <small class="text-muted">Minimal 6 karakter</small>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Role</label>
                                <select name="role" class="form-control" required>
                                    <option value="admin">Admin</option>
                                    <option value="superadmin">Superadmin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('/admin/manage-users/update') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" id="edit_username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Role</label>
                            <select name="role" id="edit_role" class="form-control" required>
                                <option value="admin">Admin</option>
                                <option value="superadmin">Superadmin</option>
                            </select>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" id="edit_is_active" class="form-check-input">
                            <label class="form-check-label" for="edit_is_active">Aktif</label>
                        </div>

                        <div id="protection_info" class="alert alert-info d-none">
                            <small>
                                <i class="fas fa-info-circle"></i>
                                <span id="protection_message"></span>
                            </small>
                        </div>

                        <div id="last_active_warning" class="alert alert-warning d-none">
                            <small>
                                <i class="fas fa-exclamation-triangle"></i>
                                <span id="last_active_message"></span>
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
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
            // Only initialize DataTables on desktop
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

            // Inisialisasi tooltip
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Handle window resize
            $(window).resize(function() {
                if ($(window).width() < 768) {
                    $('.modal').modal('hide');
                }
            });

            // Adjust modal for mobile
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

            // Proteksi logika
            const protectionInfo = document.getElementById('protection_info');
            const protectionMessage = document.getElementById('protection_message');
            const lastActiveWarning = document.getElementById('last_active_warning');
            const lastActiveMessage = document.getElementById('last_active_message');
            const isActiveCheckbox = document.getElementById('edit_is_active');
            const roleSelect = document.getElementById('edit_role');
            const currentUserRole = '{{ $currentUserRole }}';
            const currentUserId = {{ $currentUserId }};
            const isSuperAdmin = currentUserRole === 'superadmin';

            // Reset semua proteksi
            protectionInfo.classList.add('d-none');
            lastActiveWarning.classList.add('d-none');
            isActiveCheckbox.disabled = false;
            roleSelect.disabled = false;

            // Reset semua input
            document.getElementById('edit_username').disabled = false;
            document.getElementById('edit_email').disabled = false;

            // 1. Jika ini adalah akun SUPERADMIN dan user yang login bukan superadmin
            if (user.role === 'superadmin' && !isSuperAdmin) {
                // Admin biasa tidak bisa mengedit superadmin sama sekali
                protectionInfo.classList.remove('d-none');
                protectionMessage.textContent = 'Admin biasa tidak dapat mengedit akun superadmin.';

                // Nonaktifkan semua input
                document.getElementById('edit_username').disabled = true;
                document.getElementById('edit_email').disabled = true;
                roleSelect.disabled = true;
                isActiveCheckbox.disabled = true;

                // Jika superadmin non-aktif, admin biasa bisa mengaktifkan
                if (user.is_active == 0) {
                    protectionMessage.textContent = 'Admin biasa dapat mengaktifkan akun superadmin yang non-aktif.';
                    isActiveCheckbox.disabled = false;
                    isActiveCheckbox.checked = true;
                }
            }

            // 2. Jika ini adalah akun aktif terakhir
            if (user.other_active_count == 0 && user.is_active == 1) {
                isActiveCheckbox.checked = true;
                isActiveCheckbox.disabled = true;
                lastActiveWarning.classList.remove('d-none');
                lastActiveMessage.textContent = 'PERINGATAN: Ini adalah akun aktif terakhir. Tidak dapat dinonaktifkan.';
            }

            // 3. Jika user mencoba mengedit akun sendiri
            if (user.id == currentUserId) {
                // User tidak bisa mengubah role sendiri
                roleSelect.disabled = true;

                // User tidak bisa menonaktifkan diri sendiri
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

            // 4. Validasi tambahan untuk admin biasa
            if (!isSuperAdmin) {
                // Admin biasa tidak bisa mengubah role menjadi superadmin
                roleSelect.querySelector('option[value="superadmin"]').disabled = true;

                // Admin biasa hanya bisa mengaktifkan akun yang non-aktif (kecuali superadmin)
                if (user.role !== 'superadmin' && user.is_active == 0) {
                    // Bisa mengaktifkan
                    isActiveCheckbox.disabled = false;
                    isActiveCheckbox.checked = true;
                    protectionInfo.classList.remove('d-none');
                    protectionMessage.textContent = 'Anda dapat mengaktifkan akun admin ini.';
                } else if (user.role !== 'superadmin' && user.is_active == 1) {
                    // Tidak bisa menonaktifkan
                    isActiveCheckbox.disabled = true;
                    protectionInfo.classList.remove('d-none');
                    protectionMessage.textContent = 'Admin biasa tidak dapat menonaktifkan admin lain.';
                }
            }

            document.getElementById('editModal').querySelector('form').action = '{{ url('/admin/manage-users/update') }}';
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        // Validasi form sebelum submit
        document.querySelector('#editModal form').addEventListener('submit', function(e) {
            const userId = document.getElementById('edit_id').value;
            const userRole = document.getElementById('edit_role').value;
            const isActive = document.getElementById('edit_is_active').checked;
            const currentUserRole = '{{ $currentUserRole }}';
            const currentUserId = {{ $currentUserId }};
            const isSuperAdmin = currentUserRole === 'superadmin';

            // Validasi: Admin biasa tidak bisa mengubah role menjadi superadmin
            if (!isSuperAdmin && userRole === 'superadmin') {
                e.preventDefault();
                alert('Error: Admin biasa tidak dapat membuat atau mengubah akun menjadi superadmin.');
                return false;
            }

            // Validasi: User tidak bisa menonaktifkan diri sendiri
            if (userId == currentUserId && !isActive) {
                e.preventDefault();
                alert('Error: Tidak dapat menonaktifkan akun sendiri.');
                return false;
            }

            return true;
        });
    </script>
</body>

</html>
