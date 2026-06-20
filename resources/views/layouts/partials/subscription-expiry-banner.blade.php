{{-- ══════════════════════════════════════════
     شريط تنبيه اقتراب انتهاء اشتراك المدرسة (Subscription Expiry Warning Banner)
     يظهر فقط لمدير المدرسة (حارس "web" الافتراضي) المنتمي فعلياً لمدرسة
     (auth()->user()->school_id غير NULL)، وفقط إذا كان الاشتراك لا يزال سارياً
     لكنه على وشك الانتهاء خلال 7 أيام أو أقل. اشتراك منتهٍ بالفعل لا يظهر هنا
     لأنه يُعالَج عبر صفحة الخطأ 403 (انظر resources/views/errors/403.blade.php).
══════════════════════════════════════════ --}}
@php
    $expiryWarningDaysLeft = null;

    if (auth()->check() && ! is_null(auth()->user()->school_id) && auth()->user()->school) {
        $subscriptionExpiresAt = auth()->user()->school->subscription_expires_at;

        // isFuture() يضمن أن الاشتراك "لا يزال سارياً" وليس منتهياً بالفعل
        if ($subscriptionExpiresAt && $subscriptionExpiresAt->isFuture()) {
            // diffInDays بين تاريخين تُعيد دائماً فرقاً موجباً (absolute) هنا لأن
            // التاريخ مستقبلي، وتُقرَّب لأسفل (مثلاً 6 ساعات متبقية = 0 يوم)؛
            // وهو سلوك مقصود: العدّاد يعكس "أيام كاملة متبقية" فقط
            $expiryWarningDaysLeft = (int) now()->diffInDays($subscriptionExpiresAt);
        }
    }
@endphp

@if (! is_null($expiryWarningDaysLeft) && $expiryWarningDaysLeft <= 7)
    <div class="expiry-warning-banner" role="alert">
        {{ trans('Errors_trans.subscription_expiry_warning', ['days' => $expiryWarningDaysLeft]) }}
    </div>

    <style>
        /* شريط مسطّح بالكامل: لون خلفية تحذيري واحد ثابت، بدون تدرج، بدون ظل، بدون أيقونات، بدون حواف دائرية */
        .expiry-warning-banner {
            position: sticky;
            top: 0;
            z-index: 1041;
            background: #fffbeb;
            color: #92400e;
            text-align: center;
            padding: 9px 18px;
            font-family: 'Cairo', sans-serif;
            font-size: .82rem;
            font-weight: 700;
            border-bottom: 1px solid #fde68a;
            border-radius: 0;
        }
    </style>
@endif
