@extends('layouts.admin.master')

@section('title', trans('admin.categories'))

@section('page-title', trans('admin.categories'))

@section('page-small-title', trans('admin.all_categories'))

@section('breadcrumb')
    @include('includes.admin.components.breadcrumb', ['tree' => [
        ['page' => trans('admin.home'), 'href' => '/home'],
    ], 'current' => trans('admin.categories')])
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="btn-group">
                            <a href="{{ route('categories.create') }}" id="sample_editable_1_2_new"
                               class="btn sbold green"> {{ ucwords(trans('admin.add_new')) }}
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered"
                           id="sample_1_2">
                        <thead>
                        <tr>
                            <th class="hidden"></th>
                            <th class="text-center"> {{ trans('admin.image') }}</th>
                            <th class="text-center"> {{ trans('admin.name') }}</th>
                            <th class="text-center"> {{ trans('admin.orders') }}</th>
                            <th class="text-center"> {{ trans('admin.controls') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr class="odd gradeX">
                                <th class="hidden"></th>
                                <td class="text-center">
                                    <img src="{{ $category->image }}"
                                         alt="{{ $category[app()->getLocale() . '_name'] }}"
                                         width="70" height="60">
                                </td>

                                <td class="text-center">
                                    {{ $category[app()->getLocale() . '_name'] }}
                                </td>

                                <td>
                                    @if(!$loop->first)
                                        <a href="/categories/{{$category->id}}/true"
                                           class="btn btn-sm green margin-bottom">
                                            <i class="fa fa-angle-up" style="font-size: 22px;font-weight: bold"></i>
                                        </a>                                    @endif

                                    @if(!$loop->last)
                                        <a href="/categories/{{$category->id}}/false"
                                           class="btn btn-sm red filter-cancel">
                                            <i class="fa fa-angle-down" style="font-size: 22px;font-weight: bold"></i>
                                        </a>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="margin-bottom-5">

                                        <a href="{{ route('products.index') . '?category=' . $category->id }}"
                                           class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                                            <i class="fa fa-files-o"></i> {{ ucfirst(trans('admin.products')) }}
                                        </a>

                                        {{-- edit category --}}
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                           class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                            <i class="fa fa-edit"></i> {{ ucfirst(trans('admin.edit')) }}
                                        </a>
                                        {{-- delete category --}}
                                        <a class="btn btn-sm red btn-outline filter-cancel delete-btn"
                                           data-id="{{ $category->id }}"
                                           data-link="{{ route('categories.destroy', $category->id) }}"
                                           data-type="DELETE">
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
@stop
