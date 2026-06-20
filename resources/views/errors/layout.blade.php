<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ in_array(app()->getLocale(), ['ar', 'ur', 'he']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>

    {{-- Cairo Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 — RTL or LTR، بدون أي إضافات أو أيقونات خارجية --}}
    @if (in_array(app()->getLocale(), ['ar', 'ur', 'he']))
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @endif

    <style>
        :root {
            --em-600: #059669;
            --em-700: #047857;
            --slate:  #334155;
        }

        * , *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Cairo', sans-serif;
            background: #f0f4f8;
            color: #1e293b;
            min-height: 100vh;
            margin: 0;
        }

        /* حاوية مركزية مسطّحة بالكامل: بدون تدرج، بدون ظل، بدون حواف دائرية */
        .error-screen {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .error-card {
            width: 100%;
            max-width: 560px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0;
            padding: 48px 40px;
            text-align: center;
        }

        .error-code {
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: 1px;
            color: var(--slate);
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .error-heading {
            font-size: 1.4rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 14px;
        }

        .error-description {
            font-size: .95rem;
            font-weight: 500;
            color: #64748b;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        /* رابط/زر مسطّح بلون Emerald — بدون تدرج وبدون أيقونة */
        .error-action {
            display: inline-block;
            background: var(--em-600);
            color: #ffffff;
            font-weight: 700;
            font-size: .9rem;
            padding: 12px 32px;
            border-radius: 0;
            text-decoration: none;
            border: none;
        }
        .error-action:hover {
            background: var(--em-700);
            color: #ffffff;
        }

        @media (max-width: 575.98px) {
            .error-card { padding: 36px 22px; }
            .error-heading { font-size: 1.15rem; }
        }
    </style>

    @yield('css')
</head>
<body>

    <div class="error-screen">
        <div class="error-card">
            @yield('content')
        </div>
    </div>

</body>
</html>
