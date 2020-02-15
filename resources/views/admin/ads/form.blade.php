<div class="alert alert-danger display-hide">
    <button class="close" data-close="alert"></button>
    You have some form errors. Please check below.
</div>

<div class="alert alert-success display-hide">
    <button class="close" data-close="alert"></button>
    Your form validation is successful!
</div>

@if(isset($ad->image))
    <div class="img text-center">
        <img src="{{ $ad->image }}" alt="ad image" style="max-width: 500px;max-height: 300px">
    </div>
@endif

<div class="form-body">
    <div class="form-group">
        <label>{{ trans('admin.image') }}</label>
        <div class="input-icon right {{ $errors->has('image') ? 'has-error' : '' }}">
            <i class="fa fa-image"></i>
            {{ Form::file('image', ['class' => 'form-control input-circle','placeholder'=> trans('admin.image'),!isset($ad) ? 'required' : '']) }}
            <span class="help-block">{{ $errors->first('image') }}</span>
        </div>
    </div>

    <div class="form-group">
        <label>{{ trans('admin.product') }}</label>
        <div class="input-icon right {{ $errors->has('product_id') ? 'has-error' : '' }}">
            {{ Form::select('product_id', (new \App\Http\Repositories\ProductRepository())->getProductsList(), null,[ 'class'=>'form-control chosen-select ' . ($errors->has('color') ? 'redborder' : '')  , 'id'=>'product_id','required' => 'required']) }}
            <span class="help-block">{{ $errors->first('product_id') }}</span>
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
            product_id: {
                required: true,
            },
        };
        AdminValidation(the_rules, '#form-add-ad');
    </script>
@stop
