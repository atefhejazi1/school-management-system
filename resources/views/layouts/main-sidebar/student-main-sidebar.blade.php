{{-- ── Mobile-only offcanvas header (close button) ── --}}
<div class="offcanvas-header">
    <span class="sb-brand-name" id="adminSidebarLabel">{{ trans('main_trans.main_menu') }}</span>
    <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="{{ trans('main_trans.cancel') }}"></button>
</div>

{{-- ── Brand (desktop) ── --}}
<a href="{{ route('student.dashboard') }}" class="sb-brand">
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
            <a href="{{ route('student.dashboard') }}"
               class="sb-link {{ request()->routeIs('student.dashboard') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-gauge-high"></i></span>
                <span class="sb-text">{{ trans('main_trans.Dashboard') }}</span>
            </a>
        </li>
    </ul>

    <span class="sb-label">{{ trans('main_trans.Programname') }}</span>
    <ul class="sb-list">

        <li>
            <a href="{{ route('student_exams.index') }}"
               class="sb-link {{ request()->routeIs('student_exams.*') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-book-open"></i></span>
                <span class="sb-text">{{ trans('Students_trans.Exams') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('profile-student.index') }}"
               class="sb-link {{ request()->routeIs('profile-student.*') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-id-card-alt"></i></span>
                <span class="sb-text">{{ trans('Students_trans.Personal_profile') }}</span>
            </a>
        </li>

    </ul>

</div>{{-- /.sb-scroll --}}

{{-- ── Sidebar Footer ── --}}
<div class="sb-footer">
    <div class="sb-user">
        <div class="sb-avatar">
            {{ mb_substr(auth('student')->user()->name ?? 'S', 0, 1) }}
        </div>
        <div class="sb-user-info">
            <span class="sb-user-name">{{ auth('student')->user()->name ?? trans('main_trans.role_student') }}</span>
            <span class="sb-user-role">{{ trans('main_trans.role_student') }}</span>
        </div>
        <form method="POST" action="{{ route('custom.logout', 'student') }}" style="margin:0">
            @csrf
            <button type="submit" class="sb-logout" title="{{ trans('main_trans.logout') }}">
                <i class="fas fa-right-from-bracket"></i>
            </button>
        </form>
    </div>
</div>
