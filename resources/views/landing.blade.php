<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title id="pageTitle" data-i18n="meta_title">نظام إدارة المدارس الذكي | منصة SaaS متكاملة للمدارس</title>
    <meta id="pageDescription" name="description" data-i18n-content="meta_description" content="منصة SaaS متكاملة لإدارة المدارس: طلاب، معلمون، أولياء أمور، حضور، امتحانات، رسوم، حصص أونلاين، ومكتبة رقمية — كل مدرسة بمساحتها المعزولة الخاصة.">

    {{-- Cairo Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 (RTL/LTR href swapped by JS on language toggle) --}}
    <link id="bootstrapCss" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">

    {{-- Apply saved language choice before first paint to avoid a flash of the wrong direction --}}
    <script>
        (function () {
            var lang = localStorage.getItem('siteLang') || 'ar';
            document.documentElement.lang = lang;
            document.documentElement.dir = lang === 'ar' ? 'rtl' : 'ltr';
            window.__initialLang = lang;
            if (lang === 'en') {
                document.getElementById('bootstrapCss').href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css';
            }
        })();
    </script>

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
        <a class="navbar-brand d-flex align-items-center gap-3" href="{{ url('/') }}">
            <div class="nav-brand-icon"><i class="fas fa-graduation-cap"></i></div>
            <div>
                <div class="nav-brand-text" data-i18n="brand_name">إدارة المدارس</div>
                <div class="nav-brand-sub">School Management SaaS</div>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#home" data-i18n="nav_home">الرئيسية</a></li>
                <li class="nav-item"><a class="nav-link" href="#features" data-i18n="nav_features">المميزات</a></li>
                <li class="nav-item"><a class="nav-link" href="#dashboard-preview" data-i18n="nav_dashboard">لوحة التحكم</a></li>
                <li class="nav-item"><a class="nav-link" href="#roles" data-i18n="nav_roles">الأدوار</a></li>
                <li class="nav-item"><a class="nav-link" href="#saas" data-i18n="nav_saas">منصة متعددة المدارس</a></li>
                <li class="nav-item"><a class="nav-link" href="#register" data-i18n="nav_register">تسجيل مدرسة</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <button type="button" id="langToggleBtn" class="btn-lang-toggle" onclick="toggleLanguage()">
                    <i class="fas fa-globe"></i> <span id="langToggleLabel">English</span>
                </button>
                <a href="{{ url('/select') }}" class="btn-nav-login">
                    <i class="fas fa-right-to-bracket me-2"></i> <span data-i18n="nav_login">تسجيل الدخول</span>
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
                    <span data-i18n="hero_eyebrow">منصة SaaS — كل مدرسة بمساحتها الخاصة والمعزولة بالكامل</span>
                </div>

                <h1 class="hero-title">
                    <span data-i18n="hero_title_line1">نظام إدارة</span><br>
                    <span class="highlight" data-i18n="hero_title_line2">المدارس الذكي</span>
                </h1>

                <p class="hero-subtitle" data-i18n="hero_subtitle">
                    منصة متكاملة لإدارة الطلاب، المعلمين، أولياء الأمور، الحضور، الامتحانات،
                    والرسوم في لوحة تحكم واحدة. سجّل مدرستك وابدأ العمل في دقائق — بياناتك معزولة
                    وآمنة تماماً عن أي مدرسة أخرى على المنصة.
                </p>

                <div class="hero-btns">
                    <a href="#register" class="btn-hero-primary">
                        <i class="fas fa-school me-2"></i> <span data-i18n="hero_btn_register">سجّل مدرستك الآن</span>
                    </a>
                    <a href="{{ url('/select') }}" class="btn-hero-outline">
                        <i class="fas fa-arrow-right-to-bracket me-2"></i> <span data-i18n="nav_login">تسجيل الدخول</span>
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat-pill">
                        <div>
                            <div class="stat-num">12+</div>
                            <div class="stat-label" data-i18n="stat_modules">وحدة إدارية متكاملة</div>
                        </div>
                    </div>
                    <div class="stat-pill">
                        <div>
                            <div class="stat-num">5</div>
                            <div class="stat-label" data-i18n="stat_roles">أدوار مستخدمين</div>
                        </div>
                    </div>
                    <div class="stat-pill">
                        <div>
                            <div class="stat-num">100%</div>
                            <div class="stat-label" data-i18n="stat_isolation">عزل بيانات بين المدارس</div>
                        </div>
                    </div>
                    <div class="stat-pill">
                        <div>
                            <div class="stat-num">AR / EN</div>
                            <div class="stat-label" data-i18n="stat_languages">دعم كامل للغتين</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 offset-lg-1">
                <div class="hero-visual">
                    <div class="hero-panel">
                        <div class="hero-panel-head">
                            <span class="hero-panel-title" data-i18n="hero_panel_title">نظرة لحظية</span>
                            <span class="hero-panel-live"><span class="dot"></span> <span data-i18n="hero_panel_live">مباشر</span></span>
                        </div>

                        <div class="hero-stat-row">
                            <div class="hero-stat-row-icon"><i class="fas fa-user-graduate"></i></div>
                            <div>
                                <div class="hero-stat-row-num">+150</div>
                                <div class="hero-stat-row-label" data-i18n="hc_active_students">طالب نشط لكل مدرسة</div>
                            </div>
                        </div>
                        <div class="hero-stat-row">
                            <div class="hero-stat-row-icon"><i class="fas fa-building-columns"></i></div>
                            <div>
                                <div class="hero-stat-row-num">∞</div>
                                <div class="hero-stat-row-label" data-i18n="hc_schools_count">عدد المدارس على بنية واحدة</div>
                            </div>
                        </div>
                        <div class="hero-stat-row">
                            <div class="hero-stat-row-icon"><i class="fas fa-chart-line"></i></div>
                            <div>
                                <div class="hero-stat-row-num" data-i18n="hc_live_reports">تقارير لحظية</div>
                                <div class="hero-stat-row-label" data-i18n="hc_live_reports_sub">حضور · درجات · رسوم</div>
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
            <div class="section-tag" data-i18n="tag_features">المميزات</div>
            <h2 class="section-title" data-i18n="features_title">كل ما تحتاجه مدرستك في مكان واحد</h2>
            <p class="section-sub" data-i18n="features_sub">من أول يوم تسجيل لمدرستك على المنصة، تحصل على كل هذه الوحدات جاهزة للعمل فوراً</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-user-graduate"></i></div>
                    <h3 class="feat-title" data-i18n="feat1_title">إدارة الطلاب</h3>
                    <p class="feat-desc" data-i18n="feat1_desc">ملفات شاملة لكل طالب: بيانات شخصية، صور ومرفقات، الصف والفصل والقسم، وربط مباشر بولي الأمر.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-chalkboard-user"></i></div>
                    <h3 class="feat-title" data-i18n="feat2_title">إدارة المعلمين</h3>
                    <p class="feat-desc" data-i18n="feat2_desc">تخصصات، تواريخ التحاق، وربط كل معلم بالأقسام التي يُدرّسها مع صلاحيات مخصصة.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-people-roof"></i></div>
                    <h3 class="feat-title" data-i18n="feat3_title">أولياء الأمور</h3>
                    <p class="feat-desc" data-i18n="feat3_desc">بيانات كاملة للأب والأم، وحساب مستقل لكل ولي أمر لمتابعة أبنائه في أي وقت.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-layer-group"></i></div>
                    <h3 class="feat-title" data-i18n="feat4_title">المراحل والفصول والأقسام</h3>
                    <p class="feat-desc" data-i18n="feat4_desc">هيكل أكاديمي مرن: كل مدرسة تنشئ مراحلها وفصولها وأقسامها الخاصة بها بالكامل.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-calendar-check"></i></div>
                    <h3 class="feat-title" data-i18n="feat5_title">الحضور والغياب</h3>
                    <p class="feat-desc" data-i18n="feat5_desc">تسجيل يومي سريع لكل قسم، مع سجل تاريخي قابل للمراجعة في أي لحظة.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-file-pen"></i></div>
                    <h3 class="feat-title" data-i18n="feat6_title">الاختبارات والأسئلة</h3>
                    <p class="feat-desc" data-i18n="feat6_desc">إنشاء اختبارات إلكترونية مرتبطة بالمادة والمرحلة، مع بنك أسئلة وتصحيح تلقائي للدرجات.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-chart-line"></i></div>
                    <h3 class="feat-title" data-i18n="feat7_title">كشوف الدرجات والنتائج</h3>
                    <p class="feat-desc" data-i18n="feat7_desc">رصد درجة كل طالب في كل اختبار تلقائياً، مع تقارير نتائج جاهزة للمراجعة والطباعة.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-sack-dollar"></i></div>
                    <h3 class="feat-title" data-i18n="feat8_title">الرسوم والفواتير والمدفوعات</h3>
                    <p class="feat-desc" data-i18n="feat8_desc">دورة مالية كاملة: فواتير رسوم، إيصالات استلام، متابعة المدفوعات، وحسابات الصندوق.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-arrow-trend-up"></i></div>
                    <h3 class="feat-title" data-i18n="feat9_title">الترقية والتخرج</h3>
                    <p class="feat-desc" data-i18n="feat9_desc">نقل الطلاب بين الصفوف الدراسية في نهاية العام بضغطة واحدة، وأرشفة دفعات التخرج.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-video"></i></div>
                    <h3 class="feat-title" data-i18n="feat10_title">الحصص الأونلاين</h3>
                    <p class="feat-desc" data-i18n="feat10_desc">جدولة حصص ومؤتمرات مباشرة عبر تكامل Zoom API، بروابط دخول فورية للمعلم والطلاب.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-book-open"></i></div>
                    <h3 class="feat-title" data-i18n="feat11_title">المكتبة الرقمية</h3>
                    <p class="feat-desc" data-i18n="feat11_desc">رفع وتحميل الملفات والمواد التعليمية لكل مرحلة، متاحة للطلاب والمعلمين في أي وقت.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feat-card">
                    <div class="feat-icon"><i class="fas fa-language"></i></div>
                    <h3 class="feat-title" data-i18n="feat12_title">دعم العربية والإنجليزية</h3>
                    <p class="feat-desc" data-i18n="feat12_desc">واجهة كاملة باتجاه RTL/LTR تلقائياً حسب اللغة، لخدمة الفرق والطلاب بلغتهم المفضّلة.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     DASHBOARD PREVIEW
══════════════════════════════════════════ --}}
<section id="dashboard-preview" class="dash-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag" data-i18n="tag_dashboard">لوحة التحكم</div>
            <h2 class="section-title" data-i18n="dash_title">رؤية كاملة لمدرستك من شاشة واحدة</h2>
            <p class="section-sub" data-i18n="dash_sub">إحصاءات لحظية، نسب الحضور، وآخر الأنشطة — كل ما يحتاجه المدير ليتخذ القرار الصحيح بسرعة</p>
        </div>

        <div class="dash-window">
            <div class="dash-window-bar">
                <div class="dash-dots"><span></span><span></span><span></span></div>
                <div class="dash-url"><i class="fas fa-lock"></i> yourschool.app/dashboard</div>
            </div>

            <div class="dash-window-body">
                {{-- Mini sidebar --}}
                <div class="dash-sidebar-mini">
                    <div class="dsm-brand"><i class="fas fa-graduation-cap"></i> <span data-i18n="dsm_brand">مدرستي</span></div>
                    <div class="dsm-item active"><i class="fas fa-gauge-high"></i> <span data-i18n="dsm_home">الرئيسية</span></div>
                    <div class="dsm-item"><i class="fas fa-user-graduate"></i> <span data-i18n="dsm_students">الطلاب</span></div>
                    <div class="dsm-item"><i class="fas fa-chalkboard-user"></i> <span data-i18n="dsm_teachers">المعلمون</span></div>
                    <div class="dsm-item"><i class="fas fa-calendar-check"></i> <span data-i18n="dsm_attendance">الحضور</span></div>
                    <div class="dsm-item"><i class="fas fa-file-pen"></i> <span data-i18n="dsm_exams">الاختبارات</span></div>
                    <div class="dsm-item"><i class="fas fa-sack-dollar"></i> <span data-i18n="dsm_fees">الرسوم</span></div>
                    <div class="dsm-item"><i class="fas fa-gear"></i> <span data-i18n="dsm_settings">الإعدادات</span></div>
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
                            <div class="dstat-label" data-i18n="dstat_students">إجمالي الطلاب</div>
                        </div>
                        <div class="dstat-card">
                            <div class="dstat-top">
                                <div class="dstat-icon di-purple"><i class="fas fa-chalkboard-user"></i></div>
                                <span class="dstat-trend">+1.1%</span>
                            </div>
                            <div class="dstat-num">28</div>
                            <div class="dstat-label" data-i18n="dstat_teachers">إجمالي المعلمين</div>
                        </div>
                        <div class="dstat-card">
                            <div class="dstat-top">
                                <div class="dstat-icon di-green"><i class="fas fa-calendar-check"></i></div>
                                <span class="dstat-trend">+0.6%</span>
                            </div>
                            <div class="dstat-num">96%</div>
                            <div class="dstat-label" data-i18n="dstat_attendance">نسبة الحضور اليوم</div>
                        </div>
                        <div class="dstat-card">
                            <div class="dstat-top">
                                <div class="dstat-icon di-amber"><i class="fas fa-sack-dollar"></i></div>
                                <span class="dstat-trend">+8.4%</span>
                            </div>
                            <div class="dstat-num">42,500</div>
                            <div class="dstat-label" data-i18n="dstat_fees">رسوم محصّلة هذا الشهر</div>
                        </div>
                    </div>

                    <div class="dash-panels-row">
                        <div class="dpanel-card">
                            <div class="dpanel-title" data-i18n="dpanel_weekly_attendance">نسبة الحضور الأسبوعية</div>
                            <div class="bar-chart">
                                <div class="bar-col"><div class="bar-fill" style="height:70%"></div><span class="bar-day" data-i18n="day_sun">أحد</span></div>
                                <div class="bar-col"><div class="bar-fill" style="height:88%"></div><span class="bar-day" data-i18n="day_mon">إثنين</span></div>
                                <div class="bar-col"><div class="bar-fill" style="height:95%"></div><span class="bar-day" data-i18n="day_tue">ثلاثاء</span></div>
                                <div class="bar-col"><div class="bar-fill" style="height:80%"></div><span class="bar-day" data-i18n="day_wed">أربعاء</span></div>
                                <div class="bar-col"><div class="bar-fill" style="height:92%"></div><span class="bar-day" data-i18n="day_thu">خميس</span></div>
                            </div>
                        </div>
                        <div class="dpanel-card">
                            <div class="dpanel-title" data-i18n="dpanel_recent_activity">آخر الأنشطة</div>

                            <div class="activity-item">
                                <div class="activity-dot di-blue"><i class="fas fa-user-plus"></i></div>
                                <div>
                                    <div class="activity-text" data-i18n="activity1_text">تسجيل طالب جديد في الصف الأول</div>
                                    <div class="activity-time" data-i18n="activity1_time">منذ 12 دقيقة</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-dot di-amber"><i class="fas fa-file-invoice-dollar"></i></div>
                                <div>
                                    <div class="activity-text" data-i18n="activity2_text">تم سداد فاتورة رسوم رقم #1042</div>
                                    <div class="activity-time" data-i18n="activity2_time">منذ 40 دقيقة</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-dot di-purple"><i class="fas fa-file-pen"></i></div>
                                <div>
                                    <div class="activity-text" data-i18n="activity3_text">نشر درجات اختبار العلوم — الصف التاسع</div>
                                    <div class="activity-time" data-i18n="activity3_time">منذ ساعة</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-dot di-green"><i class="fas fa-video"></i></div>
                                <div>
                                    <div class="activity-text" data-i18n="activity4_text">حصة أونلاين جديدة على Zoom للقسم (أ)</div>
                                    <div class="activity-time" data-i18n="activity4_time">منذ 3 ساعات</div>
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
            <div class="section-tag" data-i18n="tag_roles">الأدوار</div>
            <h2 class="section-title" data-i18n="roles_title">مصمّم لكل أفراد المدرسة</h2>
            <p class="section-sub" data-i18n="roles_sub">واجهة مخصصة وصلاحيات دقيقة لكل دور داخل المنظومة التعليمية</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="role-card role-card-admin">
                    <div class="role-avatar ra-admin"><i class="fas fa-crown"></i></div>
                    <h3 class="role-name" data-i18n="role_admin_name">المدير</h3>
                    <p class="role-desc" data-i18n="role_admin_desc">يتحكم بكل جوانب مدرسته ويملك صلاحيات كاملة على جميع البيانات والتقارير والإعدادات.</p>
                    <span class="role-badge rb-admin" data-i18n="role_admin_badge">صلاحيات كاملة</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="role-card role-card-teacher">
                    <div class="role-avatar ra-teacher"><i class="fas fa-chalkboard-user"></i></div>
                    <h3 class="role-name" data-i18n="role_teacher_name">المعلم</h3>
                    <p class="role-desc" data-i18n="role_teacher_desc">يدير صفوفه وطلابه، يُسجّل الحضور، يُنشئ الاختبارات، ويتابع أداء كل طالب.</p>
                    <span class="role-badge rb-teacher" data-i18n="role_teacher_badge">إدارة الصفوف</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="role-card role-card-student">
                    <div class="role-avatar ra-student"><i class="fas fa-user-graduate"></i></div>
                    <h3 class="role-name" data-i18n="role_student_name">الطالب</h3>
                    <p class="role-desc" data-i18n="role_student_desc">يتابع جدوله الدراسي، يطّلع على درجاته، يحضر الحصص الأونلاين، ويراجع المكتبة.</p>
                    <span class="role-badge rb-student" data-i18n="role_student_badge">متابعة الأداء</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="role-card role-card-parent">
                    <div class="role-avatar ra-parent"><i class="fas fa-people-roof"></i></div>
                    <h3 class="role-name" data-i18n="role_parent_name">ولي الأمر</h3>
                    <p class="role-desc" data-i18n="role_parent_desc">يتابع أداء أبنائه، يستلم إشعارات الغياب، يراجع الدرجات، ويطّلع على الرسوم.</p>
                    <span class="role-badge rb-parent" data-i18n="role_parent_badge">متابعة الأبناء</span>
                </div>
            </div>
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
                <div class="section-tag" data-i18n="tag_saas">المنصة</div>
                <h2 class="section-title" data-i18n="saas_title">منصة واحدة... لا حدود لعدد المدارس</h2>
                <p class="section-sub mb-4" style="margin:0 0 28px;" data-i18n="saas_sub">
                    بُنيت المنصة من الأساس لتخدم عدداً غير محدود من المدارس على نفس البنية التقنية،
                    مع فصل كامل وآمن لبيانات كل مدرسة عن غيرها.
                </p>

                <div class="saas-check">
                    <div class="saas-check-icon"><i class="fas fa-check"></i></div>
                    <div class="saas-check-text" data-i18n="saas_check1">عزل كامل لبيانات كل مدرسة (طلاب، معلمون، حضور، رسوم) عن باقي المدارس على المنصة.</div>
                </div>
                <div class="saas-check">
                    <div class="saas-check-icon"><i class="fas fa-check"></i></div>
                    <div class="saas-check-text" data-i18n="saas_check2">لوحة تحكم مستقلة لكل مدير مدرسة، مع حساب Admin خاص بمدرسته فقط.</div>
                </div>
                <div class="saas-check">
                    <div class="saas-check-icon"><i class="fas fa-check"></i></div>
                    <div class="saas-check-text" data-i18n="saas_check3">لوحة "مدير المنصة" العامة لمراجعة طلبات تسجيل المدارس وتفعيلها أو تعليقها.</div>
                </div>
                <div class="saas-check">
                    <div class="saas-check-icon"><i class="fas fa-check"></i></div>
                    <div class="saas-check-text" data-i18n="saas_check4">قابلية توسّع حقيقية لخدمة آلاف المدارس دون الحاجة لأي تعديل في البنية الأساسية.</div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="saas-diagram">
                    <span class="saas-platform-box"><i class="fas fa-building-columns"></i> <span data-i18n="saas_platform_box">منصة إدارة المدارس</span></span>
                    <div class="saas-connector"></div>
                    <div class="saas-tenants-row">
                        <div class="saas-tenant-box">
                            <div class="saas-tenant-icon"><i class="fas fa-school"></i></div>
                            <div class="saas-tenant-name" data-i18n="saas_tenant_a">مدرسة الأمل</div>
                            <div class="saas-tenant-sub">School A</div>
                        </div>
                        <div class="saas-tenant-box">
                            <div class="saas-tenant-icon"><i class="fas fa-school"></i></div>
                            <div class="saas-tenant-name" data-i18n="saas_tenant_b">أكاديمية النجاح</div>
                            <div class="saas-tenant-sub">School B</div>
                        </div>
                        <div class="saas-tenant-box">
                            <div class="saas-tenant-icon"><i class="fas fa-plus"></i></div>
                            <div class="saas-tenant-name" data-i18n="saas_tenant_c">مدرستك القادمة</div>
                            <div class="saas-tenant-sub">School C...</div>
                        </div>
                    </div>
                    <div class="saas-lock-badge"><i class="fas fa-shield-halved"></i> <span data-i18n="saas_lock_badge">عزل بيانات 100% بين المدارس</span></div>
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
        <div class="section-tag" data-i18n="tag_tech">التقنية</div>
        <h2 class="section-title" data-i18n="tech_title">مبني بأحدث التقنيات</h2>
        <p class="section-sub mb-5" data-i18n="tech_sub">معمارية حديثة تضمن الأداء العالي والأمان وقابلية التوسع لخدمة آلاف المدارس</p>

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
                <div class="section-tag" data-i18n="tag_register">التسجيل</div>
                <h2 class="section-title" data-i18n="register_title">سجّل مدرستك الآن</h2>
                <p class="section-sub" data-i18n="register_sub">
                    سيتواصل معكم فريقنا خلال <strong style="color:#93c5fd;">24 ساعة</strong> لتفعيل حسابكم وبدء التجربة
                </p>
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
                        <p class="mb-0" style="color:#e2e8f0; font-weight:600;" data-i18n="register_closed">
                            التسجيل العام مغلق حالياً، يرجى التواصل معنا مباشرةً لتفعيل حساب مدرستك.
                        </p>
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
                        <div class="footer-brand-name" data-i18n="footer_brand_name">نظام إدارة المدارس</div>
                        <div class="footer-brand-sub">School Management SaaS</div>
                    </div>
                </div>
                <p class="footer-copy mt-2" data-i18n="footer_brand_desc">منصة SaaS متكاملة لإدارة مدارس متعددة بتقنية حديثة</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <a href="https://github.com/atefhejazi1" class="footer-link" target="_blank" rel="noopener">
                        <i class="fab fa-github me-1"></i> GitHub
                    </a>
                    <a href="#" class="footer-link">
                        <i class="fab fa-linkedin me-1"></i> LinkedIn
                    </a>
                    <a href="#features" class="footer-link" data-i18n="nav_features">المميزات</a>
                    <a href="#dashboard-preview" class="footer-link" data-i18n="nav_dashboard">لوحة التحكم</a>
                    <a href="#saas" class="footer-link" data-i18n="footer_platform_link">المنصة</a>
                </div>
            </div>
            <div class="col-md-3 text-md-start text-center mt-3 mt-md-0">
                <p class="footer-copy">© {{ date('Y') }} <span data-i18n="footer_brand_name">نظام إدارة المدارس</span></p>
                <p class="footer-copy"><span data-i18n="footer_dev_by">تطوير</span> <strong style="color:rgba(255,255,255,.45);">عاطف حجازي</strong></p>
            </div>
        </div>

        <hr class="footer-divider">
        <p class="text-center footer-copy mb-0" data-i18n="footer_tagline">
            مبني بـ ❤️ باستخدام Laravel + Livewire + Bootstrap 5
        </p>
    </div>
