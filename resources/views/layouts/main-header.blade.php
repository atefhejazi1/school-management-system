<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* ══════════════════════════════════════════
   ADMIN HEADER — Complete Redesign
   ══════════════════════════════════════════ */

.admin-header.navbar {
    background: #ffffff !important;
    border-bottom: 1px solid #e2e8f0 !important;
    box-shadow: 0 1px 12px rgba(0,0,0,0.06) !important;
    height: 64px !important;
    padding: 0 !important;
    z-index: 999 !important;
}

/* Thin gradient accent line at very top */
.admin-header.navbar::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #2563eb 0%, #7c3aed 40%, #0891b2 70%, #059669 100%);
    z-index: 1;
}

/* Brand wrapper — matches sidebar width */
.navbar-brand-wrapper {
    width: 265px !important;
    background: linear-gradient(180deg, #0f172a 0%, #1a2744 100%) !important;
    height: 64px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border: none !important;
    flex-shrink: 0 !important;
}

.hd-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.hd-brand-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; color: white;
    box-shadow: 0 4px 10px rgba(59,130,246,0.4);
}

.hd-brand-label {
    font-family: 'Cairo', sans-serif;
    font-size: 13px; font-weight: 800;
    color: #f1f5f9;
    line-height: 1.2;
    white-space: nowrap;
}

/* ── Left toolbar (toggle + search) ── */
.hd-left {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    padding-right: 16px;
    flex: 1 !important;
    margin: 0 !important;
}

/* Sidebar toggle button */
.hd-toggle {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    display: flex; align-items: center; justify-content: center;
    color: #64748b; font-size: 16px;
    cursor: pointer; text-decoration: none;
    transition: all 0.2s ease;
    flex-shrink: 0;
}
.hd-toggle:hover {
    background: #f1f5f9;
    color: #3b82f6;
}

/* Search bar */
.hd-search {
    position: relative;
    max-width: 280px;
    width: 100%;
}

.hd-search input {
    width: 100%;
    height: 38px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 0 14px 0 40px;
    font-family: 'Cairo', sans-serif;
    font-size: 13px;
    color: #374151;
    outline: none;
    transition: all 0.2s ease;
    direction: rtl;
}

