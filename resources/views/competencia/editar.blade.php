<div class="modal-header modal-colored-header bg-primary d-flex align-items-center rounded-top">
    <h5 class="modal-title  text-white ">Modificar Faena</h5>
    <button type="button" class="btn-close  text-white " data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>

{!! Form::open(['route' => ['competencias.update', $competencia->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
<div class="modal-body">
    <div class="add-contact-box">
        <div class="add-contact-content">

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        {{ Form::label('tipo', 'Tipo', ['class' => 'form-label']) }}
                        <div>
                            {{ Form::select('tipo', $tipos, $competencia->tipo_competencia_id, ['class' => 'form-control select2']) }}
                        </div>
                    </div>
                    <div class="mb-3">
                        {{ Form::label('llave', 'Llave', ['class' => 'form-label']) }}
                        {{ Form::text('llave', $competencia->llave, ['class' => 'form-control']) }}
                    </div>
                    <div class="mb-3">
                        {{ Form::label('nombre', 'Nombre', ['class' => 'form-label']) }}
                        {{ Form::textarea('nombre', $competencia->nombre, ['class' => 'form-control', 'rows' => 2]) }}
                    </div>
                    <div class="mb-3">
                        {{ Form::label('definicion', 'Definición', ['class' => 'form-label']) }}
                        {{ Form::textarea('definicion', $competencia->definicion, ['class' => 'form-control', 'rows' => 2]) }}
                    </div>
                    <div class="mb-3">
                        {{ Form::label('proyecto', 'Proyecto', ['class' => 'form-label']) }}
                        {{ Form::text('proyecto', $competencia->proyecto, ['class' => 'form-control']) }}
                    </div>
                    <div class="mb-3">
                        {{ Form::label('alcance', 'Alcance', ['class' => 'form-label']) }}
                        {{ Form::text('alcance', $competencia->alcance, ['class' => 'form-control']) }}
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