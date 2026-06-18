<div>

    <div class="ph-wrap">
        <div class="ph-title-group">
            <div>
                <h1 class="ph-title">إعدادات المنصة العامة</h1>
                <p class="ph-subtitle">متغيرات عامة تخص المنصة بالكامل، مستقلة عن إعدادات أي مدرسة بعينها</p>
            </div>
        </div>
    </div>

    <form wire:submit="save">

        <div class="admin-card flat-card mb-4">
            <div class="admin-card-header" style="border-bottom:none;">
                <span class="admin-card-title">التسجيل العام</span>
            </div>
            <div class="p-4 pt-0">
                <label class="settings-toggle-row">
                    <input type="checkbox" wire:model="allowPublicRegistration" class="settings-toggle-input">
                    <span>السماح بظهور نموذج تسجيل المدارس في الصفحة الرئيسية العامة</span>
                </label>
                <p class="text-muted mt-2 mb-0" style="font-size:.8rem;">
                    عند إلغاء التفعيل، يظهر للزوار نص يطلب التواصل المباشر بدلاً من نموذج التسجيل.
                </p>
            </div>
        </div>

        <div class="admin-card flat-card mb-4">
            <div class="admin-card-header" style="border-bottom:none;">
                <span class="admin-card-title">قالب رسالة ترحيب واتساب</span>
            </div>
            <div class="p-4 pt-0">
                <p class="text-muted mb-2" style="font-size:.8rem;">
                    المتغيرات المتاحة لاستخدامها داخل القالب: {school_name} ، {email} ، {password} ، {login_url}
                </p>
                <textarea wire:model="whatsappWelcomeTemplate"
                          class="form-control @error('whatsappWelcomeTemplate') is-invalid @enderror"
                          rows="9" dir="rtl"></textarea>
                @error('whatsappWelcomeTemplate')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror

                <button type="button" wire:click="resetWhatsappTemplate" class="btn-flat-outline mt-3">
                    استعادة النص الافتراضي
                </button>
            </div>
        </div>

        <button type="submit" class="btn-flat-emerald" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="save">حفظ التغييرات</span>
            <span wire:loading wire:target="save">جاري الحفظ...</span>
        </button>

    </form>

    <style>
        .flat-card { box-shadow: none !important; }

        .settings-toggle-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .9rem;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
        }
        .settings-toggle-input {
            width: 18px;
            height: 18px;
            accent-color: #059669;
        }

        .btn-flat-emerald {
            background: #059669;
            color: #ffffff;
            border: none;
            font-family: 'Cairo', sans-serif;
            font-weight: 700;
            border-radius: 8px;
            padding: 10px 22px;
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
            padding: 8px 16px;
            font-size: .82rem;
        }
        .btn-flat-outline:hover { background: #f8fafc; color: #334155; }
    </style>

</div>
