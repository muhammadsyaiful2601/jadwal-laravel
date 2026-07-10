<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Jadwal Kuliah - {{ $institusiNama }}</title>
    <link rel="icon" type="image/png" href="{{ asset('jadwal-kampus/assets/images/si.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #1e293b;
            --primary-light: #334155;
            --accent: #2563eb;
            --accent-hover: #1d4ed8;
            --accent-light: #dbeafe;
            --success: #059669;
            --success-light: #d1fae5;
            --success-bg: #ecfdf5;
            --warning: #d97706;
            --warning-light: #fef3c7;
            --warning-bg: #fffbeb;
            --danger: #dc2626;
            --purple: #7c3aed;
            --purple-light: #ede9fe;
            --purple-bg: #f5f3ff;
            --dark: #0f172a;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            font-weight: 400;
        }

        /* Maintenance Mode */
        body.maintenance-active {
            overflow: hidden;
        }

        .maintenance-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .maintenance-content {
            background: white;
            border-radius: 16px;
            padding: 48px;
            text-align: center;
            max-width: 480px;
            width: 100%;
            box-shadow: var(--shadow-xl);
            animation: slideUp 0.5s ease;
        }

        .maintenance-icon {
            font-size: 4rem;
            color: var(--warning);
            margin-bottom: 24px;
            animation: spin 3s linear infinite;
        }

        .maintenance-content h2 {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 16px;
            font-size: 1.75rem;
        }

        .maintenance-message {
            color: var(--gray-600);
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .maintenance-info {
            background: var(--gray-50);
            padding: 12px 24px;
            border-radius: 8px;
            display: inline-block;
            color: var(--gray-600);
            font-size: 0.875rem;
            border: 1px solid var(--gray-200);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Header - Clean App Header */
        .app-header {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
            flex-wrap: wrap;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
        }

        .institution-info {
            text-align: center;
            flex: 1;
        }

        .logo-img {
            height: 56px;
            width: auto;
            object-fit: contain;
        }

        .institution-info h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--gray-900);
            margin: 0;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .institution-info h2 {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-600);
            margin: 4px 0 0 0;
        }

        .institution-info .institution-sub {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--accent);
            margin: 6px 0 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .institution-info .institution-divider {
            color: var(--gray-300);
            font-weight: 400;
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .btn-reset {
            padding: 10px 20px;
            border: 1.5px solid var(--gray-300);
            background: white;
            color: var(--gray-700);
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-reset:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
            color: var(--gray-900);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        /* Filter Section - Interactive Control Panel */
        .filter-section {
            background: white;
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 32px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-200);
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--gray-100);
        }

        .filter-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-title i {
            color: var(--accent);
            font-size: 1.25rem;
        }

        .filter-meta {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-top: 4px;
            font-weight: 400;
        }

        .filter-meta strong {
            color: var(--gray-900);
            font-weight: 600;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
        }

        .btn-filter-action {
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-action {
            background: var(--accent);
            color: white;
        }

        .btn-primary-action:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-outline-action {
            background: white;
            color: var(--gray-700);
            border: 1.5px solid var(--gray-300);
        }

        .btn-outline-action:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
            color: var(--gray-900);
        }

        .filter-group {
            margin-bottom: 20px;
        }

        .filter-group:last-child {
            margin-bottom: 0;
        }

        .filter-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-label i {
            color: var(--accent);
            font-size: 1rem;
        }

        .filter-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filter-pill {
            padding: 10px 18px;
            border-radius: 100px;
            border: none;
            background: var(--gray-100);
            color: var(--gray-700);
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .filter-pill:hover {
            background: var(--gray-200);
            color: var(--gray-900);
            transform: translateY(-1px);
        }

        .filter-pill.active {
            background: var(--accent);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .filter-pill i {
            font-size: 0.875rem;
        }

        /* Current & Next Schedule Section */
        .current-next-section {
            margin-bottom: 40px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--gray-900);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title i {
            color: var(--accent);
            font-size: 1.5rem;
        }

        .section-subtitle {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-top: 4px;
            font-weight: 400;
        }

        .section-actions {
            display: flex;
            gap: 10px;
        }

        .btn-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 1.5px solid var(--gray-300);
            background: white;
            color: var(--gray-700);
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-icon:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
            color: var(--gray-900);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .current-next-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .schedule-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            position: relative;
            transition: all 0.3s ease;
        }

        .schedule-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .schedule-card.accent-left::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 8px;
            background: var(--purple);
        }

        .schedule-card.accent-green::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 8px;
            background: var(--success);
        }

        .schedule-card-header {
            padding: 24px;
            border-bottom: 1px solid var(--gray-100);
        }

        .schedule-card-header.primary-bg {
            background: var(--primary);
            color: white;
        }

        .schedule-card-header.success-bg {
            background: var(--success);
            color: white;
        }

        .schedule-card-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .schedule-card-body {
            padding: 24px;
        }

        .schedule-card-body.flex-center {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 280px;
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            background: var(--accent-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .empty-state-icon i {
            font-size: 2.5rem;
            color: var(--accent);
        }

        .empty-state-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 8px;
        }

        .empty-state-text {
            font-size: 0.875rem;
            color: var(--gray-600);
            text-align: center;
            max-width: 280px;
        }

        .current-schedule-content {
            display: flex;
            gap: 24px;
            align-items: center;
        }

        .schedule-time-badge {
            text-align: center;
            min-width: 100px;
        }

        .schedule-time-badge .time-number {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1;
            color: var(--gray-900);
            letter-spacing: -0.03em;
        }

        .schedule-time-badge .time-label {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-top: 8px;
            font-weight: 500;
        }

        .schedule-details {
            flex: 1;
        }

        .schedule-course-name {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: 16px;
            line-height: 1.3;
        }

        .schedule-info-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 0.9375rem;
            color: var(--gray-700);
        }

        .schedule-info-row i {
            color: var(--accent);
            width: 18px;
            font-size: 0.9375rem;
        }

        .schedule-info-row strong {
            color: var(--gray-900);
            font-weight: 600;
        }

        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 0.8125rem;
            font-weight: 600;
            margin-top: 12px;
        }

        .badge-pill.success-pill {
            background: var(--success-bg);
            color: var(--success);
        }

        .badge-pill.warning-pill {
            background: var(--warning-bg);
            color: var(--warning);
        }

        .badge-pill i {
            font-size: 0.75rem;
        }

        .countdown-box {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 16px;
            margin-top: 16px;
        }

        .countdown-label {
            font-size: 0.8125rem;
            color: var(--gray-600);
            text-align: center;
            margin-bottom: 12px;
            font-weight: 500;
        }

        .countdown-timer {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .countdown-unit {
            background: white;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid var(--gray-200);
            text-align: center;
            min-width: 60px;
        }

        .countdown-unit .countdown-value {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--gray-900);
            line-height: 1;
        }

        .countdown-unit .countdown-text {
            font-size: 0.6875rem;
            color: var(--gray-600);
            margin-top: 4px;
            font-weight: 500;
        }

        .btn-detail-modern {
            padding: 10px 20px;
            border: 1.5px solid var(--accent);
            background: white;
            color: var(--accent);
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
        }

        .btn-detail-modern:hover {
            background: var(--accent);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Info Box */
        .info-box {
            background: var(--accent-light);
            border-left: 4px solid var(--accent);
            border-radius: 12px;
            padding: 16px 20px;
            margin-top: 24px;
        }

        .info-box-content {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .info-box-icon {
            color: var(--accent);
            font-size: 1.25rem;
            margin-top: 2px;
        }

        .info-box-text {
            flex: 1;
        }

        .info-box-title {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--gray-600);
            margin-bottom: 8px;
        }

        .info-box-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .info-tag {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.875rem;
            color: var(--gray-700);
        }

        .info-tag i {
            color: var(--accent);
            font-size: 0.875rem;
        }

        .info-tag strong {
            color: var(--gray-900);
            font-weight: 600;
        }

        /* Schedule List Section */
        .schedule-list-section {
            margin-bottom: 40px;
        }

        .schedule-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .schedule-count-badge {
            background: var(--primary);
            color: white;
            padding: 8px 16px;
            border-radius: 100px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .schedule-list-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 20px;
        }

        .schedule-list-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-200);
            display: flex;
            gap: 16px;
            transition: all 0.2s ease;
            position: relative;
        }

        .schedule-list-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent);
        }

        .schedule-list-card.active {
            border-color: var(--success);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }

        .schedule-time-box {
            background: var(--gray-100);
            border: 1px solid var(--gray-200);
            border-radius: 10px;
            padding: 12px 16px;
            text-align: center;
            min-width: 90px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .schedule-time-box .time-start {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .schedule-time-box .time-separator {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin: 4px 0;
        }

        .schedule-time-box .time-end {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .schedule-content {
            flex: 1;
        }

        .schedule-course {
            font-size: 1.0625rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .schedule-meta {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 12px;
        }

        .schedule-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .schedule-meta-item i {
            color: var(--accent);
            width: 16px;
            font-size: 0.875rem;
        }

        .schedule-meta-item a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        .schedule-meta-item a:hover {
            text-decoration: underline;
        }

        /* Footer */
        .app-footer {
            background: white;
            border-top: 1px solid var(--gray-200);
            padding: 48px 0 24px;
            margin-top: 64px;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 48px;
            margin-bottom: 32px;
        }

        .footer-section h5 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-section h5 i {
            color: var(--accent);
            font-size: 1.125rem;
        }

        .footer-info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 0.9375rem;
            color: var(--gray-700);
        }

        .footer-info-item i {
            color: var(--accent);
            width: 18px;
            font-size: 0.9375rem;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid var(--gray-200);
        }

        .btn-suggestion {
            padding: 12px 24px;
            background: var(--gray-100);
            color: var(--gray-700);
            border: 1.5px solid var(--gray-300);
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .btn-suggestion:hover {
            background: var(--gray-200);
            border-color: var(--gray-400);
            color: var(--gray-900);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .footer-copyright {
            font-size: 0.875rem;
            color: var(--gray-700);
            font-weight: 600;
            margin-bottom: 4px;
        }

        .footer-version {
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        /* Mobile Sidebar */
        .sidebar-filter {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100vh;
            background: white;
            z-index: 1050;
            transition: left 0.3s ease;
            box-shadow: var(--shadow-xl);
            overflow-y: auto;
        }

        .sidebar-filter.show {
            left: 0;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.5);
            z-index: 1049;
            display: none;
        }

        .overlay.show {
            display: block;
        }

        .sidebar-header {
            background: var(--primary);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-header h5 {
            margin: 0;
            font-weight: 700;
        }

        .sidebar-body {
            padding: 20px;
        }

        .sidebar-footer {
            position: sticky;
            bottom: 0;
            background: white;
            padding: 16px 20px;
            border-top: 1px solid var(--gray-200);
        }

        .filter-toggle-btn {
            background: var(--accent) !important;
            color: white !important;
            border: none !important;
            padding: 10px 20px !important;
            border-radius: 100px !important;
            font-weight: 600 !important;
        }

        .filter-toggle-btn:hover {
            background: var(--accent-hover) !important;
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .current-next-grid {
                grid-template-columns: 1fr;
            }

            .schedule-list-grid {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }
        }

        @media (max-width: 767.98px) {
            .header-content {
                flex-wrap: wrap;
            }

            .institution-info h1 {
                font-size: 1.25rem;
            }

            .filter-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .filter-actions {
                width: 100%;
            }

            .filter-actions .btn-filter-action {
                flex: 1;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .current-schedule-content {
                flex-direction: column;
                text-align: center;
            }

            .schedule-time-badge {
                min-width: auto;
            }
        }

        @media (max-width: 576px) {
            .filter-pills {
                flex-direction: column;
            }

            .filter-pill {
                width: 100%;
                justify-content: center;
            }
        }

        @media print {

            .current-next-section,
            .filter-section,
            .filter-toggle-btn,
            .sidebar-filter,
            .overlay,
            .section-actions {
                display: none !important;
            }
        }

        .collapsed-section #currentScheduleContent {
            display: none !important;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .schedule-card,
        .schedule-list-card {
            animation: fadeInUp 0.4s ease;
        }
    </style>
</head>

<body class="{{ $maintenanceMode == '1' ? 'maintenance-active' : '' }}">

    @if ($maintenanceMode == '1')
        <div class="maintenance-modal" id="maintenanceModal">
            <div class="maintenance-content">
                <div class="maintenance-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <h2>Sistem Sedang Dalam Perawatan</h2>
                <p class="maintenance-message">{{ $maintenanceMessage }}</p>
                <div class="maintenance-info">
                    <i class="fas fa-clock me-2"></i>
                    <span>{{ now()->format('d F Y, H:i') }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Header - Clean App Header -->
    <header class="app-header">
        <div class="header-container">
            <div class="header-content">
                <div class="logo-section">
                    <img src="{{ asset('jadwal-kampus/assets/images/logo_kampus.png') }}" alt="Logo Kampus"
                        class="logo-img"
                        onerror="this.onerror=null; this.src='https://via.placeholder.com/56x56/1e293b/ffffff?text=LOGO'">
                </div>
                <div class="institution-info">
                    <h1>{{ $headerTitle1 ?? $institusiNama }}</h1>
                    <h2>{{ $headerTitle2 ?? $institusiLokasi }}</h2>
                    <p class="institution-sub">{{ $programStudi }}<span class="institution-divider">|</span>Tahun
                        Akademik {{ $tahunAkademik }}</p>
                </div>
                <div class="logo-section">
                    <img src="{{ asset('jadwal-kampus/assets/images/logo_jurusan.png') }}" alt="Logo Jurusan"
                        class="logo-img"
                        onerror="this.onerror=null; this.src='https://via.placeholder.com/56x56/1e293b/ffffff?text=LOGO'">
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Filter Toggle -->
    <div class="main-container d-md-none" style="padding-top: 16px; padding-bottom: 0;">
        <button class="btn filter-toggle-btn w-100" onclick="toggleSidebar()">
            <i class="fas fa-filter me-2"></i> Filter Jadwal
        </button>
    </div>

    <!-- Sidebar Filter Mobile -->
    <div class="sidebar-filter d-md-none" id="mobileSidebar">
        <div class="sidebar-header">
            <h5><i class="fas fa-filter me-2"></i> Filter Jadwal</h5>
            <button class="btn btn-close btn-close-white" onclick="toggleSidebar()"></button>
        </div>
        <div class="sidebar-body">
            <div class="mb-4">
                <h6 class="mb-3"><i class="fas fa-calendar-day me-2"></i> Pilih Hari</h6>
                <div class="filter-pills" id="filter-hari-mobile">
                    @foreach ($hariMap as $num => $hari)
                        <button class="filter-pill {{ !$tampilSemuaHari && $hariSelected == $num ? 'active' : '' }}"
                            data-type="hari" data-value="{{ $num }}" onclick="applyFilter(this)">
                            <i class="fas fa-calendar-day"></i> {{ $hari }}
                        </button>
                    @endforeach
                    <button class="filter-pill {{ $tampilSemuaHari ? 'active' : '' }}" data-type="semua_hari"
                        data-value="1" onclick="applyFilter(this)">
                        <i class="fas fa-layer-group"></i> Semua Hari
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <h6 class="mb-3"><i class="fas fa-users me-2"></i> Pilih Kelas</h6>
                @if (!empty($kelasList))
                    <div class="filter-pills" id="filter-kelas-mobile">
                        @foreach ($kelasList as $kelas)
                            <button
                                class="filter-pill {{ !$tampilSemuaKelas && $kelasSelected == $kelas ? 'active' : '' }}"
                                data-type="kelas" data-value="{{ $kelas }}" onclick="applyFilter(this)">
                                <i class="fas fa-graduation-cap"></i> {{ $kelas }}
                            </button>
                        @endforeach
                        <button class="filter-pill {{ $tampilSemuaKelas ? 'active' : '' }}" data-type="semua_kelas"
                            data-value="1" onclick="applyFilter(this)">
                            <i class="fas fa-layer-group"></i> Semua Kelas
                        </button>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Tidak ada kelas tersedia
                    </div>
                @endif
            </div>
        </div>
        <div class="sidebar-footer">
            <button class="btn btn-primary-action btn-filter-action w-100 mb-2" onclick="handleShowAllSchedule()">
                <i class="fas fa-eye me-2"></i> Tampilkan Semua
            </button>
            <button class="btn btn-outline-action btn-filter-action w-100" onclick="handleResetFilter()">
                <i class="fas fa-undo me-2"></i> Reset Filter
            </button>
        </div>
    </div>
    <div class="overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <main class="main-container">
        <!-- Filter Section -->
        <section class="filter-section d-none d-md-block">
            <div class="filter-header">
                <div>
                    <h3 class="filter-title">
                        <i class="fas fa-filter"></i>
                        Filter Jadwal
                    </h3>
                    <p class="filter-meta">
                        Tahun Akademik: <strong>{{ $tahunAkademik }}</strong> |
                        Semester: <strong>{{ $semesterAktif }}</strong>
                    </p>
                </div>
                <div class="filter-actions">
                    <button class="btn-filter-action btn-primary-action" onclick="handleShowAllSchedule()">
                        <i class="fas fa-eye"></i> Tampilkan Semua
                    </button>
                    <button class="btn-filter-action btn-outline-action" onclick="handleResetFilter()">
                        <i class="fas fa-undo"></i> Reset Filter
                    </button>
                </div>
            </div>

            <div class="filter-group">
                <div class="filter-label">
                    <i class="fas fa-calendar-day"></i>
                    Pilih Hari
                </div>
                <div class="filter-pills" id="filter-hari-desktop">
                    @foreach ($hariMap as $num => $hari)
                        <button class="filter-pill {{ !$tampilSemuaHari && $hariSelected == $num ? 'active' : '' }}"
                            data-type="hari" data-value="{{ $num }}" onclick="applyFilter(this)">
                            <i class="fas fa-calendar-day"></i> {{ $hari }}
                        </button>
                    @endforeach
                    <button class="filter-pill {{ $tampilSemuaHari ? 'active' : '' }}" data-type="semua_hari"
                        data-value="1" onclick="applyFilter(this)">
                        <i class="fas fa-layer-group"></i> Semua Hari
                    </button>
                </div>
            </div>

            <div class="filter-group">
                <div class="filter-label">
                    <i class="fas fa-users"></i>
                    Pilih Kelas
                </div>
                @if (!empty($kelasList))
                    <div class="filter-pills" id="filter-kelas-desktop">
                        @foreach ($kelasList as $kelas)
                            <button
                                class="filter-pill {{ !$tampilSemuaKelas && $kelasSelected == $kelas ? 'active' : '' }}"
                                data-type="kelas" data-value="{{ $kelas }}" onclick="applyFilter(this)">
                                <i class="fas fa-graduation-cap"></i> {{ $kelas }}
                            </button>
                        @endforeach
                        <button class="filter-pill {{ $tampilSemuaKelas ? 'active' : '' }}" data-type="semua_kelas"
                            data-value="1" onclick="applyFilter(this)">
                            <i class="fas fa-layer-group"></i> Semua Kelas
                        </button>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Tidak ada kelas tersedia untuk semester {{ $semesterAktif }}
                    </div>
                @endif
            </div>
        </section>

        <!-- Running Text / Marquee -->
        @if (($runningTextEnabled ?? '0') == '1' && !empty($runningTextContent))
            <div class="running-text-bar"
                style="background-color: {{ $runningTextBgColor ?? '#4361ee' }}; color: {{ $runningTextColor ?? '#ffffff' }}; border-radius: 12px; overflow: hidden; margin-bottom: 28px;">
                <marquee behavior="scroll" direction="left"
                    style="display: block; padding: 14px 20px; font-weight: 600; font-size: 0.95rem; width: 100%;"
                    @if (($runningTextSpeed ?? 'normal') == 'slow') scrollamount="3"
                    @elseif(($runningTextSpeed ?? 'normal') == 'fast') scrollamount="8"
                    @else scrollamount="5" @endif>
                    {!! $runningTextContent ?? '' !!}
                </marquee>
            </div>
        @endif

        <!-- Jadwal Terdekat Section -->
        <div class="current-next-section" id="currentNextSection">
            <div class="section-header">
                <div>
                    <h3 class="section-title">
                        <i class="fas fa-clock"></i>
                        @if ($tampilSemuaHari)
                            Jadwal Saat Ini ({{ $hariSekarangTeks ?? 'Libur' }})
                        @else
                            Jadwal {{ $hariTeks }}
                        @endif
                    </h3>
                    <p class="section-subtitle">Jadwal berikutnya berdasarkan kelas dan hari ini</p>
                </div>
                <div class="section-actions">
                    <button class="btn-icon" onclick="toggleCurrentSchedule()" title="Sembunyikan/Tampilkan">
                        <i class="fas fa-eye-slash" id="toggleIcon"></i>
                    </button>
                    <button class="btn-icon" onclick="refreshCurrentSchedule(event)" title="Refresh">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>

            <div id="currentScheduleContent">
                <div class="current-next-grid">
                    <!-- Card Kiri: Jadwal Berlangsung -->
                    <div class="schedule-card accent-green">
                        <div class="schedule-card-header success-bg">
                            <h5 class="schedule-card-title">
                                <i class="fas fa-play-circle"></i>
                                Sedang Berlangsung
                            </h5>
                        </div>
                        <div class="schedule-card-body">
                            @if ($jadwalBerlangsung)
                                <div class="current-schedule-content">
                                    <div class="schedule-time-badge">
                                        <div class="time-number">{{ $jadwalBerlangsung->jam_ke }}</div>
                                        <div class="time-label">Jam ke-{{ $jadwalBerlangsung->jam_ke }}</div>
                                    </div>
                                    <div class="schedule-details">
                                        <div class="schedule-course-name">{{ $jadwalBerlangsung->mata_kuliah }}</div>
                                        <div class="schedule-info-row">
                                            <i class="fas fa-user-tie"></i>
                                            <span>{{ $jadwalBerlangsung->dosen }}</span>
                                        </div>
                                        <div class="schedule-info-row">
                                            <i class="fas fa-door-open"></i>
                                            <span>Ruang {{ $jadwalBerlangsung->ruang }}</span>
                                        </div>
                                        <div class="schedule-info-row">
                                            <i class="fas fa-users"></i>
                                            <span>Kelas {{ $jadwalBerlangsung->kelas }}</span>
                                        </div>
                                        <div class="schedule-info-row">
                                            <i class="fas fa-clock"></i>
                                            <span>{{ $jadwalBerlangsung->waktu }}</span>
                                        </div>
                                        <button class="btn-detail-modern"
                                            data-schedule='{{ json_encode($jadwalBerlangsung->toArray()) }}'>
                                            <i class="fas fa-info-circle"></i>
                                            Detail Jadwal
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="schedule-card-body flex-center">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-calendar-times"></i>
                                    </div>
                                    <div class="empty-state-title">Tidak Ada Jadwal Berlangsung</div>
                                    <p class="empty-state-text">
                                        @if ($tampilSemuaHari)
                                            Tidak ada jadwal kuliah yang sedang berlangsung untuk filter ini
                                        @else
                                            Tidak ada jadwal kuliah yang sedang berlangsung saat ini
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Card Kanan: Jadwal Berikutnya -->
                    <div class="schedule-card accent-left">
                        <div class="schedule-card-header primary-bg">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                                <h5 class="schedule-card-title" style="margin: 0;">
                                    <i class="fas fa-clock"></i>
                                    Jadwal Berikutnya
                                </h5>
                                <div>
                                    <span class="badge-pill success-pill">
                                        <i class="fas fa-calendar-day"></i>
                                        Hari Ini: {{ $hariSekarangTeks ?? 'Hari ini' }}
                                    </span>
                                    @if ($selisihHari > 0)
                                        <span class="badge-pill warning-pill">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ $targetHari }} ({{ $selisihHari }} hari lagi)
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="schedule-card-body">
                            @if ($jadwalBerikutnya)
                                <div class="current-schedule-content">
                                    <div class="schedule-time-badge">
                                        <div class="time-number">{{ $jadwalBerikutnya->jam_ke }}</div>
                                        <div class="time-label">Jam ke-{{ $jadwalBerikutnya->jam_ke }}</div>
                                    </div>
                                    <div class="schedule-details">
                                        <div class="schedule-course-name">{{ $jadwalBerikutnya->mata_kuliah }}</div>
                                        <div class="schedule-info-row">
                                            <i class="fas fa-user-tie"></i>
                                            <span>{{ $jadwalBerikutnya->dosen }}</span>
                                        </div>
                                        <div class="schedule-info-row">
                                            <i class="fas fa-door-open"></i>
                                            <span>Ruang {{ $jadwalBerikutnya->ruang }}</span>
                                        </div>
                                        <div class="schedule-info-row">
                                            <i class="fas fa-users"></i>
                                            <span>Kelas {{ $jadwalBerikutnya->kelas }}</span>
                                        </div>
                                        <div class="schedule-info-row">
                                            <i class="fas fa-clock"></i>
                                            <span>{{ $jadwalBerikutnya->waktu }}</span>
                                        </div>

                                        @if ($tampilSemuaHari && $selisihHari > 0)
                                            <div class="badge-pill warning-pill">
                                                <i class="fas fa-calendar-alt"></i>
                                                <strong>Jadwal di hari {{ $targetHari }}</strong>
                                            </div>
                                        @endif

                                        @if ($waktuTungguDetik > 0)
                                            <div class="countdown-box">
                                                <div class="countdown-label">
                                                    <i class="fas fa-hourglass-half me-1"></i>
                                                    Mulai dalam:
                                                </div>
                                                <div class="countdown-timer" id="countdownTimer">
                                                    <div class="countdown-unit">
                                                        <div class="countdown-value" id="countdownDays">0</div>
                                                        <div class="countdown-text">Hari</div>
                                                    </div>
                                                    <div class="countdown-unit">
                                                        <div class="countdown-value" id="countdownHours">00</div>
                                                        <div class="countdown-text">Jam</div>
                                                    </div>
                                                    <div class="countdown-unit">
                                                        <div class="countdown-value" id="countdownMinutes">00</div>
                                                        <div class="countdown-text">Menit</div>
                                                    </div>
                                                    <div class="countdown-unit">
                                                        <div class="countdown-value" id="countdownSeconds">00</div>
                                                        <div class="countdown-text">Detik</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <button class="btn-detail-modern"
                                            data-schedule='{{ json_encode($jadwalBerikutnya->toArray()) }}'>
                                            <i class="fas fa-info-circle"></i>
                                            Detail Jadwal
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="schedule-card-body flex-center">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-calendar-times"></i>
                                    </div>
                                    <div class="empty-state-title">Tidak Ada Jadwal Berikutnya</div>
                                    <p class="empty-state-text">
                                        @if ($tampilSemuaHari)
                                            Tidak ada jadwal kuliah berikutnya untuk filter ini
                                        @else
                                            Tidak ada jadwal kuliah berikutnya
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="info-box">
                    <div class="info-box-content">
                        <i class="fas fa-info-circle info-box-icon"></i>
                        <div class="info-box-text">
                            <div class="info-box-title">Info Sistem & Filter</div>
                            <div class="info-box-tags">
                                <div class="info-tag">
                                    <i class="fas fa-calendar"></i>
                                    Hari: <strong>{{ $tampilSemuaHari ? 'Semua Hari' : $hariTeks }}</strong>
                                    @if ($hariSekarangTeks && !$tampilSemuaHari && $hariTeks != $hariSekarangTeks)
                                        (Hari ini: {{ $hariSekarangTeks }})
                                    @endif
                                </div>
                                <div class="info-tag">
                                    <i class="fas fa-users"></i>
                                    Kelas: <strong>{{ $tampilSemuaKelas ? 'Semua Kelas' : $kelasSelected }}</strong>
                                </div>
                                <div class="info-tag">
                                    <i class="fas fa-clock"></i>
                                    Jadwal berikutnya: Berdasarkan <strong>Kelas</strong> dan <strong>Hari Ini</strong>
                                </div>
                                <div class="info-tag">
                                    <i class="fas fa-clock"></i>
                                    Waktu: <strong>{{ now()->format('H:i') }}</strong>
                                </div>
                                <div class="info-tag">
                                    <i class="fas fa-graduation-cap"></i>
                                    Semester: <strong>{{ $semesterAktif }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Jadwal Section -->
        <section class="schedule-list-section">
            <div class="schedule-list-header">
                <div>
                    <h2 class="section-title">
                        <i class="fas fa-calendar-alt"></i>
                        @if ($tampilSemuaHari)
                            Semua Hari
                        @else
                            Hari {{ $hariTeks }}
                        @endif
                        @if ($tampilSemuaKelas)
                            - Semua Kelas
                        @else
                            - Kelas {{ $kelasSelected }}
                        @endif
                    </h2>
                </div>
                <span class="schedule-count-badge">
                    <i class="fas fa-calendar-check"></i>
                    {{ count($jadwal) }} Jadwal
                </span>
            </div>

            @if (empty($jadwal))
                <div class="schedule-card" style="text-align: center; padding: 60px 20px;">
                    <div class="empty-state-icon" style="margin: 0 auto 20px;">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <div class="empty-state-title">Tidak ada jadwal</div>
                    <p class="empty-state-text" style="max-width: 100%;">Tidak ada jadwal kuliah untuk kriteria yang
                        dipilih</p>
                    <button class="btn-detail-modern" onclick="handleShowAllSchedule()" style="margin-top: 20px;">
                        <i class="fas fa-eye"></i>
                        Tampilkan Semua Jadwal
                    </button>
                </div>
            @elseif($tampilSemuaHari)
                @foreach ($hariMap as $num => $hari)
                    @if (isset($jadwalPerHari[$hari]) && count($jadwalPerHari[$hari]) > 0)
                        <div class="mb-4">
                            <h4 class="mb-3"
                                style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-calendar-day" style="color: var(--accent);"></i>
                                {{ $hari }}
                                <span class="badge-pill"
                                    style="background: var(--gray-100); color: var(--gray-700); margin-left: 8px;">
                                    {{ count($jadwalPerHari[$hari]) }} Jadwal
                                </span>
                            </h4>
                            <div class="schedule-list-grid">
                                @foreach ($jadwalPerHari[$hari] as $item)
                                    @php
                                        $isCurrent = false;
                                        if ($item['hari'] == $hariSekarangTeks && $jadwalBerlangsung) {
                                            if ($jadwalBerlangsung->id == $item['id']) {
                                                $isCurrent = true;
                                            }
                                        }
                                    @endphp
                                    <div class="schedule-list-card {{ $isCurrent ? 'active' : '' }}">
                                        <div class="schedule-time-box">
                                            <div class="time-start">
                                                {{ explode(' - ', $item['waktu'])[0] ?? $item['waktu'] }}</div>
                                            <div class="time-separator">—</div>
                                            <div class="time-end">{{ explode(' - ', $item['waktu'])[1] ?? '' }}</div>
                                        </div>
                                        <div class="schedule-content">
                                            <div class="schedule-course">{{ $item['mata_kuliah'] }}</div>
                                            <div class="schedule-meta">
                                                <div class="schedule-meta-item">
                                                    <i class="fas fa-user-tie"></i>
                                                    <span>{{ $item['dosen'] }}</span>
                                                </div>
                                                <div class="schedule-meta-item">
                                                    <i class="fas fa-door-open"></i>
                                                    <span>
                                                        @if (isset($ruanganMap[$item['ruang']]))
                                                            <a href="javascript:void(0)" class="room-link"
                                                                data-room="{{ $item['ruang'] }}"
                                                                onclick="showRoomPhoto('{{ $item['ruang'] }}')">
                                                                Ruang {{ $item['ruang'] }}
                                                            </a>
                                                        @else
                                                            Ruang {{ $item['ruang'] }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="schedule-meta-item">
                                                    <i class="fas fa-users"></i>
                                                    <span>Kelas {{ $item['kelas'] }}</span>
                                                </div>
                                            </div>
                                            <button class="btn-detail-modern"
                                                data-schedule='{{ json_encode($item) }}'>
                                                <i class="fas fa-info-circle"></i>
                                                Detail Jadwal
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="schedule-list-grid">
                    @foreach ($jadwal as $item)
                        @php
                            $isCurrent = false;
                            if ($item['hari'] == $hariSekarangTeks && $jadwalBerlangsung) {
                                if ($jadwalBerlangsung->id == $item['id']) {
                                    $isCurrent = true;
                                }
                            }
                        @endphp
                        <div class="schedule-list-card {{ $isCurrent ? 'active' : '' }}">
                            <div class="schedule-time-box">
                                <div class="time-start">{{ explode(' - ', $item['waktu'])[0] ?? $item['waktu'] }}
                                </div>
                                <div class="time-separator">—</div>
                                <div class="time-end">{{ explode(' - ', $item['waktu'])[1] ?? '' }}</div>
                            </div>
                            <div class="schedule-content">
                                <div class="schedule-course">{{ $item['mata_kuliah'] }}</div>
                                <div class="schedule-meta">
                                    <div class="schedule-meta-item">
                                        <i class="fas fa-user-tie"></i>
                                        <span>{{ $item['dosen'] }}</span>
                                    </div>
                                    <div class="schedule-meta-item">
                                        <i class="fas fa-door-open"></i>
                                        <span>
                                            @if (isset($ruanganMap[$item['ruang']]))
                                                <a href="javascript:void(0)" class="room-link"
                                                    data-room="{{ $item['ruang'] }}"
                                                    onclick="showRoomPhoto('{{ $item['ruang'] }}')">
                                                    Ruang {{ $item['ruang'] }}
                                                </a>
                                            @else
                                                Ruang {{ $item['ruang'] }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="schedule-meta-item">
                                        <i class="fas fa-users"></i>
                                        <span>Kelas {{ $item['kelas'] }}</span>
                                    </div>
                                </div>
                                <button class="btn-detail-modern" data-schedule='{{ json_encode($item) }}'>
                                    <i class="fas fa-info-circle"></i>
                                    Detail Jadwal
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>

    <!-- Footer -->
    <footer class="app-footer">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-section">
                    <h5>
                        <i class="fas fa-university"></i>
                        {{ $institusiNama }}
                    </h5>
                    <div class="footer-info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $institusiLokasi }}</span>
                    </div>
                    <div class="footer-info-item">
                        <i class="fas fa-graduation-cap"></i>
                        <span>{{ $programStudi }}</span>
                    </div>
                    <div class="footer-info-item">
                        <i class="fas fa-building"></i>
                        <span>{{ $fakultas }}</span>
                    </div>
                </div>
                <div class="footer-section">
                    <h5>
                        <i class="fas fa-info-circle"></i>
                        Informasi Sistem
                    </h5>
                    <div class="footer-info-item">
                        <i class="fas fa-calendar"></i>
                        <span>Tahun Akademik: {{ $tahunAkademik }}</span>
                    </div>
                    <div class="footer-info-item">
                        <i class="fas fa-book"></i>
                        <span>Semester: {{ $semesterAktif }}</span>
                    </div>
                    <div class="footer-info-item">
                        <i class="fas fa-clock"></i>
                        <span>Update Terakhir: {{ now()->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="footer-info-item">
                        <i class="fas fa-database"></i>
                        <span>Total Jadwal: {{ count($jadwal) }}</span>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <button class="btn-suggestion" data-bs-toggle="modal" data-bs-target="#suggestionModal">
                    <i class="fas fa-comment-dots"></i>
                    Beri Kritik & Saran
                </button>
                <p class="footer-copyright">
                    <span class="fw-semibold">© {{ date('Y') }} Sistem Informasi Jadwal Kuliah v2.0</span>
                </p>
                <p class="footer-version">
                    Sistem menampilkan {{ count($jadwal) }} jadwal untuk semester {{ $semesterAktif }}
                    {{ $tahunAkademik }}
                    @if ($tampilSemuaKelas)
                        - Mode: Semua Kelas
                    @else
                        - Mode: Kelas {{ $kelasSelected }}
                    @endif
                </p>
            </div>
        </div>
    </footer>

    <!-- Modal Foto Ruangan -->
    <div class="modal fade room-photo-modal" id="roomPhotoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-xl);">
                <div class="modal-header" style="background: var(--primary); color: white; border-bottom: none;">
                    <h5 class="modal-title">
                        <i class="fas fa-door-open me-2"></i> Foto Ruangan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 0; text-align: center;">
                    <div class="room-photo-container" id="roomPhotoContainer"
                        style="min-height: 300px; background: var(--gray-50); display: flex; align-items: center; justify-content: center;">
                        <div class="room-photo-placeholder" style="padding: 60px 20px; color: var(--gray-400);">
                            <i class="fas fa-image d-block" style="font-size: 4rem; margin-bottom: 16px;"></i>
                            <p class="mb-0">Memuat foto...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--gray-200);">
                    <button type="button" class="btn btn-outline-action" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Jadwal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content"
                style="border: none; border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-xl);">
                <div class="modal-header" style="background: var(--primary); color: white; border-bottom: none;">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle me-2"></i> Detail Jadwal
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" id="scheduleDetail">
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--gray-200);">
                    <button type="button" class="btn btn-outline-action" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Kritik & Saran -->
    <div class="modal fade" id="suggestionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="border: none; border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-xl);">
                <div class="modal-header" style="background: var(--primary); color: white; border-bottom: none;">
                    <h5 class="modal-title">
                        <i class="fas fa-comment-dots me-2"></i> Kritik & Saran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="suggestionForm" method="POST" action="{{ url('/submit-suggestion') }}">
                    @csrf
                    <div class="modal-body p-4">
                        <p class="text-muted mb-4">
                            Sampaikan kritik dan saran Anda untuk perbaikan sistem jadwal kuliah.
                            Semua masukan akan sangat berarti bagi kami.
                        </p>

                        <div class="mb-3">
                            <label for="suggestionName" class="form-label"
                                style="font-weight: 600; color: var(--gray-900);">
                                Nama <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="suggestionName" name="name"
                                placeholder="Masukkan nama Anda" required
                                style="border-radius: 8px; border: 1.5px solid var(--gray-300); padding: 10px 14px;">
                        </div>

                        <div class="mb-3">
                            <label for="suggestionEmail" class="form-label"
                                style="font-weight: 600; color: var(--gray-900);">
                                Email (opsional)
                            </label>
                            <input type="email" class="form-control" id="suggestionEmail" name="email"
                                placeholder="nama@email.com"
                                style="border-radius: 8px; border: 1.5px solid var(--gray-300); padding: 10px 14px;">
                            <small class="text-muted">Email hanya digunakan untuk follow up jika diperlukan</small>
                        </div>

                        <div class="mb-3">
                            <label for="suggestionMessage" class="form-label"
                                style="font-weight: 600; color: var(--gray-900);">
                                Kritik & Saran <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="suggestionMessage" name="message" rows="5"
                                placeholder="Tuliskan kritik dan saran Anda di sini..." required
                                style="border-radius: 8px; border: 1.5px solid var(--gray-300); padding: 10px 14px;"></textarea>
                            <small class="text-muted">Minimal 10 karakter</small>
                        </div>

                        <div class="info-box">
                            <div class="info-box-content">
                                <i class="fas fa-info-circle info-box-icon"></i>
                                <div class="info-box-text">
                                    <small class="text-muted">
                                        Kritik dan saran Anda akan langsung masuk ke sistem dan dapat dilihat oleh
                                        admin.
                                        Tidak perlu login untuk mengirimkan kritik dan saran.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid var(--gray-200);">
                        <button type="button" class="btn btn-outline-action" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary-action" id="submitSuggestionBtn">
                            <i class="fas fa-paper-plane me-2"></i> Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Room data from controller
        const ruanganMap = @json($ruanganMap);

        // JavaScript variables untuk default values
        const currentDay = {{ now()->dayOfWeekIso }};
        const firstClass = @json(!empty($kelasList) ? $kelasList[0] : 'A1');
        let waktuTungguDetik = {{ $waktuTungguDetik }};
        let countdownInterval = null;

        function toggleSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (sidebar && overlay) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
            }
        }

        function applyFilter(button) {
            const type = button.dataset.type;
            const value = button.dataset.value;
            const params = new URLSearchParams(window.location.search);

            // Update active state
            const container = button.parentElement;
            container.querySelectorAll('.filter-pill').forEach(pill => pill.classList.remove('active'));
            button.classList.add('active');

            if (type === 'hari') {
                params.delete('semua_hari');
                params.set('hari', value);
                params.delete('kelas');
                params.delete('semua_kelas');
            } else if (type === 'semua_hari') {
                params.set('semua_hari', '1');
                params.delete('hari');
            } else if (type === 'kelas') {
                params.delete('semua_kelas');
                params.set('kelas', value);
            } else if (type === 'semua_kelas') {
                params.set('semua_kelas', '1');
                params.delete('kelas');
            }

            window.location.href = '?' + params.toString();
        }

        function handleShowAllSchedule() {
            window.location.href = '?semua_hari=1&semua_kelas=1';
        }

        function handleResetFilter() {
            const hariSekarang = currentDay > 5 ? 1 : currentDay;
            const kelasPertama = firstClass;
            window.location.href = '?hari=' + hariSekarang + '&kelas=' + encodeURIComponent(kelasPertama);
        }

        function toggleCurrentSchedule() {
            const section = document.getElementById('currentNextSection');
            const toggleIcon = document.getElementById('toggleIcon');
            if (section && toggleIcon) {
                section.classList.toggle('collapsed-section');
                if (section.classList.contains('collapsed-section')) {
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                    try {
                        localStorage.setItem('scheduleVisible', 'false');
                    } catch (e) {}
                } else {
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                    try {
                        localStorage.setItem('scheduleVisible', 'true');
                    } catch (e) {}
                }
            }
        }

        function refreshCurrentSchedule(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            window.location.reload();
        }

        // Show room photo popup
        function showRoomPhoto(roomName) {
            const modal = document.getElementById('roomPhotoModal');
            const photoContainer = document.getElementById('roomPhotoContainer');

            if (ruanganMap && ruanganMap[roomName]) {
                const photoPath = ruanganMap[roomName];
                const img = document.createElement('img');
                img.src = "{{ asset('') }}" + photoPath;
                img.alt = "Foto Ruangan " + roomName;
                img.className = "img-fluid";
                img.style.maxHeight = "500px";
                img.style.objectFit = "contain";
                img.onerror = function() {
                    photoContainer.innerHTML = `
                        <div class="room-photo-placeholder">
                            <i class="fas fa-image d-block" style="font-size: 4rem; margin-bottom: 16px; color: var(--gray-400);"></i>
                            <p class="mb-0">Foto tidak tersedia</p>
                        </div>
                    `;
                };
                photoContainer.innerHTML = '';
                photoContainer.appendChild(img);
            } else {
                photoContainer.innerHTML = `
                    <div class="room-photo-placeholder">
                        <i class="fas fa-image d-block" style="font-size: 4rem; margin-bottom: 16px; color: var(--gray-400);"></i>
                        <p class="mb-0">Foto tidak tersedia</p>
                    </div>
                `;
            }

            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        }

        // Detail modal
        function showScheduleDetail(data) {
            const modal = document.getElementById('scheduleModal');
            const detail = document.getElementById('scheduleDetail');
            const bootstrapModal = new bootstrap.Modal(modal);
            detail.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-3" style="color: var(--gray-900); font-weight: 800; font-size: 1.5rem;">${data.mata_kuliah}</h4>
                        <table class="table table-borderless">
                            <tr>
                                <td style="width: 140px;"><i class="fas fa-clock me-2" style="color: var(--accent);"></i>Waktu</td>
                                <td><strong>${data.waktu}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-list-ol me-2" style="color: var(--accent);"></i>Jam ke-</td>
                                <td><strong>${data.jam_ke}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-user-tie me-2" style="color: var(--accent);"></i>Dosen</td>
                                <td><strong>${data.dosen}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-door-open me-2" style="color: var(--accent);"></i>Ruang</td>
                                <td><strong>${data.ruang}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-users me-2" style="color: var(--accent);"></i>Kelas</td>
                                <td><strong>${data.kelas}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calendar-day me-2" style="color: var(--accent);"></i>Hari</td>
                                <td><strong>${data.hari}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calendar-alt me-2" style="color: var(--accent);"></i>Semester</td>
                                <td><strong>${data.semester} ${data.tahun_akademik}</strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="card" style="background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: 12px;">
                            <div class="card-body text-center py-5">
                                <div class="display-1 fw-bold mb-3" style="color: var(--accent); font-size: 4rem; font-weight: 900;">${data.jam_ke}</div>
                                <h6 class="text-muted">Jam ke-${data.jam_ke}</h6>
                                <span class="badge-pill success-pill mt-2" style="font-size: 0.875rem;">
                                    <i class="fas fa-clock"></i> ${data.waktu}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            bootstrapModal.show();
        }

        // Initialize on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            // Detail buttons
            document.querySelectorAll('.btn-detail-modern').forEach(btn => {
                btn.addEventListener('click', function() {
                    try {
                        const data = JSON.parse(this.dataset.schedule);
                        showScheduleDetail(data);
                    } catch (e) {
                        console.error('Error parsing schedule data', e);
                    }
                });
            });

            // Tooltip init
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Schedule visibility
            const scheduleVisible = localStorage.getItem('scheduleVisible');
            if (scheduleVisible === 'false') {
                const section = document.getElementById('currentNextSection');
                const toggleIcon = document.getElementById('toggleIcon');
                if (section && toggleIcon) {
                    section.classList.add('collapsed-section');
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            }

            // Countdown timer
            if (waktuTungguDetik > 0) {
                startCountdownTimer();
            }

            // Update current time badge every minute
            setInterval(() => {
                const now = new Date();
                const currentTime = now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });
            }, 60000);

            // Suggestion form handler
            $('#suggestionForm').on('submit', function(e) {
                e.preventDefault();
                const submitBtn = $('#submitSuggestionBtn');
                const name = $('#suggestionName').val().trim();
                const message = $('#suggestionMessage').val().trim();

                if (name.length < 2) {
                    alert('Nama minimal 2 karakter');
                    $('#suggestionName').focus();
                    return;
                }
                if (message.length < 10) {
                    alert('Pesan minimal 10 karakter');
                    $('#suggestionMessage').focus();
                    return;
                }

                submitBtn.prop('disabled', true);
                submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i> Mengirim...');

                const form = $(this);
                const csrfToken = form.find('input[name="_token"]').val();

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('#suggestionModal').modal('hide');
                            $('#suggestionForm')[0].reset();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        let errMsg = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
                        try {
                            const resp = JSON.parse(xhr.responseText);
                            if (resp.message) errMsg = resp.message;
                        } catch (e) {}
                        alert(errMsg);
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false);
                        submitBtn.html('<i class="fas fa-paper-plane me-2"></i> Kirim');
                    }
                });
            });

            // Suggestion message validation
            $('#suggestionMessage').on('input', function() {
                const message = $(this).val();
                const minLength = 10;
                if (message.length < minLength && message.length > 0) {
                    $(this).addClass('is-invalid').removeClass('is-valid');
                } else if (message.length >= minLength) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $(this).removeClass('is-invalid is-valid');
                }
            });

            $('#suggestionModal').on('hidden.bs.modal', function() {
                $('#suggestionForm')[0].reset();
                $('#suggestionMessage').removeClass('is-invalid is-valid');
            });
        });

        window.startCountdownTimer = function() {
            if (!waktuTungguDetik || waktuTungguDetik <= 0) return;
            let remainingSeconds = waktuTungguDetik;

            function updateCountdown() {
                if (remainingSeconds <= 0) {
                    window.location.reload();
                    return;
                }
                const days = Math.floor(remainingSeconds / (24 * 3600));
                const hours = Math.floor((remainingSeconds % (24 * 3600)) / 3600);
                const minutes = Math.floor((remainingSeconds % 3600) / 60);
                const seconds = remainingSeconds % 60;

                const daysEl = document.getElementById('countdownDays');
                const hoursEl = document.getElementById('countdownHours');
                const minutesEl = document.getElementById('countdownMinutes');
                const secondsEl = document.getElementById('countdownSeconds');

                if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
                if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
                if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
                if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
                remainingSeconds--;
            }

            updateCountdown();
            countdownInterval = setInterval(updateCountdown, 1000);
        };

        window.addEventListener('beforeunload', function() {
            if (countdownInterval) clearInterval(countdownInterval);
        });
    </script>
</body>

</html>
