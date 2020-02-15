@extends('layouts.admin.master')

@section('title', trans('admin.products'))

@section('page-title', trans('admin.products'))

@section('page-small-title', trans('admin.add_product'))

@section('page-styles')
    {{ Html::style('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}
    {{ Html::style('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css') }}
    {{ Html::style('assets/pages/css/select2.min.css') }}
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
    ], 'current' => trans('admin.products')])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::open(['route' => 'products.store', 'id' => 'form-add-product', 'role' => 'Form', 'files' => true ]) }}
                    @include('admin.products.form')
                    {{ Form::close()  }}
                </div>
            </div>
        </div>
    </div>
@endsection
