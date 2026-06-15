@extends('layouts.master')

@section('title', trans('main_trans.Dashboard_page'))
@section('PageTitle', trans('main_trans.Dashboard_page'))

@section('css')
<style>
    /* ══════════════════════════════════════════
       DASHBOARD — Minimal / Monochromatic
       Single accent: Emerald (--em-*)
       Neutrals: slate-50 through slate-900
    ══════════════════════════════════════════ */

    /* ── Welcome Banner ── */
    .welcome-banner {
        background: #1e293b;
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(0,0,0,.12);
    }
    /* Subtle dot pattern overlay */
    .welcome-banner::before {
        content: '';
        position: absolute; inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,.04) 1px, transparent 1px);
        background-size: 26px 26px;
        pointer-events: none;
    }
    /* Emerald accent stripe on the start edge */
    .welcome-banner::after {
        content: '';
        position: absolute;
        inset-block: 0; inset-inline-start: 0;
        width: 4px;
        border-radius: 0 4px 4px 0;
        background: linear-gradient(to bottom, var(--em-400), var(--em-700));
    }
    .wb-left  { position: relative; z-index: 1; }
    .wb-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,.07);
        border: 1px solid rgba(255,255,255,.1);
        color: rgba(255,255,255,.5);
        font-size: 10.5px; font-weight: 700; letter-spacing: .4px;
        padding: 3px 12px; border-radius: 20px; margin-bottom: 10px;
    }
    .wb-badge span { color: var(--em-400); }
    .wb-name {
        font-size: 26px; font-weight: 900;
        color: #fff; line-height: 1.2; margin-bottom: 4px;
    }
    .wb-name em { font-style: normal; color: var(--em-300); }
    .wb-date {
        font-size: 11.5px; color: rgba(255,255,255,.35);
        display: flex; align-items: center; gap: 6px;
        margin-bottom: 18px;
    }
    .wb-actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .wb-btn {
        display: inline-flex; align-items: center; gap: 7px;
        background: rgba(255,255,255,.07);
        border: 1px solid rgba(255,255,255,.1);
        color: rgba(255,255,255,.75);
        padding: 7px 16px; border-radius: 10px;
        font-size: 12px; font-weight: 600;
        text-decoration: none; font-family: 'Cairo', sans-serif;
        transition: all .2s;
    }
    .wb-btn:hover {
        background: rgba(16,185,129,.15);
        border-color: rgba(16,185,129,.3);
        color: var(--em-300);
    }
    .wb-btn.primary {
        background: rgba(16,185,129,.15);
        border-color: rgba(16,185,129,.3);
        color: var(--em-300);
    }
    .wb-btn.primary:hover {
        background: rgba(16,185,129,.25);
        border-color: rgba(16,185,129,.5);
    }

    /* Right side mini stats */
    .wb-right {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 10px; position: relative; z-index: 1;
        min-width: 280px;
    }
    .wb-stat {
        background: rgba(255,255,255,.05);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 14px; padding: 14px 16px;
        transition: background .2s;
    }
    .wb-stat:hover { background: rgba(255,255,255,.09); }
    .wb-stat-ico { font-size: 12px; color: var(--em-400); margin-bottom: 7px; }
    .wb-stat-num { font-size: 22px; font-weight: 900; color: #fff; line-height: 1; }
    .wb-stat-lbl { font-size: 10px; color: rgba(255,255,255,.38); font-weight: 500; margin-top: 2px; }

    /* ── Section title separator ── */
    .sec-title {
        font-size: 12px; font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase; letter-spacing: .8px;
        margin-bottom: 14px;
        display: flex; align-items: center; gap: 10px;
    }
    .sec-title::after {
        content: ''; flex: 1; height: 1px;
        background: linear-gradient(90deg, #e2e8f0, transparent);
    }

    /* ── KPI CARDS — clean white, single emerald icon ── */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 22px;
    }
    .kpi-card {
        background: #fff;
        border-radius: 18px;
        padding: 22px 20px 16px;
        border: 1px solid #e8edf5;
        box-shadow: 0 2px 12px rgba(0,0,0,.05);
        transition: transform .28s cubic-bezier(.22,.68,0,1.2),
                    box-shadow .28s ease,
                    border-color .28s ease;
    }
    .kpi-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 36px rgba(0,0,0,.1);
        border-color: var(--em-200, #a7f3d0);
    }
    .kpi-top {
        display: flex; align-items: flex-start;
        justify-content: space-between; margin-bottom: 16px;
    }
    .kpi-icon {
        width: 46px; height: 46px; border-radius: 13px;
        background: rgba(16,185,129,.08);
        border: 1.5px solid rgba(16,185,129,.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 19px; color: var(--em-600, #059669);
        transition: all .2s;
    }
    .kpi-card:hover .kpi-icon {
        background: rgba(16,185,129,.14);
        border-color: rgba(16,185,129,.3);
    }
    .kpi-trend {
        display: inline-flex; align-items: center; gap: 4px;
        background: rgba(16,185,129,.08);
        border: 1px solid rgba(16,185,129,.15);
        padding: 3px 9px; border-radius: 8px;
        font-size: 10px; font-weight: 700;
        color: var(--em-700, #047857);
    }
    .kpi-trend.flat {
        background: rgba(100,116,139,.07);
        border-color: rgba(100,116,139,.15);
        color: #64748b;
    }
    .kpi-num {
        font-size: 40px; font-weight: 900;
        color: #0f172a; line-height: 1;
        margin-bottom: 4px;
    }
    .kpi-lbl {
        font-size: 12px; font-weight: 600;
        color: #64748b; margin-bottom: 16px;
    }
    /* Spark line in neutral slate instead of white-on-color */
    .kpi-spark { width: 100%; height: 38px; margin-bottom: 14px; }
    .kpi-spark svg { width: 100%; height: 100%; overflow: visible; }
    .kpi-foot {
        display: flex; align-items: center;
        justify-content: space-between;
        padding-top: 11px;
        border-top: 1px solid #f1f5f9;
    }
    .kpi-link {
        font-size: 11px; font-weight: 700;
        color: var(--em-600, #059669);
        text-decoration: none;
        display: flex; align-items: center; gap: 5px;
        transition: gap .2s;
    }
    .kpi-link:hover { gap: 8px; color: var(--em-700, #047857); }
    .kpi-sub { font-size: 10.5px; color: #94a3b8; }

    /* ── ACTIVITY CARD ── */
    .dash-body {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 18px;
        margin-bottom: 22px;
    }
    .act-card {
        background: white;
        border-radius: 18px;
        box-shadow: 0 2px 12px rgba(0,0,0,.05);
        border: 1px solid #e8edf5;
        overflow: hidden;
    }
    .panel-hd {
        display: flex; align-items: center;
        justify-content: space-between;
        padding: 16px 20px 14px;
        border-bottom: 1px solid #f1f5f9;
    }
    .panel-hd-title {
        font-size: 13.5px; font-weight: 800; color: #0f172a;
        display: flex; align-items: center; gap: 9px;
    }
    .panel-hd-icon {
        width: 30px; height: 30px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; flex-shrink: 0;
        /* One style for all — emerald tint */
        background: rgba(16,185,129,.08);
        color: var(--em-600, #059669);
    }
    .panel-hd-link {
        font-size: 11px; font-weight: 700;
        color: var(--em-600, #059669);
        text-decoration: none;
        display: flex; align-items: center; gap: 4px;
        transition: gap .2s;
    }
    .panel-hd-link:hover { gap: 7px; }

    /* Tabs — emerald active instead of blue */
    .act-tabs {
        display: flex; padding: 0 16px;
        border-bottom: 1px solid #f1f5f9;
        gap: 2px;
    }
    .act-tab {
        padding: 10px 14px; font-size: 12px; font-weight: 600;
        color: #64748b; border-bottom: 2px solid transparent;
        cursor: pointer; text-decoration: none;
        transition: all .2s; display: flex; align-items: center; gap: 6px;
        background: none;
        border-left: none; border-right: none; border-top: none;
        font-family: 'Cairo', sans-serif;
    }
    .act-tab:hover {
        color: var(--em-600, #059669);
        background: rgba(16,185,129,.04);
    }
    .act-tab.active {
        color: var(--em-600, #059669);
        border-bottom-color: var(--em-500, #10b981);
    }
    .act-tab .tc {
        background: rgba(16,185,129,.1);
        color: var(--em-700, #047857);
        font-size: 9px; font-weight: 700;
        padding: 1px 6px; border-radius: 6px;
    }

    /* Table styles */
    .act-table { width: 100%; border-collapse: collapse; }
    .act-table thead tr { background: #f8fafc; }
    .act-table thead th {
        padding: 10px 14px; font-size: 10px; font-weight: 700;
        color: #94a3b8; text-transform: uppercase; letter-spacing: .7px;
        border-bottom: 1px solid #f1f5f9; white-space: nowrap;
        text-align: center;
    }
    .act-table tbody tr { border-bottom: 1px solid #f8fafc; transition: background .15s; }
    .act-table tbody tr:hover { background: #fafbfd; }
    .act-table tbody tr:last-child { border-bottom: none; }
    .act-table tbody td {
        padding: 10px 14px; font-size: 12px;
        color: #374151; text-align: center; vertical-align: middle;
    }
    .td-name {
        display: flex; align-items: center;
        gap: 8px; justify-content: center;
    }
    /* All avatars same emerald-tinted style */
    .td-av {
        width: 28px; height: 28px; border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; flex-shrink: 0;
        background: rgba(16,185,129,.1);
        color: var(--em-700, #047857);
    }
    .td-pill {
        display: inline-flex; align-items: center; gap: 3px;
        padding: 2px 8px; border-radius: 6px;
        font-size: 10px; font-weight: 700;
    }
    .td-pill.male    { background: #f1f5f9; color: #475569; }
    .td-pill.female  { background: #f1f5f9; color: #475569; }
    .td-pill.ok      { background: rgba(16,185,129,.08); color: var(--em-700,#047857); }
    .td-pill.active  { background: rgba(16,185,129,.08); color: var(--em-700,#047857); }
    .td-empty { padding: 44px 20px !important; text-align: center; }
    .td-empty-wrap  { display: flex; flex-direction: column; align-items: center; gap: 10px; }
    .td-empty-icon  { width: 48px; height: 48px; border-radius: 13px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #94a3b8; }
    .td-empty-lbl   { font-size: 12.5px; color: #94a3b8; font-weight: 600; }

    /* ── RIGHT COLUMN ── */
    .right-col { display: flex; flex-direction: column; gap: 16px; }
    .quick-card, .status-card {
        background: white;
        border-radius: 18px;
        box-shadow: 0 2px 12px rgba(0,0,0,.05);
        border: 1px solid #e8edf5;
        overflow: hidden;
    }

    /* Quick action grid — uniform emerald icon */
    .qa-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 8px; padding: 14px;
    }
    .qa-btn {
        display: flex; flex-direction: column; align-items: center; gap: 6px;
        padding: 14px 8px; border-radius: 13px;
        text-decoration: none; color: #1e293b;
        border: 1.5px solid #f1f5f9;
        transition: all .22s cubic-bezier(.22,.68,0,1.2);
        background: white;
    }
    .qa-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(0,0,0,.08);
        border-color: rgba(16,185,129,.25);
        color: #1e293b;
    }
    .qa-ico {
        width: 40px; height: 40px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
        background: rgba(16,185,129,.08);
        color: var(--em-600, #059669);
        transition: all .22s;
    }
    .qa-btn:hover .qa-ico {
        background: rgba(16,185,129,.14);
        transform: scale(1.08);
    }
    .qa-lbl { font-size: 11px; font-weight: 700; text-align: center; color: #374151; }
    .qa-sub { font-size: 9.5px; color: #94a3b8; text-align: center; }

    /* System status */
    .status-list { padding: 10px 18px 14px; }
    .status-row {
        display: flex; align-items: center;
        justify-content: space-between;
        padding: 10px 0; border-bottom: 1px solid #f8fafc;
    }
    .status-row:last-child { border-bottom: none; }
    .status-name {
        font-size: 12px; color: #374151; font-weight: 600;
        display: flex; align-items: center; gap: 8px;
    }
    .s-dot {
        width: 7px; height: 7px; border-radius: 50%;
        animation: sDotBlink 2.2s ease-in-out infinite;
    }
    .s-dot.green { background: var(--em-500, #10b981); }
    .s-dot.blue  { background: #64748b; }
    @keyframes sDotBlink { 0%,100% { opacity: 1; } 50% { opacity: .35; } }
    .status-val { font-size: 11.5px; font-weight: 700; color: #64748b; }
    .status-val.ok { color: var(--em-600, #059669); }

    /* ── RESPONSIVE ── */
    @media (max-width: 1200px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 1024px) { .dash-body { grid-template-columns: 1fr; } .wb-right { display: none; } }
    @media (max-width: 768px)  { .kpi-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; } .kpi-num { font-size: 32px; } .welcome-banner { padding: 20px; } .wb-name { font-size: 22px; } }
    @media (max-width: 480px)  { .kpi-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div>

    {{-- ══ WELCOME BANNER ══ --}}
    <div class="welcome-banner">
        <div class="wb-left">
            <div class="wb-badge">
                <i class="fas fa-circle" style="font-size:5px;color:var(--em-400);"></i>
                {{ trans('main_trans.system_active') }}
                <span>— {{ trans('main_trans.Dashboard_page') }}</span>
            </div>
            <div class="wb-name">
                {{ __('أهلاً،') }} <em>{{ auth()->user()->name ?? trans('main_trans.role_admin') }}</em>
            </div>
            <div class="wb-date">
                <i class="fas fa-calendar-alt"></i>
                <span id="currentDate"></span>
            </div>
            <div class="wb-actions">
                <a href="{{ route('Students.create') }}" class="wb-btn primary">
                    <i class="fas fa-user-plus"></i> {{ trans('main_trans.add_student') }}
                </a>
                <a href="{{ route('Teachers.index') }}" class="wb-btn">
                    <i class="fas fa-chalkboard-user"></i> {{ trans('main_trans.Teachers') }}
                </a>
                <a href="{{ route('Fees_Invoices.index') }}" class="wb-btn">
                    <i class="fas fa-file-invoice"></i> {{ trans('main_trans.invoices') }}
                </a>
                <a href="{{ route('settings.index') }}" class="wb-btn">
                    <i class="fas fa-gear"></i> {{ trans('main_trans.Settings') }}
                </a>
            </div>
        </div>

        <div class="wb-right">
            <div class="wb-stat">
                <div class="wb-stat-ico"><i class="fas fa-user-graduate"></i></div>
                <div class="wb-stat-num">{{ \App\Models\students::count() }}</div>
                <div class="wb-stat-lbl">{{ trans('main_trans.students') }}</div>
            </div>
            <div class="wb-stat">
                <div class="wb-stat-ico"><i class="fas fa-chalkboard-user"></i></div>
                <div class="wb-stat-num">{{ \App\Models\Teachers::count() }}</div>
                <div class="wb-stat-lbl">{{ trans('main_trans.Teachers') }}</div>
            </div>
            <div class="wb-stat">
                <div class="wb-stat-ico"><i class="fas fa-users"></i></div>
                <div class="wb-stat-num">{{ \App\Models\My_Parent::count() }}</div>
                <div class="wb-stat-lbl">{{ trans('main_trans.Parents') }}</div>
            </div>
            <div class="wb-stat">
                <div class="wb-stat-ico"><i class="fas fa-door-open"></i></div>
                <div class="wb-stat-num">{{ \App\Models\sections::count() }}</div>
                <div class="wb-stat-lbl">{{ trans('main_trans.sections') }}</div>
            </div>
        </div>
    </div>

    {{-- ══ KPI CARDS ══ --}}
    <div class="sec-title">{{ __('نظرة عامة على النظام') }}</div>
    <div class="kpi-grid">

        {{-- Students --}}
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon"><i class="fas fa-user-graduate"></i></div>
                <span class="kpi-trend">
                    <i class="fas fa-arrow-trend-up"></i> {{ __('نشط') }}
                </span>
            </div>
            <div class="kpi-num" data-target="{{ \App\Models\students::count() }}">
                {{ \App\Models\students::count() }}
            </div>
            <div class="kpi-lbl">{{ __('إجمالي الطلاب المسجلين') }}</div>
            <div class="kpi-spark">
                <svg viewBox="0 0 200 38" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="sg1" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="rgba(16,185,129,.22)"/>
                            <stop offset="100%" stop-color="rgba(16,185,129,0)"/>
                        </linearGradient>
                    </defs>
                    <path d="M0,34 C30,28 60,20 90,14 C120,8 150,5 180,3 L200,2"
                          fill="none" stroke="rgba(16,185,129,.55)" stroke-width="2" stroke-linecap="round"/>
                    <path d="M0,34 C30,28 60,20 90,14 C120,8 150,5 180,3 L200,2 L200,38 L0,38Z"
                          fill="url(#sg1)"/>
                </svg>
            </div>
            <div class="kpi-foot">
                <a href="{{ route('Students.index') }}" class="kpi-link">
                    {{ __('عرض الكل') }} <i class="fas fa-arrow-left"></i>
                </a>
                <span class="kpi-sub">
                    {{ \App\Models\students::whereDate('created_at', today())->count() }} {{ __('اليوم') }}
                </span>
            </div>
        </div>

        {{-- Teachers --}}
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon"><i class="fas fa-chalkboard-user"></i></div>
                <span class="kpi-trend">
                    <i class="fas fa-arrow-trend-up"></i> {{ __('نشط') }}
                </span>
            </div>
            <div class="kpi-num" data-target="{{ \App\Models\Teachers::count() }}">
                {{ \App\Models\Teachers::count() }}
            </div>
            <div class="kpi-lbl">{{ __('إجمالي المعلمين') }}</div>
            <div class="kpi-spark">
                <svg viewBox="0 0 200 38" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="sg2" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="rgba(16,185,129,.22)"/>
                            <stop offset="100%" stop-color="rgba(16,185,129,0)"/>
                        </linearGradient>
                    </defs>
                    <path d="M0,30 C30,24 60,18 90,12 C120,8 150,5 180,3 L200,2"
                          fill="none" stroke="rgba(16,185,129,.55)" stroke-width="2" stroke-linecap="round"/>
                    <path d="M0,30 C30,24 60,18 90,12 C120,8 150,5 180,3 L200,2 L200,38 L0,38Z"
                          fill="url(#sg2)"/>
                </svg>
            </div>
            <div class="kpi-foot">
                <a href="{{ route('Teachers.index') }}" class="kpi-link">
                    {{ __('عرض الكل') }} <i class="fas fa-arrow-left"></i>
                </a>
                <span class="kpi-sub">
                    {{ \App\Models\Teachers::whereDate('created_at', today())->count() }} {{ __('اليوم') }}
                </span>
            </div>
        </div>

        {{-- Parents --}}
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon"><i class="fas fa-users"></i></div>
                <span class="kpi-trend flat">
                    <i class="fas fa-minus"></i> {{ __('ثابت') }}
                </span>
            </div>
            <div class="kpi-num" data-target="{{ \App\Models\My_Parent::count() }}">
                {{ \App\Models\My_Parent::count() }}
            </div>
            <div class="kpi-lbl">{{ trans('main_trans.Parents') }}</div>
            <div class="kpi-spark">
                <svg viewBox="0 0 200 38" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="sg3" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="rgba(16,185,129,.22)"/>
                            <stop offset="100%" stop-color="rgba(16,185,129,0)"/>
                        </linearGradient>
                    </defs>
                    <path d="M0,22 C30,20 60,24 90,20 C120,17 150,21 180,19 L200,19"
                          fill="none" stroke="rgba(16,185,129,.45)" stroke-width="2" stroke-linecap="round"/>
                    <path d="M0,22 C30,20 60,24 90,20 C120,17 150,21 180,19 L200,19 L200,38 L0,38Z"
                          fill="url(#sg3)"/>
                </svg>
            </div>
            <div class="kpi-foot">
                <a href="{{ url('add_parent') }}" class="kpi-link">
                    {{ __('عرض الكل') }} <i class="fas fa-arrow-left"></i>
                </a>
                <span class="kpi-sub">
                    {{ \App\Models\My_Parent::whereDate('created_at', today())->count() }} {{ __('اليوم') }}
                </span>
            </div>
        </div>

        {{-- Sections --}}
        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon"><i class="fas fa-door-open"></i></div>
                <span class="kpi-trend flat">
                    <i class="fas fa-minus"></i> {{ __('ثابت') }}
                </span>
            </div>
            <div class="kpi-num" data-target="{{ \App\Models\sections::count() }}">
                {{ \App\Models\sections::count() }}
            </div>
            <div class="kpi-lbl">{{ __('الأقسام الدراسية') }}</div>
            <div class="kpi-spark">
                <svg viewBox="0 0 200 38" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="sg4" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="rgba(16,185,129,.22)"/>
                            <stop offset="100%" stop-color="rgba(16,185,129,0)"/>
                        </linearGradient>
                    </defs>
                    <path d="M0,20 C30,18 60,22 90,19 C120,17 150,20 180,18 L200,18"
                          fill="none" stroke="rgba(16,185,129,.45)" stroke-width="2" stroke-linecap="round"/>
                    <path d="M0,20 C30,18 60,22 90,19 C120,17 150,20 180,18 L200,18 L200,38 L0,38Z"
                          fill="url(#sg4)"/>
                </svg>
            </div>
            <div class="kpi-foot">
                <a href="{{ route('Sections.index') }}" class="kpi-link">
                    {{ __('عرض الكل') }} <i class="fas fa-arrow-left"></i>
                </a>
                <span class="kpi-sub">
                    {{ \App\Models\Classroom::count() }} {{ __('صف') }}
                </span>
            </div>
        </div>

    </div>

    {{-- ══ BODY: Activity + Right panel ══ --}}
    <div class="dash-body">

        {{-- LEFT: Recent activity tabs --}}
        <div>
            <div class="sec-title">{{ __('آخر العمليات') }}</div>
            <div class="act-card">
                <div class="panel-hd">
                    <div class="panel-hd-title">
                        <span class="panel-hd-icon"><i class="fas fa-clock-rotate-left"></i></span>
                        {{ __('سجل العمليات الأخيرة') }}
                    </div>
                    <a href="{{ route('Students.index') }}" class="panel-hd-link">
                        {{ __('عرض الكل') }} <i class="fas fa-arrow-left"></i>
                    </a>
                </div>

                <div class="act-tabs" id="actTabs">
                    <button class="act-tab active" data-tab="tab-s" type="button">
                        <i class="fas fa-user-graduate"></i> {{ trans('main_trans.students') }}
                        <span class="tc">{{ \App\Models\students::take(5)->count() }}</span>
                    </button>
                    <button class="act-tab" data-tab="tab-t" type="button">
                        <i class="fas fa-chalkboard-user"></i> {{ trans('main_trans.Teachers') }}
                    </button>
                    <button class="act-tab" data-tab="tab-p" type="button">
                        <i class="fas fa-users"></i> {{ trans('main_trans.Parents') }}
                    </button>
                    <button class="act-tab" data-tab="tab-i" type="button">
                        <i class="fas fa-file-invoice"></i> {{ trans('main_trans.invoices') }}
                    </button>
                </div>

                <div class="tab-content">

                    {{-- Students tab --}}
                    <div class="tab-pane fade show active" id="tab-s">
                        <table class="act-table">
                            <thead><tr>
                                <th>#</th><th>{{ __('الطالب') }}</th><th>{{ __('البريد') }}</th>
                                <th>{{ __('النوع') }}</th><th>{{ __('المرحلة') }}</th>
                                <th>{{ __('الصف') }}</th><th>{{ __('القسم') }}</th><th>{{ __('التاريخ') }}</th>
                            </tr></thead>
                            <tbody>
                                @forelse(\App\Models\Students::latest()->take(5)->get() as $s)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="td-name">
                                                <div class="td-av">{{ mb_substr($s->name, 0, 1) }}</div>
                                                {{ $s->name }}
                                            </div>
                                        </td>
                                        <td>{{ $s->email }}</td>
                                        <td>
                                            @if($s->gender)
                                                <span class="td-pill {{ $s->gender->Name == 'ذكر' ? 'male' : 'female' }}">
                                                    {{ $s->gender->Name }}
                                                </span>
                                            @else <span style="color:#cbd5e1">—</span> @endif
                                        </td>
                                        <td>{{ $s->grade->Name ?? '—' }}</td>
                                        <td>{{ $s->classroom->Name_Class ?? '—' }}</td>
                                        <td>{{ $s->section->Name_Section ?? '—' }}</td>
                                        <td><span class="td-pill ok">{{ $s->created_at->format('d/m/Y') }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="td-empty">
                                        <div class="td-empty-wrap">
                                            <div class="td-empty-icon"><i class="fas fa-user-graduate"></i></div>
                                            <div class="td-empty-lbl">{{ __('لا يوجد طلاب مسجلون بعد') }}</div>
                                        </div>
                                    </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Teachers tab --}}
                    <div class="tab-pane fade" id="tab-t">
                        <table class="act-table">
                            <thead><tr>
                                <th>#</th><th>{{ __('المعلم') }}</th><th>{{ __('النوع') }}</th>
                                <th>{{ __('تاريخ التعيين') }}</th><th>{{ __('التخصص') }}</th><th>{{ __('التاريخ') }}</th>
                            </tr></thead>
                            <tbody>
                                @forelse(\App\Models\Teachers::latest()->take(5)->get() as $t)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="td-name">
                                                <div class="td-av">{{ mb_substr($t->Name, 0, 1) }}</div>
                                                {{ $t->Name }}
                                            </div>
                                        </td>
                                        <td>{{ $t->genders->Name ?? '—' }}</td>
                                        <td>{{ $t->Joining_Date ?? '—' }}</td>
                                        <td>{{ $t->specializations->Name ?? '—' }}</td>
                                        <td><span class="td-pill ok">{{ $t->created_at->format('d/m/Y') }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="td-empty">
                                        <div class="td-empty-wrap">
                                            <div class="td-empty-icon"><i class="fas fa-chalkboard-user"></i></div>
                                            <div class="td-empty-lbl">{{ __('لا يوجد معلمون مسجلون بعد') }}</div>
                                        </div>
                                    </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Parents tab --}}
                    <div class="tab-pane fade" id="tab-p">
                        <table class="act-table">
                            <thead><tr>
                                <th>#</th><th>{{ __('ولي الأمر') }}</th><th>{{ __('البريد') }}</th>
                                <th>{{ __('رقم الهوية') }}</th><th>{{ __('الهاتف') }}</th><th>{{ __('التاريخ') }}</th>
                            </tr></thead>
                            <tbody>
                                @forelse(\App\Models\My_Parent::latest()->take(5)->get() as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="td-name">
                                                <div class="td-av">{{ mb_substr($p->Name_Father, 0, 1) }}</div>
                                                {{ $p->Name_Father }}
                                            </div>
                                        </td>
                                        <td>{{ $p->email }}</td>
                                        <td>{{ $p->National_ID_Father ?? '—' }}</td>
                                        <td>{{ $p->Phone_Father ?? '—' }}</td>
                                        <td><span class="td-pill ok">{{ $p->created_at->format('d/m/Y') }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="td-empty">
                                        <div class="td-empty-wrap">
                                            <div class="td-empty-icon"><i class="fas fa-users"></i></div>
                                            <div class="td-empty-lbl">{{ __('لا يوجد أولياء أمور مسجلون بعد') }}</div>
                                        </div>
                                    </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Invoices tab --}}
                    <div class="tab-pane fade" id="tab-i">
                        <table class="act-table">
                            <thead><tr>
                                <th>#</th><th>{{ __('تاريخ الفاتورة') }}</th><th>{{ __('الصف') }}</th>
                                <th>{{ __('المرحلة') }}</th><th>{{ __('الحالة') }}</th>
                            </tr></thead>
                            <tbody>
                                @forelse(\App\Models\Fee_invoice::latest()->take(5)->get() as $inv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><span class="td-pill ok">{{ $inv->invoice_date ?? '—' }}</span></td>
                                        <td>{{ $inv->classroom->Name_Class ?? '—' }}</td>
                                        <td>{{ $inv->classroom->grade->Name ?? '—' }}</td>
                                        <td><span class="td-pill active">{{ __('نشطة') }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="td-empty">
                                        <div class="td-empty-wrap">
                                            <div class="td-empty-icon"><i class="fas fa-file-invoice"></i></div>
                                            <div class="td-empty-lbl">{{ __('لا توجد فواتير حتى الآن') }}</div>
                                        </div>
                                    </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        {{-- RIGHT: Quick actions + System status --}}
        <div class="right-col">
            <div class="sec-title">{{ __('الإجراءات السريعة') }}</div>

            <div class="quick-card">
                <div class="panel-hd">
                    <div class="panel-hd-title">
                        <span class="panel-hd-icon"><i class="fas fa-bolt"></i></span>
                        {{ __('وصول سريع') }}
                    </div>
                </div>
                <div class="qa-grid">
                    <a href="{{ route('Students.create') }}" class="qa-btn">
                        <div class="qa-ico"><i class="fas fa-user-plus"></i></div>
                        <div class="qa-lbl">{{ trans('main_trans.add_student') }}</div>
                        <div class="qa-sub">{{ __('تسجيل جديد') }}</div>
                    </a>
                    <a href="{{ route('Teachers.index') }}" class="qa-btn">
                        <div class="qa-ico"><i class="fas fa-chalkboard-user"></i></div>
                        <div class="qa-lbl">{{ trans('main_trans.Teachers') }}</div>
                        <div class="qa-sub">{{ __('الهيئة التدريسية') }}</div>
                    </a>
                    <a href="{{ route('Fees_Invoices.index') }}" class="qa-btn">
                        <div class="qa-ico"><i class="fas fa-file-invoice-dollar"></i></div>
                        <div class="qa-lbl">{{ trans('main_trans.invoices') }}</div>
                        <div class="qa-sub">{{ __('الرسوم الدراسية') }}</div>
                    </a>
                    <a href="{{ route('Attendance.index') }}" class="qa-btn">
                        <div class="qa-ico"><i class="fas fa-calendar-check"></i></div>
                        <div class="qa-lbl">{{ trans('main_trans.Attendance') }}</div>
                        <div class="qa-sub">{{ __('متابعة الغياب') }}</div>
                    </a>
                    <a href="{{ route('Grades.index') }}" class="qa-btn">
                        <div class="qa-ico"><i class="fas fa-layer-group"></i></div>
                        <div class="qa-lbl">{{ trans('main_trans.Grades') }}</div>
                        <div class="qa-sub">{{ __('الصفوف الدراسية') }}</div>
                    </a>
                    <a href="{{ route('Sections.index') }}" class="qa-btn">
                        <div class="qa-ico"><i class="fas fa-chalkboard"></i></div>
                        <div class="qa-lbl">{{ trans('main_trans.sections') }}</div>
                        <div class="qa-sub">{{ __('الفصول') }}</div>
                    </a>
                    <a href="{{ route('Quizzes.index') }}" class="qa-btn">
                        <div class="qa-ico"><i class="fas fa-file-pen"></i></div>
                        <div class="qa-lbl">{{ trans('main_trans.quizzes') }}</div>
                        <div class="qa-sub">{{ __('إدارة الأسئلة') }}</div>
                    </a>
                    <a href="{{ route('settings.index') }}" class="qa-btn">
                        <div class="qa-ico"><i class="fas fa-gear"></i></div>
                        <div class="qa-lbl">{{ trans('main_trans.Settings') }}</div>
                        <div class="qa-sub">{{ __('ضبط النظام') }}</div>
                    </a>
                </div>
            </div>

            <div class="status-card">
                <div class="panel-hd">
                    <div class="panel-hd-title">
                        <span class="panel-hd-icon"><i class="fas fa-server"></i></span>
                        {{ __('حالة النظام') }}
                    </div>
                </div>
                <div class="status-list">
                    <div class="status-row">
                        <div class="status-name">
                            <span class="s-dot green"></span> {{ __('قاعدة البيانات') }}
                        </div>
                        <span class="status-val ok">{{ __('متصلة') }} ✓</span>
                    </div>
                    <div class="status-row">
                        <div class="status-name">
                            <span class="s-dot green"></span> {{ __('خادم الموقع') }}
                        </div>
                        <span class="status-val ok">{{ __('يعمل') }} ✓</span>
                    </div>
                    <div class="status-row">
                        <div class="status-name">
                            <span class="s-dot blue"></span> {{ __('إصدار النظام') }}
                        </div>
                        <span class="status-val">v2.0</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Calendar Livewire component --}}
    @livewire('calendar')

</div>
@endsection

@section('js')
<script>
    // Arabic date
    const dateEl = document.getElementById('currentDate');
    if (dateEl) {
        dateEl.textContent = new Date().toLocaleDateString('ar-SA', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
    }

    // Plain JS tab switcher
    document.querySelectorAll('#actTabs .act-tab').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var targetId = this.getAttribute('data-tab');
            document.querySelectorAll('#actTabs .act-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.tab-content .tab-pane').forEach(p => p.classList.remove('show', 'active'));
            var pane = document.getElementById(targetId);
            if (pane) pane.classList.add('show', 'active');
        });
    });

    // Count-up animation on KPI numbers
    document.querySelectorAll('.kpi-num[data-target]').forEach(function (el) {
        var target = parseInt(el.dataset.target, 10);
        if (!target) return;
        var cur = 0, step = Math.max(1, Math.ceil(target / 35));
        var timer = setInterval(function () {
            cur = Math.min(cur + step, target);
            el.textContent = cur;
            if (cur >= target) clearInterval(timer);
        }, 32);
    });
</script>
@endsection
