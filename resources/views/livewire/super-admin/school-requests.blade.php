<div>

    {{-- ── Page Header ── --}}
    <div class="ph-wrap">
        <div class="ph-title-group">
            <div class="ph-icon-wrap"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <h1 class="ph-title">{{ __('super_dash.school_requests') }}</h1>
                <p class="ph-subtitle">إجمالي النتائج: {{ $registrations->total() }}</p>
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
                            تم تفعيل حساب مدرسة "{{ $justApprovedSchoolName }}" بنجاح
                        </h5>
                        <p class="mb-0 text-muted" style="font-size:.82rem;">
                            بيانات الدخول التالية مخصّصة لمرة واحدة، يُرجى نسخها أو إرسالها إلى مدير المدرسة الآن.
                        </p>
                    </div>
                    <button type="button" wire:click="dismissApprovedCredentials" class="btn btn-sm btn-outline-secondary">
                        إغلاق
                    </button>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="text-muted" style="font-size:.75rem;">البريد الإلكتروني</div>
                        <div id="justApprovedEmailText" class="fw-semibold" dir="ltr" style="font-size:.9rem; color:#0f172a;">
                            {{ $justApprovedEmail }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted" style="font-size:.75rem;">كلمة المرور المؤقتة</div>
                        <div id="justApprovedPasswordText" class="fw-semibold" dir="ltr" style="font-size:.9rem; color:#0f172a;">
                            {{ $justApprovedPassword }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted" style="font-size:.75rem;">رابط بوابة تسجيل الدخول الموحدة</div>
                        <div id="justApprovedLoginUrlText" class="fw-semibold" dir="ltr" style="font-size:.9rem; color:#0f172a;">
                            {{ $this->justApprovedLoginUrl() }}
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-4">
                    <button type="button" class="lp-text-link" onclick="copyApprovedLoginInfo()">
                        نسخ بيانات الدخول
                    </button>

                    @if ($this->justApprovedWhatsappUrl())
                        <a href="{{ $this->justApprovedWhatsappUrl() }}" target="_blank" rel="noopener" class="lp-text-link">
                            إرسال عبر واتساب
                        </a>
                    @else
                        <span class="text-muted" style="font-size:.85rem;">
                            لا يوجد رقم هاتف مسجَّل لإرسال الرسالة عبر واتساب
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <script>
            function copyApprovedLoginInfo() {
                const email    = document.getElementById('justApprovedEmailText')?.innerText.trim();
                const password = document.getElementById('justApprovedPasswordText')?.innerText.trim();
                const loginUrl = document.getElementById('justApprovedLoginUrlText')?.innerText.trim();

                if (!email || !password || !loginUrl) {
                    return;
                }

                const text = 'البريد الإلكتروني: ' + email
                    + '\nكلمة المرور: ' + password
                    + '\nرابط تسجيل الدخول: ' + loginUrl;

                navigator.clipboard.writeText(text).then(function () {
                    if (window.showToast) {
                        window.showToast('success', 'تم نسخ بيانات الدخول إلى الحافظة');
                    }
                });
            }
        </script>

        <style>
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
                        <option value="">كل الحالات</option>
                        <option value="pending">قيد المراجعة</option>
                        <option value="approved">مقبول</option>
                        <option value="rejected">مرفوض</option>
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
                <p class="text-muted mt-3 mb-0">لا توجد نتائج مطابقة</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table admin-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم المدرسة</th>
                            <th>المسؤول</th>
                            <th>البريد الإلكتروني</th>
                            <th>المدينة</th>
                            <th>حالة الطلب</th>
                            <th>حالة المدرسة</th>
                            <th>التاريخ</th>
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
                                    @if ($reg->status === 'pending')
                                        <span class="pill pill-warning"><i class="fas fa-clock"></i> قيد المراجعة</span>
                                    @elseif ($reg->status === 'approved')
                                        <span class="pill pill-success"><i class="fas fa-check"></i> مقبول</span>
                                    @else
                                        <span class="pill pill-danger"><i class="fas fa-xmark"></i> مرفوض</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($reg->school)
                                        @if ($reg->school->isActive())
                                            <span class="pill pill-success"><i class="fas fa-circle-check"></i> نشطة</span>
                                        @else
                                            <span class="pill pill-danger"><i class="fas fa-ban"></i> معلّقة</span>
                                        @endif
                                    @else
                                        <span class="text-muted" style="font-size:.78rem;">—</span>
                                    @endif
                                </td>
                                <td><span style="font-size:.8rem; color:#94a3b8;">{{ $reg->created_at->format('Y/m/d') }}</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if ($reg->status === 'pending')
                                            {{-- موافقة → تمر عبر نافذة التأكيد العامة --}}
                                            <button type="button"
                                                    class="btn btn-sm btn-emerald"
                                                    title="موافقة"
                                                    wire:click="$dispatch('confirm-action', [{
                                                        title:       'الموافقة على طلب التسجيل',
                                                        message:     'هل تريد الموافقة على طلب مدرسة &quot;{{ addslashes($reg->school_name) }}&quot;؟',
                                                        sub:         'سيتم إنشاء حساب مدير للمدرسة وإرسال بيانات الدخول إلى بريده.',
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
                                                    title="رفض"
                                                    wire:click="openReject({{ $reg->id }})">
                                                <i class="fas fa-xmark"></i>
                                            </button>
                                        @elseif ($reg->school)
                                            @if ($reg->school->isActive())
                                                <button type="button"
                                                        class="btn btn-sm"
                                                        style="background:#fff1f2; color:#be123c; border:1px solid #fecdd3; border-radius:8px;"
                                                        title="تعليق"
                                                        wire:click="$dispatch('confirm-action', [{
                                                            title:       'تعليق وصول المدرسة',
                                                            message:     'هل تريد تعليق وصول مدرسة &quot;{{ addslashes($reg->school_name) }}&quot; إلى المنصة فوراً؟',
                                                            sub:         'سيتم منع جميع مستخدمي هذه المدرسة من تسجيل الدخول.',
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
                                                        title="إعادة تفعيل"
                                                        wire:click="$dispatch('confirm-action', [{
                                                            title:       'إعادة تفعيل المدرسة',
                                                            message:     'هل تريد إعادة تفعيل مدرسة &quot;{{ addslashes($reg->school_name) }}&quot;؟',
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

    {{-- ══════════════════════════════════════════
         نافذة الرفض — تحتاج حقلاً نصياً، لذا مخصّصة وليست عبر نافذة التأكيد العامة
    ══════════════════════════════════════════ --}}
    @if ($showRejectModal)
        <div class="pf-reject-backdrop" wire:click.self="$set('showRejectModal', false)">
            <div class="pf-reject-modal">
                <div class="pf-reject-header">
                    <h5 class="mb-0 fw-bold" style="color:#b91c1c;">
                        <i class="fas fa-xmark-circle me-2"></i> رفض طلب التسجيل
                    </h5>
                    <button wire:click="$set('showRejectModal', false)" class="pf-reject-close">&times;</button>
                </div>
                <div class="pf-reject-body">
                    <label class="form-label fw-semibold">سبب الرفض <span class="text-danger">*</span></label>
                    <textarea wire:model="rejectReason"
                              class="form-control @error('rejectReason') is-invalid @enderror"
                              rows="3"
                              placeholder="اكتب سبب الرفض هنا..."></textarea>
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
                            <i class="fas fa-xmark me-1"></i> تأكيد الرفض
                        </span>
                        <span wire:loading wire:target="confirmReject">جاري المعالجة...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <style>
        .pf-reject-backdrop { position: fixed; inset: 0; background: rgba(15,23,42,.55); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 20px; backdrop-filter: blur(3px); }
        .pf-reject-modal { background: white; border-radius: 18px; width: 100%; max-width: 460px; box-shadow: 0 25px 80px rgba(0,0,0,.25); overflow: hidden; }
        .pf-reject-header { display: flex; align-items: center; justify-content: space-between; padding: 18px 22px 14px; border-bottom: 1px solid #f1f5f9; }
        .pf-reject-body { padding: 18px 22px; }
        .pf-reject-footer { display: flex; justify-content: flex-end; gap: 10px; padding: 14px 22px; border-top: 1px solid #f1f5f9; background: #f9fafb; }
        .pf-reject-close { background: none; border: none; font-size: 1.3rem; color: #94a3b8; cursor: pointer; line-height: 1; }
        .pf-reject-close:hover { color: #475569; }
    </style>

</div>
