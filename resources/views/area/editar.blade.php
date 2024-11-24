<div class="modal-header modal-colored-header bg-primary d-flex align-items-center rounded-top">
    <h5 class="modal-title  text-white ">Modificar Area</h5>
    <button type="button" class="btn-close  text-white " data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>

{!! Form::open(['route' => ['areas.update', $area->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
<div class="modal-body">
    <div class="add-contact-box">
        <div class="add-contact-content">

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        {{ Form::label('nombre', 'Nombre', ['class' => 'form-label']) }}
                        {{ Form::text('nombre', $area->nombre, ['class' => 'form-control']) }}
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