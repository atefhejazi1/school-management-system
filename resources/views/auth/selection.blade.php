<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>برنامج إدارة المدارس — اختيار الحساب</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { font-family: 'Cairo', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; overflow: hidden; }

        /* ─── Full-screen 2×2 grid ─── */
        .tiles-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            height: 100vh;
            position: relative;
        }

        /* ─── Tile base ─── */
        .tile {
            position: relative; overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; color: white;
            cursor: pointer;
            transition: filter 0.45s ease;
            isolation: isolate;
        }

        /* Dim all non-hovered tiles */
        .tiles-grid:has(.tile:hover) .tile:not(:hover) {
            filter: brightness(0.58) saturate(0.7);
        }

        /* Focus style */
        .tile:focus-visible {
            outline: 4px solid rgba(255,255,255,0.8);
            outline-offset: -4px;
            z-index: 20;
        }

        /* ─── Role gradients ─── */
        .t-student { background: linear-gradient(145deg, #0369a1 0%, #0891b2 55%, #22d3ee 100%); }
        .t-parent  { background: linear-gradient(145deg, #065f46 0%, #059669 55%, #34d399 100%); }
        .t-teacher { background: linear-gradient(145deg, #92400e 0%, #d97706 55%, #fbbf24 100%); }
        .t-admin   { background: linear-gradient(145deg, #991b1b 0%, #dc2626 55%, #f87171 100%); }

        /* ─── Background decorative circle per tile ─── */
        .tile::before {
            content: ''; position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.09); pointer-events: none; z-index: 0;
            transition: transform 0.6s ease;
        }
        .t-student::before { width: 500px; height: 500px; top: -200px; right: -180px; }
        .t-parent::before  { width: 440px; height: 440px; bottom: -180px; left: -160px; }
        .t-teacher::before { width: 480px; height: 480px; bottom: -190px; right: -170px; }
        .t-admin::before   { width: 420px; height: 420px; top: -170px; left: -150px; }
        .tile:hover::before { transform: scale(1.15); }

        /* ─── Shine sweep on hover ─── */
        .tile::after {
            content: ''; position: absolute;
            top: 0; left: -100%; width: 55%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.11), transparent);
            transition: left 0.75s ease; pointer-events: none; z-index: 0;
        }
        .tile:hover::after { left: 160%; }

        /* ─── Tile body (content) ─── */
        .tile-body {
            position: relative; z-index: 2;
            text-align: center; display: flex; flex-direction: column; align-items: center;
            padding: 20px;
            transition: transform 0.4s cubic-bezier(.22,.68,0,1.2);
        }
        .tile:hover .tile-body { transform: translateY(-16px); }

        /* ─── Corner tag ─── */
        .tile-tag {
            position: absolute; top: 22px;
            font-size: 9.5px; font-weight: 800;
            letter-spacing: 2px; text-transform: uppercase;
            color: rgba(255,255,255,0.38);
            z-index: 3;
            transition: color 0.35s ease, letter-spacing 0.35s ease;
        }
        /* RTL: right-side tag */
        .tile-tag { right: 22px; }
        .tile:hover .tile-tag { color: rgba(255,255,255,0.72); letter-spacing: 2.5px; }

        /* ─── Icon ─── */
        .tile-icon {
            width: 104px; height: 104px; border-radius: 30px;
            background: rgba(255,255,255,0.18);
            border: 2px solid rgba(255,255,255,0.28);
            display: flex; align-items: center; justify-content: center;
            font-size: 46px; color: white;
            margin-bottom: 24px;
            backdrop-filter: blur(8px);
            transition: all 0.4s cubic-bezier(.22,.68,0,1.2);
            box-shadow: 0 8px 40px rgba(0,0,0,0.18);
        }
        .tile:hover .tile-icon {
            background: rgba(255,255,255,0.3);
            border-color: rgba(255,255,255,0.5);
            transform: scale(1.12);
            box-shadow: 0 24px 64px rgba(0,0,0,0.35);
        }

        /* ─── Name & description ─── */
        .tile-name {
            font-size: 32px; font-weight: 900; margin-bottom: 9px;
            text-shadow: 0 2px 20px rgba(0,0,0,0.2);
        }
        .tile-desc {
            font-size: 13.5px; font-weight: 500;
            opacity: 0.72; line-height: 1.6; max-width: 240px;
            transition: opacity 0.3s;
        }
        .tile:hover .tile-desc { opacity: 0.9; }

        /* ─── CTA button ─── */
        .tile-cta {
            display: inline-flex; align-items: center; gap: 9px;
            background: rgba(255,255,255,0.2);
            border: 1.5px solid rgba(255,255,255,0.4);
            color: white; font-weight: 800; font-size: 14.5px;
            padding: 11px 28px; border-radius: 15px;
            margin-top: 24px;
            opacity: 0; transform: translateY(14px);
            transition: opacity 0.35s ease 0.05s, transform 0.35s ease 0.05s, background 0.2s;
            backdrop-filter: blur(6px);
        }
        .tile:hover .tile-cta { opacity: 1; transform: translateY(0); }
        .tile-cta i { font-size: 11px; transition: transform 0.2s; }
        .tile:hover .tile-cta:hover { background: rgba(255,255,255,0.32); }

        /* ─── Center school badge ─── */
        .center-badge {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            z-index: 50;
            pointer-events: none;
            display: flex; flex-direction: column; align-items: center;
            animation: badgeIn 0.6s 0.5s cubic-bezier(.22,.68,0,1.2) both;
        }

        @keyframes badgeIn {
            from { opacity: 0; transform: translate(-50%, -50%) scale(0.6); }
            to   { opacity: 1; transform: translate(-50%, -50%) scale(1); }
        }

        .badge-ring {
            width: 96px; height: 96px; border-radius: 50%;
            background: white;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 12px 56px rgba(0,0,0,0.55), 0 0 0 6px rgba(255,255,255,0.18);
            position: relative;
        }

        .badge-ring::before {
            content: ''; position: absolute; inset: -10px; border-radius: 50%;
            border: 2px dashed rgba(255,255,255,0.45);
            animation: badgeSpin 14s linear infinite;
        }
        .badge-ring::after {
            content: ''; position: absolute; inset: -20px; border-radius: 50%;
            border: 1px dashed rgba(255,255,255,0.22);
            animation: badgeSpin 22s linear infinite reverse;
        }

        .badge-ring i { font-size: 40px; color: #1d4ed8; position: relative; z-index: 1; }

        .badge-label {
            margin-top: 12px; white-space: nowrap;
            font-size: 11px; font-weight: 700; letter-spacing: 0.8px;
            color: rgba(255,255,255,0.55);
            background: rgba(0,0,0,0.25);
            backdrop-filter: blur(8px);
            padding: 5px 14px; border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.12);
        }

        @keyframes badgeSpin { to { transform: rotate(360deg); } }

        /* ─── Entry animations ─── */
        .tile { opacity: 0; }
        .t-student { animation: tileIn 0.65s cubic-bezier(.22,.68,0,1.2) 0s    forwards; }
        .t-parent  { animation: tileIn 0.65s cubic-bezier(.22,.68,0,1.2) 0.1s  forwards; }
        .t-teacher { animation: tileIn 0.65s cubic-bezier(.22,.68,0,1.2) 0.18s forwards; }
        .t-admin   { animation: tileIn 0.65s cubic-bezier(.22,.68,0,1.2) 0.26s forwards; }

        @keyframes tileIn {
            from { opacity: 0; transform: scale(0.96); }
            to   { opacity: 1; transform: scale(1); }
        }

        /* ─── Ripple ─── */
        .ripple {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.28);
            transform: scale(0);
            animation: rippleAnim 0.75s linear;
            pointer-events: none; z-index: 1;
        }
        @keyframes rippleAnim { to { transform: scale(5); opacity: 0; } }

        /* ─── Responsive (mobile: stacked) ─── */
        @media (max-width: 640px) {
            html, body { overflow-y: auto; }
            .tiles-grid {
                grid-template-columns: 1fr;
                grid-template-rows: repeat(4, 56vw);
                height: auto; min-height: 100vh;
            }
            .center-badge { display: none; }
            .tile-name  { font-size: 26px; }
            .tile-icon  { width: 82px; height: 82px; font-size: 36px; margin-bottom: 16px; }
            .tile-desc  { font-size: 12.5px; }
            .tile-cta   { opacity: 1; transform: none; margin-top: 16px; }
            .tile:hover .tile-body { transform: none; }
            .t-student, .t-parent, .t-teacher, .t-admin {
                animation: fadeInMobile 0.5s ease forwards;
            }
            @keyframes fadeInMobile { to { opacity: 1; } }
        }

        @media (min-width: 641px) and (max-width: 900px) {
            .tile-name  { font-size: 26px; }
            .tile-icon  { width: 86px; height: 86px; font-size: 38px; }
            .badge-ring { width: 78px; height: 78px; }
            .badge-ring i { font-size: 32px; }
        }
    </style>
</head>
<body>

    <div class="tiles-grid">

        <!-- ─── Center badge (school logo) ─── -->
        <div class="center-badge">
            <div class="badge-ring">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="badge-label">نظام إدارة المدارس</div>
        </div>

        <!-- ─── Student ─── -->
        <a href="{{ route('login.show', 'student') }}" class="tile t-student" aria-label="دخول الطالب">
            <span class="tile-tag">STUDENT</span>
            <div class="tile-body">
                <div class="tile-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="tile-name">طالب</div>
                <div class="tile-desc">الدرجات · الجدول الدراسي · الحضور</div>
                <div class="tile-cta">دخول الآن <i class="fas fa-arrow-left"></i></div>
            </div>
        </a>

        <!-- ─── Parent ─── -->
        <a href="{{ route('login.show', 'parent') }}" class="tile t-parent" aria-label="دخول ولي الأمر">
            <span class="tile-tag">PARENT</span>
            <div class="tile-body">
                <div class="tile-icon"><i class="fas fa-users"></i></div>
                <div class="tile-name">ولي الأمر</div>
                <div class="tile-desc">تابع تقدم أبنائك ونتائجهم</div>
                <div class="tile-cta">دخول الآن <i class="fas fa-arrow-left"></i></div>
            </div>
        </a>

        <!-- ─── Teacher ─── -->
        <a href="{{ route('login.show', 'teacher') }}" class="tile t-teacher" aria-label="دخول المعلم">
            <span class="tile-tag">TEACHER</span>
            <div class="tile-body">
                <div class="tile-icon"><i class="fas fa-chalkboard-user"></i></div>
                <div class="tile-name">معلم</div>
                <div class="tile-desc">إدارة الفصول والمواد والدرجات</div>
                <div class="tile-cta">دخول الآن <i class="fas fa-arrow-left"></i></div>
            </div>
        </a>

        <!-- ─── Admin ─── -->
        <a href="{{ route('login.show', 'admin') }}" class="tile t-admin" aria-label="دخول المسؤول">
            <span class="tile-tag">ADMIN</span>
            <div class="tile-body">
                <div class="tile-icon"><i class="fas fa-shield-halved"></i></div>
                <div class="tile-name">مسؤول</div>
                <div class="tile-desc">الإدارة الشاملة للنظام والمستخدمين</div>
                <div class="tile-cta">دخول الآن <i class="fas fa-arrow-left"></i></div>
            </div>
        </a>

    </div>

    <script>
        // Ripple on click
        document.querySelectorAll('.tile').forEach(tile => {
            tile.addEventListener('click', function (e) {
                const rect = this.getBoundingClientRect();
                const r = document.createElement('span');
                r.className = 'ripple';
                const d = Math.max(rect.width, rect.height);
                r.style.cssText = `
                    width:${d}px; height:${d}px;
                    left:${e.clientX - rect.left - d/2}px;
                    top:${e.clientY - rect.top - d/2}px;
                `;
                this.appendChild(r);
                setTimeout(() => r.remove(), 750);
            });
        });

        // Keyboard navigation (arrow keys between tiles)
        const tiles = Array.from(document.querySelectorAll('.tile'));
        tiles.forEach((tile, i) => {
            tile.addEventListener('keydown', e => {
                const map = { ArrowRight: -1, ArrowLeft: 1, ArrowDown: 2, ArrowUp: -2 };
                const next = tiles[i + (map[e.key] ?? 0)];
                if (next) { e.preventDefault(); next.focus(); }
            });
        });
    </script>
</body>
</html>
