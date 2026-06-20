<div>
    @if ($submitted)
        {{-- ── Success State ── --}}
        <div class="reg-success text-center py-5">
            <div class="success-icon-wrap">
                <svg viewBox="0 0 52 52" class="checkmark" xmlns="http://www.w3.org/2000/svg">
                    <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark-check" fill="none" d="M14 27l8 8 16-16"/>
                </svg>
            </div>
            <h3 class="mt-4 fw-bold" style="color:#1e3a8a; font-size:1.6rem;">{{ trans('landing_trans.reg_success_title') }}</h3>
            <p class="text-muted mt-2" style="font-size:1.05rem;">{!! trans('landing_trans.reg_success_sub') !!}</p>
            <div class="mt-4 p-3 rounded-3" style="background:#f0f7ff; border:1px solid #bfdbfe; display:inline-block; min-width:260px;">
                <div class="text-muted" style="font-size:.85rem;">{{ trans('landing_trans.reg_success_email_label') }}</div>
                <div class="fw-bold" style="color:#1e3a8a;">{{ $email }}</div>
            </div>
        </div>

        <style>
            .checkmark { width: 72px; height: 72px; }
            .checkmark-circle { stroke: #22c55e; stroke-width: 2; stroke-dasharray: 166; stroke-dashoffset: 166; animation: stroke .6s cubic-bezier(.65,0,.45,1) forwards; }
            .checkmark-check { stroke: #22c55e; stroke-width: 3; stroke-linecap: round; stroke-linejoin: round; stroke-dasharray: 48; stroke-dashoffset: 48; animation: stroke .3s cubic-bezier(.65,0,.45,1) .8s forwards; }
            @keyframes stroke { 100% { stroke-dashoffset: 0; } }
        </style>
    @else
        {{-- ── Form ── --}}
        <form wire:submit.prevent="submit" novalidate>
            <div class="row g-4">

                {{-- School Name --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <span class="field-icon">🏫</span> <span>{{ trans('landing_trans.reg_label_school_name') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           wire:model.live.debounce.400ms="school_name"
                           class="form-control reg-input @error('school_name') is-invalid @enderror"
                           placeholder="{{ trans('landing_trans.reg_ph_school_name') }}">
                    @error('school_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Contact Name --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <span class="field-icon">👤</span> <span>{{ trans('landing_trans.reg_label_contact_name') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           wire:model.live.debounce.400ms="contact_name"
                           class="form-control reg-input @error('contact_name') is-invalid @enderror"
                           placeholder="{{ trans('landing_trans.reg_ph_contact_name') }}">
                    @error('contact_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <span class="field-icon">📧</span> <span>{{ trans('landing_trans.reg_label_email') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="email"
                           wire:model.live.debounce.600ms="email"
                           class="form-control reg-input @error('email') is-invalid @enderror"
                           placeholder="school@example.com"
                           dir="ltr">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <span class="field-icon">📱</span> <span>{{ trans('landing_trans.reg_label_phone') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           wire:model.live.debounce.400ms="phone"
                           class="form-control reg-input @error('phone') is-invalid @enderror"
                           placeholder="05xxxxxxxx"
                           dir="ltr">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- City --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <span class="field-icon">🏙️</span> <span>{{ trans('landing_trans.reg_label_city') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           wire:model.live.debounce.400ms="city"
                           class="form-control reg-input @error('city') is-invalid @enderror"
                           placeholder="{{ trans('landing_trans.reg_ph_city') }}">
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Student Count --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <span class="field-icon">🎓</span> <span>{{ trans('landing_trans.reg_label_student_count') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <select wire:model="student_count"
                            class="form-select reg-input @error('student_count') is-invalid @enderror">
                        <option value="">{{ trans('landing_trans.reg_opt_choose') }}</option>
                        <option value="less_100">{{ trans('landing_trans.reg_opt_less_100') }}</option>
                        <option value="100_300">{{ trans('landing_trans.reg_opt_100_300') }}</option>
                        <option value="more_300">{{ trans('landing_trans.reg_opt_more_300') }}</option>
                    </select>
                    @error('student_count')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Message --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">
                        <span class="field-icon">💬</span> <span>{{ trans('landing_trans.reg_label_message') }}</span>
                    </label>
                    <textarea wire:model="message"
                              class="form-control reg-input"
                              rows="3"
                              placeholder="{{ trans('landing_trans.reg_ph_message') }}"></textarea>
                </div>

                {{-- Terms --}}
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox"
                               wire:model="terms"
                               class="form-check-input @error('terms') is-invalid @enderror"
                               id="reg-terms">
                        <label class="form-check-label me-2" for="reg-terms" style="font-size:.95rem;">
                            {!! trans('landing_trans.reg_terms_text') !!}
                        </label>
                        @error('terms')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Submit --}}
                <div class="col-12 text-center pt-2">
                    <button type="submit"
                            class="btn btn-primary btn-lg px-5 py-3 reg-submit-btn"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="submit">
                            <i class="fas fa-paper-plane me-2"></i> <span>{{ trans('landing_trans.reg_submit_btn') }}</span>
                        </span>
                        <span wire:loading wire:target="submit">
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            <span>{{ trans('landing_trans.reg_submitting') }}</span>
                        </span>
                    </button>
                    <p class="mt-3 text-muted" style="font-size:.85rem;">
                        <i class="fas fa-shield-halved me-1" style="color:#22c55e;"></i>
                        <span>{{ trans('landing_trans.reg_secure_note') }}</span>
                    </p>
                </div>

            </div>
        </form>
    @endif
</div>
