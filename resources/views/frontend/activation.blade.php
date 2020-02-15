@extends('layouts.frontend.master')
@section('content')
    <div class="row">
        <div class="col col-xs-3">
            <div class="icon">
                <img src="{{ asset($flag==1 ? 'assets/css/check.png' : 'assets/css/error.png') }}" class="img-icon">
            </div>
        </div>
        <div class="col col-xs-9">
            <div class="message-pop">
                {!!  $flag==1 ? 'Thanks '. $user->name ." ! Your Account Is Activated" : "Sorry ! Invalid Token " !!}
            </div>
        </div>
    </div>
@stop

