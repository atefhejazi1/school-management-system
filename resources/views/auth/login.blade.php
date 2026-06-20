<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{ trans('main_trans.login_page_title') }} — {{ trans('main_trans.Main_title') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @if (LaravelLocalization::getCurrentLocaleDirection() === 'rtl')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    <style>
        :root {
            --lp-text:   #334155;
            --lp-heading:#0f172a;
            --lp-border: #e2e8f0;
            --lp-bg-soft:#f8fafc;
            --lp-accent: #059669;
            --lp-accent-dark: #047857;
            --lp-danger: #b91c1c;
            --lp-danger-bg: #fef2f2;
            --lp-danger-border: #fecaca;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Cairo', sans-serif;
            background: #ffffff;
            color: var(--lp-text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lp-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 32px 20px;
        }

        .lp-brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .lp-brand-name {
            font-size: 17px;
            font-weight: 700;
            color: var(--lp-heading);
        }

        .lp-card {
            border: 1px solid var(--lp-border);
            padding: 36px 32px;
        }

        .lp-card h1 {
            font-size: 19px;
            font-weight: 700;
            color: var(--lp-heading);
            margin: 0 0 6px;
        }

        .lp-card p.lp-subtitle {
            font-size: 13px;
            color: var(--lp-text);
            margin: 0 0 24px;
        }

        .lp-alert {
            background: var(--lp-danger-bg);
            border: 1px solid var(--lp-danger-border);
            color: var(--lp-danger);
            font-size: 13px;
            padding: 11px 14px;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--lp-text);
        }

        .form-control {
            border: 1px solid var(--lp-border);
            border-radius: 4px;
            font-family: 'Cairo', sans-serif;
            font-size: 14px;
            padding: 10px 12px;
            color: var(--lp-heading);
        }

        .form-control:focus {
            border-color: var(--lp-accent);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15);
        }

        .form-control.is-invalid {
            border-color: var(--lp-danger);
        }

        .invalid-feedback {
            font-size: 12px;
        }

        .form-check-input:checked {
            background-color: var(--lp-accent);
            border-color: var(--lp-accent);
        }

        .form-check-label {
            font-size: 13px;
            color: var(--lp-text);
        }

        .lp-forgot {
            font-size: 13px;
            color: var(--lp-accent);
            text-decoration: none;
        }

        .lp-forgot:hover {
            color: var(--lp-accent-dark);
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            background: var(--lp-accent);
            border: 1px solid var(--lp-accent);
            color: #ffffff;
            border-radius: 4px;
            font-family: 'Cairo', sans-serif;
            font-size: 14px;
            font-weight: 700;
            padding: 11px 0;
        }

        .btn-submit:hover {
            background: var(--lp-accent-dark);
            border-color: var(--lp-accent-dark);
            color: #ffffff;
        }

        .btn-submit:focus {
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.25);
        }

        .lp-footer-note {
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            margin-top: 18px;
        }

        .lp-lang-switcher {
            position: fixed;
            top: 20px;
            inset-inline-end: 24px;
        }
        .lp-lang-btn {
            display: inline-flex; align-items: center; gap: 8px;
            background: #ffffff;
            border: 1px solid var(--lp-border);
            color: var(--lp-text);
            font-family: 'Cairo', sans-serif;
            font-size: 13px; font-weight: 600;
            padding: 7px 16px; border-radius: 50px;
        }
        .lp-lang-btn::after { display: none; }
    </style>
</head>
<body>
    <div class="lp-lang-switcher dropdown">
        <button class="lp-lang-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-globe"></i> {{ trans('main_trans.lang_name') }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
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

    <div class="lp-wrapper">
        <div class="lp-brand">
            <span class="lp-brand-name">{{ trans('main_trans.Main_title') }}</span>
        </div>

        <div class="lp-card">
            <h1>{{ trans('main_trans.login_page_title') }}</h1>
            <p class="lp-subtitle">{{ trans('main_trans.login_page_subtitle') }}</p>

            @if(\Session::has('message'))
                <div class="lp-alert">{!! \Session::get('message') !!}</div>
            @endif

            <form method="POST" action="{{ $type ? route('login.store', ['type' => $type]) : route('login.attempt') }}">
                @csrf
                @if($type)
                    <input type="hidden" name="type" value="{{ $type }}">
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label">{{ trans('main_trans.email_label') }}</label>
                    <input id="email" type="email" name="email"
                        value="{{ old('email') }}"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        required autocomplete="email" autofocus dir="ltr">
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ trans('main_trans.password_label') }}</label>
                    <input id="password" type="password" name="password"
                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        required autocomplete="current-password" dir="ltr">
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">{{ trans('main_trans.remember_me') }}</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="lp-forgot">{{ trans('main_trans.forgot_password') }}</a>
                </div>

                <button type="submit" class="btn btn-submit">{{ trans('main_trans.login_page_title') }}</button>
            </form>
        </div>

        <p class="lp-footer-note">© {{ date('Y') }} {{ trans('main_trans.Main_title') }}</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
