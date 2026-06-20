@extends('layouts.master')
@section('css')
@section('title')
    {{ trans('Fees_trans.outstanding_invoices_title') }}
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    {{ trans('Fees_trans.outstanding_invoices_title') }}
@stop
<!-- breadcrumb -->
@endsection
@section('content')

    {{-- جدول مسطّح بالكامل: بدون ظل، بدون حواف دائرية، بدون أيقونات — متَّسق مع
         نظام التصميم المؤسسي الجديد (Slate Gray + Emerald Green) --}}
    <div class="oi-card">
        <div class="oi-card-header">
            <span class="oi-card-title">{{ trans('Fees_trans.outstanding_invoices_title') }}</span>
            <span class="oi-card-count">{{ trans('Fees_trans.outstanding_count', ['count' => $outstandingInvoices->count()]) }}</span>
        </div>

        <div class="table-responsive">
            <table class="oi-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('Fees_trans.student_name') }}</th>
                    <th>{{ trans('Fees_trans.th_fee_type') }}</th>
                    <th>{{ trans('Fees_trans.invoice_total_amount') }}</th>
                    <th>{{ trans('Fees_trans.paid_amount') }}</th>
                    <th>{{ trans('Fees_trans.invoice_balance_amount') }}</th>
                    <th>{{ trans('Fees_trans.status') }}</th>
                    <th>{{ trans('Fees_trans.th_processes') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($outstandingInvoices as $invoice)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $invoice->student->name ?? '—' }}</td>
                        <td>{{ $invoice->fees->title ?? '—' }}</td>
                        <td>{{ number_format($invoice->amount, 2) }}</td>
                        <td>{{ number_format($invoice->paid_amount, 2) }}</td>
                        <td class="oi-balance">{{ number_format($invoice->balance_amount, 2) }}</td>
                        <td>
                            @if ($invoice->status === 'partially_paid')
                                <span class="oi-status oi-status-partial">{{ trans('Fees_trans.status_partially_paid') }}</span>
                            @else
                                <span class="oi-status oi-status-unpaid">{{ trans('Fees_trans.status_unpaid') }}</span>
                            @endif
                        </td>
                        <td>
                            <button type="button"
                                    class="oi-btn-pay"
                                    onclick="Livewire.dispatch('open-record-payment-modal', { invoiceId: {{ $invoice->id }} })">
                                {{ trans('Fees_trans.record_payment_action') }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="oi-empty">{{ trans('Fees_trans.no_outstanding_invoices') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <livewire:record-payment />

    <style>
        .oi-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0;
        }
        .oi-card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .oi-card-title { font-size: .95rem; font-weight: 800; color: #334155; }
        .oi-card-count { font-size: .8rem; font-weight: 600; color: #64748b; }
        .oi-table { width: 100%; margin: 0; font-family: 'Cairo', sans-serif; font-size: .87rem; }
        .oi-table thead th {
            background: #f8fafc;
            color: #334155;
            font-weight: 700;
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
            text-align: start;
        }
        .oi-table tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }
        .oi-table tbody tr:last-child td { border-bottom: none; }
        .oi-balance { font-weight: 800; color: #be123c; }
        .oi-status {
            display: inline-block;
            font-size: .76rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 0;
        }
        .oi-status-partial { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .oi-status-unpaid  { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
        .oi-btn-pay {
            background: #ffffff;
            color: #059669;
            border: 1px solid #059669;
            border-radius: 0;
            padding: 6px 16px;
            font-family: 'Cairo', sans-serif;
            font-size: .8rem;
            font-weight: 700;
            cursor: pointer;
        }
        .oi-btn-pay:hover { background: #059669; color: #ffffff; }
        .oi-empty { text-align: center; padding: 30px; color: #94a3b8; }
    </style>
@endsection
@section('js')
    @toastr_js
    @toastr_render
    <script>
        document.addEventListener('livewire:init', () => {
            // إعادة تحميل الصفحة بعد تسجيل أي دفعة بنجاح، لضمان ظهور أرقام المتبقي
            // والحالة المحدَّثة فوراً في الجدول (الجدول هنا Blade عادي وليس Livewire،
            // فلا يُعاد رسمه تلقائياً عند تغيّر بيانات مكوّن RecordPayment المنفصل)
            Livewire.on('payment-recorded', () => window.location.reload());
        });
    </script>
@endsection
