@extends('layouts.master')

@section('title', trans('main_trans.Dashboard'))
@section('PageTitle', trans('main_trans.Dashboard'))

@section('css')
<style>
    /* ══════════════════════════════════════════
       PARENT DASHBOARD — Flat Corporate Style
       White background, Slate Gray text (#334155), Emerald Green accents (#059669)
       No gradients, no shadows, no icons.
    ══════════════════════════════════════════ */

    .flat-card { box-shadow: none !important; }

    /* ── Welcome header ── */
    .pd-welcome {
        background: #ffffff;
        border: 1px solid var(--border, #e2e8f0);
        border-radius: 0;
        padding: 24px 26px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }
    .pd-welcome-name { font-size: 1.3rem; font-weight: 800; color: #334155; margin-bottom: 4px; }
    .pd-welcome-name span { color: #059669; }
    .pd-welcome-sub { font-size: .8rem; color: #94a3b8; font-weight: 600; }
    .pd-welcome-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    .btn-flat-emerald {
        background: #059669;
        color: #ffffff;
        border: none;
        font-family: 'Cairo', sans-serif;
        font-weight: 700;
        border-radius: 0;
        padding: 9px 18px;
        font-size: .84rem;
        text-decoration: none;
        display: inline-block;
    }
    .btn-flat-emerald:hover { background: #047857; color: #ffffff; }

    .btn-flat-outline {
        background: #ffffff;
        color: #334155;
        border: 1px solid var(--border, #e2e8f0);
        font-family: 'Cairo', sans-serif;
        font-weight: 700;
        border-radius: 0;
        padding: 8px 16px;
        font-size: .82rem;
        text-decoration: none;
        display: inline-block;
    }
    .btn-flat-outline:hover { background: #f8fafc; color: #334155; }

    /* ── Section title ── */
    .pd-sec-title {
        font-size: .78rem; font-weight: 800; color: #94a3b8;
        text-transform: uppercase; letter-spacing: .8px;
        margin-bottom: 12px;
    }

    /* ── KPI CARDS — flat ── */
    .pd-kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 22px; }
    .pd-kpi-card {
        background: #ffffff;
        border: 1px solid var(--border, #e2e8f0);
        border-radius: 0;
        padding: 20px 20px 16px;
    }
    .pd-kpi-lbl { font-size: .82rem; font-weight: 600; color: #334155; margin-bottom: 6px; }
    .pd-kpi-num { font-size: 2rem; font-weight: 800; color: #059669; line-height: 1; margin-bottom: 10px; }
    .pd-kpi-num.muted { color: #94a3b8; }
    .pd-kpi-foot {
        display: flex; align-items: center; justify-content: space-between;
        padding-top: 10px; border-top: 1px solid #f1f5f9;
    }
    .pd-kpi-link { font-size: .78rem; font-weight: 700; color: #059669; text-decoration: none; }
    .pd-kpi-link:hover { color: #047857; }
    .pd-kpi-sub { font-size: .72rem; color: #94a3b8; font-weight: 600; }

    /* ── BODY: children + right column ── */
    .pd-body { display: grid; grid-template-columns: 1fr 320px; gap: 18px; margin-bottom: 22px; }

    .pd-panel-hd {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 20px; border-bottom: 1px solid #f1f5f9;
    }
    .pd-panel-title { font-size: .9rem; font-weight: 800; color: #334155; }

    /* ── Children grid ── */
    .pd-child-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; padding: 16px; }
    .pd-child-card {
        border: 1px solid var(--border, #e2e8f0);
        padding: 16px;
    }
    .pd-child-name { font-size: .92rem; font-weight: 800; color: #334155; margin-bottom: 2px; }
    .pd-child-sub { font-size: .74rem; color: #94a3b8; font-weight: 600; margin-bottom: 14px; }
    .pd-child-stats { display: flex; gap: 16px; margin-bottom: 14px; }
    .pd-child-stat-num { font-size: 1.2rem; font-weight: 800; color: #059669; line-height: 1; }
    .pd-child-stat-num.muted { color: #cbd5e1; }
    .pd-child-stat-lbl { font-size: .68rem; color: #94a3b8; font-weight: 600; }
    .pd-child-actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .pd-empty { padding: 40px 20px; text-align: center; color: #94a3b8; font-size: .8rem; font-weight: 600; grid-column: 1 / -1; }
    .pd-link-btn {
        display: inline-block; background: #ffffff; color: #059669;
        border: 1px solid #059669; border-radius: 0;
        padding: 4px 12px; font-size: .72rem; font-weight: 700; text-decoration: none;
    }
    .pd-link-btn:hover { background: #059669; color: #ffffff; }

    /* ── RIGHT COLUMN ── */
    .pd-right-col { display: flex; flex-direction: column; gap: 16px; }

    .pd-qa-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; padding: 14px; }
    .pd-qa-btn {
        display: flex; flex-direction: column; gap: 2px;
        padding: 12px 10px; border-radius: 0;
        text-decoration: none; color: #334155;
        border: 1px solid var(--border, #e2e8f0);
        background: #ffffff;
    }
    .pd-qa-btn:hover { background: #f8fafc; }
    .pd-qa-lbl { font-size: .78rem; font-weight: 700; color: #334155; }
    .pd-qa-sub { font-size: .68rem; color: #94a3b8; }

    /* Table */
    .pd-table { width: 100%; border-collapse: collapse; }
    .pd-table thead tr { background: #f8fafc; }
    .pd-table thead th {
        padding: 10px 14px; font-size: .7rem; font-weight: 700;
        color: #94a3b8; text-transform: uppercase; letter-spacing: .5px;
        border-bottom: 1px solid #f1f5f9; white-space: nowrap; text-align: center;
    }
    .pd-table tbody tr { border-bottom: 1px solid #f8fafc; }
    .pd-table tbody tr:last-child { border-bottom: none; }
    .pd-table tbody td { padding: 10px 14px; font-size: .8rem; color: #334155; text-align: center; vertical-align: middle; }
    .pd-pill {
        display: inline-flex; align-items: center; padding: 2px 9px;
        border-radius: 0; font-size: .68rem; font-weight: 700;
    }
    .pd-pill.ok  { background: #ecfdf5; color: #047857; }
    .pd-pill.bad { background: #fff1f2; color: #be123c; }
    .pd-table-empty { padding: 40px 20px !important; text-align: center; color: #94a3b8; font-size: .8rem; font-weight: 600; }

    /* ── RESPONSIVE ── */
    @media (max-width: 1200px) { .pd-kpi-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 1024px) { .pd-body { grid-template-columns: 1fr; } }
    @media (max-width: 768px)  { .pd-child-grid { grid-template-columns: 1fr; } }
    @media (max-width: 480px)  { .pd-kpi-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div>

    {{-- ══ WELCOME HEADER ══ --}}
    <div class="pd-welcome">
        <div>
            <div class="pd-welcome-name">
                {{ trans('Parent_trans.welcome_colon') }} <span>{{ $parent->Name_Father }}</span>
            </div>
            <div class="pd-welcome-sub">{{ trans('Parent_trans.parent_role_label') }}</div>
        </div>
        <div class="pd-welcome-actions">
            <a href="{{ route('sons.index') }}" class="btn-flat-emerald">{{ trans('Parent_trans.sidebar_children') }}</a>
            <a href="{{ route('profile.show.parent') }}" class="btn-flat-outline">{{ trans('Parent_trans.sidebar_profile') }}</a>
        </div>
    </div>

    {{-- ══ KPI CARDS ══ --}}
    <div class="pd-sec-title">{{ trans('Parent_trans.pd_overview') }}</div>
    <div class="pd-kpi-grid">

        <div class="pd-kpi-card flat-card">
            <div class="pd-kpi-lbl">{{ trans('Parent_trans.pd_children_count') }}</div>
            <div class="pd-kpi-num {{ $sons->count() > 0 ? '' : 'muted' }}">{{ $sons->count() }}</div>
            <div class="pd-kpi-foot">
                <a href="{{ route('sons.index') }}" class="pd-kpi-link">{{ trans('main_trans.dash_view_all') }}</a>
            </div>
        </div>

        <div class="pd-kpi-card flat-card">
            <div class="pd-kpi-lbl">{{ trans('Parent_trans.pd_attendance_rate') }}</div>
            <div class="pd-kpi-num {{ $attendanceRate === null ? 'muted' : '' }}">{{ $attendanceRate !== null ? $attendanceRate.'%' : '—' }}</div>
            <div class="pd-kpi-foot">
                <a href="{{ route('sons.attendances') }}" class="pd-kpi-link">{{ trans('main_trans.dash_view_all') }}</a>
            </div>
        </div>

        <div class="pd-kpi-card flat-card">
            <div class="pd-kpi-lbl">{{ trans('Parent_trans.pd_average_score') }}</div>
            <div class="pd-kpi-num {{ $averageScore === null ? 'muted' : '' }}">{{ $averageScore !== null ? $averageScore.'%' : '—' }}</div>
            <div class="pd-kpi-foot">
                <span class="pd-kpi-sub">{{ $averageScore === null ? trans('Parent_trans.pd_no_scores_yet') : '' }}</span>
            </div>
        </div>

        <div class="pd-kpi-card flat-card">
            <div class="pd-kpi-lbl">{{ trans('Parent_trans.pd_fee_balance') }}</div>
            <div class="pd-kpi-num {{ $feeBalance > 0 ? '' : 'muted' }}">{{ number_format($feeBalance, 2) }}</div>
            <div class="pd-kpi-foot">
                <a href="{{ route('sons.fees') }}" class="pd-kpi-link">{{ trans('main_trans.dash_view_all') }}</a>
            </div>
        </div>

    </div>

    {{-- ══ BODY: Children + Right panel ══ --}}
    <div class="pd-body">

        {{-- LEFT: Children grid --}}
        <div class="admin-card flat-card">
            <div class="pd-panel-hd">
                <span class="pd-panel-title">{{ trans('Parent_trans.pd_my_children') }}</span>
            </div>
            <div class="pd-child-grid">
                @forelse($sons as $son)
                    @php $stats = $childStats[$son->id]; @endphp
                    <div class="pd-child-card">
                        <div class="pd-child-name">{{ $son->name }}</div>
                        <div class="pd-child-sub">
                            {{ $son->grade->Name ?? '—' }} · {{ $son->classroom->Name_Class ?? '—' }} · {{ $son->section->Name_Section ?? '—' }}
                        </div>
                        <div class="pd-child-stats">
                            <div>
                                <div class="pd-child-stat-num {{ $stats['attendance_rate'] === null ? 'muted' : '' }}">
                                    {{ $stats['attendance_rate'] !== null ? $stats['attendance_rate'].'%' : '—' }}
                                </div>
                                <div class="pd-child-stat-lbl">{{ trans('Parent_trans.pd_attendance_rate') }}</div>
                            </div>
                            <div>
                                <div class="pd-child-stat-num {{ $stats['average_score'] === null ? 'muted' : '' }}">
                                    {{ $stats['average_score'] !== null ? $stats['average_score'].'%' : '—' }}
                                </div>
                                <div class="pd-child-stat-lbl">{{ trans('Parent_trans.pd_average_score') }}</div>
                            </div>
                            <div>
                                <div class="pd-child-stat-num {{ $stats['fee_balance'] > 0 ? '' : 'muted' }}">
                                    {{ number_format($stats['fee_balance'], 0) }}
                                </div>
                                <div class="pd-child-stat-lbl">{{ trans('Parent_trans.pd_fee_balance') }}</div>
                            </div>
                        </div>
                        <div class="pd-child-actions">
                            <a href="{{ route('sons.results', $son->id) }}" class="pd-link-btn">{{ trans('Parent_trans.pd_view_results') }}</a>
                            <a href="{{ route('sons.attendances') }}" class="pd-link-btn">{{ trans('Parent_trans.sidebar_attendance_report') }}</a>
                            <a href="{{ route('sons.fees') }}" class="pd-link-btn">{{ trans('Parent_trans.sidebar_financial_report') }}</a>
                        </div>
                    </div>
                @empty
                    <div class="pd-empty">{{ trans('Parent_trans.pd_no_children') }}</div>
                @endforelse
            </div>
        </div>

        {{-- RIGHT: Quick actions + Recent attendance --}}
        <div class="pd-right-col">

            <div class="admin-card flat-card">
                <div class="pd-panel-hd">
                    <span class="pd-panel-title">{{ trans('main_trans.dash_quick_access') }}</span>
                </div>
                <div class="pd-qa-grid">
                    <a href="{{ route('sons.index') }}" class="pd-qa-btn">
                        <span class="pd-qa-lbl">{{ trans('Parent_trans.sidebar_children') }}</span>
                        <span class="pd-qa-sub">{{ trans('Parent_trans.pd_qa_children_sub') }}</span>
                    </a>
                    <a href="{{ route('sons.attendances') }}" class="pd-qa-btn">
                        <span class="pd-qa-lbl">{{ trans('Parent_trans.sidebar_attendance_report') }}</span>
                        <span class="pd-qa-sub">{{ trans('Parent_trans.pd_qa_attendance_sub') }}</span>
                    </a>
                    <a href="{{ route('sons.fees') }}" class="pd-qa-btn">
                        <span class="pd-qa-lbl">{{ trans('Parent_trans.sidebar_financial_report') }}</span>
                        <span class="pd-qa-sub">{{ trans('Parent_trans.pd_qa_fees_sub') }}</span>
                    </a>
                    <a href="{{ route('profile.show.parent') }}" class="pd-qa-btn">
                        <span class="pd-qa-lbl">{{ trans('Parent_trans.sidebar_profile') }}</span>
                        <span class="pd-qa-sub">{{ trans('Parent_trans.pd_qa_profile_sub') }}</span>
                    </a>
                </div>
            </div>

            <div class="admin-card flat-card">
                <div class="pd-panel-hd">
                    <span class="pd-panel-title">{{ trans('Parent_trans.pd_recent_attendance') }}</span>
                </div>
                <table class="pd-table">
                    <thead><tr>
                        <th>{{ trans('Parent_trans.student_name') }}</th><th>{{ trans('main_trans.dash_col_date') }}</th><th>{{ trans('main_trans.status') }}</th>
                    </tr></thead>
                    <tbody>
                        @forelse($recentAttendance as $record)
                            <tr>
                                <td>{{ $record->students->name ?? '—' }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($record->attendence_date)->format('d/m/Y') }}</td>
                                <td>
                                    @if($record->attendence_status)
                                        <span class="pd-pill ok">{{ trans('Parent_trans.present') }}</span>
                                    @else
                                        <span class="pd-pill bad">{{ trans('Parent_trans.absent') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="pd-table-empty">{{ trans('Parent_trans.pd_no_attendance') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>
@endsection
