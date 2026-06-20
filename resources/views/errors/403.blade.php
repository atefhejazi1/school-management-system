@extends('errors.layout')

@section('title', trans('Errors_trans.403_heading'))

@section('content')
    <div class="error-code">403 — {{ trans('Errors_trans.error_code_label') }}</div>
    <h1 class="error-heading">{{ trans('Errors_trans.403_heading') }}</h1>
    <p class="error-description">{{ trans('Errors_trans.403_description') }}</p>

    {{-- route('login') يولّد الرابط مع بادئة اللغة الحالية تلقائياً (نظام التوطين
         locale-prefixed)، ويُعيد المستخدم دائماً إلى البوابة الموحدة لتسجيل الدخول
         بدلاً من رابط ثابت قد لا يطابق اللغة أو يتغيّر مستقبلاً --}}
    <a href="{{ route('login') }}" class="error-action">
        {{ trans('Errors_trans.403_action') }}
    </a>
@endsection
