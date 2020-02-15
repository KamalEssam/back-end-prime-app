@extends('layouts.admin.login')

<!-- comment -->
@section('title', 'reset password')


@section('content')

    <div>
        <div class="col-md-4 form-spaces login">
            <div id="login">
                <h1 class="loon">Forget Password</h1>

                <form class="login-form" action="{{route('sendResetEmail')}}" method="post">

                    {{ csrf_field() }}

                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}"/>

                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="{{trans('lang.email')}}">
                        <small class="red">{{  $errors->has('email') ? $errors->first('email') : '' }}</small>

                    </div>

                    <div class="form-check">
                        <button type="submit"
                                class="btn btn-custom btn-lg btn-block background-loon">{{trans('lang.send_confirmation_email')}}</button>
                    </div>
                </form>

                @if(Session::has('status'))
                    <div class="mt-100 text-center alert alert-success flash">
                        {{  Session::get('status') }}
                    </div>
                @endif
                <div class="row">
                    <div class="auth-logo">
                        <a href="/"><img src="{{ asset('assets/images/logo/logo.png') }}"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