</footer>

{{-- Bootstrap 5 JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@livewireScripts

<script>
    const I18N = {
        ar: {
            meta_title: "نظام إدارة المدارس الذكي | منصة SaaS متكاملة للمدارس",
            meta_description: "منصة SaaS متكاملة لإدارة المدارس: طلاب، معلمون، أولياء أمور، حضور، امتحانات، رسوم، حصص أونلاين، ومكتبة رقمية — كل مدرسة بمساحتها المعزولة الخاصة.",

            brand_name: "إدارة المدارس",
            nav_home: "الرئيسية",
            nav_features: "المميزات",
            nav_dashboard: "لوحة التحكم",
            nav_roles: "الأدوار",
            nav_saas: "منصة متعددة المدارس",
            nav_register: "تسجيل مدرسة",
            nav_login: "تسجيل الدخول",

            hero_eyebrow: "منصة SaaS — كل مدرسة بمساحتها الخاصة والمعزولة بالكامل",
            hero_title_line1: "نظام إدارة",
            hero_title_line2: "المدارس الذكي",
            hero_subtitle: "منصة متكاملة لإدارة الطلاب، المعلمين، أولياء الأمور، الحضور، الامتحانات، والرسوم في لوحة تحكم واحدة. سجّل مدرستك وابدأ العمل في دقائق — بياناتك معزولة وآمنة تماماً عن أي مدرسة أخرى على المنصة.",
            hero_btn_register: "سجّل مدرستك الآن",
            stat_modules: "وحدة إدارية متكاملة",
            stat_roles: "أدوار مستخدمين",
            stat_isolation: "عزل بيانات بين المدارس",
            stat_languages: "دعم كامل للغتين",
            hero_panel_title: "نظرة لحظية",
            hero_panel_live: "مباشر",
            hc_active_students: "طالب نشط لكل مدرسة",
            hc_schools_count: "عدد المدارس على بنية واحدة",
            hc_live_reports: "تقارير لحظية",
            hc_live_reports_sub: "حضور · درجات · رسوم",

            tag_features: "المميزات",
            features_title: "كل ما تحتاجه مدرستك في مكان واحد",
            features_sub: "من أول يوم تسجيل لمدرستك على المنصة، تحصل على كل هذه الوحدات جاهزة للعمل فوراً",
            feat1_title: "إدارة الطلاب",
            feat1_desc: "ملفات شاملة لكل طالب: بيانات شخصية، صور ومرفقات، الصف والفصل والقسم، وربط مباشر بولي الأمر.",
            feat2_title: "إدارة المعلمين",
            feat2_desc: "تخصصات، تواريخ التحاق، وربط كل معلم بالأقسام التي يُدرّسها مع صلاحيات مخصصة.",
            feat3_title: "أولياء الأمور",
            feat3_desc: "بيانات كاملة للأب والأم، وحساب مستقل لكل ولي أمر لمتابعة أبنائه في أي وقت.",
            feat4_title: "المراحل والفصول والأقسام",
            feat4_desc: "هيكل أكاديمي مرن: كل مدرسة تنشئ مراحلها وفصولها وأقسامها الخاصة بها بالكامل.",
            feat5_title: "الحضور والغياب",
            feat5_desc: "تسجيل يومي سريع لكل قسم، مع سجل تاريخي قابل للمراجعة في أي لحظة.",
            feat6_title: "الاختبارات والأسئلة",
            feat6_desc: "إنشاء اختبارات إلكترونية مرتبطة بالمادة والمرحلة، مع بنك أسئلة وتصحيح تلقائي للدرجات.",
            feat7_title: "كشوف الدرجات والنتائج",
            feat7_desc: "رصد درجة كل طالب في كل اختبار تلقائياً، مع تقارير نتائج جاهزة للمراجعة والطباعة.",
            feat8_title: "الرسوم والفواتير والمدفوعات",
            feat8_desc: "دورة مالية كاملة: فواتير رسوم، إيصالات استلام، متابعة المدفوعات، وحسابات الصندوق.",
            feat9_title: "الترقية والتخرج",
            feat9_desc: "نقل الطلاب بين الصفوف الدراسية في نهاية العام بضغطة واحدة، وأرشفة دفعات التخرج.",
            feat10_title: "الحصص الأونلاين",
            feat10_desc: "جدولة حصص ومؤتمرات مباشرة عبر تكامل Zoom API، بروابط دخول فورية للمعلم والطلاب.",
            feat11_title: "المكتبة الرقمية",
            feat11_desc: "رفع وتحميل الملفات والمواد التعليمية لكل مرحلة، متاحة للطلاب والمعلمين في أي وقت.",
            feat12_title: "دعم العربية والإنجليزية",
            feat12_desc: "واجهة كاملة باتجاه RTL/LTR تلقائياً حسب اللغة، لخدمة الفرق والطلاب بلغتهم المفضّلة.",

            tag_dashboard: "لوحة التحكم",
            dash_title: "رؤية كاملة لمدرستك من شاشة واحدة",
            dash_sub: "إحصاءات لحظية، نسب الحضور، وآخر الأنشطة — كل ما يحتاجه المدير ليتخذ القرار الصحيح بسرعة",
            dsm_brand: "مدرستي",
            dsm_home: "الرئيسية",
            dsm_students: "الطلاب",
            dsm_teachers: "المعلمون",
            dsm_attendance: "الحضور",
            dsm_exams: "الاختبارات",
            dsm_fees: "الرسوم",
            dsm_settings: "الإعدادات",
            dstat_students: "إجمالي الطلاب",
            dstat_teachers: "إجمالي المعلمين",
            dstat_attendance: "نسبة الحضور اليوم",
            dstat_fees: "رسوم محصّلة هذا الشهر",
            dpanel_weekly_attendance: "نسبة الحضور الأسبوعية",
            day_sun: "أحد", day_mon: "إثنين", day_tue: "ثلاثاء", day_wed: "أربعاء", day_thu: "خميس",
            dpanel_recent_activity: "آخر الأنشطة",
            activity1_text: "تسجيل طالب جديد في الصف الأول",
            activity1_time: "منذ 12 دقيقة",
            activity2_text: "تم سداد فاتورة رسوم رقم #1042",
            activity2_time: "منذ 40 دقيقة",
            activity3_text: "نشر درجات اختبار العلوم — الصف التاسع",
            activity3_time: "منذ ساعة",
            activity4_text: "حصة أونلاين جديدة على Zoom للقسم (أ)",
            activity4_time: "منذ 3 ساعات",

            tag_roles: "الأدوار",
            roles_title: "مصمّم لكل أفراد المدرسة",
            roles_sub: "واجهة مخصصة وصلاحيات دقيقة لكل دور داخل المنظومة التعليمية",
            role_admin_name: "المدير",
            role_admin_desc: "يتحكم بكل جوانب مدرسته ويملك صلاحيات كاملة على جميع البيانات والتقارير والإعدادات.",
            role_admin_badge: "صلاحيات كاملة",
            role_teacher_name: "المعلم",
            role_teacher_desc: "يدير صفوفه وطلابه، يُسجّل الحضور، يُنشئ الاختبارات، ويتابع أداء كل طالب.",
            role_teacher_badge: "إدارة الصفوف",
            role_student_name: "الطالب",
            role_student_desc: "يتابع جدوله الدراسي، يطّلع على درجاته، يحضر الحصص الأونلاين، ويراجع المكتبة.",
            role_student_badge: "متابعة الأداء",
            role_parent_name: "ولي الأمر",
            role_parent_desc: "يتابع أداء أبنائه، يستلم إشعارات الغياب، يراجع الدرجات، ويطّلع على الرسوم.",
            role_parent_badge: "متابعة الأبناء",

            tag_saas: "المنصة",
            saas_title: "منصة واحدة... لا حدود لعدد المدارس",
            saas_sub: "بُنيت المنصة من الأساس لتخدم عدداً غير محدود من المدارس على نفس البنية التقنية، مع فصل كامل وآمن لبيانات كل مدرسة عن غيرها.",
            saas_check1: "عزل كامل لبيانات كل مدرسة (طلاب، معلمون، حضور، رسوم) عن باقي المدارس على المنصة.",
            saas_check2: "لوحة تحكم مستقلة لكل مدير مدرسة، مع حساب Admin خاص بمدرسته فقط.",
            saas_check3: "لوحة \"مدير المنصة\" العامة لمراجعة طلبات تسجيل المدارس وتفعيلها أو تعليقها.",
            saas_check4: "قابلية توسّع حقيقية لخدمة آلاف المدارس دون الحاجة لأي تعديل في البنية الأساسية.",
            saas_platform_box: "منصة إدارة المدارس",
            saas_tenant_a: "مدرسة الأمل",
            saas_tenant_b: "أكاديمية النجاح",
            saas_tenant_c: "مدرستك القادمة",
            saas_lock_badge: "عزل بيانات 100% بين المدارس",

            tag_tech: "التقنية",
            tech_title: "مبني بأحدث التقنيات",
            tech_sub: "معمارية حديثة تضمن الأداء العالي والأمان وقابلية التوسع لخدمة آلاف المدارس",

            tag_register: "التسجيل",
            register_title: "سجّل مدرستك الآن",
            register_sub: "سيتواصل معكم فريقنا خلال <strong style=\"color:#93c5fd;\">24 ساعة</strong> لتفعيل حسابكم وبدء التجربة",

            footer_brand_name: "نظام إدارة المدارس",
            footer_brand_desc: "منصة SaaS متكاملة لإدارة مدارس متعددة بتقنية حديثة",
            footer_platform_link: "المنصة",
            footer_dev_by: "تطوير",
            footer_tagline: "مبني بـ ❤️ باستخدام Laravel + Livewire + Bootstrap 5",

            reg_success_title: "شكراً! تم استلام طلبكم بنجاح",
            reg_success_sub: "سيتواصل معكم فريقنا خلال <strong>24 ساعة</strong> لتفعيل حسابكم",
            reg_success_email_label: "البريد الإلكتروني المسجّل",
            reg_label_school_name: "اسم المدرسة",
            reg_ph_school_name: "مثال: مدرسة الأمل الأهلية",
            reg_label_contact_name: "اسم المسؤول",
            reg_ph_contact_name: "الاسم الكامل للمسؤول",
            reg_label_email: "البريد الإلكتروني",
            reg_label_phone: "رقم الهاتف",
            reg_label_city: "المدينة",
            reg_ph_city: "مثال: الرياض",
            reg_label_student_count: "عدد الطلاب المتوقع",
            reg_opt_choose: "— اختر —",
            reg_opt_less_100: "أقل من 100 طالب",
            reg_opt_100_300: "من 100 إلى 300 طالب",
            reg_opt_more_300: "أكثر من 300 طالب",
            reg_label_message: "ملاحظات إضافية",
            reg_ph_message: "أي معلومات إضافية تودّ مشاركتها مع فريقنا...",
            reg_terms_text: "أوافق على <a href=\"#\" class=\"text-primary fw-semibold\">الشروط والأحكام</a> وسياسة الخصوصية",
            reg_submit_btn: "إرسال طلب التسجيل",
            reg_submitting: "جاري الإرسال...",
            reg_secure_note: "بياناتك آمنة ومشفّرة — لن نشاركها مع أي طرف ثالث"
        },
        en: {
            meta_title: "Smart School Management System | Multi-School SaaS Platform",
            meta_description: "A complete SaaS platform for school management: students, teachers, parents, attendance, exams, fees, online classes, and a digital library — every school gets its own fully isolated space.",

            brand_name: "School Management",
            nav_home: "Home",
            nav_features: "Features",
            nav_dashboard: "Dashboard",
            nav_roles: "Roles",
            nav_saas: "Multi-School Platform",
            nav_register: "Register School",
            nav_login: "Sign In",

            hero_eyebrow: "A SaaS platform — every school gets its own fully isolated space",
            hero_title_line1: "Smart School",
            hero_title_line2: "Management System",
            hero_subtitle: "A complete platform to manage students, teachers, parents, attendance, exams, and fees from a single dashboard. Register your school and get started in minutes — your data stays fully isolated and secure from every other school on the platform.",
            hero_btn_register: "Register Your School",
            stat_modules: "integrated modules",
            stat_roles: "user roles",
            stat_isolation: "data isolation between schools",
            stat_languages: "full bilingual support",
            hero_panel_title: "Live Overview",
            hero_panel_live: "Live",
            hc_active_students: "active students per school",
            hc_schools_count: "schools on one architecture",
            hc_live_reports: "Live reports",
            hc_live_reports_sub: "Attendance · grades · fees",

            tag_features: "Features",
            features_title: "Everything your school needs in one place",
            features_sub: "From the day you register, your school gets every one of these modules ready to use immediately",
            feat1_title: "Student Management",
            feat1_desc: "Complete profiles for every student: personal data, photos and attachments, grade/class/section, and a direct link to the parent account.",
            feat2_title: "Teacher Management",
            feat2_desc: "Specializations, joining dates, and assignment of each teacher to the sections they teach, with custom permissions.",
            feat3_title: "Parent Accounts",
            feat3_desc: "Full father and mother records, with an independent account for each parent to follow their children at any time.",
            feat4_title: "Grades, Classes & Sections",
            feat4_desc: "A flexible academic structure: every school creates its own grades, classes, and sections entirely on its own.",
            feat5_title: "Attendance Tracking",
            feat5_desc: "Quick daily attendance for every section, with a full historical record you can review at any time.",
            feat6_title: "Exams & Question Bank",
            feat6_desc: "Create online exams linked to subject and grade level, with a question bank and automatic grade scoring.",
            feat7_title: "Grade Reports & Results",
            feat7_desc: "Automatically record every student's score on every exam, with results reports ready for review and printing.",
            feat8_title: "Fees, Invoices & Payments",
            feat8_desc: "A complete financial cycle: fee invoices, payment receipts, payment tracking, and treasury accounts.",
            feat9_title: "Promotion & Graduation",
            feat9_desc: "Move students up to the next grade at year-end with one click, and archive graduating classes.",
            feat10_title: "Online Classes",
            feat10_desc: "Schedule live classes and meetings via Zoom API integration, with instant join links for teachers and students.",
            feat11_title: "Digital Library",
            feat11_desc: "Upload and download files and learning materials for every grade level, available to students and teachers anytime.",
            feat12_title: "Arabic & English Support",
            feat12_desc: "A full RTL/LTR interface that switches automatically with language, serving every team and student in their preferred language.",

            tag_dashboard: "Dashboard",
            dash_title: "A complete view of your school on one screen",
            dash_sub: "Live stats, attendance rates, and recent activity — everything an administrator needs to make the right call, fast",
            dsm_brand: "My School",
            dsm_home: "Home",
            dsm_students: "Students",
            dsm_teachers: "Teachers",
            dsm_attendance: "Attendance",
            dsm_exams: "Exams",
            dsm_fees: "Fees",
            dsm_settings: "Settings",
            dstat_students: "Total Students",
            dstat_teachers: "Total Teachers",
            dstat_attendance: "Today's Attendance Rate",
            dstat_fees: "Fees Collected This Month",
            dpanel_weekly_attendance: "Weekly Attendance Rate",
            day_sun: "Sun", day_mon: "Mon", day_tue: "Tue", day_wed: "Wed", day_thu: "Thu",
            dpanel_recent_activity: "Recent Activity",
            activity1_text: "New student registered in Grade 1",
            activity1_time: "12 minutes ago",
            activity2_text: "Fee invoice #1042 was paid",
            activity2_time: "40 minutes ago",
            activity3_text: "Science exam grades published — Grade 9",
            activity3_time: "1 hour ago",
            activity4_text: "New online class scheduled on Zoom for Section A",
            activity4_time: "3 hours ago",

            tag_roles: "Roles",
            roles_title: "Built for everyone at your school",
            roles_sub: "A tailored interface and precise permissions for every role across the educational system",
            role_admin_name: "Admin",
            role_admin_desc: "Controls every aspect of their school with full permissions over all data, reports, and settings.",
            role_admin_badge: "Full permissions",
            role_teacher_name: "Teacher",
            role_teacher_desc: "Manages their classes and students, records attendance, creates exams, and tracks every student's performance.",
            role_teacher_badge: "Class management",
            role_student_name: "Student",
            role_student_desc: "Follows their class schedule, checks their grades, attends online classes, and browses the library.",
            role_student_badge: "Performance tracking",
            role_parent_name: "Parent",
            role_parent_desc: "Tracks their children's performance, receives absence notifications, reviews grades, and checks fees.",
            role_parent_badge: "Tracking children",

            tag_saas: "Platform",
            saas_title: "One platform... no limit on the number of schools",
            saas_sub: "Built from the ground up to serve an unlimited number of schools on the same technical architecture, with complete, secure separation of every school's data.",
            saas_check1: "Complete isolation of every school's data (students, teachers, attendance, fees) from every other school on the platform.",
            saas_check2: "An independent dashboard for every school admin, with an Admin account scoped to their school only.",
            saas_check3: "A platform-owner dashboard to review, approve, or suspend school registration requests.",
            saas_check4: "Real scalability to serve thousands of schools without any change to the underlying architecture.",
            saas_platform_box: "School Management Platform",
            saas_tenant_a: "Al-Amal School",
            saas_tenant_b: "Al-Najah Academy",
            saas_tenant_c: "Your School Next",
            saas_lock_badge: "100% data isolation between schools",

            tag_tech: "Technology",
            tech_title: "Built with modern technology",
            tech_sub: "A modern architecture that ensures high performance, security, and the ability to scale to thousands of schools",

            tag_register: "Registration",
            register_title: "Register Your School Now",
            register_sub: "Our team will reach out within <strong style=\"color:#93c5fd;\">24 hours</strong> to activate your account and get you started",

            footer_brand_name: "School Management System",
            footer_brand_desc: "A complete SaaS platform for managing multiple schools with modern technology",
            footer_platform_link: "Platform",
            footer_dev_by: "Developed by",
            footer_tagline: "Built with ❤️ using Laravel + Livewire + Bootstrap 5",

            reg_success_title: "Thank you! Your request was received",
            reg_success_sub: "Our team will reach out within <strong>24 hours</strong> to activate your account",
            reg_success_email_label: "Registered email",
            reg_label_school_name: "School Name",
            reg_ph_school_name: "e.g. Al-Amal Private School",
            reg_label_contact_name: "Contact Person",
            reg_ph_contact_name: "Contact person's full name",
            reg_label_email: "Email",
            reg_label_phone: "Phone Number",
            reg_label_city: "City",
            reg_ph_city: "e.g. Riyadh",
            reg_label_student_count: "Expected Number of Students",
            reg_opt_choose: "— Choose —",
            reg_opt_less_100: "Less than 100 students",
            reg_opt_100_300: "100 to 300 students",
            reg_opt_more_300: "More than 300 students",
            reg_label_message: "Additional Notes",
            reg_ph_message: "Any additional information you'd like to share with our team...",
            reg_terms_text: "I agree to the <a href=\"#\" class=\"text-primary fw-semibold\">Terms & Conditions</a> and Privacy Policy",
            reg_submit_btn: "Submit Registration Request",
            reg_submitting: "Submitting...",
            reg_secure_note: "Your data is safe and encrypted — we never share it with third parties"
        }
    };

    function translatePage(lang) {
        const dict = I18N[lang] || I18N.ar;

        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (dict[key] !== undefined) el.innerHTML = dict[key];
        });

        document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
            const key = el.getAttribute('data-i18n-placeholder');
            if (dict[key] !== undefined) el.setAttribute('placeholder', dict[key]);
        });

        document.querySelectorAll('[data-i18n-content]').forEach(el => {
            const key = el.getAttribute('data-i18n-content');
            if (dict[key] !== undefined) el.setAttribute('content', dict[key]);
        });
    }

    function applyLanguage(lang) {
        document.documentElement.lang = lang;
        document.documentElement.dir = lang === 'ar' ? 'rtl' : 'ltr';

        document.getElementById('bootstrapCss').href = lang === 'ar'
            ? 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css'
            : 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css';

        translatePage(lang);

        const toggleLabel = document.getElementById('langToggleLabel');
        if (toggleLabel) toggleLabel.textContent = lang === 'ar' ? 'English' : 'العربية';

        window.__currentLang = lang;
        localStorage.setItem('siteLang', lang);
    }

    function toggleLanguage() {
        applyLanguage(window.__currentLang === 'en' ? 'ar' : 'en');
    }

    applyLanguage(window.__initialLang || 'ar');

    document.addEventListener('livewire:init', () => {
        Livewire.hook('morph.updated', () => translatePage(window.__currentLang || 'ar'));
    });

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
