@extends('layouts.admin.guest')
<!-- comment -->
@section('title', 'reset password')

@section('content')
    <style>
        label {
            color: #fff;
        }

        .login {
            background-color: #252525 !important;
        }

        .page-content, .page-footer {
            background-color: #252525 !important;
        }

        .center-screen {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 100vh;
        }


        @media (max-width: 480px) {
            .reset {
                width: auto !important;
            }
        }

        @media (max-width: 768px) {
            .reset {
                width: auto !important;
            }
        }


    </style>

    <div class="container center-screen">
        <div class="text-center">
            @include('includes.admin.components.login-logo')
        </div>


        <div class="login reset" style="width: 40%">
            <h1 class="loon text-center" style="color: #fff;">{{ ucwords(trans('admin.reset_password')) }}</h1>

            {!! Form::open(['route' => 'resetPassword']) !!}
            {{ csrf_field() }}

            <div class="form-group text-left">
                <label>{{ trans('admin.password') }}</label>
                <div class="input-icon right {{ $errors->has('password') ? 'has-error' : '' }}">
                    {{ Form::password('password', ['class' => 'form-control input-circle', 'placeholder' => 'enter password']) }}
                    <span class="help-block">{{ $errors->first('password') }}</span>
                </div>
            </div>

            <div class="form-group text-left">
                <label>{{ trans('admin.password_confirmation') }}</label>
                <div class="input-icon right {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    {{ Form::password('password_confirmation', ['class' => 'form-control input-circle', 'placeholder' => 'enter password']) }}
                    <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                </div>
            </div>
            <input type="hidden" name="user_id" value="{{ request()->segment(2) }}">
            <input type="hidden" name="token" value="{{ request()->segment(4) }}">
            <div class="form-group text-center">
                <button type="submit"
                        class="btn btn-primary btn-md background-loon">{{trans('admin.reset_password')}}
                </button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop

