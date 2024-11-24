<div class="modal-header modal-colored-header bg-primary d-flex align-items-center rounded-top">
    <h5 class="modal-title  text-white ">Modificar Criterio</h5>
    <button type="button" class="btn-close  text-white " data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>

{!! Form::open(['route' => ['criterios.update', $criterio->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
<div class="modal-body">
    <div class="add-contact-box">
        <div class="add-contact-content">

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        {{ Form::label('tipo', 'Tipo', ['class' => 'form-label']) }}
                        <div>
                            {{ Form::select('tipo', $tipos, $criterio->competencia->tipo_competencia_id, ['class' => 'form-control select2 tipoeditar']) }}
                        </div>
                    </div>
                    <div class="mb-3">
                        {{ Form::label('competencia', 'Competencia', ['class' => 'form-label']) }}
                        <div class="mb-3">
                            {{ Form::select('competencia', [$criterio->competencia->id => $criterio->competencia->nombre], $criterio->competencia->id, ['class' => 'select2 competenciaeditar', 'placeholder' => 'Seleccionar']) }}
                        </div>
                    </div>
                    <div class="mb-3">
                        {{ Form::label('llave', 'Llave', ['class' => 'form-label']) }}
                        {{ Form::text('llave', $criterio->llave, ['class' => 'form-control']) }}
                    </div>
                    <div class="mb-3">
                        {{ Form::label('criterio', 'Nombre', ['class' => 'form-label']) }}
                        {{ Form::textarea('criterio', $criterio->criterio, ['class' => 'form-control', 'rows' => 2]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button id="btn-add" type="submit" class="btn btn-success rounded-pill px-4">
        Guardar
    </button>
    <button type="button" class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal">
        Cancelar
    </button>
</div>
{!! Form::close() !!}