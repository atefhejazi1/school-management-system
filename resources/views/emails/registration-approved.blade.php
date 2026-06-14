<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تمت الموافقة على طلبكم</title>
    <style>
        body { margin: 0; padding: 0; background: #f1f5f9; font-family: Arial, sans-serif; direction: rtl; }
        .wrapper { max-width: 600px; margin: 40px auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
        .header { background: linear-gradient(135deg, #064e3b, #059669, #34d399); padding: 40px 36px; text-align: center; }
        .header-icon { font-size: 3rem; margin-bottom: 12px; }
        .header-title { color: white; font-size: 1.5rem; font-weight: bold; margin: 0; }
        .header-sub { color: rgba(255,255,255,.75); font-size: .9rem; margin-top: 6px; }
        .body { padding: 36px; }
        .greeting { font-size: 1.05rem; color: #1e293b; margin-bottom: 20px; }
        .congrats-box { background: linear-gradient(135deg, #f0fdf4, #dcfce7); border: 1px solid #bbf7d0; border-radius: 14px; padding: 22px 26px; margin-bottom: 24px; text-align: center; }
        .congrats-icon { font-size: 2.5rem; margin-bottom: 10px; }
        .congrats-text { color: #15803d; font-size: 1rem; font-weight: bold; }
        .credentials-box { background: #0f172a; border-radius: 14px; padding: 24px 28px; margin-bottom: 24px; }
        .cred-title { color: rgba(255,255,255,.6); font-size: .8rem; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 16px; }
        .cred-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,.07); }
        .cred-row:last-child { border-bottom: none; }
        .cred-label { color: rgba(255,255,255,.5); font-size: .85rem; }
        .cred-value { color: #60a5fa; font-weight: bold; font-size: .95rem; font-family: monospace; }
        .warning-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 14px 18px; color: #92400e; font-size: .88rem; line-height: 1.65; margin-bottom: 20px; }
        .steps-box { margin-bottom: 24px; }
        .step { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 14px; }
        .step-num { width: 28px; height: 28px; border-radius: 50%; background: #eff6ff; color: #2563eb; font-weight: bold; font-size: .85rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .step-text { color: #475569; font-size: .9rem; line-height: 1.5; }
        .footer { background: #f8fafc; padding: 24px 36px; text-align: center; border-top: 1px solid #e2e8f0; }
        .footer-text { font-size: .8rem; color: #94a3b8; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="header-icon">🎉</div>
        <h1 class="header-title">تمت الموافقة على طلبكم!</h1>
        <p class="header-sub">مرحباً بكم في نظام إدارة المدارس</p>
    </div>

    <div class="body">
        <p class="greeting">
            مرحباً <strong>{{ $registration->contact_name }}</strong>،
        </p>

        <div class="congrats-box">
            <div class="congrats-icon">✅</div>
            <div class="congrats-text">
                تمت الموافقة على طلب مدرسة <strong>{{ $registration->school_name }}</strong>
            </div>
        </div>

        @if ($password)
        <p style="color:#475569; font-size:.92rem; line-height:1.7; margin-bottom:16px;">
            تم إنشاء حسابكم في النظام. فيما يلي بيانات الدخول الخاصة بكم:
        </p>

        <div class="credentials-box">
            <div class="cred-title">🔐 بيانات الدخول</div>
            <div class="cred-row">
                <span class="cred-label">البريد الإلكتروني</span>
                <span class="cred-value" dir="ltr">{{ $registration->email }}</span>
            </div>
            <div class="cred-row">
                <span class="cred-label">كلمة المرور المؤقتة</span>
                <span class="cred-value" dir="ltr">{{ $password }}</span>
            </div>
        </div>

        <div class="warning-box">
            ⚠️ <strong>مهم:</strong> يُرجى تغيير كلمة المرور فور تسجيل الدخول لأول مرة لضمان أمان حسابكم.
        </div>
        @else
        <p style="color:#475569; font-size:.92rem; line-height:1.7;">
            سيتواصل معكم فريقنا قريباً لإرسال بيانات الدخول وبدء إعداد النظام لمدرستكم.
        </p>
        @endif

        <div class="steps-box">
            <p style="font-weight:bold; color:#1e293b; margin-bottom:14px;">خطوات البدء:</p>
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-text">سجّل الدخول إلى النظام باستخدام البيانات أعلاه</div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-text">أضف بيانات مدرستك من قسم الإعدادات</div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-text">ابدأ بإضافة المعلمين والطلاب وإعداد الصفوف</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p class="footer-text">بحاجة إلى مساعدة؟ تواصل مع فريق الدعم عبر البريد الإلكتروني.</p>
        <p class="footer-text">© {{ date('Y') }} نظام إدارة المدارس — تطوير عاطف حجازي</p>
    </div>
</div>
</body>
</html>
