<div class="alert alert-danger display-hide">
    <button class="close" data-close="alert"></button>
    You have some form errors. Please check below.
</div>

<div class="alert alert-success display-hide">
    <button class="close" data-close="alert"></button>
    Your form validation is successful!
</div>

<div class="form-group">
    <label>{{ trans('admin.name') }}</label>
    <div class="input-icon right {{ $errors->has('name') ? 'has-error' : '' }}">
        <i class="fa fa-info"></i>
        {{ Form::text('name', null, ['class' => 'form-control input-circle','id' => 'name','required', 'placeholder' => trans('admin.name')]) }}
        <span class="help-block">{{ $errors->first('name') }}</span>
    </div>
</div>

<div class="form-group">
    <label>{{ trans('admin.email') }}</label>
    <div class="input-icon right {{ $errors->has('email') ? 'has-error' : '' }}">
        <i class="fa fa-info"></i>
        {{ Form::email('email', null, ['class' => 'form-control input-circle','id' => 'email','required', 'placeholder' => trans('admin.email')]) }}
        <span class="help-block">{{ $errors->first('email') }}</span>
    </div>
</div>

<div class="form-group">
    <label>{{ trans('admin.mobile') }}</label>
    <div class="input-icon right {{ $errors->has('mobile') ? 'has-error' : '' }}">
        <i class="fa fa-info"></i>
        {{ Form::text('mobile', null, ['class' => 'form-control input-circle','id' => 'mobile','required', 'placeholder' => trans('admin.mobile')]) }}
        <span class="help-block">{{ $errors->first('mobile') }}</span>
    </div>
</div>

<div class="form-actions">
    <button type="submit" class="btn blue">{{ trans('admin.save') }}</button>
    <button type="button" onclick="window.history.back()" class="btn default">{{ trans('admin.cancel') }}</button>
</div>

@section('page-scripts')
    {{ Html::script('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}
    <script>
        var the_rules = {
            name: {
                required: true
            },
            email: {
                required: true,
            },
            mobile: {
                required: true,
            }
        };
        AdminValidation(the_rules, '#form-edit-sale');
    </script>
@stop
