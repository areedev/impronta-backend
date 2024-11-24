<div class="card seccion">
    <div class="card-header text-bg-primary">
        <h4 class="mb-0 text-white fs-5">Mover para ordenar</h4>
      </div>
    <div class="row card-body">
        <div class="col-md-12">
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    {{ Form::label('nombre_seccion[' . $seccion->id . ']', 'Nombre de la sección', ['class' => 'form-label']) }}
                    <button type="button"
                        class="mb-3 justify-content-center btn btn-sm mb-1 btn-rounded btn-outline-danger d-flex align-items-center eliminar-seccion"
                        data-action="{{ route('perfilevaluaciones.eliminarseccion') }}" data-seccion="{{ $seccion->id }}">
                        <i class="ti ti-minus fs-4 me-2"></i>
                        Eliminar Sección
                    </button>
                </div>
                {{ Form::text('nombre_seccion[' . $seccion->id . ']', $seccion->nombre, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-md-12 seccion-items">
            @foreach ($seccion->items as $item)
                <div class="row d-flex item-seccion">
                    <div class="col-md-2">
                        {{ Form::label('item[' . $item->seccion_id . '][' . $item->id . ']', 'Item', ['class' => 'form-label']) }}
                        <div class="mb-3">
                            {{ Form::select('item[' . $item->seccion_id . '][' . $item->id . ']', $items, $item->item_id, ['class' => 'select2', 'placeholder' => 'Seleccionar']) }}
                        </div>
                    </div>
                    <div class="col-md-9">
                        {{ Form::label('descripcion[' . $item->seccion_id . '][]', 'Descripción', ['class' => 'form-label']) }}
                        {{ Form::textarea('descripcion[' . $item->seccion_id . '][' . $item->id . ']', $item->descripcion, ['class' => 'form-control', 'rows' => 1]) }}
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
            @endforeach
        </div>
        <div class="col-md-12">
            <button type="button"
                class="justify-content-center w-100 btn mb-1 btn-rounded btn-outline-dark d-flex align-items-center nueva-columna"
                data-action="{{ route('perfilevaluaciones.columna') }}" data-perfil="{{ $seccion->perfil_evaluacion_id }}"
                data-seccion="{{ $seccion->id }}">
                <i class="ti ti-plus fs-4 me-2"></i>
                Agregar Columna
            </button>
        </div>
    </div>
</div>