<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>نظام إدارة المدارس الذكي</title>

    {{-- Cairo Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 RTL --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">

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
            font-size: 20px; flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(37,99,235,.4);
        }
        .nav-brand-text { font-size: 1.05rem; font-weight: 800; color: white; line-height: 1.1; }
        .nav-brand-sub  { font-size: .68rem; font-weight: 500; color: rgba(255,255,255,.5); }

        .navbar-nav .nav-link {
            color: rgba(255,255,255,.75) !important;
            font-weight: 600; font-size: .9rem;
            padding: 6px 14px !important;
            border-radius: 8px;
            transition: color .2s, background .2s;
        }
        .navbar-nav .nav-link:hover {
            color: white !important;
            background: rgba(255,255,255,.1);
        }
        .btn-nav-login {
            background: rgba(255,255,255,.12);
            border: 1.5px solid rgba(255,255,255,.25);
            color: white !important;
            font-weight: 700; font-size: .88rem;
            padding: 8px 22px; border-radius: 10px;
            transition: all .25s ease;
        }
        .btn-nav-login:hover {
            background: white !important;
            color: #1e3a8a !important;
            border-color: white;
        }
        .navbar-toggler { border: 1.5px solid rgba(255,255,255,.3); border-radius: 8px; padding: 6px 10px; }
        .navbar-toggler-icon { filter: invert(1); }

        /* ══════════════════════════════════════════
           HERO
        ══════════════════════════════════════════ */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(145deg, #0b1120 0%, #0f172a 40%, #1a1f3c 70%, #1e2d5c 100%);
            display: flex; flex-direction: column; justify-content: center;
            position: relative; overflow: hidden;
            padding-top: 100px; padding-bottom: 80px;
        }

        /* Dot-grid pattern */
        .hero-section::before {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,.06) 1px, transparent 1px);
            background-size: 30px 30px;
            pointer-events: none;
        }

        /* Glow blobs */
        .hero-glow {
            position: absolute; border-radius: 50%; filter: blur(80px); pointer-events: none;
        }
        .hero-glow-1 { top: -100px; right: -100px; width: 500px; height: 500px; background: rgba(37,99,235,.18); }
        .hero-glow-2 { bottom: -120px; left: -80px;  width: 420px; height: 420px; background: rgba(124,58,237,.15); }
        .hero-glow-3 { top: 40%; left: 50%;          width: 300px; height: 300px; background: rgba(6,182,212,.08); transform: translate(-50%,-50%); }

        .hero-content { position: relative; z-index: 2; }

        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14);
            color: rgba(255,255,255,.65); font-size: .8rem; font-weight: 700;
            padding: 5px 16px; border-radius: 50px; margin-bottom: 24px;
            letter-spacing: .5px;
        }
        .hero-eyebrow .dot { width: 7px; height: 7px; background: #4ade80; border-radius: 50%; animation: dotPulse 2s ease-in-out infinite; }
        @keyframes dotPulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.85)} }

        .hero-title {
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 900; color: white; line-height: 1.15; margin-bottom: 20px;
        }
        .hero-title .highlight {
            background: linear-gradient(90deg, #60a5fa, #a78bfa, #34d399);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.15rem; color: rgba(255,255,255,.6);
            font-weight: 400; line-height: 1.75; max-width: 580px; margin-bottom: 38px;
        }

        .hero-btns { display: flex; flex-wrap: wrap; gap: 14px; margin-bottom: 52px; }
        .btn-hero-primary {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: white; font-weight: 700; font-size: 1rem;
            padding: 14px 34px; border-radius: 14px; border: none;
            box-shadow: 0 8px 28px rgba(37,99,235,.4);
            transition: all .3s ease;
        }
        .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(37,99,235,.5); color: white; }
        .btn-hero-outline {
            background: rgba(255,255,255,.08); border: 1.5px solid rgba(255,255,255,.25);
            color: white; font-weight: 700; font-size: 1rem;
            padding: 14px 34px; border-radius: 14px;
            transition: all .3s ease; backdrop-filter: blur(4px);
        }
        .btn-hero-outline:hover { background: rgba(255,255,255,.16); color: white; transform: translateY(-3px); }

        /* Stats row */
        .hero-stats {
            display: flex; flex-wrap: wrap; gap: 10px;
        }
        .stat-pill {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1);
            border-radius: 14px; padding: 12px 20px;
            transition: background .25s;
        }
        .stat-pill:hover { background: rgba(255,255,255,.12); }
        .stat-num { font-size: 1.5rem; font-weight: 900; color: white; line-height: 1; }
        .stat-label { font-size: .78rem; color: rgba(255,255,255,.5); font-weight: 500; }

        /* Hero visual (right side) */
        .hero-visual {
            position: relative; z-index: 2;
        }
        .hero-card {
            background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.12);
            border-radius: 20px; padding: 22px 24px;
            backdrop-filter: blur(10px);
            margin-bottom: 14px;
        }
        .hero-card-icon { font-size: 2rem; margin-bottom: 10px; }
        .hero-card-title { font-size: .9rem; font-weight: 700; color: rgba(255,255,255,.85); }
        .hero-card-sub   { font-size: .78rem; color: rgba(255,255,255,.45); }
        .hc-stat { font-size: 1.7rem; font-weight: 900; color: white; }

        .hero-card.float-1 { animation: float1 6s ease-in-out infinite; }
        .hero-card.float-2 { animation: float2 7s ease-in-out infinite .5s; }
        .hero-card.float-3 { animation: float3 5.5s ease-in-out infinite 1s; }
        @keyframes float1 { 0%,100%{transform:translateY(0)}    50%{transform:translateY(-10px)} }
        @keyframes float2 { 0%,100%{transform:translateY(0)}    50%{transform:translateY(-14px)} }
        @keyframes float3 { 0%,100%{transform:translateY(-8px)} 50%{transform:translateY(4px)} }

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
            font-size: 1.05rem; color: #64748b; font-weight: 400; max-width: 560px; margin: 0 auto;
        }

        /* ══════════════════════════════════════════
           FEATURES
        ══════════════════════════════════════════ */
        .features-section { padding: 96px 0; background: #f8fafc; }

        .feat-card {
            background: white; border-radius: 20px;
            border: 1px solid #e2e8f0;
            padding: 32px 28px; height: 100%;
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
            width: 64px; height: 64px; border-radius: 18px;
            background: linear-gradient(135deg, #eff6ff, #e0e7ff);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.9rem; margin-bottom: 20px;
            transition: transform .3s ease;
        }
        .feat-card:hover .feat-icon { transform: scale(1.1) rotate(-5deg); }

        .feat-title { font-size: 1.05rem; font-weight: 800; color: #0f172a; margin-bottom: 10px; }
        .feat-desc  { font-size: .88rem; color: #64748b; line-height: 1.7; }

        /* ══════════════════════════════════════════
           ROLES
        ══════════════════════════════════════════ */
        .roles-section { padding: 96px 0; background: white; }

        .role-card {
            border-radius: 20px; border: 1px solid #e2e8f0;
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
            font-size: 2.2rem; margin: 0 auto 18px;
        }
        .ra-admin   { background: linear-gradient(135deg, #eff6ff, #dbeafe); }
        .ra-teacher { background: linear-gradient(135deg, #f5f3ff, #ede9fe); }
        .ra-student { background: linear-gradient(135deg, #f0fdf4, #dcfce7); }
        .ra-parent  { background: linear-gradient(135deg, #fffbeb, #fef3c7); }

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
           TECH STACK
        ══════════════════════════════════════════ */
        .tech-section { padding: 72px 0; background: #f1f5f9; }

        .tech-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: white; border: 1.5px solid #e2e8f0;
            color: #334155; font-size: .88rem; font-weight: 700;
            padding: 10px 20px; border-radius: 50px;
            transition: all .25s ease; cursor: default;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }
        .tech-badge:hover { border-color: #2563eb; color: #2563eb; transform: translateY(-3px); box-shadow: 0 8px 22px rgba(37,99,235,.12); }
        .tech-badge-icon { font-size: 1.1rem; }

        /* ══════════════════════════════════════════
           REGISTRATION SECTION
        ══════════════════════════════════════════ */
        .register-section {
            padding: 96px 0;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #1a1f3c 100%);
            position: relative; overflow: hidden;
        }
        .register-section::before {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,.05) 1px, transparent 1px);
            background-size: 28px 28px;
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
            font-size: 20px;
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
            .hero-card.float-1, .hero-card.float-2, .hero-card.float-3 { animation: none; }
        }
        @media (max-width: 767px) {
            .hero-title { font-size: 2rem; }
            .hero-btns  { flex-direction: column; }
            .btn-hero-primary, .btn-hero-outline { width: 100%; text-align: center; }
            .hero-stats { justify-content: center; }
            .reg-form-card { padding: 28px 20px; }
            .feat-card { padding: 24px 20px; }
        }
    </style>
</head>
<body>

{{-- ══════════════════════════════════════════
     NAVBAR
══════════════════════════════════════════ --}}
<nav class="navbar navbar-expand-lg fixed-top" id="mainNav" style="background: transparent;">
    <div class="container">
        {{-- Brand (RTL: right side) --}}
        <a class="navbar-brand d-flex align-items-center gap-3" href="{{ url('/') }}">
            <div class="nav-brand-icon">🏫</div>
            <div>
                <div class="nav-brand-text">إدارة المدارس</div>
                <div class="nav-brand-sub">School Management System</div>
            </div>
        </a>

        {{-- Mobile toggle --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Links --}}
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#home">الرئيسية</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">المميزات</a></li>
                <li class="nav-item"><a class="nav-link" href="#roles">الأدوار</a></li>
                <li class="nav-item"><a class="nav-link" href="#register">تسجيل مدرسة</a></li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ url('/select') }}" class="btn-nav-login">
                    <i class="fas fa-right-to-bracket me-2"></i> تسجيل الدخول
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ --}}
<section id="home" class="hero-section">
    <div class="hero-glow hero-glow-1"></div>
    <div class="hero-glow hero-glow-2"></div>
    <div class="hero-glow hero-glow-3"></div>

    <div class="container hero-content">
        <div class="row align-items-center">
            {{-- Left: text --}}
            <div class="col-lg-6">
                <div class="hero-eyebrow">
                    <span class="dot"></span>
                    النظام جاهز للتشغيل — ابدأ الآن مجاناً
                </div>

                <h1 class="hero-title">
                    نظام إدارة<br>
                    <span class="highlight">المدارس الذكي</span>
                </h1>

                <p class="hero-subtitle">
                    منصة متكاملة لإدارة الطلاب، المعلمين، الحضور، والامتحانات في مكان واحد.
                    تقنية حديثة تُسهّل عمل الإدارة وتُحسّن تجربة التعلم.
                </p>

                <div class="hero-btns">
                    <a href="#register" class="btn-hero-primary">
                        <i class="fas fa-school me-2"></i> سجّل مدرستك الآن
                    </a>
                    <a href="{{ url('/select') }}" class="btn-hero-outline">
                        <i class="fas fa-arrow-right-to-bracket me-2"></i> تسجيل الدخول
                    </a>
                </div>

                {{-- Stats --}}
                <div class="hero-stats">
                    <div class="stat-pill">
                        <div>
                            <div class="stat-num">150+</div>
                            <div class="stat-label">طالب مسجّل</div>
                        </div>
                    </div>
                    <div class="stat-pill">
                        <div>
                            <div class="stat-num">5</div>
                            <div class="stat-label">دفعات دراسية</div>
                        </div>
                    </div>
                    <div class="stat-pill">
                        <div>
                            <div class="stat-num">720+</div>
                            <div class="stat-label">ساعة تدريب</div>
                        </div>
                    </div>
                    <div class="stat-pill">
                        <div>
                            <div class="stat-num">4</div>
                            <div class="stat-label">أدوار متخصصة</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: visual cards --}}
            <div class="col-lg-5 offset-lg-1">
                <div class="hero-visual">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="hero-card float-1">
                                <div class="hero-card-icon">🎓</div>
                                <div class="hc-stat">150+</div>
                                <div class="hero-card-title">طالب نشط</div>
                                <div class="hero-card-sub">في 5 دفعات</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-card float-2">
                                <div class="hero-card-icon">👨‍🏫</div>
                                <div class="hc-stat">98%</div>
                                <div class="hero-card-title">رضا المعلمين</div>
                                <div class="hero-card-sub">عن النظام</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="hero-card float-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="font-size:2rem;">📊</div>
                                    <div>
                                        <div class="hero-card-title">تقارير لحظية</div>
                                        <div class="hero-card-sub">حضور · درجات · رسوم — كل شيء في لوحة واحدة</div>
                                    </div>
                                </div>
                                <div class="mt-3 d-flex gap-2">
                                    <div style="height:6px; border-radius:3px; background:rgba(96,165,250,.7); flex:3;"></div>
                                    <div style="height:6px; border-radius:3px; background:rgba(167,139,250,.7); flex:2;"></div>
                                    <div style="height:6px; border-radius:3px; background:rgba(52,211,153,.7); flex:1;"></div>
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
     FEATURES
══════════════════════════════════════════ --}}
<section id="features" class="features-section">
    <div class="container">
        {{-- Header --}}
        <div class="text-center mb-5">
            <div class="section-tag">المميزات</div>
            <h2 class="section-title">كل ما تحتاجه في مكان واحد</h2>
            <p class="section-sub">أدوات متكاملة مصمّمة خصيصاً للبيئة التعليمية العربية</p>
        </div>

        {{-- Cards --}}
        <div class="row g-4">
            {{-- Card 1 --}}
            <div class="col-md-4 col-sm-6">
                <div class="feat-card">
                    <div class="feat-icon">🎓</div>
                    <h3 class="feat-title">إدارة الطلاب</h3>
                    <p class="feat-desc">تسجيل الطلاب ومتابعة أدائهم الأكاديمي مع ملفات شاملة تحتوي على كل البيانات والمرفقات.</p>
                </div>
            </div>
            {{-- Card 2 --}}
            <div class="col-md-4 col-sm-6">
                <div class="feat-card">
                    <div class="feat-icon">👨‍🏫</div>
                    <h3 class="feat-title">إدارة المعلمين</h3>
                    <p class="feat-desc">تنظيم الجداول الدراسية، إدارة الصلاحيات، وإنشاء تقارير أداء تفصيلية لكل معلم.</p>
                </div>
            </div>
            {{-- Card 3 --}}
            <div class="col-md-4 col-sm-6">
                <div class="feat-card">
                    <div class="feat-icon">📋</div>
                    <h3 class="feat-title">الحضور والغياب</h3>
                    <p class="feat-desc">تسجيل يومي سريع للحضور والغياب مع إشعارات فورية لأولياء الأمور وتقارير دورية.</p>
                </div>
            </div>
            {{-- Card 4 --}}
            <div class="col-md-4 col-sm-6">
                <div class="feat-card">
                    <div class="feat-icon">📝</div>
                    <h3 class="feat-title">الامتحانات والدرجات</h3>
                    <p class="feat-desc">إنشاء الاختبارات الإلكترونية، تصحيح تلقائي، ورصد النتائج مع كشوف الدرجات.</p>
                </div>
            </div>
            {{-- Card 5 --}}
            <div class="col-md-4 col-sm-6">
                <div class="feat-card">
                    <div class="feat-icon">🎥</div>
                    <h3 class="feat-title">اجتماعات Zoom</h3>
                    <p class="feat-desc">جدولة الحصص الأونلاين ومؤتمرات أولياء الأمور مباشرةً من النظام عبر Zoom API.</p>
                </div>
            </div>
            {{-- Card 6 --}}
            <div class="col-md-4 col-sm-6">
                <div class="feat-card">
                    <div class="feat-icon">💰</div>
                    <h3 class="feat-title">الحسابات والرسوم</h3>
                    <p class="feat-desc">إصدار فواتير الرسوم، تتبع المدفوعات، وإنشاء تقارير مالية شاملة بنقرة واحدة.</p>
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
        {{-- Header --}}
        <div class="text-center mb-5">
            <div class="section-tag">الأدوار</div>
            <h2 class="section-title">مصمّم لكل أفراد المدرسة</h2>
            <p class="section-sub">واجهة مخصصة وصلاحيات دقيقة لكل دور داخل المنظومة التعليمية</p>
        </div>

        <div class="row g-4">
            {{-- Admin --}}
            <div class="col-lg-3 col-md-6">
                <div class="role-card role-card-admin">
                    <div class="role-avatar ra-admin">👑</div>
                    <h3 class="role-name">المدير</h3>
                    <p class="role-desc">يتحكم بكل جوانب النظام ويملك صلاحيات كاملة على جميع البيانات والتقارير والإعدادات.</p>
                    <span class="role-badge rb-admin">صلاحيات كاملة</span>
                </div>
            </div>
            {{-- Teacher --}}
            <div class="col-lg-3 col-md-6">
                <div class="role-card role-card-teacher">
                    <div class="role-avatar ra-teacher">👨‍🏫</div>
                    <h3 class="role-name">المعلم</h3>
                    <p class="role-desc">يدير صفوفه وطلابه، يُسجّل الحضور، يُنشئ الاختبارات، ويتابع أداء كل طالب.</p>
                    <span class="role-badge rb-teacher">إدارة الصفوف</span>
                </div>
            </div>
            {{-- Student --}}
            <div class="col-lg-3 col-md-6">
                <div class="role-card role-card-student">
                    <div class="role-avatar ra-student">🎓</div>
                    <h3 class="role-name">الطالب</h3>
                    <p class="role-desc">يتابع جدوله الدراسي، يطّلع على درجاته، يحضر الحصص الأونلاين، ويراجع المكتبة.</p>
                    <span class="role-badge rb-student">متابعة الأداء</span>
                </div>
            </div>
            {{-- Parent --}}
            <div class="col-lg-3 col-md-6">
                <div class="role-card role-card-parent">
                    <div class="role-avatar ra-parent">👨‍👩‍👦</div>
                    <h3 class="role-name">ولي الأمر</h3>
                    <p class="role-desc">يتابع أداء أبنائه، يستلم إشعارات الغياب، يراجع الدرجات، ويطّلع على الرسوم.</p>
                    <span class="role-badge rb-parent">متابعة الأبناء</span>
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
        <div class="section-tag">التقنية</div>
        <h2 class="section-title">مبني بأحدث التقنيات</h2>
        <p class="section-sub mb-5">معمارية حديثة تضمن الأداء العالي والأمان والقابلية للتوسع</p>

        <div class="d-flex flex-wrap justify-content-center gap-3">
            <span class="tech-badge"><span class="tech-badge-icon">⚡</span> Laravel 10</span>
            <span class="tech-badge"><span class="tech-badge-icon">🔥</span> Livewire 3</span>
            <span class="tech-badge"><span class="tech-badge-icon">🎨</span> Bootstrap 5 RTL</span>
            <span class="tech-badge"><span class="tech-badge-icon">🗄️</span> MySQL</span>
            <span class="tech-badge"><span class="tech-badge-icon">🎥</span> Zoom API</span>
            <span class="tech-badge"><span class="tech-badge-icon">🏗️</span> Repository Pattern</span>
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
                <div class="section-tag">التسجيل</div>
                <h2 class="section-title">سجّل مدرستك الآن</h2>
                <p class="section-sub">
                    سيتواصل معكم فريقنا خلال <strong style="color:#93c5fd;">24 ساعة</strong> لتفعيل حسابكم وبدء التجربة
                </p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="reg-form-card">
                    <livewire:school-registration />
                </div>
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
                    <div class="footer-brand-icon">🏫</div>
                    <div>
                        <div class="footer-brand-name">نظام إدارة المدارس</div>
                        <div class="footer-brand-sub">School Management System</div>
                    </div>
                </div>
                <p class="footer-copy mt-2">منصة متكاملة لإدارة المدارس بتقنية حديثة</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="d-flex justify-content-center gap-4">
                    <a href="https://github.com/atefhejazi1" class="footer-link" target="_blank" rel="noopener">
                        <i class="fab fa-github me-1"></i> GitHub
                    </a>
                    <a href="#" class="footer-link">
                        <i class="fab fa-linkedin me-1"></i> LinkedIn
                    </a>
                    <a href="#features" class="footer-link">المميزات</a>
                    <a href="#roles" class="footer-link">الأدوار</a>
                </div>
            </div>
            <div class="col-md-3 text-md-start text-center mt-3 mt-md-0">
                <p class="footer-copy">© 2024 نظام إدارة المدارس</p>
                <p class="footer-copy">تطوير <strong style="color:rgba(255,255,255,.45);">عاطف حجازي</strong></p>
            </div>
        </div>

        <hr class="footer-divider">
        <p class="text-center footer-copy mb-0">
            مبني بـ ❤️ باستخدام Laravel + Livewire + Bootstrap 5
        </p>
    </div>
</footer>

{{-- Bootstrap 5 JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@livewireScripts

<script>
    // ── Navbar: transparent → solid on scroll ──
    const nav = document.getElementById('mainNav');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 60);
    }, { passive: true });

    // ── Smooth scroll for anchor links ──
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

    // ── Intersection Observer: fade-in on scroll ──
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.feat-card, .role-card, .tech-badge').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(28px)';
        el.style.transition = 'opacity .6s ease, transform .6s ease';
        observer.observe(el);
    });
</script>

</body>
</html>
