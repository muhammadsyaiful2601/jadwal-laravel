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
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        /* =============================================
               NEOBRUTALISM STYLES - Landing Page Only
               ============================================= */
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
            -webkit-font-smoothing: antialiased;
        }

        body.maintenance-active {
            overflow: hidden;
        }

        .maintenance-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .maintenance-content {
            background: var(--nb-yellow);
            border: var(--nb-border-thick);
            border-radius: var(--nb-radius);
            padding: 48px;
            text-align: center;
            max-width: 480px;
            width: 100%;
            box-shadow: var(--nb-shadow-lg);
            animation: slideUp 0.5s ease;
        }

        .maintenance-icon {
            font-size: 4rem;
            color: var(--nb-black);
            margin-bottom: 24px;
            animation: spin 3s linear infinite;
        }

        .maintenance-content h2 {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 16px;
        }

        .maintenance-message {
            margin-bottom: 24px;
            line-height: 1.6;
            font-weight: 500;
        }

        .maintenance-info {
            background: var(--nb-black);
            color: var(--nb-white);
            padding: 12px 24px;
            border-radius: var(--nb-radius-sm);
            display: inline-block;
            font-size: 0.875rem;
            border: 2px solid var(--nb-black);
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

        /* Header - Neobrutalism App Header */
        .app-header {
            background: var(--nb-white);
            border-bottom: var(--nb-border-thick);
            padding: 24px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--nb-shadow);
            background-image:
                radial-gradient(circle at 20% 50%, rgba(166, 108, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(78, 205, 196, 0.08) 0%, transparent 50%),
                repeating-linear-gradient(90deg, transparent, transparent 100px, rgba(0, 0, 0, 0.01) 100px, rgba(0, 0, 0, 0.01) 101px);
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
            height: 64px;
            width: auto;
            object-fit: contain;
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 6px;
            background: var(--nb-white);
            box-shadow: var(--nb-shadow-sm);
            transition: all 0.2s ease;
        }

        .logo-img:hover {
            transform: translateY(-2px) rotate(-2deg);
            box-shadow: var(--nb-shadow);
        }

        .institution-info h1 {
            font-family: var(--font-display);
            font-size: 1.75rem;
            font-weight: 900;
            color: var(--nb-black);
            margin: 0;
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: -0.03em;
            text-shadow: 2px 2px 0 var(--nb-yellow);
        }

        .institution-info h2 {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--nb-dark);
            margin: 4px 0 0 0;
        }

        .institution-info .institution-sub {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--nb-black);
            margin: 8px 0 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .institution-info .institution-sub span {
            background: var(--nb-yellow);
            padding: 4px 12px;
            border: 2px solid var(--nb-black);
            border-radius: var(--nb-radius-sm);
            box-shadow: var(--nb-shadow-sm);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .institution-info .institution-sub span::before {
            content: '●';
            color: var(--nb-purple);
            font-size: 0.625rem;
        }

        .institution-info .institution-divider {
            color: var(--nb-black);
            font-weight: 400;
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        /* Decorative corner accent */
        .header-container::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 120px;
            height: 120px;
            background: var(--nb-yellow);
            border-radius: 50%;
            opacity: 0.15;
            z-index: -1;
        }

        .header-container::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 100px;
            height: 100px;
            background: var(--nb-teal);
            border-radius: 50%;
            opacity: 0.15;
            z-index: -1;
        }

        .btn-reset {
            padding: 10px 20px;
            border: var(--nb-border);
            background: var(--nb-white);
            color: var(--nb-black);
            border-radius: var(--nb-radius-sm);
            font-weight: 700;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: var(--nb-shadow-sm);
        }

        .btn-reset:hover {
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-reset:active {
            transform: translate(2px, 2px);
            box-shadow: none;
        }

        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        /* Filter Section - Neobrutalism Control Panel */
        .filter-section {
            background: var(--nb-yellow);
            border: var(--nb-border-thick);
            border-radius: var(--nb-radius);
            padding: 28px;
            margin-bottom: 32px;
            box-shadow: var(--nb-shadow);
            position: relative;
            overflow: hidden;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(166, 108, 255, 0.12) 0%, transparent 30%),
                radial-gradient(circle at 90% 80%, rgba(78, 205, 196, 0.12) 0%, transparent 30%);
        }

        .filter-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 200px;
            height: 200px;
            background: var(--nb-purple);
            border-radius: 50%;
            opacity: 0.1;
            transform: rotate(45deg);
        }

        .filter-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 150px;
            height: 150px;
            background: var(--nb-teal);
            border-radius: 50%;
            opacity: 0.1;
            transform: rotate(-30deg);
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 3px dashed var(--nb-black);
        }

        .filter-title {
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 900;
            color: var(--nb-black);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.02em;
        }

        .filter-title i {
            transform: rotate(-5deg);
        }

        .filter-title i {
            font-size: 1.25rem;
        }

        .filter-meta {
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 4px;
        }

        .filter-meta strong {
            background: var(--nb-black);
            color: var(--nb-white);
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 700;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
        }

        .btn-filter-action {
            padding: 10px 18px;
            border-radius: var(--nb-radius-sm);
            font-weight: 700;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.15s ease;
            border: var(--nb-border);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: var(--nb-shadow-sm);
            font-family: var(--font-display);
            position: relative;
            overflow: hidden;
        }

        .btn-filter-action::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.4s ease, height 0.4s ease;
        }

        .btn-filter-action:hover::before {
            width: 200px;
            height: 200px;
        }

        .btn-primary-action {
            background: var(--nb-teal);
            color: var(--nb-black);
        }

        .btn-primary-action:hover {
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-primary-action:active {
            transform: translate(2px, 2px);
            box-shadow: none;
        }

        .btn-outline-action {
            background: var(--nb-white);
            color: var(--nb-black);
        }

        .btn-outline-action:hover {
            background: var(--nb-gray);
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-outline-action:active {
            transform: translate(2px, 2px);
            box-shadow: none;
        }

        .filter-group {
            margin-bottom: 20px;
        }

        .filter-group:last-child {
            margin-bottom: 0;
        }

        .filter-label {
            font-family: var(--font-display);
            font-size: 0.9375rem;
            font-weight: 700;
            color: var(--nb-black);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-label i {
            font-size: 1rem;
        }

        .filter-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filter-pill {
            padding: 10px 18px;
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            background: var(--nb-white);
            color: var(--nb-black);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: var(--nb-shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .filter-pill::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--nb-purple);
            transform: scaleX(0);
            transition: transform 0.3s ease;
            transform-origin: left;
        }

        .filter-pill:hover::before,
        .filter-pill.active::before {
            transform: scaleX(1);
        }

        .filter-pill:hover {
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .filter-pill:active {
            transform: translate(2px, 2px);
            box-shadow: none;
        }

        .filter-pill.active {
            background: var(--nb-black);
            color: var(--nb-white);
            box-shadow: var(--nb-shadow);
            transform: translate(-2px, -2px);
        }

        .filter-pill.active::before {
            background: var(--nb-yellow);
            transform: scaleX(1);
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
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 900;
            color: var(--nb-black);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.02em;
        }

        .section-title i {
            animation: rotateIcon 3s ease-in-out infinite;
        }

        @keyframes rotateIcon {

            0%,
            100% {
                transform: rotate(0deg);
            }

            50% {
                transform: rotate(10deg);
            }
        }

        .section-title i {
            font-size: 1.5rem;
        }

        .section-subtitle {
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 4px;
            color: var(--nb-dark);
        }

        .section-actions {
            display: flex;
            gap: 10px;
        }

        .btn-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            background: var(--nb-white);
            color: var(--nb-black);
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--nb-shadow-sm);
            position: relative;
        }

        .btn-icon::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--nb-yellow);
            border-radius: var(--nb-radius-sm);
            opacity: 0;
            transition: opacity 0.15s ease;
        }

        .btn-icon:hover {
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .btn-icon:hover::before {
            opacity: 0.3;
        }

        .btn-icon:active {
            transform: translate(2px, 2px);
            box-shadow: none;
        }

        .btn-icon i {
            position: relative;
            z-index: 1;
        }

        .current-next-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            position: relative;
        }

        /* Decorative connector line between cards */
        .current-next-grid::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 2px;
            height: 60%;
            background: repeating-linear-gradient(to bottom,
                    var(--nb-black) 0,
                    var(--nb-black) 8px,
                    transparent 8px,
                    transparent 16px);
            opacity: 0.3;
            z-index: 0;
        }

        /* =============================================
               3D CARD - Neobrutalism Schedule Card
               ============================================= */
        .schedule-card {
            background: var(--nb-dark);
            border: var(--nb-border-thick);
            border-radius: var(--nb-radius);
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--nb-shadow);
            transform-style: preserve-3d;
            perspective: 1000px;
            overflow: hidden;
        }

        .schedule-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--nb-purple) 0%, var(--nb-pink) 50%, var(--nb-purple) 100%);
            opacity: 0.8;
            transition: box-shadow 0.3s ease;
        }

        .schedule-card:hover::after {
            box-shadow: 0 0 20px rgba(166, 108, 255, 0.6);
        }

        .schedule-card:hover {
            transform: perspective(1000px) rotateX(2deg) rotateY(-2deg) translateY(-6px);
            box-shadow: var(--nb-shadow-hover);
        }

        .schedule-card:hover .schedule-time-badge .time-number {
            animation: bounce 0.5s ease;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* 3D depth layers */
        .schedule-card::before {
            content: '';
            position: absolute;
            top: 4px;
            left: 4px;
            right: -4px;
            bottom: -4px;
            background: var(--nb-black);
            border-radius: var(--nb-radius);
            z-index: -1;
            transition: all 0.3s ease;
        }

        .schedule-card:hover::before {
            top: 8px;
            left: 8px;
            right: -8px;
            bottom: -8px;
        }

        /* Accent left border */
        .schedule-card.accent-left::after {
            content: '';
            position: absolute;
            left: -4px;
            top: 16px;
            bottom: 16px;
            width: 12px;
            background: var(--nb-purple);
            border: 2px solid var(--nb-black);
            border-radius: 4px;
            z-index: 2;
            box-shadow: 2px 2px 0 var(--nb-black);
            animation: pulseAccent 2s ease-in-out infinite;
        }

        @keyframes pulseAccent {

            0%,
            100% {
                box-shadow: 2px 2px 0 var(--nb-black);
            }

            50% {
                box-shadow: 2px 2px 0 var(--nb-black), 0 0 0 3px rgba(166, 108, 255, 0.3);
            }
        }

        .schedule-card.accent-green::after {
            content: '';
            position: absolute;
            left: -4px;
            top: 16px;
            bottom: 16px;
            width: 12px;
            background: var(--nb-green);
            border: 2px solid var(--nb-black);
            border-radius: 4px;
            z-index: 2;
        }

        .schedule-card-header {
            padding: 24px;
            border-bottom: var(--nb-border);
            position: relative;
            overflow: hidden;
        }

        .schedule-card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
        }

        .schedule-card-header.success-bg::before {
            background: rgba(0, 0, 0, 0.1);
        }

        .schedule-card-header.primary-bg {
            background: var(--nb-purple);
            color: var(--nb-white);
        }

        .schedule-card-header.success-bg {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .schedule-card-title {
            font-family: var(--font-display);
            font-size: 1.125rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 1;
        }

        .schedule-card-body {
            padding: 24px;
            position: relative;
            z-index: 1;
        }

        .schedule-card-body.flex-center {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 280px;
            background: var(--nb-dark);
            border-radius: 0 0 var(--nb-radius) var(--nb-radius);
        }

        /* Decorative pattern overlay on empty states */
        .schedule-card-body.flex-center::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255, 255, 255, 0.03) 10px, rgba(255, 255, 255, 0.03) 20px),
                repeating-linear-gradient(-45deg, transparent, transparent 10px, rgba(255, 255, 255, 0.03) 10px, rgba(255, 255, 255, 0.03) 20px);
            pointer-events: none;
            z-index: 0;
        }

        .empty-state-icon,
        .empty-state-title,
        .empty-state-text {
            position: relative;
            z-index: 1;
        }

        .empty-state-icon {
            width: 90px;
            height: 90px;
            background: var(--nb-yellow);
            border: var(--nb-border);
            border-radius: var(--nb-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: var(--nb-shadow-sm);
            animation: float 3s ease-in-out infinite;
            position: relative;
            background-image:
                repeating-linear-gradient(45deg, transparent, transparent 5px, rgba(0, 0, 0, 0.05) 5px, rgba(0, 0, 0, 0.05) 10px);
        }

        .empty-state-icon::after {
            content: '';
            position: absolute;
            inset: -8px;
            border: 3px dashed var(--nb-purple);
            border-radius: var(--nb-radius);
            opacity: 0.4;
            animation: spin 15s linear infinite reverse;
        }

        .empty-state-icon::before {
            content: '';
            position: absolute;
            inset: -4px;
            border: 3px dashed var(--nb-purple);
            border-radius: var(--nb-radius);
            opacity: 0.5;
            animation: spin 20s linear infinite;
        }

        .empty-state-icon i {
            font-size: 2.5rem;
            color: var(--nb-black);
            animation: pulseIcon 2s ease-in-out infinite;
        }

        @keyframes pulseIcon {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .empty-state-title {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 900;
            margin-bottom: 8px;
            color: var(--nb-white);
            text-shadow: 2px 2px 0 var(--nb-black);
        }

        .empty-state-text {
            font-size: 0.875rem;
            font-weight: 500;
            text-align: center;
            max-width: 280px;
            color: var(--nb-white);
            line-height: 1.5;
        }

        .current-schedule-content {
            display: flex;
            gap: 24px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .schedule-time-badge {
            text-align: center;
            min-width: 100px;
        }

        .schedule-time-badge .time-number {
            font-family: var(--font-display);
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1;
            color: var(--nb-yellow);
            letter-spacing: -0.03em;
            text-shadow: 3px 3px 0 var(--nb-black);
        }

        .schedule-time-badge .time-label {
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 8px;
            background: var(--nb-yellow);
            color: var(--nb-black);
            padding: 4px 12px;
            border-radius: 4px;
            display: inline-block;
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
            transition: all 0.2s ease;
        }

        .schedule-card:hover .schedule-time-badge .time-label {
            transform: translateY(-2px);
            box-shadow: var(--nb-shadow);
        }

        .schedule-details {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .schedule-course-name {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--nb-yellow);
            margin-bottom: 16px;
            line-height: 1.3;
            text-shadow: 2px 2px 0 var(--nb-black);
            position: relative;
            display: inline-block;
        }

        .schedule-course-name::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--nb-purple);
            border-radius: 2px;
        }

        .schedule-info-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--nb-white);
        }

        .schedule-info-row span {
            color: var(--nb-white);
        }

        .schedule-info-row i {
            width: 18px;
            font-size: 0.9375rem;
            background: var(--nb-yellow);
            padding: 4px;
            border: 2px solid var(--nb-black);
            border-radius: 4px;
            text-align: center;
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
            transition: all 0.2s ease;
            position: relative;
        }

        .schedule-card:hover .schedule-info-row i {
            box-shadow: var(--nb-shadow);
            transform: translateY(-1px);
        }

        .schedule-info-row strong {
            font-weight: 700;
            color: var(--nb-yellow);
        }

        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: var(--nb-radius-sm);
            font-size: 0.8125rem;
            font-weight: 700;
            margin-top: 12px;
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .badge-pill::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .badge-pill:hover::before {
            left: 100%;
        }

        .badge-pill.success-pill {
            background: var(--nb-green);
            color: var(--nb-black);
        }

        .badge-pill.warning-pill {
            background: var(--nb-orange);
            color: var(--nb-black);
        }

        .badge-pill i {
            font-size: 0.75rem;
        }

        .countdown-box {
            background: var(--nb-yellow);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 16px;
            margin-top: 16px;
            box-shadow: var(--nb-shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .countdown-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--nb-purple), var(--nb-pink), var(--nb-purple));
            animation: gradientShift 2s ease infinite;
        }

        .countdown-label {
            font-size: 0.8125rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 12px;
        }

        .countdown-timer {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .countdown-unit {
            background: var(--nb-white);
            padding: 10px 14px;
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            text-align: center;
            min-width: 60px;
            box-shadow: var(--nb-shadow-sm);
            position: relative;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .countdown-unit:hover {
            transform: translateY(-2px);
            box-shadow: var(--nb-shadow);
        }

        .countdown-unit::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--nb-purple);
        }

        .countdown-unit .countdown-value {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--nb-black);
            line-height: 1;
        }

        .countdown-unit .countdown-text {
            font-size: 0.6875rem;
            font-weight: 600;
            margin-top: 4px;
        }

        /* =============================================
               3D Detail Button
               ============================================= */
        .btn-detail-modern {
            padding: 10px 20px;
            border: var(--nb-border);
            background: var(--nb-white);
            color: var(--nb-black);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
            box-shadow: var(--nb-shadow-sm);
        }

        .btn-detail-modern:hover {
            background: var(--nb-black);
            color: var(--nb-white);
            transform: translate(-3px, -3px);
            box-shadow: var(--nb-shadow);
        }

        .btn-detail-modern:active {
            transform: translate(3px, 3px);
            box-shadow: none;
        }

        /* Info Box */
        .info-box {
            background: var(--nb-teal);
            border: var(--nb-border-thick);
            border-radius: var(--nb-radius);
            padding: 16px 20px;
            margin-top: 24px;
            box-shadow: var(--nb-shadow-sm);
            position: relative;
            overflow: hidden;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(255, 230, 109, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(166, 108, 255, 0.15) 0%, transparent 50%);
        }

        .info-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--nb-yellow) 0%, var(--nb-purple) 100%);
        }

        .info-box-content {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .info-box-icon {
            font-size: 1.25rem;
            margin-top: 2px;
        }

        .info-box-text {
            flex: 1;
        }

        .info-box-title {
            font-family: var(--font-display);
            font-size: 0.875rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--nb-black);
            text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.3);
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
            font-weight: 500;
            padding: 6px 10px;
            background: var(--nb-white);
            border-radius: var(--nb-radius-sm);
            border: 2px solid var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
            transition: all 0.2s ease;
        }

        .info-tag:hover {
            transform: translateY(-2px);
            box-shadow: var(--nb-shadow);
        }

        .info-tag i {
            font-size: 0.875rem;
            background: var(--nb-white);
            padding: 3px;
            border: 2px solid var(--nb-black);
            border-radius: 4px;
            text-align: center;
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .info-tag strong {
            font-weight: 700;
            background: var(--nb-black);
            color: var(--nb-white);
            padding: 1px 6px;
            border-radius: 3px;
        }

        /* Schedule List Section */
        .schedule-list-section {
            margin-bottom: 40px;
            position: relative;
        }

        /* Decorative background elements */
        .schedule-list-section::before {
            content: '';
            position: absolute;
            top: 20px;
            left: -50px;
            width: 100px;
            height: 100px;
            background: var(--nb-yellow);
            border-radius: 50%;
            opacity: 0.3;
            transform: rotate(45deg);
            z-index: 0;
            animation: float 6s ease-in-out infinite;
        }

        .schedule-list-section::after {
            content: '';
            position: absolute;
            bottom: 40px;
            right: -30px;
            width: 80px;
            height: 80px;
            background: var(--nb-teal);
            border-radius: 50%;
            opacity: 0.2;
            transform: rotate(-30deg);
            z-index: 0;
            animation: float 8s ease-in-out infinite reverse;
        }

        .schedule-list-section>* {
            position: relative;
            z-index: 1;
        }

        .schedule-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding: 16px 20px;
            background: var(--nb-white);
            border-radius: var(--nb-radius);
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
        }

        .schedule-count-badge {
            background: var(--nb-purple);
            color: var(--nb-white);
            padding: 10px 18px;
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-size: 0.875rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: var(--nb-border);
            box-shadow: var(--nb-shadow-sm);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .schedule-list-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 24px;
            position: relative;
            z-index: 1;
        }

        /* =============================================
               3D CARD - Schedule List Card
               ============================================= */
        .schedule-list-card {
            background: var(--nb-dark);
            border: var(--nb-border-thick);
            border-radius: var(--nb-radius);
            padding: 20px;
            display: flex;
            gap: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            box-shadow: var(--nb-shadow);
            transform-style: preserve-3d;
            perspective: 1000px;
            overflow: hidden;
        }

        .schedule-list-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--nb-purple), var(--nb-pink), var(--nb-purple));
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
            z-index: 1;
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .schedule-list-card::after {
            content: '';
            position: absolute;
            top: 4px;
            left: 4px;
            right: -4px;
            bottom: -4px;
            background: var(--nb-black);
            border-radius: var(--nb-radius);
            z-index: -1;
            transition: all 0.3s ease;
        }

        .schedule-list-card:hover {
            transform: perspective(1000px) rotateX(3deg) rotateY(-3deg) translateY(-6px) scale(1.02);
            box-shadow: var(--nb-shadow-hover);
        }

        .schedule-list-card:hover::after {
            top: 8px;
            left: 8px;
            right: -8px;
            bottom: -8px;
        }

        .schedule-list-card:hover .schedule-time-box {
            transform: translateY(-2px);
            box-shadow: var(--nb-shadow);
        }

        .schedule-list-card:hover .schedule-course {
            text-shadow: 2px 2px 0 var(--nb-black);
        }

        .schedule-list-card.active {
            background: var(--nb-green);
        }

        .schedule-list-card.active::before {
            background: linear-gradient(90deg, var(--nb-black), var(--nb-dark), var(--nb-black));
            background-size: 200% 100%;
        }

        .schedule-list-card.active::after {
            background: var(--nb-black);
        }

        .schedule-list-card.active .schedule-time-box {
            transform: translateY(-4px) scale(1.05);
            box-shadow: var(--nb-shadow);
        }

        .schedule-time-box {
            background: var(--nb-yellow);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 12px 16px;
            text-align: center;
            min-width: 90px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: var(--nb-shadow-sm);
            position: relative;
            overflow: hidden;
            z-index: 2;
        }

        .schedule-time-box::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--nb-purple), var(--nb-pink));
            opacity: 0.6;
        }

        .schedule-time-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--nb-black) 0%, var(--nb-dark) 100%);
        }

        .schedule-time-box .time-start {
            font-family: var(--font-display);
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--nb-black);
            transition: all 0.2s ease;
        }

        .schedule-time-box .time-separator {
            font-size: 0.75rem;
            font-weight: 700;
            margin: 4px 0;
            color: var(--nb-black);
        }

        .schedule-time-box .time-end {
            font-family: var(--font-display);
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--nb-black);
            transition: all 0.2s ease;
        }

        .schedule-list-card:hover .schedule-time-box .time-start,
        .schedule-list-card:hover .schedule-time-box .time-end {
            transform: scale(1.05);
        }

        .schedule-content {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .schedule-course {
            font-family: var(--font-display);
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--nb-yellow);
            margin-bottom: 10px;
            line-height: 1.3;
            text-shadow: 1px 1px 0 var(--nb-black);
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
            font-weight: 500;
            color: var(--nb-white);
        }

        .schedule-meta-item i {
            width: 16px;
            font-size: 0.875rem;
            color: var(--nb-black);
            background: var(--nb-yellow);
            padding: 3px;
            border: 2px solid var(--nb-black);
            border-radius: 4px;
            text-align: center;
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--nb-shadow-sm);
            transition: all 0.2s ease;
        }

        .schedule-list-card:hover .schedule-meta-item i {
            transform: rotate(-5deg) scale(1.1);
        }

        .schedule-meta-item a {
            font-weight: 700;
            color: var(--nb-white);
            text-decoration: underline;
            text-decoration-thickness: 2px;
            text-underline-offset: 2px;
            transition: all 0.15s ease;
            padding: 2px 6px;
            border-radius: 4px;
            margin: -2px -6px;
        }

        .schedule-meta-item a:hover {
            background: var(--nb-yellow);
            color: var(--nb-black);
            transform: translateY(-1px);
        }

        .schedule-meta-item span {
            color: var(--nb-white);
            font-weight: 600;
        }

        /* Footer */
        .app-footer {
            background: var(--nb-black);
            color: var(--nb-white);
            padding: 48px 0 24px;
            margin-top: 64px;
            border-top: var(--nb-border-thick);
            position: relative;
            overflow: hidden;
        }

        .app-footer::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(78, 205, 196, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(166, 108, 255, 0.08) 0%, transparent 40%);
            pointer-events: none;
        }

        .app-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--nb-yellow) 0%, var(--nb-purple) 25%, var(--nb-pink) 50%, var(--nb-purple) 75%, var(--nb-yellow) 100%);
            background-size: 200% 100%;
            animation: gradientShift 4s ease infinite;
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
            font-family: var(--font-display);
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--nb-yellow);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-section h5 i {
            font-size: 1.125rem;
        }

        .footer-info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 0.9375rem;
            font-weight: 500;
            color: var(--nb-gray);
            transition: all 0.2s ease;
            padding: 6px 10px;
            border-radius: var(--nb-radius-sm);
            margin-left: -10px;
        }

        .footer-info-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--nb-white);
            transform: translateX(5px);
        }

        .footer-info-item i {
            width: 18px;
            font-size: 0.9375rem;
            color: var(--nb-yellow);
            transition: transform 0.2s ease;
        }

        .footer-info-item:hover i {
            transform: scale(1.2);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 24px;
            border-top: 2px dashed var(--nb-dark);
            position: relative;
        }

        /* Decorative dots on footer */
        .footer-bottom::before {
            content: '';
            position: absolute;
            top: -6px;
            left: 50%;
            transform: translateX(-50%);
            width: 12px;
            height: 12px;
            background: var(--nb-yellow);
            border: 2px solid var(--nb-black);
            border-radius: 50%;
            box-shadow: var(--nb-shadow-sm);
        }

        .btn-suggestion {
            padding: 14px 28px;
            background: var(--nb-yellow);
            color: var(--nb-black);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            box-shadow: var(--nb-shadow-sm);
            position: relative;
        }

        .btn-suggestion::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(255, 255, 255, 0.3) 50%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-suggestion:hover {
            transform: translate(-3px, -3px);
            box-shadow: var(--nb-shadow);
        }

        .btn-suggestion:hover::before {
            opacity: 1;
        }

        .btn-suggestion:active {
            transform: translate(3px, 3px);
            box-shadow: none;
        }

        .footer-copyright {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 4px;
            color: var(--nb-white);
            text-shadow: 1px 1px 0 var(--nb-black);
        }

        .footer-version {
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--nb-gray);
        }

        /* Mobile Sidebar */
        .sidebar-filter {
            position: fixed;
            top: 0;
            left: -320px;
            width: 320px;
            height: 100vh;
            background: var(--nb-white);
            z-index: 1050;
            transition: left 0.3s ease;
            box-shadow: var(--nb-shadow-lg);
            overflow-y: auto;
            border-right: var(--nb-border-thick);
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
            background: rgba(0, 0, 0, 0.6);
            z-index: 1049;
            display: none;
        }

        .overlay.show {
            display: block;
        }

        .sidebar-header {
            background: var(--nb-black);
            color: var(--nb-white);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: var(--nb-border);
        }

        .sidebar-header h5 {
            font-family: var(--font-display);
            margin: 0;
            font-weight: 700;
        }

        .btn-close-white {
            filter: brightness(0) invert(1);
        }

        .sidebar-body {
            padding: 20px;
        }

        .sidebar-body h6 {
            font-family: var(--font-display);
            font-weight: 700;
        }

        .sidebar-footer {
            position: sticky;
            bottom: 0;
            background: var(--nb-white);
            padding: 16px 20px;
            border-top: var(--nb-border);
        }

        .filter-toggle-btn {
            background: var(--nb-black) !important;
            color: var(--nb-white) !important;
            border: var(--nb-border) !important;
            padding: 12px 20px !important;
            border-radius: var(--nb-radius-sm) !important;
            font-family: var(--font-display) !important;
            font-weight: 700 !important;
            box-shadow: var(--nb-shadow-sm) !important;
        }

        .filter-toggle-btn:hover {
            transform: translate(-2px, -2px) !important;
            box-shadow: var(--nb-shadow) !important;
        }

        .filter-toggle-btn:active {
            transform: translate(2px, 2px) !important;
            box-shadow: none !important;
        }

        /* =============================================
               3D Detail Button
               ============================================= */
        .btn-detail-modern {
            padding: 10px 20px;
            border: var(--nb-border);
            background: var(--nb-white);
            color: var(--nb-black);
            border-radius: var(--nb-radius-sm);
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
            box-shadow: var(--nb-shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .btn-detail-modern::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--nb-purple), var(--nb-pink), var(--nb-purple));
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
        }

        .btn-detail-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }

        .btn-detail-modern:hover {
            background: var(--nb-black);
            color: var(--nb-white);
            transform: translate(-3px, -3px);
            box-shadow: var(--nb-shadow);
        }

        .btn-detail-modern:hover::before {
            left: 100%;
        }

        .btn-detail-modern:active {
            transform: translate(3px, 3px);
            box-shadow: none;
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
        /* =============================================
               REAL-TIME CLOCK - Neobrutalism
               ============================================= */
        .live-clock-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--nb-black);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 8px 16px;
            box-shadow: var(--nb-shadow-sm);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .live-clock-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--nb-yellow), var(--nb-purple), var(--nb-yellow));
            background-size: 200% 100%;
            animation: gradientShift 2s ease infinite;
        }

        .live-clock-wrapper::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--nb-teal), var(--nb-pink), var(--nb-teal));
            background-size: 200% 100%;
            animation: gradientShift 2s ease infinite reverse;
        }

        .clock-icon {
            font-size: 1rem;
            color: var(--nb-yellow);
            animation: pulseIcon 2s ease-in-out infinite;
        }

        .clock-icon i {
            font-size: 1rem;
        }

        .clock-display {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--nb-white);
            letter-spacing: 0.05em;
            line-height: 1;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .clock-display .clock-time {
            background: var(--nb-dark);
            padding: 4px 10px;
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            min-width: 80px;
            text-align: center;
        }

        .clock-display .clock-date {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--nb-gray);
            border-left: 1px solid rgba(255, 255, 255, 0.15);
            padding-left: 10px;
        }

        .clock-separator {
            animation: blink 1s step-end infinite;
            color: var(--nb-yellow);
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }

        /* Big clock widget */
        .big-clock-widget {
            background: var(--nb-white);
            border: var(--nb-border-thick);
            border-radius: var(--nb-radius);
            padding: 20px 28px;
            box-shadow: var(--nb-shadow);
            display: inline-flex;
            align-items: center;
            gap: 20px;
            position: relative;
            overflow: hidden;
            background-image:
                radial-gradient(circle at 80% 20%, rgba(166, 108, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 20% 80%, rgba(78, 205, 196, 0.08) 0%, transparent 50%);
            transition: all 0.3s ease;
        }

        .big-clock-widget:hover {
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow-hover);
        }

        .big-clock-widget::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--nb-yellow), var(--nb-purple));
        }

        .big-clock-icon {
            width: 56px;
            height: 56px;
            background: var(--nb-yellow);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
            flex-shrink: 0;
            animation: pulseIcon 2s ease-in-out infinite;
        }

        .big-clock-content {
            display: flex;
            flex-direction: column;
        }

        .big-clock-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--nb-dark);
            margin-bottom: 4px;
        }

        .big-clock-time {
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--nb-black);
            line-height: 1;
            letter-spacing: -0.02em;
            text-shadow: 2px 2px 0 var(--nb-yellow);
        }

        .big-clock-date {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--nb-dark);
            margin-top: 4px;
        }

        /* =============================================
               ANIMATED GRADIENT BACKGROUND
               ============================================= */
        .gradient-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
            background: linear-gradient(135deg,
                    var(--nb-offwhite) 0%,
                    rgba(166, 108, 255, 0.05) 25%,
                    rgba(78, 205, 196, 0.05) 50%,
                    rgba(255, 230, 109, 0.05) 75%,
                    var(--nb-offwhite) 100%);
            background-size: 400% 400%;
            animation: gradientShiftBg 15s ease infinite;
        }

        @keyframes gradientShiftBg {
            0% {
                background-position: 0% 50%;
            }

            25% {
                background-position: 100% 0%;
            }

            50% {
                background-position: 100% 100%;
            }

            75% {
                background-position: 0% 100%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* =============================================
               MOUSE GLOW TRAIL
               ============================================= */
        .mouse-glow {
            position: fixed;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(166, 108, 255, 0.12) 0%, transparent 70%);
            pointer-events: none;
            z-index: 9998;
            transform: translate(-50%, -50%);
            transition: opacity 0.3s ease;
            opacity: 0;
            will-change: transform;
        }

        .mouse-glow.visible {
            opacity: 1;
        }

        .mouse-glow-trail {
            position: fixed;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--nb-purple);
            border: 2px solid var(--nb-black);
            pointer-events: none;
            z-index: 9999;
            transform: translate(-50%, -50%);
            transition: all 0.1s ease;
            opacity: 0;
            box-shadow: var(--nb-shadow-sm);
        }

        .mouse-glow-trail.visible {
            opacity: 1;
        }

        /* =============================================
               TIME-BASED GREETING
               ============================================= */
        .greeting-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--nb-white);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            padding: 8px 16px;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.875rem;
            color: var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .greeting-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--nb-yellow), var(--nb-purple), var(--nb-teal));
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
        }

        .greeting-badge:hover {
            transform: translate(-2px, -2px);
            box-shadow: var(--nb-shadow);
        }

        .greeting-badge .greeting-emoji {
            font-size: 1.25rem;
            animation: wave 2s ease-in-out infinite;
        }

        @keyframes wave {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(10deg);
            }

            75% {
                transform: rotate(-5deg);
            }
        }

        /* =============================================
               ANIMATED NUMBER COUNTER
               ============================================= */
        .count-animate {
            display: inline-block;
            transition: all 0.3s ease;
        }

        .count-animate.count-pop {
            animation: countPop 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes countPop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
                color: var(--nb-yellow);
            }

            100% {
                transform: scale(1);
            }
        }

        /* =============================================
               RIPPLE EFFECT ON CLICK
               ============================================= */
        .ripple-container {
            position: relative;
            overflow: hidden;
        }

        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background: rgba(166, 108, 255, 0.3);
            border: 2px solid var(--nb-black);
            transform: scale(0);
            animation: rippleAnim 0.6s ease-out;
            pointer-events: none;
        }

        @keyframes rippleAnim {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* =============================================
               STAMP BADGE ANIMATION
               ============================================= */
        .stamp-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            background: var(--nb-yellow);
            border: 2px solid var(--nb-black);
            border-radius: 4px;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 0.6875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--nb-black);
            box-shadow: var(--nb-shadow-sm);
            transform: rotate(-3deg);
            animation: stampAppear 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .stamp-badge:nth-child(2) {
            transform: rotate(2deg);
            background: var(--nb-purple);
            color: var(--nb-white);
        }

        .stamp-badge:nth-child(3) {
            transform: rotate(-1deg);
            background: var(--nb-teal);
        }

        @keyframes stampAppear {
            0% {
                transform: rotate(-10deg) scale(0) translateY(-20px);
                opacity: 0;
            }

            60% {
                transform: rotate(2deg) scale(1.1);
                opacity: 1;
            }

            100% {
                transform: rotate(-3deg) scale(1);
            }
        }

        .stamp-badge i {
            font-size: 0.75rem;
        }

        /* =============================================
               CARD 3D STACK ENTRANCE
               ============================================= */
        .schedule-list-card {
            transform-style: preserve-3d;
            perspective: 1200px;
        }

        .schedule-list-card.entrance {
            animation: cardEntrance 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            opacity: 0;
        }

        @keyframes cardEntrance {
            0% {
                opacity: 0;
                transform: perspective(1200px) rotateX(10deg) rotateY(-10deg) translateY(60px) scale(0.9);
            }

            60% {
                opacity: 1;
                transform: perspective(1200px) rotateX(-2deg) rotateY(2deg) translateY(-5px) scale(1.02);
            }

            100% {
                opacity: 1;
                transform: perspective(1200px) rotateX(0deg) rotateY(0deg) translateY(0) scale(1);
            }
        }

        /* =============================================
               INTERACTIVE BACKGROUND PARTICLES
               ============================================= */
        #particles-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            border-radius: 4px;
            pointer-events: none;
            opacity: 0;
            transition: opacity 1s ease;
        }

        .particle.visible {
            opacity: 1;
        }

        .particle.shape-circle {
            border-radius: 50%;
        }

        .particle.shape-square {
            border-radius: 2px;
        }

        .particle.shape-triangle {
            width: 0 !important;
            height: 0 !important;
            background: transparent !important;
            border-left: solid transparent;
            border-right: solid transparent;
            border-bottom: solid;
        }

        /* =============================================
               LIVE PULSE INDICATOR
               ============================================= */
        .live-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--nb-red);
            color: var(--nb-white);
            padding: 6px 14px;
            border-radius: var(--nb-radius-sm);
            border: var(--nb-border);
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.8125rem;
            box-shadow: var(--nb-shadow-sm);
            animation: livePulse 2s ease-in-out infinite;
            position: relative;
            overflow: hidden;
            margin-left: 10px;
        }

        .live-indicator::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        .live-dot {
            width: 10px;
            height: 10px;
            background: var(--nb-white);
            border-radius: 50%;
            border: 2px solid var(--nb-black);
            animation: liveDot 1.5s ease-in-out infinite;
            position: relative;
            z-index: 1;
        }

        @keyframes liveDot {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
            }

            50% {
                transform: scale(0.7);
                opacity: 0.7;
                box-shadow: 0 0 0 8px rgba(255, 255, 255, 0);
            }
        }

        @keyframes livePulse {

            0%,
            100% {
                box-shadow: var(--nb-shadow-sm), 0 0 0 0 rgba(255, 107, 107, 0.4);
            }

            50% {
                box-shadow: var(--nb-shadow), 0 0 0 12px rgba(255, 107, 107, 0);
            }
        }

        /* =============================================
               PROGRESS BAR FOR CURRENT CLASS
               ============================================= */
        .class-progress-container {
            margin-top: 16px;
            padding: 12px 16px;
            background: var(--nb-dark);
            border: var(--nb-border);
            border-radius: var(--nb-radius-sm);
            box-shadow: var(--nb-shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .class-progress-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--nb-yellow), var(--nb-purple));
        }

        .class-progress-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--nb-white);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .class-progress-bar {
            height: 12px;
            background: var(--nb-dark);
            border: 2px solid var(--nb-black);
            border-radius: 6px;
            overflow: hidden;
            position: relative;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .class-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--nb-yellow), var(--nb-purple), var(--nb-pink));
            background-size: 200% 100%;
            border-radius: 4px;
            transition: width 1s ease;
            animation: gradientShift 3s ease infinite;
            position: relative;
        }

        .class-progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 20px;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            filter: blur(4px);
        }

        .class-progress-percent {
            font-family: var(--font-display);
            font-size: 0.8125rem;
            font-weight: 800;
            color: var(--nb-yellow);
            background: var(--nb-black);
            padding: 1px 8px;
            border-radius: 3px;
        }

        /* =============================================
               SCROLL REVEAL ANIMATIONS
               ============================================= */
        .reveal {
            opacity: 0;
            transform: translateY(40px) scale(0.98);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform, opacity;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .reveal-left {
            opacity: 0;
            transform: translateX(-50px) rotateY(-5deg);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform, opacity;
        }

        .reveal-left.visible {
            opacity: 1;
            transform: translateX(0) rotateY(0);
        }

        .reveal-right {
            opacity: 0;
            transform: translateX(50px) rotateY(5deg);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform, opacity;
        }

        .reveal-right.visible {
            opacity: 1;
            transform: translateX(0) rotateY(0);
        }

        .reveal-scale {
            opacity: 0;
            transform: scale(0.85);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform, opacity;
        }

        .reveal-scale.visible {
            opacity: 1;
            transform: scale(1);
        }

        /* Delay classes */
        .delay-100 {
            transition-delay: 0.1s;
        }

        .delay-200 {
            transition-delay: 0.2s;
        }

        .delay-300 {
            transition-delay: 0.3s;
        }

        .delay-400 {
            transition-delay: 0.4s;
        }

        .delay-500 {
            transition-delay: 0.5s;
        }

        /* =============================================
               INTERACTIVE SCHEDULE CARD HOVER
               ============================================= */
        .schedule-list-card {
            cursor: pointer;
        }

        .schedule-list-card .schedule-course {
            transition: all 0.3s ease;
        }

        .schedule-list-card:hover .schedule-course {
            transform: translateX(5px);
        }

        .schedule-list-card .schedule-meta-item {
            transition: all 0.3s ease;
        }

        .schedule-list-card:hover .schedule-meta-item {
            transform: translateX(3px);
        }

        .schedule-list-card .schedule-meta-item:nth-child(2) {
            transition-delay: 0.05s;
        }

        .schedule-list-card .schedule-meta-item:nth-child(3) {
            transition-delay: 0.1s;
        }

        /* Color accent overlay on hover */
        .schedule-list-card::after {
            content: '';
            position: absolute;
            top: 4px;
            left: 4px;
            right: -4px;
            bottom: -4px;
            background: var(--nb-black);
            border-radius: var(--nb-radius);
            z-index: -1;
            transition: all 0.3s ease;
        }

        .schedule-list-card.color-accent-purple::after {
            background: var(--nb-purple) !important;
        }

        .schedule-list-card.color-accent-teal::after {
            background: var(--nb-teal) !important;
        }

        .schedule-list-card.color-accent-pink::after {
            background: var(--nb-pink) !important;
        }

        .schedule-list-card.color-accent-orange::after {
            background: var(--nb-orange) !important;
        }

        .schedule-list-card.color-accent-green::after {
            background: var(--nb-green) !important;
        }

        .schedule-list-card.color-accent-blue::after {
            background: var(--nb-blue) !important;
        }

        /* =============================================
               SMOOTH SCROLL INDICATOR
               ============================================= */
        .scroll-indicator {
            text-align: center;
            padding: 20px 0 10px;
            animation: bounceIndicator 2s ease-in-out infinite;
        }

        .scroll-indicator span {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--nb-dark);
            opacity: 0.6;
            transition: opacity 0.3s ease;
        }

        .scroll-indicator span i {
            font-size: 1rem;
            animation: bounceArrow 2s ease-in-out infinite;
        }

        @keyframes bounceIndicator {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(6px);
            }
        }

        @keyframes bounceArrow {

            0%,
            100% {
                transform: translateY(0);
                opacity: 1;
            }

            50% {
                transform: translateY(4px);
                opacity: 0.5;
            }
        }

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

        @keyframes slideInCard {
            from {
                opacity: 0;
                transform: translateX(-30px) rotateY(-5deg);
            }

            to {
                opacity: 1;
                transform: translateX(0) rotateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        .schedule-card {
            animation: fadeInUp 0.5s ease;
        }

        .schedule-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        /* Schedule list cards with staggered animation */
        /* Default animation is now handled by .entrance class from JS */
        .schedule-list-card:not(.entrance) {
            animation: slideInCard 0.6s ease forwards;
        }

        .schedule-list-card:not(.entrance):nth-child(1) {
            animation-delay: 0.05s;
        }

        .schedule-list-card:not(.entrance):nth-child(2) {
            animation-delay: 0.1s;
        }

        .schedule-list-card:not(.entrance):nth-child(3) {
            animation-delay: 0.15s;
        }

        .schedule-list-card:not(.entrance):nth-child(4) {
            animation-delay: 0.2s;
        }

        .schedule-list-card:not(.entrance):nth-child(5) {
            animation-delay: 0.25s;
        }

        .schedule-list-card:not(.entrance):nth-child(6) {
            animation-delay: 0.3s;
        }

        .schedule-list-card:not(.entrance):nth-child(7) {
            animation-delay: 0.35s;
        }

        .schedule-list-card:not(.entrance):nth-child(8) {
            animation-delay: 0.4s;
        }
    </style>
</head>

<body class="{{ $maintenanceMode == '1' ? 'maintenance-active' : '' }}">

    <!-- Animated Gradient Background -->
    <div class="gradient-bg"></div>

    <!-- Mouse Glow Trail -->
    <div class="mouse-glow" id="mouseGlow"></div>
    <div class="mouse-glow-trail" id="mouseGlowTrail"></div>

    <!-- Interactive Background Particles Canvas -->
    <div id="particles-canvas"></div>

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

    <!-- Header - Neobrutalism App Header -->
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
                    <p class="institution-sub">
                        {{ $programStudi }}<span class="institution-divider"> | </span>Tahun
                        Akademik {{ $tahunAkademik }}
                    </p>
                    <!-- Greeting Badge -->
                    <div class="greeting-badge" style="margin-top: 8px;" id="greetingBadge">
                        <span class="greeting-emoji" id="greetingEmoji">👋</span>
                        <span id="greetingText">Selamat datang</span>
                    </div>
                </div>
                <div class="logo-section">
                    <img src="{{ asset('jadwal-kampus/assets/images/logo_jurusan.png') }}" alt="Logo Jurusan"
                        class="logo-img"
                        onerror="this.onerror=null; this.src='https://via.placeholder.com/56x56/1e293b/ffffff?text=LOGO'">
                </div>
            </div>
            <!-- Live Clock Widget di Header -->
            <div class="header-content" style="margin-top: 12px; justify-content: center;">
                <div class="live-clock-wrapper">
                    <span class="clock-icon"><i class="fas fa-clock"></i></span>
                    <div class="clock-display">
                        <span class="clock-time" id="headerClockTime">{{ now()->format('H:i:s') }}</span>
                        <span class="clock-date"
                            id="headerClockDate">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
                    </div>
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
                    <div class="alert alert-warning"
                        style="background: var(--nb-orange); border: var(--nb-border); border-radius: var(--nb-radius-sm); color: var(--nb-black); font-weight: 600;">
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
                    <div class="alert alert-warning"
                        style="background: var(--nb-orange); border: var(--nb-border); border-radius: var(--nb-radius-sm); color: var(--nb-black); font-weight: 600;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Tidak ada kelas tersedia untuk semester {{ $semesterAktif }}
                    </div>
                @endif
            </div>
        </section>

        <!-- Running Text / Marquee -->
        @if (($runningTextEnabled ?? '0') == '1' && !empty($runningTextContent))
            <div class="running-text-bar"
                style="background: {{ $runningTextBgColor ?? '#1A1A2E' }}; color: {{ $runningTextColor ?? '#FFE66D' }}; border-radius: var(--nb-radius-sm); border: var(--nb-border); overflow: hidden; margin-bottom: 28px;">
                <marquee behavior="scroll" direction="left"
                    style="display: block; padding: 14px 20px; font-weight: 700; font-size: 0.95rem; width: 100%; font-family: 'Space Grotesk', sans-serif;"
                    @if (($runningTextSpeed ?? 'normal') == 'slow') scrollamount="3"
                    @elseif(($runningTextSpeed ?? 'normal') == 'fast') scrollamount="8"
                    @else scrollamount="5" @endif>
                    {!! $runningTextContent ?? '' !!}
                </marquee>
            </div>
        @endif

        <!-- Scroll Indicator -->
        <div class="scroll-indicator reveal">
            <span>
                <i class="fas fa-chevron-down"></i>
                Scroll untuk jadwal lengkap
                <i class="fas fa-chevron-down"></i>
            </span>
        </div>

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
                    <div class="schedule-card accent-green tilt-3d reveal-left" data-tilt>
                        <div class="schedule-card-header success-bg">
                            <h5 class="schedule-card-title"
                                style="display: flex; align-items: center; flex-wrap: wrap; gap: 8px;">
                                <i class="fas fa-play-circle"></i>
                                Sedang Berlangsung
                                @if ($jadwalBerlangsung)
                                    <span class="live-indicator">
                                        <span class="live-dot"></span>
                                        LIVE
                                    </span>
                                @endif
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
                                        <div class="class-progress-container" id="classProgressContainer">
                                            <div class="class-progress-label">
                                                <span><i class="fas fa-hourglass-half me-1"></i> Progress
                                                    Perkuliahan</span>
                                                <span class="class-progress-percent"
                                                    id="classProgressPercent">0%</span>
                                            </div>
                                            <div class="class-progress-bar">
                                                <div class="class-progress-fill" id="classProgressFill"
                                                    style="width: 0%;"></div>
                                            </div>
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
                    <div class="schedule-card accent-left tilt-3d reveal-right" data-tilt>
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
                <div class="info-box reveal">
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
                                    Waktu: <strong id="liveTimeInfoBox">{{ now()->format('H:i:s') }}</strong>
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
            <div class="schedule-list-header reveal">
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
                    <span class="count-animate" id="scheduleCount">{{ count($jadwal) }}</span> Jadwal
                </span>
            </div>

            @if (empty($jadwal))
                <div class="schedule-card"
                    style="text-align: center; padding: 60px 20px; background: var(--nb-dark);">
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
                                style="font-family: 'Space Grotesk', sans-serif; font-size: 1.125rem; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-calendar-day" style="font-size: 1.25rem;"></i>
                                {{ $hari }}
                                <span class="badge-pill"
                                    style="background: var(--nb-black); color: var(--nb-white); border: var(--nb-border); margin-left: 8px; font-size: 0.8125rem;">
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
                                    <div class="schedule-list-card {{ $isCurrent ? 'active' : '' }} tilt-3d"
                                        data-tilt>
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
                        <div class="schedule-list-card {{ $isCurrent ? 'active' : '' }} tilt-3d" data-tilt>
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
            <div class="modal-content"
                style="border: var(--nb-border-thick); border-radius: var(--nb-radius); overflow: hidden; box-shadow: var(--nb-shadow-lg);">
                <div class="modal-header"
                    style="background: var(--nb-black); color: var(--nb-white); border-bottom: var(--nb-border);">
                    <h5 class="modal-title" style="font-family: 'Space Grotesk', sans-serif; font-weight: 700;">
                        <i class="fas fa-door-open me-2"></i> Foto Ruangan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 0; text-align: center;">
                    <div class="room-photo-container" id="roomPhotoContainer"
                        style="min-height: 300px; background: var(--nb-offwhite); display: flex; align-items: center; justify-content: center;">
                        <div class="room-photo-placeholder" style="padding: 60px 20px; color: var(--nb-dark);">
                            <i class="fas fa-image d-block" style="font-size: 4rem; margin-bottom: 16px;"></i>
                            <p class="mb-0">Memuat foto...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: var(--nb-border); background: var(--nb-offwhite);">
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
                style="border: var(--nb-border-thick); border-radius: var(--nb-radius); overflow: hidden; box-shadow: var(--nb-shadow-lg);">
                <div class="modal-header"
                    style="background: var(--nb-black); color: var(--nb-white); border-bottom: var(--nb-border);">
                    <h5 class="modal-title" style="font-family: 'Space Grotesk', sans-serif; font-weight: 700;">
                        <i class="fas fa-info-circle me-2"></i> Detail Jadwal
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" id="scheduleDetail">
                </div>
                <div class="modal-footer" style="border-top: var(--nb-border); background: var(--nb-offwhite);">
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
                style="border: var(--nb-border-thick); border-radius: var(--nb-radius); overflow: hidden; box-shadow: var(--nb-shadow-lg);">
                <div class="modal-header"
                    style="background: var(--nb-black); color: var(--nb-white); border-bottom: var(--nb-border);">
                    <h5 class="modal-title" style="font-family: 'Space Grotesk', sans-serif; font-weight: 700;">
                        <i class="fas fa-comment-dots me-2"></i> Kritik & Saran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="suggestionForm" method="POST" action="{{ url('/submit-suggestion') }}">
                    @csrf
                    <div class="modal-body p-4">
                        <p class="mb-4" style="font-weight: 500;">
                            Sampaikan kritik dan saran Anda untuk perbaikan sistem jadwal kuliah.
                            Semua masukan akan sangat berarti bagi kami.
                        </p>

                        <div class="mb-3">
                            <label for="suggestionName" class="form-label"
                                style="font-family: 'Space Grotesk', sans-serif; font-weight: 700;">
                                Nama <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="suggestionName" name="name"
                                placeholder="Masukkan nama Anda" required
                                style="border-radius: var(--nb-radius-sm); border: var(--nb-border); padding: 10px 14px;">
                        </div>

                        <div class="mb-3">
                            <label for="suggestionEmail" class="form-label"
                                style="font-family: 'Space Grotesk', sans-serif; font-weight: 700;">
                                Email (opsional)
                            </label>
                            <input type="email" class="form-control" id="suggestionEmail" name="email"
                                placeholder="nama@email.com"
                                style="border-radius: var(--nb-radius-sm); border: var(--nb-border); padding: 10px 14px;">
                            <small class="text-muted">Email hanya digunakan untuk follow up jika diperlukan</small>
                        </div>

                        <div class="mb-3">
                            <label for="suggestionMessage" class="form-label"
                                style="font-family: 'Space Grotesk', sans-serif; font-weight: 700;">
                                Kritik & Saran <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="suggestionMessage" name="message" rows="5"
                                placeholder="Tuliskan kritik dan saran Anda di sini..." required
                                style="border-radius: var(--nb-radius-sm); border: var(--nb-border); padding: 10px 14px;"></textarea>
                            <small class="text-muted">Minimal 10 karakter</small>
                        </div>

                        <div class="info-box" style="background: var(--nb-yellow);">
                            <div class="info-box-content">
                                <i class="fas fa-info-circle info-box-icon" style="font-size: 1.25rem;"></i>
                                <div class="info-box-text">
                                    <small style="font-weight: 500;">
                                        Kritik dan saran Anda akan langsung masuk ke sistem dan dapat dilihat oleh
                                        admin.
                                        Tidak perlu login untuk mengirimkan kritik dan saran.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: var(--nb-border); background: var(--nb-offwhite);">
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
        let realtimeClockInterval = null;

        /**
         * Real-time Clock updater
         * Updates the header clock and info box time every second
         */
        function startRealtimeClock() {
            function updateClock() {
                const now = new Date();

                // Format time HH:MM:SS
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const timeStr = hours + ':' + minutes + ':' + seconds;
                const timeStrShort = hours + ':' + minutes;

                // Format date in Indonesian
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                    'Oktober', 'November', 'Desember'
                ];
                const dayName = days[now.getDay()];
                const date = now.getDate();
                const month = months[now.getMonth()];
                const year = now.getFullYear();
                const dateStr = dayName + ', ' + date + ' ' + month + ' ' + year;

                // Update header clock
                const headerTime = document.getElementById('headerClockTime');
                const headerDate = document.getElementById('headerClockDate');
                if (headerTime) headerTime.textContent = timeStr;
                if (headerDate) headerDate.textContent = dateStr;

                // Update info box time
                const infoBoxTime = document.getElementById('liveTimeInfoBox');
                if (infoBoxTime) infoBoxTime.textContent = timeStr;
            }

            updateClock();
            realtimeClockInterval = setInterval(updateClock, 1000);
        }

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
                // Specific day selected
                params.delete('semua_hari');
                params.set('hari', value);
                // Keep kelas if exists, otherwise add default first class
                if (!params.has('kelas') || params.get('kelas') === '1') {
                    params.set('kelas', firstClass);
                }
                params.delete('semua_kelas');
            } else if (type === 'semua_hari') {
                // All days selected
                params.set('semua_hari', '1');
                params.delete('hari');
                // Keep kelas if exists, otherwise use first class
                if (!params.has('kelas')) {
                    params.set('kelas', firstClass);
                }
            } else if (type === 'kelas') {
                // Specific class selected
                params.delete('semua_kelas');
                params.set('kelas', value);
                // Keep hari if exists, otherwise use current day
                if (!params.has('hari') || params.get('hari') === '1') {
                    params.set('hari', currentDay);
                }
                params.delete('semua_hari');
            } else if (type === 'semua_kelas') {
                // All classes selected
                params.set('semua_kelas', '1');
                params.delete('kelas');
                // Keep hari if exists, otherwise use current day
                if (!params.has('hari')) {
                    params.set('hari', currentDay);
                }
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
                const photoFilename = ruanganMap[roomName];
                const photoUrl = "{{ asset('storage/uploads/rooms/') }}" + '/' + photoFilename;
                const img = document.createElement('img');
                img.src = photoUrl;
                img.alt = "Foto Ruangan " + roomName;
                img.className = "img-fluid";
                img.style.maxHeight = "500px";
                img.style.objectFit = "contain";
                img.onerror = function() {
                    photoContainer.innerHTML = `
                        <div class="room-photo-placeholder" style="padding: 60px 20px; color: var(--nb-dark);">
                            <i class="fas fa-image d-block" style="font-size: 4rem; margin-bottom: 16px;"></i>
                            <p class="mb-0">Foto tidak tersedia</p>
                        </div>
                    `;
                };
                photoContainer.innerHTML = '';
                photoContainer.appendChild(img);
            } else {
                photoContainer.innerHTML = `
                    <div class="room-photo-placeholder" style="padding: 60px 20px; color: var(--nb-dark);">
                        <i class="fas fa-image d-block" style="font-size: 4rem; margin-bottom: 16px;"></i>
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

            // Check if room photo exists
            let roomPhotoHTML = '';
            if (ruanganMap && ruanganMap[data.ruang]) {
                const photoFilename = ruanganMap[data.ruang];
                const photoUrl = "{{ asset('storage/uploads/rooms/') }}" + '/' + photoFilename;
                roomPhotoHTML = `
                    <div class="col-md-6">
                        <div class="room-photo-detail" style="background: var(--nb-white); border: var(--nb-border); border-radius: var(--nb-radius); overflow: hidden; box-shadow: var(--nb-shadow-sm);">
                            <img src="${photoUrl}" alt="Foto Ruangan ${data.ruang}" style="width: 100%; height: 250px; object-fit: cover; display: block;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="room-photo-fallback" style="display: none; padding: 40px 20px; text-align: center; background: var(--nb-offwhite); color: var(--nb-dark); flex-direction: column; align-items: center; justify-content: center; min-height: 250px;">
                                <i class="fas fa-image d-block" style="font-size: 3rem; margin-bottom: 12px; color: var(--nb-dark);"></i>
                                <p class="mb-0" style="font-weight: 600;">Foto tidak tersedia</p>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <small style="font-weight: 600; color: var(--nb-dark);"><i class="fas fa-door-open me-1"></i> Ruang ${data.ruang}</small>
                        </div>
                    </div>
                `;
            } else {
                roomPhotoHTML = `
                    <div class="col-md-6">
                        <div class="room-photo-detail" style="background: var(--nb-offwhite); border: var(--nb-border); border-radius: var(--nb-radius); padding: 40px 20px; text-align: center; min-height: 250px; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: var(--nb-shadow-sm);">
                            <i class="fas fa-image d-block" style="font-size: 3rem; margin-bottom: 12px; color: var(--nb-dark);"></i>
                            <p class="mb-0" style="font-weight: 600; color: var(--nb-dark);">Foto Ruangan Tidak Tersedia</p>
                            <small style="color: var(--nb-dark);">Ruang ${data.ruang}</small>
                        </div>
                    </div>
                `;
            }

            detail.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-3" style="font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 1.5rem;">${data.mata_kuliah}</h4>
                        <table class="table table-borderless">
                            <tr>
                                <td style="width: 140px;"><i class="fas fa-clock me-2" style="background: var(--nb-yellow); padding: 3px; border: 2px solid #000; border-radius: 4px; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"></i>Waktu</td>
                                <td><strong>${data.waktu}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-list-ol me-2" style="background: var(--nb-yellow); padding: 3px; border: 2px solid #000; border-radius: 4px; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"></i>Jam ke-</td>
                                <td><strong>${data.jam_ke}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-user-tie me-2" style="background: var(--nb-yellow); padding: 3px; border: 2px solid #000; border-radius: 4px; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"></i>Dosen</td>
                                <td><strong>${data.dosen}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-door-open me-2" style="background: var(--nb-yellow); padding: 3px; border: 2px solid #000; border-radius: 4px; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"></i>Ruang</td>
                                <td><strong>${data.ruang}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-users me-2" style="background: var(--nb-yellow); padding: 3px; border: 2px solid #000; border-radius: 4px; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"></i>Kelas</td>
                                <td><strong>${data.kelas}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calendar-day me-2" style="background: var(--nb-yellow); padding: 3px; border: 2px solid #000; border-radius: 4px; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"></i>Hari</td>
                                <td><strong>${data.hari}</strong></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calendar-alt me-2" style="background: var(--nb-yellow); padding: 3px; border: 2px solid #000; border-radius: 4px; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"></i>Semester</td>
                                <td><strong>${data.semester} ${data.tahun_akademik}</strong></td>
                            </tr>
                        </table>
                    </div>
                    ${roomPhotoHTML}
                    <div class="col-md-6">
                        <div class="card" style="background: var(--nb-yellow); border: var(--nb-border); border-radius: var(--nb-radius); box-shadow: var(--nb-shadow-sm);">
                            <div class="card-body text-center py-5">
                                <div class="display-1 fw-bold mb-3" style="font-family: 'Space Grotesk', sans-serif; color: var(--nb-black); font-size: 4rem; font-weight: 900; text-shadow: 3px 3px 0 rgba(0,0,0,0.1);">${data.jam_ke}</div>
                                <h6 style="font-weight: 600;">Jam ke-${data.jam_ke}</h6>
                                <span class="badge-pill success-pill mt-2" style="font-size: 0.875rem; background: var(--nb-black); color: var(--nb-white);">
                                    <i class="fas fa-clock"></i> ${data.waktu}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            bootstrapModal.show();
        }

        // =============================================
        // MOUSE GLOW EFFECT
        // =============================================
        function initMouseGlow() {
            const glow = document.getElementById('mouseGlow');
            const trail = document.getElementById('mouseGlowTrail');
            if (!glow || !trail) return;

            let mouseX = -200,
                mouseY = -200;
            let trailX = -200,
                trailY = -200;
            let isVisible = false;
            let timeoutId = null;

            document.addEventListener('mousemove', function(e) {
                mouseX = e.clientX;
                mouseY = e.clientY;

                if (!isVisible) {
                    isVisible = true;
                    glow.classList.add('visible');
                    trail.classList.add('visible');
                }

                glow.style.left = mouseX + 'px';
                glow.style.top = mouseY + 'px';

                // Clear timeout
                if (timeoutId) clearTimeout(timeoutId);
                timeoutId = setTimeout(function() {
                    isVisible = false;
                    glow.classList.remove('visible');
                    trail.classList.remove('visible');
                }, 3000);
            });

            // Smooth trail following
            function animateTrail() {
                trailX += (mouseX - trailX) * 0.15;
                trailY += (mouseY - trailY) * 0.15;

                if (trail.style.opacity !== '0') {
                    trail.style.left = trailX + 'px';
                    trail.style.top = trailY + 'px';
                }
                requestAnimationFrame(animateTrail);
            }
            animateTrail();
        }

        // =============================================
        // TIME-BASED GREETING
        // =============================================
        function initGreeting() {
            const emojiEl = document.getElementById('greetingEmoji');
            const textEl = document.getElementById('greetingText');
            if (!emojiEl || !textEl) return;

            function updateGreeting() {
                const hour = new Date().getHours();
                let emoji, text;

                if (hour >= 3 && hour < 6) {
                    emoji = '🌅';
                    text = 'Selamat subuh';
                } else if (hour >= 6 && hour < 10) {
                    emoji = '☀️';
                    text = 'Selamat pagi';
                } else if (hour >= 10 && hour < 12) {
                    emoji = '🌤️';
                    text = 'Selamat siang';
                } else if (hour >= 12 && hour < 15) {
                    emoji = '🌞';
                    text = 'Selamat siang';
                } else if (hour >= 15 && hour < 18) {
                    emoji = '🌅';
                    text = 'Selamat sore';
                } else if (hour >= 18 && hour < 21) {
                    emoji = '🌆';
                    text = 'Selamat petang';
                } else {
                    emoji = '🌙';
                    text = 'Selamat malam';
                }

                emojiEl.textContent = emoji;
                textEl.textContent = text;
            }

            updateGreeting();
            setInterval(updateGreeting, 60000); // Check every minute
        }

        // =============================================
        // RIPPLE EFFECT ON CLICK
        // =============================================
        function initRippleEffect() {
            document.querySelectorAll('.schedule-list-card, .btn-detail-modern, .btn-filter-action').forEach(function(el) {
                el.classList.add('ripple-container');
                el.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const ripple = document.createElement('span');
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.className = 'ripple-effect';
                    ripple.style.width = size + 'px';
                    ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';

                    this.appendChild(ripple);
                    setTimeout(function() {
                        ripple.remove();
                    }, 600);
                });
            });
        }

        // =============================================
        // ANIMATED COUNTER
        // =============================================
        function initAnimatedCounter() {
            const countEl = document.getElementById('scheduleCount');
            if (!countEl) return;

            const target = parseInt(countEl.textContent) || 0;

            function animateCount() {
                countEl.classList.add('count-pop');
                setTimeout(function() {
                    countEl.classList.remove('count-pop');
                }, 400);
            }

            // Pop on load
            setTimeout(animateCount, 300);

            // Re-pop on scroll reveal
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        animateCount();
                    }
                });
            });
            observer.observe(countEl);
        }

        // =============================================
        // CARD 3D STACK ENTRANCE (Enhanced)
        // =============================================
        function initCardEntrance() {
            const cards = document.querySelectorAll('.schedule-list-card');
            cards.forEach(function(card, index) {
                // Only apply if card is not already visible via other animations
                if (!card.classList.contains('active')) {
                    card.style.opacity = '0';
                    card.classList.add('entrance');
                    card.style.animationDelay = (0.05 * index) + 's';
                    card.style.animationDuration = '0.8s';
                    card.style.animationFillMode = 'forwards';
                }
            });
        }

        // =============================================
        // STAMP BADGES FOR EMPTY STATE
        // =============================================
        function initStampBadges() {
            // Add stamp badges to empty state if needed
            const emptyCards = document.querySelectorAll('.schedule-card-body.flex-center');
            emptyCards.forEach(function(card) {
                if (!card.querySelector('.stamp-badge')) {
                    const header = card.closest('.schedule-card')?.querySelector('.schedule-card-header');
                    if (header) {
                        const stamps = document.createElement('div');
                        stamps.style.cssText = 'display: flex; gap: 6px; flex-wrap: wrap; margin-top: 4px;';
                        stamps.innerHTML = `
                            <span class="stamp-badge"><i class="fas fa-check"></i> LIBUR</span>
                            <span class="stamp-badge"><i class="fas fa-clock"></i> ISTIRAHAT</span>
                        `;
                        header.appendChild(stamps);
                    }
                }
            });
        }

        // =============================================
        // INTERACTIVE PARTICLES BACKGROUND
        // =============================================
        function initParticles() {
            const canvas = document.getElementById('particles-canvas');
            if (!canvas) return;

            const shapes = ['circle', 'square', 'triangle'];
            const colors = ['#A66CFF', '#4ECDC4', '#FFE66D', '#FF6B6B', '#F38181', '#95E1D3', '#FFB347', '#6BB5FF'];
            const particles = [];
            const particleCount = 35;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                const shape = shapes[Math.floor(Math.random() * shapes.length)];
                const size = Math.floor(Math.random() * 16) + 6;
                const color = colors[Math.floor(Math.random() * colors.length)];

                particle.classList.add('particle', 'shape-' + shape);
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';

                if (shape === 'triangle') {
                    particle.style.borderLeftWidth = (size / 2) + 'px';
                    particle.style.borderRightWidth = (size / 2) + 'px';
                    particle.style.borderBottomWidth = size + 'px';
                    particle.style.borderBottomColor = color;
                } else {
                    particle.style.background = color;
                    if (shape === 'square') {
                        particle.style.borderRadius = '2px';
                        particle.style.transform = 'rotate(' + Math.floor(Math.random() * 90) + 'deg)';
                    }
                }

                const startX = Math.random() * window.innerWidth;
                const startY = Math.random() * window.innerHeight;

                particle.style.left = startX + 'px';
                particle.style.top = startY + 'px';

                canvas.appendChild(particle);

                particles.push({
                    el: particle,
                    x: startX,
                    y: startY,
                    size: size,
                    speedX: (Math.random() - 0.5) * 0.5,
                    speedY: (Math.random() - 0.5) * 0.5,
                    rotation: Math.random() * 360,
                    rotSpeed: (Math.random() - 0.5) * 1,
                    visible: false,
                    delay: Math.random() * 3000
                });
            }

            // Animate
            function animateParticles() {
                const now = Date.now();

                particles.forEach(function(p) {
                    // Show with delay
                    if (!p.visible && now > p.delay) {
                        p.visible = true;
                        p.el.classList.add('visible');
                    }

                    if (!p.visible) return;

                    // Move
                    p.x += p.speedX;
                    p.y += p.speedY;
                    p.rotation += p.rotSpeed;

                    // Wrap around
                    if (p.x < -50) p.x = window.innerWidth + 50;
                    if (p.x > window.innerWidth + 50) p.x = -50;
                    if (p.y < -50) p.y = window.innerHeight + 50;
                    if (p.y > window.innerHeight + 50) p.y = -50;

                    p.el.style.left = p.x + 'px';
                    p.el.style.top = p.y + 'px';

                    if (p.el.style.transform) {
                        p.el.style.transform = 'rotate(' + p.rotation + 'deg)';
                    }
                });

                requestAnimationFrame(animateParticles);
            }

            animateParticles();

            // Resize handler
            window.addEventListener('resize', function() {
                particles.forEach(function(p) {
                    if (p.x > window.innerWidth) p.x = window.innerWidth * 0.8;
                    if (p.y > window.innerHeight) p.y = window.innerHeight * 0.8;
                });
            });
        }

        // =============================================
        // SCROLL REVEAL ANIMATIONS
        // =============================================
        function initScrollReveal() {
            const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');

            function checkReveal() {
                const windowHeight = window.innerHeight;
                const revealPoint = 100;

                revealElements.forEach(function(el) {
                    const revealTop = el.getBoundingClientRect().top;
                    if (revealTop < windowHeight - revealPoint) {
                        el.classList.add('visible');
                    }
                });
            }

            // Check on load
            checkReveal();

            // Check on scroll with throttling
            let ticking = false;
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        checkReveal();
                        ticking = false;
                    });
                    ticking = true;
                }
            });

            // Check on resize
            window.addEventListener('resize', checkReveal);
        }

        // =============================================
        // CLASS PROGRESS BAR (Current Schedule)
        // =============================================
        function initClassProgress() {
            const container = document.getElementById('classProgressContainer');
            if (!container) return;

            // Get start & end time from the schedule
            const scheduleDataEl = document.querySelector('.schedule-card.accent-green .btn-detail-modern');
            if (!scheduleDataEl) return;

            try {
                const data = JSON.parse(scheduleDataEl.dataset.schedule);
                const waktu = data.waktu || '';
                const parts = waktu.split(' - ');
                if (parts.length < 2) return;

                const startTime = parts[0].trim();
                const endTime = parts[1].trim();

                function updateProgress() {
                    const now = new Date();
                    const currentMinutes = now.getHours() * 60 + now.getMinutes();

                    const startParts = startTime.split(':');
                    const endParts = endTime.split(':');
                    const startMinutes = parseInt(startParts[0]) * 60 + parseInt(startParts[1]);
                    const endMinutes = parseInt(endParts[0]) * 60 + parseInt(endParts[1]);

                    if (currentMinutes < startMinutes) {
                        // Class hasn't started yet
                        setProgress(0, '0%');
                        return;
                    }

                    if (currentMinutes > endMinutes) {
                        // Class has ended
                        setProgress(100, '100%');
                        return;
                    }

                    const totalDuration = endMinutes - startMinutes;
                    const elapsed = currentMinutes - startMinutes;
                    const percent = Math.min(100, Math.round((elapsed / totalDuration) * 100));

                    setProgress(percent, percent + '%');
                }

                function setProgress(percent, text) {
                    const fill = document.getElementById('classProgressFill');
                    const label = document.getElementById('classProgressPercent');
                    if (fill) fill.style.width = percent + '%';
                    if (label) label.textContent = text;
                }

                updateProgress();
                setInterval(updateProgress, 10000); // Update every 10 seconds
            } catch (e) {
                console.warn('Could not initialize class progress:', e);
            }
        }

        // =============================================
        // RANDOM COLOR ACCENT ON CARD HOVER
        // =============================================
        function initColorAccents() {
            const cards = document.querySelectorAll('.schedule-list-card');
            const accentClasses = [
                'color-accent-purple',
                'color-accent-teal',
                'color-accent-pink',
                'color-accent-orange',
                'color-accent-green',
                'color-accent-blue'
            ];

            cards.forEach(function(card) {
                card.addEventListener('mouseenter', function() {
                    // Remove any existing accent
                    accentClasses.forEach(function(cls) {
                        card.classList.remove(cls);
                    });
                    // Add random accent
                    const randomClass = accentClasses[Math.floor(Math.random() * accentClasses.length)];
                    card.classList.add(randomClass);
                });

                card.addEventListener('mouseleave', function() {
                    // Keep the accent for a moment then remove
                    var self = this;
                    setTimeout(function() {
                        accentClasses.forEach(function(cls) {
                            self.classList.remove(cls);
                        });
                    }, 500);
                });
            });
        }

        // =============================================
        // 3D TILT EFFECT - Vanilla JS
        // =============================================
        function initTiltEffect() {
            const tiltElements = document.querySelectorAll('.tilt-3d');

            tiltElements.forEach(el => {
                el.addEventListener('mousemove', (e) => {
                    const rect = el.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;

                    const rotateX = ((y - centerY) / centerY) * -8;
                    const rotateY = ((x - centerX) / centerX) * 8;

                    el.style.setProperty('--rotate-x', rotateX + 'deg');
                    el.style.setProperty('--rotate-y', rotateY + 'deg');

                    el.style.transform =
                        `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-6px)`;
                });

                el.addEventListener('mouseleave', () => {
                    el.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0px)';
                });
            });
        }

        // Initialize on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize 3D tilt
            initTiltEffect();

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

            // Start real-time clock
            startRealtimeClock();

            // Initialize interactive features
            initMouseGlow();
            initGreeting();
            initParticles();
            initScrollReveal();
            initClassProgress();
            initColorAccents();
            initRippleEffect();
            initAnimatedCounter();
            initCardEntrance();
            initStampBadges();

            // Countdown timer
            if (waktuTungguDetik > 0) {
                startCountdownTimer();
            }

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
            if (realtimeClockInterval) clearInterval(realtimeClockInterval);
        });
    </script>
</body>

</html>
