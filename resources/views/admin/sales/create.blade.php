@extends('layouts.admin.master')

@section('title', trans('admin.sales'))

@section('page-title', trans('admin.sales'))

@section('page-small-title', trans('admin.add_sale'))

@section('page-styles')
    {{ Html::style('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}
    {{ Html::style('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css') }}
    <style>
        .bootstrap-tagsinput input {
            min-width: 500px;
            min-height: 50px;
        }
    </style>
@endsection

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.sales')])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::open(['route' => 'sales.store', 'id' => 'form-add-sale', 'role' => 'Form' ]) }}
                    @include('admin.sales.form')
                    {{ Form::close()  }}
                </div>
            </div>
        </div>
    </div>
@endsection
