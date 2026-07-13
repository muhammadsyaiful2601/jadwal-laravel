@php
    $pageTitle = 'Kritik & Saran - Admin';
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kritik & Saran - Admin</title>
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
            background: var(--nb-purple);
        }

        .stat-card:nth-child(2)::before {
            background: var(--nb-orange);
        }

        .stat-card:nth-child(3)::before {
            background: var(--nb-green);
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

        .stat-card-icon.total {
            background: var(--nb-blue);
            color: var(--nb-white);
        }

        .stat-card-icon.pending {
            background: var(--nb-orange);
            color: var(--nb-black);
        }

        .stat-card-icon.read {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .stat-card-icon.responded {
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

        /* Filter Card */
        .filter-card {
            background: var(--nb-white);
            border-radius: var(--nb-radius);
            box-shadow: var(--nb-shadow);
            padding: 20px 24px;
            margin-bottom: 24px;
            border: var(--nb-border);
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
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--nb-black);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-group select,
        .filter-group input {
            padding: 10px 14px;
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--nb-black);
            background: var(--nb-white);
            outline: none;
            transition: all 0.2s ease;
            min-width: 180px;
            box-shadow: var(--nb-shadow-sm);
        }

        .filter-group select:focus,
        .filter-group input:focus {
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow);
            transform: translate(-2px, -2px);
        }

        .btn-filter {
            padding: 10px 24px;
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

        .btn-filter:hover {
            background: var(--nb-pink);
            color: var(--nb-black);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        /* Superadmin Alert */
        .superadmin-alert {
            background: var(--nb-orange);
            border: var(--nb-border);
            border-radius: var(--nb-radius);
            padding: 18px 22px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            box-shadow: var(--nb-shadow);
        }

        .superadmin-alert-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .superadmin-alert-left .alert-icon {
            width: 44px;
            height: 44px;
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--nb-black);
            font-size: 1.2rem;
            flex-shrink: 0;
            box-shadow: var(--nb-shadow-sm);
        }

        .superadmin-alert-left h6 {
            font-family: var(--font-display);
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .superadmin-alert-left p {
            font-family: var(--font-body);
            font-size: 0.82rem;
            color: var(--nb-black);
            margin-bottom: 0;
            font-weight: 600;
        }

        .btn-destructive {
            padding: 10px 20px;
            border: var(--nb-border);
            background: var(--nb-red);
            color: var(--nb-white);
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

        .btn-destructive:hover {
            background: var(--nb-red);
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
            padding: 14px 20px;
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
            cursor: pointer;
        }

        .table-clean tbody tr:hover {
            background: var(--nb-yellow);
            transform: scale(1.01);
        }

        .table-clean tbody td {
            padding: 14px 20px;
            color: var(--nb-black);
            font-weight: 500;
            vertical-align: middle;
        }

        .sender-name {
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--nb-black);
            font-size: 0.9rem;
        }

        .sender-email {
            font-family: var(--font-body);
            font-size: 0.78rem;
            color: var(--nb-dark);
            display: block;
            margin-top: 2px;
            font-weight: 600;
        }

        .badge-new {
            display: inline-block;
            background: var(--nb-red);
            color: var(--nb-white);
            font-family: var(--font-display);
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: var(--nb-radius-sm);
            margin-left: 8px;
            vertical-align: middle;
            letter-spacing: 0.5px;
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 0.75rem;
            font-weight: 700;
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .status-badge.pending {
            background: var(--nb-orange);
            color: var(--nb-black);
        }

        .status-badge.read {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .status-badge.responded {
            background: var(--nb-purple);
            color: var(--nb-white);
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

        .action-btn.danger {
            background: var(--nb-white);
        }

        .action-btn.danger:hover {
            background: var(--nb-red);
            color: var(--nb-white);
        }

        .message-cell {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--nb-dark);
            font-size: 0.82rem;
            font-weight: 600;
        }

        .date-cell {
            white-space: nowrap;
            color: var(--nb-dark);
            font-size: 0.82rem;
            font-weight: 600;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--nb-dark);
            margin-bottom: 16px;
            display: block;
        }

        .empty-state h5 {
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 6px;
        }

        .empty-state p {
            color: var(--nb-dark);
            font-size: 0.88rem;
            margin-bottom: 0;
            font-weight: 500;
        }

        /* Pagination */
        .pagination-modern {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 16px 24px;
            border-top: var(--nb-border);
        }

        .pagination-modern .page-item {
            list-style: none;
        }

        .pagination-modern .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            background: var(--nb-white);
            color: var(--nb-black);
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.15s ease;
            box-shadow: var(--nb-shadow-sm);
        }

        .pagination-modern .page-link:hover {
            background: var(--nb-yellow);
            color: var(--nb-black);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .pagination-modern .page-item.active .page-link {
            background: var(--nb-purple);
            color: var(--nb-white);
            border-color: var(--nb-black);
        }

        .pagination-modern .page-item.disabled .page-link {
            opacity: 0.4;
            pointer-events: none;
        }

        .pagination-info {
            font-family: var(--font-body);
            font-size: 0.78rem;
            color: var(--nb-dark);
            margin-left: 12px;
            font-weight: 600;
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

        /* Notification */
        #notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .notification-modern {
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            padding: 16px 20px;
            min-width: 320px;
            box-shadow: var(--nb-shadow);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
        }

        .notification-modern.success {
            background: var(--nb-green);
            color: var(--nb-black);
            border-left: 5px solid var(--nb-black);
        }

        .notification-modern.error {
            background: var(--nb-red);
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
        }

        .confirmation-display {
            background: var(--nb-offwhite);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 16px;
            text-align: center;
            margin-bottom: 16px;
        }

        .confirmation-display code {
            font-family: 'SF Mono', 'Fira Code', monospace;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--nb-red);
            letter-spacing: 2px;
        }

        .input-confirm {
            width: 100%;
            padding: 10px 14px;
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--nb-black);
            outline: none;
            transition: all 0.2s ease;
            background: var(--nb-white);
            box-shadow: var(--nb-shadow-sm);
        }

        .input-confirm:focus {
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow);
        }

        .input-confirm.is-valid {
            border-color: var(--nb-green);
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .input-confirm.is-invalid {
            border-color: var(--nb-red);
            background: var(--nb-red);
            color: var(--nb-white);
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

            .filter-inline {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group select,
            .filter-group input {
                min-width: auto;
                width: 100%;
            }

            .superadmin-alert {
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

            .message-cell {
                max-width: 100px;
            }
        }
    </style>
</head>

<body>
    <div id="notification-container">
        @if (session('success'))
            <div class="notification-modern success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="margin-left:auto;"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="notification-modern error alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="margin-left:auto;"></button>
            </div>
        @endif
    </div>

    @include('components.admin.sidebar')

    <div class="main-content">
        <header class="top-bar">
            <div class="top-bar-left">
                <button class="top-bar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>Kritik & Saran</h4>
            </div>
            <div class="top-bar-right">
                <span class="top-bar-date"><i class="far fa-calendar-alt me-1"></i> {{ date('d F Y') }}</span>
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i>
                        {{ $currentUsername }}
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
                <h4>Kritik & Saran</h4>
                <p>Kelola kritik dan saran dari pengguna</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total</span>
                        <div class="stat-card-icon total"><i class="fas fa-comments"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['total'] }}</div>
                    <div class="stat-card-footer"><small>Total masukan</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Pending</span>
                        <div class="stat-card-icon pending"><i class="fas fa-clock"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['pending'] }}</div>
                    <div class="stat-card-footer"><small>Menunggu ditinjau</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Sudah Dibaca</span>
                        <div class="stat-card-icon read"><i class="fas fa-check-circle"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['read_count'] }}</div>
                    <div class="stat-card-footer"><small>Telah ditinjau</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Ditanggapi</span>
                        <div class="stat-card-icon responded"><i class="fas fa-reply"></i></div>
                    </div>
                    <div class="stat-card-value">{{ $stats['responded'] }}</div>
                    <div class="stat-card-footer"><small>Sudah direspons</small></div>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="filter-card">
                <form method="GET" class="filter-inline">
                    <div class="filter-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="read" {{ $status === 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                            <option value="responded" {{ $status === 'responded' ? 'selected' : '' }}>Ditanggapi
                            </option>
                        </select>
                    </div>
                    <div class="filter-group" style="flex:1; min-width:200px;">
                        <label>Cari</label>
                        <input type="text" name="search" placeholder="Cari nama, email, atau pesan..."
                            value="{{ $search }}">
                    </div>
                    <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Filter</button>
                </form>
            </div>

            <!-- Superadmin Alert -->
            @if ($currentUserRole === 'superadmin' && $totalSuggestions > 0)
                <div class="superadmin-alert">
                    <div class="superadmin-alert-left">
                        <div class="alert-icon"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <h6>Superadmin Action</h6>
                            <p>Anda dapat menghapus semua {{ $totalSuggestions }} data kritik & saran sekaligus.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-destructive" data-bs-toggle="modal"
                        data-bs-target="#deleteAllModal">
                        <i class="fas fa-trash-alt"></i> Hapus Semua Data
                    </button>
                </div>
            @endif

            <!-- Suggestions Table -->
            <div class="table-card">
                <div class="table-card-header">
                    <h5><i class="fas fa-list"></i> Daftar Kritik & Saran</h5>
                    @if ($totalSuggestions > 0)
                        <small style="color:var(--nb-white); font-size:0.78rem; opacity:0.9;">Halaman
                            {{ $page }} dari {{ $totalPages }}</small>
                    @endif
                </div>
                <div class="table-card-body">
                    @if (empty($suggestions))
                        <div class="empty-state">
                            <i class="fas fa-comments"></i>
                            <h5>Tidak ada kritik dan saran</h5>
                            <p>Belum ada kritik dan saran yang masuk</p>
                        </div>
                    @else
                        <div style="overflow-x: auto;">
                            <table class="table-clean">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="18%">Pengirim</th>
                                        <th width="22%">Pesan</th>
                                        <th width="12%">Status</th>
                                        <th width="15%">Tanggal</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suggestions as $index => $suggestion)
                                        @php
                                            $isUnread = $suggestion->status === 'pending';
                                            $message = e($suggestion->message);
                                            $messagePreview =
                                                strlen($message) > 60 ? substr($message, 0, 60) . '...' : $message;
                                        @endphp
                                        <tr onclick="openDetail({{ $suggestion->id }})"
                                            data-id="{{ $suggestion->id }}">
                                            <td style="color:var(--nb-dark); font-weight:600; font-size:0.82rem;">
                                                {{ $offset + $index + 1 }}</td>
                                            <td>
                                                <span class="sender-name">
                                                    {{ e($suggestion->name) }}
                                                    @if ($isUnread)
                                                        <span class="badge-new">BARU</span>
                                                    @endif
                                                </span>
                                                <span
                                                    class="sender-email">{{ $suggestion->email ?: 'Tidak ada email' }}</span>
                                            </td>
                                            <td>
                                                <div class="message-cell" title="{{ $message }}">
                                                    {{ $messagePreview }}</div>
                                            </td>
                                            <td>
                                                @php
                                                    $statusText = [
                                                        'pending' => 'Pending',
                                                        'read' => 'Sudah Dibaca',
                                                        'responded' => 'Ditanggapi',
                                                    ];
                                                @endphp
                                                <span class="status-badge {{ $suggestion->status }}">
                                                    @if ($suggestion->status === 'pending')
                                                        <i class="fas fa-clock" style="font-size:0.65rem;"></i>
                                                    @elseif($suggestion->status === 'read')
                                                        <i class="fas fa-check" style="font-size:0.65rem;"></i>
                                                    @else
                                                        <i class="fas fa-reply" style="font-size:0.65rem;"></i>
                                                    @endif
                                                    {{ $statusText[$suggestion->status] }}
                                                </span>
                                            </td>
                                            <td><span
                                                    class="date-cell">{{ date('d/m/Y H:i', strtotime($suggestion->created_at)) }}</span>
                                            </td>
                                            <td>
                                                <div class="action-group">
                                                    <button type="button" class="action-btn"
                                                        onclick="event.stopPropagation(); openDetail({{ $suggestion->id }})"
                                                        title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @if ($currentUserRole === 'superadmin')
                                                        <button type="button" class="action-btn danger"
                                                            onclick="event.stopPropagation(); confirmDelete({{ $suggestion->id }})"
                                                            title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($totalPages > 1)
                            <nav class="pagination-modern">
                                <ul style="display:flex;align-items:center;gap:6px;margin:0;padding:0;">
                                    <li class="page-item {{ $page <= 1 ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="?page={{ $page - 1 }}&status={{ $status }}&search={{ urlencode($search) }}">
                                            <i class="fas fa-chevron-left" style="font-size:0.7rem;"></i>
                                        </a>
                                    </li>
                                    @for ($i = 1; $i <= $totalPages; $i++)
                                        <li class="page-item {{ $i === $page ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="?page={{ $i }}&status={{ $status }}&search={{ urlencode($search) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item {{ $page >= $totalPages ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="?page={{ $page + 1 }}&status={{ $status }}&search={{ urlencode($search) }}">
                                            <i class="fas fa-chevron-right" style="font-size:0.7rem;"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    @foreach ($suggestions as $suggestion)
        <div class="modal fade" id="detailModal{{ $suggestion->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content modal-content-modern">
                    <div class="modal-header-modern d-flex align-items-center justify-content-between">
                        <h5 class="modal-title">
                            <i class="fas fa-comment-dots me-2"></i> Detail
                            Kritik & Saran
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body-modern">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h6
                                    style="font-size:0.8rem;font-weight:700;color:var(--nb-dark);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:12px;">
                                    Informasi Pengirim
                                </h6>
                                <table style="width:100%;font-size:0.88rem;">
                                    <tr>
                                        <td style="color:var(--nb-dark);padding:4px 0;width:90px;font-weight:600;">Nama
                                        </td>
                                        <td style="font-weight:700;color:var(--nb-black);">:
                                            {{ e($suggestion->name) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--nb-dark);padding:4px 0;font-weight:600;">Email</td>
                                        <td style="color:var(--nb-black);font-weight:600;">:
                                            {{ $suggestion->email ?: 'Tidak ada' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--nb-dark);padding:4px 0;font-weight:600;">IP</td>
                                        <td>: <span class="ip-badge"
                                                style="display:inline-block;background:var(--nb-dark);color:var(--nb-white);font-family:monospace;font-size:0.78rem;padding:4px 12px;border-radius:var(--nb-radius-sm);border:2px solid var(--nb-black);box-shadow:var(--nb-shadow-sm);">{{ $suggestion->ip_address }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--nb-dark);padding:4px 0;font-weight:600;">Tanggal</td>
                                        <td style="color:var(--nb-black);font-weight:600;">:
                                            {{ date('d F Y H:i', strtotime($suggestion->created_at)) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6
                                    style="font-size:0.8rem;font-weight:700;color:var(--nb-dark);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:12px;">
                                    Status
                                </h6>
                                <form method="POST" action="{{ url('/admin/saran/update-status') }}"
                                    id="statusForm{{ $suggestion->id }}">
                                    @csrf
                                    <input type="hidden" name="suggestion_id" value="{{ $suggestion->id }}">
                                    <input type="hidden" name="action" value="update_status">
                                    <div class="mb-3">
                                        <select name="status" class="form-select"
                                            style="padding:10px 14px;border:var(--nb-border);border-radius:var(--nb-radius-sm);font-size:0.85rem;font-family:var(--font-body);width:100%;background:var(--nb-white);box-shadow:var(--nb-shadow-sm);">
                                            @if ($suggestion->status === 'pending')
                                                <option value="pending" selected>Pending</option>
                                            @endif
                                            <option value="read"
                                                {{ $suggestion->status === 'read' ? 'selected' : '' }}>Sudah Dibaca
                                            </option>
                                            <option value="responded"
                                                {{ $suggestion->status === 'responded' ? 'selected' : '' }}>Ditanggapi
                                            </option>
                                        </select>
                                        @if ($suggestion->status !== 'pending')
                                            <small
                                                style="color:var(--nb-dark);font-size:0.78rem;margin-top:4px;display:block;font-weight:600;">
                                                <i class="fas fa-info-circle me-1"></i> Status tidak bisa dikembalikan
                                                ke
                                                pending.
                                            </small>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            style="font-size:0.82rem;font-weight:700;color:var(--nb-black);margin-bottom:6px;display:block;text-transform:uppercase;letter-spacing:0.5px;">Tanggapan
                                            (opsional)
                                        </label>
                                        <textarea name="response" rows="3"
                                            style="width:100%;padding:10px 14px;border:var(--nb-border);border-radius:var(--nb-radius-sm);font-size:0.85rem;font-family:var(--font-body);outline:none;transition:all 0.2s ease;background:var(--nb-white);box-shadow:var(--nb-shadow-sm);"
                                            placeholder="Masukkan tanggapan...">{{ $suggestion->response ?? '' }}</textarea>
                                    </div>
                                    <div style="display:flex;gap:10px;">
                                        <button type="submit"
                                            style="padding:10px 20px;background:var(--nb-purple);color:var(--nb-white);border:var(--nb-border);border-radius:var(--nb-radius-sm);font-size:0.82rem;font-weight:700;cursor:pointer;font-family:var(--font-display);box-shadow:var(--nb-shadow-sm);">
                                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                                        </button>
                                        @if ($currentUserRole === 'superadmin')
                                            <button type="button"
                                                style="padding:10px 20px;border:var(--nb-border);background:var(--nb-red);color:var(--nb-white);border-radius:var(--nb-radius-sm);font-size:0.82rem;font-weight:700;cursor:pointer;font-family:var(--font-display);box-shadow:var(--nb-shadow-sm);"
                                                onclick="confirmDelete({{ $suggestion->id }})">
                                                <i class="fas fa-trash me-2"></i> Hapus
                                            </button>
                                        @endif
                                    </div>
                                </form>
                                @if ($suggestion->responded_by)
                                    <div style="margin-top:16px;padding-top:16px;border-top:var(--nb-border);">
                                        <small style="color:var(--nb-dark);display:block;font-weight:600;"><strong>Ditanggapi
                                                oleh:</strong> {{ $suggestion->responder_name }}</small>
                                        <small
                                            style="color:var(--nb-dark);display:block;font-weight:600;"><strong>Tanggal:</strong>
                                            {{ date('d F Y H:i', strtotime($suggestion->responded_at)) }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr style="border-color:var(--nb-gray);margin:20px 0;">
                        <h6
                            style="font-size:0.85rem;font-weight:700;color:var(--nb-black);margin-bottom:10px;text-transform:uppercase;">
                            Pesan
                        </h6>
                        <div
                            style="background:var(--nb-offwhite);border:var(--nb-border);border-radius:var(--nb-radius-sm);padding:16px 20px;font-size:0.88rem;color:var(--nb-black);line-height:1.6;font-weight:500;">
                            {!! nl2br(e($suggestion->message)) !!}
                        </div>
                        @if (!empty($suggestion->response))
                            <h6
                                style="font-size:0.85rem;font-weight:700;color:var(--nb-black);margin-top:20px;margin-bottom:10px;text-transform:uppercase;">
                                Tanggapan
                            </h6>
                            <div
                                style="background:var(--nb-green);border:var(--nb-border);border-radius:var(--nb-radius-sm);padding:16px 20px;font-size:0.88rem;color:var(--nb-black);line-height:1.6;font-weight:500;">
                                {!! nl2br(e($suggestion->response)) !!}
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer-modern d-flex justify-content-end">
                        <button type="button" class="btn-filter" data-bs-dismiss="modal"
                            style="padding:8px 20px;font-size:0.82rem;">
                            <i class="fas fa-times me-2"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Delete All Modal -->
    <div class="modal fade" id="deleteAllModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-modern">
                <div class="modal-header-modern d-flex align-items-center justify-content-between"
                    style="border-color:var(--nb-red);">
                    <h5 class="modal-title" style="font-weight:700;font-size:1rem;color:var(--nb-white);">
                        <i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Penghapusan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body-modern">
                    <div class="text-center mb-4">
                        <i class="fas fa-trash-alt"
                            style="font-size:3rem;color:var(--nb-red);margin-bottom:12px;display:block;"></i>
                        <h5 style="font-weight:700;color:var(--nb-red);font-size:1.1rem;text-transform:uppercase;">
                            PERINGATAN!</h5>
                    </div>
                    <div
                        style="background:var(--nb-red);border:var(--nb-border);border-radius:var(--nb-radius-sm);padding:16px;margin-bottom:20px;color:var(--nb-white);">
                        <h6 style="font-size:0.85rem;font-weight:700;color:var(--nb-white);margin-bottom:8px;"><i
                                class="fas fa-exclamation-circle me-2"></i>Tindakan ini akan:</h6>
                        <ul style="margin-bottom:0;padding-left:20px;font-size:0.85rem;font-weight:600;">
                            <li>Menghapus <strong>SEMUA {{ $totalSuggestions }} data</strong> kritik & saran</li>
                            <li>Data yang dihapus <strong>TIDAK DAPAT DIPULIHKAN</strong></li>
                            <li>Statistik akan direset ke 0</li>
                            <li>Riwayat respons juga akan terhapus</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <label
                            style="font-size:0.82rem;font-weight:700;color:var(--nb-black);margin-bottom:8px;display:block;text-transform:uppercase;letter-spacing:0.5px;">Masukkan
                            konfirmasi berikut:</label>
                        <div class="confirmation-display">
                            <code id="randomConfirmationText"></code>
                        </div>
                        <small
                            style="color:var(--nb-dark);font-size:0.78rem;display:block;margin-bottom:8px;font-weight:600;">
                            <i class="fas fa-info-circle me-1"></i>Ketik teks di atas dengan tepat (huruf kapital)
                            untuk mengaktifkan tombol hapus
                        </small>
                        <div style="display:flex;gap:8px;">
                            <input type="text" id="deleteAllConfirm" class="input-confirm"
                                placeholder="Ketik teks konfirmasi..." autocomplete="off" style="flex:1;">
                            <button type="button" class="action-btn" onclick="copyConfirmationText()"
                                title="Salin"><i class="fas fa-copy"></i></button>
                            <button type="button" class="action-btn" onclick="regenerateConfirmationText()"
                                title="Buat baru"><i class="fas fa-redo"></i></button>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-top:6px;">
                            <small style="color:var(--nb-dark);font-size:0.75rem;font-weight:600;"><i
                                    class="fas fa-shield-alt me-1"></i>Teks diacak setiap kali untuk keamanan</small>
                            <small style="color:var(--nb-dark);font-size:0.75rem;font-weight:600;"><span
                                    id="charCount">0</span>
                                karakter</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-modern d-flex justify-content-between">
                    <button type="button" class="btn-filter"
                        style="background:var(--nb-gray);color:var(--nb-black);padding:8px 20px;font-size:0.82rem;"
                        data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Batal
                    </button>
                    <form method="POST" action="{{ url('/admin/saran/update-status') }}" id="deleteAllForm">
                        @csrf
                        <input type="hidden" name="action" value="delete_all">
                        <input type="hidden" name="confirm_delete_all" id="confirm_delete_all" value="0">
                        <button type="submit" class="btn-destructive" id="confirmDeleteAllBtn" disabled
                            style="padding:8px 20px;">
                            <i class="fas fa-trash-alt me-2"></i> Ya, Hapus Semua!
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form method="POST" action="{{ url('/admin/saran/update-status') }}" id="deleteForm" style="display:none;">
        @csrf
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="suggestion_id" id="deleteSuggestionId" value="">
    </form>

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

        function openDetail(id) {
            const modal = new bootstrap.Modal(document.getElementById('detailModal' + id));
            modal.show();
        }

        function confirmDelete(id) {
            if (confirm('Yakin ingin menghapus saran ini?')) {
                document.getElementById('deleteSuggestionId').value = id;
                document.getElementById('deleteForm').submit();
            }
        }

        function generateRandomString(length) {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = '';
            for (let i = 0; i < length; i++) result += chars.charAt(Math.floor(Math.random() * chars.length));
            return result;
        }

        function regenerateConfirmationText() {
            const text = generateRandomString(8);
            document.getElementById('randomConfirmationText').textContent = text;
            document.getElementById('deleteAllConfirm').value = '';
            document.getElementById('confirmDeleteAllBtn').disabled = true;
            document.getElementById('confirm_delete_all').value = '0';
            document.getElementById('charCount').textContent = '0';
            document.getElementById('deleteAllConfirm').classList.remove('is-valid', 'is-invalid');
        }

        function copyConfirmationText() {
            const text = document.getElementById('randomConfirmationText').textContent;
            navigator.clipboard.writeText(text).then(function() {
                const btn = document.querySelector('.input-group .action-btn');
                if (btn) {
                    const original = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-check"></i>';
                    setTimeout(() => {
                        btn.innerHTML = original;
                    }, 1500);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            regenerateConfirmationText();

            $('#deleteAllConfirm').on('input', function() {
                const expected = $('#randomConfirmationText').text();
                const input = $(this).val();
                const match = input === expected;

                if (match) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                    $('#confirmDeleteAllBtn').prop('disabled', false);
                    $('#confirm_delete_all').val('1');
                } else {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                    $('#confirmDeleteAllBtn').prop('disabled', true);
                    $('#confirm_delete_all').val('0');
                }
                $('#charCount').text(input.length);
            });

            setTimeout(() => {
                $('.notification-modern').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>

</html>
