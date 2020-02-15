@extends('layouts.admin.master')

@section('title', trans('admin.dashboard'))

@section('page-title', trans('admin.dashboard'))
@section('page-small-title', trans('admin.dashboard'))
@section('page-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css">
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
        @include('includes.admin.components.dashboard-status', ['color' => 'blue', 'number' => \App\Models\product::count(), 'title' => ucfirst(trans('admin.products')), 'href' => route('products.index')])
        @include('includes.admin.components.dashboard-status', ['color' => 'green', 'number' => (new \App\Models\User())->sale()->count(), 'title' => ucfirst(trans('admin.sales')), 'href' => route('sales.index')])
        @include('includes.admin.components.dashboard-status', ['color' => 'purple', 'number' => \App\Models\Order::count(), 'title' => ucfirst(trans('admin.orders')), 'href' => route('orders.index')])
        <div class="clearfix"></div>
        <!-- END DASHBOARD STATS-->
    </div>
    <br><br>
    <div class="row">
        <h2 class="text-center bold">{{ trans('admin.all_orders') }}</h2>
        <div class="col-md-12">
            <div class="col-md-5">
                <select name="months" id="selectYear" class="form-control">
                    @php $currentYear = date('Y'); $currentMonth = date('m'); @endphp
                    @for ($i = 2018; $i <= $currentYear; $i++)
                        <option value="{{$i}}" {{$currentYear == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-5">
                <select name="months" id="selectMonth" class="form-control">
                    @for ($i = 1; $i <= 12; $i++)
                        @php $timestamp = mktime(0, 0, 0, $i);
                                    $label = date('F', $timestamp);
                        @endphp
                        <option
                            value="{{ sprintf('%02d', $i)  }}" {{$currentMonth == $i ? 'selected' : ''}}>{{ $label }}</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2">
                <input type="button" id="AdminChartLines" class="btn btn-primary"
                       value="{{ trans('admin.show-results') }}">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <canvas id="orders"></canvas>
        </div>
    </div>
@stop

@section('page-scripts')
    <script src="/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
    <script>
        $(document).ready(function () {
            const URL = "{{ url('/') }}";

            // registered doctors
            $.ajax({
                url: URL + '/statistics/orders',
                type: 'GET',
            }).done(function (orders) {
                if (orders.status == true) {
                    AdminLinesChart(orders);
                }
            });


            function AdminLinesChart(data, msg = 'total orders') {
                var ctx3 = document.getElementById("orders").getContext('2d');
                ctx3.height = 800;
                new Chart(ctx3, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                label: msg,
                                fillColor: "rgba(78,164,219,1)",
                                strokeColor: "rgba(78,164,219,1)",
                                pointColor: "rgba(78,164,219,1)",
                                pointStrokeColor: "#4EA4DB",
                                pointHighlightFill: "#4EA4DB",
                                pointHighlightStroke: "rgba(78,164,219,1)",
                                backgroundColor: "rgba(78,164,219,0.5)",
                                data: data.data
                            }
                        ]
                    }
                });
            }

            $('#AdminChartLines').on('click', function () {
                updateLineChart();
            });

            function updateLineChart() {
                let year = $('#selectYear').val();
                let month = $('#selectMonth').val();
                let type = $('#selectType').val();

                $.ajax({
                    url: URL + '/statistics/orders',
                    type: 'GET',
                    data: {year: year, month: month, type: type}
                }).done(function (doctors) {
                    if (doctors.status == true) {
                        AdminLinesChart(doctors, 'orders');
                    }
                });
            }
        });
    </script>
@stop
