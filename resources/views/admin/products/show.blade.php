@extends('layouts.admin.master')

@section('title', trans('admin.products'))

@section('page-title', trans('admin.products'))

@section('page-small-title', trans('admin.show_product'))

@section('page-styles')
    {{ Html::style('/assets/global/plugins/cubeportfolio/css/cubeportfolio.css') }}
    {{ Html::style('assets/pages/css/portfolio.min.css') }}
@endsection

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.products')])
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="portlet blue-hoki box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>{{ $product->{app()->getLocale() .'_name'} }}
                    </div>
                </div>
                <div class="portlet-body">
                    {{--iamges--}}
                    <h2 class="text-left">{{ ucwords(trans('admin.product_images')) }}</h2>
                    <div class="text-left">
                        <img src="{{ $product->image }}" alt="{{ $product->{app()->getLocale() .'_name'} }}"
                             style="max-width: 300px; max-height: 300px; margin: 5px">
                    </div>
                    <br>

                    <h2 class="text-left">{{ ucwords(trans('admin.product_info')) }}</h2> <br><br>

                    {{-- category --}}
                    <div class="row static-info">
                        <div class="col-md-5 name"> {{ trans('admin.category') }} </div>
                        <div class="col-md-7 value"> {{ $product->category[app()->getLocale() . '_name'] }}</div>
                    </div>

                    {{-- price --}}
                    <div class="row static-info">
                        <div class="col-md-5 name"> {{ trans('admin.price') }} </div>
                        <div class="col-md-7 value">
                            {{  $product->price . ' EP' }}
                        </div>
                    </div>

                    <hr>
                    <div class="row static-info">
                        <div class="col-md-5 name"> {{ trans('admin.description') }} </div>
                        <div class="col-md-7 value"> {{ $product->{app()->getLocale() .'_desc'} }}</div>
                    </div>

                </div>
            </div>
            <br><br><br>
        </div>
    </div>
@endsection

@section('page-scripts')
    {{--{{ Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js') }}--}}
    {{--{{ Html::script('assets/pages/scripts/portfolio-2.min.js') }}--}}
@endsection
