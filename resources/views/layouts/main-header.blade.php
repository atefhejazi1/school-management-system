<header class="admin-header" id="adminHeader">

    {{-- ── Mobile: hamburger to open sidebar offcanvas ── --}}
    <button class="d-lg-none hd-toggle me-2"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#adminSidebar"
            aria-controls="adminSidebar"
            aria-label="{{ trans('main_trans.toggle_sidebar') }}">
        <i class="fas fa-bars"></i>
    </button>

    {{-- ── Desktop: sidebar collapse toggle (optional future use) ── --}}
    <button class="d-none d-lg-flex hd-toggle"
            type="button"
            id="btnSidebarToggle"
            title="{{ trans('main_trans.toggle_sidebar') }}">
        <i class="fas fa-bars-staggered"></i>
    </button>

    {{-- ── Search bar ── --}}
    <div class="hd-search d-none d-md-block">
        <span class="hd-search-icon"><i class="fas fa-magnifying-glass"></i></span>
        <input type="search"
               class="hd-search-input"
               placeholder="{{ trans('main_trans.search_placeholder') }}"
               aria-label="{{ trans('main_trans.search_placeholder') }}">
    </div>

    {{-- ── Right toolbar (push to end) ── --}}
    <div class="hd-right ms-auto d-flex align-items-center gap-2">

        {{-- Language switcher --}}
        <div class="dropdown hd-lang">
            <button class="hd-lang-btn dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                <i class="fas fa-globe"></i>
                <span>{{ trans('main_trans.lang_name') }}</span>
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

        {{-- Fullscreen --}}
        <button class="hd-icon-btn"
                id="btnFullscreen"
                title="{{ trans('main_trans.fullscreen') }}">
            <i class="fas fa-expand"></i>
        </button>

        {{-- Notifications --}}
        <div class="dropdown">
            <button class="hd-icon-btn position-relative"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    title="{{ trans('main_trans.notifications') }}">
                <i class="fas fa-bell"></i>
                <span class="hd-notif-dot position-absolute top-0 start-0 translate-middle"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end hd-notif-menu">
                <div class="hd-notif-header">
                    <span class="hd-notif-title">{{ trans('main_trans.notifications') }}</span>
                    <span class="hd-notif-count">3</span>
                </div>
                <div class="hd-notif-list">
                    <a href="#" class="hd-notif-item">
                        <div class="hd-notif-icon hd-ni-blue"><i class="fas fa-user-plus"></i></div>
                        <div class="hd-notif-text">
                            <p>{{ trans('main_trans.notif_new_student_registered') }}</p>
                            <span>{{ trans('main_trans.notif_minutes_ago_5') }}</span>
                        </div>
                    </a>
                    <a href="#" class="hd-notif-item">
                        <div class="hd-notif-icon hd-ni-green"><i class="fas fa-file-invoice"></i></div>
                        <div class="hd-notif-text">
                            <p>{{ trans('main_trans.notif_new_invoice_received') }}</p>
                            <span>{{ trans('main_trans.notif_minutes_ago_22') }}</span>
                        </div>
                    </a>
                    <a href="#" class="hd-notif-item">
                        <div class="hd-notif-icon hd-ni-amber"><i class="fas fa-triangle-exclamation"></i></div>
                        <div class="hd-notif-text">
                            <p>{{ trans('main_trans.notif_system_update_required') }}</p>
                            <span>{{ trans('main_trans.notif_hours_ago_2') }}</span>
                        </div>
                    </a>
                </div>
                <div class="hd-notif-footer">
                    <a href="#">{{ trans('main_trans.mark_all_read') }}</a>
                </div>
            </div>
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
                    <span class="hd-user-name">{{ auth()->user()->name ?? trans('main_trans.role_admin') }}</span>
                    <span class="hd-user-role">{{ trans('main_trans.admin_role_label') }}</span>
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end hd-user-menu">
                <li>
                    <a class="dropdown-item hd-menu-item" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-circle"></i>
                        {{ trans('main_trans.profile') }}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item hd-menu-item" href="{{ route('settings.index') }}">
                        <i class="fas fa-gear"></i>
                        {{ trans('main_trans.system_settings') }}
                    </a>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    @if (auth('student')->check())
                        <form method="POST" action="{{ route('custom.logout', 'student') }}">
                    @elseif (auth('teacher')->check())
                        <form method="POST" action="{{ route('custom.logout', 'teacher') }}">
                    @elseif (auth('parent')->check())
                        <form method="POST" action="{{ route('custom.logout', 'parent') }}">
                    @else
                        <form method="POST" action="{{ route('custom.logout', 'web') }}">
                    @endif
                    @csrf
                    <button type="submit" class="dropdown-item hd-menu-item hd-logout-item">
                        <i class="fas fa-right-from-bracket"></i>
                        {{ trans('main_trans.logout') }}
                    </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>{{-- /.hd-right --}}

