@extends('layouts.admin.master')

@section('title', trans('admin.categories'))

@section('page-title', trans('admin.categories'))

@section('page-small-title', trans('admin.add_category'))


@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.add_category')])
@endsection


@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::open(['route' => 'categories.store', 'id' => 'form-add-category', 'role' => 'Form', 'files' => true ]) }}
                    @include('admin.categories.form')
                    {{ Form::close()  }}
                </div>
            </div>
        </div>
    </div>
@endsection
