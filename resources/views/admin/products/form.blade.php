<div class="alert alert-danger display-hide">
    <button class="close" data-close="alert"></button>
    You have some form errors. Please check below.
</div>

<div class="alert alert-success display-hide">
    <button class="close" data-close="alert"></button>
    Your form validation is successful!
</div>

@if(isset($product->image))
    <div class="img text-center">
        <img src="{{ $product->image }}" alt="{{ $product->name }}" style="max-width: 500px;max-height: 300px">
    </div>
@endif

<div class="form-group">
    <label>{{ trans('admin.image') }}</label>
    <div class="input-icon right {{ $errors->has('image') ? 'has-error' : '' }}">
        <i class="fa fa-image"></i>
        {{ Form::file('image', ['class' => 'form-control input-circle', isset($product) ? '' : 'required','placeholder'=> trans('admin.image')]) }}
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

{{--<div class="form-group">--}}
{{--    <label>{{ trans('admin.ar_name') }}</label>--}}
{{--    <div class="input-icon right {{ $errors->has('ar_name') ? 'has-error' : '' }}">--}}
{{--        <i class="fa fa-info"></i>--}}
{{--        {{ Form::text('ar_name', null, ['class' => 'form-control input-circle', 'placeholder' => 'Arabic Name']) }}--}}
{{--        <span class="help-block">{{ $errors->first('ar_name') }}</span>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="form-group">
    <label>{{ trans('admin.description') }}</label>
    <div class="input-icon right {{ $errors->has('en_desc') ? 'has-error' : '' }}">
        <i class="fa fa-info"></i>
        {{ Form::textarea('en_desc', null, ['class'=>'form-control ' . ($errors->has('en_desc') ? 'redborder' : '') ,'title' => trans('lang.en_desc'), 'id'=>'en_desc', 'rows'=> 2]) }}
        <span class="help-block">{{ $errors->first('en_desc') }}</span>
    </div>
</div>

{{--<div class="form-group">--}}
{{--    <label>{{ trans('admin.ar_desc') }}</label>--}}
{{--    <div class="input-icon right {{ $errors->has('ar_desc') ? 'has-error' : '' }}">--}}
{{--        <i class="fa fa-info"></i>--}}
{{--        {{ Form::textarea('ar_desc', null, ['class'=>'form-control ' . ($errors->has('ar_desc') ? 'redborder' : '') ,'title' => trans('lang.ar_desc'), 'id'=>'ar_desc', 'rows'=> 2]) }}--}}
{{--        <span class="help-block">{{ $errors->first('ar_desc') }}</span>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="form-group">
    <label>{{ trans('admin.unique_id') }}</label>
    <div class="input-icon right {{ $errors->has('unique_id') ? 'has-error' : '' }}">
        <i class="fa fa-info"></i>
        {{ Form::text('unique_id', null, ['class' => 'form-control input-circle', 'placeholder' => 'code of product']) }}
        <span class="help-block">{{ $errors->first('unique_id') }}</span>
    </div>
</div>

<div class="form-group">
    <label>{{ trans('admin.category') }}</label>
    <div class="input-icon right {{ $errors->has('category_id') ? 'has-error' : '' }}">
        {{ Form::select('category_id', (new \App\Http\Repositories\CategoryRepository())->getArrayOfCategories(), null, ['class' => 'category_id form-control' ,'id' => 'category_id','required' => 'required', 'placeholder' => trans('admin.select_category')]) }}
        <span class="help-block">{{ $errors->first('category_id') }}</span>
    </div>
</div>

{{--<div class="form-group">--}}
{{--    <label>{{ trans('admin.colors') }}</label>--}}
{{--    <div class="input-icon right {{ $errors->has('colors') ? 'has-error' : '' }}">--}}
{{--        <i class="fa fa-info"></i>--}}
{{--        {{ Form::select('colors[]', (new \App\Http\Repositories\ColorRepository())->getColorsArray(), null,  ['multiple' => 'multiple','class'=>'form-control colors multiple-select ', 'id'=>'colors']) }}--}}
{{--        <span class="help-block">{{ $errors->first('colors') }}</span>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="form-group">
    <label>{{ trans('admin.price') }}</label>
    <div class="input-icon right {{ $errors->has('price') ? 'has-error' : '' }}">
        <i class="fa fa-money"></i>
        {{ Form::number('price', null, ['class' => 'form-control input-circle','min' => 0, 'placeholder' => 'enter price']) }}
        <span class="help-block">{{ $errors->first('price') }}</span>
    </div>
</div>

{{--<div class="form-group">--}}
{{--    <label>{{ trans('admin.quantity') }}</label>--}}
{{--    <div class="input-icon right {{ $errors->has('quantity') ? 'has-error' : '' }}">--}}
{{--        <i class="fa fa-money"></i>--}}
{{--        {{ Form::number('quantity', null, ['class' => 'form-control input-circle','min' => 0, 'placeholder' => 'enter quantity']) }}--}}
{{--        <span class="help-block">{{ $errors->first('quantity') }}</span>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="form-actions">
    <button type="submit" class="btn blue">{{ trans('admin.save') }}</button>
    <button type="button" onclick="window.history.back()" class="btn default">{{ trans('admin.cancel') }}</button>
</div>

@section('page-scripts')
    {{ Html::script('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}

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
            en_name: {
                minlength: 2,
                required: true
            },
            // ar_name: {
            //     minlength: 2,
            //     required: true
            // },
            en_desc: {
                minlength: 2,
                required: true
            },
            // ar_desc: {
            //     minlength: 2,
            //     required: true
            // },
            category_id: {
                required: true
            },
            // quantity: {
            //     required: true,
            //     min: 1
            // },
            unique_id: {
                required: true,
            }
        };
        AdminValidation(the_rules, '#form-add-product');
    </script>
@stop
