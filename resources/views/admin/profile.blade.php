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
            color: var(--zinc-500);
            margin: 0;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--zinc-700);
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--zinc-200);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.9375rem;
            color: var(--zinc-800);
            background: white;
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--corporate-blue);
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
        }

        .form-control-plaintext {
            padding: 10px 0;
            font-size: 0.9375rem;
            color: var(--zinc-800);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary-custom {
            background: var(--corporate-blue);
            color: white;
        }

        .btn-primary-custom:hover {
            background: var(--corporate-blue-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(29, 78, 216, 0.15);
        }

        .btn-secondary-custom {
            background: var(--zinc-50);
            color: var(--zinc-700);
            border: 1px solid var(--zinc-200);
        }

        .btn-secondary-custom:hover {
            background: var(--zinc-100);
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
                <h4>Profile</h4>
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
                <h4>Profile Saya</h4>
                <p>Kelola informasi akun dan keamanan Anda</p>
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

            <div class="table-card">
                <div class="table-card-header">
                    <h5><i class="fas fa-user-circle"></i> Informasi Akun</h5>
                </div>
                <div class="table-card-body">
                    <div style="padding: 24px;">
                        <div class="profile-header">
                            <div class="profile-avatar">
                                {{ strtoupper(substr(session('username'), 0, 1)) }}
                            </div>
                            <div class="profile-info">
                                <h4>{{ session('username') }}</h4>
                                <p>{{ ucfirst(session('role')) }}</p>
                            </div>
                        </div>

                        @if (session('role') == 'superadmin')
                            <div class="alert {{ $user->email_verified_at ? 'alert-success' : 'alert-warning' }} alert-dismissible fade show mb-4"
                                role="alert" style="border-radius: 8px;">
                                <i
                                    class="fas {{ $user->email_verified_at ? 'fa-check-circle' : 'fa-exclamation-triangle' }} me-2"></i>
                                <strong>Status Email:</strong>
                                @if ($user->email_verified_at)
                                    Terverifikasi ({{ date('d F Y H:i', strtotime($user->email_verified_at)) }})
                                @else
                                    Belum Terverifikasi
                                @endif
                            </div>
                        @endif


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
                                    <div class="input-group">
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $user->email) }}">
                                        @if (session('role') == 'superadmin' && !$user->email_verified_at)
                                            <button type="button" class="btn btn-outline-primary"
                                                style="border-radius: 0 8px 8px 0; border: 1px solid var(--zinc-200);"
                                                onclick="showVerificationModal()">
                                                <i class="fas fa-envelope"></i> Verifikasi
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem;"><i
                                    class="fas fa-lock me-2"></i>Ubah Password</h5>
                            <p style="font-size: 0.875rem; color: var(--zinc-500); margin-bottom: 16px;">Kosongkan jika
                                tidak ingin mengubah password
                            </p>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" name="new_password" class="form-control" minlength="6">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="confirm_password" class="form-control"
                                        minlength="6">
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                                </button>
                                <a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary-custom">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Modal -->
    <div class="modal fade" id="verificationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"
                style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
                <div class="modal-header" style="border-bottom: 1px solid var(--zinc-100); padding: 20px 24px;">
                    <h5 class="modal-title" style="font-weight: 700; font-size: 1.1rem;">
                        <i class="fas fa-envelope me-2" style="color: var(--corporate-blue);"></i>Verifikasi Email
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 24px;">
                    <p style="color: var(--zinc-600); font-size: 0.95rem; margin-bottom: 20px;">
                        Pilih salah satu opsi di bawah ini:
                    </p>

                    @if (!empty($user->email))
                        <div class="d-grid gap-2 mb-3">
                            <form method="POST" action="{{ url('/admin/profile/send-verification') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary-custom w-100" style="padding: 12px;">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim Link Verifikasi ke Email Saat Ini
                                </button>
                            </form>
                        </div>
                    @endif

                    <hr style="border-color: var(--zinc-200);">

                    <h6 style="font-weight: 600; color: var(--zinc-700); margin-bottom: 12px;">
                        <i class="fas fa-plus-circle me-1"></i> Buat Email Baru
                    </h6>
                    <form method="POST" action="{{ url('/admin/profile/update-email') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email Baru</label>
                            <input type="email" name="new_email" class="form-control"
                                placeholder="Masukkan email baru" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <span style="color: #dc2626;">*</span></label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Masukkan password untuk konfirmasi" required>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100" style="padding: 12px;">
                            <i class="fas fa-save me-2"></i> Simpan Email Baru
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showVerificationModal() {
            new bootstrap.Modal(document.getElementById('verificationModal')).show();
        }

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
    </script>
</body>

</html>
