@extends('layouts.admin.master')

@section('title', trans('admin.orders'))

@section('page-title', trans('admin.orders'))

@section('page-small-title', trans('admin.all_orders'))

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.orders')])
@endsection

@section('page-styles')
    <style>
        .new-order {
            margin-left: 10px;
            background-color: #f00;
            color: #fff;
            padding: 8px;
            border-radius: 50% !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <div class="table-toolbar">
                    </div>
                    <table class="table table-striped table-bordered"
                           id="sample_1_2">
                        <thead>
                        <tr>
                            <th class="text-center hidden"></th>
                            <th class="text-center"> {{ trans('admin.client_name') }}</th>
                            <th class="text-center"> {{ trans('admin.client_mobile') }}</th>
                            <th class="text-center"> {{ trans('admin.client_email') }}</th>
                            <th class="text-center"> {{ trans('admin.is_approved') }}</th>
                            <th class="text-center"> {{ trans('admin.isSale') }}</th>
                            <th class="text-center"> {{ trans('admin.sending_time') }}</th>
                            <th class="text-center"> {{ trans('admin.controls') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr class="odd gradeX">
                                <td class="hidden"></td>
                                <td class="text-center"> {{ $order->name }} <span
                                        class="{{ ($order['status'] == 0) ? 'dot':''}}"> </span></td>
                                <td class="text-center"> {{ $order->mobile }}</td>
                                <td class="text-center"> {{ $order->email }}</td>
                                <td class="text-center">
                                    @switch($order->is_approved)
                                        @case(0)
                                        <span class="pending">pending</span>
                                        @break
                                        @case(1)
                                        <span class="approved">approved</span>
                                        @break
                                        @case(2)
                                        <span class="rejected">rejected</span>
                                        @break
                                        @default
                                    @endswitch
                                </td>
                                <td class="text-center"> {{ $order->is_sale == 1 ? 'Sale' : 'Client' }}</td>
                                <td class="text-center"> {{ $order->created_at }}</td>
                                <td class="text-center">
                                    <div class="margin-bottom-5">
                                        <a href="{{ route('orders.show', $order->id) }}"
                                           class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                                            <i class="fa fa-eye"></i> {{ ucfirst(trans('admin.show')) }}
                                        </a>

                                        @if ($order->is_approved === 0)
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
                                        @endif
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
@stop