.hd-search input::placeholder { color: #94a3b8; }

.hd-search input:focus {
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}

.hd-search-icon {
    position: absolute;
    left: 12px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: 13px;
    pointer-events: none;
}

/* ── Right toolbar ── */
.hd-right {
    display: flex !important;
    align-items: center !important;
    gap: 4px !important;
    padding-left: 16px;
    margin: 0 !important;
    list-style: none;
}

/* Icon action buttons */
.hd-btn {
    width: 38px; height: 38px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #64748b; font-size: 17px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}

.hd-btn:hover {
    background: #f1f5f9;
    color: #3b82f6;
}

/* Notification badge */
.hd-badge {
    position: absolute;
    top: 6px; right: 6px;
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #ef4444;
    border: 2px solid white;
}

/* Language selector */
.hd-lang .btn {
    height: 36px;
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 10px !important;
    font-family: 'Cairo', sans-serif !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    color: #374151 !important;
    display: flex; align-items: center; gap: 6px;
    padding: 0 12px;
    box-shadow: none !important;
    transition: all 0.2s;
}

.hd-lang .btn:hover {
    background: #f1f5f9 !important;
    border-color: #3b82f6 !important;
}

.hd-lang .btn img { width: 18px; height: 14px; border-radius: 2px; }

.hd-lang .dropdown-menu {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    padding: 6px;
    min-width: 140px;
}

.hd-lang .dropdown-item {
    border-radius: 8px;
    font-family: 'Cairo', sans-serif;
    font-size: 13px;
    padding: 8px 12px;
    transition: background 0.15s;
}

.hd-lang .dropdown-item:hover { background: #f1f5f9; }

/* Notification dropdown */
.hd-notif-dropdown {
    width: 320px;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 12px 32px rgba(0,0,0,0.12);
    padding: 0;
    overflow: hidden;
}

.hd-notif-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    background: #f8fafc;
}

.hd-notif-header strong {
    font-family: 'Cairo', sans-serif;
    font-size: 14px; font-weight: 700; color: #1e293b;
}

.hd-notif-badge {
    background: #ef4444; color: white;
    font-size: 10px; font-weight: 700;
    padding: 2px 7px; border-radius: 10px;
    font-family: 'Cairo', sans-serif;
}

.hd-notif-item {
    display: flex; align-items: start; gap: 12px;
    padding: 13px 18px;
    border-bottom: 1px solid #f8fafc;
    text-decoration: none;
    transition: background 0.15s;
}

.hd-notif-item:hover { background: #f8fafc; }

.hd-notif-dot {
    width: 36px; height: 36px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; flex-shrink: 0;
}

.hd-notif-dot.blue  { background: rgba(59,130,246,0.1);  color: #3b82f6; }
.hd-notif-dot.green { background: rgba(16,185,129,0.1);  color: #10b981; }
.hd-notif-dot.amber { background: rgba(245,158,11,0.1);  color: #f59e0b; }

.hd-notif-text { flex: 1; }
.hd-notif-text p {
    font-family: 'Cairo', sans-serif;
    font-size: 12.5px; color: #374151;
    margin: 0 0 2px; font-weight: 500;
}
.hd-notif-text span {
    font-family: 'Cairo', sans-serif;
    font-size: 11px; color: #94a3b8;
}

/* User avatar + dropdown */
.hd-avatar-btn {
    display: flex !important; align-items: center; gap: 10px;
    padding: 5px 10px !important;
    border-radius: 12px !important;
    text-decoration: none !important;
    transition: background 0.2s !important;
    height: 50px;
}

.hd-avatar-btn:hover { background: #f1f5f9 !important; }

.hd-avatar-img {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: white; font-weight: 700;
    font-family: 'Cairo', sans-serif;
    flex-shrink: 0;
}

.hd-avatar-info { text-align: right; }
.hd-avatar-name {
    font-family: 'Cairo', sans-serif;
    font-size: 12.5px; font-weight: 700; color: #1e293b;
    display: block; white-space: nowrap;
}
.hd-avatar-role {
    font-family: 'Cairo', sans-serif;
    font-size: 10.5px; color: #94a3b8;
    display: block;
}

.hd-user-dropdown {
    width: 220px;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 12px 32px rgba(0,0,0,0.12);
    padding: 6px;
}

.hd-user-dropdown .dropdown-item {
    border-radius: 8px;
    font-family: 'Cairo', sans-serif;
    font-size: 13px;
    padding: 10px 14px;
    display: flex; align-items: center; gap: 10px;
    transition: background 0.15s;
}

.hd-user-dropdown .dropdown-item:hover { background: #f1f5f9; }
.hd-user-dropdown .dropdown-item i { width: 16px; text-align: center; }

.hd-user-dropdown .dropdown-divider { margin: 4px 0; border-color: #f1f5f9; }

.hd-logout-item { color: #ef4444 !important; }
.hd-logout-item:hover { background: #fef2f2 !important; }

/* Divider between sections */
.hd-sep { width: 1px; height: 28px; background: #e2e8f0; margin: 0 6px; flex-shrink: 0; }

/* Content wrapper top margin */
.content-wrapper {
    margin-top: 64px !important;
    background: #f1f5f9 !important;
}
</style>

<!-- ══════════════════════════════════════════
     ADMIN HEADER
     ══════════════════════════════════════════ -->
<nav class="admin-header navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

    <!-- Brand / Logo -->
    <div class="text-left navbar-brand-wrapper">
        <a class="hd-brand" href="{{ url('/dashboard') }}">
            <div class="hd-brand-icon"><i class="fas fa-graduation-cap"></i></div>
            <span class="hd-brand-label">إدارة<br>المدارس</span>
        </a>
    </div>

    <!-- Left side: toggle + search -->
    <ul class="nav navbar-nav hd-left">
        <li class="nav-item">
            <a id="button-toggle" class="hd-toggle" href="javascript:void(0);" title="تبديل القائمة">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item" style="flex:1; max-width: 300px;">
            <div class="hd-search">
                <input type="text" placeholder="بحث في النظام..." name="search">
                <i class="fas fa-search hd-search-icon"></i>
            </div>
        </li>
    </ul>

    <!-- Right side: actions -->
    <ul class="nav navbar-nav hd-right">

        <!-- Language -->
        <li class="nav-item hd-lang">
            <div class="btn-group">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if (App::getLocale() == 'ar')
                        <img src="{{ URL::asset('assets/images/flags/EG.png') }}" alt="AR">
                        <span>عربي</span>
                    @else
                        <img src="{{ URL::asset('assets/images/flags/US.png') }}" alt="EN">
                        <span>English</span>
                    @endif
                    <i class="fas fa-chevron-down" style="font-size:10px; opacity:.6;"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                           href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </li>

        <div class="hd-sep"></div>

        <!-- Fullscreen -->
        <li class="nav-item">
            <a id="btnFullscreen" href="#" class="hd-btn" title="ملء الشاشة">
                <i class="fas fa-expand"></i>
            </a>
        </li>

        <!-- Notifications -->
        <li class="nav-item dropdown">
            <a class="hd-btn" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" title="الإشعارات">
                <i class="fas fa-bell"></i>
                <span class="hd-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right hd-notif-dropdown">
                <div class="hd-notif-header">
                    <strong>الإشعارات</strong>
                    <span class="hd-notif-badge">3</span>
                </div>
                <a href="#" class="hd-notif-item">
                    <div class="hd-notif-dot blue"><i class="fas fa-user-plus"></i></div>
                    <div class="hd-notif-text">
                        <p>تم تسجيل طالب جديد</p>
                        <span>منذ 5 دقائق</span>
                    </div>
                </a>
                <a href="#" class="hd-notif-item">
                    <div class="hd-notif-dot green"><i class="fas fa-file-invoice"></i></div>
                    <div class="hd-notif-text">
                        <p>فاتورة جديدة واردة</p>
                        <span>منذ 22 دقيقة</span>
                    </div>
                </a>
                <a href="#" class="hd-notif-item">
                    <div class="hd-notif-dot amber"><i class="fas fa-triangle-exclamation"></i></div>
                    <div class="hd-notif-text">
                        <p>تحديث النظام مطلوب</p>
                        <span>منذ ساعتين</span>
                    </div>
                </a>
            </div>
        </li>

        <div class="hd-sep"></div>

        <!-- User Avatar -->
        <li class="nav-item dropdown">
            <a class="hd-avatar-btn" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="hd-avatar-info">
                    <span class="hd-avatar-name">{{ auth()->user()->name ?? 'المسؤول' }}</span>
                    <span class="hd-avatar-role">مسؤول النظام</span>
                </div>
                <div class="hd-avatar-img">
                    {{ mb_substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right hd-user-dropdown">
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                    <i class="fas fa-user text-primary"></i> الملف الشخصي
                </a>
                <a class="dropdown-item" href="{{ route('settings.index') }}">
                    <i class="fas fa-gear text-secondary"></i> إعدادات النظام
                </a>
                <div class="dropdown-divider"></div>

                @if (auth('student')->check())
                    <form method="POST" action="{{ route('custom.logout', 'student') }}">
                @elseif(auth('teacher')->check())
                    <form method="POST" action="{{ route('custom.logout', 'teacher') }}">
                @elseif(auth('parent')->check())
                    <form method="POST" action="{{ route('custom.logout', 'parent') }}">
                @else
                    <form method="POST" action="{{ route('custom.logout', 'web') }}">
                @endif
                @csrf
                <button type="submit" class="dropdown-item hd-logout-item" style="border:none; background:none; width:100%; text-align:right; cursor:pointer;">
                    <i class="fas fa-right-from-bracket"></i> تسجيل الخروج
                </button>
                </form>
            </div>
        </li>

    </ul>
</nav>
