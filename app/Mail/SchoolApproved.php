<?php

namespace App\Mail;

use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * بريد ترحيب يُرسل لمدير المدرسة فور الموافقة على طلب التسجيل، ويحتوي على
 * رابط البوابة الموحدة لتسجيل الدخول (نفس الرابط لكل المستخدمين) بالإضافة
 * إلى البريد الإلكتروني وكلمة المرور المؤقتة التي تم توليدها تلقائياً.
 */
class SchoolApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public School $school,
        public string $email,
        public string $temporaryPassword,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'تمت الموافقة على طلب تسجيل مدرستكم — بيانات الدخول',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.school_approved',
            with: [
                'schoolName'  => $this->school->name,
                'loginUrl'    => route('login'),
                'email'       => $this->email,
                'password'    => $this->temporaryPassword,
            ],
        );
    }
}
