<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Ruangan - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <style>
        #notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        }

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

        .top-bar-toggle:active {
            transform: translate(2px, 2px);
            box-shadow: none;
        }

        .top-bar-left h4 {
            font-family: var(--font-display);
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 0;
            letter-spacing: -0.3px;
            text-transform: uppercase;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .top-bar-date {
            font-family: var(--font-display);
            font-size: 0.85rem;
            color: var(--nb-dark);
            font-weight: 600;
        }

        .top-bar-right .dropdown-toggle {
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 10px 16px;
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--nb-black);
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
            box-shadow: var(--nb-shadow-sm);
        }

        .top-bar-right .dropdown-toggle:hover {
            background: var(--nb-yellow);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .top-bar-right .dropdown-toggle::after {
            display: none;
        }

        .top-bar-right .dropdown-menu {
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            box-shadow: var(--nb-shadow);
            padding: 8px;
            min-width: 180px;
            background: var(--nb-white);
        }

        .top-bar-right .dropdown-item {
            border-radius: var(--nb-radius-sm);
            padding: 10px 14px;
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--nb-black);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.15s ease;
        }

        .top-bar-right .dropdown-item:hover {
            background: var(--nb-yellow);
            color: var(--nb-black);
        }

        .top-bar-right .dropdown-item.text-danger {
            color: var(--nb-red);
        }

        .top-bar-right .dropdown-item.text-danger:hover {
            background: var(--nb-red);
            color: var(--nb-white);
        }

        .top-bar-right .dropdown-divider {
            margin: 4px 0;
            border-color: var(--nb-gray);
        }

        .content-wrapper {
            padding: 28px 32px;
        }

        .page-title-section {
            margin-bottom: 28px;
        }

        .page-title-section h4 {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 6px;
            letter-spacing: -0.3px;
            text-transform: uppercase;
        }

        .page-title-section p {
            font-family: var(--font-body);
            font-size: 0.95rem;
            color: var(--nb-dark);
            margin-bottom: 0;
            font-weight: 500;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--nb-white);
            border-radius: var(--nb-radius);
            box-shadow: var(--nb-shadow);
            padding: 22px 24px;
            transition: all 0.2s ease;
            border: var(--nb-border);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: var(--nb-black);
        }

        .stat-card:nth-child(1)::before {
            background: var(--nb-teal);
        }

        .stat-card:nth-child(2)::before {
            background: var(--nb-green);
        }

        .stat-card:nth-child(3)::before {
            background: var(--nb-orange);
        }

        .stat-card:nth-child(4)::before {
            background: var(--nb-pink);
        }

        .stat-card:hover {
            transform: translate(-3px, -3px);
            box-shadow: var(--nb-shadow-hover);
        }

        .stat-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .stat-card-label {
            font-family: var(--font-display);
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--nb-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--nb-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
        }

        .stat-card-icon.blue {
            background: var(--nb-teal);
            color: var(--nb-black);
        }

        .stat-card-icon.green {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .stat-card-icon.amber {
            background: var(--nb-orange);
            color: var(--nb-black);
        }

        .stat-card-icon.rose {
            background: var(--nb-pink);
            color: var(--nb-white);
        }

        .stat-card-value {
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--nb-black);
            letter-spacing: -0.5px;
            line-height: 1.2;
            text-shadow: 3px 3px 0 var(--nb-gray);
        }

        .stat-card-footer {
            margin-top: 10px;
        }

        .stat-card-footer small {
            font-family: var(--font-body);
            font-size: 0.78rem;
            color: var(--nb-dark);
            font-weight: 600;
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
            font-family: var(--font-body);
            font-size: 0.88rem;
            color: var(--nb-dark);
            font-weight: 600;
        }

        .actions-bar-left strong {
            color: var(--nb-black);
            font-weight: 700;
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

        /* Table Card */
        .table-card {
            background: var(--nb-white);
            border-radius: var(--nb-radius);
            box-shadow: var(--nb-shadow);
            border: var(--nb-border);
            margin-bottom: 28px;
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
            background: var(--nb-purple);
        }

        .table-card-header h5 {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: var(--nb-white);
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-card-header h5 i {
            font-size: 1rem;
        }

        .table-card-body {
            padding: 0;
        }

        .table-clean {
            width: 100%;
            border-collapse: collapse;
            font-family: var(--font-body);
            font-size: 0.88rem;
        }

        .table-clean thead {
            background: var(--nb-offwhite);
        }

        .table-clean thead th {
            padding: 14px 18px;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--nb-black);
            border-bottom: var(--nb-border);
            text-align: left;
            white-space: nowrap;
        }

        .table-clean tbody tr {
            transition: all 0.15s ease;
            border-bottom: 1px solid var(--nb-gray);
        }

        .table-clean tbody tr:hover {
            background: var(--nb-yellow);
            transform: scale(1.01);
        }

        .table-clean tbody td {
            padding: 14px 18px;
            color: var(--nb-black);
            font-weight: 500;
            vertical-align: middle;
        }

        .table-clean tbody tr:nth-child(even) {
            background: var(--nb-offwhite);
        }

        .table-clean tbody tr:nth-child(even):hover {
            background: var(--nb-yellow);
        }

        .room-name {
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--nb-black);
        }

        .capacity-badge {
            display: inline-block;
            background: var(--nb-blue);
            color: var(--nb-white);
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: var(--nb-radius-sm);
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .facility-badge {
            display: inline-block;
            background: var(--nb-gray);
            color: var(--nb-black);
            font-family: var(--font-body);
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: var(--nb-radius-sm);
            margin: 2px;
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .facility-more {
            display: inline-block;
            background: var(--nb-offwhite);
            color: var(--nb-dark);
            font-family: var(--font-display);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: var(--nb-radius-sm);
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .photo-thumb {
            width: 50px;
            height: 50px;
            border-radius: var(--nb-radius-sm);
            object-fit: cover;
            cursor: pointer;
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
            transition: all 0.15s ease;
        }

        .photo-thumb:hover {
            transform: scale(1.1);
            box-shadow: var(--nb-shadow);
        }

        .photo-none {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: var(--nb-radius-sm);
            background: var(--nb-gray);
            color: var(--nb-dark);
            font-size: 0.75rem;
            border: var(--nb-border);
        }

        .action-group {
            display: flex;
            gap: 6px;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            background: var(--nb-white);
            color: var(--nb-black);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            font-size: 0.85rem;
            box-shadow: var(--nb-shadow-sm);
        }

        .action-btn:hover {
            background: var(--nb-yellow);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .action-btn.danger:hover {
            background: var(--nb-red);
            color: var(--nb-white);
        }

        /* Alert flash */
        .alert-flash {
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: var(--font-body);
            font-size: 0.88rem;
            font-weight: 600;
            box-shadow: var(--nb-shadow-sm);
        }

        .alert-flash.success {
            background: var(--nb-green);
            color: var(--nb-black);
            border-left: 5px solid var(--nb-black);
        }

        .alert-flash.error {
            background: var(--nb-red);
            color: var(--nb-white);
            border-left: 5px solid var(--nb-black);
        }

        /* Upload box */
        .upload-box {
            border: var(--nb-border);
            border-radius: var(--nb-radius);
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.15s ease;
            background: var(--nb-offwhite);
            box-shadow: var(--nb-shadow-sm);
        }

        .upload-box:hover {
            border-color: var(--nb-black);
            background: var(--nb-yellow);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .upload-box i {
            font-size: 2rem;
            color: var(--nb-dark);
            display: block;
            margin-bottom: 8px;
        }

        /* Photo Preview */
        .foto-preview {
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
            border-radius: var(--nb-radius-sm);
            margin-top: 10px;
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
        }

        /* Modal */
        .modal-content-modern {
            border-radius: var(--nb-radius);
            border: var(--nb-border-thick);
            box-shadow: var(--nb-shadow-lg);
        }

        .modal-header-modern {
            padding: 20px 24px;
            border-bottom: var(--nb-border);
            background: var(--nb-purple);
        }

        .modal-header-modern .modal-title {
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--nb-white);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modal-header-modern .btn-close {
            filter: invert(1);
        }

        .modal-body-modern {
            padding: 24px;
            max-height: 65vh;
            overflow-y: auto;
        }

        .modal-footer-modern {
            padding: 16px 24px;
            border-top: var(--nb-border);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-modal-secondary {
            padding: 10px 20px;
            background: var(--nb-white);
            color: var(--nb-black);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-modal-secondary:hover {
            background: var(--nb-gray);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-modal-primary {
            padding: 10px 20px;
            background: var(--nb-purple);
            color: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-modal-primary:hover {
            background: var(--nb-pink);
            color: var(--nb-black);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        /* Form Controls */
        .form-control-custom {
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 10px 14px;
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--nb-black);
            background: var(--nb-white);
            outline: none;
            transition: all 0.15s ease;
            width: 100%;
            box-shadow: var(--nb-shadow-sm);
        }

        .form-control-custom:focus {
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow);
            transform: translate(-2px, -2px);
        }

        .form-label-custom {
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 8px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
                font-size: 1.8rem;
            }

            .stat-card-icon {
                width: 38px;
                height: 38px;
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
                <button class="top-bar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>Kelola Ruangan</h4>
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
                <div class="actions-bar-left">
                    <strong>{{ count($rooms) }}</strong> ruangan tersedia
                </div>
                <button class="btn-primary-solid" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Tambah Ruangan
                </button>
            </div>

            <!-- Data Table -->
            <div class="table-card">
                <div class="table-card-body">
                    <div style="overflow-x: auto;">
                        <table class="table-clean" id="roomsTable">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Nama Ruangan</th>
                                    <th>Foto</th>
                                    <th>Deskripsi</th>
                                    <th>Kapasitas</th>
                                    <th>Fasilitas</th>
                                    <th>Tanggal Dibuat</th>
                                    <th style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($rooms as $room)
                                    <tr>
                                        <td style="color:var(--nb-dark); font-weight:600;">{{ $no++ }}</td>
                                        <td><span class="room-name">{{ $room->nama_ruang }}</span></td>
                                        <td>
                                            @if ($room->foto_path)
                                                <img src="{{ asset('storage/uploads/rooms/' . $room->foto_path) }}"
                                                    class="photo-thumb" alt="Foto {{ $room->nama_ruang }}"
                                                    onclick="viewPhoto('{{ asset('storage/uploads/rooms/' . $room->foto_path) }}', '{{ $room->nama_ruang }}')"
                                                    title="Klik untuk perbesar">
                                            @else
                                                <span class="photo-none"><i class="fas fa-image"></i></span>
                                            @endif
                                        </td>
                                        <td
                                            style="max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--nb-dark);">
                                            {{ $room->deskripsi ?: '-' }}
                                        </td>
                                        <td>
                                            @if ($room->kapasitas > 0)
                                                <span class="capacity-badge">{{ $room->kapasitas }}</span>
                                            @else
                                                <span style="color:var(--nb-dark);">-</span>
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
                                                <span style="color:var(--nb-dark);">-</span>
                                            @endif
                                        </td>
                                        <td style="font-weight:600;">{{ date('d/m/Y', strtotime($room->created_at)) }}
                                        </td>
                                        <td>
                                            <div class="action-group">
                                                <button class="action-btn"
                                                    onclick='editRoom(@json($room))' title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                @if ($room->foto_path)
                                                    <a href="{{ url('/admin/manage-rooms/delete-photo/' . $room->id) }}"
                                                        class="action-btn danger"
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
                        <h5 class="modal-title">
                            <i class="fas fa-plus me-2"></i> Tambah Ruangan Baru
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body-modern">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label-custom">Nama Ruangan <span
                                            style="color:var(--nb-red);">*</span></label>
                                    <input type="text" name="nama_ruang" class="form-control-custom" required
                                        placeholder="Contoh: R.101, Lab. Komputer 1">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label-custom">Kapasitas</label>
                                    <input type="number" name="kapasitas" class="form-control-custom"
                                        placeholder="Jumlah maksimal orang" min="0">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label-custom">Fasilitas</label>
                                    <textarea name="fasilitas" class="form-control-custom" rows="2"
                                        placeholder="Pisahkan dengan koma (AC, Proyektor, Papan Tulis)"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label-custom">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control-custom" rows="4" placeholder="Deskripsi ruangan..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label-custom">Foto Ruangan</label>
                                    <div class="upload-box" onclick="document.getElementById('fotoInput').click()">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p style="color:var(--nb-dark);font-size:0.85rem;margin-bottom:4px;">Klik
                                            untuk upload foto</p>
                                        <small style="color:var(--nb-dark);font-size:0.75rem;">Format: JPG, PNG, GIF,
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
                        <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" name="add_room" class="btn-modal-primary">
                            <i class="fas fa-save me-1"></i> Simpan
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
                        <h5 class="modal-title">
                            <i class="fas fa-edit me-2"></i> Edit Ruangan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body-modern">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label-custom">Nama Ruangan <span
                                            style="color:var(--nb-red);">*</span></label>
                                    <input type="text" name="nama_ruang" id="edit_nama_ruang"
                                        class="form-control-custom" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label-custom">Kapasitas</label>
                                    <input type="number" name="kapasitas" id="edit_kapasitas"
                                        class="form-control-custom" min="0">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label-custom">Fasilitas</label>
                                    <textarea name="fasilitas" id="edit_fasilitas" class="form-control-custom" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label-custom">Deskripsi</label>
                                    <textarea name="deskripsi" id="edit_deskripsi" class="form-control-custom" rows="4"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label-custom">Foto Ruangan</label>
                                    <div id="currentFoto" class="mb-2"></div>
                                    <div class="upload-box"
                                        onclick="document.getElementById('editFotoInput').click()">
                                        <i class="fas fa-sync-alt"></i>
                                        <p style="color:var(--nb-dark);font-size:0.85rem;margin-bottom:4px;">Klik
                                            untuk ganti foto</p>
                                        <small style="color:var(--nb-dark);font-size:0.75rem;">Biarkan kosong jika
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
                        <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" name="edit_room" class="btn-modal-primary">
                            <i class="fas fa-save me-1"></i> Update
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
                    <h5 class="modal-title" id="photoTitle">Foto Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body-modern text-center">
                    <img id="viewPhotoImg" src="" alt=""
                        style="max-width:100%;max-height:500px;border-radius:var(--nb-radius-sm);">
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
                    <p style="font-size:0.8rem;color:var(--nb-dark);margin-bottom:6px;font-weight:600;">Foto saat ini:</p>
                    <img src="{{ asset('storage/uploads/rooms/') }}/${room.foto_path}"
                         class="foto-preview"
                         alt="Foto ${room.nama_ruang}"
                         onclick="viewPhoto('{{ asset('storage/uploads/rooms/') }}/${room.foto_path}', '${room.nama_ruang}')"
                         style="cursor:pointer;">
                `;
            } else {
                currentFotoDiv.innerHTML = '<p style="font-size:0.8rem;color:var(--nb-dark);">Tidak ada foto</p>';
            }

            document.getElementById('editFotoPreview').innerHTML = '';

            // Update form action with room ID
            const editForm = document.getElementById('editForm');
            editForm.action = "{{ url('/admin/manage-rooms/update') }}/" + room.id;

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
                        <div style="border:var(--nb-border);border-radius:var(--nb-radius-sm);padding:8px;margin-top:8px;">
                            <img src="${e.target.result}" class="img-thumbnail" style="max-height:150px;border-radius:var(--nb-radius-sm);">
                            <small style="display:block;margin-top:4px;color:var(--nb-dark);">${file.name} (${(file.size / 1024).toFixed(1)} KB)</small>
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
