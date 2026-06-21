@extends('layouts.master')

@section('title', trans('main_trans.Dashboard'))
@section('PageTitle', trans('main_trans.Dashboard'))

@section('css')
<style>
    /* ══════════════════════════════════════════
       TEACHER DASHBOARD — Flat Corporate Style
       White background, Slate Gray text (#334155), Emerald Green accents (#059669)
       No gradients, no shadows, no icons.
    ══════════════════════════════════════════ */

    .flat-card { box-shadow: none !important; }

    /* ── Welcome header ── */
    .td-welcome {
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
    .td-welcome-name { font-size: 1.3rem; font-weight: 800; color: #334155; margin-bottom: 4px; }
    .td-welcome-name span { color: #059669; }
    .td-welcome-sub { font-size: .8rem; color: #94a3b8; font-weight: 600; }
    .td-welcome-actions { display: flex; gap: 8px; flex-wrap: wrap; }

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
    .td-sec-title {
        font-size: .78rem; font-weight: 800; color: #94a3b8;
        text-transform: uppercase; letter-spacing: .8px;
        margin-bottom: 12px;
    }

    /* ── KPI CARDS — flat ── */
    .td-kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 22px; }
    .td-kpi-card {
        background: #ffffff;
        border: 1px solid var(--border, #e2e8f0);
        border-radius: 0;
        padding: 20px 20px 16px;
    }
    .td-kpi-lbl { font-size: .82rem; font-weight: 600; color: #334155; margin-bottom: 6px; }
    .td-kpi-num { font-size: 2rem; font-weight: 800; color: #059669; line-height: 1; margin-bottom: 10px; }
    .td-kpi-num.muted { color: #94a3b8; }
    .td-kpi-foot {
        display: flex; align-items: center; justify-content: space-between;
        padding-top: 10px; border-top: 1px solid #f1f5f9;
    }
    .td-kpi-link { font-size: .78rem; font-weight: 700; color: #059669; text-decoration: none; }
    .td-kpi-link:hover { color: #047857; }
    .td-kpi-sub { font-size: .72rem; color: #94a3b8; font-weight: 600; }

    /* ── BODY: activity + right column ── */
    .td-body { display: grid; grid-template-columns: 1fr 320px; gap: 18px; margin-bottom: 22px; }

    .td-panel-hd {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 20px; border-bottom: 1px solid #f1f5f9;
    }
    .td-panel-title { font-size: .9rem; font-weight: 800; color: #334155; }
    .td-panel-link { font-size: .75rem; font-weight: 700; color: #059669; text-decoration: none; }
    .td-panel-link:hover { color: #047857; }

    /* Tabs — flat, text only */
    .td-tabs { display: flex; padding: 0 16px; border-bottom: 1px solid #f1f5f9; gap: 4px; flex-wrap: wrap; }
    .td-tab {
        padding: 10px 14px; font-size: .8rem; font-weight: 700;
        color: #94a3b8; border: none; background: none;
        border-bottom: 2px solid transparent;
        cursor: pointer; font-family: 'Cairo', sans-serif;
    }
    .td-tab:hover { color: #334155; }
    .td-tab.active { color: #059669; border-bottom-color: #059669; }

    /* Table */
    .td-table { width: 100%; border-collapse: collapse; }
    .td-table thead tr { background: #f8fafc; }
    .td-table thead th {
        padding: 10px 14px; font-size: .7rem; font-weight: 700;
        color: #94a3b8; text-transform: uppercase; letter-spacing: .5px;
        border-bottom: 1px solid #f1f5f9; white-space: nowrap; text-align: center;
    }
    .td-table tbody tr { border-bottom: 1px solid #f8fafc; }
    .td-table tbody tr:last-child { border-bottom: none; }
    .td-table tbody td { padding: 10px 14px; font-size: .8rem; color: #334155; text-align: center; vertical-align: middle; }
    .td-pill {
        display: inline-flex; align-items: center; padding: 2px 9px;
        border-radius: 0; font-size: .68rem; font-weight: 700;
    }
    .td-pill.ok   { background: #ecfdf5; color: #047857; }
    .td-pill.bad  { background: #fff1f2; color: #be123c; }
    .td-empty { padding: 40px 20px !important; text-align: center; color: #94a3b8; font-size: .8rem; font-weight: 600; }
    .td-link-btn {
        display: inline-block; background: #ffffff; color: #059669;
        border: 1px solid #059669; border-radius: 0;
        padding: 4px 12px; font-size: .72rem; font-weight: 700; text-decoration: none;
    }
    .td-link-btn:hover { background: #059669; color: #ffffff; }

    /* ── RIGHT COLUMN ── */
    .td-right-col { display: flex; flex-direction: column; gap: 16px; }

    .td-qa-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; padding: 14px; }
    .td-qa-btn {
        display: flex; flex-direction: column; gap: 2px;
        padding: 12px 10px; border-radius: 0;
        text-decoration: none; color: #334155;
        border: 1px solid var(--border, #e2e8f0);
        background: #ffffff;
    }
    .td-qa-btn:hover { background: #f8fafc; }
    .td-qa-lbl { font-size: .78rem; font-weight: 700; color: #334155; }
    .td-qa-sub { font-size: .68rem; color: #94a3b8; }

    /* Upcoming online classes list */
    .td-class-list { padding: 4px 18px 14px; }
    .td-class-row {
        padding: 12px 0; border-bottom: 1px solid #f8fafc;
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
    }
    .td-class-row:last-child { border-bottom: none; }
    .td-class-topic { font-size: .82rem; font-weight: 700; color: #334155; margin-bottom: 2px; }
    .td-class-time { font-size: .72rem; color: #94a3b8; font-weight: 600; }
    .td-class-empty { padding: 22px 18px; text-align: center; color: #94a3b8; font-size: .78rem; font-weight: 600; }

    /* ── RESPONSIVE ── */
    @media (max-width: 1200px) { .td-kpi-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 1024px) { .td-body { grid-template-columns: 1fr; } }
    @media (max-width: 480px)  { .td-kpi-grid { grid-template-columns: 1fr; } }

    /* ── CALENDAR — flatten FullCalendar's default theme to match Slate/Emerald ── */
    .td-calendar-wrap { padding: 18px; }
    .td-calendar-wrap .fc {
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
    .td-calendar-wrap .fc .fc-button { box-shadow: none !important; color: #334155; font-weight: 700; text-transform: none; }
    .td-calendar-wrap .fc .fc-button:focus { box-shadow: none !important; }
    .td-calendar-wrap .fc .fc-button-primary:not(:disabled).fc-button-active,
    .td-calendar-wrap .fc .fc-button-primary:not(:disabled):active { color: #ffffff; }
    .td-calendar-wrap .fc .fc-toolbar-title { font-size: 1rem; font-weight: 800; color: #334155; }
    .td-calendar-wrap .fc .fc-daygrid-day-number,
    .td-calendar-wrap .fc .fc-col-header-cell-cushion { color: #334155; }
</style>
@endsection

@section('content')
<div>

    {{-- ══ WELCOME HEADER ══ --}}
    <div class="td-welcome">
        <div>
            <div class="td-welcome-name">
                {{ trans('Teacher_trans.welcome_message') }} <span>{{ $teacher->Name }}</span>
            </div>
            <div class="td-welcome-sub">{{ trans('Teacher_trans.teacher_role_label') }}</div>
        </div>
        <div class="td-welcome-actions">
            <a href="{{ route('sections') }}" class="btn-flat-emerald">{{ trans('Teacher_trans.sidebar_sections') }}</a>
            <a href="{{ route('profile.show') }}" class="btn-flat-outline">{{ trans('Teacher_trans.sidebar_profile') }}</a>
        </div>
    </div>

    {{-- ══ KPI CARDS ══ --}}
    <div class="td-sec-title">{{ trans('Teacher_trans.td_overview') }}</div>
    <div class="td-kpi-grid">

        <div class="td-kpi-card flat-card">
            <div class="td-kpi-lbl">{{ trans('Teacher_trans.sections_count_label') }}</div>
            <div class="td-kpi-num {{ $countSections > 0 ? '' : 'muted' }}">{{ $countSections }}</div>
            <div class="td-kpi-foot">
                <a href="{{ route('sections') }}" class="td-kpi-link">{{ trans('main_trans.dash_view_all') }}</a>
            </div>
        </div>

        <div class="td-kpi-card flat-card">
            <div class="td-kpi-lbl">{{ trans('Teacher_trans.students_count_label') }}</div>
            <div class="td-kpi-num {{ $countStudents > 0 ? '' : 'muted' }}">{{ $countStudents }}</div>
            <div class="td-kpi-foot">
                <a href="{{ route('student.index') }}" class="td-kpi-link">{{ trans('main_trans.dash_view_all') }}</a>
            </div>
        </div>

        <div class="td-kpi-card flat-card">
            <div class="td-kpi-lbl">{{ trans('Teacher_trans.td_my_quizzes') }}</div>
            <div class="td-kpi-num {{ $countQuizzes > 0 ? '' : 'muted' }}">{{ $countQuizzes }}</div>
            <div class="td-kpi-foot">
                <a href="{{ route('quizzes.index') }}" class="td-kpi-link">{{ trans('main_trans.dash_view_all') }}</a>
                <span class="td-kpi-sub">{{ trans('Teacher_trans.td_quizzes_sub', ['count' => $countQuizzes]) }}</span>
            </div>
        </div>

        <div class="td-kpi-card flat-card">
            <div class="td-kpi-lbl">{{ trans('Teacher_trans.td_upcoming_classes') }}</div>
            <div class="td-kpi-num {{ $countUpcomingClasses > 0 ? '' : 'muted' }}">{{ $countUpcomingClasses }}</div>
            <div class="td-kpi-foot">
                <a href="{{ route('online_zoom_classes.index') }}" class="td-kpi-link">{{ trans('main_trans.dash_view_all') }}</a>
                <span class="td-kpi-sub">{{ trans('Teacher_trans.td_next_days') }}</span>
            </div>
        </div>

    </div>

    {{-- ══ BODY: Students/Quizzes/Attendance + Right panel ══ --}}
    <div class="td-body">

        {{-- LEFT: Tabs --}}
        <div class="admin-card flat-card">
            <div class="td-panel-hd">
                <span class="td-panel-title">{{ trans('Teacher_trans.td_academic_activity') }}</span>
            </div>

            <div class="td-tabs" id="tdTabs">
                <button class="td-tab active" data-tab="td-tab-s" type="button">{{ trans('Teacher_trans.students_tab') }}</button>
                <button class="td-tab" data-tab="td-tab-q" type="button">{{ trans('Teacher_trans.sidebar_quizzes') }}</button>
                <button class="td-tab" data-tab="td-tab-a" type="button">{{ trans('Teacher_trans.td_tab_attendance') }}</button>
            </div>

            <div class="tab-content">

                {{-- Students tab --}}
                <div class="tab-pane fade show active" id="td-tab-s">
                    <table class="td-table">
                        <thead><tr>
                            <th>#</th><th>{{ trans('Teacher_trans.student_name_column') }}</th>
                            <th>{{ trans('Teacher_trans.grade_column') }}</th><th>{{ trans('Teacher_trans.classroom_column') }}</th>
                            <th>{{ trans('Teacher_trans.section_column') }}</th><th>{{ trans('Teacher_trans.added_date_column') }}</th>
                        </tr></thead>
                        <tbody>
                            @forelse($recentStudents as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->grade->Name ?? '—' }}</td>
                                    <td>{{ $student->classroom->Name_Class ?? '—' }}</td>
                                    <td>{{ $student->section->Name_Section ?? '—' }}</td>
                                    <td>{{ $student->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="td-empty">{{ trans('Teacher_trans.td_no_students') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Quizzes tab --}}
                <div class="tab-pane fade" id="td-tab-q">
                    <table class="td-table">
                        <thead><tr>
                            <th>#</th><th>{{ trans('Teacher_trans.quiz_name_column') }}</th>
                            <th>{{ trans('Teacher_trans.td_col_subject') }}</th><th>{{ trans('Teacher_trans.section_column') }}</th>
                            <th>{{ trans('Teacher_trans.td_col_created') }}</th><th>{{ trans('Teacher_trans.Operations') }}</th>
                        </tr></thead>
                        <tbody>
                            @forelse($recentQuizzes as $quiz)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $quiz->name }}</td>
                                    <td>{{ $quiz->subject->name ?? '—' }}</td>
                                    <td>{{ $quiz->section->Name_Section ?? '—' }}</td>
                                    <td>{{ $quiz->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('quizzes.show', $quiz->id) }}" class="td-link-btn">{{ trans('Teacher_trans.view_questions') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="td-empty">{{ trans('Teacher_trans.td_no_quizzes') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Attendance tab --}}
                <div class="tab-pane fade" id="td-tab-a">
                    <table class="td-table">
                        <thead><tr>
                            <th>#</th><th>{{ trans('Teacher_trans.student_name_column') }}</th>
                            <th>{{ trans('main_trans.dash_col_date') }}</th><th>{{ trans('main_trans.status') }}</th>
                        </tr></thead>
                        <tbody>
                            @forelse($recentAttendance as $record)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $record->students->name ?? '—' }}</td>
                                    <td>{{ \Illuminate\Support\Carbon::parse($record->attendence_date)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($record->attendence_status)
                                            <span class="td-pill ok">{{ trans('Teacher_trans.presence') }}</span>
                                        @else
                                            <span class="td-pill bad">{{ trans('Teacher_trans.absence') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="td-empty">{{ trans('Teacher_trans.td_no_attendance') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        {{-- RIGHT: Quick actions + Upcoming online classes --}}
        <div class="td-right-col">

            <div class="admin-card flat-card">
                <div class="td-panel-hd">
                    <span class="td-panel-title">{{ trans('main_trans.dash_quick_access') }}</span>
                </div>
                <div class="td-qa-grid">
                    <a href="{{ route('sections') }}" class="td-qa-btn">
                        <span class="td-qa-lbl">{{ trans('Teacher_trans.sidebar_sections') }}</span>
                        <span class="td-qa-sub">{{ trans('Teacher_trans.td_qa_sections_sub') }}</span>
                    </a>
                    <a href="{{ route('student.index') }}" class="td-qa-btn">
                        <span class="td-qa-lbl">{{ trans('Teacher_trans.sidebar_students') }}</span>
                        <span class="td-qa-sub">{{ trans('Teacher_trans.td_qa_students_sub') }}</span>
                    </a>
                    <a href="{{ route('attendance.report') }}" class="td-qa-btn">
                        <span class="td-qa-lbl">{{ trans('Teacher_trans.sidebar_attendance_report') }}</span>
                        <span class="td-qa-sub">{{ trans('Teacher_trans.td_qa_attendance_sub') }}</span>
                    </a>
                    <a href="{{ route('online_zoom_classes.index') }}" class="td-qa-btn">
                        <span class="td-qa-lbl">{{ trans('main_trans.Onlineclasses') }}</span>
                        <span class="td-qa-sub">{{ trans('Teacher_trans.td_qa_online_sub') }}</span>
                    </a>
                </div>
            </div>

            <div class="admin-card flat-card">
                <div class="td-panel-hd">
                    <span class="td-panel-title">{{ trans('Teacher_trans.td_upcoming_classes') }}</span>
                </div>
                <div class="td-class-list">
                    @forelse($upcomingClasses as $onlineClass)
                        <div class="td-class-row">
                            <div>
                                <div class="td-class-topic">{{ $onlineClass->topic }}</div>
                                <div class="td-class-time">{{ \Illuminate\Support\Carbon::parse($onlineClass->start_at)->format('d/m/Y — h:i A') }}</div>
                            </div>
                            @if($onlineClass->start_url)
                                <a href="{{ $onlineClass->start_url }}" target="_blank" rel="noopener" class="td-link-btn">{{ trans('Teacher_trans.td_join') }}</a>
                            @endif
                        </div>
                    @empty
                        <div class="td-class-empty">{{ trans('Teacher_trans.td_no_online_classes') }}</div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

    {{-- ══ CALENDAR ══ --}}
    <div class="td-sec-title">{{ trans('main_trans.dash_academic_calendar') }}</div>
    <div class="admin-card flat-card td-calendar-wrap">
        <livewire:calendar-student />
    </div>

</div>
@endsection

@section('js')
<script>
    // Plain JS tab switcher
    document.querySelectorAll('#tdTabs .td-tab').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var targetId = this.getAttribute('data-tab');
            document.querySelectorAll('#tdTabs .td-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.tab-content .tab-pane').forEach(p => p.classList.remove('show', 'active'));
            var pane = document.getElementById(targetId);
            if (pane) pane.classList.add('show', 'active');
        });
    });
</script>
@endsection
