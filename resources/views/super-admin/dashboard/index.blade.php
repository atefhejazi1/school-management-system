@extends('layouts.super-admin.master')

@section('title', __('super_dash.dashboard'))

@section('content')

    {{-- ══════════════════════════════════════════════════════════
         لوحة تحكم منشئ المنصة — تصميم مسطّح بالكامل خاص بهذه الصفحة فقط:
         خلفية بيضاء، نص Slate Gray (#334155)، لون واحد فقط للتمييز وهو
         Emerald Green (#059669)، بدون أي تدرّجات لونية أو ظلال أو أيقونات
         أو حواف دائرية. لا نستخدم هنا أصناف CSS العامة المشتركة مثل
         admin-card / pf-stat-card / pill لأنها مصمَّمة بظلال وحواف دائرية
         وتُستخدَم في صفحات أخرى لمنشئ المنصة لم يطلب العميل إعادة تصميمها،
         فنُعرّف بدلاً منها أصناف "sad-" مخصّصة لهذه الصفحة وحدها.
    ══════════════════════════════════════════════════════════ --}}

    <div class="sad-header">
        <div>
            <h1 class="sad-title">{{ __('super_dash.dashboard') }}</h1>
            <p class="sad-subtitle">{{ __('super_dash.platform_sub') }}</p>
        </div>
        <a href="{{ route('super-admin.school-requests.index') }}" class="sad-btn-primary">
            {{ __('super_dash.school_requests') }}
        </a>
    </div>

    {{-- ── عدّادات نصّية مسطّحة بالكامل: أرقام واضحة بدون صناديق أو شارات أو ظلال ── --}}
    <div class="sad-metrics-grid">
        <div class="sad-metric">
            <div class="sad-metric-value">{{ $stats['total_schools'] }}</div>
            <div class="sad-metric-label">{{ __('super_dash.total_schools') }}</div>
        </div>
        <div class="sad-metric">
            <div class="sad-metric-value">{{ $stats['active_schools'] }}</div>
            <div class="sad-metric-label">{{ __('super_dash.active_schools') }}</div>
        </div>
        <div class="sad-metric">
            <div class="sad-metric-value">{{ $stats['suspended_schools'] }}</div>
            <div class="sad-metric-label">{{ __('super_dash.suspended_schools') }}</div>
        </div>
        <div class="sad-metric">
            <div class="sad-metric-value">{{ $stats['pending_requests'] }}</div>
            <div class="sad-metric-label">{{ __('super_dash.pending_requests') }}</div>
        </div>
        <div class="sad-metric">
            <div class="sad-metric-value">{{ $stats['total_students'] }}</div>
            <div class="sad-metric-label">{{ trans('super_dash.total_students_platform') }}</div>
        </div>
        <div class="sad-metric">
            <div class="sad-metric-value">{{ $stats['total_teachers'] }}</div>
            <div class="sad-metric-label">{{ trans('super_dash.total_teachers_platform') }}</div>
        </div>
        <div class="sad-metric">
            <div class="sad-metric-value">{{ $stats['total_parents'] }}</div>
            <div class="sad-metric-label">{{ trans('super_dash.total_parents_platform') }}</div>
        </div>
    </div>

    {{-- ── شريط البحث السريع عن المدارس + رابط ضبط إعدادات المنصة العامة ── --}}
    <div class="sad-toolbar">
        <input type="text" id="sadSchoolSearch" class="sad-search-input"
               placeholder="{{ trans('super_dash.search_schools_placeholder') }}">
        <a href="{{ route('super-admin.settings.index') }}" class="sad-btn-outline">
            {{ trans('super_dash.configure_settings_link') }}
        </a>
    </div>

    {{-- ── جدول أحدث تسجيلات المدارس: رأس مسطّح بخلفية #F8FAFC ونص رمادي غامق بارز ── --}}
    <div class="sad-table-wrap">
        <div class="sad-table-title">{{ trans('super_dash.recent_signups_title') }}</div>
        <table class="sad-table">
            <thead>
            <tr>
                <th>{{ trans('super_dash.school_name_th') }}</th>
                <th>{{ trans('super_dash.school_status_th') }}</th>
                <th>{{ trans('super_dash.date_th') }}</th>
                <th>{{ trans('super_dash.actions_th') }}</th>
            </tr>
            </thead>
            <tbody id="sadSchoolRows">
            @forelse ($recentSchools as $school)
                <tr class="sad-school-row">
                    <td class="sad-school-name">{{ $school->name }}</td>
                    <td>
                        @if ($school->isActive())
                            {{ trans('super_dash.school_status_active') }}
                        @elseif ($school->isSuspended())
                            {{ trans('super_dash.school_status_suspended') }}
                        @else
                            {{ $school->status }}
                        @endif
                    </td>
                    <td>{{ $school->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('super-admin.plan-selection.index', $school) }}" class="sad-row-action">
                            {{ trans('super_dash.view_school_action') }}
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="sad-empty">{{ trans('super_dash.no_recent_schools') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <style>
        /* ── Header ── */
        .sad-header {
            display: flex; align-items: flex-start; justify-content: space-between;
            gap: 16px; flex-wrap: wrap; margin-bottom: 26px;
        }
        .sad-title { font-size: 1.4rem; font-weight: 800; color: #334155; margin: 0 0 4px; }
        .sad-subtitle { font-size: .85rem; color: #64748b; margin: 0; }

        .sad-btn-primary {
            background: #059669; color: #ffffff; border: 1px solid #059669; border-radius: 0;
            padding: 9px 20px; font-family: 'Cairo', sans-serif; font-size: .85rem; font-weight: 700;
            text-decoration: none; display: inline-block;
        }
        .sad-btn-primary:hover { background: #047857; color: #ffffff; border-color: #047857; }

        .sad-btn-outline {
            background: #ffffff; color: #334155; border: 1px solid #e2e8f0; border-radius: 0;
            padding: 9px 18px; font-family: 'Cairo', sans-serif; font-size: .85rem; font-weight: 700;
            text-decoration: none; display: inline-block; white-space: nowrap;
        }
        .sad-btn-outline:hover { background: #f8fafc; color: #334155; }

        /* ── Metrics: plain text grid, no card boxes, no shadows, no badges ── */
        .sad-metrics-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;
            margin-bottom: 26px;
        }
        .sad-metric {
            padding: 20px 18px;
            border-inline-end: 1px solid #e2e8f0;
        }
        .sad-metric:nth-child(4n) { border-inline-end: none; }
        .sad-metric-value { font-size: 1.9rem; font-weight: 800; color: #059669; line-height: 1; margin-bottom: 6px; }
        .sad-metric-label { font-size: .8rem; font-weight: 700; color: #334155; }

        /* ── Toolbar: flat search input + settings link ── */
        .sad-toolbar { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 18px; }
        .sad-search-input {
            flex: 1 1 280px;
            border: 1px solid #cbd5e1; border-radius: 0;
            padding: 10px 14px; font-family: 'Cairo', sans-serif; font-size: .88rem;
            color: #334155; background: #ffffff;
        }
        .sad-search-input:focus { outline: 1px solid #059669; border-color: #059669; box-shadow: none; }

        /* ── Recent sign-ups table ── */
        .sad-table-wrap { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; }
        .sad-table-title { padding: 16px 18px; font-size: .92rem; font-weight: 800; color: #334155; border-bottom: 1px solid #e2e8f0; }
        .sad-table { width: 100%; margin: 0; font-family: 'Cairo', sans-serif; font-size: .87rem; }
        .sad-table thead th {
            background: #f8fafc; color: #334155; font-weight: 700; font-size: .76rem;
            text-transform: uppercase; letter-spacing: .4px; padding: 12px 18px;
            border-bottom: 1px solid #e2e8f0; text-align: start;
        }
        .sad-table tbody td { padding: 12px 18px; border-bottom: 1px solid #f1f5f9; color: #334155; }
        .sad-table tbody tr:last-child td { border-bottom: none; }
        .sad-school-name { font-weight: 700; }
        .sad-empty { text-align: center; padding: 30px; color: #94a3b8; }
        .sad-row-action {
            display: inline-block; background: #ffffff; color: #059669; border: 1px solid #059669; border-radius: 0;
            padding: 5px 14px; font-family: 'Cairo', sans-serif; font-size: .78rem; font-weight: 700; text-decoration: none;
        }
        .sad-row-action:hover { background: #059669; color: #ffffff; }

        @media (max-width: 991px) { .sad-metrics-grid { grid-template-columns: repeat(2, 1fr); } .sad-metric:nth-child(2n) { border-inline-end: none; } .sad-metric:nth-child(4n) { border-inline-end: 1px solid #e2e8f0; } }
        @media (max-width: 575px)  { .sad-metrics-grid { grid-template-columns: 1fr; } .sad-metric { border-inline-end: none !important; border-bottom: 1px solid #f1f5f9; } .sad-metric:last-child { border-bottom: none; } }
    </style>

@endsection

@section('js')
    <script>
        // فلترة فورية على جدول أحدث المدارس حسب الاسم — بحث جانب العميل بدون أي استدعاء خادم،
        // مناسب لعدد صفوف محدود (آخر 8 مدارس) ولا يتطلب نقطة نهاية بحث مخصّصة
        document.getElementById('sadSchoolSearch')?.addEventListener('input', function (e) {
            var term = e.target.value.trim().toLowerCase();
            document.querySelectorAll('#sadSchoolRows .sad-school-row').forEach(function (row) {
                var name = row.querySelector('.sad-school-name').textContent.toLowerCase();
                row.style.display = name.includes(term) ? '' : 'none';
            });
        });
    </script>
@endsection
