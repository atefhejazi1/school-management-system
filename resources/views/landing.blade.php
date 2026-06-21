<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('landing_trans.meta_title') }}</title>
    <meta name="description" content="{{ trans('landing_trans.meta_description') }}">

    {{-- Cairo Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 — RTL or LTR --}}
    @if (LaravelLocalization::getCurrentLocaleDirection() === 'rtl')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @endif

    @livewireStyles

    <style>
        /* ══════════════════════════════════════════════════════════
           نظام تصميم مؤسسي مسطّح بالكامل: خلفية بيضاء صرفة، نص Slate Gray
           (#334155)، ولون تمييز واحد فقط هو Emerald Green (#059669).
           لا توجد هنا أي تدرّجات لونية (gradients)، ولا أي ظلال (shadows)،
           ولا أيقونات أو رموز تعبيرية (emojis) في أي عنصر من عناصر الصفحة.
           كل الحواف حادّة تماماً (border-radius: 0) في كل مكوّنات الصفحة.
        ══════════════════════════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Cairo', sans-serif;
            background: #ffffff;
            color: #334155;
            overflow-x: hidden;
        }
        a { text-decoration: none; }

        /* ── NAVBAR ── */
        #mainNav {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding-top: 16px;
            padding-bottom: 16px;
        }
        .nav-brand-text { font-size: 1.05rem; font-weight: 800; color: #334155; line-height: 1.1; }
        .nav-brand-sub  { font-size: .68rem; font-weight: 500; color: #64748b; }

        .navbar-nav .nav-link {
            color: #334155 !important;
            font-weight: 600; font-size: .9rem;
            padding: 6px 14px !important;
            border-radius: 0;
        }
        .navbar-nav .nav-link:hover { color: #059669 !important; }

        .btn-nav-login {
            background: transparent;
            border: 1px solid #334155;
            color: #334155 !important;
            font-weight: 700; font-size: .88rem;
            padding: 8px 22px; border-radius: 0;
        }
        .btn-nav-login:hover { background: #334155; color: #ffffff !important; }

        .btn-lang-toggle {
            display: inline-flex; align-items: center; gap: 6px;
            background: transparent; border: 1px solid #cbd5e1;
            color: #334155; font-weight: 700; font-size: .82rem;
            padding: 7px 16px; border-radius: 0; cursor: pointer;
        }
        .btn-lang-toggle:hover { border-color: #059669; color: #059669; }
        .navbar-toggler { border: 1px solid #cbd5e1; border-radius: 0; padding: 6px 10px; box-shadow: none !important; }

        /* ── HERO ── */
        .hero-section {
            background: #ffffff;
            padding-top: 80px; padding-bottom: 70px;
            border-bottom: 1px solid #e2e8f0;
        }
        .hero-title {
            font-size: clamp(2.1rem, 4.6vw, 3.4rem);
            font-weight: 900; color: #334155; line-height: 1.2; margin-bottom: 22px;
        }
        .hero-title .highlight { color: #059669; }
        .hero-subtitle {
            font-size: 1.08rem; color: #475569;
            font-weight: 400; line-height: 1.8; max-width: 600px; margin-bottom: 36px;
        }
        .hero-btns { display: flex; flex-wrap: wrap; gap: 14px; margin-bottom: 50px; }
        .btn-hero-primary {
            background: #059669; color: #ffffff; font-weight: 700; font-size: 1rem;
            padding: 14px 34px; border-radius: 0; border: 1px solid #059669;
        }
        .btn-hero-primary:hover { background: #047857; border-color: #047857; color: #ffffff; }
        .btn-hero-outline {
            background: transparent; border: 1px solid #334155;
            color: #334155; font-weight: 700; font-size: 1rem;
            padding: 14px 34px; border-radius: 0;
        }
        .btn-hero-outline:hover { background: #334155; color: #ffffff; }

        .hero-stats {
            display: grid; grid-template-columns: repeat(4, 1fr);
            border-top: 1px solid #e2e8f0; max-width: 620px;
        }
        .stat-col { padding: 16px 18px 0; border-inline-end: 1px solid #e2e8f0; }
        .stat-col:last-child { border-inline-end: none; }
        .stat-num { font-size: 1.5rem; font-weight: 900; color: #059669; line-height: 1; }
        .stat-label { font-size: .76rem; color: #64748b; font-weight: 600; margin-top: 4px; }

        .hero-panel {
            background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; padding: 26px 28px;
        }
        .hero-panel-head {
            display: flex; align-items: center; justify-content: space-between;
            padding-bottom: 18px; margin-bottom: 18px; border-bottom: 1px solid #e2e8f0;
        }
        .hero-panel-title { font-size: .92rem; font-weight: 800; color: #334155; }
        .hero-panel-live  { font-size: .72rem; font-weight: 700; color: #059669; }
        .hero-stat-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 0; border-bottom: 1px solid #f1f5f9;
        }
        .hero-stat-row:last-child { border-bottom: none; padding-bottom: 0; }
        .hero-stat-row-num   { font-size: 1.2rem; font-weight: 900; color: #334155; line-height: 1; }
        .hero-stat-row-label { font-size: .8rem; color: #64748b; }

        /* ── SECTION HEADER ── */
        .section-tag {
            display: inline-block; font-size: .75rem; font-weight: 800;
            letter-spacing: 1.5px; text-transform: uppercase;
            color: #059669; border: 1px solid #059669;
            padding: 4px 14px; border-radius: 0; margin-bottom: 14px;
        }
        .section-title {
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            font-weight: 900; color: #334155; line-height: 1.3; margin-bottom: 14px;
        }
        .section-sub { font-size: 1.02rem; color: #64748b; font-weight: 400; max-width: 640px; margin: 0 auto; }

        /* ── FEATURES ── */
        .features-section { padding: 80px 0; background: #ffffff; border-bottom: 1px solid #e2e8f0; }
        .feat-card { border: 1px solid #e2e8f0; border-radius: 0; padding: 26px 22px; height: 100%; }
        .feat-title { font-size: 1rem; font-weight: 800; color: #334155; margin-bottom: 8px; }
        .feat-desc  { font-size: .85rem; color: #64748b; line-height: 1.7; }

        /* ── ROLES ── */
        .roles-section { padding: 80px 0; background: #ffffff; border-bottom: 1px solid #e2e8f0; }
        .role-card { border: 1px solid #e2e8f0; border-radius: 0; padding: 28px 22px; height: 100%; }
        .role-name { font-size: 1.05rem; font-weight: 800; color: #334155; margin-bottom: 10px; }
        .role-desc { font-size: .85rem; color: #64748b; line-height: 1.7; margin-bottom: 14px; }
        .role-badge {
            display: inline-block; font-size: .72rem; font-weight: 700;
            color: #059669; border: 1px solid #059669; padding: 3px 12px; border-radius: 0;
        }

        /* ── PRICING / PLANS ── */
        .pricing-section { padding: 80px 0; background: #ffffff; border-bottom: 1px solid #e2e8f0; }
        .pricing-card { border: 1px solid #e2e8f0; border-radius: 0; padding: 30px 26px; height: 100%; display: flex; flex-direction: column; }
        .pricing-name { font-size: 1.1rem; font-weight: 800; color: #334155; margin-bottom: 14px; }
        .pricing-price { font-size: 1.9rem; font-weight: 900; color: #059669; margin-bottom: 4px; }
        .pricing-price-unit { font-size: .82rem; color: #64748b; font-weight: 600; }
        .pricing-feature {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 0; border-top: 1px solid #f1f5f9; font-size: .86rem; margin-top: 14px;
        }
        .pricing-feature-label { color: #64748b; }
        .pricing-feature-value { color: #334155; font-weight: 700; }
        .pricing-cta {
            margin-top: 22px; text-align: center;
            background: #ffffff; color: #059669; border: 1px solid #059669; border-radius: 0;
            padding: 11px 18px; font-weight: 700; font-size: .88rem;
        }
        .pricing-cta:hover { background: #059669; color: #ffffff; }
        .pricing-empty { text-align: center; color: #64748b; font-size: .95rem; padding: 30px 0; }

        /* ── SAAS / MULTI-SCHOOL ── */
        .saas-section { padding: 80px 0; background: #ffffff; border-bottom: 1px solid #e2e8f0; }
        .saas-check { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 18px; }
        .saas-check-mark {
            width: 10px; height: 10px; background: #059669; flex-shrink: 0; margin-top: 6px;
        }
        .saas-check-text { font-size: .94rem; color: #334155; font-weight: 600; line-height: 1.65; }
        .saas-list { border: 1px solid #e2e8f0; border-radius: 0; padding: 28px 26px; }
        .saas-list-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 0; border-bottom: 1px solid #f1f5f9; font-size: .88rem;
        }
        .saas-list-row:last-child { border-bottom: none; }
        .saas-list-label { color: #64748b; }
        .saas-list-value { color: #334155; font-weight: 700; }

        /* ── TECH STACK ── */
        .tech-section { padding: 64px 0; background: #ffffff; border-bottom: 1px solid #e2e8f0; }
        .tech-badge {
            display: inline-flex; align-items: center;
            background: transparent; border: 1px solid #cbd5e1;
            color: #334155; font-size: .86rem; font-weight: 700;
            padding: 9px 20px; border-radius: 0;
        }

        /* ── REGISTRATION ── */
        .register-section { padding: 80px 0; background: #ffffff; }
        .reg-form-card { border: 1px solid #e2e8f0; border-radius: 0; padding: 40px 36px; }
        .reg-input {
            border: 1px solid #cbd5e1 !important;
            border-radius: 0 !important;
            padding: 11px 16px !important;
            font-family: 'Cairo', sans-serif !important;
            font-size: .92rem !important;
        }
        .reg-input:focus {
            border-color: #059669 !important;
            outline: 1px solid #059669 !important;
            box-shadow: none !important;
        }
        .form-label { font-size: .88rem; font-weight: 700; color: #334155; margin-bottom: 6px; }
        .reg-submit-btn {
            background: #059669 !important;
            border: 1px solid #059669 !important; border-radius: 0 !important;
            font-weight: 800 !important; font-size: 1.02rem !important;
            box-shadow: none !important;
            min-width: 220px;
        }
        .reg-submit-btn:hover:not(:disabled) { background: #047857 !important; border-color: #047857 !important; }

        /* ── FOOTER ── */
        .landing-footer { background: #ffffff; padding: 40px 0 26px; border-top: 1px solid #e2e8f0; }
        .footer-brand-name { font-size: 1rem; font-weight: 800; color: #334155; }
        .footer-brand-sub  { font-size: .72rem; color: #64748b; }
        .footer-link { color: #64748b; font-size: .87rem; }
        .footer-link:hover { color: #059669; }
        .footer-copy { font-size: .82rem; color: #94a3b8; }
        .footer-divider { border-color: #e2e8f0 !important; margin: 22px 0 20px; }

        @media (max-width: 767px) {
            .hero-title { font-size: 2rem; }
            .hero-btns  { flex-direction: column; }
            .btn-hero-primary, .btn-hero-outline { width: 100%; text-align: center; }
            .hero-stats { grid-template-columns: repeat(2, 1fr); }
            .stat-col:nth-child(2) { border-inline-end: none; }
            .reg-form-card { padding: 26px 18px; }
        }
    </style>
</head>
<body>

{{-- ══════════════════════════════════════════
     NAVBAR
══════════════════════════════════════════ --}}
<nav class="navbar navbar-expand-lg" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('landing') }}">
            <div>
                <div class="nav-brand-text">{{ trans('landing_trans.brand_name') }}</div>
                <div class="nav-brand-sub">School Management SaaS</div>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#home">{{ trans('landing_trans.nav_home') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">{{ trans('landing_trans.nav_features') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#roles">{{ trans('landing_trans.nav_roles') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#pricing">{{ trans('landing_trans.tag_pricing') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#saas">{{ trans('landing_trans.nav_saas') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="#register">{{ trans('landing_trans.nav_register') }}</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <div class="dropdown">
                    <button type="button" class="btn-lang-toggle dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>{{ LaravelLocalization::getSupportedLocales()[app()->getLocale()]['native'] }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="border-radius:0; border-color:#e2e8f0;">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() === $localeCode ? 'active' : '' }}"
                                   rel="alternate"
                                   hreflang="{{ $localeCode }}"
                                   href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <a href="{{ route('selection') }}" class="btn-nav-login">
                    <span>{{ trans('landing_trans.nav_login') }}</span>
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- ══════════════════════════════════════════
     HERO — قسم نصّي بحت، بدون أي عناصر زخرفية أو رسوم متحركة
══════════════════════════════════════════ --}}
<section id="home" class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">
                    <span>{{ trans('landing_trans.hero_title_line1') }}</span><br>
                    <span class="highlight">{{ trans('landing_trans.hero_title_line2') }}</span>
                </h1>

                <p class="hero-subtitle">{{ trans('landing_trans.hero_subtitle') }}</p>

                <div class="hero-btns">
                    <a href="#register" class="btn-hero-primary">
                        <span>{{ trans('landing_trans.hero_btn_register') }}</span>
                    </a>
                    <a href="{{ route('selection') }}" class="btn-hero-outline">
                        <span>{{ trans('landing_trans.nav_login') }}</span>
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat-col">
                        <div class="stat-num">12+</div>
                        <div class="stat-label">{{ trans('landing_trans.stat_modules') }}</div>
                    </div>
                    <div class="stat-col">
                        <div class="stat-num">5</div>
                        <div class="stat-label">{{ trans('landing_trans.stat_roles') }}</div>
                    </div>
                    <div class="stat-col">
                        <div class="stat-num">100%</div>
                        <div class="stat-label">{{ trans('landing_trans.stat_isolation') }}</div>
                    </div>
                    <div class="stat-col">
                        <div class="stat-num">AR / EN</div>
                        <div class="stat-label">{{ trans('landing_trans.stat_languages') }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 offset-lg-1 mt-5 mt-lg-0">
                <div class="hero-panel">
                    <div class="hero-panel-head">
                        <span class="hero-panel-title">{{ trans('landing_trans.hero_panel_title') }}</span>
                        <span class="hero-panel-live">{{ trans('landing_trans.hero_panel_live') }}</span>
                    </div>

                    <div class="hero-stat-row">
                        <span class="hero-stat-row-label">{{ trans('landing_trans.hc_active_students') }}</span>
                        <span class="hero-stat-row-num">+150</span>
                    </div>
                    <div class="hero-stat-row">
                        <span class="hero-stat-row-label">{{ trans('landing_trans.hc_schools_count') }}</span>
                        <span class="hero-stat-row-num">&#8734;</span>
                    </div>
                    <div class="hero-stat-row">
                        <span class="hero-stat-row-label">{{ trans('landing_trans.hc_live_reports_sub') }}</span>
                        <span class="hero-stat-row-num">{{ trans('landing_trans.hc_live_reports') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     FEATURES (12 modules) — بطاقات نصّية مسطّحة بلا أيقونات
══════════════════════════════════════════ --}}
<section id="features" class="features-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag">{{ trans('landing_trans.tag_features') }}</div>
            <h2 class="section-title">{{ trans('landing_trans.features_title') }}</h2>
            <p class="section-sub">{{ trans('landing_trans.features_sub') }}</p>
        </div>

        <div class="row g-4">
            @foreach (['feat1', 'feat2', 'feat3', 'feat4', 'feat5', 'feat6', 'feat7', 'feat8', 'feat9', 'feat10', 'feat11', 'feat12'] as $featKey)
                <div class="col-lg-3 col-md-6">
                    <div class="feat-card">
                        <h3 class="feat-title">{{ trans("landing_trans.{$featKey}_title") }}</h3>
                        <p class="feat-desc">{{ trans("landing_trans.{$featKey}_desc") }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     ROLES
══════════════════════════════════════════ --}}
<section id="roles" class="roles-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag">{{ trans('landing_trans.tag_roles') }}</div>
            <h2 class="section-title">{{ trans('landing_trans.roles_title') }}</h2>
            <p class="section-sub">{{ trans('landing_trans.roles_sub') }}</p>
        </div>

        <div class="row g-4">
            @foreach (['role_admin', 'role_teacher', 'role_student', 'role_parent'] as $roleKey)
                <div class="col-lg-3 col-md-6">
                    <div class="role-card">
                        <h3 class="role-name">{{ trans("landing_trans.{$roleKey}_name") }}</h3>
                        <p class="role-desc">{{ trans("landing_trans.{$roleKey}_desc") }}</p>
                        <span class="role-badge">{{ trans("landing_trans.{$roleKey}_badge") }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     PRICING / PLANS — تُعرَض هنا الباقات الفعلية من قاعدة البيانات
     (جدول plans) بدلاً من بيانات وهمية ثابتة، فأي باقة جديدة يضيفها
     منشئ المنصة تظهر تلقائياً هنا دون أي تعديل على هذه الصفحة.
══════════════════════════════════════════ --}}
<section id="pricing" class="pricing-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag">{{ trans('landing_trans.tag_pricing') }}</div>
            <h2 class="section-title">{{ trans('landing_trans.pricing_title') }}</h2>
            <p class="section-sub">{{ trans('landing_trans.pricing_sub') }}</p>
        </div>

        @if ($plans->isEmpty())
            <p class="pricing-empty">{{ trans('landing_trans.pricing_empty') }}</p>
        @else
            <div class="row g-4 justify-content-center">
                @foreach ($plans as $plan)
                    <div class="col-lg-4 col-md-6">
                        <div class="pricing-card">
                            <div class="pricing-name">{{ $plan->name }}</div>
                            <div class="pricing-price">
                                {{ number_format((float) $plan->price, 2) }}
                                <span class="pricing-price-unit">/ {{ trans('landing_trans.pricing_per_month') }}</span>
                            </div>
                            <div class="pricing-feature">
                                <span class="pricing-feature-label">{{ trans('landing_trans.pricing_max_students_label') }}</span>
                                <span class="pricing-feature-value">{{ $plan->max_students }} {{ trans('landing_trans.pricing_student_unit') }}</span>
                            </div>
                            <a href="#register" class="pricing-cta">{{ trans('landing_trans.pricing_cta') }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ══════════════════════════════════════════
     SAAS / MULTI-SCHOOL PLATFORM
══════════════════════════════════════════ --}}
<section id="saas" class="saas-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="section-tag">{{ trans('landing_trans.tag_saas') }}</div>
                <h2 class="section-title">{{ trans('landing_trans.saas_title') }}</h2>
                <p class="section-sub mb-4" style="margin:0 0 28px; text-align:start;">{{ trans('landing_trans.saas_sub') }}</p>

                <div class="saas-check">
                    <div class="saas-check-mark"></div>
                    <div class="saas-check-text">{{ trans('landing_trans.saas_check1') }}</div>
                </div>
                <div class="saas-check">
                    <div class="saas-check-mark"></div>
                    <div class="saas-check-text">{{ trans('landing_trans.saas_check2') }}</div>
                </div>
                <div class="saas-check">
                    <div class="saas-check-mark"></div>
                    <div class="saas-check-text">{{ trans('landing_trans.saas_check3') }}</div>
                </div>
                <div class="saas-check">
                    <div class="saas-check-mark"></div>
                    <div class="saas-check-text">{{ trans('landing_trans.saas_check4') }}</div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="saas-list">
                    <div class="saas-list-row">
                        <span class="saas-list-label">{{ trans('landing_trans.saas_platform_box') }}</span>
                        <span class="saas-list-value">1</span>
                    </div>
                    <div class="saas-list-row">
                        <span class="saas-list-label">{{ trans('landing_trans.saas_tenant_a') }}</span>
                        <span class="saas-list-value">School A</span>
                    </div>
                    <div class="saas-list-row">
                        <span class="saas-list-label">{{ trans('landing_trans.saas_tenant_b') }}</span>
                        <span class="saas-list-value">School B</span>
                    </div>
                    <div class="saas-list-row">
                        <span class="saas-list-label">{{ trans('landing_trans.saas_tenant_c') }}</span>
                        <span class="saas-list-value">...</span>
                    </div>
                    <div class="saas-list-row">
                        <span class="saas-list-label">{{ trans('landing_trans.saas_lock_badge') }}</span>
                        <span class="saas-list-value">100%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     TECH STACK
══════════════════════════════════════════ --}}
<section class="tech-section">
    <div class="container text-center">
        <div class="section-tag">{{ trans('landing_trans.tag_tech') }}</div>
        <h2 class="section-title">{{ trans('landing_trans.tech_title') }}</h2>
        <p class="section-sub mb-5">{{ trans('landing_trans.tech_sub') }}</p>

        <div class="d-flex flex-wrap justify-content-center gap-3">
            <span class="tech-badge">Laravel 12</span>
            <span class="tech-badge">Livewire 3</span>
            <span class="tech-badge">Multi-Tenant (school_id)</span>
            <span class="tech-badge">AR/EN Localization</span>
            <span class="tech-badge">Bootstrap 5 RTL</span>
            <span class="tech-badge">MySQL</span>
            <span class="tech-badge">Zoom API</span>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     REGISTRATION FORM — خلفية بيضاء صرفة (لا تدرّج لوني داكن كما كانت سابقاً)
══════════════════════════════════════════ --}}
<section id="register" class="register-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center mb-5">
                <div class="section-tag">{{ trans('landing_trans.tag_register') }}</div>
                <h2 class="section-title">{{ trans('landing_trans.register_title') }}</h2>
                <p class="section-sub">{!! trans('landing_trans.register_sub') !!}</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                {{-- إظهار/إخفاء نموذج التسجيل العام يتحكم به منشئ المنصة عبر إعدادات المنصة العامة
                     (allow_public_registration)؛ القيمة الافتراضية '1' تعني إظهار النموذج إذا لم
                     يُحدَّد الإعداد بعد. --}}
                @if (\App\Models\PlatformSetting::get('allow_public_registration', '1') === '1')
                    <div class="reg-form-card">
                        <livewire:school-registration />
                    </div>
                @else
                    <div class="reg-form-card text-center">
                        <p class="mb-0" style="color:#334155; font-weight:600;">{{ trans('landing_trans.register_closed') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     FOOTER
══════════════════════════════════════════ --}}
<footer class="landing-footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5">
                <div class="footer-brand-name">{{ trans('landing_trans.footer_brand_name') }}</div>
                <div class="footer-brand-sub">School Management SaaS</div>
                <p class="footer-copy mt-2">{{ trans('landing_trans.footer_brand_desc') }}</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <a href="https://github.com/atefhejazi1" class="footer-link" target="_blank" rel="noopener">GitHub</a>
                    <a href="#features" class="footer-link">{{ trans('landing_trans.nav_features') }}</a>
                    <a href="#saas" class="footer-link">{{ trans('landing_trans.footer_platform_link') }}</a>
                </div>
            </div>
            <div class="col-md-3 text-md-start text-center mt-3 mt-md-0">
                <p class="footer-copy">© {{ date('Y') }} <span>{{ trans('landing_trans.footer_brand_name') }}</span></p>
                <p class="footer-copy"><span>{{ trans('landing_trans.footer_dev_by') }}</span> <strong style="color:#334155;">{{ trans('main_trans.Name_Programer') }}</strong></p>
            </div>
        </div>

        <hr class="footer-divider">
        <p class="text-center footer-copy mb-0">{{ trans('landing_trans.footer_tagline') }}</p>
    </div>
</footer>

{{-- Bootstrap 5 JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@livewireScripts

<script>
    // تمرير سلِس فقط عند الضغط على روابط الفهرس الداخلية (#section) — بدون أي تأثيرات
    // حركية أو تلاشي تدريجي (fade-in)، لتفادي اللمسة "المُولَّدة بالذكاء الاصطناعي"
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', e => {
            const target = document.querySelector(link.getAttribute('href'));
            if (target) {
                e.preventDefault();
                const offset = 70;
                window.scrollTo({ top: target.offsetTop - offset, behavior: 'smooth' });
            }
        });
    });
</script>

</body>
</html>
