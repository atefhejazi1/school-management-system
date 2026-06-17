<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', __('super_dash.platform_name'))</title>

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

    @livewireStyles

    {{-- ══════════════════════════════════════════
         PLATFORM (SUPER ADMIN) THEME — Light Gray / Emerald
         خلفية فاتحة بالكامل (شريط جانبي + رؤوس صفحات) لتمييز
         سياق "منشئ المنصة" بوضوح عن لوحة تحكم المدرسة (الغامقة).
         جميع القيم الاتجاهية منطقية (logical) لدعم RTL/LTR تلقائياً.
    ══════════════════════════════════════════ --}}
    <style>
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

        /* ══ SIDEBAR — light gray theme ══ */
        #superAdminSidebar {
            width: var(--sb-w) !important;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%) !important;
            border-inline-end: 1px solid var(--border) !important;
            display: flex;
            flex-direction: column;
        }

        @media (min-width: 992px) {
            #superAdminSidebar {
                position: fixed !important;
                top: 0 !important;
                bottom: 0 !important;
                inset-inline-start: 0 !important;
                transform: none !important;
                visibility: visible !important;
                z-index: 1030 !important;
                box-shadow: 0 0 24px rgba(0,0,0,.04) !important;
            }
            .offcanvas-backdrop { display: none !important; }
            .admin-main-content { margin-inline-start: var(--sb-w); }
            .admin-header { inset-inline-start: var(--sb-w) !important; }
        }

        /* ══ HEADER ══ */
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
            overflow: visible !important;
        }
        .admin-header .dropdown-menu { z-index: 1035 !important; }
        .admin-header::before {
            content: '';
            position: absolute;
            top: 0;
            inset-inline-start: 0;
            inset-inline-end: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--em-700) 0%, var(--em-600) 25%, var(--em-500) 55%, var(--em-400) 80%, var(--em-300) 100%);
        }

        .hd-toggle {
            width: 38px; height: 38px; border-radius: 10px;
            background: #f8fafc; border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: #64748b; font-size: 16px; cursor: pointer;
            transition: all .2s ease; flex-shrink: 0;
        }
        .hd-toggle:hover { background: var(--em-50); color: var(--em-600); border-color: var(--em-100); }
        .hd-sep { width: 1px; height: 28px; background: var(--border); flex-shrink: 0; }

        .hd-lang-btn {
            display: flex; align-items: center; gap: 6px; height: 36px;
            background: #f8fafc; border: 1px solid var(--border); border-radius: 10px;
            font-family: 'Cairo', sans-serif; font-size: 12px; font-weight: 600; color: #374151;
            padding: 0 12px; cursor: pointer; transition: all .2s;
        }
        .hd-lang-btn::after { display: none; }
        .hd-lang-btn:hover { border-color: var(--em-500); color: var(--em-700); background: var(--em-50); }
        .hd-caret { font-size: 9px; opacity: .6; }
        .hd-lang-menu { border: 1px solid var(--border) !important; border-radius: 14px !important; box-shadow: 0 10px 30px rgba(0,0,0,.1) !important; padding: 6px !important; min-width: 150px !important; }
        .hd-lang-item { border-radius: 8px !important; font-family: 'Cairo', sans-serif !important; font-size: 13px !important; font-weight: 600 !important; padding: 9px 12px !important; display: flex !important; align-items: center !important; gap: 8px !important; transition: background .15s !important; }
        .hd-lang-item:hover { background: #f1f5f9 !important; }
        .hd-lang-active { color: var(--em-700) !important; background: var(--em-50) !important; }

        .hd-user-btn { display: flex; align-items: center; gap: 10px; background: transparent; border: none; border-radius: 12px; padding: 5px 10px; cursor: pointer; transition: background .2s; height: 50px; }
        .hd-user-btn::after { display: none; }
        .hd-user-btn:hover { background: #f1f5f9; }
        .hd-avatar { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, var(--em-600), var(--em-800)); display: flex; align-items: center; justify-content: center; font-size: 15px; color: white; font-weight: 800; font-family: 'Cairo', sans-serif; flex-shrink: 0; box-shadow: 0 3px 10px rgba(5,150,105,.35); }
        .hd-user-info { text-align: end; }
        .hd-user-name { font-family: 'Cairo', sans-serif; font-size: 12.5px; font-weight: 700; color: #1e293b; display: block; white-space: nowrap; }
        .hd-user-role { font-size: 10.5px; color: #94a3b8; display: block; }
        .hd-user-menu { width: 220px; border: 1px solid var(--border) !important; border-radius: 14px !important; box-shadow: 0 14px 36px rgba(0,0,0,.1) !important; padding: 6px !important; }
        .hd-menu-item { border-radius: 8px !important; font-family: 'Cairo', sans-serif !important; font-size: 13px !important; font-weight: 600 !important; padding: 10px 14px !important; display: flex !important; align-items: center !important; gap: 10px !important; transition: background .15s !important; width: 100%; border: none; background: none; cursor: pointer; text-align: start !important; }
        .hd-menu-item i { width: 16px; text-align: center; color: #64748b; }
        .hd-menu-item:hover { background: #f1f5f9 !important; }
        .hd-logout-item { color: #ef4444 !important; }
        .hd-logout-item i { color: #ef4444 !important; }
        .hd-logout-item:hover { background: #fff1f2 !important; }

        /* ══ MAIN CONTENT ══ */
        .admin-main-content { margin-top: var(--hdr-h); min-height: calc(100vh - var(--hdr-h)); padding: 24px; }

        /* ══ CARD ══ */
        .admin-card { background: var(--card-bg); border-radius: 18px; border: 1px solid var(--border); box-shadow: 0 2px 16px rgba(0,0,0,.05); }
        .admin-card-header { padding: 16px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
        .admin-card-title { font-size: .95rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 9px; }
        .admin-card-title i { color: var(--em-600); font-size: 1rem; }

        /* ══ BREADCRUMB ══ */
        .admin-breadcrumb { background: transparent; padding: 0; margin-bottom: 18px; font-size: .82rem; }
        .admin-breadcrumb .breadcrumb-item a { color: var(--em-600); font-weight: 600; text-decoration: none; }
        .admin-breadcrumb .breadcrumb-item a:hover { color: var(--em-700); }
        .admin-breadcrumb .breadcrumb-item.active { color: #64748b; font-weight: 600; }
        .admin-breadcrumb .breadcrumb-item + .breadcrumb-item::before { color: #cbd5e1; }

        /* ══ TABLES ══ */
        .table-responsive { border-radius: 12px; overflow: hidden; }
        .admin-table { font-size: .88rem; margin: 0; }
        .admin-table thead th { background: #f8fafc; color: #64748b; font-weight: 700; font-size: .78rem; text-transform: uppercase; letter-spacing: .4px; padding: 13px 16px; border-bottom: 2px solid var(--border); white-space: nowrap; }
        .admin-table tbody td { padding: 13px 16px; vertical-align: middle; border-bottom: 1px solid #f8fafc; color: #374151; }
        .admin-table tbody tr:hover { background: #f9fafb; }
        .admin-table tbody tr:last-child td { border-bottom: none; }

        /* ══ FORMS ══ */
        .form-control, .form-select { font-family: 'Cairo', sans-serif; font-size: .9rem; border-radius: 10px; border-color: var(--border); padding: 10px 14px; }
        .form-control:focus, .form-select:focus { border-color: var(--em-500); box-shadow: 0 0 0 3px rgba(16,185,129,.12); }
        .form-label { font-weight: 700; font-size: .85rem; color: #374151; }

        /* ══ BUTTONS ══ */
        .btn-emerald { background: linear-gradient(135deg, var(--em-700), var(--em-600)); color: white; border: none; font-family: 'Cairo', sans-serif; font-weight: 700; border-radius: 10px; padding: 9px 20px; transition: all .25s ease; box-shadow: 0 4px 14px rgba(5,150,105,.3); }
        .btn-emerald:hover { background: linear-gradient(135deg, var(--em-800), var(--em-700)); color: white; transform: translateY(-2px); box-shadow: 0 8px 22px rgba(5,150,105,.4); }
        .btn-emerald-outline { background: var(--em-50); color: var(--em-700); border: 1.5px solid var(--em-100); font-family: 'Cairo', sans-serif; font-weight: 700; border-radius: 10px; padding: 8px 18px; transition: all .2s; }
        .btn-emerald-outline:hover { background: var(--em-100); color: var(--em-800); border-color: var(--em-400); }

        /* ══ PILLS ══ */
        .pill { display: inline-flex; align-items: center; gap: 5px; font-size: .75rem; font-weight: 700; padding: 3px 10px; border-radius: 50px; }
        .pill-success { background: var(--em-50); color: var(--em-700); border: 1px solid var(--em-100); }
        .pill-warning { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .pill-danger  { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
        .pill-info    { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

        /* ══ PAGE HEADER (.ph-*) ══ */
        .ph-wrap { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 20px; flex-wrap: wrap; }
        .ph-title-group { display: flex; align-items: center; gap: 12px; }
        .ph-icon-wrap { width: 44px; height: 44px; border-radius: 13px; background: var(--em-50); border: 1.5px solid var(--em-100); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .ph-icon-wrap i { color: var(--em-600); font-size: 1.05rem; }
        .ph-title { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.3; }
        .ph-subtitle { font-size: .79rem; color: #94a3b8; font-weight: 500; margin: 2px 0 0; }
        .ph-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

        /* ══ STAT CARDS ══ */
        .pf-stat-card {
            background: var(--card-bg); border: 1px solid var(--border); border-radius: 16px;
            padding: 20px 22px; display: flex; align-items: center; gap: 16px;
            box-shadow: 0 2px 16px rgba(0,0,0,.04);
        }
        .pf-stat-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
        .pf-stat-value { font-size: 1.6rem; font-weight: 800; color: #0f172a; line-height: 1; }
        .pf-stat-label { font-size: .8rem; color: #94a3b8; font-weight: 600; margin-top: 4px; }

        /* ══ RESPONSIVE ══ */
        @media (max-width: 991.98px) { .admin-main-content { padding: 16px; } }
        @media (max-width: 575.98px) { .admin-main-content { padding: 12px; } .admin-card { border-radius: 14px; } }
    </style>

    @yield('css')
</head>
<body>

    {{-- ══ SIDEBAR — Offcanvas (always visible on desktop, slide-in on mobile) ══ --}}
    <div class="offcanvas offcanvas-start"
         id="superAdminSidebar"
         data-bs-backdrop="false"
         tabindex="-1"
         aria-labelledby="superAdminSidebarLabel">
        @include('layouts.super-admin.sidebar')
    </div>

    {{-- ══ HEADER ══ --}}
    @include('layouts.super-admin.header')

    {{-- ══ TOAST CONTAINER ══ --}}
    @include('layouts.partials.toast-container')

    {{-- ══ CONFIRM MODAL ══ --}}
    @include('layouts.partials.confirm-modal')

    {{-- ══ MAIN CONTENT ══ --}}
    <div class="admin-main-content">

        @hasSection('PageTitle')
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb admin-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('super-admin.dashboard') }}">
                            <i class="fas fa-house me-1"></i>{{ __('super_dash.dashboard') }}
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

        @include('layouts.footer')

    </div>{{-- /.admin-main-content --}}

    {{-- ══ SCRIPTS ══ --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @livewireScripts

    @yield('js')

</body>
</html>
