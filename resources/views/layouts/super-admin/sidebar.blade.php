<style>
/* ══════════════════════════════════════════
   PLATFORM SIDEBAR — Light Gray / Emerald Theme
   نسخة مستقلة عن شريط لوحة تحكم المدرسة (الذي يستخدم خلفية غامقة)،
   مصمّمة بخلفية فاتحة لتمييز سياق "منشئ المنصة" بوضوح.
   جميع القيم الاتجاهية منطقية (logical) لتدعم RTL/LTR تلقائياً.
══════════════════════════════════════════ */

.pf-sb-scroll {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 8px 0 16px;
    scrollbar-width: thin;
    scrollbar-color: rgba(0,0,0,.08) transparent;
}
.pf-sb-scroll::-webkit-scrollbar { width: 4px; }
.pf-sb-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,.1); border-radius: 2px; }

/* ── Brand ── */
.pf-sb-brand {
    display: flex; align-items: center; gap: 11px;
    padding: 18px 16px;
    border-bottom: 1px solid var(--border, #e2e8f0);
    background: #ffffff;
    flex-shrink: 0;
    text-decoration: none;
}
.pf-sb-brand-icon {
    width: 42px; height: 42px; border-radius: 12px;
    background: linear-gradient(135deg, var(--em-600, #059669), var(--em-800, #065f46));
    display: flex; align-items: center; justify-content: center;
    font-size: 19px; color: white;
    box-shadow: 0 4px 12px rgba(5,150,105,.3);
    flex-shrink: 0;
}
.pf-sb-brand-name {
    font-family: 'Cairo', sans-serif;
    font-size: 13.5px; font-weight: 800;
    color: #0f172a; display: block; line-height: 1.25;
}
.pf-sb-brand-sub {
    font-family: 'Cairo', sans-serif;
    font-size: 9.5px; color: #94a3b8; display: block; font-weight: 600;
    text-transform: uppercase; letter-spacing: .5px;
}

/* ── Section label ── */
.pf-sb-label {
    font-family: 'Cairo', sans-serif;
    font-size: 9px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1.6px;
    color: #94a3b8;
    padding: 16px 18px 6px;
    display: block;
}

/* ── Nav list ── */
.pf-sb-list { list-style: none; padding: 0; margin: 0; }
.pf-sb-list li { margin: 1px 8px; }

/* ── Nav link ── */
.pf-sb-link {
    display: flex !important; align-items: center; gap: 10px;
    padding: 10px 12px !important;
    border-radius: 10px !important;
    color: #475569 !important;
    font-family: 'Cairo', sans-serif !important;
    font-size: 13px !important; font-weight: 600 !important;
    text-decoration: none !important;
    transition: all .2s ease !important;
    width: 100%;
    text-align: start !important;
}
.pf-sb-link:hover { background: var(--em-50, #ecfdf5) !important; color: var(--em-700, #047857) !important; }
.pf-sb-link.pf-sb-active {
    background: linear-gradient(135deg, var(--em-700, #047857), var(--em-600, #059669)) !important;
    color: white !important;
    box-shadow: 0 4px 14px rgba(5,150,105,.28) !important;
}
.pf-sb-link.pf-sb-active .pf-sb-icon { background: rgba(255,255,255,.2) !important; color: white !important; }

/* ── Icon box ── */
.pf-sb-icon {
    width: 30px; height: 30px; border-radius: 8px;
    background: #f1f5f9;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; color: #64748b;
    flex-shrink: 0;
    transition: all .2s;
}
.pf-sb-link:hover .pf-sb-icon { background: var(--em-100, #d1fae5); color: var(--em-700, #047857); }

.pf-sb-text { flex: 1; line-height: 1; }

.pf-sb-badge {
    margin-inline-start: auto;
    background: #ef4444; color: white;
    font-size: 10px; font-weight: 700;
    padding: 2px 8px; border-radius: 50px;
    line-height: 1.7; flex-shrink: 0;
}
.pf-sb-link.pf-sb-active .pf-sb-badge { background: rgba(255,255,255,.25); }

/* ── Sidebar footer ── */
.pf-sb-footer {
    padding: 12px 14px;
    border-top: 1px solid var(--border, #e2e8f0);
    background: #ffffff;
    flex-shrink: 0;
}
.pf-sb-user { display: flex; align-items: center; gap: 9px; }
.pf-sb-avatar {
    width: 34px; height: 34px; border-radius: 9px;
    background: linear-gradient(135deg, var(--em-600, #059669), var(--em-800, #065f46));
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: white; font-weight: 800;
    font-family: 'Cairo', sans-serif; flex-shrink: 0;
}
.pf-sb-user-info { flex: 1; min-width: 0; }
.pf-sb-user-name {
    font-family: 'Cairo', sans-serif;
    font-size: 11.5px; font-weight: 700; color: #1e293b;
    display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.pf-sb-user-role {
    font-family: 'Cairo', sans-serif;
    font-size: 9.5px; color: #94a3b8; display: block;
}
.pf-sb-logout {
    width: 30px; height: 30px; border-radius: 8px;
    background: rgba(239,68,68,.08); border: 1px solid rgba(239,68,68,.18);
    display: flex; align-items: center; justify-content: center;
    color: #ef4444; font-size: 13px; cursor: pointer;
    transition: all .2s; flex-shrink: 0;
}
.pf-sb-logout:hover { background: rgba(239,68,68,.16); }

/* ── Mobile offcanvas close header ── */
.pf-sb-offcanvas-header { display: none; }
@media (max-width: 991.98px) {
    .pf-sb-offcanvas-header {
        display: flex;
        padding: 12px 16px;
        border-bottom: 1px solid var(--border, #e2e8f0);
        background: #ffffff;
        align-items: center;
        justify-content: space-between;
    }
}
</style>

{{-- ── Mobile-only offcanvas header (close button) ── --}}
<div class="pf-sb-offcanvas-header">
    <span class="pf-sb-brand-name" id="superAdminSidebarLabel">{{ __('super_dash.platform_name') }}</span>
    <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="{{ __('super_dash.cancel') }}"></button>
</div>

{{-- ── Brand (desktop) ── --}}
<a href="{{ route('super-admin.dashboard') }}" class="pf-sb-brand">
    <div class="pf-sb-brand-icon"><i class="fas fa-building-columns"></i></div>
    <div>
        <span class="pf-sb-brand-name">{{ __('super_dash.platform_name') }}</span>
        <span class="pf-sb-brand-sub">{{ __('super_dash.platform_sub') }}</span>
    </div>
</a>

{{-- ── Scrollable nav ── --}}
<div class="pf-sb-scroll">

    <span class="pf-sb-label">{{ __('super_dash.main_section') }}</span>
    <ul class="pf-sb-list">
        <li>
            <a href="{{ route('super-admin.dashboard') }}"
               class="pf-sb-link {{ request()->routeIs('super-admin.dashboard') ? 'pf-sb-active' : '' }}">
                <span class="pf-sb-icon"><i class="fas fa-gauge-high"></i></span>
                <span class="pf-sb-text">{{ __('super_dash.dashboard') }}</span>
            </a>
        </li>
    </ul>

    <span class="pf-sb-label">{{ __('super_dash.management_section') }}</span>
    <ul class="pf-sb-list">
        <li>
            <a href="{{ route('super-admin.school-requests.index') }}"
               class="pf-sb-link {{ request()->routeIs('super-admin.school-requests.*') ? 'pf-sb-active' : '' }}">
                <span class="pf-sb-icon"><i class="fas fa-clipboard-list"></i></span>
                <span class="pf-sb-text">{{ __('super_dash.school_requests') }}</span>
                @php $__pendingCount = \App\Models\SchoolRegistration::pending()->count(); @endphp
                @if ($__pendingCount > 0)
                    <span class="pf-sb-badge">{{ $__pendingCount }}</span>
                @endif
            </a>
        </li>
    </ul>

    <span class="pf-sb-label">{{ __('super_dash.system_section') }}</span>
    <ul class="pf-sb-list">
        <li>
            <a href="#" class="pf-sb-link">
                <span class="pf-sb-icon"><i class="fas fa-gear"></i></span>
                <span class="pf-sb-text">{{ __('super_dash.settings') }}</span>
            </a>
        </li>
    </ul>

</div>{{-- /.pf-sb-scroll --}}

{{-- ── Sidebar Footer ── --}}
<div class="pf-sb-footer">
    <div class="pf-sb-user">
        <div class="pf-sb-avatar">
            {{ mb_substr(auth()->user()->name ?? 'A', 0, 1) }}
        </div>
        <div class="pf-sb-user-info">
            <span class="pf-sb-user-name">{{ auth()->user()->name ?? __('super_dash.super_admin_role') }}</span>
            <span class="pf-sb-user-role">{{ __('super_dash.super_admin_role') }}</span>
        </div>
        <form method="POST" action="{{ route('custom.logout', 'web') }}" style="margin:0">
            @csrf
            <button type="submit" class="pf-sb-logout" title="{{ __('super_dash.logout') }}">
                <i class="fas fa-right-from-bracket"></i>
            </button>
        </form>
    </div>
</div>
