@extends('layouts.master')

@section('title', trans('main_trans.Dashboard_page'))
@section('PageTitle', trans('main_trans.Dashboard_page'))

@section('css')
<style>
    /* ══════════════════════════════════════════
       DASHBOARD — Flat Corporate Style
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
    .td-welcome-date { font-size: .8rem; color: #94a3b8; font-weight: 600; }
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
    .td-name { display: flex; align-items: center; gap: 8px; justify-content: center; }
    .td-av {
        width: 26px; height: 26px; border-radius: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: .72rem; font-weight: 700; flex-shrink: 0;
        background: #ecfdf5; color: #047857;
    }
    .td-pill {
        display: inline-flex; align-items: center; padding: 2px 9px;
        border-radius: 0; font-size: .68rem; font-weight: 700;
    }
    .td-pill.neutral { background: #f1f5f9; color: #475569; }
    .td-pill.ok      { background: #ecfdf5; color: #047857; }
    .td-empty { padding: 40px 20px !important; text-align: center; color: #94a3b8; font-size: .8rem; font-weight: 600; }

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

    .td-status-list { padding: 8px 18px 14px; }
    .td-status-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 0; border-bottom: 1px solid #f8fafc;
    }
    .td-status-row:last-child { border-bottom: none; }
    .td-status-name { font-size: .8rem; color: #334155; font-weight: 600; }
    .td-status-val { font-size: .76rem; font-weight: 700; color: #94a3b8; }
    .td-status-val.ok { color: #059669; }

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
                {{ trans('main_trans.dash_welcome_greeting') }} <span>{{ auth()->user()->name ?? trans('main_trans.role_admin') }}</span>
            </div>
            <div class="td-welcome-date" id="currentDate"></div>
        </div>
        <div class="td-welcome-actions">
            <a href="{{ route('Students.create') }}" class="btn-flat-emerald">{{ trans('main_trans.add_student') }}</a>
            <a href="{{ route('Teachers.index') }}" class="btn-flat-outline">{{ trans('main_trans.Teachers') }}</a>
            <a href="{{ route('Fees_Invoices.index') }}" class="btn-flat-outline">{{ trans('main_trans.invoices') }}</a>
            <a href="{{ route('settings.index') }}" class="btn-flat-outline">{{ trans('main_trans.Settings') }}</a>
        </div>
    </div>

    {{-- ══ KPI CARDS ══ --}}
    <div class="td-sec-title">{{ trans('main_trans.dash_system_overview') }}</div>
    <div class="td-kpi-grid">

        <div class="td-kpi-card flat-card">
            <div class="td-kpi-lbl">{{ trans('main_trans.dash_total_students') }}</div>
            <div class="td-kpi-num">{{ \App\Models\students::count() }}</div>
            <div class="td-kpi-foot">
                <a href="{{ route('Students.index') }}" class="td-kpi-link">{{ trans('main_trans.dash_view_all') }}</a>
                <span class="td-kpi-sub">{{ \App\Models\students::whereDate('created_at', today())->count() }} {{ trans('main_trans.dash_today') }}</span>
            </div>
        </div>

        <div class="td-kpi-card flat-card">
            <div class="td-kpi-lbl">{{ trans('main_trans.dash_total_teachers') }}</div>
            <div class="td-kpi-num">{{ \App\Models\Teachers::count() }}</div>
            <div class="td-kpi-foot">
                <a href="{{ route('Teachers.index') }}" class="td-kpi-link">{{ trans('main_trans.dash_view_all') }}</a>
                <span class="td-kpi-sub">{{ \App\Models\Teachers::whereDate('created_at', today())->count() }} {{ trans('main_trans.dash_today') }}</span>
            </div>
        </div>

        <div class="td-kpi-card flat-card">
            <div class="td-kpi-lbl">{{ trans('main_trans.Parents') }}</div>
            <div class="td-kpi-num">{{ \App\Models\My_Parent::count() }}</div>
            <div class="td-kpi-foot">
                <a href="{{ url('add_parent') }}" class="td-kpi-link">{{ trans('main_trans.dash_view_all') }}</a>
                <span class="td-kpi-sub">{{ \App\Models\My_Parent::whereDate('created_at', today())->count() }} {{ trans('main_trans.dash_today') }}</span>
            </div>
        </div>

        <div class="td-kpi-card flat-card">
            <div class="td-kpi-lbl">{{ trans('main_trans.dash_academic_sections') }}</div>
            <div class="td-kpi-num">{{ \App\Models\sections::count() }}</div>
            <div class="td-kpi-foot">
                <a href="{{ route('Sections.index') }}" class="td-kpi-link">{{ trans('main_trans.dash_view_all') }}</a>
                <span class="td-kpi-sub">{{ \App\Models\Classroom::count() }} {{ trans('main_trans.dash_class_unit') }}</span>
            </div>
        </div>

    </div>

    {{-- ══ BODY: Activity + Right panel ══ --}}
    <div class="td-body">

        {{-- LEFT: Recent activity tabs --}}
        <div class="admin-card flat-card">
            <div class="td-panel-hd">
                <span class="td-panel-title">{{ trans('main_trans.dash_recent_activity') }}</span>
                <a href="{{ route('Students.index') }}" class="td-panel-link">{{ trans('main_trans.dash_view_all') }}</a>
            </div>

            <div class="td-tabs" id="actTabs">
                <button class="td-tab active" data-tab="tab-s" type="button">{{ trans('main_trans.students') }}</button>
                <button class="td-tab" data-tab="tab-t" type="button">{{ trans('main_trans.Teachers') }}</button>
                <button class="td-tab" data-tab="tab-p" type="button">{{ trans('main_trans.Parents') }}</button>
                <button class="td-tab" data-tab="tab-i" type="button">{{ trans('main_trans.invoices') }}</button>
                <button class="td-tab" data-tab="tab-c" type="button">{{ trans('main_trans.List_classes') }}</button>
            </div>

            <div class="tab-content">

                {{-- Students tab --}}
                <div class="tab-pane fade show active" id="tab-s">
                    <table class="td-table">
                        <thead><tr>
                            <th>#</th><th>{{ trans('main_trans.dash_col_student') }}</th><th>{{ trans('main_trans.dash_col_email') }}</th>
                            <th>{{ trans('main_trans.dash_col_gender') }}</th><th>{{ trans('main_trans.dash_col_grade') }}</th>
                            <th>{{ trans('main_trans.dash_col_class') }}</th><th>{{ trans('main_trans.dash_col_section') }}</th><th>{{ trans('main_trans.dash_col_date') }}</th>
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
                                            <span class="td-pill neutral">{{ $s->gender->Name }}</span>
                                        @else <span style="color:#cbd5e1">—</span> @endif
                                    </td>
                                    <td>{{ $s->grade->Name ?? '—' }}</td>
                                    <td>{{ $s->classroom->Name_Class ?? '—' }}</td>
                                    <td>{{ $s->section->Name_Section ?? '—' }}</td>
                                    <td><span class="td-pill ok">{{ $s->created_at->format('d/m/Y') }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="td-empty">{{ trans('main_trans.dash_no_students') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Teachers tab --}}
                <div class="tab-pane fade" id="tab-t">
                    <table class="td-table">
                        <thead><tr>
                            <th>#</th><th>{{ trans('main_trans.dash_col_teacher') }}</th><th>{{ trans('main_trans.dash_col_gender') }}</th>
                            <th>{{ trans('main_trans.dash_col_joining_date') }}</th><th>{{ trans('main_trans.dash_col_specialization') }}</th><th>{{ trans('main_trans.dash_col_date') }}</th>
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
                                <tr><td colspan="6" class="td-empty">{{ trans('main_trans.dash_no_teachers') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Parents tab --}}
                <div class="tab-pane fade" id="tab-p">
                    <table class="td-table">
                        <thead><tr>
                            <th>#</th><th>{{ trans('main_trans.dash_col_parent') }}</th><th>{{ trans('main_trans.dash_col_email') }}</th>
                            <th>{{ trans('main_trans.dash_col_national_id') }}</th><th>{{ trans('main_trans.dash_col_phone') }}</th><th>{{ trans('main_trans.dash_col_date') }}</th>
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
                                <tr><td colspan="6" class="td-empty">{{ trans('main_trans.dash_no_parents') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Invoices tab — يضم عمود "المتبقي" لعرض رصيد الرسوم المالية المتبقي على كل فاتورة --}}
                <div class="tab-pane fade" id="tab-i">
                    <table class="td-table">
                        <thead><tr>
                            <th>#</th><th>{{ trans('main_trans.dash_col_invoice_date') }}</th><th>{{ trans('main_trans.dash_col_class') }}</th>
                            <th>{{ trans('main_trans.dash_col_grade') }}</th><th>{{ trans('main_trans.dash_col_balance') }}</th><th>{{ trans('main_trans.status') }}</th>
                        </tr></thead>
                        <tbody>
                            @forelse(\App\Models\Fee_invoice::latest()->take(5)->get() as $inv)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="td-pill ok">{{ $inv->invoice_date ?? '—' }}</span></td>
                                    <td>{{ $inv->classroom->Name_Class ?? '—' }}</td>
                                    <td>{{ $inv->classroom->grade->Name ?? '—' }}</td>
                                    <td>{{ number_format($inv->balance_amount, 2) }}</td>
                                    <td><span class="td-pill ok">{{ trans('main_trans.dash_status_active') }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="td-empty">{{ trans('main_trans.dash_no_invoices') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Classrooms tab — ملخص تتبّع الصفوف الدراسية وعدد طلاب كل صف --}}
                <div class="tab-pane fade" id="tab-c">
                    <table class="td-table">
                        <thead><tr>
                            <th>#</th><th>{{ trans('main_trans.dash_col_classroom_name') }}</th>
                            <th>{{ trans('main_trans.dash_col_grade') }}</th><th>{{ trans('main_trans.dash_col_students_count') }}</th>
                        </tr></thead>
                        <tbody>
                            @forelse(\App\Models\Classroom::with('Grades')->withCount('students')->latest()->take(5)->get() as $classroom)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $classroom->Name_Class }}</td>
                                    <td>{{ $classroom->Grades->Name ?? '—' }}</td>
                                    <td><span class="td-pill neutral">{{ $classroom->students_count }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="td-empty">{{ trans('main_trans.dash_no_classrooms') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        {{-- RIGHT: Quick actions + System status --}}
        <div class="td-right-col">

            <div class="admin-card flat-card">
                <div class="td-panel-hd">
                    <span class="td-panel-title">{{ trans('main_trans.dash_quick_access') }}</span>
                </div>
                <div class="td-qa-grid">
                    <a href="{{ route('Students.create') }}" class="td-qa-btn">
                        <span class="td-qa-lbl">{{ trans('main_trans.add_student') }}</span>
                        <span class="td-qa-sub">{{ trans('main_trans.dash_qa_new_registration') }}</span>
                    </a>
                    <a href="{{ route('Teachers.index') }}" class="td-qa-btn">
                        <span class="td-qa-lbl">{{ trans('main_trans.Teachers') }}</span>
                        <span class="td-qa-sub">{{ trans('main_trans.dash_qa_teaching_staff') }}</span>
                    </a>
                    <a href="{{ route('Fees_Invoices.index') }}" class="td-qa-btn">
                        <span class="td-qa-lbl">{{ trans('main_trans.invoices') }}</span>
                        <span class="td-qa-sub">{{ trans('main_trans.dash_qa_tuition_fees') }}</span>
                    </a>
                    <a href="{{ route('Attendance.index') }}" class="td-qa-btn">
                        <span class="td-qa-lbl">{{ trans('main_trans.Attendance') }}</span>
                        <span class="td-qa-sub">{{ trans('main_trans.dash_qa_attendance_tracking') }}</span>
                    </a>
                    <a href="{{ route('Grades.index') }}" class="td-qa-btn">
                        <span class="td-qa-lbl">{{ trans('main_trans.Grades') }}</span>
                        <span class="td-qa-sub">{{ trans('main_trans.dash_qa_academic_grades') }}</span>
                    </a>
                    <a href="{{ route('Sections.index') }}" class="td-qa-btn">
                        <span class="td-qa-lbl">{{ trans('main_trans.sections') }}</span>
                        <span class="td-qa-sub">{{ trans('main_trans.dash_qa_classes') }}</span>
                    </a>
                    <a href="{{ route('Quizzes.index') }}" class="td-qa-btn">
                        <span class="td-qa-lbl">{{ trans('main_trans.quizzes') }}</span>
                        <span class="td-qa-sub">{{ trans('main_trans.dash_qa_question_mgmt') }}</span>
                    </a>
                    <a href="{{ route('settings.index') }}" class="td-qa-btn">
                        <span class="td-qa-lbl">{{ trans('main_trans.Settings') }}</span>
                        <span class="td-qa-sub">{{ trans('main_trans.dash_qa_system_settings') }}</span>
                    </a>
                </div>
            </div>

            <div class="admin-card flat-card">
                <div class="td-panel-hd">
                    <span class="td-panel-title">{{ trans('main_trans.dash_system_status') }}</span>
                </div>
                <div class="td-status-list">
                    <div class="td-status-row">
                        <span class="td-status-name">{{ trans('main_trans.dash_status_database') }}</span>
                        <span class="td-status-val ok">{{ trans('main_trans.dash_status_connected') }}</span>
                    </div>
                    <div class="td-status-row">
                        <span class="td-status-name">{{ trans('main_trans.dash_status_webserver') }}</span>
                        <span class="td-status-val ok">{{ trans('main_trans.dash_status_running') }}</span>
                    </div>
                    <div class="td-status-row">
                        <span class="td-status-name">{{ trans('main_trans.dash_status_version') }}</span>
                        <span class="td-status-val">v2.0</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- ══ CALENDAR ══ --}}
    <div class="td-sec-title">{{ trans('main_trans.dash_academic_calendar') }}</div>
    <div class="admin-card flat-card td-calendar-wrap">
        @livewire('calendar')
    </div>

</div>
@endsection

@section('js')
<script>
    // Locale-aware date
    const dateEl = document.getElementById('currentDate');
    if (dateEl) {
        dateEl.textContent = new Date().toLocaleDateString('{{ app()->getLocale() === 'ar' ? 'ar-SA' : 'en-US' }}', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
    }

    // Plain JS tab switcher
    document.querySelectorAll('#actTabs .td-tab').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var targetId = this.getAttribute('data-tab');
            document.querySelectorAll('#actTabs .td-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.tab-content .tab-pane').forEach(p => p.classList.remove('show', 'active'));
            var pane = document.getElementById(targetId);
            if (pane) pane.classList.add('show', 'active');
        });
    });
</script>
@endsection
