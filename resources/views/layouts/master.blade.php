<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', trans('main_trans.Main_title'))</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}" type="image/x-icon">

    {{-- Cairo Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Bootstrap 5 — RTL or LTR --}}
    @if (LaravelLocalization::getCurrentLocaleDirection() === 'rtl')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @endif

    {{-- Legacy template CSS (forms, tables, wizard — kept for existing page compatibility) --}}
    <link href="{{ URL::asset('assets/css/wizard.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet">
    @if (App::getLocale() === 'en')
        <link href="{{ URL::asset('assets/css/ltr.css') }}" rel="stylesheet">
    @else
        <link href="{{ URL::asset('assets/css/rtl.css') }}" rel="stylesheet">
    @endif

    @livewireStyles

    {{-- ══════════════════════════════════════════
         EMERALD GREEN THEME — Global Styles
         All directional values use logical CSS properties
         (inset-inline-start, margin-inline-start, etc.)
         so the layout mirrors automatically in RTL/LTR.
    ══════════════════════════════════════════ --}}
    <style>
        /* ── CSS Custom Properties ── */
        :root {
            --em-50:    #ecfdf5;
            --em-100:   #d1fae5;
            --em-300:   #6ee7b7;
            --em-400:   #34d399;
            --em-500:   #10b981;
            --em-600:   #059669;
            --em-700:   #047857;
            --em-800:   #065f46;
            --sb-w:     265px;
            --hdr-h:    64px;
            --sb-from:  #0a1628;
            --sb-to:    #0d1f3c;
            --page-bg:  #f0f4f8;
            --card-bg:  #ffffff;
            --border:   #e2e8f0;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Cairo', sans-serif;
            background: var(--page-bg);
            color: #1e293b;
            min-height: 100vh;
        }

        /* ══════════════════════════════════════════
           SIDEBAR — Bootstrap 5 Offcanvas + CSS override
           On desktop: forced visible & fixed (start side)
           On mobile:  proper slide-in offcanvas
        ══════════════════════════════════════════ */
        #adminSidebar {
            width: var(--sb-w) !important;
            background: linear-gradient(180deg, var(--sb-from) 0%, var(--sb-to) 100%) !important;
            border: none !important;
            display: flex;
            flex-direction: column;
        }

        @media (min-width: 992px) {
            /* Make offcanvas always visible and fixed on desktop */
            #adminSidebar {
                position: fixed !important;
                top: 0 !important;
                bottom: 0 !important;
                inset-inline-start: 0 !important;
                transform: none !important;
                visibility: visible !important;
                z-index: 1030 !important;
                box-shadow: 0 0 40px rgba(0,0,0,.28) !important;
            }
            /* No backdrop on desktop */
            .offcanvas-backdrop { display: none !important; }

            /* Content area offset */
            .admin-main-content { margin-inline-start: var(--sb-w); }

            /* Header offset */
            .admin-header { inset-inline-start: var(--sb-w) !important; }
        }

        /* ══════════════════════════════════════════
           HEADER
        ══════════════════════════════════════════ */
        .admin-header {
            position: fixed;
            top: 0;
            inset-inline-start: 0;
            inset-inline-end: 0;
            height: var(--hdr-h);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 1px 14px rgba(0,0,0,.06);
            z-index: 1020;
            display: flex;
            align-items: center;
            padding: 0 20px;
            gap: 12px;
            /* Allow dropdown menus to overflow outside the header bounds */
            overflow: visible !important;
        }

        /* Dropdown menus inside the header must sit above the sidebar (z-index 1030+) */
        .admin-header .dropdown-menu {
            z-index: 1035 !important;
        }

        /* Emerald accent line at top */
        .admin-header::before {
            content: '';
            position: absolute;
            top: 0;
            inset-inline-start: 0;
            inset-inline-end: 0;
            height: 3px;
            background: linear-gradient(
                90deg,
                var(--em-700) 0%,
                var(--em-600) 25%,
                var(--em-500) 55%,
                var(--em-400) 80%,
                var(--em-300) 100%
            );
        }

        /* ══════════════════════════════════════════
           MAIN CONTENT WRAPPER
        ══════════════════════════════════════════ */
        .admin-main-content {
            margin-top: var(--hdr-h);
            min-height: calc(100vh - var(--hdr-h));
            padding: 24px;
        }

        /* ══════════════════════════════════════════
           ADMIN CARD — universal container
        ══════════════════════════════════════════ */
        .admin-card {
            background: var(--card-bg);
            border-radius: 18px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 16px rgba(0,0,0,.05);
        }

        /* ── Card header variant ── */
        .admin-card-header {
            padding: 16px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }
        .admin-card-title {
            font-size: .95rem;
            font-weight: 800;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .admin-card-title i {
            color: var(--em-600);
            font-size: 1rem;
        }

        /* ══════════════════════════════════════════
           BREADCRUMB
        ══════════════════════════════════════════ */
        .admin-breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 18px;
            font-size: .82rem;
        }
        .admin-breadcrumb .breadcrumb-item a {
            color: var(--em-600);
            font-weight: 600;
            text-decoration: none;
        }
        .admin-breadcrumb .breadcrumb-item a:hover { color: var(--em-700); }
        .admin-breadcrumb .breadcrumb-item.active { color: #64748b; font-weight: 600; }
        .admin-breadcrumb .breadcrumb-item + .breadcrumb-item::before { color: #cbd5e1; }

        /* ══════════════════════════════════════════
           TABLES
        ══════════════════════════════════════════ */
        .table-responsive { border-radius: 12px; overflow: hidden; }

        .admin-table {
            font-size: .88rem;
            margin: 0;
        }
        .admin-table thead th {
            background: #f8fafc;
            color: #64748b;
            font-weight: 700;
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: 13px 16px;
            border-bottom: 2px solid var(--border);
            white-space: nowrap;
        }
        .admin-table tbody td {
            padding: 13px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f8fafc;
            color: #374151;
        }
        .admin-table tbody tr:hover { background: #f9fafb; }
        .admin-table tbody tr:last-child td { border-bottom: none; }

        /* ══════════════════════════════════════════
           FORMS — override Bootstrap defaults
        ══════════════════════════════════════════ */
        .form-control, .form-select {
            font-family: 'Cairo', sans-serif;
            font-size: .9rem;
            border-radius: 10px;
            border-color: var(--border);
            padding: 10px 14px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--em-500);
            box-shadow: 0 0 0 3px rgba(16,185,129,.12);
        }
        .form-label {
            font-weight: 700;
            font-size: .85rem;
            color: #374151;
        }

        /* ══════════════════════════════════════════
           BUTTONS — emerald primary
        ══════════════════════════════════════════ */
        .btn-emerald {
            background: linear-gradient(135deg, var(--em-700), var(--em-600));
            color: white;
            border: none;
            font-family: 'Cairo', sans-serif;
            font-weight: 700;
            border-radius: 10px;
            padding: 9px 20px;
            transition: all .25s ease;
            box-shadow: 0 4px 14px rgba(5,150,105,.3);
        }
        .btn-emerald:hover {
            background: linear-gradient(135deg, var(--em-800), var(--em-700));
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(5,150,105,.4);
        }

        .btn-emerald-outline {
            background: var(--em-50);
            color: var(--em-700);
            border: 1.5px solid var(--em-200);
            font-family: 'Cairo', sans-serif;
            font-weight: 700;
            border-radius: 10px;
            padding: 8px 18px;
            transition: all .2s;
        }
        .btn-emerald-outline:hover {
            background: var(--em-100);
            color: var(--em-800);
            border-color: var(--em-400);
        }

        /* ══════════════════════════════════════════
           BADGES & STATUS PILLS
        ══════════════════════════════════════════ */
        .pill {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: .75rem; font-weight: 700;
            padding: 3px 10px; border-radius: 50px;
        }
        .pill-success { background: var(--em-50);  color: var(--em-700); border: 1px solid var(--em-100); }
        .pill-warning { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .pill-danger  { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
        .pill-info    { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

        /* ══════════════════════════════════════════
           TOAST CONTAINER
        ══════════════════════════════════════════ */
        #toastContainer {
            position: fixed;
            bottom: 28px;
            inset-inline-end: 28px;
            z-index: 1100;
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-width: 300px;
        }

        /* ══════════════════════════════════════════
           SKELETON LOADER
        ══════════════════════════════════════════ */
        .skeleton-row {
            height: 16px;
            border-radius: 8px;
            background: #e2e8f0;
            animation: shimmer 1.5s infinite linear;
            background-image: linear-gradient(
                90deg,
                #e2e8f0 25%,
                #f1f5f9 50%,
                #e2e8f0 75%
            );
            background-size: 200% 100%;
        }
        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* ══════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════ */
        @media (max-width: 991.98px) {
            .admin-main-content { padding: 16px; }
        }
        @media (max-width: 575.98px) {
            .admin-main-content { padding: 12px; }
            .admin-card { border-radius: 14px; }
        }

        /* ── Utility: hide scrollbar but keep scroll ── */
        .scroll-thin { scrollbar-width: thin; scrollbar-color: rgba(0,0,0,.1) transparent; }
        .scroll-thin::-webkit-scrollbar { width: 5px; }
        .scroll-thin::-webkit-scrollbar-thumb { background: rgba(0,0,0,.1); border-radius: 3px; }

        /* ══════════════════════════════════════════
           PAGE HEADER  (.ph-*)
        ══════════════════════════════════════════ */
        .ph-wrap {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .ph-title-group { display: flex; align-items: center; gap: 12px; }
        .ph-icon-wrap {
            width: 44px; height: 44px; border-radius: 13px;
            background: var(--em-50); border: 1.5px solid var(--em-100);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .ph-icon-wrap i { color: var(--em-600); font-size: 1.05rem; }
        .ph-title  { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.3; }
        .ph-subtitle { font-size: .79rem; color: #94a3b8; font-weight: 500; margin: 2px 0 0; }
        .ph-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

        /* ══════════════════════════════════════════
           TABLE AVATARS & ICON BUTTONS
        ══════════════════════════════════════════ */
        .tbl-avatar {
            width: 36px; height: 36px; border-radius: 10px;
            overflow: hidden; flex-shrink: 0;
            background: var(--em-50); border: 1.5px solid var(--em-100);
            display: flex; align-items: center; justify-content: center;
        }
        .tbl-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .tbl-avatar-initials { font-size: .8rem; font-weight: 800; color: var(--em-700); }

        /* Small icon action buttons in table rows */
        .btn-icon {
            width: 30px; height: 30px; border-radius: 8px;
            border: none; cursor: pointer;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: .78rem;
            transition: all .18s ease;
            text-decoration: none; flex-shrink: 0;
        }
        .btn-icon:focus-visible { outline: 2px solid var(--em-400); outline-offset: 2px; }
        .btn-icon-info    { background: #eff6ff; color: #1d4ed8; }
        .btn-icon-warning { background: #fffbeb; color: #b45309; }
        .btn-icon-danger  { background: #fff1f2; color: #be123c; }
        .btn-icon-success { background: var(--em-50); color: var(--em-700); }
        .btn-icon-gray    { background: #f1f5f9; color: #475569; }

        .btn-icon-info:hover    { background: #1d4ed8; color: white; }
        .btn-icon-warning:hover { background: #b45309; color: white; }
        .btn-icon-danger:hover  { background: #be123c; color: white; }
        .btn-icon-success:hover { background: var(--em-600); color: white; }
        .btn-icon-gray:hover    { background: #475569; color: white; }

        /* ══════════════════════════════════════════
           SEARCH INPUT & CARD HEADER CONTROLS
        ══════════════════════════════════════════ */
        .ip-search-wrap { position: relative; display: flex; align-items: center; }
        .ip-search-icon {
            position: absolute;
            inset-inline-start: 12px;
            color: #94a3b8; font-size: .78rem;
            pointer-events: none; z-index: 2;
        }
        .ip-search {
            padding-inline-start: 32px !important;
            width: 220px; height: 36px;
            font-size: .85rem !important;
            border-radius: 10px !important;
        }
        .ip-per-page {
            width: 75px !important; height: 36px !important;
            font-size: .82rem !important;
            border-radius: 10px !important;
            padding: 4px 8px !important;
        }
        .ip-filter-btn {
            height: 36px;
            border-radius: 10px !important;
            font-size: .82rem !important;
            font-family: 'Cairo', sans-serif !important;
            font-weight: 600 !important;
        }
        @media (max-width: 575px) { .ip-search { width: 100%; } }

        /* ══════════════════════════════════════════
           EXPANDED FILTER ROW
        ══════════════════════════════════════════ */
        .ip-filters-row {
            border-bottom: 1px solid var(--border);
            background: #f8fafc;
            transition: max-height .25s ease;
        }

        /* ══════════════════════════════════════════
           PAGINATION BAR
        ══════════════════════════════════════════ */
        .ip-pagination-wrap {
            display: flex; align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid #f1f5f9;
            flex-wrap: wrap; gap: 12px;
        }
        .ip-pagination-wrap .pagination { margin: 0; }
        .ip-pagination-wrap .page-link {
            font-family: 'Cairo', sans-serif;
            font-size: .82rem; color: #475569;
            border-color: var(--border);
            padding: 5px 11px;
            border-radius: 8px !important;
            margin: 0 2px;
            transition: all .15s;
        }
        .ip-pagination-wrap .page-item.active .page-link {
            background: var(--em-600);
            border-color: var(--em-600);
            color: white;
            box-shadow: 0 4px 10px rgba(5,150,105,.25);
        }
        .ip-pagination-wrap .page-link:hover:not(.active) {
            background: var(--em-50);
            color: var(--em-700);
            border-color: var(--em-200);
        }
        .ip-pagination-wrap .page-link:focus {
            box-shadow: 0 0 0 3px rgba(16,185,129,.15);
        }
        .ip-pagination-info { font-size: .8rem; color: #94a3b8; }

        /* ══════════════════════════════════════════
           FORM SECTION BLOCKS  (.form-section-*)
        ══════════════════════════════════════════ */
        .form-section {
            padding: 24px 28px;
            border-bottom: 1px solid var(--border);
        }
        .form-section:last-of-type { border-bottom: none; }

        .form-section-header {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 22px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #e8edf2;
        }
        .form-section-icon {
            width: 34px; height: 34px; border-radius: 9px;
            background: var(--em-50); border: 1px solid var(--em-100);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .form-section-icon i { color: var(--em-600); font-size: .82rem; }
        .form-section-title   { font-size: .92rem; font-weight: 800; color: #0f172a; margin: 0; }
        .form-section-subtitle { font-size: .76rem; color: #94a3b8; margin: 1px 0 0; }

        /* Helper / hint text under inputs */
        .form-hint { font-size: .76rem; color: #94a3b8; margin-top: 5px; display: block; }

        /* Character counter */
        .char-counter { font-size: .73rem; color: #94a3b8; text-align: end; display: block; margin-top: 4px; }

        /* Form card footer (submit / cancel row) */
        .form-footer {
            display: flex; align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding: 18px 28px;
            border-top: 1px solid var(--border);
            background: #fafcff;
            border-radius: 0 0 18px 18px;
            flex-wrap: wrap;
        }

        /* ── File / image upload zone ── */
        .upload-zone {
            border: 2px dashed var(--border);
            border-radius: 14px;
            padding: 28px 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color .2s, background .2s;
            background: #fafcff;
            position: relative;
        }
        .upload-zone:hover, .upload-zone.dragover {
            border-color: var(--em-400);
            background: var(--em-50);
        }
        .upload-zone input[type="file"] {
            position: absolute; inset: 0; opacity: 0;
            cursor: pointer; width: 100%; height: 100%;
        }
        .upload-zone-icon { font-size: 2rem; color: var(--em-300); margin-bottom: 10px; }
        .upload-zone-text { font-size: .85rem; color: #64748b; font-weight: 600; }
        .upload-zone-hint { font-size: .74rem; color: #94a3b8; margin-top: 4px; }

        /* Image preview thumbnail */
        .img-preview-wrap {
            position: relative; display: inline-block;
        }
        .img-preview {
            width: 80px; height: 80px; border-radius: 14px;
            object-fit: cover; border: 2px solid var(--em-100);
        }
        .img-preview-remove {
            position: absolute; top: -6px; inset-inline-end: -6px;
            width: 20px; height: 20px; border-radius: 50%;
            background: #ef4444; color: white; border: none;
            font-size: .6rem; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
        }

        /* ══════════════════════════════════════════
           SHOW / PROFILE PAGE  (.profile-*)
        ══════════════════════════════════════════ */
        .profile-hero {
            background: linear-gradient(135deg, var(--em-800) 0%, var(--em-600) 100%);
            border-radius: 18px 18px 0 0;
            padding: 32px 28px 22px;
            position: relative;
            overflow: hidden;
        }
        .profile-hero::before {
            content: '';
            position: absolute; top: -50px; inset-inline-end: -50px;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(255,255,255,.06); pointer-events: none;
        }
        .profile-hero::after {
            content: '';
            position: absolute; bottom: -70px; inset-inline-start: -40px;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(255,255,255,.04); pointer-events: none;
        }
        .profile-avatar {
            width: 80px; height: 80px; border-radius: 20px;
            border: 3px solid rgba(255,255,255,.4);
            object-fit: cover;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; font-weight: 800; color: white;
            flex-shrink: 0; overflow: hidden;
            background: var(--em-700);
        }
        .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .profile-hero-name { font-size: 1.2rem; font-weight: 800; color: white; margin: 0; }
        .profile-hero-sub  { font-size: .82rem; color: rgba(255,255,255,.7); margin: 3px 0 0; }

        /* Quick-stats bar below hero */
        .profile-stats-bar {
            background: white;
            border: 1px solid var(--border);
            border-top: none;
            border-radius: 0 0 18px 18px;
            display: flex; flex-wrap: wrap;
        }
        .profile-stat-item {
            flex: 1; min-width: 110px;
            padding: 16px 20px;
            border-inline-end: 1px solid var(--border);
            text-align: center;
        }
        .profile-stat-item:last-child { border-inline-end: none; }
        .profile-stat-value { font-size: 1.3rem; font-weight: 800; color: #0f172a; line-height: 1; }
        .profile-stat-label { font-size: .73rem; color: #94a3b8; font-weight: 600; margin-top: 4px; }

        /* Info key-value pairs in show cards */
        .info-item { margin-bottom: 18px; }
        .info-item:last-child { margin-bottom: 0; }
        .info-label {
            font-size: .72rem; font-weight: 700; color: #94a3b8;
            text-transform: uppercase; letter-spacing: .5px;
            margin-bottom: 3px;
        }
        .info-value { font-size: .9rem; font-weight: 600; color: #1e293b; }
        .info-value.empty { color: #cbd5e1; font-style: italic; }

        /* Tab-style switcher on show page */
        .profile-tabs {
            display: flex; gap: 4px;
            background: #f1f5f9;
            border-radius: 12px; padding: 4px;
            flex-wrap: wrap;
        }
        .profile-tab-btn {
            padding: 7px 18px; border-radius: 9px;
            font-family: 'Cairo', sans-serif;
            font-size: .83rem; font-weight: 700;
            border: none; cursor: pointer;
            color: #64748b; background: transparent;
            transition: all .2s;
        }
        .profile-tab-btn.active {
            background: white;
            color: var(--em-700);
            box-shadow: 0 1px 6px rgba(0,0,0,.08);
        }
    </style>

    @yield('css')
</head>
<body>

    {{-- ══ شريط معاينة منشئ المنصة (يظهر فقط أثناء جلسة Impersonation) ══ --}}
    @include('layouts.partials.impersonation-banner')

    {{-- ══ SIDEBAR — Offcanvas (always visible on desktop, slide-in on mobile) ══ --}}
    <div class="offcanvas offcanvas-start"
         id="adminSidebar"
         data-bs-backdrop="false"
         tabindex="-1"
         aria-labelledby="adminSidebarLabel">

        @if (auth('web')->check())
            @include('layouts.main-sidebar.admin-main-sidebar')
        @elseif (auth('student')->check())
            @include('layouts.main-sidebar.student-main-sidebar')
        @elseif (auth('teacher')->check())
            @include('layouts.main-sidebar.teacher-main-sidebar')
        @elseif (auth('parent')->check())
            @include('layouts.main-sidebar.parent-main-sidebar')
        @endif

    </div>

    {{-- ══ HEADER ══ --}}
    @include('layouts.main-header')

    {{-- ══ TOAST CONTAINER ══ --}}
    @include('layouts.partials.toast-container')

    {{-- ══ CONFIRM MODAL ══ --}}
    @include('layouts.partials.confirm-modal')

    {{-- ══ MAIN CONTENT ══ --}}
    <div class="admin-main-content">

        {{-- Breadcrumb --}}
        @hasSection('PageTitle')
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb admin-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/dashboard') }}">
                            <i class="fas fa-house me-1"></i>{{ trans('main_trans.breadcrumb_home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @yield('PageTitle')
                    </li>
                </ol>
            </nav>
        @endif

        @yield('page-header')

        {{-- Page content --}}
        @yield('content')

        {{-- Footer --}}
        @include('layouts.footer')

    </div>{{-- /.admin-main-content --}}

    {{-- ══ SCRIPTS ══ --}}

    {{-- 1. jQuery --}}
    <script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>

    {{-- 2. plugin_path for loadScript() calls inside custom.js --}}
    <script>var plugin_path = '{{ asset('assets/js') }}/';</script>

    {{-- 3. Legacy plugins INCLUDING Bootstrap 4 — loaded BEFORE Bootstrap 5 so that
         Bootstrap 4's document-level event listeners register first. Bootstrap 5's
         listeners register second and take precedence for data-bs-* selectors,
         while Bootstrap 4 keeps handling its own data-toggle="*" elements. --}}
    <script src="{{ URL::asset('assets/js/plugins-jquery.js') }}"></script>

    {{-- 4. Bootstrap 5 Bundle (Popper 2 bundled) — loaded AFTER Bootstrap 4 so that
         BS5's document event handlers fire last and win for data-bs-* attributes. --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @livewireScripts

    {{-- 5. Remaining legacy plugins --}}
    <script src="{{ URL::asset('assets/js/calendar.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/sweetalert2.js') }}"></script>
    <script src="{{ URL::asset('assets/js/toastr.js') }}"></script>

    {{-- 6. custom.js — includes POTENZA.Fullscreenwindow() which binds #btnFullscreen.
         We do NOT add a second fullscreen listener below to avoid double-firing. --}}
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>

    {{-- Global admin scripts --}}
    <script>
    (function () {
        'use strict';

        // NOTE: fullscreen is handled by POTENZA.Fullscreenwindow() in custom.js above.

        // يملأ قائمة منسدلة (select) ببيانات قادمة من AJAX، ويضمن وجود خيار مرئي دائماً
        // (سواء "اختر..." أو "لا توجد نتائج") بدلاً من ترك القائمة بلا أي خيارات على الإطلاق،
        // وهي الحالة التي تبدو للمستخدم كأن القائمة "لا تظهر" بينما هي فعلياً فارغة من الداخل.
        function fillCascadeSelect($select, data, emptyLabel) {
            $select.empty();

            const hasData = data && Object.keys(data).length > 0;

            $select.append($('<option>', { value: '', selected: true, disabled: true })
                .text(hasData ? '{{ trans('Parent_trans.Choose') }}...' : emptyLabel));

            $.each(data || {}, function (key, val) {
                $select.append($('<option>', { value: key, text: val }));
            });
        }

        // ── Grade → Classroom AJAX ──
        function bindCascade(gradeField, classroomField) {
            $(gradeField).on('change', function () {
                const id = $(this).val();
                if (!id) return;
                $.getJSON('{{ URL::to("Get_classrooms") }}/' + id, function (data) {
                    fillCascadeSelect($(classroomField), data, 'لا توجد فصول مضافة لهذا الصف بعد');
                });
            });
        }

        // ── Classroom → Section AJAX ──
        function bindSection(classroomField, sectionField) {
            $(classroomField).on('change', function () {
                const id = $(this).val();
                if (!id) return;
                $.getJSON('{{ URL::to("Get_Sections") }}/' + id, function (data) {
                    fillCascadeSelect($(sectionField), data, 'لا توجد شعب مضافة لهذا الفصل بعد');
                });
            });
        }

        $(function () {
            bindCascade('[name="Grade_id"]',     '[name="Classroom_id"]');
            bindCascade('[name="Grade_id_new"]', '[name="Classroom_id_new"]');
            bindSection('[name="Classroom_id"]',     '[name="section_id"]');
            bindSection('[name="Classroom_id_new"]', '[name="section_id_new"]');
        });

        // ── CheckAll helper ──
        window.CheckAll = function (className, elem) {
            document.querySelectorAll('.' + className)
                    .forEach(el => el.checked = elem.checked);
        };

        // ── Flash toast from session ──
        @if (session('success'))
            window.dispatchEvent(new CustomEvent('show-toast', {
                detail: { type: 'success', message: @json(session('success')) }
            }));
        @endif
        @if (session('error'))
            window.dispatchEvent(new CustomEvent('show-toast', {
                detail: { type: 'error', message: @json(session('error')) }
            }));
        @endif

    })();
    </script>

    @yield('js')

</body>
</html>
