<!DOCTYPE html>
<html lang="ar" dir="rtl">
@section('title'){{ trans('main_trans.Main_title') }}@stop
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>لوحة التحكم — إدارة المدارس</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @include('layouts.head')
    @livewireStyles

    <style>
        /* ── Base ── */
        * { font-family: 'Cairo', sans-serif; }
        body, .wrapper { background: #edf0f7 !important; }
        .content-wrapper { margin-top: 64px !important; background: #edf0f7 !important; }

        /* ── Page Wrapper ── */
        .dash-wrap { padding: 22px 20px; }

        /* ══════════════════════════════════════════
           HERO BANNER
        ══════════════════════════════════════════ */
        .hero-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #1d4ed8 100%);
            border-radius: 22px;
            margin-bottom: 22px;
            position: relative; overflow: hidden;
            box-shadow: 0 16px 52px rgba(15,23,42,0.38);
            display: flex; align-items: stretch;
        }

        /* Dot-grid pattern */
        .hero-banner::before {
            content: ''; position: absolute; inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px);
            background-size: 28px 28px; pointer-events: none;
        }

        .hero-glow-1 {
            position: absolute; top: -80px; right: -80px;
            width: 280px; height: 280px; border-radius: 50%;
            background: rgba(59,130,246,0.22); filter: blur(50px); pointer-events: none;
        }
        .hero-glow-2 {
            position: absolute; bottom: -60px; left: 28%;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(139,92,246,0.18); filter: blur(50px); pointer-events: none;
        }

        /* Left content */
        .hero-left {
            flex: 1; padding: 32px 36px;
            position: relative; z-index: 2;
            display: flex; flex-direction: column; justify-content: center;
        }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 7px;
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.65); font-size: 11.5px; font-weight: 700;
            padding: 4px 14px; border-radius: 20px; margin-bottom: 12px;
            width: fit-content; letter-spacing: 0.4px;
        }

        .hero-title {
            font-size: 30px; font-weight: 900; color: white;
            line-height: 1.15; margin-bottom: 6px;
        }
        .hero-title em { font-style: normal; color: #93c5fd; }

        .hero-date {
            font-size: 12px; color: rgba(255,255,255,0.48);
            display: flex; align-items: center; gap: 7px; margin-bottom: 22px;
        }

        .hero-actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .hero-btn {
            display: inline-flex; align-items: center; gap: 7px;
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.18);
            color: white; padding: 8px 18px; border-radius: 10px;
            font-size: 12.5px; font-weight: 600; text-decoration: none;
            transition: all 0.2s ease; backdrop-filter: blur(4px);
        }
        .hero-btn:hover { background: rgba(255,255,255,0.2); color: white; }
        .hero-btn.primary { background: rgba(255,255,255,0.2); border-color: rgba(255,255,255,0.35); }

        /* Right metric grid */
        .hero-right {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 10px; padding: 22px 28px 22px 14px;
            position: relative; z-index: 2; align-content: center;
            min-width: 300px;
            border-right: 1px solid rgba(255,255,255,0.07);
        }

        .hero-metric {
            background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px; padding: 14px 15px; transition: background 0.2s;
        }
        .hero-metric:hover { background: rgba(255,255,255,0.14); }
        .hero-metric-ico { font-size: 13px; color: rgba(255,255,255,0.38); margin-bottom: 8px; }
        .hero-metric-num { font-size: 24px; font-weight: 900; color: white; line-height: 1; margin-bottom: 3px; }
        .hero-metric-lbl { font-size: 10.5px; color: rgba(255,255,255,0.48); font-weight: 500; }

        /* ══════════════════════════════════════════
           KPI CARDS — full gradient
        ══════════════════════════════════════════ */
        .kpi-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 16px; margin-bottom: 22px;
        }

        .kpi-card {
            border-radius: 20px; padding: 22px 20px 16px;
            position: relative; overflow: hidden; color: white;
            transition: transform 0.3s cubic-bezier(.22,.68,0,1.2), box-shadow 0.3s;
        }

        .kpi-card:hover { transform: translateY(-7px); }

        /* Decorative rings */
        .kpi-card::before {
            content: ''; position: absolute; bottom: -30px; left: -30px;
            width: 140px; height: 140px; border-radius: 50%;
            background: rgba(255,255,255,0.07);
        }
        .kpi-card::after {
            content: ''; position: absolute; bottom: -55px; left: -55px;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }

        .kc-blue   { background: linear-gradient(140deg, #1e3a8a, #2563eb, #60a5fa); box-shadow: 0 8px 30px rgba(37,99,235,0.4); }
        .kc-amber  { background: linear-gradient(140deg, #7c2d12, #d97706, #fcd34d); box-shadow: 0 8px 30px rgba(217,119,6,0.4); }
        .kc-green  { background: linear-gradient(140deg, #064e3b, #059669, #6ee7b7); box-shadow: 0 8px 30px rgba(5,150,105,0.4); }
        .kc-purple { background: linear-gradient(140deg, #4c1d95, #7c3aed, #c4b5fd); box-shadow: 0 8px 30px rgba(124,58,237,0.4); }

        .kc-blue:hover   { box-shadow: 0 20px 44px rgba(37,99,235,0.5); }
        .kc-amber:hover  { box-shadow: 0 20px 44px rgba(217,119,6,0.5); }
        .kc-green:hover  { box-shadow: 0 20px 44px rgba(5,150,105,0.5); }
        .kc-purple:hover { box-shadow: 0 20px 44px rgba(124,58,237,0.5); }

        .kpi-top {
            display: flex; align-items: flex-start; justify-content: space-between;
            margin-bottom: 14px; position: relative; z-index: 1;
        }

        .kpi-icon {
            width: 48px; height: 48px; border-radius: 14px;
            background: rgba(255,255,255,0.2); border: 1.5px solid rgba(255,255,255,0.28);
            display: flex; align-items: center; justify-content: center;
            font-size: 21px; color: white;
        }

        .kpi-trend {
            display: inline-flex; align-items: center; gap: 4px;
            background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.28);
            padding: 3px 9px; border-radius: 8px;
            font-size: 10.5px; font-weight: 700; color: white;
        }

        .kpi-num {
            font-size: 42px; font-weight: 900; color: white;
            line-height: 1; margin-bottom: 3px; position: relative; z-index: 1;
        }

        .kpi-lbl {
            font-size: 12.5px; font-weight: 600; color: rgba(255,255,255,0.7);
            position: relative; z-index: 1; margin-bottom: 14px;
        }

        /* SVG sparkline */
        .kpi-spark {
            width: 100%; height: 42px; position: relative; z-index: 1; margin-bottom: 12px;
        }
        .kpi-spark svg { width: 100%; height: 100%; overflow: visible; }

        /* Footer row */
        .kpi-foot {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 11px; border-top: 1px solid rgba(255,255,255,0.15);
            position: relative; z-index: 1;
        }

        .kpi-link {
            font-size: 11.5px; font-weight: 700; color: rgba(255,255,255,0.85);
            text-decoration: none; display: flex; align-items: center; gap: 5px;
            transition: gap 0.2s, color 0.2s;
        }
        .kpi-link:hover { gap: 8px; color: white; }
        .kpi-sub { font-size: 10.5px; color: rgba(255,255,255,0.48); }

        /* ══════════════════════════════════════════
           DASHBOARD BODY — 2-column
        ══════════════════════════════════════════ */
        .dash-body {
            display: grid; grid-template-columns: 1fr 330px;
            gap: 18px; margin-bottom: 22px;
        }

        /* Panel title shared */
        .panel-hd {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 22px 14px;
            border-bottom: 1px solid #eef1f7;
        }

        .panel-hd-title {
            font-size: 14.5px; font-weight: 800; color: #0f172a;
            display: flex; align-items: center; gap: 9px;
        }

        .panel-hd-icon {
            width: 32px; height: 32px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; flex-shrink: 0;
        }
        .phi-blue   { background: rgba(37,99,235,0.1);  color: #2563eb; }
        .phi-green  { background: rgba(5,150,105,0.1);  color: #059669; }
        .phi-purple { background: rgba(124,58,237,0.1); color: #7c3aed; }

        .panel-hd-link {
            font-size: 11.5px; font-weight: 700; color: #2563eb;
            text-decoration: none; display: flex; align-items: center; gap: 4px;
            transition: gap 0.2s;
        }
        .panel-hd-link:hover { gap: 7px; }

        /* ── Activity Card ── */
        .act-card {
            background: white; border-radius: 18px;
            box-shadow: 0 2px 14px rgba(0,0,0,0.06);
            border: 1px solid #e8edf5; overflow: hidden;
        }

        .act-tabs {
            display: flex; padding: 0 18px;
            border-bottom: 1px solid #eef1f7; gap: 2px;
        }

        .act-tab {
            padding: 10px 15px; font-size: 12.5px; font-weight: 600;
            color: #64748b; border-bottom: 2px solid transparent;
            cursor: pointer; text-decoration: none;
            transition: all 0.2s; display: flex; align-items: center; gap: 6px;
        }
        .act-tab:hover { color: #2563eb; background: rgba(37,99,235,0.04); }
        .act-tab.active { color: #2563eb; border-bottom-color: #2563eb; }
        .act-tab .tc {
            background: #eff6ff; color: #2563eb;
            font-size: 9.5px; font-weight: 700;
            padding: 1px 6px; border-radius: 6px;
        }

        /* Table */
        .act-table { width: 100%; border-collapse: collapse; }

        .act-table thead tr { background: #f8fafc; }
        .act-table thead th {
            padding: 11px 15px; font-size: 10.5px; font-weight: 700;
            color: #94a3b8; text-align: center; text-transform: uppercase;
            letter-spacing: 0.7px; border-bottom: 1px solid #eef1f7; white-space: nowrap;
        }

        .act-table tbody tr { border-bottom: 1px solid #f5f8fc; transition: background 0.15s; }
        .act-table tbody tr:hover { background: #fafbfd; }
        .act-table tbody tr:last-child { border-bottom: none; }
        .act-table tbody td {
            padding: 11px 15px; font-size: 12.5px; color: #374151;
            text-align: center; vertical-align: middle;
        }

        .td-name { display: flex; align-items: center; gap: 9px; justify-content: center; }
        .td-av {
            width: 30px; height: 30px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; color: white; font-weight: 700; flex-shrink: 0;
        }
        .td-av.blue   { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .td-av.amber  { background: linear-gradient(135deg, #fbbf24, #d97706); }
        .td-av.green  { background: linear-gradient(135deg, #34d399, #059669); }

        .td-pill {
            display: inline-flex; align-items: center; gap: 3px;
            padding: 3px 9px; border-radius: 7px;
            font-size: 10.5px; font-weight: 700;
        }
        .td-pill.male    { background: #eff6ff; color: #1d4ed8; }
        .td-pill.female  { background: #fdf4ff; color: #7e22ce; }
        .td-pill.ok      { background: #f0fdf4; color: #16a34a; }
        .td-pill.active  { background: #f0fdf4; color: #16a34a; }

        .td-empty { padding: 48px 20px !important; text-align: center; }
        .td-empty-wrap { display: flex; flex-direction: column; align-items: center; gap: 10px; }
        .td-empty-icon {
            width: 52px; height: 52px; border-radius: 14px; background: #f0f4f8;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: #94a3b8;
        }
        .td-empty-lbl { font-size: 13px; color: #94a3b8; font-weight: 600; }

        /* ── Right column ── */
        .right-col { display: flex; flex-direction: column; gap: 16px; }

        /* Quick actions */
        .quick-card {
            background: white; border-radius: 18px;
            box-shadow: 0 2px 14px rgba(0,0,0,0.06);
            border: 1px solid #e8edf5; overflow: hidden;
        }

        .qa-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; padding: 14px; }

        .qa-btn {
            display: flex; flex-direction: column; align-items: center;
            gap: 7px; padding: 15px 10px; border-radius: 13px;
            text-decoration: none; color: #1e293b;
            border: 1.5px solid #eef1f7;
            transition: all 0.25s cubic-bezier(.22,.68,0,1.2);
            background: white;
        }
        .qa-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(0,0,0,0.09);
            border-color: #dce8ff; color: #1e293b;
        }
        .qa-ico {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; transition: transform 0.25s;
        }
        .qa-btn:hover .qa-ico { transform: scale(1.1); }
        .qa-lbl { font-size: 11.5px; font-weight: 700; text-align: center; }
        .qa-sub { font-size: 10px; color: #94a3b8; text-align: center; }

        /* Status card */
        .status-card {
            background: white; border-radius: 18px;
            box-shadow: 0 2px 14px rgba(0,0,0,0.06);
            border: 1px solid #e8edf5; overflow: hidden;
        }

        .status-list { padding: 12px 18px; }
        .status-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 10px 0; border-bottom: 1px solid #f5f8fc;
        }
        .status-row:last-child { border-bottom: none; }
        .status-name {
            font-size: 12.5px; color: #374151; font-weight: 600;
            display: flex; align-items: center; gap: 8px;
        }
        .s-dot {
            width: 8px; height: 8px; border-radius: 50%;
            animation: sDotBlink 2s ease-in-out infinite;
        }
        .s-dot.green { background: #22c55e; }
        .s-dot.blue  { background: #3b82f6; }
        @keyframes sDotBlink { 0%,100% { opacity: 1; } 50% { opacity: 0.4; } }
        .status-val { font-size: 12px; font-weight: 700; color: #64748b; }
        .status-val.ok { color: #16a34a; }

        /* Section titles */
        .sec-title {
            font-size: 13.5px; font-weight: 800; color: #1e293b;
            margin-bottom: 12px; display: flex; align-items: center; gap: 8px;
        }
        .sec-title::after {
            content: ''; flex: 1; height: 1px;
            background: linear-gradient(90deg, #e2e8f0, transparent);
        }

        /* ══════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════ */
        @media (max-width: 1200px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }

        @media (max-width: 1024px) {
            .dash-body { grid-template-columns: 1fr; }
            .hero-right { display: none; }
        }

        @media (max-width: 768px) {
            .dash-wrap { padding: 14px; }
            .hero-left { padding: 22px 20px; }
            .hero-title { font-size: 24px; }
            .kpi-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
            .kpi-num { font-size: 34px; }
        }

        @media (max-width: 480px) {
            .kpi-grid { grid-template-columns: 1fr; }
            .hero-actions { flex-direction: column; }
        }
    </style>
</head>

<body>
<div class="wrapper">

    <div id="pre-loader">
        <img src="{{ URL::asset('assets/images/pre-loader/loader-01.svg') }}" alt="">
    </div>

    @include('layouts.main-header')
    @include('layouts.main-sidebar')

    <div class="content-wrapper">
        <div class="dash-wrap">

            {{-- ══ HERO BANNER ══ --}}
            <div class="hero-banner">
                <div class="hero-glow-1"></div>
                <div class="hero-glow-2"></div>

                <div class="hero-left">
                    <div class="hero-badge">
                        <i class="fas fa-circle" style="font-size:6px; color:#4ade80;"></i>
                        النظام يعمل بشكل طبيعي — لوحة التحكم
                    </div>
                    <div class="hero-title">أهلاً، <em>{{ auth()->user()->name ?? 'المسؤول' }}</em> 👋</div>
                    <div class="hero-date">
                        <i class="fas fa-calendar-alt"></i>
                        <span id="currentDate"></span>
                    </div>
                    <div class="hero-actions">
                        <a href="{{ route('Students.create') }}" class="hero-btn primary">
                            <i class="fas fa-user-plus"></i> إضافة طالب
                        </a>
                        <a href="{{ route('Teachers.index') }}" class="hero-btn">
                            <i class="fas fa-chalkboard-user"></i> المعلمون
                        </a>
                        <a href="{{ route('Fees_Invoices.index') }}" class="hero-btn">
                            <i class="fas fa-file-invoice"></i> الفواتير
                        </a>
                        <a href="{{ route('settings.index') }}" class="hero-btn">
                            <i class="fas fa-gear"></i> الإعدادات
                        </a>
                    </div>
                </div>

                <div class="hero-right">
                    <div class="hero-metric">
                        <div class="hero-metric-ico"><i class="fas fa-user-graduate"></i></div>
                        <div class="hero-metric-num">{{ \App\Models\students::count() }}</div>
                        <div class="hero-metric-lbl">الطلاب</div>
                    </div>
                    <div class="hero-metric">
                        <div class="hero-metric-ico"><i class="fas fa-chalkboard-user"></i></div>
                        <div class="hero-metric-num">{{ \App\Models\Teachers::count() }}</div>
                        <div class="hero-metric-lbl">المعلمون</div>
                    </div>
                    <div class="hero-metric">
                        <div class="hero-metric-ico"><i class="fas fa-users"></i></div>
                        <div class="hero-metric-num">{{ \App\Models\My_Parent::count() }}</div>
                        <div class="hero-metric-lbl">أولياء الأمور</div>
                    </div>
                    <div class="hero-metric">
                        <div class="hero-metric-ico"><i class="fas fa-door-open"></i></div>
                        <div class="hero-metric-num">{{ \App\Models\sections::count() }}</div>
                        <div class="hero-metric-lbl">الأقسام</div>
                    </div>
                </div>
            </div>

            {{-- ══ KPI CARDS ══ --}}
            <div class="sec-title">نظرة عامة على النظام</div>
            <div class="kpi-grid">

                {{-- Students --}}
                <div class="kpi-card kc-blue">
                    <div class="kpi-top">
                        <div class="kpi-icon"><i class="fas fa-user-graduate"></i></div>
                        <span class="kpi-trend"><i class="fas fa-arrow-trend-up"></i> نشط</span>
                    </div>
                    <div class="kpi-num" data-target="{{ \App\Models\students::count() }}">{{ \App\Models\students::count() }}</div>
                    <div class="kpi-lbl">إجمالي الطلاب المسجلين</div>
                    <div class="kpi-spark">
                        <svg viewBox="0 0 200 42" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="g1" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="rgba(255,255,255,0.28)"/>
                                    <stop offset="100%" stop-color="rgba(255,255,255,0)"/>
                                </linearGradient>
                            </defs>
                            <path d="M0,38 C20,32 40,26 60,20 C80,14 100,10 120,8 C140,6 160,4 180,3 L200,2" fill="none" stroke="rgba(255,255,255,0.55)" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M0,38 C20,32 40,26 60,20 C80,14 100,10 120,8 C140,6 160,4 180,3 L200,2 L200,42 L0,42Z" fill="url(#g1)"/>
                        </svg>
                    </div>
                    <div class="kpi-foot">
                        <a href="{{ route('Students.index') }}" class="kpi-link">عرض الكل <i class="fas fa-arrow-left"></i></a>
                        <span class="kpi-sub">{{ \App\Models\students::whereDate('created_at', today())->count() }} اليوم</span>
                    </div>
                </div>

                {{-- Teachers --}}
                <div class="kpi-card kc-amber">
                    <div class="kpi-top">
                        <div class="kpi-icon"><i class="fas fa-chalkboard-user"></i></div>
                        <span class="kpi-trend"><i class="fas fa-arrow-trend-up"></i> نشط</span>
                    </div>
                    <div class="kpi-num" data-target="{{ \App\Models\Teachers::count() }}">{{ \App\Models\Teachers::count() }}</div>
                    <div class="kpi-lbl">إجمالي المعلمين</div>
                    <div class="kpi-spark">
                        <svg viewBox="0 0 200 42" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="g2" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="rgba(255,255,255,0.28)"/>
                                    <stop offset="100%" stop-color="rgba(255,255,255,0)"/>
                                </linearGradient>
                            </defs>
                            <path d="M0,34 C20,28 40,22 60,16 C80,12 100,9 120,7 C140,5 160,4 180,3 L200,2" fill="none" stroke="rgba(255,255,255,0.55)" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M0,34 C20,28 40,22 60,16 C80,12 100,9 120,7 C140,5 160,4 180,3 L200,2 L200,42 L0,42Z" fill="url(#g2)"/>
                        </svg>
                    </div>
                    <div class="kpi-foot">
                        <a href="{{ route('Teachers.index') }}" class="kpi-link">عرض الكل <i class="fas fa-arrow-left"></i></a>
                        <span class="kpi-sub">{{ \App\Models\Teachers::whereDate('created_at', today())->count() }} اليوم</span>
                    </div>
                </div>

                {{-- Parents --}}
                <div class="kpi-card kc-green">
                    <div class="kpi-top">
                        <div class="kpi-icon"><i class="fas fa-users"></i></div>
                        <span class="kpi-trend"><i class="fas fa-minus"></i> ثابت</span>
                    </div>
                    <div class="kpi-num" data-target="{{ \App\Models\My_Parent::count() }}">{{ \App\Models\My_Parent::count() }}</div>
                    <div class="kpi-lbl">أولياء الأمور</div>
                    <div class="kpi-spark">
                        <svg viewBox="0 0 200 42" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="g3" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="rgba(255,255,255,0.28)"/>
                                    <stop offset="100%" stop-color="rgba(255,255,255,0)"/>
                                </linearGradient>
                            </defs>
                            <path d="M0,24 C20,22 40,26 60,21 C80,18 100,22 120,19 C140,17 160,20 180,18 L200,19" fill="none" stroke="rgba(255,255,255,0.55)" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M0,24 C20,22 40,26 60,21 C80,18 100,22 120,19 C140,17 160,20 180,18 L200,19 L200,42 L0,42Z" fill="url(#g3)"/>
                        </svg>
                    </div>
                    <div class="kpi-foot">
                        <a href="{{ url('add_parent') }}" class="kpi-link">عرض الكل <i class="fas fa-arrow-left"></i></a>
                        <span class="kpi-sub">{{ \App\Models\My_Parent::whereDate('created_at', today())->count() }} اليوم</span>
                    </div>
                </div>

                {{-- Sections --}}
                <div class="kpi-card kc-purple">
                    <div class="kpi-top">
                        <div class="kpi-icon"><i class="fas fa-door-open"></i></div>
                        <span class="kpi-trend"><i class="fas fa-minus"></i> ثابت</span>
                    </div>
                    <div class="kpi-num" data-target="{{ \App\Models\sections::count() }}">{{ \App\Models\sections::count() }}</div>
                    <div class="kpi-lbl">الأقسام الدراسية</div>
                    <div class="kpi-spark">
                        <svg viewBox="0 0 200 42" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="g4" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="rgba(255,255,255,0.28)"/>
                                    <stop offset="100%" stop-color="rgba(255,255,255,0)"/>
                                </linearGradient>
                            </defs>
                            <path d="M0,22 C20,20 40,23 60,20 C80,18 100,21 120,19 C140,17 160,21 180,19 L200,18" fill="none" stroke="rgba(255,255,255,0.55)" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M0,22 C20,20 40,23 60,20 C80,18 100,21 120,19 C140,17 160,21 180,19 L200,18 L200,42 L0,42Z" fill="url(#g4)"/>
                        </svg>
                    </div>
                    <div class="kpi-foot">
                        <a href="{{ route('Sections.index') }}" class="kpi-link">عرض الكل <i class="fas fa-arrow-left"></i></a>
                        <span class="kpi-sub">{{ \App\Models\Classroom::count() }} صف</span>
                    </div>
                </div>

            </div>

            {{-- ══ BODY (2-col) ══ --}}
            <div class="dash-body">

                {{-- LEFT: Activity --}}
                <div>
                    <div class="sec-title">آخر العمليات</div>
                    <div class="act-card">
                        <div class="panel-hd">
                            <div class="panel-hd-title">
                                <span class="panel-hd-icon phi-blue"><i class="fas fa-clock-rotate-left"></i></span>
                                سجل العمليات الأخيرة
                            </div>
                            <a href="{{ route('Students.index') }}" class="panel-hd-link">
                                عرض الكل <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>

                        <div class="act-tabs">
                            <a class="act-tab active" data-toggle="tab" href="#tab-s" role="tab">
                                <i class="fas fa-user-graduate"></i> الطلاب
                                <span class="tc">{{ \App\Models\students::take(5)->count() }}</span>
                            </a>
                            <a class="act-tab" data-toggle="tab" href="#tab-t" role="tab">
                                <i class="fas fa-chalkboard-user"></i> المعلمون
                            </a>
                            <a class="act-tab" data-toggle="tab" href="#tab-p" role="tab">
                                <i class="fas fa-users"></i> أولياء الأمور
                            </a>
                            <a class="act-tab" data-toggle="tab" href="#tab-i" role="tab">
                                <i class="fas fa-file-invoice"></i> الفواتير
                            </a>
                        </div>

                        <div class="tab-content">
                            {{-- Students --}}
                            <div class="tab-pane fade show active" id="tab-s">
                                <table class="act-table">
                                    <thead><tr>
                                        <th>#</th><th>الطالب</th><th>البريد</th>
                                        <th>النوع</th><th>المرحلة</th><th>الصف</th><th>القسم</th><th>التاريخ</th>
                                    </tr></thead>
                                    <tbody>
                                        @forelse(\App\Models\Students::latest()->take(5)->get() as $s)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><div class="td-name"><div class="td-av blue">{{ mb_substr($s->name, 0, 1) }}</div>{{ $s->name }}</div></td>
                                                <td>{{ $s->email }}</td>
                                                <td>
                                                    @if($s->gender)
                                                        <span class="td-pill {{ $s->gender->Name == 'ذكر' ? 'male' : 'female' }}">{{ $s->gender->Name }}</span>
                                                    @else <span style="color:#cbd5e1">—</span> @endif
                                                </td>
                                                <td>{{ $s->grade->Name ?? '—' }}</td>
                                                <td>{{ $s->classroom->Name_Class ?? '—' }}</td>
                                                <td>{{ $s->section->Name_Section ?? '—' }}</td>
                                                <td><span class="td-pill ok">{{ $s->created_at->format('d/m/Y') }}</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="8" class="td-empty"><div class="td-empty-wrap"><div class="td-empty-icon"><i class="fas fa-user-graduate"></i></div><div class="td-empty-lbl">لا يوجد طلاب مسجلون بعد</div></div></td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Teachers --}}
                            <div class="tab-pane fade" id="tab-t">
                                <table class="act-table">
                                    <thead><tr><th>#</th><th>المعلم</th><th>النوع</th><th>تاريخ التعيين</th><th>التخصص</th><th>التاريخ</th></tr></thead>
                                    <tbody>
                                        @forelse(\App\Models\Teachers::latest()->take(5)->get() as $t)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><div class="td-name"><div class="td-av amber">{{ mb_substr($t->Name, 0, 1) }}</div>{{ $t->Name }}</div></td>
                                                <td>{{ $t->genders->Name ?? '—' }}</td>
                                                <td>{{ $t->Joining_Date ?? '—' }}</td>
                                                <td>{{ $t->specializations->Name ?? '—' }}</td>
                                                <td><span class="td-pill ok">{{ $t->created_at->format('d/m/Y') }}</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="6" class="td-empty"><div class="td-empty-wrap"><div class="td-empty-icon"><i class="fas fa-chalkboard-user"></i></div><div class="td-empty-lbl">لا يوجد معلمون مسجلون بعد</div></div></td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Parents --}}
                            <div class="tab-pane fade" id="tab-p">
                                <table class="act-table">
                                    <thead><tr><th>#</th><th>ولي الأمر</th><th>البريد</th><th>رقم الهوية</th><th>الهاتف</th><th>التاريخ</th></tr></thead>
                                    <tbody>
                                        @forelse(\App\Models\My_Parent::latest()->take(5)->get() as $p)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><div class="td-name"><div class="td-av green">{{ mb_substr($p->Name_Father, 0, 1) }}</div>{{ $p->Name_Father }}</div></td>
                                                <td>{{ $p->email }}</td>
                                                <td>{{ $p->National_ID_Father ?? '—' }}</td>
                                                <td>{{ $p->Phone_Father ?? '—' }}</td>
                                                <td><span class="td-pill ok">{{ $p->created_at->format('d/m/Y') }}</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="6" class="td-empty"><div class="td-empty-wrap"><div class="td-empty-icon"><i class="fas fa-users"></i></div><div class="td-empty-lbl">لا يوجد أولياء أمور مسجلون بعد</div></div></td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Invoices --}}
                            <div class="tab-pane fade" id="tab-i">
                                <table class="act-table">
                                    <thead><tr><th>#</th><th>تاريخ الفاتورة</th><th>الصف</th><th>المرحلة</th><th>الحالة</th></tr></thead>
                                    <tbody>
                                        @forelse(\App\Models\Fee_invoice::latest()->take(5)->get() as $inv)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><span class="td-pill ok">{{ $inv->invoice_date ?? '—' }}</span></td>
                                                <td>{{ $inv->classroom->Name_Class ?? '—' }}</td>
                                                <td>{{ $inv->classroom->grade->Name ?? '—' }}</td>
                                                <td><span class="td-pill active">نشطة</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="td-empty"><div class="td-empty-wrap"><div class="td-empty-icon"><i class="fas fa-file-invoice"></i></div><div class="td-empty-lbl">لا توجد فواتير حتى الآن</div></div></td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Quick Actions + Status --}}
                <div class="right-col">
                    <div class="sec-title">الإجراءات السريعة</div>

                    <div class="quick-card">
                        <div class="panel-hd">
                            <div class="panel-hd-title">
                                <span class="panel-hd-icon phi-purple"><i class="fas fa-bolt"></i></span>
                                وصول سريع
                            </div>
                        </div>
                        <div class="qa-grid">
                            <a href="{{ route('Students.create') }}" class="qa-btn">
                                <div class="qa-ico" style="background:rgba(37,99,235,0.1);color:#2563eb;"><i class="fas fa-user-plus"></i></div>
                                <div class="qa-lbl">إضافة طالب</div>
                                <div class="qa-sub">تسجيل جديد</div>
                            </a>
                            <a href="{{ route('Teachers.index') }}" class="qa-btn">
                                <div class="qa-ico" style="background:rgba(217,119,6,0.1);color:#d97706;"><i class="fas fa-chalkboard-user"></i></div>
                                <div class="qa-lbl">المعلمون</div>
                                <div class="qa-sub">الهيئة التدريسية</div>
                            </a>
                            <a href="{{ route('Fees_Invoices.index') }}" class="qa-btn">
                                <div class="qa-ico" style="background:rgba(5,150,105,0.1);color:#059669;"><i class="fas fa-file-invoice-dollar"></i></div>
                                <div class="qa-lbl">الفواتير</div>
                                <div class="qa-sub">الرسوم الدراسية</div>
                            </a>
                            <a href="{{ route('Attendance.index') }}" class="qa-btn">
                                <div class="qa-ico" style="background:rgba(124,58,237,0.1);color:#7c3aed;"><i class="fas fa-calendar-check"></i></div>
                                <div class="qa-lbl">الحضور</div>
                                <div class="qa-sub">متابعة الغياب</div>
                            </a>
                            <a href="{{ route('Grades.index') }}" class="qa-btn">
                                <div class="qa-ico" style="background:rgba(239,68,68,0.1);color:#ef4444;"><i class="fas fa-layer-group"></i></div>
                                <div class="qa-lbl">المراحل</div>
                                <div class="qa-sub">الصفوف الدراسية</div>
                            </a>
                            <a href="{{ route('Sections.index') }}" class="qa-btn">
                                <div class="qa-ico" style="background:rgba(14,165,233,0.1);color:#0ea5e9;"><i class="fas fa-chalkboard"></i></div>
                                <div class="qa-lbl">الأقسام</div>
                                <div class="qa-sub">الفصول</div>
                            </a>
                            <a href="{{ route('Quizzes.index') }}" class="qa-btn">
                                <div class="qa-ico" style="background:rgba(245,158,11,0.1);color:#f59e0b;"><i class="fas fa-file-pen"></i></div>
                                <div class="qa-lbl">الاختبارات</div>
                                <div class="qa-sub">إدارة الأسئلة</div>
                            </a>
                            <a href="{{ route('settings.index') }}" class="qa-btn">
                                <div class="qa-ico" style="background:rgba(100,116,139,0.1);color:#64748b;"><i class="fas fa-gear"></i></div>
                                <div class="qa-lbl">الإعدادات</div>
                                <div class="qa-sub">ضبط النظام</div>
                            </a>
                        </div>
                    </div>

                    <div class="status-card">
                        <div class="panel-hd">
                            <div class="panel-hd-title">
                                <span class="panel-hd-icon phi-green"><i class="fas fa-server"></i></span>
                                حالة النظام
                            </div>
                        </div>
                        <div class="status-list">
                            <div class="status-row">
                                <div class="status-name"><span class="s-dot green"></span> قاعدة البيانات</div>
                                <span class="status-val ok">متصلة ✓</span>
                            </div>
                            <div class="status-row">
                                <div class="status-name"><span class="s-dot green"></span> خادم الموقع</div>
                                <span class="status-val ok">يعمل ✓</span>
                            </div>
                            <div class="status-row">
                                <div class="status-name"><span class="s-dot blue"></span> إصدار النظام</div>
                                <span class="status-val">v2.0</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Calendar --}}
            @livewire('calendar')

            @include('layouts.footer')
        </div>
    </div>

</div>

@include('layouts.footer-scripts')
@livewireScripts
@stack('scripts')

<script>
    // Arabic date
    const d = new Date();
    document.getElementById('currentDate').textContent =
        d.toLocaleDateString('ar-SA', { weekday:'long', year:'numeric', month:'long', day:'numeric' });

    // Tab sync
    document.querySelectorAll('.act-tab').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function () {
            document.querySelectorAll('.act-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
        $(tab).on('shown.bs.tab', function () {
            document.querySelectorAll('.act-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
        });
    });

    // Count-up animation on KPI numbers
    document.querySelectorAll('.kpi-num[data-target]').forEach(el => {
        const target = parseInt(el.dataset.target, 10);
        if (!target) return;
        let cur = 0;
        const step = Math.max(1, Math.ceil(target / 35));
        const timer = setInterval(() => {
            cur = Math.min(cur + step, target);
            el.textContent = cur;
            if (cur >= target) clearInterval(timer);
        }, 35);
    });
</script>
</body>
</html>
