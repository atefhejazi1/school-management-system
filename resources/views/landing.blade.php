<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('landing_trans.meta_title') }}</title>
    <meta name="description" content="{{ trans('landing_trans.meta_description') }}">

    {{-- Cairo Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 — RTL or LTR --}}
    @if (LaravelLocalization::getCurrentLocaleDirection() === 'rtl')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @endif

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @livewireStyles

    <style>
        /* ══════════════════════════════════════════
           BASE
        ══════════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Cairo', sans-serif;
            background: #ffffff;
            color: #1e293b;
            overflow-x: hidden;
        }
        a { text-decoration: none; }

        /* ══════════════════════════════════════════
           NAVBAR
        ══════════════════════════════════════════ */
        #mainNav {
            transition: background .35s ease, box-shadow .35s ease, padding .35s ease;
            padding-top: 20px;
            padding-bottom: 20px;
            z-index: 1050;
        }
        #mainNav.scrolled {
            background: rgba(15, 23, 42, 0.97) !important;
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 24px rgba(0,0,0,.25);
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .nav-brand-icon {
            width: 42px; height: 42px; border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: white; flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(37,99,235,.4);
        }
        .nav-brand-text { font-size: 1.05rem; font-weight: 800; color: #0f172a; line-height: 1.1; transition: color .3s ease; }
        .nav-brand-sub  { font-size: .68rem; font-weight: 500; color: #64748b; transition: color .3s ease; }
        #mainNav.scrolled .nav-brand-text { color: white; }
        #mainNav.scrolled .nav-brand-sub  { color: rgba(255,255,255,.5); }

        .navbar-nav .nav-link {
            color: rgba(15,23,42,.7) !important;
            font-weight: 600; font-size: .9rem;
            padding: 6px 14px !important;
            border-radius: 8px;
            transition: color .2s, background .2s;
        }
        .navbar-nav .nav-link:hover {
            color: #0f172a !important;
            background: rgba(15,23,42,.06);
        }
        #mainNav.scrolled .navbar-nav .nav-link { color: rgba(255,255,255,.75) !important; }
        #mainNav.scrolled .navbar-nav .nav-link:hover {
            color: white !important;
            background: rgba(255,255,255,.1);
        }
        .btn-nav-login {
            background: rgba(15,23,42,.06);
            border: 1.5px solid rgba(15,23,42,.15);
            color: #0f172a !important;
            font-weight: 700; font-size: .88rem;
            padding: 8px 22px; border-radius: 10px;
            transition: all .25s ease;
        }
        .btn-nav-login:hover {
            background: #0f172a !important;
            color: white !important;
            border-color: #0f172a;
        }
        #mainNav.scrolled .btn-nav-login {
            background: rgba(255,255,255,.12);
            border-color: rgba(255,255,255,.25);
            color: white !important;
        }
        #mainNav.scrolled .btn-nav-login:hover {
            background: white !important;
            color: #1e3a8a !important;
            border-color: white;
        }
        .btn-lang-toggle {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(15,23,42,.06); border: 1.5px solid rgba(15,23,42,.15);
            color: #0f172a; font-weight: 700; font-size: .82rem;
            padding: 7px 16px; border-radius: 10px;
            transition: all .25s ease; cursor: pointer;
        }
        .btn-lang-toggle:hover { background: rgba(15,23,42,.12); }
        #mainNav.scrolled .btn-lang-toggle {
            background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.25); color: white;
        }
        #mainNav.scrolled .btn-lang-toggle:hover { background: rgba(255,255,255,.2); }
        .navbar-toggler { border: 1.5px solid rgba(15,23,42,.2); border-radius: 8px; padding: 6px 10px; }
        #mainNav.scrolled .navbar-toggler { border-color: rgba(255,255,255,.3); }
        #mainNav.scrolled .navbar-toggler-icon { filter: invert(1); }

        /* ══════════════════════════════════════════
           HERO
        ══════════════════════════════════════════ */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(160deg, #f8fafc 0%, #eef2ff 50%, #e0e7ff 100%);
            display: flex; flex-direction: column; justify-content: center;
            position: relative; overflow: hidden;
            padding-top: 100px; padding-bottom: 80px;
        }

        .hero-content { position: relative; z-index: 2; }

        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            background: white; border: 1px solid #dbeafe;
            color: #1e3a8a; font-size: .8rem; font-weight: 700;
            padding: 5px 16px; border-radius: 50px; margin-bottom: 24px;
            letter-spacing: .5px;
            box-shadow: 0 4px 14px rgba(15,23,42,.05);
        }
        .hero-eyebrow .dot { width: 7px; height: 7px; background: #22c55e; border-radius: 50%; animation: dotPulse 2s ease-in-out infinite; }
        @keyframes dotPulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.85)} }

        .hero-title {
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 900; color: #0f172a; line-height: 1.15; margin-bottom: 20px;
        }
        .hero-title .highlight {
            background: linear-gradient(90deg, #2563eb, #7c3aed, #059669);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.15rem; color: #475569;
            font-weight: 400; line-height: 1.75; max-width: 580px; margin-bottom: 38px;
        }

        .hero-btns { display: flex; flex-wrap: wrap; gap: 14px; margin-bottom: 52px; }
        .btn-hero-primary {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: white; font-weight: 700; font-size: 1rem;
            padding: 14px 34px; border-radius: 14px; border: none;
            box-shadow: 0 8px 28px rgba(37,99,235,.25);
            transition: all .3s ease;
        }
        .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(37,99,235,.35); color: white; }
        .btn-hero-outline {
            background: white; border: 1.5px solid #dbeafe;
            color: #0f172a; font-weight: 700; font-size: 1rem;
            padding: 14px 34px; border-radius: 14px;
            transition: all .3s ease;
        }
        .btn-hero-outline:hover { background: #f8fafc; border-color: #c7d9ff; color: #0f172a; transform: translateY(-3px); }

        .hero-stats { display: flex; flex-wrap: wrap; gap: 10px; }
        .stat-pill {
            display: flex; align-items: center; gap: 10px;
            background: white; border: 1px solid #e2e8f0;
            border-radius: 14px; padding: 12px 20px;
            box-shadow: 0 4px 14px rgba(15,23,42,.04);
            transition: transform .25s, box-shadow .25s;
        }
        .stat-pill:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(15,23,42,.08); }
        .stat-num { font-size: 1.5rem; font-weight: 900; color: #0f172a; line-height: 1; }
        .stat-label { font-size: .78rem; color: #64748b; font-weight: 500; }

        .hero-visual { position: relative; z-index: 2; }
        .hero-panel {
            background: white; border: 1px solid #e2e8f0;
            border-radius: 20px; padding: 26px 28px;
            box-shadow: 0 24px 60px rgba(15,23,42,.1);
        }
        .hero-panel-head {
            display: flex; align-items: center; justify-content: space-between;
            padding-bottom: 18px; margin-bottom: 18px;
            border-bottom: 1px solid #f1f5f9;
        }
        .hero-panel-title { font-size: .92rem; font-weight: 700; color: #0f172a; }
        .hero-panel-live {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: .72rem; font-weight: 700; color: #16a34a;
        }
        .hero-panel-live .dot { width: 6px; height: 6px; background: #22c55e; border-radius: 50%; animation: dotPulse 2s ease-in-out infinite; }

        .hero-stat-row {
            display: flex; align-items: center; gap: 14px;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .hero-stat-row:last-child { border-bottom: none; padding-bottom: 0; }
        .hero-stat-row-icon {
            width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
            background: linear-gradient(135deg, #eff6ff, #e0e7ff);
            display: flex; align-items: center; justify-content: center;
            color: #2563eb; font-size: .95rem;
        }
        .hero-stat-row-num { font-size: 1.25rem; font-weight: 900; color: #0f172a; line-height: 1; }
        .hero-stat-row-label { font-size: .78rem; color: #64748b; }

        .hero-panel-bar { margin-top: 6px; display: flex; gap: 4px; height: 6px; }
        .hero-panel-bar span { border-radius: 3px; display: block; }

        /* ══════════════════════════════════════════
           SECTION HEADER
        ══════════════════════════════════════════ */
        .section-tag {
            display: inline-block; font-size: .75rem; font-weight: 800;
            letter-spacing: 1.5px; text-transform: uppercase;
            color: #2563eb; background: #eff6ff; border: 1px solid #bfdbfe;
            padding: 4px 14px; border-radius: 50px; margin-bottom: 14px;
        }
        .section-title {
            font-size: clamp(1.7rem, 3.5vw, 2.4rem);
            font-weight: 900; color: #0f172a; line-height: 1.25; margin-bottom: 14px;
        }
        .section-sub {
            font-size: 1.05rem; color: #64748b; font-weight: 400; max-width: 620px; margin: 0 auto;
        }

        /* ══════════════════════════════════════════
           FEATURES
        ══════════════════════════════════════════ */
        .features-section { padding: 96px 0; background: #f8fafc; }

        .feat-card {
            background: white; border-radius: 20px;
            border: 1px solid #e2e8f0;
            padding: 28px 24px; height: 100%;
            transition: transform .35s cubic-bezier(.22,.68,0,1.2), box-shadow .35s ease, border-color .25s;
            position: relative; overflow: hidden;
        }
        .feat-card::before {
            content: '';
            position: absolute; top: 0; right: 0; left: 0; height: 3px;
            background: linear-gradient(90deg, #2563eb, #7c3aed);
            transform: scaleX(0); transform-origin: right;
            transition: transform .35s ease;
        }
        .feat-card:hover { transform: translateY(-8px); box-shadow: 0 24px 60px rgba(0,0,0,.10); border-color: #c7d9ff; }
        .feat-card:hover::before { transform: scaleX(1); }

        .feat-icon {
            width: 56px; height: 56px; border-radius: 16px;
            background: linear-gradient(135deg, #eff6ff, #e0e7ff);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: #2563eb; margin-bottom: 18px;
            transition: transform .3s ease;
        }
        .feat-card:hover .feat-icon { transform: scale(1.1) rotate(-5deg); }

        .feat-title { font-size: 1rem; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
        .feat-desc  { font-size: .85rem; color: #64748b; line-height: 1.7; }

        /* ══════════════════════════════════════════
           DASHBOARD PREVIEW
        ══════════════════════════════════════════ */
        .dash-section { padding: 96px 0; background: white; }

        .dash-window {
            background: #f1f5f9;
            border-radius: 22px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 30px 80px rgba(15,23,42,.14);
            overflow: hidden;
        }
        .dash-window-bar {
            display: flex; align-items: center; gap: 14px;
            background: #e2e8f0; padding: 12px 18px;
        }
        .dash-dots { display: flex; gap: 6px; }
        .dash-dots span { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
        .dash-dots span:nth-child(1) { background: #f87171; }
        .dash-dots span:nth-child(2) { background: #fbbf24; }
        .dash-dots span:nth-child(3) { background: #34d399; }
        .dash-url {
            background: white; border-radius: 8px; padding: 5px 16px;
            font-size: .76rem; color: #64748b; font-weight: 600;
            display: inline-flex; align-items: center; gap: 6px;
        }

        .dash-window-body { display: flex; min-height: 460px; }

        .dash-sidebar-mini {
            width: 200px; background: #0f172a; padding: 22px 14px;
            flex-shrink: 0; display: none;
        }
        @media (min-width: 768px) { .dash-sidebar-mini { display: block; } }
        .dsm-brand { display: flex; align-items: center; gap: 10px; color: white; font-weight: 800; font-size: .85rem; margin-bottom: 26px; padding: 0 6px; }
        .dsm-item {
            display: flex; align-items: center; gap: 10px;
            color: rgba(255,255,255,.55); font-size: .8rem; font-weight: 600;
            padding: 10px 12px; border-radius: 10px; margin-bottom: 4px;
        }
        .dsm-item.active { background: linear-gradient(135deg, #2563eb, #7c3aed); color: white; }
        .dsm-item i { width: 18px; text-align: center; }

        .dash-main { flex: 1; padding: 26px 24px; background: #f8fafc; }

        .dash-stats-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; margin-bottom: 20px; }
        @media (min-width: 992px) { .dash-stats-row { grid-template-columns: repeat(4, 1fr); } }

        .dstat-card {
            background: white; border: 1px solid #e2e8f0; border-radius: 16px;
            padding: 16px 18px;
        }
        .dstat-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
        .dstat-icon {
            width: 36px; height: 36px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; font-size: .95rem; color: white;
        }
        .di-blue   { background: linear-gradient(135deg, #2563eb, #3b82f6); }
        .di-purple { background: linear-gradient(135deg, #7c3aed, #a78bfa); }
        .di-green  { background: linear-gradient(135deg, #059669, #34d399); }
        .di-amber  { background: linear-gradient(135deg, #d97706, #fbbf24); }
        .dstat-trend { font-size: .68rem; font-weight: 700; color: #059669; background: #f0fdf4; padding: 2px 8px; border-radius: 50px; }
        .dstat-num { font-size: 1.45rem; font-weight: 900; color: #0f172a; line-height: 1; margin-bottom: 4px; }
        .dstat-label { font-size: .76rem; color: #64748b; font-weight: 600; }

        .dash-panels-row { display: grid; grid-template-columns: 1fr; gap: 16px; }
        @media (min-width: 992px) { .dash-panels-row { grid-template-columns: 1.3fr 1fr; } }

        .dpanel-card { background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; }
        .dpanel-title { font-size: .85rem; font-weight: 800; color: #0f172a; margin-bottom: 16px; }

        .bar-chart { display: flex; align-items: flex-end; gap: 10px; height: 130px; }
        .bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; }
        .bar-fill { width: 100%; border-radius: 6px 6px 2px 2px; background: linear-gradient(180deg, #60a5fa, #2563eb); }
        .bar-day { font-size: .68rem; color: #94a3b8; font-weight: 700; }

        .activity-item { display: flex; align-items: flex-start; gap: 10px; padding: 10px 0; border-bottom: 1px solid #f1f5f9; }
        .activity-item:last-child { border-bottom: none; padding-bottom: 0; }
        .activity-dot {
            width: 30px; height: 30px; border-radius: 9px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: .8rem; color: white; margin-top: 2px;
        }
        .activity-text { font-size: .8rem; color: #334155; font-weight: 600; line-height: 1.5; }
        .activity-time { font-size: .68rem; color: #94a3b8; font-weight: 600; }

        /* ══════════════════════════════════════════
           ROLES
        ══════════════════════════════════════════ */
        .roles-section { padding: 96px 0; background: #f8fafc; }

        .role-card {
            border-radius: 20px; border: 1px solid #e2e8f0; background: white;
            padding: 32px 24px; text-align: center; height: 100%;
            transition: transform .3s ease, box-shadow .3s ease;
            position: relative; overflow: hidden;
        }
        .role-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(0,0,0,.09); }

        .role-card-admin   { border-top: 5px solid #2563eb; }
        .role-card-teacher { border-top: 5px solid #7c3aed; }
        .role-card-student { border-top: 5px solid #059669; }
        .role-card-parent  { border-top: 5px solid #d97706; }

        .role-avatar {
            width: 80px; height: 80px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.7rem; margin: 0 auto 18px;
        }
        .ra-admin   { background: linear-gradient(135deg, #eff6ff, #dbeafe); color: #2563eb; }
        .ra-teacher { background: linear-gradient(135deg, #f5f3ff, #ede9fe); color: #7c3aed; }
        .ra-student { background: linear-gradient(135deg, #f0fdf4, #dcfce7); color: #059669; }
        .ra-parent  { background: linear-gradient(135deg, #fffbeb, #fef3c7); color: #d97706; }

        .role-name { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 10px; }
        .role-desc { font-size: .85rem; color: #64748b; line-height: 1.65; }

        .role-badge {
            display: inline-block; font-size: .72rem; font-weight: 700;
            padding: 3px 12px; border-radius: 50px; margin-top: 14px;
        }
        .rb-admin   { background: #eff6ff; color: #1d4ed8; }
        .rb-teacher { background: #f5f3ff; color: #6d28d9; }
        .rb-student { background: #f0fdf4; color: #047857; }
        .rb-parent  { background: #fffbeb; color: #b45309; }

        /* ══════════════════════════════════════════
           SAAS / MULTI-SCHOOL
        ══════════════════════════════════════════ */
        .saas-section { padding: 96px 0; background: white; }

        .saas-check { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 18px; }
        .saas-check-icon {
            width: 30px; height: 30px; border-radius: 9px; flex-shrink: 0; margin-top: 2px;
            background: linear-gradient(135deg, #059669, #34d399);
            display: flex; align-items: center; justify-content: center; color: white; font-size: .78rem;
        }
        .saas-check-text { font-size: .92rem; color: #334155; font-weight: 600; line-height: 1.6; }

        .saas-diagram { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 24px; padding: 36px 24px; text-align: center; }
        .saas-platform-box {
            display: inline-flex; align-items: center; gap: 10px;
            background: linear-gradient(135deg, #0f172a, #1e293b); color: white;
            padding: 14px 26px; border-radius: 14px; font-weight: 800; font-size: .92rem;
            box-shadow: 0 12px 30px rgba(15,23,42,.25);
        }
        .saas-connector { width: 2px; height: 30px; background: #cbd5e1; margin: 0 auto; }
        .saas-tenants-row { display: flex; justify-content: center; gap: 14px; flex-wrap: wrap; margin-top: 4px; }
        .saas-tenant-box {
            background: white; border: 1.5px solid #e2e8f0; border-radius: 14px;
            padding: 14px 18px; min-width: 130px;
            box-shadow: 0 6px 18px rgba(0,0,0,.05);
        }
        .saas-tenant-icon { font-size: 1.2rem; color: #2563eb; margin-bottom: 6px; }
        .saas-tenant-name { font-size: .8rem; font-weight: 800; color: #0f172a; }
        .saas-tenant-sub  { font-size: .68rem; color: #94a3b8; font-weight: 600; }
        .saas-lock-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: #f0fdf4; border: 1px solid #bbf7d0; color: #047857;
            font-size: .78rem; font-weight: 700; padding: 6px 16px; border-radius: 50px; margin-top: 22px;
        }

        /* ══════════════════════════════════════════
           TECH STACK
        ══════════════════════════════════════════ */
        .tech-section { padding: 72px 0; background: #f1f5f9; }

        .tech-badge {
            display: inline-flex; align-items: center;
            background: white; border: 1.5px solid #e2e8f0;
            color: #334155; font-size: .88rem; font-weight: 700;
            padding: 10px 22px; border-radius: 50px;
            transition: all .25s ease; cursor: default;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }
        .tech-badge:hover { border-color: #2563eb; color: #2563eb; transform: translateY(-3px); box-shadow: 0 8px 22px rgba(37,99,235,.12); }

        /* ══════════════════════════════════════════
           REGISTRATION SECTION
        ══════════════════════════════════════════ */
        .register-section {
            padding: 96px 0;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #1a1f3c 100%);
            position: relative;
        }
        .register-section .section-tag  { color: #93c5fd; background: rgba(147,197,253,.1); border-color: rgba(147,197,253,.2); }
        .register-section .section-title { color: white; }
        .register-section .section-sub   { color: rgba(255,255,255,.55); }

        .reg-form-card {
            background: rgba(255,255,255,.97); border-radius: 24px;
            padding: 44px 40px;
            box-shadow: 0 40px 100px rgba(0,0,0,.3);
            position: relative; z-index: 2;
        }

        .reg-input {
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
            font-family: 'Cairo', sans-serif !important;
            font-size: .92rem !important;
            transition: border-color .2s, box-shadow .2s;
        }
        .reg-input:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 4px rgba(37,99,235,.08) !important;
        }
        .form-label { font-size: .88rem; font-weight: 700; color: #374151; margin-bottom: 6px; }
        .field-icon { margin-left: 4px; }

        .reg-submit-btn {
            background: linear-gradient(135deg, #1d4ed8, #7c3aed) !important;
            border: none !important; border-radius: 14px !important;
            font-weight: 800 !important; font-size: 1.05rem !important;
            box-shadow: 0 8px 28px rgba(37,99,235,.35) !important;
            transition: all .3s ease !important;
            min-width: 220px;
        }
        .reg-submit-btn:hover:not(:disabled) {
            transform: translateY(-3px) !important;
            box-shadow: 0 16px 44px rgba(37,99,235,.45) !important;
        }

        /* ══════════════════════════════════════════
           FOOTER
        ══════════════════════════════════════════ */
        .landing-footer {
            background: #080d1a;
            padding: 44px 0 30px;
            border-top: 1px solid rgba(255,255,255,.06);
        }
        .footer-brand-icon {
            width: 44px; height: 44px; border-radius: 13px;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            font-size: 19px; color: white;
        }
        .footer-brand-name { font-size: 1rem; font-weight: 800; color: white; }
        .footer-brand-sub  { font-size: .72rem; color: rgba(255,255,255,.4); }
        .footer-link { color: rgba(255,255,255,.5); font-size: .87rem; transition: color .2s; }
        .footer-link:hover { color: #60a5fa; }
        .footer-copy { font-size: .82rem; color: rgba(255,255,255,.3); }
        .footer-divider { border-color: rgba(255,255,255,.07) !important; margin: 22px 0 20px; }

        /* ══════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════ */
        @media (max-width: 991px) {
            .hero-visual { margin-top: 50px; }
        }
        @media (max-width: 767px) {
            .hero-title { font-size: 2rem; }
            .hero-btns  { flex-direction: column; }
            .btn-hero-primary, .btn-hero-outline { width: 100%; text-align: center; }
            .hero-stats { justify-content: center; }
            .reg-form-card { padding: 28px 20px; }
            .feat-card { padding: 22px 18px; }
            .saas-tenants-row { gap: 10px; }
        }
    </style>
</head>
<body>

{{-- ══════════════════════════════════════════
     NAVBAR
══════════════════════════════════════════ --}}
<nav class="navbar navbar-expand-lg fixed-top" id="mainNav" style="background: transparent;">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-3" href="{{ route('landing') }}">
            <div class="nav-brand-icon"><i class="fas fa-graduation-cap"></i></div>
            <div>
                <div class="nav-brand-text">{{ trans('landing_trans.brand_name') }}</div>
                <div class="nav-brand-sub">School Management SaaS</div>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#home">{{ trans('landing_trans.nav_home') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">{{ trans('landing_trans.nav_features') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#dashboard-preview">{{ trans('landing_trans.nav_dashboard') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#roles">{{ trans('landing_trans.nav_roles') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#saas">{{ trans('landing_trans.nav_saas') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#register">{{ trans('landing_trans.nav_register') }}</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <div class="dropdown">
                    <button type="button" class="btn-lang-toggle dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-globe"></i> <span>{{ LaravelLocalization::getSupportedLocales()[app()->getLocale()]['native'] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() === $localeCode ? 'active' : '' }}"
                                   rel="alternate"
                                   hreflang="{{ $localeCode }}"
                                   href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <a href="{{ route('selection') }}" class="btn-nav-login">
                    <i class="fas fa-right-to-bracket me-2"></i> <span>{{ trans('landing_trans.nav_login') }}</span>
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ --}}
<section id="home" class="hero-section">
    <div class="container hero-content">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-eyebrow">
                    <span class="dot"></span>
                    <span>{{ trans('landing_trans.hero_eyebrow') }}</span>
                </div>

                <h1 class="hero-title">
                    <span>{{ trans('landing_trans.hero_title_line1') }}</span><br>
                    <span class="highlight">{{ trans('landing_trans.hero_title_line2') }}</span>
                </h1>

                <p class="hero-subtitle">{{ trans('landing_trans.hero_subtitle') }}</p>

                <div class="hero-btns">
                    <a href="#register" class="btn-hero-primary">
                        <i class="fas fa-school me-2"></i> <span>{{ trans('landing_trans.hero_btn_register') }}</span>
                    </a>
                    <a href="{{ route('selection') }}" class="btn-hero-outline">
                        <i class="fas fa-arrow-right-to-bracket me-2"></i> <span>{{ trans('landing_trans.nav_login') }}</span>
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat-pill">
                        <div>
                            <div class="stat-num">12+</div>
                            <div class="stat-label">{{ trans('landing_trans.stat_modules') }}</div>
                        </div>
                    </div>
                    <div class="stat-pill">
                        <div>
                            <div class="stat-num">5</div>
                            <div class="stat-label">{{ trans('landing_trans.stat_roles') }}</div>
                        </div>
                    </div>
                    <div class="stat-pill">
                        <div>
                            <div class="stat-num">100%</div>
                            <div class="stat-label">{{ trans('landing_trans.stat_isolation') }}</div>
                        </div>
                    </div>
                    <div class="stat-pill">
                        <div>
                            <div class="stat-num">AR / EN</div>
                            <div class="stat-label">{{ trans('landing_trans.stat_languages') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 offset-lg-1">
                <div class="hero-visual">
                    <div class="hero-panel">
                        <div class="hero-panel-head">
                            <span class="hero-panel-title">{{ trans('landing_trans.hero_panel_title') }}</span>
                            <span class="hero-panel-live"><span class="dot"></span> <span>{{ trans('landing_trans.hero_panel_live') }}</span></span>
                        </div>

                        <div class="hero-stat-row">
                            <div class="hero-stat-row-icon"><i class="fas fa-user-graduate"></i></div>
                            <div>
                                <div class="hero-stat-row-num">+150</div>
                                <div class="hero-stat-row-label">{{ trans('landing_trans.hc_active_students') }}</div>
                            </div>
                        </div>
                        <div class="hero-stat-row">
                            <div class="hero-stat-row-icon"><i class="fas fa-building-columns"></i></div>
                            <div>
                                <div class="hero-stat-row-num">∞</div>
                                <div class="hero-stat-row-label">{{ trans('landing_trans.hc_schools_count') }}</div>
                            </div>
                        </div>
                        <div class="hero-stat-row">
                            <div class="hero-stat-row-icon"><i class="fas fa-chart-line"></i></div>
                            <div>
                                <div class="hero-stat-row-num">{{ trans('landing_trans.hc_live_reports') }}</div>
                                <div class="hero-stat-row-label">{{ trans('landing_trans.hc_live_reports_sub') }}</div>
                            </div>
                        </div>

                        <div class="hero-panel-bar">
                            <span style="background:#60a5fa; flex:3;"></span>
                            <span style="background:#a78bfa; flex:2;"></span>
                            <span style="background:#34d399; flex:1;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     FEATURES (12 modules)
══════════════════════════════════════════ --}}
<section id="features" class="features-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag">{{ trans('landing_trans.tag_features') }}</div>
            <h2 class="section-title">{{ trans('landing_trans.features_title') }}</h2>
            <p class="section-sub">{{ trans('landing_trans.features_sub') }}</p>
        </div>

        <div class="row g-4">
            @foreach ([
                ['icon' => 'fa-user-graduate', 'key' => 'feat1'],
                ['icon' => 'fa-chalkboard-user', 'key' => 'feat2'],
                ['icon' => 'fa-people-roof', 'key' => 'feat3'],
                ['icon' => 'fa-layer-group', 'key' => 'feat4'],
                ['icon' => 'fa-calendar-check', 'key' => 'feat5'],
                ['icon' => 'fa-file-pen', 'key' => 'feat6'],
                ['icon' => 'fa-chart-line', 'key' => 'feat7'],
                ['icon' => 'fa-sack-dollar', 'key' => 'feat8'],
                ['icon' => 'fa-arrow-trend-up', 'key' => 'feat9'],
                ['icon' => 'fa-video', 'key' => 'feat10'],
                ['icon' => 'fa-book-open', 'key' => 'feat11'],
                ['icon' => 'fa-language', 'key' => 'feat12'],
            ] as $feature)
                <div class="col-lg-3 col-md-6">
                    <div class="feat-card">
                        <div class="feat-icon"><i class="fas {{ $feature['icon'] }}"></i></div>
                        <h3 class="feat-title">{{ trans("landing_trans.{$feature['key']}_title") }}</h3>
                        <p class="feat-desc">{{ trans("landing_trans.{$feature['key']}_desc") }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     DASHBOARD PREVIEW
══════════════════════════════════════════ --}}
<section id="dashboard-preview" class="dash-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag">{{ trans('landing_trans.tag_dashboard') }}</div>
            <h2 class="section-title">{{ trans('landing_trans.dash_title') }}</h2>
            <p class="section-sub">{{ trans('landing_trans.dash_sub') }}</p>
        </div>

        <div class="dash-window">
            <div class="dash-window-bar">
                <div class="dash-dots"><span></span><span></span><span></span></div>
                <div class="dash-url"><i class="fas fa-lock"></i> yourschool.app/dashboard</div>
            </div>

            <div class="dash-window-body">
                {{-- Mini sidebar --}}
                <div class="dash-sidebar-mini">
                    <div class="dsm-brand"><i class="fas fa-graduation-cap"></i> <span>{{ trans('landing_trans.dsm_brand') }}</span></div>
                    <div class="dsm-item active"><i class="fas fa-gauge-high"></i> <span>{{ trans('landing_trans.dsm_home') }}</span></div>
                    <div class="dsm-item"><i class="fas fa-user-graduate"></i> <span>{{ trans('landing_trans.dsm_students') }}</span></div>
                    <div class="dsm-item"><i class="fas fa-chalkboard-user"></i> <span>{{ trans('landing_trans.dsm_teachers') }}</span></div>
                    <div class="dsm-item"><i class="fas fa-calendar-check"></i> <span>{{ trans('landing_trans.dsm_attendance') }}</span></div>
                    <div class="dsm-item"><i class="fas fa-file-pen"></i> <span>{{ trans('landing_trans.dsm_exams') }}</span></div>
                    <div class="dsm-item"><i class="fas fa-sack-dollar"></i> <span>{{ trans('landing_trans.dsm_fees') }}</span></div>
                    <div class="dsm-item"><i class="fas fa-gear"></i> <span>{{ trans('landing_trans.dsm_settings') }}</span></div>
                </div>

                {{-- Main mocked content --}}
                <div class="dash-main">
                    <div class="dash-stats-row">
                        <div class="dstat-card">
                            <div class="dstat-top">
                                <div class="dstat-icon di-blue"><i class="fas fa-user-graduate"></i></div>
                                <span class="dstat-trend">+4.2%</span>
                            </div>
                            <div class="dstat-num">312</div>
                            <div class="dstat-label">{{ trans('landing_trans.dstat_students') }}</div>
                        </div>
                        <div class="dstat-card">
                            <div class="dstat-top">
                                <div class="dstat-icon di-purple"><i class="fas fa-chalkboard-user"></i></div>
                                <span class="dstat-trend">+1.1%</span>
                            </div>
                            <div class="dstat-num">28</div>
                            <div class="dstat-label">{{ trans('landing_trans.dstat_teachers') }}</div>
                        </div>
                        <div class="dstat-card">
                            <div class="dstat-top">
                                <div class="dstat-icon di-green"><i class="fas fa-calendar-check"></i></div>
                                <span class="dstat-trend">+0.6%</span>
                            </div>
                            <div class="dstat-num">96%</div>
                            <div class="dstat-label">{{ trans('landing_trans.dstat_attendance') }}</div>
                        </div>
                        <div class="dstat-card">
                            <div class="dstat-top">
                                <div class="dstat-icon di-amber"><i class="fas fa-sack-dollar"></i></div>
                                <span class="dstat-trend">+8.4%</span>
                            </div>
                            <div class="dstat-num">42,500</div>
                            <div class="dstat-label">{{ trans('landing_trans.dstat_fees') }}</div>
                        </div>
                    </div>

                    <div class="dash-panels-row">
                        <div class="dpanel-card">
                            <div class="dpanel-title">{{ trans('landing_trans.dpanel_weekly_attendance') }}</div>
                            <div class="bar-chart">
                                <div class="bar-col"><div class="bar-fill" style="height:70%"></div><span class="bar-day">{{ trans('landing_trans.day_sun') }}</span></div>
                                <div class="bar-col"><div class="bar-fill" style="height:88%"></div><span class="bar-day">{{ trans('landing_trans.day_mon') }}</span></div>
                                <div class="bar-col"><div class="bar-fill" style="height:95%"></div><span class="bar-day">{{ trans('landing_trans.day_tue') }}</span></div>
                                <div class="bar-col"><div class="bar-fill" style="height:80%"></div><span class="bar-day">{{ trans('landing_trans.day_wed') }}</span></div>
                                <div class="bar-col"><div class="bar-fill" style="height:92%"></div><span class="bar-day">{{ trans('landing_trans.day_thu') }}</span></div>
                            </div>
                        </div>
                        <div class="dpanel-card">
                            <div class="dpanel-title">{{ trans('landing_trans.dpanel_recent_activity') }}</div>

                            <div class="activity-item">
                                <div class="activity-dot di-blue"><i class="fas fa-user-plus"></i></div>
                                <div>
                                    <div class="activity-text">{{ trans('landing_trans.activity1_text') }}</div>
                                    <div class="activity-time">{{ trans('landing_trans.activity1_time') }}</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-dot di-amber"><i class="fas fa-file-invoice-dollar"></i></div>
                                <div>
                                    <div class="activity-text">{{ trans('landing_trans.activity2_text') }}</div>
                                    <div class="activity-time">{{ trans('landing_trans.activity2_time') }}</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-dot di-purple"><i class="fas fa-file-pen"></i></div>
                                <div>
                                    <div class="activity-text">{{ trans('landing_trans.activity3_text') }}</div>
                                    <div class="activity-time">{{ trans('landing_trans.activity3_time') }}</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-dot di-green"><i class="fas fa-video"></i></div>
                                <div>
                                    <div class="activity-text">{{ trans('landing_trans.activity4_text') }}</div>
                                    <div class="activity-time">{{ trans('landing_trans.activity4_time') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     ROLES
══════════════════════════════════════════ --}}
<section id="roles" class="roles-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag">{{ trans('landing_trans.tag_roles') }}</div>
            <h2 class="section-title">{{ trans('landing_trans.roles_title') }}</h2>
            <p class="section-sub">{{ trans('landing_trans.roles_sub') }}</p>
        </div>

        <div class="row g-4">
            @foreach ([
                ['css' => 'admin', 'icon' => 'fa-crown', 'key' => 'role_admin'],
                ['css' => 'teacher', 'icon' => 'fa-chalkboard-user', 'key' => 'role_teacher'],
                ['css' => 'student', 'icon' => 'fa-user-graduate', 'key' => 'role_student'],
                ['css' => 'parent', 'icon' => 'fa-people-roof', 'key' => 'role_parent'],
            ] as $role)
                <div class="col-lg-3 col-md-6">
                    <div class="role-card role-card-{{ $role['css'] }}">
                        <div class="role-avatar ra-{{ $role['css'] }}"><i class="fas {{ $role['icon'] }}"></i></div>
                        <h3 class="role-name">{{ trans("landing_trans.{$role['key']}_name") }}</h3>
                        <p class="role-desc">{{ trans("landing_trans.{$role['key']}_desc") }}</p>
                        <span class="role-badge rb-{{ $role['css'] }}">{{ trans("landing_trans.{$role['key']}_badge") }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     SAAS / MULTI-SCHOOL PLATFORM
══════════════════════════════════════════ --}}
<section id="saas" class="saas-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="section-tag">{{ trans('landing_trans.tag_saas') }}</div>
                <h2 class="section-title">{{ trans('landing_trans.saas_title') }}</h2>
                <p class="section-sub mb-4" style="margin:0 0 28px;">{{ trans('landing_trans.saas_sub') }}</p>

                <div class="saas-check">
                    <div class="saas-check-icon"><i class="fas fa-check"></i></div>
                    <div class="saas-check-text">{{ trans('landing_trans.saas_check1') }}</div>
                </div>
                <div class="saas-check">
                    <div class="saas-check-icon"><i class="fas fa-check"></i></div>
                    <div class="saas-check-text">{{ trans('landing_trans.saas_check2') }}</div>
                </div>
                <div class="saas-check">
                    <div class="saas-check-icon"><i class="fas fa-check"></i></div>
                    <div class="saas-check-text">{{ trans('landing_trans.saas_check3') }}</div>
                </div>
                <div class="saas-check">
                    <div class="saas-check-icon"><i class="fas fa-check"></i></div>
                    <div class="saas-check-text">{{ trans('landing_trans.saas_check4') }}</div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="saas-diagram">
                    <span class="saas-platform-box"><i class="fas fa-building-columns"></i> <span>{{ trans('landing_trans.saas_platform_box') }}</span></span>
                    <div class="saas-connector"></div>
                    <div class="saas-tenants-row">
                        <div class="saas-tenant-box">
                            <div class="saas-tenant-icon"><i class="fas fa-school"></i></div>
                            <div class="saas-tenant-name">{{ trans('landing_trans.saas_tenant_a') }}</div>
                            <div class="saas-tenant-sub">School A</div>
                        </div>
                        <div class="saas-tenant-box">
                            <div class="saas-tenant-icon"><i class="fas fa-school"></i></div>
                            <div class="saas-tenant-name">{{ trans('landing_trans.saas_tenant_b') }}</div>
                            <div class="saas-tenant-sub">School B</div>
                        </div>
                        <div class="saas-tenant-box">
                            <div class="saas-tenant-icon"><i class="fas fa-plus"></i></div>
                            <div class="saas-tenant-name">{{ trans('landing_trans.saas_tenant_c') }}</div>
                            <div class="saas-tenant-sub">School C...</div>
                        </div>
                    </div>
                    <div class="saas-lock-badge"><i class="fas fa-shield-halved"></i> <span>{{ trans('landing_trans.saas_lock_badge') }}</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     TECH STACK
══════════════════════════════════════════ --}}
<section class="tech-section">
    <div class="container text-center">
        <div class="section-tag">{{ trans('landing_trans.tag_tech') }}</div>
        <h2 class="section-title">{{ trans('landing_trans.tech_title') }}</h2>
        <p class="section-sub mb-5">{{ trans('landing_trans.tech_sub') }}</p>

        <div class="d-flex flex-wrap justify-content-center gap-3">
            <span class="tech-badge">Laravel 11</span>
            <span class="tech-badge">Livewire 3</span>
            <span class="tech-badge">Multi-Tenant (school_id)</span>
            <span class="tech-badge">AR/EN Localization</span>
            <span class="tech-badge">Bootstrap 5 RTL</span>
            <span class="tech-badge">MySQL</span>
            <span class="tech-badge">Zoom API</span>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     REGISTRATION FORM
══════════════════════════════════════════ --}}
<section id="register" class="register-section">
    <div class="container" style="position:relative; z-index:2;">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center mb-5">
                <div class="section-tag">{{ trans('landing_trans.tag_register') }}</div>
                <h2 class="section-title">{{ trans('landing_trans.register_title') }}</h2>
                <p class="section-sub">{!! trans('landing_trans.register_sub') !!}</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                {{-- إظهار/إخفاء نموذج التسجيل العام يتحكم به منشئ المنصة عبر إعدادات المنصة العامة
                     (allow_public_registration)؛ القيمة الافتراضية '1' تعني إظهار النموذج إذا لم
                     يُحدَّد الإعداد بعد. --}}
                @if (\App\Models\PlatformSetting::get('allow_public_registration', '1') === '1')
                    <div class="reg-form-card">
                        <livewire:school-registration />
                    </div>
                @else
                    <div class="reg-form-card text-center" style="padding:40px 24px;">
                        <p class="mb-0" style="color:#e2e8f0; font-weight:600;">{{ trans('landing_trans.register_closed') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     FOOTER
══════════════════════════════════════════ --}}
<footer class="landing-footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="footer-brand-icon"><i class="fas fa-graduation-cap"></i></div>
                    <div>
                        <div class="footer-brand-name">{{ trans('landing_trans.footer_brand_name') }}</div>
                        <div class="footer-brand-sub">School Management SaaS</div>
                    </div>
                </div>
                <p class="footer-copy mt-2">{{ trans('landing_trans.footer_brand_desc') }}</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <a href="https://github.com/atefhejazi1" class="footer-link" target="_blank" rel="noopener">
                        <i class="fab fa-github me-1"></i> GitHub
                    </a>
                    <a href="#" class="footer-link">
                        <i class="fab fa-linkedin me-1"></i> LinkedIn
                    </a>
                    <a href="#features" class="footer-link">{{ trans('landing_trans.nav_features') }}</a>
                    <a href="#dashboard-preview" class="footer-link">{{ trans('landing_trans.nav_dashboard') }}</a>
                    <a href="#saas" class="footer-link">{{ trans('landing_trans.footer_platform_link') }}</a>
                </div>
            </div>
            <div class="col-md-3 text-md-start text-center mt-3 mt-md-0">
                <p class="footer-copy">© {{ date('Y') }} <span>{{ trans('landing_trans.footer_brand_name') }}</span></p>
                <p class="footer-copy"><span>{{ trans('landing_trans.footer_dev_by') }}</span> <strong style="color:rgba(255,255,255,.45);">{{ trans('main_trans.Name_Programer') }}</strong></p>
            </div>
        </div>

        <hr class="footer-divider">
        <p class="text-center footer-copy mb-0">{{ trans('landing_trans.footer_tagline') }}</p>
    </div>
</footer>

{{-- Bootstrap 5 JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@livewireScripts

<script>
    const nav = document.getElementById('mainNav');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 60);
    }, { passive: true });

    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', e => {
            const target = document.querySelector(link.getAttribute('href'));
            if (target) {
                e.preventDefault();
                const offset = 80;
                window.scrollTo({ top: target.offsetTop - offset, behavior: 'smooth' });
            }
        });
    });

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.feat-card, .role-card, .tech-badge, .dash-window, .saas-diagram').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(28px)';
        el.style.transition = 'opacity .6s ease, transform .6s ease';
        observer.observe(el);
    });
</script>

</body>
</html>
