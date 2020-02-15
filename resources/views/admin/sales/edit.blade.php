@extends('layouts.admin.master')

@section('title', trans('admin.sales'))

@section('page-title', trans('admin.sales'))

@section('page-small-title', trans('admin.edit_sale'))

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
    ], 'current' => trans('admin.admin.edit_sale')])
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::model($sale, ['route' => ['sales.update', $sale->id], 'id' => 'form-edit-sale', 'role' => 'Form','method' => 'PATCH']) }}
                    @include('admin.sales.edit_form')
                    {{ Form::close()  }}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-scripts')
    {{ Html::script('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}
@endsection
