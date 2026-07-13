<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal - Admin Panel</title>
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

        /* Content */
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
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .data-count-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--nb-blue);
            color: var(--nb-white);
            font-family: var(--font-display);
            font-size: 0.78rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .semester-info {
            font-family: var(--font-body);
            font-size: 0.82rem;
            color: var(--nb-dark);
            font-weight: 600;
        }

        .semester-info strong {
            color: var(--nb-black);
            font-weight: 700;
        }

        .actions-bar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
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

        .btn-outline-secondary-custom {
            padding: 12px 24px;
            background: var(--nb-white);
            color: var(--nb-black);
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

        .btn-outline-secondary-custom:hover {
            background: var(--nb-gray);
            color: var(--nb-black);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-destructive-outline {
            padding: 12px 24px;
            background: var(--nb-white);
            color: var(--nb-red);
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

        .btn-destructive-outline:hover:not(:disabled) {
            background: var(--nb-red);
            color: var(--nb-white);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-destructive-outline:disabled {
            opacity: 0.5;
            cursor: not-allowed;
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
            min-width: 200px;
            box-shadow: var(--nb-shadow-sm);
        }

        .filter-group select:focus,
        .filter-group input:focus {
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow);
            transform: translate(-2px, -2px);
        }

        /* Active Filter Bar */
        .active-filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 12px;
            padding: 10px 14px;
            background: var(--nb-yellow);
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            font-family: var(--font-body);
            font-size: 0.82rem;
            color: var(--nb-black);
            font-weight: 600;
            box-shadow: var(--nb-shadow-sm);
        }

        .active-filter-bar .filter-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--nb-white);
            color: var(--nb-black);
            font-family: var(--font-display);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: var(--nb-radius-sm);
            border: 2px solid var(--nb-black);
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
            background: var(--nb-teal);
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

        .stat-card-icon.green {
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

        .class-badge {
            display: inline-block;
            background: var(--nb-blue);
            color: var(--nb-white);
            font-family: var(--font-display);
            font-size: 0.78rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: var(--nb-radius-sm);
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .room-badge {
            display: inline-block;
            background: var(--nb-green);
            color: var(--nb-black);
            font-family: var(--font-display);
            font-size: 0.78rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: var(--nb-radius-sm);
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .semester-badge {
            display: inline-block;
            font-family: var(--font-display);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: var(--nb-radius-sm);
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
        }

        .semester-badge.ganjil {
            background: var(--nb-orange);
            color: var(--nb-black);
        }

        .semester-badge.genap {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .time-slot-badge {
            display: inline-block;
            background: var(--nb-dark);
            color: var(--nb-white);
            font-family: var(--font-display);
            font-size: 0.78rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: var(--nb-radius-sm);
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
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

        .empty-state .btn-primary-solid {
            margin-top: 16px;
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
            max-height: 65vh;
            overflow-y: auto;
        }

        /* DataTables override */
        .dataTables_wrapper .dataTables_length {
            padding: 14px 18px;
            float: left;
            font-family: var(--font-body);
            font-size: 0.82rem;
            color: var(--nb-black);
            font-weight: 600;
        }

        .dataTables_wrapper .dataTables_length select {
            padding: 6px 10px;
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-body);
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--nb-black);
            outline: none;
            margin: 0 6px;
            background: var(--nb-white);
            box-shadow: var(--nb-shadow-sm);
        }

        .dataTables_wrapper .dataTables_filter {
            padding: 14px 18px;
            float: right;
            font-family: var(--font-body);
            font-size: 0.82rem;
            color: var(--nb-black);
            font-weight: 600;
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 8px 12px;
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-body);
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--nb-black);
            outline: none;
            margin-left: 8px;
            min-width: 180px;
            background: var(--nb-white);
            box-shadow: var(--nb-shadow-sm);
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--nb-black);
            box-shadow: var(--nb-shadow);
        }

        .dataTables_wrapper .dataTables_info {
            padding: 14px 18px;
            float: left;
            font-family: var(--font-body);
            font-size: 0.78rem;
            color: var(--nb-dark);
            font-weight: 600;
            clear: both;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding: 14px 18px;
            float: right;
            font-family: var(--font-body);
            font-size: 0.82rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 14px;
            margin: 0 4px;
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            color: var(--nb-black);
            cursor: pointer;
            display: inline-block;
            transition: all 0.15s ease;
            font-family: var(--font-display);
            font-size: 0.82rem;
            font-weight: 700;
            background: var(--nb-white);
            box-shadow: var(--nb-shadow-sm);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--nb-yellow);
            color: var(--nb-black);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--nb-purple);
            color: var(--nb-white);
            border-color: var(--nb-black);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4;
            cursor: default;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background: var(--nb-white);
            color: var(--nb-black);
            transform: none;
            box-shadow: var(--nb-shadow-sm);
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

            .actions-bar {
                flex-direction: column;
                align-items: flex-start;
            }

            .actions-bar-right {
                width: 100%;
            }

            .actions-bar-right .btn-primary-solid,
            .actions-bar-right .btn-outline-secondary-custom,
            .actions-bar-right .btn-destructive-outline {
                flex: 1;
                justify-content: center;
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

            .dataTables_wrapper .dataTables_filter input {
                min-width: 120px;
            }
        }
    </style>
