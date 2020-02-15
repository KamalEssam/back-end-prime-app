@extends('layouts.admin.master')

@section('title', trans('admin.dashboard'))

@section('page-title', trans('admin.dashboard'))
@section('page-small-title', trans('admin.dashboard'))
@section('page-styles')
@stop

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.dashboard')])
@stop

@section('content')
    <!-- BEGIN DASHBOARD STATS-->
    <div class="row">
        @include('includes.admin.components.dashboard-status', ['color' => 'red', 'number' => \App\Models\Category::count() , 'title' => ucfirst(trans('admin.categories')), 'href' => route('categories.index')])
        @include('includes.admin.components.dashboard-status', ['color' => 'blue', 'number' => \App\Models\Product::count(), 'title' => ucfirst(trans('admin.products')), 'href' => route('products.index')])
        @include('includes.admin.components.dashboard-status', ['color' => 'purple', 'number' => \App\Models\Branch::count(), 'title' => ucfirst(trans('admin.branches')), 'href' => route('branches.index')])
        @include('includes.admin.components.dashboard-status', ['color' => 'green', 'number' => \App\Models\Order::count(), 'title' => ucfirst(trans('admin.orders')), 'href' => route('orders.index')])
        <div class="clearfix"></div>
        <!-- END DASHBOARD STATS-->
    </div>
@stop

@section('page-scripts')
    <script src="/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
@stop