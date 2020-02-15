@extends('layouts.admin.master')

@section('title', trans('admin.settings'))
@section('page-title', trans('admin.settings'))
@section('page-small-title', trans('admin.change_pass'))

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.change_pass')])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::open(['route' => 'user.change_pass_store', 'id' => 'form-change-password', 'role' => 'Form']) }}

                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        You have some form errors. Please check below.
                    </div>

                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button>
                        Your form validation is successful!
                    </div>

                    <div class="form-body">

                        <div class="form-group">
                            <label>{{ trans('admin.old_pass') }}</label>
                            <div class="input-icon right {{ $errors->has('old_pass') ? 'has-error' : '' }}">
                                <i class="fa fa-info"></i>
                                {{ Form::password('old_pass', ['class' => 'form-control input-circle', 'placeholder' => 'old password']) }}
                                <span class="help-block">{{ $errors->first('old_pass') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ trans('admin.new_pass') }}</label>
                            <div class="input-icon right {{ $errors->has('new_pass') ? 'has-error' : '' }}">
                                <i class="fa fa-info"></i>
                                {{ Form::password('password', ['class' => 'form-control input-circle','id' => 'password', 'placeholder' => 'new password']) }}
                                <span class="help-block">{{ $errors->first('new_pass') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ trans('admin.new_pass_confirm') }}</label>
                            <div class="input-icon right {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                <i class="fa fa-info"></i>
                                {{ Form::password('password_confirmation', ['class' => 'form-control input-circle', 'placeholder' => 'confirm new password']) }}
                                <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                            </div>
                        </div>

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
            old_pass: {
                minlength: 6,
                required: true
            },
            password: {
                minlength: 6,
                required: true
            },
            password_confirmation: {
                minlength: 6,
                required: true,
                equalTo: "#password"
            },
        };
        AdminValidation(the_rules, '#form-change-password');
    </script>
@stop
