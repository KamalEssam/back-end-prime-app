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
        <label>{{ trans('admin.name') }}</label>
        <div class="input-icon right {{ $errors->has('en_name') ? 'has-error' : '' }}">
            <i class="fa fa-info"></i>
            {{ Form::text('en_name', null, ['class' => 'form-control input-circle', 'placeholder' => 'Name']) }}
            <span class="help-block">{{ $errors->first('en_name') }}</span>
        </div>
    </div>

{{--    <div class="form-group">--}}
{{--        <label>{{ trans('admin.ar_name') }}</label>--}}
{{--        <div class="input-icon right {{ $errors->has('ar_name') ? 'has-error' : '' }}">--}}
{{--            <i class="fa fa-info"></i>--}}
{{--            {{ Form::text('ar_name', null, ['class' => 'form-control input-circle', 'placeholder' => 'Arabic Name']) }}--}}
{{--            <span class="help-block">{{ $errors->first('ar_name') }}</span>--}}
{{--        </div>--}}
{{--    </div>--}}

</div>
<div class="form-actions">
    <button type="submit" class="btn blue">{{ trans('admin.save') }}</button>
    <button type="button" onclick="window.history.back()" class="btn default">{{ trans('admin.cancel') }}</button>
</div>

@section('page-scripts')
    <script>
        var the_rules = {
            en_name: {
                minlength: 2,
                required: true
            },
            // ar_name: {
            //     minlength: 2,
            //     required: true
            // }
        };
        AdminValidation(the_rules, '#form-add-color');
    </script>
@stop
