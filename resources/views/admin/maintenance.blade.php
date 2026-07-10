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

        .info-box {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 20px;
        }

        .info-box i {
            color: var(--corporate-blue);
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

        .btn-danger-custom {
            background: #dc2626;
            color: white;
        }

        .btn-danger-custom:hover {
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
            background: #16a34a;
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
            background: #d1fae5;
            color: #059669;
        }

        .status-offline {
            background: #fee2e2;
            color: #dc2626;
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
                <h4>Maintenance</h4>
                @if ($isMaintenance)
                    <span class="maintenance-badge-top"><i class="fas fa-tools"></i> Maintenance Mode</span>
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
            <div class="page-title-section">
                <h4>Maintenance Mode</h4>
                <p>Kelola mode maintenance aplikasi</p>
            </div>

            <div class="info-box">
                <div class="d-flex align-items-start gap-2">
                    <i class="fas fa-info-circle mt-1"></i>
                    <div>
                        <strong>Informasi:</strong>
                        <p class="mb-0" style="font-size: 0.875rem;">Saat mode maintenance aktif, aplikasi akan
                            menampilkan halaman maintenance kepada semua pengguna kecuali admin. Fitur meliputi
                            penjadwalan
                            backup database, pembersihan cache/log, dan pengaturan timeout sesi.</p>
                    </div>
                </div>
            </div>

            <div class="table-card">
                <div class="table-card-header">
                    <h5><i class="fas fa-database"></i> Backup Database</h5>
                </div>
                <div class="table-card-body">
                    <div style="padding: 24px;">
                        <p style="font-size: 0.875rem; color: var(--zinc-600); margin-bottom: 16px;">Backup database
                            untuk menyimpan
                            data penting.</p>

                        <div class="d-flex gap-2 flex-wrap">
                            <form method="POST" action="{{ url('/admin/maintenance/backup') }}" class="d-inline">
                                @csrf
                                @if ($superadminVerified)
                                    <button type="submit" class="btn btn-primary-custom">
                                        <i class="fas fa-download me-1"></i> Backup Sekarang
                                    </button>
                                @else
                                    <button type="button" class="btn btn-primary-custom" disabled
                                        style="opacity:0.4;cursor:not-allowed;">
                                        <i class="fas fa-download me-1"></i> Backup Sekarang
                                    </button>
                                @endif
                            </form>
                            <button class="btn btn-secondary-custom" disabled>
                                <i class="fas fa-history me-1"></i> Lihat Riwayat Backup
                            </button>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem;"><i
                                class="fas fa-broom me-2"></i>Pembersihan Data</h5>
                        <p style="font-size: 0.875rem; color: var(--zinc-600); margin-bottom: 16px;">Hapus cache, log,
                            dan data
                            sementara untuk mengoptimalkan kinerja aplikasi.</p>

                        <div class="d-flex gap-2 flex-wrap">
                            <form method="POST" action="{{ url('/admin/maintenance/clear-cache') }}" class="d-inline">
                                @csrf
                                @if ($superadminVerified)
                                    <button type="submit" class="btn btn-primary-custom">
                                        <i class="fas fa-broom me-1"></i> Clear Cache
                                    </button>
                                @else
                                    <button type="button" class="btn btn-primary-custom" disabled
                                        style="opacity:0.4;cursor:not-allowed;">
                                        <i class="fas fa-broom me-1"></i> Clear Cache
                                    </button>
                                @endif
                            </form>
                            <form method="POST" action="{{ url('/admin/maintenance/clear-logs') }}" class="d-inline">
                                @csrf
                                @if ($superadminVerified)
                                    <button type="submit" class="btn btn-primary-custom">
                                        <i class="fas fa-file-alt me-1"></i> Clear Logs
                                    </button>
                                @else
                                    <button type="button" class="btn btn-primary-custom" disabled
                                        style="opacity:0.4;cursor:not-allowed;">
                                        <i class="fas fa-file-alt me-1"></i> Clear Logs
                                    </button>
                                @endif
                            </form>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem;"><i
                                class="fas fa-clock me-2"></i>Pengaturan Sesi</h5>
                        <p style="font-size: 0.875rem; color: var(--zinc-600); margin-bottom: 16px;">Atur batas waktu
                            sesi login
                            untuk keamanan.</p>

                        <form method="POST" action="{{ url('/admin/maintenance/session') }}" class="d-inline">
                            @csrf
                            <div class="row align-items-end">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Timeout Sesi (menit)</label>
                                    <input type="number" name="session_timeout" class="form-control"
                                        value="{{ $settings['session_timeout'] ?? 60 }}" min="5"
                                        max="480">
                                </div>
                                <div class="col-md-4 mb-3">
                                    @if ($superadminVerified)
                                        <button type="submit" class="btn btn-primary-custom">
                                            <i class="fas fa-save me-1"></i> Simpan
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-primary-custom" disabled
                                            style="opacity:0.4;cursor:not-allowed;">
                                            <i class="fas fa-save me-1"></i> Simpan
                                        </button>
                                    @endif
                                    </button>
                                </div>
                            </div>
                        </form>

                        <hr class="my-4">

                        <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem;"><i
                                class="fas fa-cog me-2"></i>Mode Maintenance</h5>
                        <p style="font-size: 0.875rem; color: var(--zinc-600); margin-bottom: 16px;">Aktifkan atau
                            nonaktifkan mode
                            maintenance.</p>

                        <form method="POST" action="{{ url('/admin/maintenance/toggle') }}" id="maintenanceForm">
                            @csrf
                            <div class="d-flex align-items-center gap-3">
                                <div class="toggle-switch {{ $isMaintenance ? 'active' : '' }}"
                                    id="maintenanceToggle" style="cursor: pointer;" tabindex="0" role="switch"
                                    aria-checked="{{ $isMaintenance ? 'true' : 'false' }}"></div>
                                <span
                                    class="status-indicator {{ $isMaintenance ? 'status-offline' : 'status-online' }}"
                                    id="maintenanceStatus">
                                    <i
                                        class="fas {{ $isMaintenance ? 'fa-exclamation-circle' : 'fa-check-circle' }}"></i>
                                    {{ $isMaintenance ? 'Maintenance Aktif' : 'Aplikasi Online' }}
                                </span>
                            </div>

                            <div class="mt-3">
                                @if ($superadminVerified)
                                    <button type="submit" class="btn btn-primary-custom" id="applyMaintenance">
                                        <i class="fas fa-save me-1"></i> Terapkan Perubahan
                                    </button>
                                @else
                                    <button type="button" class="btn btn-primary-custom" disabled
                                        style="opacity:0.4;cursor:not-allowed;" id="applyMaintenance">
                                        <i class="fas fa-save me-1"></i> Terapkan Perubahan
                                    </button>
                                @endif
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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
