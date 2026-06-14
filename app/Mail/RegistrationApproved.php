<?php

namespace App\Mail;

use App\Models\SchoolRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SchoolRegistration $registration,
        public string $password = ''
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'تمت الموافقة على طلب تسجيل مدرستكم 🎉',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-approved',
        );
    }
}
