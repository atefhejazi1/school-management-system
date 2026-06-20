<div>

    {{-- ── Page Header ── --}}
    <div class="ph-wrap">
        <div class="ph-title-group">
            <div class="ph-icon-wrap"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <h1 class="ph-title">{{ __('super_dash.school_requests') }}</h1>
                <p class="ph-subtitle">{{ trans('super_dash.total_results_label') }}: {{ $registrations->total() }}</p>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         لوحة بيانات الاعتماد — تظهر مرة واحدة فقط فوراً بعد الموافقة على طلب
         (بدلاً من إجبار المسؤول على فتح سجلّ البريد الإلكتروني للحصول عليها)
    ══════════════════════════════════════════════════════════ --}}
    @if ($justApprovedId)
        <div class="admin-card mb-3" style="border:1px solid #059669;">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-start mb-3 gap-3">
                    <div>
                        <h5 class="mb-1" style="color:#047857; font-weight:700; font-size:1rem;">
                            {{ trans('super_dash.school_account_activated_success', ['name' => $justApprovedSchoolName]) }}
                        </h5>
                        <p class="mb-0 text-muted" style="font-size:.82rem;">
                            {{ trans('super_dash.one_time_credentials_hint') }}
                        </p>
                    </div>
                    <button type="button" wire:click="dismissApprovedCredentials" class="btn btn-sm btn-outline-secondary">
                        {{ trans('super_dash.close_btn') }}
                    </button>
                </div>

                <div class="cred-list mb-3">
                    <div class="cred-row d-flex justify-content-between align-items-center gap-3">
                        <div>
                            <div class="text-muted" style="font-size:.72rem;">{{ trans('super_dash.email_address_label') }}</div>
                            <div id="justApprovedEmailText" class="fw-semibold" dir="ltr" style="font-size:.92rem; color:#0f172a;">
                                {{ $justApprovedEmail }}
                            </div>
                        </div>
                        <button type="button" class="lp-copy-btn" onclick="copyCredentialField('justApprovedEmailText', '{{ trans('super_dash.email_address_label') }}')">
                            {{ trans('super_dash.copy_btn') }}
                        </button>
                    </div>
                    <div class="cred-row d-flex justify-content-between align-items-center gap-3">
                        <div>
                            <div class="text-muted" style="font-size:.72rem;">{{ trans('super_dash.password_label') }}</div>
                            <div id="justApprovedPasswordText" class="fw-semibold" dir="ltr" style="font-size:.92rem; color:#0f172a;">
                                {{ $justApprovedPassword }}
                            </div>
                        </div>
                        <button type="button" class="lp-copy-btn" onclick="copyCredentialField('justApprovedPasswordText', '{{ trans('super_dash.password_label') }}')">
                            {{ trans('super_dash.copy_btn') }}
                        </button>
                    </div>
                    <div class="cred-row d-flex justify-content-between align-items-center gap-3">
                        <div>
                            <div class="text-muted" style="font-size:.72rem;">{{ trans('super_dash.unified_login_portal_url') }}</div>
                            <div id="justApprovedLoginUrlText" class="fw-semibold" dir="ltr" style="font-size:.92rem; color:#0f172a;">
                                {{ $this->justApprovedLoginUrl() }}
                            </div>
                        </div>
                        <button type="button" class="lp-copy-btn" onclick="copyCredentialField('justApprovedLoginUrlText', '{{ trans('super_dash.login_url_label') }}')">
                            {{ trans('super_dash.copy_btn') }}
                        </button>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-4">
                    <button type="button" class="lp-text-link" onclick="copyApprovedLoginInfo()">
                        {{ trans('super_dash.copy_all_data') }}
                    </button>

                    @if ($this->justApprovedWhatsappUrl())
                        <a href="{{ $this->justApprovedWhatsappUrl() }}" target="_blank" rel="noopener" class="lp-text-link">
                            {{ trans('super_dash.send_via_whatsapp') }}
                        </a>
                    @else
                        <span class="text-muted" style="font-size:.85rem;">
                            {{ trans('super_dash.no_phone_for_whatsapp') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <script>
            function copyCredentialField(elementId, label) {
                const value = document.getElementById(elementId)?.innerText.trim();

                if (!value) {
                    return;
                }

                navigator.clipboard.writeText(value).then(function () {
                    if (window.showToast) {
                        window.showToast('success', @js(trans('super_dash.copied_field_to_clipboard')) + label + @js(trans('super_dash.to_clipboard_suffix')));
                    }
                });
            }

            function copyApprovedLoginInfo() {
                const email    = document.getElementById('justApprovedEmailText')?.innerText.trim();
                const password = document.getElementById('justApprovedPasswordText')?.innerText.trim();
                const loginUrl = document.getElementById('justApprovedLoginUrlText')?.innerText.trim();

                if (!email || !password || !loginUrl) {
                    return;
                }

                const text = @js(trans('super_dash.email_address_label')) + ': ' + email
                    + '\n' + @js(trans('super_dash.password_label')) + ': ' + password
                    + '\n' + @js(trans('super_dash.login_url_label')) + ': ' + loginUrl;

                navigator.clipboard.writeText(text).then(function () {
                    if (window.showToast) {
                        window.showToast('success', @js(trans('super_dash.login_credentials_copied')));
                    }
                });
            }
        </script>

        <style>
            .cred-row {
                padding: 10px 2px;
                border-bottom: 1px solid #f1f5f9;
            }
            .cred-row:last-child {
                border-bottom: none;
            }
            .lp-copy-btn {
                background: #f0fdf4;
                border: 1px solid #bbf7d0;
                color: #059669;
                font-family: 'Cairo', sans-serif;
                font-size: .78rem;
                font-weight: 700;
                padding: 6px 16px;
                border-radius: 8px;
                cursor: pointer;
                white-space: nowrap;
                flex-shrink: 0;
            }
            .lp-copy-btn:hover {
                background: #dcfce7;
            }
            .lp-text-link {
                background: none;
                border: none;
                padding: 0;
                font-family: 'Cairo', sans-serif;
                font-size: .85rem;
                font-weight: 700;
                color: #059669;
                text-decoration: underline;
                cursor: pointer;
            }
            .lp-text-link:hover { color: #047857; }
        </style>
    @endif

    {{-- ── Filters ── --}}
    <div class="admin-card mb-3">
        <div class="admin-card-header" style="border-bottom:none;">
            <div class="row g-3 w-100 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white" style="border-color:#e2e8f0; border-inline-end:none; border-radius:10px 0 0 10px;">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text"
                               wire:model.live.debounce.350ms="search"
                               class="form-control"
                               style="border-inline-start:none; border-radius:0 10px 10px 0;"
                               placeholder="{{ __('super_dash.search_placeholder') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="">{{ trans('super_dash.all_statuses') }}</option>
                        <option value="pending">{{ trans('super_dash.status_pending') }}</option>
                        <option value="approved">{{ trans('super_dash.status_approved') }}</option>
                        <option value="rejected">{{ trans('super_dash.status_rejected') }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Table ── --}}
    <div class="admin-card">
        @if ($registrations->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox" style="font-size:2.6rem; color:#cbd5e1;"></i>
                <p class="text-muted mt-3 mb-0">{{ trans('super_dash.no_matching_results') }}</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table admin-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('super_dash.school_name_th') }}</th>
                            <th>{{ trans('super_dash.contact_person_th') }}</th>
                            <th>{{ trans('super_dash.email_address_label') }}</th>
                            <th>{{ trans('super_dash.city_th') }}</th>
                            <th>{{ trans('super_dash.student_count_th') }}</th>
                            <th>{{ trans('super_dash.request_status_th') }}</th>
                            <th>{{ trans('super_dash.school_status_th') }}</th>
                            <th>{{ trans('super_dash.date_th') }}</th>
                            <th>{{ __('super_dash.confirm_btn') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registrations as $reg)
                            <tr wire:key="reg-{{ $reg->id }}">
                                <td class="text-muted" style="font-size:.8rem;">{{ $reg->id }}</td>
                                <td><span class="fw-semibold" style="color:#0f172a;">{{ $reg->school_name }}</span></td>
                                <td>{{ $reg->contact_name }}</td>
                                <td><span dir="ltr" style="font-size:.85rem;">{{ $reg->email }}</span></td>
                                <td>{{ $reg->city }}</td>
                                <td>
                                    <span class="pill" style="background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe;">
                                        {{ $reg->studentCountLabel() }}
                                    </span>
                                </td>
                                <td>
                                    @if ($reg->status === 'pending')
                                        <span class="pill pill-warning"><i class="fas fa-clock"></i> {{ trans('super_dash.status_pending') }}</span>
                                    @elseif ($reg->status === 'approved')
                                        <span class="pill pill-success"><i class="fas fa-check"></i> {{ trans('super_dash.status_approved') }}</span>
                                    @else
                                        <span class="pill pill-danger"><i class="fas fa-xmark"></i> {{ trans('super_dash.status_rejected') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($reg->school)
                                        @if ($reg->school->isActive())
                                            <span class="pill pill-success"><i class="fas fa-circle-check"></i> {{ trans('super_dash.school_status_active') }}</span>
                                        @else
                                            <span class="pill pill-danger"><i class="fas fa-ban"></i> {{ trans('super_dash.school_status_suspended') }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted" style="font-size:.78rem;">—</span>
                                    @endif
                                </td>
                                <td><span style="font-size:.8rem; color:#94a3b8;">{{ $reg->created_at->format('Y/m/d') }}</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button"
                                                class="btn btn-sm"
                                                style="background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; border-radius:8px;"
                                                title="{{ trans('super_dash.details_title') }}"
                                                wire:click="openDetails({{ $reg->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if ($reg->status === 'pending')
                                            <button type="button"
                                                    class="btn btn-sm btn-emerald"
                                                    title="{{ trans('super_dash.approve_title') }}"
                                                    wire:click="$dispatch('confirm-action', [{
                                                        title:       '{{ trans('super_dash.approve_registration_title') }}',
                                                        message:     '{{ trans('super_dash.approve_registration_message', ['name' => addslashes($reg->school_name)]) }}',
                                                        sub:         '{{ trans('super_dash.approve_registration_sub') }}',
                                                        event:       'doApproveSchool',
                                                        params:      { id: {{ $reg->id }} },
                                                        type:        'default',
                                                        confirmLabel:'{{ __('super_dash.confirm_btn') }}',
                                                        componentId: '{{ $this->getId() }}'
                                                    }])">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button"
                                                    class="btn btn-sm btn-emerald-outline"
                                                    title="{{ trans('super_dash.reject_title') }}"
                                                    wire:click="openReject({{ $reg->id }})">
                                                <i class="fas fa-xmark"></i>
                                            </button>
                                        @elseif ($reg->school)
                                            <button type="button"
                                                    class="btn btn-sm btn-emerald-outline"
                                                    title="{{ trans('super_dash.login_credentials_title') }}"
                                                    wire:click="$dispatch('confirm-action', [{
                                                        title:       '{{ trans('super_dash.reset_admin_password_title') }}',
                                                        message:     '{{ trans('super_dash.reset_admin_password_message', ['name' => addslashes($reg->school_name)]) }}',
                                                        sub:         '{{ trans('super_dash.reset_admin_password_sub') }}',
                                                        event:       'doResetAdminPassword',
                                                        params:      { registrationId: {{ $reg->id }} },
                                                        type:        'default',
                                                        confirmLabel:'{{ __('super_dash.confirm_btn') }}',
                                                        componentId: '{{ $this->getId() }}'
                                                    }])">
                                                <i class="fas fa-key"></i>
                                            </button>
                                            <a href="{{ route('super-admin.plan-selection.index', $reg->school->id) }}"
                                               class="btn btn-sm btn-emerald-outline"
                                               title="{{ trans('super_dash.renew_subscription_title') }}">
                                                <i class="fas fa-rotate"></i>
                                            </a>
                                            @if ($adminUserId = $reg->school->users()->value('id'))
                                                <form method="POST" action="{{ route('super-admin.impersonate', $adminUserId) }}" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-emerald-outline" title="{{ trans('super_dash.preview_school_dashboard_title') }}">
                                                        <i class="fas fa-user-secret"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if ($reg->school->isActive())
                                                <button type="button"
                                                        class="btn btn-sm"
                                                        style="background:#fff1f2; color:#be123c; border:1px solid #fecdd3; border-radius:8px;"
                                                        title="{{ trans('super_dash.suspend_title') }}"
                                                        wire:click="$dispatch('confirm-action', [{
                                                            title:       '{{ trans('super_dash.suspend_school_access_title') }}',
                                                            message:     '{{ trans('super_dash.suspend_school_access_message', ['name' => addslashes($reg->school_name)]) }}',
                                                            sub:         '{{ trans('super_dash.suspend_school_access_sub') }}',
                                                            event:       'doSuspendSchool',
                                                            params:      { registrationId: {{ $reg->id }} },
                                                            type:        'warning',
                                                            confirmLabel:'{{ __('super_dash.confirm_btn') }}',
                                                            componentId: '{{ $this->getId() }}'
                                                        }])">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @else
                                                <button type="button"
                                                        class="btn btn-sm btn-emerald-outline"
                                                        title="{{ trans('super_dash.reactivate_title') }}"
                                                        wire:click="$dispatch('confirm-action', [{
                                                            title:       '{{ trans('super_dash.reactivate_school_title') }}',
                                                            message:     '{{ trans('super_dash.reactivate_school_message', ['name' => addslashes($reg->school_name)]) }}',
                                                            event:       'doActivateSchool',
                                                            params:      { registrationId: {{ $reg->id }} },
                                                            type:        'default',
                                                            confirmLabel:'{{ __('super_dash.confirm_btn') }}',
                                                            componentId: '{{ $this->getId() }}'
                                                        }])">
                                                    <i class="fas fa-rotate-left"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-3 py-3 border-top" style="border-color:#f1f5f9 !important;">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>

    @if ($showRejectModal)
        <div class="pf-reject-backdrop" wire:click.self="$set('showRejectModal', false)">
            <div class="pf-reject-modal">
                <div class="pf-reject-header">
                    <h5 class="mb-0 fw-bold" style="color:#b91c1c;">
                        <i class="fas fa-xmark-circle me-2"></i> {{ trans('super_dash.reject_registration_title') }}
                    </h5>
                    <button wire:click="$set('showRejectModal', false)" class="pf-reject-close">&times;</button>
                </div>
                <div class="pf-reject-body">
                    <label class="form-label fw-semibold">{{ trans('super_dash.rejection_reason_label') }} <span class="text-danger">*</span></label>
                    <textarea wire:model="rejectReason"
                              class="form-control @error('rejectReason') is-invalid @enderror"
                              rows="3"
                              placeholder="{{ trans('super_dash.rejection_reason_placeholder') }}"></textarea>
                    @error('rejectReason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="pf-reject-footer">
                    <button wire:click="$set('showRejectModal', false)" class="btn btn-outline-secondary">
                        {{ __('super_dash.cancel') }}
                    </button>
                    <button wire:click="confirmReject" class="btn btn-danger px-4" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="confirmReject">
                            <i class="fas fa-xmark me-1"></i> {{ trans('super_dash.confirm_rejection') }}
                        </span>
                        <span wire:loading wire:target="confirmReject">{{ trans('super_dash.processing_dots') }}</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($showDetailsModal && $detailsRecord)
        <div class="pf-reject-backdrop" wire:click.self="closeDetails">
            <div class="pf-reject-modal pf-details-modal">
                <div class="pf-reject-header">
                    <h5 class="mb-0 fw-bold" style="color:#0f172a;">
                        {{ trans('super_dash.registration_details_for', ['name' => $detailsRecord->school_name]) }}
                    </h5>
                    <button wire:click="closeDetails" class="pf-reject-close">&times;</button>
                </div>
                <div class="pf-reject-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="pf-detail-item">
                                <span class="pf-detail-label">{{ trans('super_dash.school_name_th') }}</span>
                                <span class="pf-detail-value">{{ $detailsRecord->school_name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pf-detail-item">
                                <span class="pf-detail-label">{{ trans('super_dash.contact_person_name_label') }}</span>
                                <span class="pf-detail-value">{{ $detailsRecord->contact_name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pf-detail-item">
                                <span class="pf-detail-label">{{ trans('super_dash.email_address_label') }}</span>
                                <span class="pf-detail-value" dir="ltr">{{ $detailsRecord->email }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pf-detail-item">
                                <span class="pf-detail-label">{{ trans('super_dash.phone_number_label') }}</span>
                                <span class="pf-detail-value" dir="ltr">{{ $detailsRecord->phone ?: trans('super_dash.not_registered') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pf-detail-item">
                                <span class="pf-detail-label">{{ trans('super_dash.city_th') }}</span>
                                <span class="pf-detail-value">{{ $detailsRecord->city ?: trans('super_dash.not_registered_fem') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pf-detail-item">
                                <span class="pf-detail-label">{{ trans('super_dash.student_count_th') }}</span>
                                <span class="pf-detail-value">{{ $detailsRecord->studentCountLabel() }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pf-detail-item">
                                <span class="pf-detail-label">{{ trans('super_dash.request_status_th') }}</span>
                                <span class="pf-detail-value">{{ $detailsRecord->statusLabel() }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pf-detail-item">
                                <span class="pf-detail-label">{{ trans('super_dash.request_date_label') }}</span>
                                <span class="pf-detail-value">{{ $detailsRecord->created_at->format('Y/m/d H:i') }}</span>
                            </div>
                        </div>
                        @if ($detailsRecord->school)
                            <div class="col-md-6">
                                <div class="pf-detail-item">
                                    <span class="pf-detail-label">{{ trans('super_dash.school_platform_status_label') }}</span>
                                    <span class="pf-detail-value">{{ $detailsRecord->school->isActive() ? trans('super_dash.school_status_active') : trans('super_dash.school_status_suspended') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="pf-detail-item">
                                    <span class="pf-detail-label">{{ trans('super_dash.school_slug_label') }}</span>
                                    <span class="pf-detail-value" dir="ltr">{{ $detailsRecord->school->slug }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="pf-detail-item">
                                    <span class="pf-detail-label">{{ trans('super_dash.current_subscription_plan_label') }}</span>
                                    <span class="pf-detail-value">{{ $detailsRecord->school->plan?->name ?? trans('super_dash.no_plan_specified') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="pf-detail-item">
                                    <span class="pf-detail-label">{{ trans('super_dash.subscription_expiry_date_label') }}</span>
                                    @if ($detailsRecord->school->subscription_expires_at)
                                        <span class="pf-detail-value" style="{{ $detailsRecord->school->isSubscriptionExpired() ? 'color:#b91c1c;' : '' }}">
                                            {{ $detailsRecord->school->subscription_expires_at->format('Y/m/d') }}
                                            {{ $detailsRecord->school->isSubscriptionExpired() ? trans('super_dash.expired_paren') : '' }}
                                        </span>
                                    @else
                                        <span class="pf-detail-value">{{ trans('super_dash.not_specified') }}</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if ($detailsRecord->message)
                            <div class="col-12">
                                <div class="pf-detail-item">
                                    <span class="pf-detail-label">{{ trans('super_dash.applicant_message_label') }}</span>
                                    <span class="pf-detail-value">{{ $detailsRecord->message }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($detailsRecord->admin_notes)
                            <div class="col-12">
                                <div class="pf-detail-item" style="background:#fff5f5; border-color:#fecaca;">
                                    <span class="pf-detail-label" style="color:#b91c1c;">{{ trans('super_dash.admin_notes_rejection_reason_label') }}</span>
                                    <span class="pf-detail-value">{{ $detailsRecord->admin_notes }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="pf-reject-footer">
                    <button wire:click="closeDetails" class="btn btn-outline-secondary">{{ trans('super_dash.close_btn') }}</button>
                </div>
            </div>
        </div>
    @endif

    <style>
        .pf-reject-backdrop { position: fixed; inset: 0; background: rgba(15,23,42,.55); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 20px; backdrop-filter: blur(3px); }
        .pf-reject-modal { background: white; border-radius: 18px; width: 100%; max-width: 460px; box-shadow: 0 25px 80px rgba(0,0,0,.25); overflow: hidden; }
        .pf-details-modal { max-width: 720px; }
        .pf-reject-header { display: flex; align-items: center; justify-content: space-between; padding: 18px 22px 14px; border-bottom: 1px solid #f1f5f9; }
        .pf-reject-body { padding: 18px 22px; }
        .pf-reject-footer { display: flex; justify-content: flex-end; gap: 10px; padding: 14px 22px; border-top: 1px solid #f1f5f9; background: #f9fafb; }
        .pf-reject-close { background: none; border: none; font-size: 1.3rem; color: #94a3b8; cursor: pointer; line-height: 1; }
        .pf-reject-close:hover { color: #475569; }
        .pf-detail-item { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; display: block; }
        .pf-detail-label { display: block; font-size: .75rem; color: #94a3b8; font-weight: 600; margin-bottom: 4px; }
        .pf-detail-value { font-size: .9rem; color: #0f172a; font-weight: 600; }
    </style>

</div>
