<div class="alert alert-danger display-hide">
    <button class="close" data-close="alert"></button>
    You have some form errors. Please check below.
</div>

<div class="alert alert-success display-hide">
    <button class="close" data-close="alert"></button>
    Your form validation is successful!
</div>

@if(isset($category->image))
    <div class="img text-center">
        <img src="{{ $category->image }}" alt="{{ $category->name }}" style="max-width: 500px;max-height: 300px">
    </div>
@endif
<div class="form-body">


    <div class="form-group">
        <label>{{ trans('admin.image') }}</label>
        <div class="input-icon right {{ $errors->has('image') ? 'has-error' : '' }}">
            <i class="fa fa-image"></i>
            {{ Form::file('image', ['class' => 'form-control input-circle',isset($category) ? '' : 'required','placeholder'=> trans('admin.image')]) }}
            <span class="help-block">{{ $errors->first('image') }}</span>
        </div>
    </div>


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

    <div class="form-group">
        <div>
            <label>{{ trans('admin.is_visible') }}</label>
        </div>
        <div class="input-icon right {{ $errors->has('is_visible') ? 'has-error' : '' }}">
            <label class="switch">
                {{ Form::checkbox('is_visible', 1 ,isset($category->is_visible) ?  ($category->is_visible == 1 ) : true  , ['class'=>'no-margin'])  }}
                <span class="slider round help-block"></span>
            </label> <span class="help-block">{{ $errors->first('is_visible') }}</span>
        </div>
    </div>

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
            // },
            // image: {
            //     required: true,
            // },
        };
        AdminValidation(the_rules, '#form-add-category');
    </script>
@stop
