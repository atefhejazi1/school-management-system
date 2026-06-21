@extends('layouts.master')
@section('css')
@section('title')
    {{ trans('ReportCards_trans.page_title') }}
@stop
@endsection
@section('page-header')
@section('PageTitle')
    {{ trans('ReportCards_trans.page_title') }}
@stop
@endsection
@section('content')

    {{-- فلاتر متسلسلة: المرحلة ثم الصف ثم الشعبة ثم الفترة الامتحانية. كل اختيار يُعيد
         إرسال النموذج تلقائياً (onchange) ليُعاد رسم الخيار التالي مفلتراً، دون أي طبقة
         JavaScript إضافية أو استدعاءات AJAX --}}
    <div name="rc-card" class="rc-card">
        <div class="rc-card-header">
            <span class="rc-card-title">{{ trans('ReportCards_trans.page_title') }}</span>
        </div>
        <form action="{{ route('ReportCards.index') }}" method="get" class="rc-filters">
            <div class="rc-field">
                <label class="rc-label">{{ trans('ReportCards_trans.select_grade') }}</label>
                <select name="grade_id" class="rc-input" onchange="this.form.submit()">
                    <option value="">{{ trans('ReportCards_trans.choose_from_list') }}</option>
                    @foreach ($grades as $grade)
                        <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>{{ $grade->Name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="rc-field">
                <label class="rc-label">{{ trans('ReportCards_trans.select_classroom') }}</label>
                <select name="classroom_id" class="rc-input" onchange="this.form.submit()" {{ $classrooms->isEmpty() ? 'disabled' : '' }}>
                    <option value="">{{ trans('ReportCards_trans.choose_from_list') }}</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>{{ $classroom->Name_Class }}</option>
                    @endforeach
                </select>
            </div>

            <div class="rc-field">
                <label class="rc-label">{{ trans('ReportCards_trans.select_section') }}</label>
                <select name="section_id" class="rc-input" onchange="this.form.submit()" {{ $sections->isEmpty() ? 'disabled' : '' }}>
                    <option value="">{{ trans('ReportCards_trans.choose_from_list') }}</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>{{ $section->Name_Section }}</option>
                    @endforeach
                </select>
            </div>

            <div class="rc-field">
                <label class="rc-label">{{ trans('ReportCards_trans.select_exam') }}</label>
                <select name="exam_id" class="rc-input" onchange="this.form.submit()">
                    <option value="">{{ trans('ReportCards_trans.choose_from_list') }}</option>
                    @foreach ($exams as $exam)
                        <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>{{ $exam->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <div class="rc-card">
        <div class="rc-card-header">
            <span class="rc-card-title">{{ trans('ReportCards_trans.th_student_name') }}</span>
            <span class="rc-card-count">{{ $students->count() }}</span>
        </div>
        <div class="table-responsive">
            <table class="rc-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('ReportCards_trans.th_student_name') }}</th>
                    <th>{{ trans('ReportCards_trans.th_action') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->name }}</td>
                        <td>
                            @if (request('exam_id'))
                                <a href="{{ route('ReportCards.pdf', ['studentId' => $student->id, 'examId' => request('exam_id')]) }}"
                                   target="_blank" class="rc-btn-pdf">
                                    {{ trans('ReportCards_trans.generate_pdf_action') }}
                                </a>
                            @else
                                <span class="rc-disabled-hint">{{ trans('ReportCards_trans.select_exam_first') }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="rc-empty">{{ trans('ReportCards_trans.no_students_found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .rc-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; margin-bottom: 20px; }
        .rc-card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; border-bottom: 1px solid #e2e8f0;
        }
        .rc-card-title { font-size: .95rem; font-weight: 800; color: #334155; }
        .rc-card-count { font-size: .8rem; font-weight: 600; color: #64748b; }
        .rc-filters { display: flex; flex-wrap: wrap; gap: 16px; padding: 20px; }
        .rc-field { display: flex; flex-direction: column; min-width: 200px; }
        .rc-label { font-size: .8rem; font-weight: 700; color: #334155; margin-bottom: 6px; }
        .rc-input {
            border: 1px solid #cbd5e1; border-radius: 0; padding: 9px 12px;
            font-family: 'Cairo', sans-serif; font-size: .88rem; color: #334155; background: #ffffff;
        }
        .rc-input:focus { outline: none; border-color: #059669; }
        .rc-table { width: 100%; margin: 0; font-family: 'Cairo', sans-serif; font-size: .87rem; }
        .rc-table thead th {
            background: #f8fafc; color: #334155; font-weight: 700; font-size: .78rem;
            text-transform: uppercase; letter-spacing: .4px; padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0; text-align: start;
        }
        .rc-table tbody td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; color: #334155; vertical-align: middle; }
        .rc-table tbody tr:last-child td { border-bottom: none; }
        .rc-btn-pdf {
            display: inline-block; background: #ffffff; color: #059669; border: 1px solid #059669; border-radius: 0;
            padding: 6px 16px; font-family: 'Cairo', sans-serif; font-size: .8rem; font-weight: 700; text-decoration: none;
        }
        .rc-btn-pdf:hover { background: #059669; color: #ffffff; }
        .rc-disabled-hint { font-size: .78rem; color: #94a3b8; }
        .rc-empty { text-align: center; padding: 30px; color: #94a3b8; }
    </style>
@endsection