</header>

<style>
/* ══════════════════════════════════════════
   ADMIN HEADER COMPONENT STYLES
   All directions use logical CSS properties
══════════════════════════════════════════ */

/* ── Toggle button ── */
.hd-toggle {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: #f8fafc;
    border: 1px solid var(--border, #e2e8f0);
    display: flex; align-items: center; justify-content: center;
    color: #64748b; font-size: 16px;
    cursor: pointer;
    transition: all .2s ease;
    flex-shrink: 0;
}
.hd-toggle:hover { background: var(--em-50); color: var(--em-600); border-color: var(--em-200); }

/* ── Search ── */
.hd-search { position: relative; flex: 1; max-width: 280px; }
.hd-search-icon {
    position: absolute;
    inset-inline-start: 12px;
    top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: 13px;
    pointer-events: none;
}
.hd-search-input {
    width: 100%; height: 38px;
    background: #f8fafc;
    border: 1px solid var(--border, #e2e8f0);
    border-radius: 10px;
    padding-block: 0;
    padding-inline: 38px 12px;
    font-family: 'Cairo', sans-serif;
    font-size: 13px; color: #374151;
    outline: none;
    transition: all .2s;
}
.hd-search-input::placeholder { color: #94a3b8; }
.hd-search-input:focus {
    border-color: var(--em-500);
    background: white;
    box-shadow: 0 0 0 3px rgba(16,185,129,.1);
}

/* ── Separator ── */
.hd-sep { width: 1px; height: 28px; background: var(--border, #e2e8f0); flex-shrink: 0; }

/* ── Icon buttons (fullscreen, notifications) ── */
.hd-icon-btn {
    width: 38px; height: 38px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #64748b; font-size: 17px;
    border: none; background: transparent;
    cursor: pointer;
    transition: all .2s;
    position: relative;
}
.hd-icon-btn:hover { background: #f1f5f9; color: var(--em-600); }

/* Notification red dot */
.hd-notif-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #ef4444;
    border: 2px solid white;
    top: 7px !important;
    inset-inline-start: 7px !important;
}

/* ── Language switcher ── */
.hd-lang-btn {
    display: flex; align-items: center; gap: 6px;
    height: 36px;
    background: #f8fafc;
    border: 1px solid var(--border, #e2e8f0);
    border-radius: 10px;
    font-family: 'Cairo', sans-serif;
    font-size: 12px; font-weight: 600; color: #374151;
    padding: 0 12px;
    cursor: pointer;
    transition: all .2s;
}
.hd-lang-btn::after { display: none; }
.hd-lang-btn:hover { border-color: var(--em-500); color: var(--em-700); background: var(--em-50); }
.hd-caret { font-size: 9px; opacity: .6; }

.hd-lang-menu {
    border: 1px solid var(--border, #e2e8f0) !important;
    border-radius: 14px !important;
    box-shadow: 0 10px 30px rgba(0,0,0,.1) !important;
    padding: 6px !important;
    min-width: 150px !important;
}
.hd-lang-item {
    border-radius: 8px !important;
    font-family: 'Cairo', sans-serif !important;
    font-size: 13px !important; font-weight: 600 !important;
    padding: 9px 12px !important;
    display: flex !important; align-items: center !important; gap: 8px !important;
    transition: background .15s !important;
}
.hd-lang-item:hover { background: #f1f5f9 !important; }
.hd-lang-active { color: var(--em-700) !important; background: var(--em-50) !important; }

/* ── Notifications dropdown ── */
.hd-notif-menu {
    width: 320px;
    border: 1px solid var(--border, #e2e8f0) !important;
    border-radius: 18px !important;
    box-shadow: 0 14px 36px rgba(0,0,0,.12) !important;
    padding: 0 !important; overflow: hidden;
}
.hd-notif-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 18px;
    background: #f8fafc;
    border-bottom: 1px solid var(--border, #e2e8f0);
}
.hd-notif-title { font-family: 'Cairo', sans-serif; font-size: .88rem; font-weight: 800; color: #0f172a; }
.hd-notif-count {
    background: #ef4444; color: white;
    font-size: .7rem; font-weight: 700;
    padding: 2px 8px; border-radius: 12px;
}
.hd-notif-list { max-height: 240px; overflow-y: auto; }
.hd-notif-item {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 12px 18px;
    border-bottom: 1px solid #f8fafc;
    text-decoration: none;
    transition: background .15s;
}
.hd-notif-item:hover { background: #f8fafc; }
.hd-notif-icon {
    width: 36px; height: 36px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; flex-shrink: 0;
}
.hd-ni-blue  { background: rgba(59,130,246,.1);  color: #3b82f6; }
.hd-ni-green { background: rgba(5,150,105,.1);   color: var(--em-600); }
.hd-ni-amber { background: rgba(245,158,11,.1);  color: #d97706; }
.hd-notif-text p { font-family: 'Cairo', sans-serif; font-size: 12.5px; color: #374151; margin: 0 0 2px; font-weight: 500; }
.hd-notif-text span { font-size: 11px; color: #94a3b8; }
.hd-notif-footer {
    padding: 10px 18px;
    background: #f8fafc;
    border-top: 1px solid var(--border, #e2e8f0);
    text-align: center;
}
.hd-notif-footer a { font-family: 'Cairo', sans-serif; font-size: .8rem; color: var(--em-600); font-weight: 700; text-decoration: none; }
.hd-notif-footer a:hover { color: var(--em-700); }

/* ── User button ── */
.hd-user-btn {
    display: flex; align-items: center; gap: 10px;
    background: transparent;
    border: none;
    border-radius: 12px;
    padding: 5px 10px;
    cursor: pointer;
    transition: background .2s;
    height: 50px;
}
.hd-user-btn::after { display: none; }
.hd-user-btn:hover { background: #f1f5f9; }

.hd-avatar {
    width: 36px; height: 36px; border-radius: 10px;
    background: linear-gradient(135deg, var(--em-600), var(--em-800));
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: white; font-weight: 800;
    font-family: 'Cairo', sans-serif;
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(5,150,105,.35);
}
.hd-user-info { text-align: end; }
.hd-user-name { font-family: 'Cairo', sans-serif; font-size: 12.5px; font-weight: 700; color: #1e293b; display: block; white-space: nowrap; }
.hd-user-role { font-size: 10.5px; color: #94a3b8; display: block; }

/* ── User dropdown menu ── */
.hd-user-menu {
    width: 220px;
    border: 1px solid var(--border, #e2e8f0) !important;
    border-radius: 14px !important;
    box-shadow: 0 14px 36px rgba(0,0,0,.1) !important;
    padding: 6px !important;
}
.hd-menu-item {
    border-radius: 8px !important;
    font-family: 'Cairo', sans-serif !important;
    font-size: 13px !important; font-weight: 600 !important;
    padding: 10px 14px !important;
    display: flex !important; align-items: center !important; gap: 10px !important;
    transition: background .15s !important;
    width: 100%; border: none; background: none; cursor: pointer;
    text-align: start !important;
}
.hd-menu-item i { width: 16px; text-align: center; color: #64748b; }
.hd-menu-item:hover { background: #f1f5f9 !important; }
.hd-logout-item { color: #ef4444 !important; }
.hd-logout-item i { color: #ef4444 !important; }
.hd-logout-item:hover { background: #fff1f2 !important; }
</style>
