<?php

namespace App\Livewire\SuperAdmin;

use App\Models\PlatformSetting;
use Livewire\Component;

/**
 * إدارة متغيرات المنصة العامة (Global Platform Settings) — مستقلة تماماً عن إعدادات
 * أي مدرسة بعينها، ومتاحة فقط لمنشئ المنصة عبر middleware "role.redirect".
 */
class PlatformSettings extends Component
{
    public bool $allowPublicRegistration = true;

    public string $whatsappWelcomeTemplate = '';

    public function mount(): void
    {
        $this->allowPublicRegistration = PlatformSetting::get('allow_public_registration', '1') === '1';
        $this->whatsappWelcomeTemplate  = PlatformSetting::get('whatsapp_welcome_template', PlatformSetting::DEFAULT_WHATSAPP_TEMPLATE);
    }

    public function save(): void
    {
        $this->validate(
            ['whatsappWelcomeTemplate' => 'required|string|min:10'],
            [
                'whatsappWelcomeTemplate.required' => 'يرجى كتابة قالب رسالة الترحيب.',
                'whatsappWelcomeTemplate.min'       => 'القالب قصير جداً، يرجى كتابة رسالة كاملة.',
            ]
        );

        PlatformSetting::set('allow_public_registration', $this->allowPublicRegistration ? '1' : '0');
        PlatformSetting::set('whatsapp_welcome_template', $this->whatsappWelcomeTemplate);

        session()->flash('success', 'تم حفظ إعدادات المنصة بنجاح.');
    }

    /**
     * إعادة قالب رسالة واتساب إلى نصه الافتراضي دون حفظه فوراً؛ يحتاج المستخدم
     * لضغط "حفظ التغييرات" لتثبيت الإعادة إلى الافتراضي.
     */
    public function resetWhatsappTemplate(): void
    {
        $this->whatsappWelcomeTemplate = PlatformSetting::DEFAULT_WHATSAPP_TEMPLATE;
    }

    public function render()
    {
        return view('livewire.super-admin.platform-settings');
    }
}
