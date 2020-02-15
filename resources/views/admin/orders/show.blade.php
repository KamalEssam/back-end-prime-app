@extends('layouts.admin.master')

@section('title', trans('admin.orders'))

@section('page-title', trans('admin.orders'))

@section('page-small-title', trans('admin.show_order'))

@section('page-styles')
    {{ Html::style('/assets/global/plugins/cubeportfolio/css/cubeportfolio.css') }}
    {{ Html::style('assets/pages/css/portfolio.min.css') }}
@endsection

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.orders')])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-offset-2 col-md-8 col-sm-12">
            <div class="portlet blue-hoki box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i> {{ ucwords(trans('admin.new_order')) }}
                    </div>
                </div>
                <div class="portlet-body">
                    <h2 class="text-center"> {{ trans('admin.client_info') }} </h2> <br><br>
                    {{-- client name --}}
                    <div class="row static-info">
                        <div class="col-md-5 name"> {{ trans('admin.client_name') }} </div>
                        <div class="col-md-7 value"> {{ $order->name }}</div>
                    </div>

                    {{-- client mobile --}}
                    <div class="row static-info">
                        <div class="col-md-5 name"> {{ trans('admin.client_mobile') }} </div>
                        <div class="col-md-7 value"> {{ $order->mobile }}</div>
                    </div>

                    {{-- client email --}}
                    <div class="row static-info">
                        <div class="col-md-5 name"> {{ trans('admin.client_email') }} </div>
                        <div class="col-md-7 value"> {{ $order->email }}</div>
                    </div>

                    <hr>
                    <h2 class="text-center">{{ ucwords(trans('admin.order_details')) }}</h2> <br><br>


                    <table class="table-bordered" style="width: 100%;height: 100%;">
                        <thead>
                        <tr>
                            <th>{{ trans('admin.name') }}</th>
                            <th>{{ trans('admin.color') }}</th>
                            <th>{{ trans('admin.price') }}</th>
                            <th>{{ trans('admin.quantity') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $total = 0;@endphp
                        @foreach($order_products as $order_product)
                            <tr>
                                <td>
                                    <a href="{{ route('products.show',['io' => $order_product->id]) }}">{{ $order_product->name }}</a>
                                </td>
                                <td>{{ $order_product->color }}</td>
                                <td>{{ $order_product->price }} EGP</td>
                                <td>{{ $order_product->quantity }}</td>
                                @php $total += $order_product->price *  $order_product->quantity @endphp
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>{{ trans('admin.total') }}</b></td>
                            <td><b>{{ $total }}</b></td>
                            @if ($order->is_approved === 0)
                                <td>
                                    <a href="#"
                                       data-id="{{ $order->id }}"
                                       data-status="1"
                                       class="btn btn-sm btn-outline green btn-order" title="Accept Order">
                                        <i class="fa fa-check"></i>
                                    </a>
                                    <a href="#"
                                       data-id="{{ $order->id }}"
                                       data-status="0"
                                       class="btn btn-sm btn-outline red btn-order" title="reject order">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            @endif
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br><br><br>
        </div>
    </div>
@endsection
