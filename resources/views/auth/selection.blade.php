<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ trans('main_trans.select_role') }} — {{ trans('main_trans.Main_title') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @if (LaravelLocalization::getCurrentLocaleDirection() === 'rtl')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @endif

    <style>
        /* ══════════════════════════════════════
           BASE & VARIABLES
        ══════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --em:        #10b981;
            --em-d:      #059669;
            --em-dd:     #047857;
            --bg:        #070c14;
            --bg-card:   rgba(255,255,255,.028);
            --bg-hover:  rgba(16,185,129,.05);
            --border:    rgba(255,255,255,.07);
            --bdr-hover: rgba(16,185,129,.35);
            --txt:       rgba(255,255,255,.9);
            --txt-m:     rgba(255,255,255,.45);
            --txt-s:     rgba(255,255,255,.28);
        }

        html, body {
            height: 100%;
            font-family: 'Cairo', sans-serif;
            overflow: hidden;
            background: var(--bg);
        }

        /* Subtle dot grid on dark background */
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,.035) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        /* Faint emerald bloom, center */
        body::after {
            content: '';
            position: fixed;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 700px; height: 700px; border-radius: 50%;
            background: radial-gradient(circle, rgba(16,185,129,.06) 0%, transparent 65%);
            pointer-events: none; z-index: 0;
        }

        /* ══════════════════════════════════════
           LANGUAGE SWITCHER
        ══════════════════════════════════════ */
        .lang-switcher {
            position: fixed;
            top: 20px;
            inset-inline-end: 24px;
            z-index: 200;
        }
        .lang-btn {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.06);
            border: 1px solid var(--border);
            color: var(--txt-m);
            font-family: 'Cairo', sans-serif;
            font-size: .8rem; font-weight: 700;
            padding: 7px 16px; border-radius: 50px;
            cursor: pointer; transition: all .2s;
            backdrop-filter: blur(10px);
        }
        .lang-btn:hover {
            background: rgba(255,255,255,.1);
            color: var(--txt);
            border-color: rgba(255,255,255,.18);
        }
        .lang-btn::after { display: none; }

        .lang-menu {
            background: rgba(10,16,26,.96) !important;
            border: 1px solid rgba(255,255,255,.08) !important;
            backdrop-filter: blur(20px);
            border-radius: 14px !important;
            padding: 6px !important;
            min-width: 160px !important;
            box-shadow: 0 20px 50px rgba(0,0,0,.6) !important;
            margin-top: 8px !important;
        }
        .lang-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px !important; border-radius: 8px !important;
            color: var(--txt-m) !important;
            font-family: 'Cairo', sans-serif !important;
            font-size: .85rem !important; font-weight: 600 !important;
            transition: background .15s !important;
        }
        .lang-item:hover { background: rgba(255,255,255,.06) !important; color: var(--txt) !important; }
        .lang-item.active-lang {
            color: var(--em) !important;
            background: rgba(16,185,129,.08) !important;
        }

        /* ══════════════════════════════════════
           FULL-SCREEN 2×2 TILE GRID
        ══════════════════════════════════════ */
        .tiles-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* Grid dividers — single thin lines */
        .tiles-grid::before {
            content: '';
            position: absolute;
            top: 0; left: 50%; bottom: 0;
            width: 1px;
            background: var(--border);
            pointer-events: none; z-index: 5;
        }
        .tiles-grid::after {
            content: '';
            position: absolute;
            left: 0; top: 50%; right: 0;
            height: 1px;
            background: var(--border);
            pointer-events: none; z-index: 5;
        }

        /* ── Each tile ── */
        .tile {
            position: relative; overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; color: var(--txt);
            cursor: pointer;
            background: var(--bg-card);
            transition: background .35s ease, filter .35s ease;
            isolation: isolate;
        }

        /* Dim non-hovered tiles */
        .tiles-grid:has(.tile:hover) .tile:not(:hover) {
            filter: brightness(.45);
        }

        /* Hovered tile: subtle emerald wash */
        .tile:hover { background: var(--bg-hover); }

        /* Emerald left-edge accent appears on hover */
        .tile::before {
            content: '';
            position: absolute;
            inset-inline-start: 0; top: 20%; bottom: 20%;
            width: 3px;
            background: linear-gradient(to bottom, transparent, var(--em), transparent);
            border-radius: 0 3px 3px 0;
            opacity: 0;
            transition: opacity .35s ease;
        }
        .tile:hover::before { opacity: 1; }

        /* Radial glow behind the icon on hover */
        .tile::after {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(16,185,129,.06) 0%, transparent 65%);
            opacity: 0; pointer-events: none;
            transition: opacity .45s ease;
        }
        .tile:hover::after { opacity: 1; }

        .tile:focus-visible {
            outline: 2px solid rgba(16,185,129,.7);
            outline-offset: -2px;
            z-index: 20;
        }

        /* ── Tile content ── */
        .tile-body {
            position: relative; z-index: 2;
            text-align: center;
            display: flex; flex-direction: column; align-items: center;
            padding: 24px;
            transition: transform .4s cubic-bezier(.22,.68,0,1.2);
        }
        .tile:hover .tile-body { transform: translateY(-10px); }

        /* Corner role label */
        .tile-tag {
            position: absolute;
            top: 22px; inset-inline-end: 22px;
            font-size: 9px; font-weight: 700;
            letter-spacing: 2px; text-transform: uppercase;
            color: var(--txt-s); z-index: 3;
            transition: color .3s;
        }
        .tile:hover .tile-tag { color: var(--em); }

        /* Icon box — same emerald style for all roles */
        .tile-icon {
            width: 100px; height: 100px; border-radius: 28px;
            background: rgba(16,185,129,.08);
            border: 1.5px solid rgba(16,185,129,.18);
            display: flex; align-items: center; justify-content: center;
            font-size: 44px; color: var(--em);
            margin-bottom: 24px;
            transition: all .4s cubic-bezier(.22,.68,0,1.2);
            box-shadow: 0 0 0 0 rgba(16,185,129,0);
        }
        .tile:hover .tile-icon {
            background: rgba(16,185,129,.14);
            border-color: rgba(16,185,129,.38);
            transform: scale(1.08) rotate(-3deg);
            box-shadow: 0 0 40px rgba(16,185,129,.18);
        }

        /* Name & description */
        .tile-name {
            font-size: 30px; font-weight: 900;
            color: var(--txt);
            margin-bottom: 8px;
            letter-spacing: -.3px;
        }
        .tile-desc {
            font-size: 13px; font-weight: 500;
            color: var(--txt-m);
            line-height: 1.65; max-width: 230px;
            transition: color .3s;
        }
        .tile:hover .tile-desc { color: rgba(255,255,255,.65); }

        /* CTA button */
        .tile-cta {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(16,185,129,.12);
            border: 1px solid rgba(16,185,129,.28);
            color: var(--em);
            font-weight: 700; font-size: 13.5px;
            padding: 10px 26px; border-radius: 14px;
            margin-top: 22px;
            opacity: 0; transform: translateY(14px);
            transition: opacity .28s ease .04s, transform .28s ease .04s, background .2s;
        }
        .tile:hover .tile-cta { opacity: 1; transform: translateY(0); }
        .tile-cta:hover { background: rgba(16,185,129,.22) !important; }

        .tile-arrow { font-size: 11px; transition: transform .2s; }
        .tile:hover .tile-arrow { transform: translateX(-4px); }
        [dir="ltr"] .tile:hover .tile-arrow { transform: translateX(4px); }

        /* ── Center badge (school logo) ── */
        .center-badge {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            z-index: 50; pointer-events: none;
            display: flex; flex-direction: column; align-items: center;
            gap: 10px;
            animation: badgeIn .6s .3s cubic-bezier(.22,.68,0,1.2) both;
        }
        @keyframes badgeIn {
            from { opacity: 0; transform: translate(-50%, -50%) scale(.7); }
            to   { opacity: 1; transform: translate(-50%, -50%) scale(1); }
        }

        .badge-disk {
            width: 88px; height: 88px; border-radius: 50%;
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 40px rgba(0,0,0,.55),
                        0 0 0 6px rgba(255,255,255,.08),
                        0 0 0 12px rgba(255,255,255,.03);
        }
        .badge-disk i { font-size: 38px; color: var(--em-d); }

        .badge-name {
            font-size: 10px; font-weight: 700; letter-spacing: .6px;
            text-transform: uppercase;
            color: var(--txt-s);
            background: rgba(0,0,0,.4);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,.07);
            padding: 4px 14px; border-radius: 20px;
            white-space: nowrap;
        }

        /* ── Entry animations ── */
        .tile { opacity: 0; }
        .tile:nth-child(2) { animation: tileIn .6s cubic-bezier(.22,.68,0,1.2) .06s  forwards; }
        .tile:nth-child(3) { animation: tileIn .6s cubic-bezier(.22,.68,0,1.2) .12s  forwards; }
        .tile:nth-child(4) { animation: tileIn .6s cubic-bezier(.22,.68,0,1.2) .18s  forwards; }
        .tile:nth-child(5) { animation: tileIn .6s cubic-bezier(.22,.68,0,1.2) .24s  forwards; }
        @keyframes tileIn {
            from { opacity: 0; transform: scale(.97); }
            to   { opacity: 1; transform: scale(1); }
        }

        /* ── Ripple ── */
        .ripple {
            position: absolute; border-radius: 50%;
            background: rgba(16,185,129,.15);
            transform: scale(0);
            animation: rippleAnim .7s linear;
            pointer-events: none; z-index: 1;
        }
        @keyframes rippleAnim { to { transform: scale(5); opacity: 0; } }

        /* ══════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════ */
        @media (max-width: 640px) {
            html, body { overflow-y: auto; }
            .tiles-grid {
                grid-template-columns: 1fr;
                grid-template-rows: repeat(4, 56vw);
                height: auto; min-height: 100vh;
            }
            .tiles-grid::before, .tiles-grid::after { display: none; }
            .center-badge { display: none; }
            .tile-name  { font-size: 24px; }
            .tile-icon  { width: 78px; height: 78px; font-size: 34px; margin-bottom: 14px; }
            .tile-desc  { font-size: 12px; }
            .tile-cta   { opacity: 1; transform: none; margin-top: 14px; }
            .tile:hover .tile-body { transform: none; }
            .lang-switcher { top: 12px; inset-inline-end: 12px; }
            .tile { animation: fadeIn .45s ease forwards !important; }
            @keyframes fadeIn { to { opacity: 1; } }
        }
        @media (min-width: 641px) and (max-width: 900px) {
            .tile-name  { font-size: 24px; }
            .tile-icon  { width: 84px; height: 84px; font-size: 36px; }
            .badge-disk { width: 72px; height: 72px; }
            .badge-disk i { font-size: 30px; }
        }
    </style>
