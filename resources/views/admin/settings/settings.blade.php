@extends('layouts.admin.master')

@section('title', trans('admin.settings'))

@section('page-title', trans('admin.settings'))

@section('page-small-title', trans('admin.settings'))

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.settings')])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::open(['route' => 'permissions.update', 'id' => 'form-settings', 'role' => 'Form']) }}
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        You have some form errors. Please check below.
                    </div>

                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button>
                        Your form validation is successful!
                    </div>

                    <div class="form-body">

                        @foreach ((new \App\Http\Repositories\PermissionRepository())->all() as $permission)
                            <div class="form-group">
                                <div class="col-md-2">
                                    <span>{{ trans('admin.' . $permission->column ) }}</span>
                                </div>
                                <div class="col-md-10">
                                    <label class="switch">
                                        {{ Form::checkbox($permission->column, 1,(isset($permission->is_visible) && $permission->is_visible == 1) ? true :  false , ['class'=>'no-margin'])  }}
                                        <span class="slider round help-block"></span>
                                    </label>
                                </div>
                            </div>
                        @endforeach

                        <div class="form-actions">
                            <button type="submit" class="btn blue">{{ trans('admin.save') }}</button>
                            <button type="button" onclick="window.history.back()"
                                    class="btn default">{{ trans('admin.cancel') }}</button>
                        </div>
                    </div>
                    {{ Form::close()  }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script>
        var the_rules = {
            en_about_us: {
                required: true,
            }
        };
        AdminValidation(the_rules, '#form-settings');
    </script>
@stop
