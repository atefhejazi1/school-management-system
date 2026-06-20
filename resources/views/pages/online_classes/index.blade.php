@extends('layouts.master')
@section('css')
@section('title')
    {{ trans('OnlineClasses_trans.list_title') }}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    {{ trans('OnlineClasses_trans.list_title') }}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="col-xl-12 mb-30">
                    <div class="card card-statistics h-100">
                        <div class="card-body">
                            <a href="{{ route('online_classes.create') }}" class="btn btn-success" role="button"
                                aria-pressed="true">{{ trans('OnlineClasses_trans.add_online_class') }}</a>
                            <a class="btn btn-warning" href="{{ route('indirect.create') }}">{{ trans('OnlineClasses_trans.add_offline_class') }}</a>
                            <div class="table-responsive">
                                <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                                    data-page-length="50" style="text-align: center">
                                    <thead>
                                        <tr class="alert-success">
                                            <th>#</th>
                                            <th>{{ trans('OnlineClasses_trans.grade_stage_column') }}</th>
                                            <th>{{ trans('OnlineClasses_trans.classroom_column') }}</th>
                                            <th>{{ trans('OnlineClasses_trans.section_column') }}</th>
                                            <th>{{ trans('OnlineClasses_trans.teacher_column') }}</th>
                                            <th>{{ trans('OnlineClasses_trans.class_title_column') }}</th>
                                            <th>{{ trans('OnlineClasses_trans.start_date_column') }}</th>
                                            <th>{{ trans('OnlineClasses_trans.class_time_column') }}</th>
                                            <th>{{ trans('OnlineClasses_trans.class_link_column') }}</th>
                                            <th>{{ trans('OnlineClasses_trans.processes_column') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($online_classes as $online_classe)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $online_classe->grade->Name }}</td>
                                                <td>{{ $online_classe->classroom->Name_Class }}</td>
                                                <td>{{ $online_classe->section->Name_Section }}</td>
                                                <td>{{ $online_classe->created_by }}</td>
                                                <td>{{ $online_classe->topic }}</td>
                                                <td>{{ $online_classe->start_at }}</td>
                                                <td>{{ $online_classe->duration }}</td>
                                                <td class="text-danger"><a href="{{ $online_classe->join_url }}"
                                                        target="_blank">{{ trans('OnlineClasses_trans.join_now') }}</a></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#Delete_receipt{{ $online_classe->meeting_id }}"><i
                                                            class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            @include('pages.online_classes.delete')
                                        @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
@toastr_js
@toastr_render
@endsection