</head>
<body>

    {{-- Language Switcher --}}
    <div class="lang-switcher dropdown">
        <button class="lang-btn dropdown-toggle" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-globe"></i>
            {{ trans('main_trans.lang_name') }}
        </button>
        <ul class="dropdown-menu lang-menu dropdown-menu-end">
            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li>
                    <a class="lang-item {{ app()->getLocale() === $localeCode ? 'active-lang' : '' }}"
                       rel="alternate"
                       hreflang="{{ $localeCode }}"
                       href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                        <i class="fas fa-language"></i>
                        {{ $properties['native'] }}
                        @if (app()->getLocale() === $localeCode)
                            <i class="fas fa-check ms-auto" style="font-size:.72rem;"></i>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- 2×2 Tile Grid --}}
    <div class="tiles-grid">

        {{-- Center badge --}}
        <div class="center-badge">
            <div class="badge-disk">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="badge-name">{{ trans('main_trans.Programname') }}</div>
        </div>

        {{-- Student --}}
        <a href="{{ route('login.show', 'student') }}"
           class="tile"
           aria-label="{{ trans('main_trans.role_student') }}">
            <span class="tile-tag">STUDENT</span>
            <div class="tile-body">
                <div class="tile-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="tile-name">{{ trans('main_trans.role_student') }}</div>
                <div class="tile-desc">{{ trans('main_trans.role_student_desc') }}</div>
                <div class="tile-cta">
                    {{ trans('main_trans.login_now') }}
                    <i class="fas fa-arrow-left tile-arrow"></i>
                </div>
            </div>
        </a>

        {{-- Parent --}}
        <a href="{{ route('login.show', 'parent') }}"
           class="tile"
           aria-label="{{ trans('main_trans.role_parent') }}">
            <span class="tile-tag">PARENT</span>
            <div class="tile-body">
                <div class="tile-icon"><i class="fas fa-users"></i></div>
                <div class="tile-name">{{ trans('main_trans.role_parent') }}</div>
                <div class="tile-desc">{{ trans('main_trans.role_parent_desc') }}</div>
                <div class="tile-cta">
                    {{ trans('main_trans.login_now') }}
                    <i class="fas fa-arrow-left tile-arrow"></i>
                </div>
            </div>
        </a>

        {{-- Teacher --}}
        <a href="{{ route('login.show', 'teacher') }}"
           class="tile"
           aria-label="{{ trans('main_trans.role_teacher') }}">
            <span class="tile-tag">TEACHER</span>
            <div class="tile-body">
                <div class="tile-icon"><i class="fas fa-chalkboard-user"></i></div>
                <div class="tile-name">{{ trans('main_trans.role_teacher') }}</div>
                <div class="tile-desc">{{ trans('main_trans.role_teacher_desc') }}</div>
                <div class="tile-cta">
                    {{ trans('main_trans.login_now') }}
                    <i class="fas fa-arrow-left tile-arrow"></i>
                </div>
            </div>
        </a>

        {{-- Admin --}}
        <a href="{{ route('login.show', 'admin') }}"
           class="tile"
           aria-label="{{ trans('main_trans.role_admin') }}">
            <span class="tile-tag">ADMIN</span>
            <div class="tile-body">
                <div class="tile-icon"><i class="fas fa-shield-halved"></i></div>
                <div class="tile-name">{{ trans('main_trans.role_admin') }}</div>
                <div class="tile-desc">{{ trans('main_trans.role_admin_desc') }}</div>
                <div class="tile-cta">
                    {{ trans('main_trans.login_now') }}
                    <i class="fas fa-arrow-left tile-arrow"></i>
                </div>
            </div>
        </a>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Ripple on click
        document.querySelectorAll('.tile').forEach(tile => {
            tile.addEventListener('click', function (e) {
                const rect = this.getBoundingClientRect();
                const r    = document.createElement('span');
                r.className = 'ripple';
                const d = Math.max(rect.width, rect.height);
                Object.assign(r.style, {
                    width:  d + 'px', height: d + 'px',
                    left:   (e.clientX - rect.left - d / 2) + 'px',
                    top:    (e.clientY - rect.top  - d / 2) + 'px',
                });
                this.appendChild(r);
                setTimeout(() => r.remove(), 750);
            });
        });

        // Arrow-key navigation between tiles
        const tiles = Array.from(document.querySelectorAll('.tile'));
        tiles.forEach((tile, i) => {
            tile.setAttribute('tabindex', '0');
            tile.addEventListener('keydown', e => {
                const isRTL = document.documentElement.dir === 'rtl';
                const map = {
                    ArrowRight: isRTL ? 1 : -1,
                    ArrowLeft:  isRTL ? -1 : 1,
                    ArrowDown:  2, ArrowUp: -2,
                };
                if (map[e.key] !== undefined) {
                    const next = tiles[i + map[e.key]];
                    if (next) { e.preventDefault(); next.focus(); }
                }
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); tile.click(); }
            });
        });
    </script>
</body>
</html>
