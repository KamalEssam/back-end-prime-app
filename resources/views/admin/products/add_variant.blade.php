@extends('layouts.admin.master')
@section('title', trans('admin.products'))
@section('page-title', trans('admin.product'))
@section('page-small-title', trans('admin.add_variant'))

@section('page-styles')
    {{ Html::style('assets/apps/css/chosen.min.css') }}
@endsection

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.products')])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="form">
                {{ Form::open(['route' => 'products.store_variants', 'id' => 'form-add-product', 'role' => 'Form' ]) }}
                {{ Form::hidden('product_id',$product_id) }}
                <div class="fields" id="other">
                    <div class="add-new-service">
                        <div class="form-group col-md-5" style="padding-left: 0px;">
                            {{ Form::select('color[]', (new \App\Http\Repositories\ColorRepository())->getColorsArray(), null,[ 'class'=>'form-control' . ($errors->has('color') ? 'redborder' : '')  , 'id'=>'color[]','required' => 'required']) }}
                            <small class="text-danger">{{ $errors->first('color[]') }}</small>
                        </div>
                        <div class="form-group col-md-5">
                            <input type="number" name="quantity[]" id="quantity" class="form-control"
                                   placeholder="quantity"
                                   min="0" max="50000000"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-bottom: 30px">
                        <a class="btn btn-primary btn-sm add-other"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                {{  Form::submit('save' , ['class' => 'btn-loon mt-2 btn btn-md btn-primary pull-right' ]) }}
                {{ Form::close()  }}
            </div>
        </div>
    </div>

@endsection

@push('scripts-stack')
    {{ Html::script('assets/apps/scripts/chosen.jquery.min.js') }}
    <script>
        $('.chosen-select').chosen();

        $('.add-other').click(function () {
            // var oth = $('.add-new-service').html();
            let final = "<div>" +
                "<div class=\"form-group col-md-5\" style=\"padding-left: 0px;\">\n" +
                '            {{ Form::select('color[]',(new \App\Http\Repositories\ColorRepository())->getColorsArray(), null,[ 'class'=>'form-control' . ($errors->has('color') ? 'redborder' : '')  , 'id'=>'color[]','required' => 'required']) }}\n' +
                "            <small class=\"text-danger\">{{ $errors->first('color[]') }}</small>\n" +
                "        </div>" +
                "    <div class=\"form-group col-md-5\">\n" +
                "            <input type=\"number\" name=\"quantity[]\" id=\"quantity\" class=\"form-control\" placeholder=\"quantity\" min=\"0\"  required>\n" +
                "        </div>\n"
                + "<div class='col-md-2'><a class='btn btn-danger btn-sm del-other' ><i class='fa fa-trash'></i></a>" +
                "</div>";
            $('#other').append(final);
            $(".chosen-select").chosen('');
        });
        $(document).on('click', '.del-other', function () {
            $(this).parent().parent().html('');
        });
    </script>
@endpush
