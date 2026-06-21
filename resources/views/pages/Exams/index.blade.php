@extends('layouts.master')
@section('css')
@section('title')
    {{ trans('ReportCards_trans.exams_page_title') }}
@stop
@endsection
@section('page-header')
@section('PageTitle')
    {{ trans('ReportCards_trans.exams_page_title') }}
@stop
@endsection
@section('content')

    {{-- نموذج إضافة فترة امتحانية جديدة: مسطّح بالكامل وفق نظام التصميم المؤسسي --}}
    <div class="ex-card">
        <div class="ex-card-header">
            <span class="ex-card-title">{{ trans('ReportCards_trans.add_new_exam') }}</span>
        </div>
        <form action="{{ route('Exams.store') }}" method="post" class="ex-form">
            @csrf
            <div class="ex-field">
                <label class="ex-label">{{ trans('ReportCards_trans.exam_name_ar') }}</label>
                <input type="text" name="name_ar" class="ex-input" required>
            </div>
            <div class="ex-field">
                <label class="ex-label">{{ trans('ReportCards_trans.exam_name_en') }}</label>
                <input type="text" name="name_en" class="ex-input" required>
            </div>
            <div class="ex-field">
                <label class="ex-label">{{ trans('ReportCards_trans.exam_term') }}</label>
                <input type="text" name="term" class="ex-input">
            </div>
            <div class="ex-field">
                <label class="ex-label">{{ trans('ReportCards_trans.exam_academic_year') }}</label>
                <input type="text" name="academic_year" class="ex-input">
            </div>
            <div class="ex-field ex-field-submit">
                <button type="submit" class="ex-btn-add">{{ trans('ReportCards_trans.confirm') }}</button>
            </div>
        </form>
    </div>

    <div class="ex-card">
        <div class="ex-card-header">
            <span class="ex-card-title">{{ trans('ReportCards_trans.exams_page_title') }}</span>
        </div>
        <div class="table-responsive">
            <table class="ex-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('ReportCards_trans.th_exam_name') }}</th>
                    <th>{{ trans('ReportCards_trans.exam_term') }}</th>
                    <th>{{ trans('ReportCards_trans.exam_academic_year') }}</th>
                    <th>{{ trans('ReportCards_trans.th_action') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($exams as $exam)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $exam->name }}</td>
                        <td>{{ $exam->term ?? '—' }}</td>
                        <td>{{ $exam->academic_year ?? '—' }}</td>
                        <td>
                            <form action="{{ route('Exams.destroy', 'x') }}" method="post"
                                  onsubmit="return confirm('{{ trans('ReportCards_trans.are_you_sure_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $exam->id }}">
                                <button type="submit" class="ex-btn-delete">{{ trans('messages.Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="ex-empty">—</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .ex-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; margin-bottom: 20px; }
        .ex-card-header { padding: 16px 20px; border-bottom: 1px solid #e2e8f0; }
        .ex-card-title { font-size: .95rem; font-weight: 800; color: #334155; }
        .ex-form { display: flex; flex-wrap: wrap; gap: 16px; padding: 20px; align-items: flex-end; }
        .ex-field { display: flex; flex-direction: column; min-width: 180px; }
        .ex-field-submit { min-width: auto; }
        .ex-label { font-size: .8rem; font-weight: 700; color: #334155; margin-bottom: 6px; }
        .ex-input {
            border: 1px solid #cbd5e1; border-radius: 0; padding: 9px 12px;
            font-family: 'Cairo', sans-serif; font-size: .88rem; color: #334155; background: #ffffff;
        }
        .ex-input:focus { outline: none; border-color: #059669; }
        .ex-btn-add {
            background: #059669; color: #ffffff; border: 1px solid #059669; border-radius: 0;
            padding: 9px 24px; font-family: 'Cairo', sans-serif; font-size: .85rem; font-weight: 700; cursor: pointer;
        }
        .ex-btn-add:hover { background: #047857; border-color: #047857; }
        .ex-table { width: 100%; margin: 0; font-family: 'Cairo', sans-serif; font-size: .87rem; }
        .ex-table thead th {
            background: #f8fafc; color: #334155; font-weight: 700; font-size: .78rem;
            text-transform: uppercase; letter-spacing: .4px; padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0; text-align: start;
        }
        .ex-table tbody td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; color: #334155; vertical-align: middle; }
        .ex-table tbody tr:last-child td { border-bottom: none; }
        .ex-btn-delete {
            background: #ffffff; color: #be123c; border: 1px solid #be123c; border-radius: 0;
            padding: 5px 14px; font-family: 'Cairo', sans-serif; font-size: .78rem; font-weight: 700; cursor: pointer;
        }
        .ex-btn-delete:hover { background: #be123c; color: #ffffff; }
        .ex-empty { text-align: center; padding: 30px; color: #94a3b8; }
    </style>
@endsection
