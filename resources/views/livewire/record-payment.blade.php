<div>
    @if ($showModal)
        {{-- نافذة منبثقة مسطّحة بالكامل: بدون ظل، بدون حواف دائرية، بدون أيقونات —
             نُعرض المحتوى عبر @if Blade العادي بدل bootstrap.Modal JS لأن Livewire
             يتحكّم بإظهارها/إخفائها مباشرة من خلال الخاصية showModal، فلا حاجة لتنسيق
             استدعاءات JS الإمبراطورية (show()/hide()) مع حالة المكوّن --}}
        <div class="rp-backdrop" wire:click="closeModal"></div>

        <div class="rp-modal" role="dialog" aria-modal="true">
            <div class="rp-header">
                <span class="rp-title">{{ trans('Fees_trans.record_payment_title') }}</span>
                <button type="button" class="rp-close" wire:click="closeModal">×</button>
            </div>

            <div class="rp-body">
                <div class="rp-summary-row">
                    <span class="rp-summary-label">{{ trans('Fees_trans.student_name') }}</span>
                    <span class="rp-summary-value">{{ $invoiceStudentName }}</span>
                </div>
                <div class="rp-summary-row">
                    <span class="rp-summary-label">{{ trans('Fees_trans.invoice_total_amount') }}</span>
                    <span class="rp-summary-value">{{ number_format($invoiceTotalAmount, 2) }}</span>
                </div>
                <div class="rp-summary-row">
                    <span class="rp-summary-label">{{ trans('Fees_trans.invoice_balance_amount') }}</span>
                    <span class="rp-summary-value rp-balance">{{ number_format($invoiceBalanceAmount, 2) }}</span>
                </div>

                <div class="rp-field">
                    <label class="rp-label" for="rpAmount">{{ trans('Fees_trans.payment_amount') }}</label>
                    <input type="number" step="0.01" min="0.01" id="rpAmount" class="rp-input" wire:model="amount">
                    @error('amount') <span class="rp-error">{{ $message }}</span> @enderror
                </div>

                <div class="rp-field">
                    <label class="rp-label" for="rpMethod">{{ trans('Fees_trans.payment_method') }}</label>
                    <select id="rpMethod" class="rp-input" wire:model="method">
                        <option value="كاش">{{ trans('Fees_trans.payment_method_cash') }}</option>
                        <option value="شيك">{{ trans('Fees_trans.payment_method_cheque') }}</option>
                        <option value="تحويل بنكي">{{ trans('Fees_trans.payment_method_bank_transfer') }}</option>
                    </select>
                    @error('method') <span class="rp-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="rp-footer">
                <button type="button" class="rp-btn rp-btn-cancel" wire:click="closeModal">
                    {{ trans('main_trans.cancel') }}
                </button>
                <button type="button" class="rp-btn rp-btn-confirm" wire:click="recordPayment" wire:loading.attr="disabled">
                    {{ trans('Fees_trans.confirm_payment') }}
                </button>
            </div>
        </div>
    @endif

    <style>
        .rp-backdrop {
            position: fixed; inset: 0;
            background: rgba(15, 23, 42, .45);
            z-index: 1050;
        }
        .rp-modal {
            position: fixed;
            top: 50%; inset-inline-start: 50%;
            transform: translate(-50%, -50%);
            width: 100%; max-width: 440px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0;
            z-index: 1051;
            font-family: 'Cairo', sans-serif;
        }
        .rp-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .rp-title { font-size: .95rem; font-weight: 800; color: #334155; }
        .rp-close {
            background: none; border: none; color: #334155;
            font-size: 1.3rem; line-height: 1; cursor: pointer; padding: 0;
        }
        .rp-body { padding: 20px; }
        .rp-summary-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: .85rem;
        }
        .rp-summary-label { color: #64748b; }
        .rp-summary-value { color: #334155; font-weight: 700; }
        .rp-balance { color: #059669; }
        .rp-field { margin-top: 16px; }
        .rp-label {
            display: block; font-size: .8rem; font-weight: 700;
            color: #334155; margin-bottom: 6px;
        }
        .rp-input {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 0;
            padding: 9px 12px;
            font-family: 'Cairo', sans-serif;
            font-size: .88rem;
            color: #334155;
            background: #ffffff;
        }
        .rp-input:focus { outline: none; border-color: #059669; }
        .rp-error { display: block; margin-top: 4px; font-size: .76rem; color: #be123c; }
        .rp-footer {
            display: flex; justify-content: flex-end; gap: 10px;
            padding: 16px 20px;
            border-top: 1px solid #e2e8f0;
        }
        .rp-btn {
            border-radius: 0;
            padding: 8px 22px;
            font-family: 'Cairo', sans-serif;
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
        }
        .rp-btn-cancel {
            background: #ffffff;
            color: #334155;
            border: 1px solid #cbd5e1;
        }
        .rp-btn-confirm {
            background: #059669;
            color: #ffffff;
            border: 1px solid #059669;
        }
        .rp-btn-confirm:hover { background: #047857; border-color: #047857; }
    </style>
</div>
