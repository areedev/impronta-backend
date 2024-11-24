<div class="modal-header modal-colored-header bg-primary d-flex align-items-center rounded-top">
    <h5 class="modal-title  text-white ">Modificar Cliente</h5>
    <button type="button" class="btn-close  text-white " data-bs-dismiss="modal" aria-label="Close"></button>
</div>

{!! Form::open([
    'route' => ['empresas.update', $empresa->id],
    'method' => 'PUT',
    'enctype' => 'multipart/form-data',
]) !!}
<div class="modal-body">
    <div class="add-contact-box">
        <div class="add-contact-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('nombre', 'Nombre de la Empresa', ['class' => 'form-label']) }}
                        {{ Form::text('nombre', $empresa->nombre, ['class' => 'form-control', 'placeholder' => 'Inserte el nombre']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('rut', 'RUT', ['class' => 'form-label']) }}
                        <div class="input-group">
                            <span class="input-group-text bg-success text-white"><i class="ti ti-check"></i></span>
                            {{ Form::text('rut', $empresa->rut, ['class' => 'form-control bg-transparent rut-editar', 'placeholder' => 'Inserte un RUT válido']) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('contacto', 'Persona de contacto', ['class' => 'form-label']) }}
                        {{ Form::text('contacto', $empresa->contacto, ['class' => 'form-control', 'placeholder' => 'Inserte la persona de contacto']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('email', 'Correo', ['class' => 'form-label']) }}
                        {{ Form::email('email', $empresa->email, ['class' => 'form-control', 'placeholder' => 'Inserte el correo']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('telefono', 'Teléfono de la persona de contacto', ['class' => 'form-label']) }}
                        {{ Form::text('telefono', $empresa->telefono_contacto, ['class' => 'form-control', 'placeholder' => 'Inserte el teléfono']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    {{ Form::label('faena', 'Faenas', ['class' => 'form-label']) }}
                    {{ Form::select('faena[]', $faenas, $empresa->faenas->pluck('faena_id'), ['class' => 'select2 form-control', 'multiple']) }}
                </div>
                <div class="col-md-6">
                    {{ Form::label('area', 'Areas', ['class' => 'form-label']) }}
                    {{ Form::select('area[]', $areas, $empresa->areas->pluck('area_id'), ['class' => 'select2 form-control', 'multiple']) }}
                </div>
                <div class="col-md-6">
                    {{ Form::label('logo', 'Logo', ['class' => 'form-label']) }}
                    {{ Form::file('logo', ['class' => 'form-control']) }}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    {{ Form::label('usuario', 'Usuario asociado a esta Empresa', ['class' => 'form-label']) }}
                    <div>
                        {{ Form::select('usuario', Arr::prepend($usuarios->toArray(), '', ''), $empresa->user_id, ['class' => 'select2 form-control']) }}
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
