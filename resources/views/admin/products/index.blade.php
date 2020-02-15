@extends('layouts.admin.master')

@section('title', trans('admin.products'))

@section('page-title', trans('admin.products'))

@section('page-small-title', $category === null ? trans('admin.all_products') : $category['en_name'])

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.products')])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{ route('products.create') }}" id="sample_editable_1_2_new"
                                       class="btn sbold green">  {{ ucwords(trans('admin.add_new')) }}
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    {{--                                    <a href="#" data-iziModal-open="#modal_import"--}}
                                    {{--                                       class="btn sbold yellow" style="margin-left: 5px">{{ trans('lang.import') }}</a>--}}
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover"
                           id="sample_4">
                        <thead>
                        <tr>
                            <th class="text-center"> {{ trans('admin.image') }}</th>
                            <th class="text-center"> {{ trans('admin.name') }}</th>
                            <th class="text-center"> {{ trans('admin.unique_id') }}</th>
                            <th class="text-center"> {{ trans('admin.category') }}</th>
                            <th class="text-center">{{ trans('admin.price') }}</th>
                            <th class="text-center">{{ trans('admin.variants') }}</th>
                            <th class="text-center"> {{ trans('admin.controls') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr class="odd gradeX">
                                <td class="text-center">
                                    <img
                                        src="{{$product->image }}"
                                        alt="{{ $product[app()->getLocale() . '_name'] }}"
                                        width="80" height="60">
                                </td>
                                <td class="text-center"> {{ $product->{app()->getLocale() . '_name'} }}</td>
                                <td class="text-center"> {{ $product->unique_id }}</td>
                                <td class="text-center"> {{ $product->category[app()->getLocale() . '_name'] }}</td>
                                <td class="text-center"> {{ $product->price }} EGP</td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-sm show-variants"
                                            data-id="{{ $product->id }}"
                                            id="product_{{$product->id}}"
                                            data-title="variants"
                                            data-iziModal-open="#modal-area"> {{ trans('admin.variants') }}</button>
                                </td>

                                <td class="text-center">
                                    <div class="margin-bottom-5">
                                        <a class="btn btn-sm blue btn-outline filter-submit margin-bottom"
                                           href="{{ route('products.add_variant',['product_id' => $product->id]) }}">
                                            <i class="fa fa-plus"></i> {{ ucwords(trans('admin.add_variant')) }}
                                        </a>

                                        <a href="{{ route('products.edit', $product->id) }}"
                                           class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                            <i class="fa fa-edit"></i> {{ ucfirst(trans('admin.edit')) }}
                                        </a>

                                        <a class="btn btn-sm red btn-outline filter-cancel delete-btn"
                                           data-id="{{ $product->id }}"
                                           data-link="{{ route('products.destroy', $product->id) }}" data-type="DELETE">
                                            <i class="fa fa-trash"></i> {{ ucfirst(trans('admin.delete')) }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="modal_import" data-iziModal-title="{{ trans('lang.import') }}"
         data-iziModal-subtitle="{{ trans('lang.import-products') }}" data-iziModal-icon="icon-home">
        <div class="row" style="padding: 40px">
            <form id="modal-form" action="{{ route('products.import') }}" method="POST"
                  enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group col-md-12">
                    <div class="row">
                        <div class="col-md-12 label-form">
                            <label for="leads">{{ trans('lang.products') }}<span class="astric">*</span></label>
                        </div>
                        <div class="col-md-12 form-input">
                            {{ Form::file('products', NULL, ['class'=>'form-control ' . ($errors->has('leads') ? 'redborder' : ''),'required'=>'required' , 'id'=>'products']) }}
                            <small class="text-danger">{{ $errors->first('products') }}</small>
                            <br>
                            <p class="help-block">download sample <a
                                    href="{{ asset('assets/samples/insurance_sample.xlsx') }}">download</a></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input type="submit" value="{{ trans('lang.save') }}"
                           class="btn-modal-form-submit btn btn-primary btn-lg pull-right" id="submit-patient">
                </div>
            </form>
        </div>
    </div>
    @include('admin.products.modals')
@stop

@section('page-scripts')
    <script>

        let product = 0;
        URL = "{{ url('/') }}";
        // Trigger modal according to form to load category_features
        $(document).on('click', '.show-variants', function (e) {
            var id = $(this).data('id');

            // save the current product
            product = id;

            var title = $('.iziModal-header-title');
            var subtitle = $('.iziModal-header-subtitle');
            title.text('variants');
            subtitle.text('variants list');
            $('.form-area').load(URL + '/variants/' + id + '/loader');
            return false;
        });

        $(document).on('click', '.edit-variant', function (e) {
            // $('#modal-area').iziModal('close');
            var id = $(this).data('id');
            var title = $('.iziModal-header-title');
            var subtitle = $('.iziModal-header-subtitle');
            title.text('variants');
            subtitle.text('variants');
            $('.form-edit').load(URL + '/variant/' + id + '/loader');
        });


        // the trigger ajax
        $(document).on('click', '.btn-update-variant', function (e) {
            var form = $('#form-edit-variant');
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: form.serialize(),
                dataType: 'json',
                success: function (data) {
                    $('#product_' + product).click();
                }
            });
        });

    </script>
@stop
