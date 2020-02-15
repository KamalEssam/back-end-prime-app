@extends('layouts.admin.master')

@section('title', trans('admin.categories'))

@section('page-title', trans('admin.categories'))

@section('page-small-title', trans('admin.edit_category'))


@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.categories')])
@endsection



@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::model($category, ['route' => ['categories.update', $category->id], 'id' => 'form-add-category', 'role' => 'Form','files' => true, 'method' => 'PATCH' ]) }}
                    @include('admin.categories.form')
                    {{ Form::close()  }}
                </div>
            </div>
        </div>
    </div>
@endsection
