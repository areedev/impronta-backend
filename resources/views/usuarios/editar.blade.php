<div class="modal-header modal-colored-header bg-primary d-flex align-items-center rounded-top">
    <h5 class="modal-title  text-white ">Modificar Candidato</h5>
    <button type="button" class="btn-close  text-white " data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>

{!! Form::open(['route' => ['usuarios.update', $user->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
<div class="modal-body">
    <div class="add-contact-box">
        <div class="add-contact-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('nombre', 'Nombre', ['class' => 'form-label']) }}
                        {{ Form::text('nombre', $user->perfil->nombre, ['class' => 'form-control', 'required', 'placeholder' => 'Inserte el nombre']) }}
                        <div class="d-flex justify-content-end">
                            <small class="badge text-danger font-medium bg-danger-subtle form-text fs-1">Obligatorio</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('apellido', 'Apellido', ['class' => 'form-label']) }}
                        {{ Form::text('apellido', $user->perfil->apellido, ['class' => 'form-control', 'required', 'placeholder' => 'Inserte el apellido']) }}
                        <div class="d-flex justify-content-end">
                            <small class="badge text-danger font-medium bg-danger-subtle form-text fs-1">Obligatorio</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('telefono', 'Teléfono', ['class' => 'form-label']) }}
                        {{ Form::text('telefono', $user->perfil->telefono, ['class' => 'form-control', 'required', 'placeholder' => 'Inserte el telefono']) }}
                        <div class="d-flex justify-content-end">
                            <small class="badge text-danger font-medium bg-danger-subtle form-text fs-1">Obligatorio</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('email', 'Correo', ['class' => 'form-label']) }}
                        {{ Form::email('email', $user->email, ['class' => 'form-control', 'required', 'placeholder' => 'Inserte el correo']) }}
                        <div class="d-flex justify-content-end">
                            <small class="badge text-danger font-medium bg-danger-subtle form-text fs-1">Obligatorio</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('password', 'Contraseña', ['class' => 'form-label']) }}
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => '*******']) }}
                        <div class="d-flex justify-content-end">
                            <small class="badge text-info font-medium bg-info-subtle form-text fs-1">Mínimo 8 caracteres</small>
                            <small class="badge text-danger font-medium bg-danger-subtle form-text fs-1">Obligatorio</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('confirm-password', 'Confirmar Contraseña', ['class' => 'form-label']) }}
                        {{ Form::password('confirm-password', ['class' => 'form-control', 'placeholder' => '*******']) }}
                        <div class="d-flex justify-content-end">
                            <small class="badge text-info font-medium bg-info-subtle form-text fs-1">Mínimo 8 caracteres</small>
                            <small class="badge text-danger font-medium bg-danger-subtle form-text fs-1">Obligatorio</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    {{ Form::label('rol', 'Rol', ['class' => 'form-label']) }}
                    <div>
                    {{ Form::select('rol', $roles, $user->roles[0]->name, ['class' => 'select2 form-control', 'required', 'placeholder' => 'Seleccionar']) }}
                    </div>
                </div>
            </div>
            <hr>
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