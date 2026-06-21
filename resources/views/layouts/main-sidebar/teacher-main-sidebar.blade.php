{{-- ── Mobile-only offcanvas header (close button) ── --}}
<div class="offcanvas-header">
    <span class="sb-brand-name" id="adminSidebarLabel">{{ trans('main_trans.main_menu') }}</span>
    <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="{{ trans('main_trans.cancel') }}"></button>
</div>

{{-- ── Brand (desktop) ── --}}
<a href="{{ route('teacher.dashboard') }}" class="sb-brand">
    <div class="sb-brand-icon"><i class="fas fa-graduation-cap"></i></div>
    <div>
        <span class="sb-brand-name">{{ trans('main_trans.Programname') }}</span>
        <span class="sb-brand-sub">School Management System</span>
    </div>
</a>

{{-- ── Scrollable nav ── --}}
<div class="sb-scroll">

    <ul class="sb-list mt-1">
        <li>
            <a href="{{ route('teacher.dashboard') }}"
               class="sb-link {{ request()->routeIs('teacher.dashboard') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-gauge-high"></i></span>
                <span class="sb-text">{{ trans('main_trans.Dashboard') }}</span>
            </a>
        </li>
    </ul>

    <span class="sb-label">{{ trans('main_trans.Programname') }}</span>
    <ul class="sb-list">

        <li>
            <a href="{{ route('sections') }}"
               class="sb-link {{ request()->routeIs('sections') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-chalkboard"></i></span>
                <span class="sb-text">{{ trans('Teacher_trans.sidebar_sections') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.index') }}"
               class="sb-link {{ request()->routeIs('student.index') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-user-graduate"></i></span>
                <span class="sb-text">{{ trans('Teacher_trans.sidebar_students') }}</span>
            </a>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-quizzes"
                    class="sb-link {{ request()->routeIs('quizzes.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('quizzes.*') ? 'true' : 'false' }}"
                    aria-controls="sub-quizzes">
                <span class="sb-icon"><i class="fas fa-file-pen"></i></span>
                <span class="sb-text">{{ trans('Teacher_trans.sidebar_quizzes') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('quizzes.*') ? 'show' : '' }}" id="sub-quizzes">
                <li><a href="{{ route('quizzes.index') }}" class="{{ request()->routeIs('quizzes.index') ? 'sub-active' : '' }}">{{ trans('Teacher_trans.sidebar_quizzes_list') }}</a></li>
                <li><a href="#">{{ trans('Teacher_trans.sidebar_questions_list') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-online"
                    class="sb-link {{ request()->routeIs('online_zoom_classes.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('online_zoom_classes.*') ? 'true' : 'false' }}"
                    aria-controls="sub-online">
                <span class="sb-icon"><i class="fas fa-video"></i></span>
                <span class="sb-text">{{ trans('main_trans.Onlineclasses') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('online_zoom_classes.*') ? 'show' : '' }}" id="sub-online">
                <li><a href="{{ route('online_zoom_classes.index') }}" class="{{ request()->routeIs('online_zoom_classes.index') ? 'sub-active' : '' }}">{{ trans('Teacher_trans.sidebar_online_classes_zoom') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-reports"
                    class="sb-link {{ request()->routeIs('attendance.report') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('attendance.report') ? 'true' : 'false' }}"
                    aria-controls="sub-reports">
                <span class="sb-icon"><i class="fas fa-chalkboard"></i></span>
                <span class="sb-text">{{ trans('Teacher_trans.sidebar_reports') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('attendance.report') ? 'show' : '' }}" id="sub-reports">
                <li><a href="{{ route('attendance.report') }}" class="{{ request()->routeIs('attendance.report') ? 'sub-active' : '' }}">{{ trans('Teacher_trans.sidebar_attendance_report') }}</a></li>
                <li><a href="#">{{ trans('Teacher_trans.sidebar_exams_report') }}</a></li>
            </ul>
        </li>

        <li>
            <a href="{{ route('profile.show') }}"
               class="sb-link {{ request()->routeIs('profile.show') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-id-card-alt"></i></span>
                <span class="sb-text">{{ trans('Teacher_trans.sidebar_profile') }}</span>
            </a>
        </li>

    </ul>

</div>{{-- /.sb-scroll --}}

{{-- ── Sidebar Footer ── --}}
<div class="sb-footer">
    <div class="sb-user">
        <div class="sb-avatar">
            {{ mb_substr(auth('teacher')->user()->name ?? 'T', 0, 1) }}
        </div>
        <div class="sb-user-info">
            <span class="sb-user-name">{{ auth('teacher')->user()->name ?? trans('main_trans.role_teacher') }}</span>
            <span class="sb-user-role">{{ trans('main_trans.role_teacher') }}</span>
        </div>
        <form method="POST" action="{{ route('custom.logout', 'teacher') }}" style="margin:0">
            @csrf
            <button type="submit" class="sb-logout" title="{{ trans('main_trans.logout') }}">
                <i class="fas fa-right-from-bracket"></i>
            </button>
        </form>
    </div>
</div>
