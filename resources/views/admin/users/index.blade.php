@extends('layouts.admin.master')

@section('title', trans('admin.users'))

@section('page-title', trans('admin.users'))

@section('page-small-title', trans('admin.all_users'))

@section('page-styles')
    <style>
        tr > td {
            padding: 18px !important;
        }
    </style>
@endsection

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.users')])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column"
                           id="sample_5">
                        <thead>
                        <tr>
                            <th class="hidden"></th>
                            <th>{{ trans('admin.name') }}</th>
                            <th>{{ trans('admin.email') }}</th>
                            <th>{{ trans('admin.mobile') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="odd gradeX">
                                <th class="hidden"></th>
                                <td class="center">{{ $user->name }}</td>
                                <td class="center">{{ $user->email }}</td>
                                <td class="center">{{ $user->mobile }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
