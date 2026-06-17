<header class="admin-header" id="superAdminHeader">

    {{-- ── Mobile: hamburger to open sidebar offcanvas ── --}}
    <button class="d-lg-none hd-toggle me-2"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#superAdminSidebar"
            aria-controls="superAdminSidebar"
            aria-label="{{ __('super_dash.toggle_sidebar') }}">
        <i class="fas fa-bars"></i>
    </button>

    {{-- ── Platform badge ── --}}
    <span class="pf-hd-badge d-none d-md-inline-flex">
        <i class="fas fa-building-columns"></i>
        {{ __('super_dash.platform_sub') }}
    </span>

    {{-- ── Right toolbar (push to end) ── --}}
    <div class="hd-right ms-auto d-flex align-items-center gap-2">

        {{-- Language switcher --}}
        <div class="dropdown hd-lang">
            <button class="hd-lang-btn dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                <i class="fas fa-globe"></i>
                <span>{{ __('super_dash.lang_name') }}</span>
                <i class="fas fa-chevron-down hd-caret"></i>
            </button>
            <ul class="dropdown-menu hd-lang-menu dropdown-menu-end">
                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <li>
                        <a class="dropdown-item hd-lang-item {{ app()->getLocale() === $localeCode ? 'hd-lang-active' : '' }}"
                           rel="alternate"
                           hreflang="{{ $localeCode }}"
                           href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                            @if (app()->getLocale() === $localeCode)
                                <i class="fas fa-check ms-auto" style="color:var(--em-600); font-size:.75rem;"></i>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="hd-sep"></div>

        {{-- User avatar + dropdown --}}
        <div class="dropdown">
            <button class="hd-user-btn dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                <div class="hd-avatar">
                    {{ mb_substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="hd-user-info d-none d-sm-block">
                    <span class="hd-user-name">{{ auth()->user()->name ?? __('super_dash.super_admin_role') }}</span>
                    <span class="hd-user-role">{{ __('super_dash.super_admin_role') }}</span>
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end hd-user-menu">
                <li>
                    <a class="dropdown-item hd-menu-item" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-circle"></i>
                        {{ __('super_dash.profile') }}
                    </a>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <form method="POST" action="{{ route('custom.logout', 'web') }}">
                        @csrf
                        <button type="submit" class="dropdown-item hd-menu-item hd-logout-item">
                            <i class="fas fa-right-from-bracket"></i>
                            {{ __('super_dash.logout') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>{{-- /.hd-right --}}

</header>

<style>
.pf-hd-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--em-50, #ecfdf5);
    border: 1px solid var(--em-100, #d1fae5);
    color: var(--em-700, #047857);
    font-family: 'Cairo', sans-serif;
    font-size: 12.5px; font-weight: 700;
    padding: 7px 14px;
    border-radius: 10px;
}
</style>
