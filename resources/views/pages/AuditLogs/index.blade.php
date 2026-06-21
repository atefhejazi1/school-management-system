@extends('layouts.master')
@section('css')
@section('title')
    {{ trans('AuditLogs_trans.page_title') }}
@stop
@endsection
@section('page-header')
@section('PageTitle')
    {{ trans('AuditLogs_trans.page_title') }}
@stop
@endsection
@section('content')

    {{-- سجل نصّي بحت بترتيب زمني عكسي (الأحدث أولاً)، بدون أي أيقونات أو ألوان زخرفية،
         وفق نظام التصميم المؤسسي المسطّح (Slate Gray + Emerald Green) --}}
    <div class="al-card">
        <div class="al-card-header">
            <span class="al-card-title">{{ trans('AuditLogs_trans.page_title') }}</span>
            <span class="al-card-count">{{ $auditLogs->total() }}</span>
        </div>

        <div class="table-responsive">
            <table class="al-table">
                <thead>
                <tr>
                    <th>{{ trans('AuditLogs_trans.th_date') }}</th>
                    <th>{{ trans('AuditLogs_trans.th_user') }}</th>
                    <th>{{ trans('AuditLogs_trans.th_action') }}</th>
                    <th>{{ trans('AuditLogs_trans.th_summary') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($auditLogs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $log->user->name ?? '—' }}</td>
                        <td>
                            <span class="al-action al-action-{{ $log->action }}">
                                {{ trans('AuditLogs_trans.action_' . $log->action) }}
                            </span>
                        </td>
                        <td>{{ $log->summary }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="al-empty">{{ trans('AuditLogs_trans.no_logs_found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="al-pagination">
            {{ $auditLogs->links() }}
        </div>
    </div>

    <style>
        .al-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; }
        .al-card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; border-bottom: 1px solid #e2e8f0;
        }
        .al-card-title { font-size: .95rem; font-weight: 800; color: #334155; }
        .al-card-count { font-size: .8rem; font-weight: 600; color: #64748b; }
        .al-table { width: 100%; margin: 0; font-family: 'Cairo', sans-serif; font-size: .87rem; }
        .al-table thead th {
            background: #f8fafc; color: #334155; font-weight: 700; font-size: .78rem;
            text-transform: uppercase; letter-spacing: .4px; padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0; text-align: start;
        }
        .al-table tbody td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; color: #334155; vertical-align: middle; }
        .al-table tbody tr:last-child td { border-bottom: none; }
        .al-action {
            display: inline-block; font-size: .76rem; font-weight: 700; padding: 3px 10px; border-radius: 0;
            border: 1px solid #cbd5e1; color: #334155;
        }
        .al-action-created { border-color: #059669; color: #059669; }
        .al-action-updated { border-color: #92400e; color: #92400e; }
        .al-action-deleted { border-color: #be123c; color: #be123c; }
        .al-empty { text-align: center; padding: 30px; color: #94a3b8; }
        .al-pagination { padding: 16px 20px; }
    </style>
@endsection
