@extends('layouts.admin.master')

@section('title', trans('admin.sales'))

@section('page-title', trans('admin.sales'))

@section('page-small-title', trans('admin.all_sales'))

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
    ], 'current' => trans('admin.sale')])
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
                                    <a href="{{ route('sales.create') }}" id="sample_editable_1_2_new"
                                       class="btn sbold green">  {{ ucwords(trans('admin.add_new')) }}
                                        <i class="fa fa-plus"></i>
                                    </a>
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
                            <th class="text-center"> {{ trans('admin.controls') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="odd gradeX">
                                <th class="hidden"></th>
                                <td class="center">{{ $user->name }}</td>
                                <td class="center">{{ $user->email }}</td>
                                <td class="center">{{ $user->mobile }}</td>
                                <td class="text-center">
                                    <div class="margin-bottom-5">
                                        {{-- edit category --}}
                                        <a href="{{ route('sales.edit', $user->id) }}"
                                           class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                            <i class="fa fa-edit"></i> {{ ucfirst(trans('admin.edit')) }}
                                        </a>
                                        {{-- delete category --}}
                                        <a class="btn btn-sm red btn-outline filter-cancel delete-btn"
                                           data-id="{{ $user->id }}"
                                           data-link="{{ route('sales.destroy', $user->id) }}"
                                           data-type="DELETE">
                                            <i class="fa fa-trash"></i> {{ ucfirst(trans('admin.delete')) }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
