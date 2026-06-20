<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans('Emails_trans.registration_received_title') }}</title>
    <style>
        body { margin: 0; padding: 0; background: #f1f5f9; font-family: Arial, sans-serif; direction: rtl; }
        .wrapper { max-width: 600px; margin: 40px auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
        .header { background: linear-gradient(135deg, #0f172a, #1e3a8a); padding: 40px 36px; text-align: center; }
        .header-icon { font-size: 3rem; margin-bottom: 12px; }
        .header-title { color: white; font-size: 1.4rem; font-weight: bold; margin: 0; }
        .header-sub { color: rgba(255,255,255,.6); font-size: .88rem; margin-top: 6px; }
        .body { padding: 36px; }
        .greeting { font-size: 1.05rem; color: #1e293b; margin-bottom: 20px; }
        .info-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; }
        .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size: .9rem; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #64748b; }
        .info-value { color: #1e293b; font-weight: bold; }
        .notice { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 16px 20px; color: #1e40af; font-size: .9rem; line-height: 1.6; }
        .notice strong { color: #1d4ed8; }
        .footer { background: #f8fafc; padding: 24px 36px; text-align: center; border-top: 1px solid #e2e8f0; }
        .footer-text { font-size: .8rem; color: #94a3b8; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="header-icon">✅</div>
        <h1 class="header-title">{{ trans('Emails_trans.registration_received_header') }}</h1>
        <p class="header-sub">{{ trans('Emails_trans.registration_received_subheader') }}</p>
    </div>

    <div class="body">
        <p class="greeting">
            {{ trans('Emails_trans.registration_received_greeting', ['name' => $registration->contact_name]) }}
        </p>
        <p style="color:#475569; font-size:.92rem; line-height:1.7;">
            {{ trans('Emails_trans.registration_received_thanks', ['schoolName' => $registration->school_name]) }}
        </p>

        <div class="info-box">
            <div class="info-row">
                <span class="info-label">{{ trans('Emails_trans.school_name_label') }}</span>
                <span class="info-value">{{ $registration->school_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">{{ trans('Emails_trans.contact_person_label') }}</span>
                <span class="info-value">{{ $registration->contact_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">{{ trans('Emails_trans.email_label') }}</span>
                <span class="info-value" dir="ltr">{{ $registration->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">{{ trans('Emails_trans.city_label') }}</span>
                <span class="info-value">{{ $registration->city }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">{{ trans('Emails_trans.request_number_label') }}</span>
                <span class="info-value">#{{ $registration->id }}</span>
            </div>
        </div>

        <div class="notice">
            <strong>⏰ {{ trans('Emails_trans.whats_next_title') }}</strong><br><br>
            {!! trans('Emails_trans.registration_received_notice') !!}
        </div>
    </div>

    <div class="footer">
        <p class="footer-text">{{ trans('Emails_trans.registration_received_footer_auto') }}</p>
        <p class="footer-text">© {{ date('Y') }} {{ trans('Emails_trans.registration_received_footer_copyright') }}</p>
    </div>
</div>
</body>
</html>