</head>

<body>
    <div id="notification-container">
        @if (session('message'))
            <div class="alert-flash success">
                <i class="fas fa-check-circle"></i> {{ session('message') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert-flash error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
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
                <h4>Kelola Jadwal Kuliah</h4>
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
                <h4>Kelola Jadwal Kuliah</h4>
                <p>Atur dan kelola jadwal perkuliahan untuk semua kelas</p>
            </div>

            <!-- Actions Bar -->
            <div class="actions-bar">
                <div class="actions-bar-left">
                    <span class="data-count-badge">
                        <i class="fas fa-database" style="font-size:0.7rem;"></i> {{ count($schedules) }} data
                    </span>
                    <span class="semester-info">
                        Semester Aktif: <strong>{{ $semesterAktif }} - {{ $tahunAkademikAktif }}</strong>
                    </span>
                </div>
                <div class="actions-bar-right">
                    <button class="btn-destructive-outline" data-bs-toggle="modal" data-bs-target="#deleteAllModal"
                        {{ count($schedules) == 0 ? 'disabled' : '' }} id="btnDeleteAll">
                        <i class="fas fa-trash-alt"></i> Hapus Semua
                    </button>
                    <button class="btn-outline-secondary-custom" data-bs-toggle="modal" data-bs-target="#bulkAddModal">
                        <i class="fas fa-layer-group"></i> Tambah Massal
                    </button>
                    <button class="btn-primary-solid" data-bs-toggle="modal" data-bs-target="#addModal"
                        id="btnAddSchedule">
                        <i class="fas fa-plus"></i> Tambah Jadwal
                    </button>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="filter-card">
                <form method="GET" class="filter-inline">
                    <div class="filter-group">
                        <label>Tahun Akademik</label>
                        <select name="filter_tahun" onchange="this.form.submit()">
                            <option value="all">Semua Tahun Akademik</option>
                            @foreach ($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ $filterTahun == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Semester</label>
                        <select name="filter_semester" onchange="this.form.submit()">
                            <option value="all">Semua Semester</option>
                            <option value="GANJIL" {{ $filterSemester == 'GANJIL' ? 'selected' : '' }}>GANJIL</option>
                            <option value="GENAP" {{ $filterSemester == 'GENAP' ? 'selected' : '' }}>GENAP</option>
                        </select>
                    </div>
                    <div class="filter-group" style="justify-content:flex-end;">
                        <a href="{{ url('/admin/manage-schedule') }}" class="btn-outline-secondary-custom"
                            style="padding:10px 22px;text-decoration:none;">
                            <i class="fas fa-redo"></i> Reset Filter
                        </a>
                    </div>
                </form>
                @if ($filterTahun != 'all' || $filterSemester != 'all')
                    <div class="active-filter-bar">
                        <i class="fas fa-filter"></i>
                        Filter Aktif:
                        @if ($filterTahun != 'all')
                            <span class="filter-tag">Tahun: {{ $filterTahun }}</span>
                        @endif
                        @if ($filterSemester != 'all')
                            <span class="filter-tag">Semester: {{ $filterSemester }}</span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total Jadwal</span>
                        <div class="stat-card-icon blue"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                    <div class="stat-card-value">{{ count($schedules) }}</div>
                    <div class="stat-card-footer"><small>Jadwal terdaftar</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total Kelas</span>
                        <div class="stat-card-icon green"><i class="fas fa-users"></i></div>
                    </div>
                    <div class="stat-card-value">{{ count($kelasList) }}</div>
                    <div class="stat-card-footer"><small>Kelas terdaftar</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Total Ruangan</span>
                        <div class="stat-card-icon amber"><i class="fas fa-door-open"></i></div>
                    </div>
                    <div class="stat-card-value">{{ count($rooms) }}</div>
                    <div class="stat-card-footer"><small>Ruangan tersedia</small></div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-card-label">Tahun Akademik</span>
                        <div class="stat-card-icon purple"><i class="fas fa-graduation-cap"></i></div>
                    </div>
                    <div class="stat-card-value">{{ count($tahunList) }}</div>
                    <div class="stat-card-footer"><small>Tahun aktif</small></div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-card">
                <div class="table-card-header">
                    <h5><i class="fas fa-list"></i> Daftar Jadwal Kuliah</h5>
                </div>
                <div class="table-card-body">
                    @if (count($schedules) == 0)
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h5>Belum ada data jadwal</h5>
                            <p>Mulai dengan menambahkan jadwal baru</p>
                            <button class="btn-primary-solid" data-bs-toggle="modal" data-bs-target="#addModal"
                                style="margin-top:12px;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    @else
                        <div style="overflow-x: auto;">
                            <table class="table-clean" id="scheduleTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kelas</th>
                                        <th>Hari</th>
                                        <th>Jam Ke</th>
                                        <th>Waktu</th>
                                        <th>Mata Kuliah</th>
                                        <th>Dosen</th>
                                        <th>Ruang</th>
                                        <th>Semester</th>
                                        <th>Tahun</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($schedules as $schedule)
                                        <tr>
                                            <td style="color:var(--nb-dark); font-weight:600;">{{ $no++ }}
                                            </td>
                                            <td><span class="class-badge">{{ $schedule->kelas }}</span></td>
                                            <td style="font-weight:600;">{{ $schedule->hari }}</td>
                                            <td style="font-weight:600;">{{ $schedule->jam_ke }}</td>
                                            <td><span class="time-slot-badge">{{ $schedule->waktu }}</span></td>
                                            <td style="font-weight:600;">{{ $schedule->mata_kuliah }}</td>
                                            <td style="font-weight:500;">{{ $schedule->dosen }}</td>
                                            <td><span class="room-badge">{{ $schedule->ruang }}</span></td>
                                            <td>
                                                <span class="semester-badge {{ strtolower($schedule->semester) }}">
                                                    {{ $schedule->semester }}
                                                </span>
                                            </td>
                                            <td style="font-weight:600;">{{ $schedule->tahun_akademik }}</td>
                                            <td>
                                                <div class="action-group">
                                                    <button class="action-btn"
                                                        onclick='editSchedule(@json($schedule))'
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="{{ url('/admin/manage-schedule/delete/' . $schedule->id) }}"
                                                        class="action-btn danger"
                                                        onclick="return confirm('Yakin hapus jadwal ini?')"
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
                    @endif
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

        @if (count($schedules) > 0)
            $(document).ready(function() {
                $('#scheduleTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/id.json"
                    },
                    "order": [
                        [0, 'asc']
                    ],
                    "pageLength": 10,
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "Semua"]
                    ]
                });
            });
        @endif

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

    <!-- Include modals from original file -->
    @include('admin.schedule-modals')
</body>

</html>
