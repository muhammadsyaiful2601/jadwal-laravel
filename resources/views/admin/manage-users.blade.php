<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Kelola Admin - Admin Panel</title>
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

        /* Alert Cards */
        .alert-custom {
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-family: var(--font-body);
            font-size: 0.88rem;
            font-weight: 600;
            box-shadow: var(--nb-shadow-sm);
        }

        .alert-custom.info {
            background: var(--nb-blue);
            color: var(--nb-white);
            border-left: 5px solid var(--nb-black);
        }

        .alert-custom.warning {
            background: var(--nb-orange);
            color: var(--nb-black);
            border-left: 5px solid var(--nb-black);
        }

        .alert-custom i {
            font-size: 1.1rem;
            margin-top: 2px;
            flex-shrink: 0;
        }

        /* Action Button */
        .btn-add-admin {
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

        .btn-add-admin:hover {
            background: var(--nb-pink);
            color: var(--nb-black);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-add-admin:disabled {
            opacity: 0.4;
            cursor: not-allowed;
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

        /* User Info Cell */
        .user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-cell .avatar {
            width: 36px;
            height: 36px;
            background: var(--nb-purple);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--nb-white);
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
            box-shadow: var(--nb-shadow-sm);
        }

        .user-cell .username {
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--nb-black);
        }

        /* Badges */
        .badge-you {
            display: inline-flex;
            align-items: center;
            background: var(--nb-blue);
            color: var(--nb-white);
            font-family: var(--font-display);
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: var(--nb-radius-sm);
            margin-left: 6px;
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .badge-role {
            padding: 3px 12px;
            font-family: var(--font-display);
            font-size: 0.65rem;
            font-weight: 700;
            border-radius: var(--nb-radius-sm);
            background: var(--nb-gray);
            color: var(--nb-black);
            letter-spacing: 0.02em;
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .badge-role.superadmin {
            background: var(--nb-orange);
            color: var(--nb-black);
        }

        .badge-status {
            padding: 3px 10px;
            font-family: var(--font-display);
            font-size: 0.65rem;
            font-weight: 700;
            border-radius: var(--nb-radius-sm);
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .badge-status.active {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .badge-status.inactive {
            background: var(--nb-red);
            color: var(--nb-white);
        }

        .badge-protected {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--nb-yellow);
            color: var(--nb-black);
            font-family: var(--font-display);
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: var(--nb-radius-sm);
            margin-left: 4px;
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .badge-lockout {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--nb-red);
            color: var(--nb-white);
            font-family: var(--font-display);
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: var(--nb-radius-sm);
            margin-left: 4px;
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .status-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 4px;
        }

        .badge-verified {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--nb-green);
            color: var(--nb-black);
            font-family: var(--font-display);
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: var(--nb-radius-sm);
            margin-left: 4px;
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .badge-unverified {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--nb-orange);
            color: var(--nb-black);
            font-family: var(--font-display);
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: var(--nb-radius-sm);
            margin-left: 4px;
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        /* Action Buttons */
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

        .action-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .action-btn.edit:hover {
            background: var(--nb-teal);
            color: var(--nb-black);
        }

        .action-btn.password:hover {
            background: var(--nb-blue);
            color: var(--nb-white);
        }

        .action-btn.danger:hover {
            background: var(--nb-red);
            color: var(--nb-white);
        }

        .action-group {
            display: flex;
            gap: 6px;
        }

        /* Table */
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

        /* Mobile Cards */
        .mobile-user-card {
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: var(--nb-shadow-sm);
        }

        .mobile-user-card .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: var(--nb-border);
        }

        .mobile-user-card .card-body {
            padding: 0;
        }

        .mobile-user-card .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            font-size: 0.85rem;
        }

        .mobile-user-card .info-label {
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--nb-dark);
            font-size: 0.78rem;
            text-transform: uppercase;
        }

        .mobile-user-card .info-value {
            font-weight: 600;
            color: var(--nb-black);
        }

        /* Modal */
        .modal-content-custom {
            border-radius: var(--nb-radius);
            border: var(--nb-border-thick);
            box-shadow: var(--nb-shadow-lg);
        }

        .modal-header-custom {
            padding: 20px 24px;
            border-bottom: var(--nb-border);
            background: var(--nb-purple);
        }

        .modal-header-custom .modal-title {
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--nb-white);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modal-header-custom .btn-close {
            filter: invert(1);
        }

        .modal-body-custom {
            padding: 24px;
        }

        .modal-footer-custom {
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

        /* Floating Action Button */
        .fab {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 100;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--nb-shadow);
        }

        .fab:hover {
            transform: translate(-2px, -2px) scale(1.05);
            box-shadow: var(--nb-shadow-hover);
        }

        /* Forms */
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

        .form-select-custom {
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

        .form-select-custom:focus {
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow);
            transform: translate(-2px, -2px);
        }

        .form-check-input-custom {
            width: 18px;
            height: 18px;
            border: var(--nb-border);
            border-radius: 4px;
            cursor: pointer;
        }

        .form-check-input-custom:checked {
            background-color: var(--nb-purple);
            border-color: var(--nb-black);
        }

        /* Alert Info */
        .alert-info-custom {
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            padding: 12px 16px;
            background: var(--nb-offwhite);
            font-size: 0.82rem;
        }

        .alert-info-custom strong {
            color: var(--nb-black);
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

        /* DataTables - Show Entries Dropdown & Search */
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-body);
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--nb-dark);
        }

        .dataTables_wrapper .dataTables_length label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0;
        }

        .dataTables_wrapper .dataTables_length select {
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 8px 14px;
            font-family: var(--font-display);
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--nb-black);
            background: var(--nb-white);
            outline: none;
            cursor: pointer;
            box-shadow: var(--nb-shadow-sm);
            transition: all 0.15s ease;
            min-width: 70px;
            appearance: auto;
            -webkit-appearance: auto;
            -moz-appearance: auto;
        }

        .dataTables_wrapper .dataTables_length select:hover {
            background: var(--nb-yellow);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .dataTables_wrapper .dataTables_length select:focus {
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow);
            transform: translate(-2px, -2px);
        }

        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            font-family: var(--font-body);
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--nb-dark);
        }

        .dataTables_wrapper .dataTables_filter label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 10px 16px 10px 40px;
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--nb-black);
            background: var(--nb-white) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23000' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'/%3E%3C/svg%3E") no-repeat 12px center;
            background-size: 18px;
            outline: none;
            box-shadow: var(--nb-shadow-sm);
            transition: all 0.15s ease;
            min-width: 220px;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow);
            transform: translate(-2px, -2px);
            background-color: var(--nb-yellow);
        }

        .dataTables_wrapper .dataTables_filter input::placeholder {
            color: #999;
            font-weight: 500;
        }

        /* DataTables Pagination */
        .dataTables_wrapper .dataTables_paginate {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            padding-top: 16px;
            border-top: 2px solid var(--nb-gray);
            margin-top: 8px;
            flex-wrap: wrap;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            height: 42px;
            padding: 0 16px;
            font-family: var(--font-display);
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--nb-black);
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            box-shadow: var(--nb-shadow-sm);
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            user-select: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled) {
            background: var(--nb-yellow);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:active:not(.disabled) {
            transform: translate(2px, 2px);
            box-shadow: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--nb-black);
            color: var(--nb-white);
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow);
            transform: translate(-2px, -2px);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--nb-dark);
            color: var(--nb-white);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            background: var(--nb-gray);
            color: var(--nb-dark);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
        .dataTables_wrapper .dataTables_paginate .paginate_button.next {
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .dataTables_wrapper .dataTables_info {
            font-family: var(--font-body);
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--nb-dark);
            padding-top: 20px;
        }

        .dataTables_wrapper .dataTables_info .dataTables_info_current,
        .dataTables_wrapper .dataTables_info .dataTables_info_total {
            font-weight: 700;
            color: var(--nb-black);
        }

        .table-card-body .dataTables_wrapper {
            padding: 20px 24px;
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

            .fab {
                bottom: 16px;
                right: 16px;
                width: 48px;
                height: 48px;
            }
        }
    </style>
