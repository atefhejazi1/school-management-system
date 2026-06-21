@extends('layouts.master')

@section('title', trans('main_trans.Dashboard'))
@section('PageTitle', trans('main_trans.Dashboard'))

@section('css')
<style>
    /* ══════════════════════════════════════════
       STUDENT DASHBOARD — Flat Corporate Style
       White background, Slate Gray text (#334155), Emerald Green accents (#059669)
       No gradients, no shadows, no icons.
    ══════════════════════════════════════════ */

    .flat-card { box-shadow: none !important; }

    /* ── Welcome header ── */
    .sd-welcome {
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
    .sd-welcome-name { font-size: 1.3rem; font-weight: 800; color: #334155; margin-bottom: 4px; }
    .sd-welcome-name span { color: #059669; }
    .sd-welcome-sub { font-size: .8rem; color: #94a3b8; font-weight: 600; }
    .sd-welcome-actions { display: flex; gap: 8px; flex-wrap: wrap; }

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
    .sd-sec-title {
        font-size: .78rem; font-weight: 800; color: #94a3b8;
        text-transform: uppercase; letter-spacing: .8px;
        margin-bottom: 12px;
    }

    /* ── KPI CARDS — flat ── */
    .sd-kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 22px; }
    .sd-kpi-card {
        background: #ffffff;
        border: 1px solid var(--border, #e2e8f0);
        border-radius: 0;
        padding: 20px 20px 16px;
    }
    .sd-kpi-lbl { font-size: .82rem; font-weight: 600; color: #334155; margin-bottom: 6px; }
    .sd-kpi-num { font-size: 2rem; font-weight: 800; color: #059669; line-height: 1; margin-bottom: 10px; }
    .sd-kpi-num.muted { color: #94a3b8; }
    .sd-kpi-foot {
        display: flex; align-items: center; justify-content: space-between;
        padding-top: 10px; border-top: 1px solid #f1f5f9;
    }
    .sd-kpi-link { font-size: .78rem; font-weight: 700; color: #059669; text-decoration: none; }
    .sd-kpi-link:hover { color: #047857; }
    .sd-kpi-sub { font-size: .72rem; color: #94a3b8; font-weight: 600; }

    /* ── BODY: activity + right column ── */
    .sd-body { display: grid; grid-template-columns: 1fr 320px; gap: 18px; margin-bottom: 22px; }

    .sd-panel-hd {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 20px; border-bottom: 1px solid #f1f5f9;
    }
    .sd-panel-title { font-size: .9rem; font-weight: 800; color: #334155; }
    .sd-panel-link { font-size: .75rem; font-weight: 700; color: #059669; text-decoration: none; }
    .sd-panel-link:hover { color: #047857; }

    /* Tabs — flat, text only */
    .sd-tabs { display: flex; padding: 0 16px; border-bottom: 1px solid #f1f5f9; gap: 4px; flex-wrap: wrap; }
    .sd-tab {
        padding: 10px 14px; font-size: .8rem; font-weight: 700;
        color: #94a3b8; border: none; background: none;
        border-bottom: 2px solid transparent;
        cursor: pointer; font-family: 'Cairo', sans-serif;
    }
    .sd-tab:hover { color: #334155; }
    .sd-tab.active { color: #059669; border-bottom-color: #059669; }

    /* Table */
    .sd-table { width: 100%; border-collapse: collapse; }
    .sd-table thead tr { background: #f8fafc; }
    .sd-table thead th {
        padding: 10px 14px; font-size: .7rem; font-weight: 700;
        color: #94a3b8; text-transform: uppercase; letter-spacing: .5px;
        border-bottom: 1px solid #f1f5f9; white-space: nowrap; text-align: center;
    }
    .sd-table tbody tr { border-bottom: 1px solid #f8fafc; }
    .sd-table tbody tr:last-child { border-bottom: none; }
    .sd-table tbody td { padding: 10px 14px; font-size: .8rem; color: #334155; text-align: center; vertical-align: middle; }
    .sd-pill {
        display: inline-flex; align-items: center; padding: 2px 9px;
        border-radius: 0; font-size: .68rem; font-weight: 700;
    }
    .sd-pill.neutral { background: #f1f5f9; color: #475569; }
    .sd-pill.ok      { background: #ecfdf5; color: #047857; }
    .sd-pill.warn    { background: #fffbeb; color: #92400e; }
    .sd-pill.bad     { background: #fff1f2; color: #be123c; }
    .sd-empty { padding: 40px 20px !important; text-align: center; color: #94a3b8; font-size: .8rem; font-weight: 600; }
    .sd-link-btn {
        display: inline-block; background: #ffffff; color: #059669;
        border: 1px solid #059669; border-radius: 0;
        padding: 4px 12px; font-size: .72rem; font-weight: 700; text-decoration: none;
    }
    .sd-link-btn:hover { background: #059669; color: #ffffff; }

    /* ── RIGHT COLUMN ── */
    .sd-right-col { display: flex; flex-direction: column; gap: 16px; }

    .sd-qa-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; padding: 14px; }
    .sd-qa-btn {
        display: flex; flex-direction: column; gap: 2px;
        padding: 12px 10px; border-radius: 0;
        text-decoration: none; color: #334155;
        border: 1px solid var(--border, #e2e8f0);
        background: #ffffff;
    }
    .sd-qa-btn:hover { background: #f8fafc; }
    .sd-qa-lbl { font-size: .78rem; font-weight: 700; color: #334155; }
    .sd-qa-sub { font-size: .68rem; color: #94a3b8; }

    .sd-status-list { padding: 8px 18px 14px; }
    .sd-status-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 0; border-bottom: 1px solid #f8fafc;
    }
    .sd-status-row:last-child { border-bottom: none; }
    .sd-status-name { font-size: .8rem; color: #334155; font-weight: 600; }
    .sd-status-val { font-size: .76rem; font-weight: 700; color: #94a3b8; }
    .sd-status-val.ok { color: #059669; }

    /* Upcoming online classes list */
    .sd-class-list { padding: 4px 18px 14px; }
    .sd-class-row {
        padding: 12px 0; border-bottom: 1px solid #f8fafc;
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
    }
    .sd-class-row:last-child { border-bottom: none; }
    .sd-class-topic { font-size: .82rem; font-weight: 700; color: #334155; margin-bottom: 2px; }
    .sd-class-time { font-size: .72rem; color: #94a3b8; font-weight: 600; }
    .sd-class-empty { padding: 22px 18px; text-align: center; color: #94a3b8; font-size: .78rem; font-weight: 600; }

    /* ── RESPONSIVE ── */
    @media (max-width: 1200px) { .sd-kpi-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 1024px) { .sd-body { grid-template-columns: 1fr; } }
    @media (max-width: 480px)  { .sd-kpi-grid { grid-template-columns: 1fr; } }

    /* ── CALENDAR — flatten FullCalendar's default theme to match Slate/Emerald ── */
    .sd-calendar-wrap { padding: 18px; }
    .sd-calendar-wrap .fc {
        --fc-border-color: #f1f5f9;
        --fc-page-bg-color: #ffffff;
        --fc-neutral-bg-color: #f8fafc;
        --fc-list-event-hover-bg-color: #f8fafc;
        --fc-today-bg-color: #ecfdf5;
        --fc-button-bg-color: #ffffff;
        --fc-button-border-color: var(--border, #e2e8f0);
        --fc-button-hover-bg-color: #f8fafc;
        --fc-button-hover-border-color: var(--border, #e2e8f0);
        --fc-button-active-bg-color: #059669;
        --fc-button-active-border-color: #059669;
        --fc-event-bg-color: #059669;
        --fc-event-border-color: #059669;
        font-family: 'Cairo', sans-serif;
    }
    .sd-calendar-wrap .fc .fc-button { box-shadow: none !important; color: #334155; font-weight: 700; text-transform: none; }
    .sd-calendar-wrap .fc .fc-button:focus { box-shadow: none !important; }
    .sd-calendar-wrap .fc .fc-button-primary:not(:disabled).fc-button-active,
    .sd-calendar-wrap .fc .fc-button-primary:not(:disabled):active { color: #ffffff; }
    .sd-calendar-wrap .fc .fc-toolbar-title { font-size: 1rem; font-weight: 800; color: #334155; }
    .sd-calendar-wrap .fc .fc-daygrid-day-number,
    .sd-calendar-wrap .fc .fc-col-header-cell-cushion { color: #334155; }
</style>
@endsection

@section('content')
<div>

    {{-- ══ WELCOME HEADER ══ --}}
    <div class="sd-welcome">
        <div>
            <div class="sd-welcome-name">
                {{ trans('Students_trans.Welcome_message') }}، <span>{{ $student->name }}</span>
            </div>
            <div class="sd-welcome-sub">
                {{ $student->grade->Name ?? '—' }} · {{ $student->classroom->Name_Class ?? '—' }} · {{ $student->section->Name_Section ?? '—' }}
            </div>
        </div>
        <div class="sd-welcome-actions">
            <a href="{{ route('student_exams.index') }}" class="btn-flat-emerald">{{ trans('Students_trans.Exams') }}</a>
            <a href="{{ route('profile-student.index') }}" class="btn-flat-outline">{{ trans('Students_trans.Personal_profile') }}</a>
        </div>
    </div>

    {{-- ══ KPI CARDS ══ --}}
    <div class="sd-sec-title">{{ trans('Students_trans.sd_overview') }}</div>
    <div class="sd-kpi-grid">

        <div class="sd-kpi-card flat-card">
            <div class="sd-kpi-lbl">{{ trans('Students_trans.sd_attendance_rate') }}</div>
            <div class="sd-kpi-num {{ $attendanceRate === null ? 'muted' : '' }}">{{ $attendanceRate !== null ? $attendanceRate.'%' : '—' }}</div>
            <div class="sd-kpi-foot">
                <span class="sd-kpi-sub">{{ trans('Students_trans.sd_days_present', ['present' => $attendancePresent, 'total' => $attendanceTotal]) }}</span>
            </div>
        </div>

        <div class="sd-kpi-card flat-card">
            <div class="sd-kpi-lbl">{{ trans('Students_trans.sd_average_score') }}</div>
            <div class="sd-kpi-num {{ $averageScore === null ? 'muted' : '' }}">{{ $averageScore !== null ? $averageScore.'%' : '—' }}</div>
            <div class="sd-kpi-foot">
                <a href="{{ route('student_exams.index') }}" class="sd-kpi-link">{{ trans('main_trans.dash_view_all') }}</a>
                <span class="sd-kpi-sub">{{ trans('Students_trans.sd_quizzes_taken', ['count' => $degrees->pluck('quizze_id')->unique()->count()]) }}</span>
            </div>
        </div>

        <div class="sd-kpi-card flat-card">
            <div class="sd-kpi-lbl">{{ trans('Students_trans.sd_fee_balance') }}</div>
            <div class="sd-kpi-num {{ $feeBalance > 0 ? '' : 'muted' }}">{{ number_format($feeBalance, 2) }}</div>
            <div class="sd-kpi-foot">
                <span class="sd-kpi-sub">{{ trans('Students_trans.sd_invoices_count', ['count' => $invoices->count()]) }}</span>
            </div>
        </div>

        <div class="sd-kpi-card flat-card">
            <div class="sd-kpi-lbl">{{ trans('Students_trans.sd_upcoming_classes') }}</div>
            <div class="sd-kpi-num {{ $onlineClasses->count() > 0 ? '' : 'muted' }}">{{ $onlineClasses->count() }}</div>
            <div class="sd-kpi-foot">
                <span class="sd-kpi-sub">{{ trans('Students_trans.sd_next_days') }}</span>
            </div>
        </div>

    </div>

    {{-- ══ BODY: Grades/Attendance/Invoices + Right panel ══ --}}
    <div class="sd-body">

        {{-- LEFT: Tabs --}}
        <div class="admin-card flat-card">
            <div class="sd-panel-hd">
                <span class="sd-panel-title">{{ trans('Students_trans.sd_academic_activity') }}</span>
            </div>

            <div class="sd-tabs" id="sdTabs">
                <button class="sd-tab active" data-tab="sd-tab-g" type="button">{{ trans('Students_trans.sd_tab_grades') }}</button>
                <button class="sd-tab" data-tab="sd-tab-a" type="button">{{ trans('Students_trans.sd_tab_attendance') }}</button>
                <button class="sd-tab" data-tab="sd-tab-i" type="button">{{ trans('Students_trans.sd_tab_invoices') }}</button>
            </div>

            <div class="tab-content">

                {{-- Grades / Exams tab --}}
                <div class="tab-pane fade show active" id="sd-tab-g">
                    <table class="sd-table">
                        <thead><tr>
                            <th>#</th><th>{{ trans('Students_trans.Subject') }}</th><th>{{ trans('Students_trans.Exam_name') }}</th>
                            <th>{{ trans('Students_trans.sd_col_score') }}</th><th>{{ trans('Students_trans.Entry_or_score') }}</th>
                        </tr></thead>
                        <tbody>
                            @forelse($quizzes as $quiz)
                                @php
                                    $quizDegrees = $degrees->where('quizze_id', $quiz->id);
                                    $maxScore = $quizMaxScores[$quiz->id] ?? 0;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $quiz->subject->name ?? '—' }}</td>
                                    <td>{{ $quiz->name }}</td>
                                    <td>
                                        @if($quizDegrees->isNotEmpty())
                                            <span class="sd-pill ok">{{ $quizDegrees->sum('score') }} / {{ $maxScore }}</span>
                                        @else
                                            <span class="sd-pill neutral">{{ trans('Students_trans.sd_not_taken') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($quizDegrees->isEmpty())
                                            <a href="{{ route('student_exams.show', $quiz->id) }}" class="sd-link-btn">{{ trans('Students_trans.Take_exam') }}</a>
                                        @else
                                            <span style="color:#cbd5e1">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="sd-empty">{{ trans('Students_trans.sd_no_quizzes') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Attendance tab --}}
                <div class="tab-pane fade" id="sd-tab-a">
                    <table class="sd-table">
                        <thead><tr>
                            <th>#</th><th>{{ trans('main_trans.dash_col_date') }}</th><th>{{ trans('main_trans.status') }}</th>
                        </tr></thead>
                        <tbody>
                            @forelse($attendanceRecords as $record)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Illuminate\Support\Carbon::parse($record->attendence_date)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($record->attendence_status)
                                            <span class="sd-pill ok">{{ trans('Students_trans.sd_present') }}</span>
                                        @else
                                            <span class="sd-pill bad">{{ trans('Students_trans.sd_absent') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="sd-empty">{{ trans('Students_trans.sd_no_attendance') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Invoices tab --}}
                <div class="tab-pane fade" id="sd-tab-i">
                    <table class="sd-table">
                        <thead><tr>
                            <th>#</th><th>{{ trans('main_trans.dash_col_date') }}</th><th>{{ trans('Fees_trans.invoice_total_amount') }}</th>
                            <th>{{ trans('Fees_trans.invoice_balance_amount') }}</th><th>{{ trans('Fees_trans.status') }}</th>
                        </tr></thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $invoice->invoice_date ?? '—' }}</td>
                                    <td>{{ number_format($invoice->amount, 2) }}</td>
                                    <td>{{ number_format($invoice->balance_amount, 2) }}</td>
                                    <td>
                                        @if($invoice->status === 'paid')
                                            <span class="sd-pill ok">{{ trans('Fees_trans.status_paid') }}</span>
                                        @elseif($invoice->status === 'partially_paid')
                                            <span class="sd-pill warn">{{ trans('Fees_trans.status_partially_paid') }}</span>
                                        @else
                                            <span class="sd-pill bad">{{ trans('Fees_trans.status_unpaid') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="sd-empty">{{ trans('main_trans.dash_no_invoices') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        {{-- RIGHT: Quick actions + Class info + Upcoming online classes --}}
        <div class="sd-right-col">

            <div class="admin-card flat-card">
                <div class="sd-panel-hd">
                    <span class="sd-panel-title">{{ trans('main_trans.dash_quick_access') }}</span>
                </div>
                <div class="sd-qa-grid">
                    <a href="{{ route('student_exams.index') }}" class="sd-qa-btn">
                        <span class="sd-qa-lbl">{{ trans('Students_trans.Exams') }}</span>
                        <span class="sd-qa-sub">{{ trans('Students_trans.Exams_list') }}</span>
                    </a>
                    <a href="{{ route('profile-student.index') }}" class="sd-qa-btn">
                        <span class="sd-qa-lbl">{{ trans('Students_trans.Personal_profile') }}</span>
                        <span class="sd-qa-sub">{{ trans('Students_trans.sd_qa_edit_account') }}</span>
                    </a>
                </div>
            </div>

            <div class="admin-card flat-card">
                <div class="sd-panel-hd">
                    <span class="sd-panel-title">{{ trans('Students_trans.sd_class_info') }}</span>
                </div>
                <div class="sd-status-list">
                    <div class="sd-status-row">
                        <span class="sd-status-name">{{ trans('Students_trans.Grade') }}</span>
                        <span class="sd-status-val">{{ $student->grade->Name ?? '—' }}</span>
                    </div>
                    <div class="sd-status-row">
                        <span class="sd-status-name">{{ trans('Students_trans.classrooms') }}</span>
                        <span class="sd-status-val">{{ $student->classroom->Name_Class ?? '—' }}</span>
                    </div>
                    <div class="sd-status-row">
                        <span class="sd-status-name">{{ trans('Students_trans.section') }}</span>
                        <span class="sd-status-val">{{ $student->section->Name_Section ?? '—' }}</span>
                    </div>
                    <div class="sd-status-row">
                        <span class="sd-status-name">{{ trans('Students_trans.parent') }}</span>
                        <span class="sd-status-val ok">{{ $student->myparent->Name_Father ?? '—' }}</span>
                    </div>
                </div>
            </div>

            <div class="admin-card flat-card">
                <div class="sd-panel-hd">
                    <span class="sd-panel-title">{{ trans('Students_trans.sd_upcoming_classes') }}</span>
                </div>
                <div class="sd-class-list">
                    @forelse($onlineClasses as $onlineClass)
                        <div class="sd-class-row">
                            <div>
                                <div class="sd-class-topic">{{ $onlineClass->topic }}</div>
                                <div class="sd-class-time">{{ \Illuminate\Support\Carbon::parse($onlineClass->start_at)->format('d/m/Y — h:i A') }}</div>
                            </div>
                            @if($onlineClass->join_url)
                                <a href="{{ $onlineClass->join_url }}" target="_blank" rel="noopener" class="sd-link-btn">{{ trans('Students_trans.sd_join') }}</a>
                            @endif
                        </div>
                    @empty
                        <div class="sd-class-empty">{{ trans('Students_trans.sd_no_online_classes') }}</div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

    {{-- ══ CALENDAR ══ --}}
    <div class="sd-sec-title">{{ trans('main_trans.dash_academic_calendar') }}</div>
    <div class="admin-card flat-card sd-calendar-wrap">
        <livewire:calendar-student />
    </div>

</div>
@endsection

@section('js')
<script>
    // Plain JS tab switcher
    document.querySelectorAll('#sdTabs .sd-tab').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var targetId = this.getAttribute('data-tab');
            document.querySelectorAll('#sdTabs .sd-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.tab-content .tab-pane').forEach(p => p.classList.remove('show', 'active'));
            var pane = document.getElementById(targetId);
            if (pane) pane.classList.add('show', 'active');
        });
    });
</script>
@endsection
