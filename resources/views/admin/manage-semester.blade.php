<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Semester - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
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

        .maintenance-badge-top {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--nb-orange);
            color: var(--nb-black);
            font-family: var(--font-display);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
            margin-bottom: 24px;
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

        /* Active Semester Status Bar */
        .status-bar-card {
            background: var(--nb-white);
            border-radius: var(--nb-radius);
            box-shadow: var(--nb-shadow);
            padding: 0;
            margin-bottom: 24px;
            border: var(--nb-border);
            overflow: hidden;
        }

        .status-bar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            padding: 20px 24px;
            border-left: 6px solid var(--nb-purple);
        }

        .status-bar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .status-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--nb-radius-sm);
            background: var(--nb-purple);
            color: var(--nb-white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
        }

        .status-info h5 {
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--nb-dark);
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-info h3 {
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 2px;
        }

        .status-info small {
            font-size: 0.78rem;
            color: var(--nb-dark);
            font-weight: 600;
        }

        .status-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--nb-green);
            color: var(--nb-black);
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            padding: 6px 18px;
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
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
            background: var(--nb-purple);
        }

        .stat-card:nth-child(2)::before {
            background: var(--nb-green);
        }

        .stat-card:nth-child(3)::before {
            background: var(--nb-orange);
        }

        .stat-card:nth-child(4)::before {
            background: var(--nb-blue);
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
            background: var(--nb-blue);
            color: var(--nb-white);
        }

        .stat-card-icon.emerald {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .stat-card-icon.amber {
            background: var(--nb-orange);
            color: var(--nb-black);
        }

        .stat-card-icon.purple {
            background: var(--nb-purple);
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

        /* Semester Cards Grid */
        .semester-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .semester-item {
            background: var(--nb-white);
            border-radius: var(--nb-radius);
            box-shadow: var(--nb-shadow);
            padding: 24px;
            border: var(--nb-border);
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
        }

        .semester-item:hover {
            transform: translate(-3px, -3px);
            box-shadow: var(--nb-shadow-hover);
        }

        .semester-item.active {
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow-hover);
        }

        .semester-item.active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: var(--nb-green);
        }

        .semester-item-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .semester-item-title {
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 2px;
        }

        .semester-item-sub {
            font-family: var(--font-body);
            font-size: 0.88rem;
            color: var(--nb-dark);
            font-weight: 600;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-family: var(--font-display);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: var(--nb-radius-sm);
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .badge-status.active {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .badge-status.inactive {
            background: var(--nb-gray);
            color: var(--nb-dark);
        }

        .semester-item-stats {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: var(--nb-offwhite);
            border-radius: var(--nb-radius-sm);
            margin-bottom: 18px;
            border: var(--nb-border);
        }

        .semester-item-stats i {
            color: var(--nb-dark);
            font-size: 0.95rem;
        }

        .semester-item-stats .stat-text {
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
        }

        .semester-item-stats .stat-text strong {
            color: var(--nb-black);
            font-weight: 700;
        }

        .semester-item-stats .stat-text small {
            color: var(--nb-dark);
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .semester-item-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .btn-outline-sm {
            padding: 8px 18px;
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            border: var(--nb-border);
            background: var(--nb-white);
            color: var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .btn-outline-sm:hover {
            background: var(--nb-yellow);
            color: var(--nb-black);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-outline-sm.success {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .btn-outline-sm.success:hover {
            background: var(--nb-teal);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-outline-sm.danger {
            background: var(--nb-white);
            color: var(--nb-red);
        }

        .btn-outline-sm.danger:hover {
            background: var(--nb-red);
            color: var(--nb-white);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-outline-sm:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Info Box */
        .info-box {
            background: var(--nb-yellow);
            border: var(--nb-border);
            border-radius: var(--nb-radius);
            padding: 20px 24px;
            margin-bottom: 24px;
            box-shadow: var(--nb-shadow-sm);
        }

        .info-box h6 {
            font-family: var(--font-display);
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-box ul {
            margin-bottom: 0;
            padding-left: 20px;
            font-family: var(--font-body);
            font-size: 0.82rem;
            color: var(--nb-black);
            font-weight: 600;
        }

        .info-box ul li {
            margin-bottom: 4px;
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

        .alert-flash.info {
            background: var(--nb-blue);
            color: var(--nb-white);
            border-left: 5px solid var(--nb-black);
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

            .semester-grid {
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

            .semester-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .status-bar-inner {
                flex-direction: column;
                align-items: flex-start;
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
                <h4>Kelola Semester</h4>
                @if ($isMaintenance ?? false)
                    <span class="maintenance-badge-top">
                        <i class="fas fa-tools"></i> Maintenance
                    </span>
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
                <h4>Kelola Semester</h4>
                <p>Atur dan kelola semester akademik</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total Semester</span>
                        <div class="stat-card-icon blue"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $semesters->count() }}</div>
                    <div class="stat-card-footer"><small>Semester terdaftar</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Semester Aktif</span>
                        <div class="stat-card-icon emerald"><i class="fas fa-check-circle"></i></div>
                    </div>
                    <div class="stat-card-value">1</div>
                    <div class="stat-card-footer"><small>Sedang berjalan</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Jadwal Aktif</span>
                        <div class="stat-card-icon amber"><i class="fas fa-calendar-check"></i></div>
                    </div>
                    <div class="stat-card-value">
                        @php
                            $activeSchedules = 0;
                            if ($activeSemester) {
                                $activeSchedules = DB::table('schedules')
                                    ->where('tahun_akademik', $activeSemester->tahun_akademik)
                                    ->where('semester', $activeSemester->semester)
                                    ->count();
                            }
                            echo $activeSchedules;
                        @endphp
                    </div>
                    <div class="stat-card-footer"><small>Kuliah semester ini</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Sedang Aktif</span>
                        <div class="stat-card-icon purple"><i class="fas fa-clock"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $semesters->where('is_active', true)->count() }}</div>
                    <div class="stat-card-footer"><small>Semester berjalan</small></div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="actions-bar">
                <div class="actions-bar-left">
                    <strong>{{ $semesters->count() }}</strong> semester akademik
                </div>
                <button class="btn-primary-solid" data-bs-toggle="modal" data-bs-target="#addSemesterModal">
                    <i class="fas fa-plus"></i> Tambah Semester
                </button>
            </div>

            <!-- Active Semester Status Bar -->
            @if ($activeSemester)
                <div class="status-bar-card">
                    <div class="status-bar-inner">
                        <div class="status-bar-left">
                            <div class="status-icon"><i class="fas fa-star"></i></div>
                            <div class="status-info">
                                <h5>Semester Aktif</h5>
                                <h3>{{ $activeSemester->semester }} - {{ $activeSemester->tahun_akademik }}</h3>
                                <small>Semester yang ditampilkan di halaman utama</small>
                            </div>
                        </div>
                        <div class="status-badge-pill">
                            <i class="fas fa-calendar-check"></i>
                            @php
                                $jumlah_jadwal = DB::table('schedules')
                                    ->where('tahun_akademik', $activeSemester->tahun_akademik)
                                    ->where('semester', $activeSemester->semester)
                                    ->count();
                                echo $jumlah_jadwal . ' Jadwal';
                            @endphp
                        </div>
                    </div>
                </div>
            @endif

            <!-- Semester Cards -->
            @if ($semesters->count() > 0)
                <div class="semester-grid">
                    @foreach ($semesters as $semester)
                        @php
                            $jumlah_jadwal = DB::table('schedules')
                                ->where('tahun_akademik', $semester->tahun_akademik)
                                ->where('semester', $semester->semester)
                                ->count();
                        @endphp
                        <div class="semester-item {{ $semester->is_active ? 'active' : '' }}">
                            <div class="semester-item-top">
                                <div>
                                    <div class="semester-item-title">{{ $semester->semester }}</div>
                                    <div class="semester-item-sub">{{ $semester->tahun_akademik }}</div>
                                </div>
                                <span class="badge-status {{ $semester->is_active ? 'active' : 'inactive' }}">
                                    @if ($semester->is_active)
                                        <i class="fas fa-check-circle" style="font-size:0.65rem;"></i>
                                    @endif
                                    {{ $semester->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>

                            <div class="semester-item-stats">
                                <i class="fas fa-calendar-check"></i>
                                <div class="stat-text">
                                    <strong>{{ $jumlah_jadwal }} jadwal</strong>
                                    <small>Kuliah terdaftar</small>
                                </div>
                            </div>

                            <div class="semester-item-actions">
                                @if (!$semester->is_active)
                                    <form method="POST"
                                        action="{{ url('/admin/manage-semester/set-active/' . $semester->id) }}"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-outline-sm success">
                                            <i class="fas fa-check"></i> Set Aktif
                                        </button>
                                    </form>
                                    <a href="{{ url('/admin/manage-semester/delete/' . $semester->id) }}"
                                        class="btn-outline-sm danger"
                                        onclick="return confirm('Yakin hapus semester {{ $semester->semester }} {{ $semester->tahun_akademik }}?')">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                @else
                                    <span class="btn-outline-sm success" style="opacity:0.8;cursor:default;">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert-flash info">
                    <i class="fas fa-info-circle"></i> Belum ada data semester. Silakan tambah semester baru.
                </div>
            @endif

            <!-- Info Box -->
            <div class="info-box">
                <h6><i class="fas fa-info-circle"></i> Informasi Semester</h6>
                <ul>
                    <li>Hanya satu semester yang dapat aktif pada satu waktu</li>
                    <li>Semester yang aktif akan ditampilkan di halaman utama</li>
                    <li>Jadwal kuliah akan difilter berdasarkan semester aktif</li>
                    <li>Pastikan jadwal sudah dimasukkan untuk semester yang akan diaktifkan</li>
                    <li>Semester aktif tidak dapat dihapus</li>
                    <li>Semester yang sudah dihapus tidak dapat dikembalikan</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Add Semester Modal -->
    <div class="modal fade" id="addSemesterModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-modern">
                <form method="POST" action="{{ url('/admin/manage-semester/store') }}">
                    @csrf
                    <div class="modal-header-modern d-flex align-items-center justify-content-between">
                        <h5 class="modal-title">
                            <i class="fas fa-plus me-2"></i> Tambah Semester Baru
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body-modern">
                        <div class="mb-3">
                            <label class="form-label-custom">Tahun Akademik</label>
                            <input type="text" class="form-control-custom" id="tahun_akademik"
                                name="tahun_akademik" required placeholder="Contoh: 2024/2025" pattern="\d{4}/\d{4}">
                            <small class="form-hint">Format: YYYY/YYYY</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label-custom">Semester</label>
                            <select class="form-select-custom" id="semester" name="semester" required>
                                <option value="GANJIL">GANJIL</option>
                                <option value="GENAP">GENAP</option>
                            </select>
                        </div>
                        <div class="alert-flash warning" style="background:var(--nb-orange);color:var(--nb-black);">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>
                                <strong>Perhatian!</strong> Pastikan jadwal sudah dimasukkan untuk semester ini sebelum
                                mengaktifkannya.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer-modern">
                        <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" name="add_semester" class="btn-modal-primary">
                            <i class="fas fa-save me-1"></i> Simpan Semester
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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

        // Auto-generate tahun akademik
        document.addEventListener('DOMContentLoaded', function() {
            const tahunInput = document.getElementById('tahun_akademik');
            if (tahunInput && !tahunInput.value) {
                const now = new Date();
                const year = now.getFullYear();
                const month = now.getMonth();
                let tahun1, tahun2;
                if (month >= 6) {
                    tahun1 = year;
                    tahun2 = year + 1;
                } else {
                    tahun1 = year - 1;
                    tahun2 = year;
                }
                tahunInput.value = `${tahun1}/${tahun2}`;
            }
        });

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
