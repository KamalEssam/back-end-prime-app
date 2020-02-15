@extends('layouts.admin.master')

@section('title', trans('admin.ads'))

@section('page-title', trans('admin.ads'))

@section('page-small-title', trans('admin.edit_ad'))


@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.ads')])
@endsection



@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::model($ad, ['route' => ['ads.update', $ad->id], 'id' => 'form-add-ad', 'role' => 'Form','files' => true, 'method' => 'PATCH' ]) }}
                    @include('admin.ads.form')
                    {{ Form::close()  }}
                </div>
            </div>
        </div>
    </div>
@endsection
