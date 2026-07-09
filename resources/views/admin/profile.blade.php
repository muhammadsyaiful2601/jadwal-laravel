<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Admin Panel</title>
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
            --accent-light: #dbeafe;
            --success-light: #d1fae5;
            --success-text: #059669;
            --danger-soft: #fee2e2;
            --danger-text: #dc2626;
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
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-header-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .page-header-subtitle {
            font-size: 0.9375rem;
            color: var(--text-muted);
            font-weight: 400;
        }

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

        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .profile-info h4 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .profile-info p {
            color: var(--text-muted);
            margin: 0;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.9375rem;
            color: var(--text-primary);
            background: white;
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-control-plaintext {
            padding: 10px 0;
            font-size: 0.9375rem;
            color: var(--text-primary);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }

        .btn-secondary {
            background: var(--canvas-bg);
            color: var(--text-secondary);
            border: 1px solid var(--border-subtle);
        }

        .btn-secondary:hover {
            background: var(--border-light);
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 10px;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    @include('components.admin.sidebar')

    <div class="main-content">
        <!-- Mobile Sidebar -->
        <div class="collapse d-md-none mb-4" id="mobileSidebar">
            <div class="card">
                <div class="card-body p-3">
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ url('/admin/dashboard') }}"><i class="fas fa-tachometer-alt"></i>
                            Dashboard</a>
                        <a class="nav-link" href="{{ url('/admin/manage-schedule') }}"><i class="fas fa-calendar"></i>
                            Kelola Jadwal</a>
                        <a class="nav-link" href="{{ url('/admin/manage-rooms') }}"><i class="fas fa-door-open"></i>
                            Kelola Ruangan</a>
                        <a class="nav-link" href="{{ url('/admin/manage-semester') }}"><i
                                class="fas fa-calendar-alt"></i> Kelola Semester</a>
                        <a class="nav-link" href="{{ url('/admin/manage-settings') }}"><i class="fas fa-cog"></i>
                            Pengaturan</a>
                        <a class="nav-link" href="{{ url('/admin/manage-users') }}"><i class="fas fa-users"></i> Kelola
                            Admin</a>
                        <a class="nav-link" href="{{ url('/admin/reports') }}"><i class="fas fa-chart-bar"></i>
                            Laporan</a>
                        <a class="nav-link" href="{{ url('/admin/saran') }}"><i class="fas fa-comments"></i> Kritik &
                            Saran</a>
                        <a class="nav-link" href="{{ url('/admin/maintenance') }}"><i class="fas fa-tools"></i>
                            Maintenance</a>
                        <hr>
                        <a class="nav-link active" href="{{ url('/admin/profile') }}"><i class="fas fa-user"></i>
                            Profile</a>
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
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <button class="btn btn-light d-md-none me-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#mobileSidebar">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h4 class="d-inline">Profile</h4>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="text-muted"><i class="far fa-calendar-alt me-1"></i> {{ date('d F Y') }}</span>
                    </div>
                </div>
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
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 8px;">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="profile-header">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(session('username'), 0, 1)) }}
                    </div>
                    <div class="profile-info">
                        <h4>{{ session('username') }}</h4>
                        <p>{{ ucfirst(session('role')) }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ url('/admin/profile/update') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control"
                                value="{{ old('username', $user->username) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}">
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem;">Ubah Password</h5>
                    <p class="text-muted" style="font-size: 0.875rem;">Kosongkan jika tidak ingin mengubah password
                    </p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="new_password" class="form-control" minlength="6">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="confirm_password" class="form-control" minlength="6">
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
