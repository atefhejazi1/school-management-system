@extends('layouts.super-admin.master')

@section('title', __('super_dash.school_requests'))

@section('PageTitle', __('super_dash.school_requests'))

@section('content')
    @livewire('super-admin.school-requests')
@endsection
