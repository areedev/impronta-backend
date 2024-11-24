<div class="row d-flex item-seccion">
    <div class="col-md-2">
        {{ Form::label('tipo[' . $item->seccion_id . '][' . $item->id . ']', 'Tipo', ['class' => 'form-label']) }}
        <div class="mb-2">
            {{ Form::select('tipo[' . $item->seccion_id . '][' . $item->id . ']', $tipos, null, ['class' => 'select2 tipo', 'placeholder' => 'Seleccionar', 'data-id' => $item->id]) }}
        </div>
    </div>
    <div class="col-md-3">
        {{ Form::label('competencia[' . $item->seccion_id . '][' . $item->id . ']', 'Competencia', ['class' => 'form-label']) }}
        <div class="mb-3">
            {{ Form::select('competencia[' . $item->seccion_id . '][' . $item->id . ']', ['' => ''], null, ['class' => 'select2 competencia', 'placeholder' => 'Seleccionar', 'competencia-id' => $item->id]) }}
        </div>
    </div>
    <div class="col-md-6">
        {{ Form::label('descripcion[' . $item->seccion_id . '][' . $item->id . ']', 'Descripción', ['class' => 'form-label']) }}
        {{ Form::textarea('descripcion[' . $item->seccion_id . '][' . $item->id . ']', null, ['class' => 'form-control', 'disabled', 'rows' => 1, 'descripcion-id' => $item->id]) }}
    </div>
    <div class="col-md-1 align-self-center">
        <button type="button"
            class="justify-content-center btn btn-sm mb-1 btn-rounded btn-outline-danger d-flex align-items-center eliminar-item"
            data-item="{{ $item->id }}"
            data-action="{{ route('perfilevaluaciones.eliminarcolumna') }}">
            <i class="ti ti-minus fs-4"></i>
        </button>
    </div>
</div>
