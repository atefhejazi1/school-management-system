{{-- ══════════════════════════════════════════
     شريط معاينة منشئ المنصة لحساب مدير مدرسة (Impersonation Banner)
     يظهر فقط إذا كانت الجلسة الحالية تحمل هوية منشئ منصة أصلية محفوظة
     (أي أن منشئ المنصة دخل مؤقتاً بهوية مدير مدرسة عبر ImpersonationController).
══════════════════════════════════════════ --}}
@if (session()->has('original_super_admin_id'))
    <div class="impersonation-banner">
        <span class="impersonation-text">
            {{ trans('super_dash.impersonation_banner_text', ['name' => auth()->user()->school->name ?? '']) }}
        </span>
        <form method="POST" action="{{ route('leave_impersonation') }}" class="impersonation-form">
            @csrf
            <button type="submit" class="impersonation-leave-link">{{ trans('super_dash.return_to_super_admin_dashboard') }}</button>
        </form>
    </div>

    <style>
        /* شريط مسطّح بالكامل: لون خلفية واحد ثابت، بدون تدرج وبدون ظل وبدون أيقونات */
        .impersonation-banner {
            position: sticky;
            top: 0;
            z-index: 1040;
            background: #334155;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            padding: 10px 18px;
            font-family: 'Cairo', sans-serif;
            font-size: .85rem;
            font-weight: 600;
            flex-wrap: wrap;
            text-align: center;
        }
        .impersonation-form { margin: 0; }
        .impersonation-leave-link {
            background: #059669;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 6px 14px;
            font-family: 'Cairo', sans-serif;
            font-size: .8rem;
            font-weight: 700;
            cursor: pointer;
        }
        .impersonation-leave-link:hover { background: #047857; }
    </style>
@endif