</head>

<body>
    <div id="notification-container">
        @if (session('success'))
            <div class="alert-custom info">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert-custom warning">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif
    </div>

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
            <!-- Page Header -->
            <div class="page-title-section">
                <h4>Daftar Admin</h4>
                <p>Kelola pengguna dengan akses admin</p>
            </div>

            @if (!$isSuperAdmin)
                <div class="alert-custom info">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>Informasi Hak Akses</strong><br>
                        Sebagai <strong>Admin Biasa</strong>, Anda dapat: Melihat daftar admin, mengaktifkan akun
                        non-aktif, mengedit username dan email akun sendiri.
                        <strong>Tidak dapat:</strong> mengedit superadmin, menghapus admin, menambah admin baru.
                    </div>
                </div>
            @endif

            <!-- Action Button -->
            <div class="d-flex justify-content-end mb-3">
                @if ($isSuperAdmin)
                    <button class="btn-add-admin" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus"></i> Tambah Admin
                    </button>
                @endif
            </div>

            <!-- Data Table -->
            <div class="table-card">
                <div class="table-card-body">
                    <div style="overflow-x: auto;">
                        <table class="table-clean" id="usersTableDesktop">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Terakhir Login</th>
                                    <th style="width: 180px;">Aksi</th>
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
                                        <td style="color:var(--nb-dark); font-weight:600;">{{ $no++ }}</td>
                                        <td>
                                            <div class="user-cell">
                                                <div class="avatar" style="overflow:hidden;">
                                                    @if (!empty($user->foto))
                                                        <img src="{{ $user->foto }}" alt="Foto"
                                                            style="width:100%;height:100%;object-fit:cover;border-radius:6px;">
                                                    @else
                                                        {{ strtoupper(substr($user->username, 0, 1)) }}
                                                    @endif
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
                                                        <span class="badge-verified">
                                                            <i class="fas fa-check-circle"></i> Terverifikasi
                                                        </span>
                                                    @else
                                                        <span class="badge-unverified">
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
                                                    class="badge-status {{ $user->is_active ? 'active' : 'inactive' }}">{{ $user->is_active ? 'AKTIF' : 'NONAKTIF' }}</span>
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
                                        <td style="font-weight:600;">
                                            {{ $user->last_login ? date('d/m/Y H:i', strtotime($user->last_login)) : '-' }}
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
                                                            class="action-btn"
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
            </div>
        </div>
    </div>

    <!-- Modal Tambah (hanya untuk superadmin) -->
    @if ($isSuperAdmin)
        <div class="modal fade" id="addModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-content-custom">
                    <form method="POST" action="{{ url('/admin/manage-users/store') }}">
                        @csrf
                        <div class="modal-header modal-header-custom">
                            <h5 class="modal-title">
                                <i class="fas fa-user-plus me-2"></i> Tambah Admin Baru
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body modal-body-custom">
                            <div class="mb-3">
                                <label class="form-label-custom">Username</label>
                                <input type="text" name="username" class="form-control-custom" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label-custom">Password</label>
                                <input type="password" name="password" class="form-control-custom" required
                                    minlength="6">
                                <small
                                    style="color:var(--nb-dark);font-size:0.75rem;margin-top:4px;display:block;font-weight:500;">Minimal
                                    6 karakter</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label-custom">Email</label>
                                <input type="email" name="email" class="form-control-custom">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-custom">Role</label>
                                <select name="role" class="form-select-custom" required>
                                    <option value="admin">Admin</option>
                                    <option value="superadmin">Superadmin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer-custom">
                            <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Batal
                            </button>
                            <button type="submit" class="btn-modal-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom">
                <form method="POST" action="{{ url('/admin/manage-users/update') }}">
                    @csrf
                    <div class="modal-header modal-header-custom">
                        <h5 class="modal-title">
                            <i class="fas fa-user-edit me-2"></i> Edit Admin
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body modal-body-custom">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label class="form-label-custom">Username</label>
                            <input type="text" name="username" id="edit_username" class="form-control-custom"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label-custom">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control-custom">
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Role</label>
                            <select name="role" id="edit_role" class="form-select-custom" required>
                                <option value="admin">Admin</option>
                                <option value="superadmin">Superadmin</option>
                            </select>
                        </div>

                        <div class="mb-3" style="display: flex; align-items: center; gap: 8px;">
                            <input type="checkbox" name="is_active" id="edit_is_active"
                                class="form-check-input-custom">
                            <label class="form-check-label" for="edit_is_active"
                                style="font-weight: 700; font-size: 0.85rem;">
                                Aktif
                            </label>
                        </div>

                        <div id="protection_info" class="alert-info-custom d-none">
                            <small style="color: var(--nb-dark);">
                                <i class="fas fa-info-circle me-1"></i>
                                <span id="protection_message"></span>
                            </small>
                        </div>

                        <div id="last_active_warning" class="alert-info-custom d-none"
                            style="background: var(--nb-orange);">
                            <small style="color: var(--nb-black);">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                <span id="last_active_message"></span>
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn-modal-primary">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
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
