@extends('layouts.admin.master')
@section('title', trans('admin.about_us'))
@section('page-title', trans('admin.about_us'))
@section('page-small-title', trans('admin.about_us'))
@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.about_us')])
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    {{ Form::open(['route' => 'user.post_about_us', 'id' => 'about_us', 'role' => 'Form']) }}

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
                            <label>{{ trans('admin.en_about_us') }}</label>
                            <div class="input-icon right {{ $errors->has('en_about_us') ? 'has-error' : '' }}">
                                {{ Form::textarea('en_about_us',\App\Models\AboutUs::first()->en_about_us ?? '', ['class' => 'form-control input-circle', 'placeholder' => 'english about us']) }}
                                <span class="help-block">{{ $errors->first('en_about_us') }}</span>
                            </div>
                        </div>

{{--                        <div class="form-group">--}}
{{--                            <label>{{ trans('admin.ar_about_us') }}</label>--}}
{{--                            <div class="input-icon right {{ $errors->has('en_about_us') ? 'has-error' : '' }}">--}}
{{--                                {{ Form::textarea('ar_about_us',\App\Models\AboutUs::first()->ar_about_us ?? '', ['class' => 'form-control input-circle', 'placeholder' => 'arabic about us']) }}--}}
{{--                                <span class="help-block">{{ $errors->first('ar_about_us') }}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn blue">{{ trans('admin.save') }}</button>
                        <button type="button" onclick="window.history.back()"
                                class="btn default">{{ trans('admin.cancel') }}</button>
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
            },
            // ar_about_us: {
            //     required: true,
            // }
        };
        AdminValidation(the_rules, '#about_us');
    </script>
@stop
