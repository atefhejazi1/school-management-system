@extends('layouts.super-admin.master')

@section('title', 'اختيار باقة الاشتراك')

@section('PageTitle', 'اختيار باقة الاشتراك')

@section('content')

    <div class="ph-wrap">
        <div class="ph-title-group">
            <div>
                <h1 class="ph-title">تفعيل / تجديد باقة الاشتراك</h1>
                <p class="ph-subtitle">مدرسة "{{ $school->name }}"</p>
            </div>
        </div>
        <div class="ph-actions">
            <a href="{{ route('super-admin.school-requests.index') }}" class="btn-flat-outline">رجوع إلى طلبات المدارس</a>
        </div>
    </div>

    @if ($school->plan)
        <div class="admin-card mb-4 flat-card">
            <div class="p-4">
                <span class="pill pill-info">الباقة الحالية: {{ $school->plan->name }}</span>
                @if ($school->subscription_expires_at)
                    <span class="pill {{ $school->isSubscriptionExpired() ? 'pill-danger' : 'pill-success' }}">
                        ينتهي الاشتراك في {{ $school->subscription_expires_at->format('Y/m/d') }}
                        {{ $school->isSubscriptionExpired() ? '(منتهي)' : '' }}
                    </span>
                @endif
            </div>
        </div>
    @endif

    @if ($plans->isEmpty())
        <div class="admin-card flat-card">
            <div class="p-5 text-center">
                <p class="text-muted mb-0">لا توجد باقات نشطة متاحة حالياً. يرجى إضافة باقة من قاعدة البيانات أولاً.</p>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach ($plans as $plan)
                <div class="col-md-4">
                    <div class="pricing-card {{ $school->plan_id === $plan->id ? 'pricing-card-current' : '' }}">
                        @if ($school->plan_id === $plan->id)
                            <span class="pricing-current-badge">الباقة الحالية</span>
                        @endif

                        <h3 class="pricing-name">{{ $plan->name }}</h3>

                        <div class="pricing-price">
                            {{ number_format((float) $plan->price, 2) }}
                            <span class="pricing-price-unit">/ شهرياً</span>
                        </div>

                        <div class="pricing-feature">
                            <span class="pricing-feature-label">الحد الأقصى للطلاب</span>
                            <span class="pricing-feature-value">{{ $plan->max_students }} طالب</span>
                        </div>

                        <form method="POST" action="{{ route('super-admin.plan-selection.store', $school->id) }}" class="pricing-form">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">

                            <label class="pricing-months-label" for="months-{{ $plan->id }}">عدد أشهر التجديد</label>
                            <input type="number"
                                   id="months-{{ $plan->id }}"
                                   name="months"
                                   value="1"
                                   min="1"
                                   max="36"
                                   class="form-control pricing-months-input"
                                   required>

                            <button type="submit" class="btn-flat-emerald w-100">تفعيل هذه الباقة</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <style>
        /* بطاقات تسعير مسطّحة بالكامل: بدون تدرجات لونية، بدون ظلال، بدون أيقونات */
        .flat-card { box-shadow: none !important; }

        .pricing-card {
            position: relative;
            background: #ffffff;
            border: 1px solid var(--border, #e2e8f0);
            border-radius: 14px;
            padding: 28px 24px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .pricing-card-current { border: 2px solid var(--em-600, #059669); }
        .pricing-current-badge {
            position: absolute;
            top: 16px;
            inset-inline-end: 16px;
            background: var(--em-50, #ecfdf5);
            color: var(--em-700, #047857);
            border: 1px solid var(--em-100, #d1fae5);
            font-size: .72rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 6px;
        }
        .pricing-name { font-size: 1.15rem; font-weight: 800; color: #334155; margin-bottom: 8px; }
        .pricing-price { font-size: 1.6rem; font-weight: 800; color: #059669; margin-bottom: 18px; }
        .pricing-price-unit { font-size: .8rem; font-weight: 600; color: #94a3b8; }
        .pricing-feature {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f1f5f9;
            padding: 12px 0;
            margin-bottom: 18px;
        }
        .pricing-feature-label { font-size: .85rem; color: #334155; font-weight: 600; }
        .pricing-feature-value { font-size: .9rem; color: #059669; font-weight: 800; }
        .pricing-form { margin-top: auto; display: flex; flex-direction: column; gap: 8px; }
        .pricing-months-label { font-size: .78rem; font-weight: 700; color: #334155; }
        .pricing-months-input { text-align: center; }

        /* أزرار مسطّحة: لون خلفية واحد ثابت، بدون تدرج وبدون ظل */
        .btn-flat-emerald {
            background: #059669;
            color: #ffffff;
            border: none;
            font-family: 'Cairo', sans-serif;
            font-weight: 700;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: .88rem;
        }
        .btn-flat-emerald:hover { background: #047857; color: #ffffff; }

        .btn-flat-outline {
            background: #ffffff;
            color: #334155;
            border: 1px solid var(--border, #e2e8f0);
            font-family: 'Cairo', sans-serif;
            font-weight: 700;
            border-radius: 8px;
            padding: 9px 16px;
            font-size: .85rem;
            text-decoration: none;
            display: inline-block;
        }
        .btn-flat-outline:hover { background: #f8fafc; color: #334155; }
    </style>

@endsection
