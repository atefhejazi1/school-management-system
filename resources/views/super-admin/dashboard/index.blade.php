@extends('layouts.super-admin.master')

@section('title', __('super_dash.dashboard'))

@section('content')

    <div class="ph-wrap">
        <div class="ph-title-group">
            <div class="ph-icon-wrap"><i class="fas fa-gauge-high"></i></div>
            <div>
                <h1 class="ph-title">{{ __('super_dash.dashboard') }}</h1>
                <p class="ph-subtitle">{{ __('super_dash.platform_sub') }}</p>
            </div>
        </div>
        <div class="ph-actions">
            <a href="{{ route('super-admin.school-requests.index') }}" class="btn btn-emerald btn-sm">
                <i class="fas fa-clipboard-list me-2"></i>{{ __('super_dash.school_requests') }}
            </a>
        </div>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="pf-stat-card">
                <div class="pf-stat-icon" style="background:#eff6ff; color:#1d4ed8;">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <div class="pf-stat-value">{{ $stats['total_schools'] }}</div>
                    <div class="pf-stat-label">{{ __('super_dash.total_schools') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="pf-stat-card">
                <div class="pf-stat-icon" style="background:var(--em-50); color:var(--em-600);">
                    <i class="fas fa-circle-check"></i>
                </div>
                <div>
                    <div class="pf-stat-value">{{ $stats['active_schools'] }}</div>
                    <div class="pf-stat-label">{{ __('super_dash.active_schools') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="pf-stat-card">
                <div class="pf-stat-icon" style="background:#fff1f2; color:#be123c;">
                    <i class="fas fa-ban"></i>
                </div>
                <div>
                    <div class="pf-stat-value">{{ $stats['suspended_schools'] }}</div>
                    <div class="pf-stat-label">{{ __('super_dash.suspended_schools') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="pf-stat-card">
                <div class="pf-stat-icon" style="background:#fffbeb; color:#92400e;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div class="pf-stat-value">{{ $stats['pending_requests'] }}</div>
                    <div class="pf-stat-label">{{ __('super_dash.pending_requests') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── عدّادات شاملة عبر كل المدارس على المنصة (Ecosystem-wide counters) ── --}}
    <div class="flat-counters-row mb-4">
        <div class="flat-counter">
            <div class="flat-counter-value">{{ $stats['total_students'] }}</div>
            <div class="flat-counter-label">{{ trans('super_dash.total_students_platform') }}</div>
        </div>
        <div class="flat-counter">
            <div class="flat-counter-value">{{ $stats['total_teachers'] }}</div>
            <div class="flat-counter-label">{{ trans('super_dash.total_teachers_platform') }}</div>
        </div>
        <div class="flat-counter">
            <div class="flat-counter-value">{{ $stats['total_parents'] }}</div>
            <div class="flat-counter-label">{{ trans('super_dash.total_parents_platform') }}</div>
        </div>
    </div>

    <style>
        /* عدّادات مسطّحة بالكامل: بدون تدرج لوني، بدون ظل، بدون أيقونات */
        .flat-counters-row { display: flex; gap: 16px; flex-wrap: wrap; }
        .flat-counter {
            flex: 1 1 220px;
            background: #ffffff;
            border: 1px solid var(--border, #e2e8f0);
            border-radius: 14px;
            padding: 20px 22px;
            text-align: center;
        }
        .flat-counter-value { font-size: 1.7rem; font-weight: 800; color: #059669; }
        .flat-counter-label { font-size: .82rem; font-weight: 600; color: #334155; margin-top: 4px; }
    </style>

    {{-- ── Quick shortcut card ── --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <span class="admin-card-title"><i class="fas fa-clipboard-list"></i>{{ __('super_dash.school_requests') }}</span>
            @if ($stats['pending_requests'] > 0)
                <span class="pill pill-warning"><i class="fas fa-clock"></i> {{ $stats['pending_requests'] }} {{ __('super_dash.pending_requests') }}</span>
            @endif
        </div>
        <div class="p-4">
            <p class="text-muted mb-3" style="font-size:.88rem;">
                {{ trans('super_dash.school_requests_review_desc') }}
            </p>
            <a href="{{ route('super-admin.school-requests.index') }}" class="btn btn-emerald">
                <i class="fas fa-arrow-up-right-from-square me-2"></i>{{ __('super_dash.school_requests') }}
            </a>
        </div>
    </div>

@endsection
