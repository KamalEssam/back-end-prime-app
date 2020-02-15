@extends('layouts.admin.master')

@section('title', trans('admin.ads'))
@section('page-title', trans('admin.ads'))
@section('page-small-title', trans('admin.add_ad'))

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.add_ad')])
@endsection

@section('page-styles')
    {{ Html::style('assets/apps/css/chosen.min.css') }}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::open(['route' => 'ads.store', 'id' => 'form-add-ad', 'role' => 'Form', 'files' => true ]) }}
                    @include('admin.ads.form')
                    {{ Form::close()  }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-stack')
    {{ Html::script('assets/apps/scripts/chosen.jquery.min.js') }}
    <script>
        $('.chosen-select').chosen();
        $('.chosen-single').css({
            height: '35px !important',
            border: '1px solid #ddd !important',
            'border-radius': '251px !important'
        });
    </script>
@endpush
