@extends('layouts.admin.master')
@section('title', trans('admin.notifications'))
@section('page-title', trans('admin.notifications'))
@section('page-small-title', trans('admin.notifications'))

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.notifications')])
@endsection

@section('page-styles')
    {{ Html::style('assets/pages/css/select2.min.css') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['route' => 'notification.submit', 'id' => 'send-notifications', 'role' => 'Form']) }}
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                You have some form errors. Please check below.
            </div>

            <div class="alert alert-success display-hide">
                <button class="close" data-close="alert"></button>
                Your form validation is successful!
            </div>

            <div class="form-group">
                <label>{{ trans('admin.title') }}</label>
                <div class="input-icon right {{ $errors->has('en_title') ? 'has-error' : '' }}">
                    <i class="fa fa-info"></i>
                    {{ Form::text('en_title', null, ['class' => 'form-control', 'placeholder' => 'enter title']) }}
                    <span class="help-block">{{ $errors->first('en_title') }}</span>
                </div>
            </div>

            {{--            <div class="form-group">--}}
            {{--                <label>{{ trans('admin.ar_title') }}</label>--}}
            {{--                <div class="input-icon right {{ $errors->has('ar_title') ? 'has-error' : '' }}">--}}
            {{--                    <i class="fa fa-info"></i>--}}
            {{--                    {{ Form::text('ar_title', null, ['class' => 'form-control input-circle', 'placeholder' => 'Arabic Name']) }}--}}
            {{--                    <span class="help-block">{{ $errors->first('ar_title') }}</span>--}}
            {{--                </div>--}}
            {{--            </div>--}}

            <div class="form-group">
                <label>{{ trans('admin.message') }}</label>
                <div class="input-icon right {{ $errors->has('en_message') ? 'has-error' : '' }}">
                    <i class="fa fa-info"></i>
                    {{ Form::textarea('en_message', null, ['class'=>'form-control ' . ($errors->has('en_message') ? 'redborder' : '') ,'title' => trans('lang.en_message'), 'id'=>'en_message', 'rows'=> 2]) }}
                    <span class="help-block">{{ $errors->first('en_message') }}</span>
                </div>
            </div>

            {{--            <div class="form-group">--}}
            {{--                <label>{{ trans('admin.ar_message') }}</label>--}}
            {{--                <div class="input-icon right {{ $errors->has('ar_message') ? 'has-error' : '' }}">--}}
            {{--                    <i class="fa fa-info"></i>--}}
            {{--                    {{ Form::textarea('ar_message', null, ['class'=>'form-control ' . ($errors->has('ar_message') ? 'redborder' : '') ,'title' => trans('lang.ar_message'), 'id'=>'ar_message', 'rows'=> 2]) }}--}}
            {{--                    <span class="help-block">{{ $errors->first('ar_message') }}</span>--}}
            {{--                </div>--}}
            {{--            </div>--}}

            <div class="form-group">
                <label>{{ trans('admin.product') }}</label>
                <div class="input-icon right {{ $errors->has('product_id') ? 'has-error' : '' }}">
                    {{ Form::select('product_id', (new \App\Http\Repositories\ProductRepository())->getProductsList(), null, ['class' => 'product_id form-control' ,'id' => 'product_id','required' => 'required']) }}
                    <span class="help-block">{{ $errors->first('product_id') }}</span>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn blue">{{ trans('admin.send') }}</button>
                <button type="button" onclick="window.history.back()"
                        class="btn default">{{ trans('admin.cancel') }}</button>
            </div>

            @section('page-scripts')
                {{ Html::script('assets/pages/scripts/select2.min.js') }}
                <script>

                    $('.multiple-select').select2({
                        'placeholder': 'Select Colors'
                    });

                    // to resort the DropDown list
                    $("select").on("select2:select", function (evt) {
                        var element = evt.params.data.element;
                        var $element = $(element);
                        $element.detach();
                        $(this).append($element);
                        $(this).trigger("change");
                    });
                    $('select').select2();


                    var the_rules = {
                        en_title: {
                            minlength: 2,
                            required: true
                        },
                        // ar_title: {
                        //     minlength: 2,
                        //     required: true
                        // },
                        en_message: {
                            minlength: 2,
                            required: true
                        },
                        // ar_message: {
                        //     minlength: 2,
                        //     required: true
                        // },
                        product_id: {
                            required: true
                        }
                    };
                    AdminValidation(the_rules, '#send-notifications');
                </script>
            @endsection
            {{ Form::close()  }}
        </div>
    </div>
@endsection
