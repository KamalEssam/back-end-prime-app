@extends('layouts.admin.master')

@section('title', trans('admin.colors'))

@section('page-title', trans('admin.colors'))

@section('page-small-title', trans('admin.all_colors'))

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.colors')])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="btn-group">
                            <a href="{{ route('colors.create') }}" id="sample_editable_1_2_new"
                               class="btn sbold green"> {{ ucwords(trans('admin.add_new')) }}
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column"
                           id="sample_4">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center"> {{ trans('admin.name') }}</th>
                            <th class="text-center"> {{ trans('admin.controls') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($colors as $color)
                            <tr class="odd gradeX">

                                <td class="text-center">
                                    {{ ++$loop->index }}
                                </td>

                                <td class="text-center">
                                    {{ $color[app()->getLocale() . '_name'] }}
                                </td>

                                <td class="text-center">
                                    <div class="margin-bottom-5">
                                        {{-- edit color --}}
                                        <a href="{{ route('colors.edit', $color->id) }}"
                                           class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                            <i class="fa fa-edit"></i> {{ ucfirst(trans('admin.edit')) }}
                                        </a>
                                        {{-- delete color --}}
{{--                                        <a class="btn btn-sm red btn-outline filter-cancel delete-btn"--}}
{{--                                           data-id="{{ $color->id }}"--}}
{{--                                           data-link="{{ route('colors.destroy', $color->id) }}"--}}
{{--                                           data-type="DELETE">--}}
{{--                                            <i class="fa fa-trash"></i> {{ ucfirst(trans('admin.delete')) }}--}}
{{--                                        </a>--}}
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

