<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - Admin Panel</title>
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

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .toggle-switch {
            position: relative;
            width: 48px;
            height: 24px;
            background: #cbd5e1;
            border-radius: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-switch.active {
            background: #059669;
        }

        .toggle-switch::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .toggle-switch.active::after {
            left: 26px;
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-online {
            background: var(--success-light);
            color: var(--success-text);
        }

        .status-offline {
            background: var(--danger-soft);
            color: var(--danger-text);
        }

        .info-box {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 20px;
        }

        .info-box i {
            color: var(--accent);
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 10px;
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
                        <a class="nav-link active" href="{{ url('/admin/maintenance') }}"><i class="fas fa-tools"></i>
                            Maintenance</a>
                        <hr>
                        <a class="nav-link" href="{{ url('/admin/profile') }}"><i class="fas fa-user"></i> Profile</a>
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
                        <h4 class="d-inline">Maintenance</h4>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="text-muted"><i class="far fa-calendar-alt me-1"></i> {{ date('d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-header">
            <h1 class="page-header-title">Maintenance Mode</h1>
            <p class="page-header-subtitle">Kelola mode maintenance aplikasi</p>
        </div>

        <div class="info-box">
            <div class="d-flex align-items-start gap-2">
                <i class="fas fa-info-circle mt-1"></i>
                <div>
                    <strong>Informasi:</strong>
                    <p class="mb-0" style="font-size: 0.875rem;">Saat mode maintenance aktif, aplikasi akan
                        menampilkan halaman maintenance kepada semua pengguna kecuali admin. Fitur meliputi penjadwalan
                        backup database, pembersihan cache/log, dan pengaturan timeout sesi.</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem;">Backup Database</h5>
                <p class="text-muted" style="font-size: 0.875rem; margin-bottom: 16px;">Backup database untuk menyimpan
                    data penting.</p>

                <div class="d-flex gap-2 flex-wrap">
                    <form method="POST" action="{{ url('/admin/maintenance/backup') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-download me-1"></i> Backup Sekarang
                        </button>
                    </form>
                    <button class="btn btn-secondary" disabled>
                        <i class="fas fa-history me-1"></i> Lihat Riwayat Backup
                    </button>
                </div>

                <hr class="my-4">

                <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem;">Pembersihan Data</h5>
                <p class="text-muted" style="font-size: 0.875rem; margin-bottom: 16px;">Hapus cache, log, dan data
                    sementara untuk mengoptimalkan kinerja aplikasi.</p>

                <div class="d-flex gap-2 flex-wrap">
                    <form method="POST" action="{{ url('/admin/maintenance/clear-cache') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-broom me-1"></i> Clear Cache
                        </button>
                    </form>
                    <form method="POST" action="{{ url('/admin/maintenance/clear-logs') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-file-alt me-1"></i> Clear Logs
                        </button>
                    </form>
                </div>

                <hr class="my-4">

                <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem;">Pengaturan Sesi</h5>
                <p class="text-muted" style="font-size: 0.875rem; margin-bottom: 16px;">Atur batas waktu sesi login
                    untuk keamanan.</p>

                <form method="POST" action="{{ url('/admin/maintenance/session') }}" class="d-inline">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Timeout Sesi (menit)</label>
                            <input type="number" name="session_timeout" class="form-control"
                                value="{{ $settings['session_timeout'] ?? 60 }}" min="5" max="480">
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>

                <hr class="my-4">

                <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem;">Mode Maintenance</h5>
                <p class="text-muted" style="font-size: 0.875rem; margin-bottom: 16px;">Aktifkan atau nonaktifkan mode
                    maintenance.</p>

                <form method="POST" action="{{ url('/admin/maintenance/toggle') }}" id="maintenanceForm">
                    @csrf
                    <div class="d-flex align-items-center gap-3">
                        <div class="toggle-switch {{ $isMaintenance ? 'active' : '' }}" id="maintenanceToggle"
                            style="cursor: pointer;" tabindex="0" role="switch"
                            aria-checked="{{ $isMaintenance ? 'true' : 'false' }}"></div>
                        <span class="status-indicator {{ $isMaintenance ? 'status-offline' : 'status-online' }}"
                            id="maintenanceStatus">
                            <i class="fas {{ $isMaintenance ? 'fa-exclamation-circle' : 'fa-check-circle' }}"></i>
                            {{ $isMaintenance ? 'Maintenance Aktif' : 'Aplikasi Online' }}
                        </span>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary" id="applyMaintenance">
                            <i class="fas fa-save me-1"></i> Terapkan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function() {
            function updateStatusUI(isActive) {
                $('#maintenanceStatus')
                    .removeClass('status-online status-offline')
                    .addClass(isActive ? 'status-offline' : 'status-online')
                    .html('<i class="fas ' + (isActive ? 'fa-exclamation-circle' : 'fa-check-circle') + '"></i> ' +
                        (isActive ? 'Maintenance Aktif' : 'Aplikasi Online'));
                $('#maintenanceToggle').attr('aria-checked', isActive ? 'true' : 'false');
            }

            $('#maintenanceToggle').on('click', function() {
                $(this).toggleClass('active');
                updateStatusUI($(this).hasClass('active'));
            });

            $('#maintenanceToggle').on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).click();
                }
            });

            $('#maintenanceForm').on('submit', function(e) {
                e.preventDefault();
                var btn = $('#applyMaintenance');
                var originalText = btn.html();
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

                $.post($(this).attr('action'), $(this).serialize(), function(resp) {
                    alert('Pengaturan maintenance berhasil disimpan');
                    location.reload();
                }).fail(function() {
                    alert('Gagal menyimpan pengaturan');
                }).always(function() {
                    btn.prop('disabled', false).html(originalText);
                });
            });
        });
    </script>
</body>

</html>
