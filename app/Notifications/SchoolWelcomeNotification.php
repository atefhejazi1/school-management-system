<?php

namespace App\Notifications;

use App\Models\School;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * إشعار يُرسل لمدير المدرسة الجديد بعد قبول طلب التسجيل مباشرة،
 * ويحتوي على بيانات تسجيل الدخول المؤقتة (البريد الإلكتروني وكلمة المرور).
 *
 * يُرسل بشكل متزامن (Sync) وليس عبر طابور المهام (Queue)، تماشياً مع باقي
 * رسائل البريد الحالية في النظام (RegistrationApproved, RegistrationReceived)
 * التي لا تعتمد على عامل طابور (queue:work) قد لا يكون مُشغّلاً في كل البيئات.
 */
class SchoolWelcomeNotification extends Notification
{
    public function __construct(
        public School $school,
        public string $temporaryPassword,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('تم تفعيل حساب مدرستكم على المنصة 🎉')
            ->greeting('مرحباً ' . $notifiable->name)
            ->line('تمت الموافقة على طلب تسجيل مدرسة "' . $this->school->name . '" وتم تفعيل حسابكم بنجاح.')
            ->line('فيما يلي بيانات تسجيل الدخول الخاصة بحساب مدير المدرسة:')
            ->line('**البريد الإلكتروني:** ' . $notifiable->email)
            ->line('**كلمة المرور المؤقتة:** ' . $this->temporaryPassword)
            ->action('تسجيل الدخول إلى لوحة التحكم', url('/login/web'))
            ->line('لأسباب أمنية، يُرجى تغيير كلمة المرور فور تسجيل الدخول لأول مرة.')
            ->salutation('مع تحيات فريق المنصة');
    }
}
