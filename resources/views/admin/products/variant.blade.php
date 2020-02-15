<div class="container">
    {{ Form::open(['route' => ['variant.update',$variant->id], 'id' => 'form-edit-variant', 'role' => 'Form' ]) }}
    <div>
        <h3 class="text-left" style="margin-left: 2%;">Variant Color : {{ $variant->color }}</h3>
    </div>
    <div class="form-group col-md-4">
        <input type="number" name="quantity" id="quantity" class="form-control" min="0" max="50000000"
               placeholder="quantity" value="{{ $variant->quantity }}"
               required>
    </div>
    {{  Form::submit('save' , ['class' => 'btn-loon mt-2 btn btn-sm btn-primary btn-update-variant' ]) }}
    {{ Form::close()  }}
</div>

