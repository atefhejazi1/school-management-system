@extends('layouts.master')
@section('css')
    @livewireStyles
@section('title')
    {{ trans('Students_trans.Take_exam') }}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    {{ trans('Students_trans.Take_exam') }}
@stop
<!-- breadcrumb -->
@endsection
@section('content')

@livewire('show-question', ['quizze_id' => $quizze_id, 'student_id' => $student_id])

@endsection
@section('js')
@toastr_js
@toastr_render
@livewireScripts
@endsection
