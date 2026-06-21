{{-- ── Mobile-only offcanvas header (close button) ── --}}
<div class="offcanvas-header">
    <span class="sb-brand-name" id="adminSidebarLabel">{{ trans('main_trans.main_menu') }}</span>
    <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="{{ trans('main_trans.cancel') }}"></button>
</div>

{{-- ── Brand (desktop) ── --}}
<a href="{{ url('/dashboard') }}" class="sb-brand">
    <div class="sb-brand-icon"><i class="fas fa-graduation-cap"></i></div>
    <div>
        <span class="sb-brand-name">{{ trans('main_trans.Programname') }}</span>
        <span class="sb-brand-sub">School Management System</span>
    </div>
</a>

{{-- ── Scrollable nav ── --}}
<div class="sb-scroll">

    {{-- Dashboard --}}
    <ul class="sb-list mt-1">
        <li>
            <a href="{{ url('/dashboard') }}"
               class="sb-link {{ request()->is('dashboard') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-gauge-high"></i></span>
                <span class="sb-text">{{ trans('main_trans.Dashboard') }}</span>
            </a>
        </li>
    </ul>

    {{-- ── Academic Affairs ── --}}
    <span class="sb-label">{{ trans('main_trans.academic_affairs') }}</span>
    <ul class="sb-list">

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-grades"
                    class="sb-link {{ request()->routeIs('Grades.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('Grades.*') ? 'true' : 'false' }}"
                    aria-controls="sub-grades">
                <span class="sb-icon"><i class="fas fa-layer-group"></i></span>
                <span class="sb-text">{{ trans('main_trans.Grades') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('Grades.*') ? 'show' : '' }}" id="sub-grades">
                <li><a href="{{ route('Grades.index') }}" class="{{ request()->routeIs('Grades.index') ? 'sub-active' : '' }}">{{ trans('main_trans.Grades_list') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-classes"
                    class="sb-link {{ request()->routeIs('Classrooms.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('Classrooms.*') ? 'true' : 'false' }}"
                    aria-controls="sub-classes">
                <span class="sb-icon"><i class="fas fa-building"></i></span>
                <span class="sb-text">{{ trans('main_trans.classes') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('Classrooms.*') ? 'show' : '' }}" id="sub-classes">
                <li><a href="{{ route('Classrooms.index') }}" class="{{ request()->routeIs('Classrooms.index') ? 'sub-active' : '' }}">{{ trans('main_trans.List_classes') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-sections"
                    class="sb-link {{ request()->routeIs('Sections.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('Sections.*') ? 'true' : 'false' }}"
                    aria-controls="sub-sections">
                <span class="sb-icon"><i class="fas fa-chalkboard"></i></span>
                <span class="sb-text">{{ trans('main_trans.sections') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('Sections.*') ? 'show' : '' }}" id="sub-sections">
                <li><a href="{{ route('Sections.index') }}" class="{{ request()->routeIs('Sections.index') ? 'sub-active' : '' }}">{{ trans('main_trans.List_sections') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-subjects"
                    class="sb-link {{ request()->routeIs('subjects.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('subjects.*') ? 'true' : 'false' }}"
                    aria-controls="sub-subjects">
                <span class="sb-icon"><i class="fas fa-book-open"></i></span>
                <span class="sb-text">{{ trans('main_trans.subjects') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('subjects.*') ? 'show' : '' }}" id="sub-subjects">
                <li><a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.index') ? 'sub-active' : '' }}">{{ trans('main_trans.subjects_list') }}</a></li>
            </ul>
        </li>

        <li>
            @php $reportCardsActive = request()->routeIs('Exams.*') || request()->routeIs('ReportCards.*'); @endphp
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-report-cards"
                    class="sb-link {{ $reportCardsActive ? 'sb-active' : '' }}"
                    aria-expanded="{{ $reportCardsActive ? 'true' : 'false' }}"
                    aria-controls="sub-report-cards">
                <span class="sb-icon"><i class="fas fa-file-alt"></i></span>
                <span class="sb-text">{{ trans('main_trans.report_cards') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ $reportCardsActive ? 'show' : '' }}" id="sub-report-cards">
                <li><a href="{{ route('Exams.index') }}" class="{{ request()->routeIs('Exams.index') ? 'sub-active' : '' }}">{{ trans('main_trans.exam_terms') }}</a></li>
                <li><a href="{{ route('ReportCards.index') }}" class="{{ request()->routeIs('ReportCards.*') ? 'sub-active' : '' }}">{{ trans('main_trans.report_cards') }}</a></li>
            </ul>
        </li>

    </ul>

    {{-- ── People ── --}}
    <span class="sb-label">{{ trans('main_trans.people') }}</span>
    <ul class="sb-list">

        <li>
            @php $studActive = request()->routeIs('Students.*') || request()->routeIs('Promotion.*') || request()->routeIs('Graduated.*'); @endphp
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-students"
                    class="sb-link {{ $studActive ? 'sb-active' : '' }}"
                    aria-expanded="{{ $studActive ? 'true' : 'false' }}"
                    aria-controls="sub-students">
                <span class="sb-icon"><i class="fas fa-user-graduate"></i></span>
                <span class="sb-text">{{ trans('main_trans.students') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ $studActive ? 'show' : '' }}" id="sub-students">
                <li><a href="{{ route('Students.create') }}" class="{{ request()->routeIs('Students.create') ? 'sub-active' : '' }}">{{ trans('main_trans.add_student') }}</a></li>
                <li><a href="{{ route('Students.index') }}"  class="{{ request()->routeIs('Students.index')  ? 'sub-active' : '' }}">{{ trans('main_trans.list_students') }}</a></li>
                <li><a href="{{ route('Promotion.index') }}" class="{{ request()->routeIs('Promotion.*')     ? 'sub-active' : '' }}">{{ trans('main_trans.Students_Promotions') }}</a></li>
                <li><a href="{{ route('Graduated.index') }}" class="{{ request()->routeIs('Graduated.*')    ? 'sub-active' : '' }}">{{ trans('main_trans.Graduate_students') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-teachers"
                    class="sb-link {{ request()->routeIs('Teachers.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('Teachers.*') ? 'true' : 'false' }}"
                    aria-controls="sub-teachers">
                <span class="sb-icon"><i class="fas fa-chalkboard-user"></i></span>
                <span class="sb-text">{{ trans('main_trans.Teachers') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('Teachers.*') ? 'show' : '' }}" id="sub-teachers">
                <li><a href="{{ route('Teachers.index') }}" class="{{ request()->routeIs('Teachers.index') ? 'sub-active' : '' }}">{{ trans('main_trans.List_Teachers') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-parents"
                    class="sb-link {{ request()->is('add_parent') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->is('add_parent') ? 'true' : 'false' }}"
                    aria-controls="sub-parents">
                <span class="sb-icon"><i class="fas fa-user-tie"></i></span>
                <span class="sb-text">{{ trans('main_trans.Parents') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->is('add_parent') ? 'show' : '' }}" id="sub-parents">
                <li><a href="{{ url('add_parent') }}" class="{{ request()->is('add_parent') ? 'sub-active' : '' }}">{{ trans('main_trans.List_Parents') }}</a></li>
            </ul>
        </li>

    </ul>

    {{-- ── Finance ── --}}
    <span class="sb-label">{{ trans('main_trans.finance') }}</span>
    <ul class="sb-list">

        <li>
            @php $finActive = request()->routeIs('Fees.*') || request()->routeIs('Fees_Invoices.*') || request()->routeIs('receipt_students.*') || request()->routeIs('ProcessingFee.*') || request()->routeIs('Payment_students.*'); @endphp
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-accounts"
                    class="sb-link {{ $finActive ? 'sb-active' : '' }}"
                    aria-expanded="{{ $finActive ? 'true' : 'false' }}"
                    aria-controls="sub-accounts">
                <span class="sb-icon"><i class="fas fa-coins"></i></span>
                <span class="sb-text">{{ trans('main_trans.Accounts') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ $finActive ? 'show' : '' }}" id="sub-accounts">
                <li><a href="{{ route('Fees.index') }}"             class="{{ request()->routeIs('Fees.index')             ? 'sub-active' : '' }}">{{ trans('main_trans.fees_title') }}</a></li>
                <li><a href="{{ route('Fees_Invoices.index') }}"    class="{{ request()->routeIs('Fees_Invoices.index')    ? 'sub-active' : '' }}">{{ trans('main_trans.invoices') }}</a></li>
                <li><a href="{{ route('Fees_Invoices.outstanding') }}" class="{{ request()->routeIs('Fees_Invoices.outstanding') ? 'sub-active' : '' }}">{{ trans('main_trans.outstanding_invoices') }}</a></li>
                <li><a href="{{ route('receipt_students.index') }}" class="{{ request()->routeIs('receipt_students.*')    ? 'sub-active' : '' }}">{{ trans('main_trans.receipts') }}</a></li>
                <li><a href="{{ route('ProcessingFee.index') }}"    class="{{ request()->routeIs('ProcessingFee.*')       ? 'sub-active' : '' }}">{{ trans('main_trans.fee_exemptions') }}</a></li>
                <li><a href="{{ route('Payment_students.index') }}" class="{{ request()->routeIs('Payment_students.*')   ? 'sub-active' : '' }}">{{ trans('main_trans.payment_orders') }}</a></li>
            </ul>
        </li>

    </ul>

    {{-- ── Activity & Content ── --}}
    <span class="sb-label">{{ trans('main_trans.activity_content') }}</span>
    <ul class="sb-list">

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-attendance"
                    class="sb-link {{ request()->routeIs('Attendance.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('Attendance.*') ? 'true' : 'false' }}"
                    aria-controls="sub-attendance">
                <span class="sb-icon"><i class="fas fa-calendar-check"></i></span>
                <span class="sb-text">{{ trans('main_trans.Attendance') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('Attendance.*') ? 'show' : '' }}" id="sub-attendance">
                <li><a href="{{ route('Attendance.index') }}" class="{{ request()->routeIs('Attendance.index') ? 'sub-active' : '' }}">{{ trans('main_trans.attendance_list') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-quizzes"
                    class="sb-link {{ request()->routeIs('Quizzes.*') || request()->routeIs('questions.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('Quizzes.*') ? 'true' : 'false' }}"
                    aria-controls="sub-quizzes">
                <span class="sb-icon"><i class="fas fa-file-pen"></i></span>
                <span class="sb-text">{{ trans('main_trans.quizzes') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('Quizzes.*') ? 'show' : '' }}" id="sub-quizzes">
                <li><a href="{{ route('Quizzes.index') }}" class="{{ request()->routeIs('Quizzes.index') ? 'sub-active' : '' }}">{{ trans('main_trans.quizzes_list') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-library"
                    class="sb-link {{ request()->routeIs('library.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('library.*') ? 'true' : 'false' }}"
                    aria-controls="sub-library">
                <span class="sb-icon"><i class="fas fa-book"></i></span>
                <span class="sb-text">{{ trans('main_trans.library') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('library.*') ? 'show' : '' }}" id="sub-library">
                <li><a href="{{ route('library.index') }}" class="{{ request()->routeIs('library.index') ? 'sub-active' : '' }}">{{ trans('main_trans.library_list') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-online"
                    class="sb-link {{ request()->routeIs('online_classes.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('online_classes.*') ? 'true' : 'false' }}"
                    aria-controls="sub-online">
                <span class="sb-icon"><i class="fas fa-video"></i></span>
                <span class="sb-text">{{ trans('main_trans.Onlineclasses') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('online_classes.*') ? 'show' : '' }}" id="sub-online">
                <li><a href="{{ route('online_classes.index') }}" class="{{ request()->routeIs('online_classes.index') ? 'sub-active' : '' }}">{{ trans('main_trans.online_zoom') }}</a></li>
            </ul>
        </li>

    </ul>

    {{-- ── System ── --}}
    <span class="sb-label">{{ trans('main_trans.system_section') }}</span>
    <ul class="sb-list">

        <li>
            <a href="{{ route('settings.index') }}"
               class="sb-link {{ request()->routeIs('settings.*') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-gear"></i></span>
                <span class="sb-text">{{ trans('main_trans.Settings') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('AuditLogs.index') }}"
               class="sb-link {{ request()->routeIs('AuditLogs.*') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-shield-alt"></i></span>
                <span class="sb-text">{{ trans('main_trans.audit_logs') }}</span>
            </a>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-users"
                    class="sb-link"
                    aria-expanded="false"
                    aria-controls="sub-users">
                <span class="sb-icon"><i class="fas fa-users-cog"></i></span>
                <span class="sb-text">{{ trans('main_trans.Users') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu" id="sub-users">
                <li><a href="#">{{ trans('main_trans.users_mgmt') }}</a></li>
            </ul>
        </li>

    </ul>

</div>{{-- /.sb-scroll --}}

{{-- ── Sidebar Footer ── --}}
<div class="sb-footer">
    <div class="sb-user">
        <div class="sb-avatar">
            {{ mb_substr(auth()->user()->name ?? 'A', 0, 1) }}
        </div>
        <div class="sb-user-info">
            <span class="sb-user-name">{{ auth()->user()->name ?? trans('main_trans.role_admin') }}</span>
            <span class="sb-user-role">{{ trans('main_trans.admin_role_label') }}</span>
        </div>
        <form method="POST" action="{{ route('custom.logout', 'web') }}" style="margin:0">
            @csrf
            <button type="submit" class="sb-logout" title="{{ trans('main_trans.logout') }}">
                <i class="fas fa-right-from-bracket"></i>
            </button>
        </form>
    </div>
</div>
