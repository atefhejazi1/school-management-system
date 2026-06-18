<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تمت الموافقة على طلب تسجيل مدرستكم</title>
    <style>
        body { margin: 0; padding: 0; background: #f1f5f9; font-family: Arial, sans-serif; direction: rtl; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border: 1px solid #e2e8f0; }
        .header { background: #ffffff; border-bottom: 2px solid #059669; padding: 28px 36px; }
        .header-title { color: #0f172a; font-size: 1.25rem; font-weight: bold; margin: 0; }
        .body { padding: 32px 36px; }
        .greeting { font-size: 1rem; color: #334155; margin-bottom: 18px; }
        .text { color: #334155; font-size: .92rem; line-height: 1.7; margin-bottom: 18px; }
        .credentials-box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px 24px; margin-bottom: 22px; }
        .cred-title { color: #64748b; font-size: .78rem; letter-spacing: .5px; text-transform: uppercase; margin-bottom: 14px; }
        .cred-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #e2e8f0; }
        .cred-row:last-child { border-bottom: none; }
        .cred-label { color: #64748b; font-size: .85rem; }
        .cred-value { color: #0f172a; font-weight: bold; font-size: .92rem; font-family: monospace; }
        .cta { text-align: center; margin-bottom: 22px; }
        .cta a { display: inline-block; background: #059669; color: #ffffff; text-decoration: none; font-weight: bold; font-size: .92rem; padding: 12px 32px; }
        .notice { border: 1px solid #e2e8f0; padding: 12px 16px; color: #334155; font-size: .85rem; line-height: 1.65; margin-bottom: 4px; }
        .footer { background: #f8fafc; padding: 20px 36px; text-align: center; border-top: 1px solid #e2e8f0; }
        .footer-text { font-size: .78rem; color: #94a3b8; margin: 0; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <p class="header-title">تمت الموافقة على طلب تسجيل مدرستكم</p>
    </div>

    <div class="body">
        <p class="greeting">مرحباً،</p>

        <p class="text">
            تمت الموافقة على طلب تسجيل مدرسة <strong>{{ $schoolName }}</strong> على المنصة، وتم تفعيل حساب مدير المدرسة بنجاح.
            فيما يلي بيانات الدخول الخاصة بكم عبر بوابة تسجيل الدخول الموحدة:
        </p>

        <div class="credentials-box">
            <div class="cred-title">بيانات الدخول</div>
            <div class="cred-row">
                <span class="cred-label">البريد الإلكتروني</span>
                <span class="cred-value" dir="ltr">{{ $email }}</span>
            </div>
            <div class="cred-row">
                <span class="cred-label">كلمة المرور المؤقتة</span>
                <span class="cred-value" dir="ltr">{{ $password }}</span>
            </div>
        </div>

        <div class="cta">
            <a href="{{ $loginUrl }}" dir="ltr">تسجيل الدخول إلى المنصة</a>
        </div>

        <div class="notice">
            لأسباب أمنية، يُرجى تغيير كلمة المرور المؤقتة فور تسجيل الدخول لأول مرة.
        </div>
    </div>

    <div class="footer">
        <p class="footer-text">© {{ date('Y') }} نظام إدارة المدارس</p>
    </div>
</div>
</body>
</html>
