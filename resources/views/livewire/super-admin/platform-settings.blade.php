<div>

    <div class="ph-wrap">
        <div class="ph-title-group">
            <div>
                <h1 class="ph-title">{{ trans('super_dash.general_platform_settings_title') }}</h1>
                <p class="ph-subtitle">{{ trans('super_dash.general_platform_settings_subtitle') }}</p>
            </div>
        </div>
    </div>

    <form wire:submit="save">

        <div class="admin-card flat-card mb-4">
            <div class="admin-card-header" style="border-bottom:none;">
                <span class="admin-card-title">{{ trans('super_dash.public_registration_label') }}</span>
            </div>
            <div class="p-4 pt-0">
                <label class="settings-toggle-row">
                    <input type="checkbox" wire:model="allowPublicRegistration" class="settings-toggle-input">
                    <span>{{ trans('super_dash.allow_public_registration_form') }}</span>
                </label>
                <p class="text-muted mt-2 mb-0" style="font-size:.8rem;">
                    {{ trans('super_dash.public_registration_disabled_hint') }}
                </p>
            </div>
        </div>

        <div class="admin-card flat-card mb-4">
            <div class="admin-card-header" style="border-bottom:none;">
                <span class="admin-card-title">{{ trans('super_dash.whatsapp_welcome_template_title') }}</span>
            </div>
            <div class="p-4 pt-0">
                <p class="text-muted mb-2" style="font-size:.8rem;">
                    {{ trans('super_dash.whatsapp_template_variables_hint') }}
                </p>
                <textarea wire:model="whatsappWelcomeTemplate"
                          class="form-control @error('whatsappWelcomeTemplate') is-invalid @enderror"
                          rows="9" dir="rtl"></textarea>
                @error('whatsappWelcomeTemplate')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror

                <button type="button" wire:click="resetWhatsappTemplate" class="btn-flat-outline mt-3">
                    {{ trans('super_dash.restore_default_text') }}
                </button>
            </div>
        </div>

        <button type="submit" class="btn-flat-emerald" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="save">{{ trans('super_dash.save_changes_btn') }}</span>
            <span wire:loading wire:target="save">{{ trans('super_dash.saving_dots') }}</span>
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
