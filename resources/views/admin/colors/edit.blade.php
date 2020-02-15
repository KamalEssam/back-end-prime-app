@extends('layouts.admin.master')

@section('title', trans('admin.colors'))

@section('page-title', trans('admin.colors'))

@section('page-small-title', trans('admin.edit_color'))


@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.colors')])
@endsection



@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::model($color, ['route' => ['colors.update', $color->id], 'id' => 'form-add-brand', 'role' => 'Form', 'method' => 'PATCH' ]) }}
                    @include('admin.colors.form')
                    {{ Form::close()  }}
                </div>
            </div>
        </div>
    </div>
@endsection
