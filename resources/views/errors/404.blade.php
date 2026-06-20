@extends('errors.layout')

@section('title', trans('Errors_trans.404_heading'))

@section('content')
    <div class="error-code">404 — {{ trans('Errors_trans.error_code_label') }}</div>
    <h1 class="error-heading">{{ trans('Errors_trans.404_heading') }}</h1>
    <p class="error-description">{{ trans('Errors_trans.404_description') }}</p>

    {{-- route('dashboard') مسار محمي بـ middleware('auth')، فإذا كان الزائر
         غير مسجل دخوله سيُعاد توجيهه تلقائياً لصفحة تسجيل الدخول عبر middleware
         النظام نفسه، بلا حاجة لفرع شرطي إضافي هنا --}}
    <a href="{{ route('dashboard') }}" class="error-action">
        {{ trans('Errors_trans.404_action') }}
    </a>
@endsection
