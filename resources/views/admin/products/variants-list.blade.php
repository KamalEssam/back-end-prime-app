@if(count($variants) > 0)
    <table class="table-bordered" style="width: 100%;height: 100%;">
        <thead>
        <tr>
            <td class="text-center bold">color</td>
            <td class="text-center bold">quantity</td>
            <td class="text-center bold">controls</td>
        </tr>
        </thead>
        <tbody>
        @foreach($variants as $variant)
            <tr>
                <td class="text-center">{{ $variant->color }}</td>
                <td class="text-center">{{ $variant->quantity }}</td>
                <td class="text-center">

                    <a class="btn btn-sm blue btn-outline edit-variant"
                       data-id="{{ $variant->id }}"
                       data-title="variant"
                       data-iziModal-open="#modal-edit"
                       data-link="{{ route('variant.update', $variant->id) }}">
                        <i class="fa fa-pencil"></i> {{ ucfirst(trans('admin.edit')) }}
                    </a>

                    <a class="btn btn-sm red btn-outline filter-cancel delete-btn-no-refresh"
                       data-id="{{ $variant->id }}"
                       data-link="{{ route('variant.destroy', $variant->id) }}"
                       data-type="DELETE">
                        <i class="fa fa-trash"></i> {{ ucfirst(trans('admin.delete')) }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p class="text-center">No Variants Yet </p>
@endif
