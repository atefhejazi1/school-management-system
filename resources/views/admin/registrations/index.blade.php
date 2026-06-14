@extends('layouts.master')

@section('title')
    طلبات التسجيل
@endsection

@section('page-header')
@section('PageTitle')
    طلبات تسجيل المدارس
@endsection
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-30">
        <livewire:admin.registration-requests />
    </div>
</div>
@endsection

@section('js')
@livewireScripts
@endsection
