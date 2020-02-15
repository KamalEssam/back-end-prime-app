@extends('layouts.admin.master')

@section('title', trans('admin.products'))

@section('page-title', trans('admin.products'))

@section('page-small-title', trans('admin.edit_product'))

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
    ], 'current' => trans('admin.edit_product')])
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::model($product, ['route' => ['products.update', $product->id], 'id' => 'form-add-product', 'role' => 'Form','method' => 'PATCH', 'files' => true  ]) }}
                    @include('admin.products.form')
                    {{ Form::close()  }}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-scripts')
    {{ Html::script('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}
@endsection
