{{-- ── Mobile-only offcanvas header (close button) ── --}}
<div class="offcanvas-header">
    <span class="sb-brand-name" id="adminSidebarLabel">{{ trans('main_trans.main_menu') }}</span>
    <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="{{ trans('main_trans.cancel') }}"></button>
</div>

{{-- ── Brand (desktop) ── --}}
<a href="{{ route('parent.dashboard') }}" class="sb-brand">
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
            <a href="{{ route('parent.dashboard') }}"
               class="sb-link {{ request()->routeIs('parent.dashboard') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-gauge-high"></i></span>
                <span class="sb-text">{{ trans('main_trans.Dashboard') }}</span>
            </a>
        </li>
    </ul>

    <span class="sb-label">{{ trans('main_trans.Programname') }}</span>
    <ul class="sb-list">

        <li>
            <a href="{{ route('sons.index') }}"
               class="sb-link {{ request()->routeIs('sons.index') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-book-open"></i></span>
                <span class="sb-text">{{ trans('Parent_trans.sidebar_children') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('sons.attendances') }}"
               class="sb-link {{ request()->routeIs('sons.attendances') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-book-open"></i></span>
                <span class="sb-text">{{ trans('Parent_trans.sidebar_attendance_report') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('sons.fees') }}"
               class="sb-link {{ request()->routeIs('sons.fees') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-book-open"></i></span>
                <span class="sb-text">{{ trans('Parent_trans.sidebar_financial_report') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('profile.show.parent') }}"
               class="sb-link {{ request()->routeIs('profile.show.parent') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-id-card-alt"></i></span>
                <span class="sb-text">{{ trans('Parent_trans.sidebar_profile') }}</span>
            </a>
        </li>

    </ul>

</div>{{-- /.sb-scroll --}}

{{-- ── Sidebar Footer ── --}}
<div class="sb-footer">
    <div class="sb-user">
        <div class="sb-avatar">
            {{ mb_substr(auth('parent')->user()->name ?? 'P', 0, 1) }}
        </div>
        <div class="sb-user-info">
            <span class="sb-user-name">{{ auth('parent')->user()->name ?? trans('main_trans.role_parent') }}</span>
            <span class="sb-user-role">{{ trans('main_trans.role_parent') }}</span>
        </div>
        <form method="POST" action="{{ route('custom.logout', 'parent') }}" style="margin:0">
            @csrf
            <button type="submit" class="sb-logout" title="{{ trans('main_trans.logout') }}">
                <i class="fas fa-right-from-bracket"></i>
            </button>
        </form>
    </div>
</div>
