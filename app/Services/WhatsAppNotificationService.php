<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * طبقة وسيطة بين النظام وأي مزوّد خدمة واتساب (WhatsApp Business API). تبني نفس
 * شكل الحمولة (Payload) القياسي المستخدَم من مزوّدي WhatsApp Cloud API بصمت، وترسلها
 * فقط إذا كانت بيانات الاعتماد فعلياً مهيَّأة في .env (WHATSAPP_API_URL / WHATSAPP_API_TOKEN).
 *
 * في حال عدم تهيئة بيانات الاعتماد بعد (بيئة تطوير، أو قبل تفعيل حساب رسمي لدى المزوّد)،
 * نُسجِّل الرسالة في السجلّ (Log) بدلاً من تنفيذ استدعاء فعلي خارجي قد يفشل أو يُرسَل
 * برقم/توكن غير صحيحين، فيبقى تدفّق الكود نفسه (Controller/Repository) يعمل دون انقطاع
 * بمجرد ضبط بيانات الاعتماد الحقيقية لاحقاً.
 */
class WhatsAppNotificationService
{
    public function sendDynamicMessage(string $phoneNumber, string $messageText): bool
    {
        $apiUrl = config('services.whatsapp.api_url');
        $apiToken = config('services.whatsapp.api_token');

        // واتساب يتطلب رقم الهاتف بصيغة دولية وأرقام فقط (بدون +، 00، مسافات أو شرطات)
        $digitsOnly = preg_replace('/\D/', '', $phoneNumber);

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $digitsOnly,
            'type' => 'text',
            'text' => ['body' => $messageText],
        ];

        if (! $apiUrl || ! $apiToken) {
            Log::info('WhatsApp notification skipped (no API credentials configured)', $payload);
            return false;
        }

        $response = Http::withToken($apiToken)->post($apiUrl, $payload);

        if (! $response->successful()) {
            Log::warning('WhatsApp notification failed', [
                'payload' => $payload,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

        return $response->successful();
    }
}
