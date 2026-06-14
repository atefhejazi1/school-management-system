<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>
        @if($type == 'student') دخول الطالب
        @elseif($type == 'parent') دخول ولي الأمر
        @elseif($type == 'teacher') دخول المعلم
        @else دخول المسؤول
        @endif — نظام إدارة المدارس
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            @if($type == 'student')
            --role-start: #0284c7;
            --role-mid:   #0891b2;
            --role-end:   #06b6d4;
            --role-glow:  rgba(8,145,178,0.45);
            --role-light: rgba(8,145,178,0.1);
            --role-focus: rgba(8,145,178,0.2);
            @elseif($type == 'parent')
            --role-start: #047857;
            --role-mid:   #059669;
            --role-end:   #10b981;
            --role-glow:  rgba(5,150,105,0.45);
            --role-light: rgba(5,150,105,0.1);
            --role-focus: rgba(5,150,105,0.2);
            @elseif($type == 'teacher')
            --role-start: #b45309;
            --role-mid:   #d97706;
            --role-end:   #f59e0b;
            --role-glow:  rgba(217,119,6,0.45);
            --role-light: rgba(217,119,6,0.1);
            --role-focus: rgba(217,119,6,0.2);
            @else
            --role-start: #b91c1c;
            --role-mid:   #dc2626;
            --role-end:   #ef4444;
            --role-glow:  rgba(220,38,38,0.45);
            --role-light: rgba(220,38,38,0.1);
            --role-focus: rgba(220,38,38,0.2);
            @endif
        }

        * { font-family: 'Cairo', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: linear-gradient(-45deg, #0c2461, #1e3799, #0a3d62, #1a237e, #0d47a1);
            background-size: 400% 400%;
            animation: bgShift 18s ease infinite;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; position: relative;
        }

        @keyframes bgShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Blobs */
        .blob {
            position: absolute; border-radius: 50%;
            filter: blur(70px); opacity: 0.18; pointer-events: none;
            animation: blobFloat linear infinite;
        }
        .blob-1 { width: 420px; height: 420px; background: var(--role-end); top: -160px; right: -100px; animation-duration: 22s; }
        .blob-2 { width: 300px; height: 300px; background: #818cf8; bottom: -80px; left: -60px; animation-duration: 28s; animation-direction: reverse; }
        .blob-3 { width: 180px; height: 180px; background: var(--role-mid); top: 55%; left: 28%; animation-duration: 20s; animation-delay: -7s; }

        @keyframes blobFloat {
            0%,100% { transform: translate(0,0) scale(1); }
            33%     { transform: translate(30px,40px) scale(1.06); }
            66%     { transform: translate(-20px,20px) scale(0.94); }
        }

        /* Particles */
        .particles { position: absolute; inset: 0; pointer-events: none; }
        .particle {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.7);
            animation: particleDrift linear infinite;
        }
        @keyframes particleDrift {
            0%   { transform: translateY(110vh) scale(0); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 0.5; }
            100% { transform: translateY(-10vh) scale(1); opacity: 0; }
        }

        /* Back button */
        .back-to-select {
            position: fixed; top: 20px; right: 20px;
            display: flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(8px);
            color: rgba(255,255,255,0.9);
            padding: 8px 18px; border-radius: 12px;
            font-size: 13px; font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
            z-index: 100;
        }
        .back-to-select:hover { background: rgba(255,255,255,0.22); color: white; }

        /* Page wrapper */
        .lp-wrapper {
            position: relative; z-index: 10;
            width: 100%; max-width: 1000px;
            padding: 24px 16px;
        }

        /* Card */
        .lp-card {
            display: grid;
            grid-template-columns: 420px 1fr;
            gap: 0;
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 40px 90px rgba(0,0,0,0.45), 0 0 0 1px rgba(255,255,255,0.08) inset;
            animation: cardIn 0.65s cubic-bezier(.22,.68,0,1.2) both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(44px) scale(0.96); }
            to   { opacity: 1; transform: none; }
        }

        /* ── Info Panel ── */
        .lp-info {
            background: linear-gradient(155deg, var(--role-start) 0%, var(--role-mid) 55%, var(--role-end) 100%);
            padding: 52px 42px;
            display: flex; flex-direction: column; justify-content: space-between;
            position: relative; overflow: hidden;
        }

        .lp-info::before {
            content: ''; position: absolute; top: -80px; right: -80px;
            width: 260px; height: 260px; border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }
        .lp-info::after {
            content: ''; position: absolute; bottom: -50px; left: -50px;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(255,255,255,0.07);
        }

        .lp-info-body { position: relative; z-index: 1; }

        .lp-role-icon {
            width: 82px; height: 82px; border-radius: 22px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(6px);
            border: 1.5px solid rgba(255,255,255,0.3);
            display: flex; align-items: center; justify-content: center;
            font-size: 38px; color: white;
            margin-bottom: 30px;
            box-shadow: 0 8px 28px rgba(0,0,0,0.18);
            animation: iconPulse 3s ease-in-out infinite;
        }

        @keyframes iconPulse {
            0%,100% { box-shadow: 0 8px 28px rgba(0,0,0,0.18); }
            50%     { box-shadow: 0 8px 40px rgba(0,0,0,0.28), 0 0 0 8px rgba(255,255,255,0.06); }
        }

        .lp-info h2 {
            font-size: 27px; font-weight: 900;
            color: white; line-height: 1.2; margin-bottom: 12px;
        }

        .lp-info-desc {
            font-size: 13.5px; color: rgba(255,255,255,0.8);
            line-height: 1.75; margin-bottom: 32px;
        }

        .lp-features { list-style: none; padding: 0; margin: 0; }
        .lp-features li {
            display: flex; align-items: center; gap: 12px;
            font-size: 13px; color: rgba(255,255,255,0.88);
            margin-bottom: 14px; font-weight: 500;
        }
        .lp-feat-icon {
            width: 28px; height: 28px; border-radius: 8px;
            background: rgba(255,255,255,0.22);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; flex-shrink: 0;
        }

        .lp-info-divider {
            height: 1px; background: rgba(255,255,255,0.15); margin: 28px 0;
        }

        /* Step indicator */
        .lp-steps {
            position: relative; z-index: 1;
            display: flex; align-items: center; gap: 10px;
        }
        .lp-step {
            width: 30px; height: 30px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700;
        }
        .lp-step.done {
            background: rgba(255,255,255,0.25);
            color: rgba(255,255,255,0.9);
            border: 1.5px solid rgba(255,255,255,0.4);
        }
        .lp-step.active { background: white; color: var(--role-mid); }
        .lp-step-line { flex: 1; height: 2px; background: rgba(255,255,255,0.2); }
        .lp-step-label { font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.6); margin-right: 6px; }

        /* ── Form Panel ── */
        .lp-form {
            background: rgba(255,255,255,0.97);
            padding: 52px 46px;
            display: flex; flex-direction: column; justify-content: center;
        }

        .lp-form-header { margin-bottom: 32px; }

        .lp-badge {
            display: inline-flex; align-items: center; gap: 7px;
            background: var(--role-light);
            border: 1px solid var(--role-focus);
            color: var(--role-mid);
            font-size: 11.5px; font-weight: 700;
            padding: 5px 13px; border-radius: 10px;
            margin-bottom: 14px;
        }

        .lp-form-header h3 {
            font-size: 23px; font-weight: 900; color: #0f172a; margin-bottom: 5px;
        }
        .lp-form-header p { font-size: 13px; color: #94a3b8; font-weight: 500; margin: 0; }

        /* Error alert */
        .lp-error {
            background: #fef2f2; border: 1px solid #fecaca;
            border-radius: 12px; padding: 13px 16px; margin-bottom: 22px;
            display: flex; align-items: start; gap: 10px;
        }
        .lp-error i { color: #ef4444; font-size: 15px; margin-top: 1px; flex-shrink: 0; }
        .lp-error p { font-size: 13px; color: #991b1b; font-weight: 500; margin: 0; line-height: 1.5; }

        /* Fields */
        .lp-field { margin-bottom: 20px; }
        .lp-field label {
            display: block; font-size: 13px; font-weight: 700;
            color: #374151; margin-bottom: 8px;
        }
        .lp-input-wrap { position: relative; }

        .lp-input-wrap input {
            width: 100%; height: 50px;
            padding: 0 46px 0 16px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 13px;
            font-family: 'Cairo', sans-serif;
            font-size: 14px; color: #0f172a;
            outline: none;
            transition: all 0.25s ease;
        }
        .lp-input-wrap input:focus {
            border-color: var(--role-mid);
            background: white;
            box-shadow: 0 0 0 3px var(--role-focus);
        }
        .lp-input-wrap input.is-invalid {
            border-color: #ef4444; background: #fef2f2;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
        }

        .lp-input-icon {
            position: absolute; right: 15px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 15px; pointer-events: none;
            transition: color 0.2s;
        }
        .lp-input-wrap input:focus ~ .lp-input-icon { color: var(--role-mid); }

        .lp-pwd-toggle {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 14px;
            border: none; background: none; cursor: pointer; padding: 4px;
            transition: color 0.2s;
        }
        .lp-pwd-toggle:hover { color: var(--role-mid); }

        .lp-invalid-msg {
            font-size: 12px; color: #ef4444; font-weight: 600;
            margin-top: 6px; display: flex; align-items: center; gap: 5px;
        }

        /* Remember row */
        .lp-remember-row {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 26px;
        }
        .lp-remember-label {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: #374151; font-weight: 500; cursor: pointer;
        }
        .lp-remember-label input[type="checkbox"] {
            width: 16px; height: 16px; accent-color: var(--role-mid); cursor: pointer;
        }
        .lp-forgot {
            font-size: 12.5px; font-weight: 600;
            color: var(--role-mid); text-decoration: none;
            opacity: 0.9; transition: opacity 0.2s;
        }
        .lp-forgot:hover { opacity: 1; }

        /* Submit */
        .lp-submit {
            width: 100%; height: 52px;
            background: linear-gradient(135deg, var(--role-start) 0%, var(--role-end) 100%);
            color: white; border: none; border-radius: 15px;
            font-family: 'Cairo', sans-serif;
            font-size: 15.5px; font-weight: 800;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            box-shadow: 0 6px 24px var(--role-glow);
            transition: all 0.3s cubic-bezier(.22,.68,0,1.2);
            letter-spacing: 0.3px;
        }
        .lp-submit:hover { transform: translateY(-3px); box-shadow: 0 14px 36px var(--role-glow); }
        .lp-submit:active { transform: translateY(0); }

        /* Security note */
        .lp-security {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            margin-top: 22px;
            font-size: 11.5px; color: #94a3b8; font-weight: 500;
        }
        .lp-security i { color: #10b981; }

        /* Responsive */
        @media (max-width: 860px) {
            .lp-card { grid-template-columns: 1fr; }
            .lp-info { padding: 36px 30px; }
            .lp-form { padding: 36px 30px; }
            .lp-info h2 { font-size: 22px; }
            .lp-features { display: none; }
            .lp-info-divider { display: none; }
        }
        @media (max-width: 480px) {
            .lp-info { padding: 28px 22px; }
            .lp-form { padding: 28px 22px; }
            .lp-form-header h3 { font-size: 20px; }
            .back-to-select { top: 12px; right: 12px; padding: 6px 12px; font-size: 12px; }
        }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
    <div class="particles" id="particles"></div>

    <a href="{{ url('/') }}" class="back-to-select">
        <i class="fas fa-arrow-right"></i>
        تغيير نوع الحساب
    </a>

    <div class="lp-wrapper">
        <div class="lp-card">

            <!-- ── Info Panel ── -->
            <div class="lp-info">
                <div class="lp-info-body">
                    <div class="lp-role-icon">
                        @if($type == 'student')
                            <i class="fas fa-user-graduate"></i>
                        @elseif($type == 'parent')
                            <i class="fas fa-users"></i>
                        @elseif($type == 'teacher')
                            <i class="fas fa-chalkboard-user"></i>
                        @else
                            <i class="fas fa-shield-halved"></i>
                        @endif
                    </div>

                    <h2>
                        @if($type == 'student') بوابة الطلاب
                        @elseif($type == 'parent') بوابة أولياء الأمور
                        @elseif($type == 'teacher') بوابة المعلمين
                        @else بوابة المسؤولين
                        @endif
                    </h2>

                    <p class="lp-info-desc">
                        @if($type == 'student')
                            مرحباً بك — تابع درجاتك وجدولك الدراسي وحضورك من مكان واحد
                        @elseif($type == 'parent')
                            ابقَ على اطلاع دائم بنتائج وتقدم أبنائك في المدرسة
                        @elseif($type == 'teacher')
                            إدارة فصولك وطلابك وتسجيل الدرجات بكل سهولة
                        @else
                            الإدارة الشاملة لجميع جوانب المنظومة التعليمية
                        @endif
                    </p>

                    <ul class="lp-features">
                        @if($type == 'student')
                            <li><span class="lp-feat-icon"><i class="fas fa-star"></i></span> عرض الدرجات والنتائج</li>
                            <li><span class="lp-feat-icon"><i class="fas fa-calendar"></i></span> الجدول الدراسي والواجبات</li>
                            <li><span class="lp-feat-icon"><i class="fas fa-chart-bar"></i></span> متابعة التقدم الأكاديمي</li>
                        @elseif($type == 'parent')
                            <li><span class="lp-feat-icon"><i class="fas fa-eye"></i></span> متابعة نتائج الأبناء</li>
                            <li><span class="lp-feat-icon"><i class="fas fa-comments"></i></span> التواصل مع إدارة المدرسة</li>
                            <li><span class="lp-feat-icon"><i class="fas fa-receipt"></i></span> سداد الرسوم والمصاريف</li>
                        @elseif($type == 'teacher')
                            <li><span class="lp-feat-icon"><i class="fas fa-chalkboard"></i></span> إدارة الفصول والمواد</li>
                            <li><span class="lp-feat-icon"><i class="fas fa-pen-to-square"></i></span> تسجيل الدرجات والحضور</li>
                            <li><span class="lp-feat-icon"><i class="fas fa-upload"></i></span> رفع المحتوى التعليمي</li>
                        @else
                            <li><span class="lp-feat-icon"><i class="fas fa-users"></i></span> إدارة الطلاب والمعلمين</li>
                            <li><span class="lp-feat-icon"><i class="fas fa-chart-line"></i></span> التقارير المالية الشاملة</li>
                            <li><span class="lp-feat-icon"><i class="fas fa-gears"></i></span> إعدادات النظام الكاملة</li>
                        @endif
                    </ul>

                    <div class="lp-info-divider"></div>
                </div>

                <div class="lp-steps">
                    <div class="lp-step done"><i class="fas fa-check" style="font-size:10px;"></i></div>
                    <div class="lp-step-line"></div>
                    <div class="lp-step active">2</div>
                    <span class="lp-step-label">الخطوة 2 من 2</span>
                </div>
            </div>

            <!-- ── Form Panel ── -->
            <div class="lp-form">
                <div class="lp-form-header">
                    <div class="lp-badge">
                        <i class="fas fa-lock"></i>
                        دخول آمن ومشفر
                    </div>
                    <h3>
                        @if($type == 'student') تسجيل دخول الطالب
                        @elseif($type == 'parent') تسجيل دخول ولي الأمر
                        @elseif($type == 'teacher') تسجيل دخول المعلم
                        @else تسجيل دخول المسؤول
                        @endif
                    </h3>
                    <p>أدخل بياناتك للوصول إلى حسابك</p>
                </div>

                @if(\Session::has('message'))
                    <div class="lp-error">
                        <i class="fas fa-circle-exclamation"></i>
                        <p>{!! \Session::get('message') !!}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store', ['type' => $type]) }}">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">

                    <!-- Email -->
                    <div class="lp-field">
                        <label for="email">البريد الإلكتروني</label>
                        <div class="lp-input-wrap">
                            <input id="email" type="email" name="email"
                                value="{{ old('email') }}"
                                class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                                placeholder="example@school.com"
                                required autocomplete="email" autofocus>
                            <i class="fas fa-envelope lp-input-icon"></i>
                        </div>
                        @error('email')
                            <div class="lp-invalid-msg">
                                <i class="fas fa-circle-exclamation"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="lp-field">
                        <label for="password">كلمة المرور</label>
                        <div class="lp-input-wrap">
                            <input id="password" type="password" name="password"
                                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                                placeholder="••••••••••"
                                required autocomplete="current-password">
                            <i class="fas fa-lock lp-input-icon"></i>
                            <button type="button" class="lp-pwd-toggle" id="pwdToggle" tabindex="-1">
                                <i class="fas fa-eye" id="pwdIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="lp-invalid-msg">
                                <i class="fas fa-circle-exclamation"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="lp-remember-row">
                        <label class="lp-remember-label">
                            <input type="checkbox" name="remember" id="remember">
                            تذكرني في هذا الجهاز
                        </label>
                        <a href="#" class="lp-forgot">نسيت كلمة المرور؟</a>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="lp-submit">
                        <i class="fas fa-right-to-bracket"></i>
                        تسجيل الدخول
                    </button>

                    <div class="lp-security">
                        <i class="fas fa-shield-halved"></i>
                        الاتصال محمي بتشفير SSL/TLS
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Particles
        const container = document.getElementById('particles');
        for (let i = 0; i < 18; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            const size = Math.random() * 3.5 + 2;
            p.style.cssText = `
                width:${size}px; height:${size}px;
                left:${Math.random()*100}%;
                animation-duration:${Math.random()*14+10}s;
                animation-delay:${Math.random()*-22}s;
                opacity:${Math.random()*0.4+0.15};
            `;
            container.appendChild(p);
        }

        // Password visibility toggle
        const pwdInput = document.getElementById('password');
        const pwdToggle = document.getElementById('pwdToggle');
        const pwdIcon = document.getElementById('pwdIcon');

        pwdToggle.addEventListener('click', () => {
            const isVisible = pwdInput.type === 'text';
            pwdInput.type = isVisible ? 'password' : 'text';
            pwdIcon.className = isVisible ? 'fas fa-eye' : 'fas fa-eye-slash';
        });
    </script>
</body>
</html>
