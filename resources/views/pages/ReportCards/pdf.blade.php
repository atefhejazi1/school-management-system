<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>{{ trans('ReportCards_trans.report_card_title') }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; color: #334155; direction: rtl; }
        .pc-title { text-align: center; font-size: 16px; font-weight: bold; color: #334155; margin-bottom: 18px; }
        .pc-meta { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .pc-meta td { padding: 5px 8px; font-size: 11px; border-bottom: 1px solid #e2e8f0; }
        .pc-meta td.pc-meta-label { color: #64748b; width: 18%; }
        .pc-meta td.pc-meta-value { font-weight: bold; color: #334155; }
        table.pc-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.pc-table th {
            background: #f8fafc; color: #334155; font-size: 11px; font-weight: bold;
            padding: 8px; border: 1px solid #e2e8f0; text-align: center;
        }
        table.pc-table td { padding: 8px; border: 1px solid #e2e8f0; font-size: 11px; text-align: center; }
        .pc-summary { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .pc-summary td { padding: 8px; border: 1px solid #e2e8f0; font-size: 12px; text-align: center; }
        .pc-summary td.pc-summary-label { background: #f8fafc; font-weight: bold; color: #334155; }
        .pc-summary td.pc-summary-value { font-weight: bold; color: #059669; }
        .pc-footer { margin-top: 30px; font-size: 9px; color: #94a3b8; text-align: center; }
    </style>
</head>
<body>

<div class="pc-title">{{ trans('ReportCards_trans.report_card_title') }}</div>

<table class="pc-meta">
    <tr>
        <td class="pc-meta-label">{{ trans('ReportCards_trans.student_name') }}</td>
        <td class="pc-meta-value">{{ $student->name }}</td>
        <td class="pc-meta-label">{{ trans('ReportCards_trans.exam') }}</td>
        <td class="pc-meta-value">{{ $exam->name }}</td>
    </tr>
    <tr>
        <td class="pc-meta-label">{{ trans('ReportCards_trans.grade') }}</td>
        <td class="pc-meta-value">{{ $student->grade->Name ?? '—' }}</td>
        <td class="pc-meta-label">{{ trans('ReportCards_trans.classroom') }}</td>
        <td class="pc-meta-value">{{ $student->classroom->Name_Class ?? '—' }}</td>
    </tr>
    <tr>
        <td class="pc-meta-label">{{ trans('ReportCards_trans.section') }}</td>
        <td class="pc-meta-value">{{ $student->section->Name_Section ?? '—' }}</td>
        <td class="pc-meta-label">{{ trans('ReportCards_trans.class_size') }}</td>
        <td class="pc-meta-value">{{ $classSize }}</td>
    </tr>
</table>

<table class="pc-table">
    <thead>
    <tr>
        <th>{{ trans('ReportCards_trans.th_subject') }}</th>
        <th>{{ trans('ReportCards_trans.th_obtained') }}</th>
        <th>{{ trans('ReportCards_trans.th_max') }}</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($subjectRows as $row)
        <tr>
            <td>{{ $row['subject'] }}</td>
            <td>{{ number_format($row['obtained'], 2) }}</td>
            <td>{{ number_format($row['max'], 2) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3">—</td>
        </tr>
    @endforelse
    </tbody>
</table>

<table class="pc-summary">
    <tr>
        <td class="pc-summary-label">{{ trans('ReportCards_trans.total') }}</td>
        <td class="pc-summary-value">{{ number_format($totalObtained, 2) }} / {{ number_format($totalMax, 2) }}</td>
        <td class="pc-summary-label">{{ trans('ReportCards_trans.percentage') }}</td>
        <td class="pc-summary-value">{{ number_format($percentage, 2) }}%</td>
        <td class="pc-summary-label">{{ trans('ReportCards_trans.rank') }}</td>
        <td class="pc-summary-value">{{ $rankText }}</td>
    </tr>
</table>

<div class="pc-footer">{{ now()->format('Y-m-d') }}</div>

</body>
</html>
