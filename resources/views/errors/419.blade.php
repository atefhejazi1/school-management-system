@extends('errors.layout')

@section('title', trans('Errors_trans.419_heading'))

@section('content')
    <div class="error-code">419 — {{ trans('Errors_trans.error_code_label') }}</div>
    <h1 class="error-heading">{{ trans('Errors_trans.419_heading') }}</h1>
    <p class="error-description">{{ trans('Errors_trans.419_description') }}</p>

    {{-- خطأ 419 يعني أن CSRF Token القديم لم يعد صالحاً؛ التوجيه إلى صفحة تسجيل
         الدخول من جديد يضمن إصدار جلسة وtoken جديدين بدلاً من إعادة تحميل نفس
         الصفحة القديمة التي قد تحمل النموذج الفاشل نفسه --}}
    <a href="{{ route('login') }}" class="error-action">
        {{ trans('Errors_trans.419_action') }}
    </a>
@endsection
