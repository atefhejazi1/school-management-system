@extends('layouts.super-admin.master')

@section('title', trans('super_dash.platform_settings_title'))

@section('PageTitle', trans('super_dash.platform_settings_title'))

@section('content')
    @livewire('super-admin.platform-settings')
@endsection
