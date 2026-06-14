<div>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius:12px; border:none; background:#dcfce7; color:#15803d;">
            <i class="fas fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ── Header ── --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h4 class="mb-1 fw-bold" style="color:#1e293b; font-size:1.35rem;">
                <i class="fas fa-clipboard-list me-2" style="color:#2563eb;"></i>
                طلبات تسجيل المدارس
            </h4>
            <p class="text-muted mb-0" style="font-size:.88rem;">إدارة وقبول طلبات تسجيل المدارس الجديدة</p>
        </div>
        @if ($pendingCount > 0)
            <span class="badge rounded-pill px-3 py-2" style="background:#fef3c7; color:#92400e; font-size:.85rem; border:1px solid #fde68a;">
                <i class="fas fa-clock me-1"></i> {{ $pendingCount }} طلب قيد المراجعة
            </span>
        @endif
    </div>

    {{-- ── Filters ── --}}
    <div class="rr-filter-bar mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text" style="background:white; border-color:#e2e8f0;">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text"
                           wire:model.live.debounce.350ms="search"
                           class="form-control rr-search"
                           placeholder="ابحث باسم المدرسة، الإيميل، أو المسؤول...">
                </div>
            </div>
            <div class="col-md-3">
                <select wire:model.live="filterStatus" class="form-select rr-select">
                    <option value="">كل الحالات</option>
                    <option value="pending">قيد المراجعة</option>
                    <option value="approved">مقبول</option>
                    <option value="rejected">مرفوض</option>
                </select>
            </div>
            <div class="col-md-4 text-start">
                <span class="text-muted" style="font-size:.85rem;">
                    إجمالي النتائج: <strong>{{ $registrations->total() }}</strong>
                </span>
            </div>
        </div>
    </div>

    {{-- ── Table ── --}}
    <div class="rr-table-wrap">
        @if ($registrations->isEmpty())
            <div class="text-center py-5">
                <div style="font-size:3rem; opacity:.3;">📋</div>
                <p class="text-muted mt-3">لا توجد نتائج مطابقة للبحث</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table rr-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم المدرسة</th>
                            <th>المسؤول</th>
                            <th>الإيميل</th>
                            <th>المدينة</th>
                            <th>عدد الطلاب</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registrations as $reg)
                            <tr>
                                <td class="text-muted" style="font-size:.8rem;">{{ $reg->id }}</td>
                                <td>
                                    <span class="fw-semibold" style="color:#1e293b;">{{ $reg->school_name }}</span>
                                </td>
                                <td>{{ $reg->contact_name }}</td>
                                <td>
                                    <span dir="ltr" style="font-size:.88rem; color:#475569;">{{ $reg->email }}</span>
                                </td>
                                <td>{{ $reg->city }}</td>
                                <td>
                                    <span class="badge rounded-pill" style="background:#eff6ff; color:#2563eb; font-size:.78rem; border:1px solid #bfdbfe;">
                                        {{ $reg->studentCountLabel() }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill badge-status-{{ $reg->status }}">
                                        @if ($reg->status === 'pending')
                                            <i class="fas fa-clock me-1"></i> قيد المراجعة
                                        @elseif ($reg->status === 'approved')
                                            <i class="fas fa-check me-1"></i> مقبول
                                        @else
                                            <i class="fas fa-xmark me-1"></i> مرفوض
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span style="font-size:.8rem; color:#94a3b8;">
                                        {{ $reg->created_at->format('Y/m/d') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button wire:click="openDetails({{ $reg->id }})"
                                                class="btn btn-sm rr-btn-detail" title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if ($reg->status === 'pending')
                                            <button wire:click="openApprove({{ $reg->id }})"
                                                    class="btn btn-sm rr-btn-approve" title="قبول">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button wire:click="openReject({{ $reg->id }})"
                                                    class="btn btn-sm rr-btn-reject" title="رفض">
                                                <i class="fas fa-xmark"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-4 py-3 border-top" style="border-color:#f1f5f9 !important;">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>

    {{-- ══════════════════════════════════════════
         APPROVE MODAL
    ══════════════════════════════════════════ --}}
    @if ($showApproveModal)
        <div class="rr-modal-backdrop" wire:click.self="$set('showApproveModal', false)">
            <div class="rr-modal">
                <div class="rr-modal-header" style="border-top: 4px solid #22c55e;">
                    <h5 class="mb-0 fw-bold" style="color:#15803d;">
                        <i class="fas fa-check-circle me-2"></i> قبول طلب التسجيل
                    </h5>
                    <button wire:click="$set('showApproveModal', false)" class="rr-modal-close">&times;</button>
                </div>
                <div class="rr-modal-body">
                    @php $reg = \App\Models\SchoolRegistration::find($approvingId); @endphp
                    @if ($reg)
                        <p class="mb-3">
                            هل تريد قبول طلب مدرسة <strong>{{ $reg->school_name }}</strong>؟
                        </p>
                        <div class="rr-choice-card mb-3">
                            <div class="form-check">
                                <input type="checkbox" wire:model="createAccount" class="form-check-input" id="createAcc">
                                <label class="form-check-label fw-semibold me-2" for="createAcc">
                                    إنشاء حساب Admin للمدرسة فوراً
                                </label>
                            </div>
                            @if ($createAccount)
                                <div class="mt-2 p-2 rounded-2" style="background:#f0fdf4; font-size:.85rem; color:#15803d; border:1px solid #bbf7d0;">
                                    <i class="fas fa-info-circle me-1"></i>
                                    سيتم إنشاء حساب بالبريد <strong>{{ $reg->email }}</strong> وإرسال كلمة المرور تلقائياً.
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="rr-modal-footer">
                    <button wire:click="$set('showApproveModal', false)" class="btn btn-outline-secondary">إلغاء</button>
                    <button wire:click="confirmApprove" class="btn btn-success px-4" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="confirmApprove">
                            <i class="fas fa-check me-1"></i> تأكيد القبول
                        </span>
                        <span wire:loading wire:target="confirmApprove">جاري المعالجة...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ══════════════════════════════════════════
         REJECT MODAL
    ══════════════════════════════════════════ --}}
    @if ($showRejectModal)
        <div class="rr-modal-backdrop" wire:click.self="$set('showRejectModal', false)">
            <div class="rr-modal">
                <div class="rr-modal-header" style="border-top: 4px solid #ef4444;">
                    <h5 class="mb-0 fw-bold" style="color:#b91c1c;">
                        <i class="fas fa-xmark-circle me-2"></i> رفض طلب التسجيل
                    </h5>
                    <button wire:click="$set('showRejectModal', false)" class="rr-modal-close">&times;</button>
                </div>
                <div class="rr-modal-body">
                    @php $reg = \App\Models\SchoolRegistration::find($rejectingId); @endphp
                    @if ($reg)
                        <p class="mb-3">رفض طلب مدرسة <strong>{{ $reg->school_name }}</strong></p>
                    @endif
                    <label class="form-label fw-semibold">سبب الرفض <span class="text-danger">*</span></label>
                    <textarea wire:model="rejectReason"
                              class="form-control @error('rejectReason') is-invalid @enderror"
                              rows="3"
                              placeholder="اكتب سبب الرفض هنا..."></textarea>
                    @error('rejectReason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="rr-modal-footer">
                    <button wire:click="$set('showRejectModal', false)" class="btn btn-outline-secondary">إلغاء</button>
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

    {{-- ══════════════════════════════════════════
         DETAILS MODAL
    ══════════════════════════════════════════ --}}
    @if ($showDetailsModal && $detailsRecord)
        <div class="rr-modal-backdrop" wire:click.self="$set('showDetailsModal', false)">
            <div class="rr-modal rr-modal-lg">
                <div class="rr-modal-header" style="border-top: 4px solid #2563eb;">
                    <h5 class="mb-0 fw-bold" style="color:#1e3a8a;">
                        <i class="fas fa-school me-2"></i> تفاصيل الطلب
                    </h5>
                    <button wire:click="$set('showDetailsModal', false)" class="rr-modal-close">&times;</button>
                </div>
                <div class="rr-modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="rr-detail-item">
                                <span class="rr-detail-label">اسم المدرسة</span>
                                <span class="rr-detail-value">{{ $detailsRecord->school_name }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rr-detail-item">
                                <span class="rr-detail-label">اسم المسؤول</span>
                                <span class="rr-detail-value">{{ $detailsRecord->contact_name }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rr-detail-item">
                                <span class="rr-detail-label">البريد الإلكتروني</span>
                                <span class="rr-detail-value" dir="ltr">{{ $detailsRecord->email }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rr-detail-item">
                                <span class="rr-detail-label">رقم الهاتف</span>
                                <span class="rr-detail-value" dir="ltr">{{ $detailsRecord->phone }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rr-detail-item">
                                <span class="rr-detail-label">المدينة</span>
                                <span class="rr-detail-value">{{ $detailsRecord->city }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rr-detail-item">
                                <span class="rr-detail-label">عدد الطلاب</span>
                                <span class="rr-detail-value">{{ $detailsRecord->studentCountLabel() }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rr-detail-item">
                                <span class="rr-detail-label">الحالة</span>
                                <span class="badge badge-status-{{ $detailsRecord->status }}">{{ $detailsRecord->statusLabel() }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rr-detail-item">
                                <span class="rr-detail-label">تاريخ الطلب</span>
                                <span class="rr-detail-value">{{ $detailsRecord->created_at->format('Y/m/d H:i') }}</span>
                            </div>
                        </div>
                        @if ($detailsRecord->message)
                            <div class="col-12">
                                <div class="rr-detail-item">
                                    <span class="rr-detail-label">ملاحظات</span>
                                    <span class="rr-detail-value">{{ $detailsRecord->message }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($detailsRecord->admin_notes)
                            <div class="col-12">
                                <div class="rr-detail-item" style="background:#fff5f5; border-color:#fecaca;">
                                    <span class="rr-detail-label" style="color:#b91c1c;">ملاحظات المشرف (سبب الرفض)</span>
                                    <span class="rr-detail-value">{{ $detailsRecord->admin_notes }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="rr-modal-footer">
                    <button wire:click="$set('showDetailsModal', false)" class="btn btn-outline-secondary">إغلاق</button>
                    @if ($detailsRecord->status === 'pending')
                        <button wire:click="openApprove({{ $detailsRecord->id }}); $set('showDetailsModal', false)"
                                class="btn btn-success px-4">
                            <i class="fas fa-check me-1"></i> قبول
                        </button>
                        <button wire:click="openReject({{ $detailsRecord->id }}); $set('showDetailsModal', false)"
                                class="btn btn-danger px-4">
                            <i class="fas fa-xmark me-1"></i> رفض
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- ══ Styles ══ --}}
    <style>
        .rr-filter-bar { background: white; border-radius: 14px; padding: 16px 18px; box-shadow: 0 1px 8px rgba(0,0,0,.05); border: 1px solid #f1f5f9; }
        .rr-search, .rr-select { border-color: #e2e8f0; border-radius: 10px; font-family: 'Cairo', sans-serif; font-size: .9rem; }
        .rr-search:focus, .rr-select:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.08); }

        .rr-table-wrap { background: white; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,.06); border: 1px solid #f1f5f9; overflow: hidden; }
        .rr-table thead th { background: #f8fafc; font-weight: 700; font-size: .82rem; color: #64748b; text-transform: uppercase; letter-spacing: .3px; padding: 14px 16px; border-bottom: 2px solid #e2e8f0; white-space: nowrap; }
        .rr-table tbody td { padding: 14px 16px; border-bottom: 1px solid #f8fafc; font-size: .9rem; vertical-align: middle; }
        .rr-table tbody tr:hover { background: #f9fafb; }
        .rr-table tbody tr:last-child td { border-bottom: none; }

        .badge-status-pending  { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; font-size: .78rem; padding: 4px 10px; border-radius: 20px; }
        .badge-status-approved { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-size: .78rem; padding: 4px 10px; border-radius: 20px; }
        .badge-status-rejected { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; font-size: .78rem; padding: 4px 10px; border-radius: 20px; }

        .rr-btn-detail  { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; border-radius: 8px; width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center; }
        .rr-btn-approve { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; border-radius: 8px; width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center; }
        .rr-btn-reject  { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; border-radius: 8px; width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center; }
        .rr-btn-detail:hover  { background: #2563eb; color: white; }
        .rr-btn-approve:hover { background: #15803d; color: white; }
        .rr-btn-reject:hover  { background: #b91c1c; color: white; }

        /* Modals */
        .rr-modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 20px; backdrop-filter: blur(3px); }
        .rr-modal { background: white; border-radius: 20px; width: 100%; max-width: 480px; box-shadow: 0 25px 80px rgba(0,0,0,.25); overflow: hidden; }
        .rr-modal-lg { max-width: 700px; }
        .rr-modal-header { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px 16px; border-bottom: 1px solid #f1f5f9; }
        .rr-modal-body { padding: 20px 24px; }
        .rr-modal-footer { display: flex; justify-content: flex-end; gap: 10px; padding: 16px 24px; border-top: 1px solid #f1f5f9; background: #f9fafb; }
        .rr-modal-close { background: none; border: none; font-size: 1.4rem; color: #94a3b8; cursor: pointer; line-height: 1; padding: 0; }
        .rr-modal-close:hover { color: #475569; }

        .rr-choice-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; }

        .rr-detail-item { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; }
        .rr-detail-label { display: block; font-size: .78rem; color: #94a3b8; font-weight: 600; margin-bottom: 4px; }
        .rr-detail-value { font-size: .92rem; color: #1e293b; font-weight: 600; }
    </style>

</div>
