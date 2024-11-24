<div class="modal-header modal-colored-header bg-primary d-flex align-items-center rounded-top">
    <h5 class="modal-title  text-white ">Modificar Candidato</h5>
    <button type="button" class="btn-close  text-white " data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>

{!! Form::open(['route' => ['candidatos.update', $candidato->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
<div class="modal-body">
    <div class="add-contact-box">
        <div class="add-contact-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('nombre', 'Nombre', ['class' => 'form-label']) }}
                        {{ Form::text('nombre', $candidato->nombre, ['class' => 'form-control', 'required', 'placeholder' => 'Inserte el nombre']) }}
                        <div class="d-flex justify-content-end">
                            <small class="badge text-danger font-medium bg-danger-subtle form-text fs-1">Obligatorio</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('rut', 'RUT', ['class' => 'form-label']) }}
                        <div class="input-group">
                            <span class="input-group-text bg-success text-white"><i
                                    class="ti ti-check"></i></span>
                            {{ Form::text('rut', $candidato->rut, ['class' => 'form-control bg-transparent rut-editar', 'placeholder' => 'Inserte un RUT válido']) }}
                        </div>
                        <div class="d-flex justify-content-end">
                            <small class="badge text-danger font-medium bg-danger-subtle form-text fs-1">Obligatorio</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('telefono', 'Teléfono', ['class' => 'form-label']) }}
                        {{ Form::text('telefono', $candidato->telefono, ['class' => 'form-control', 'required', 'placeholder' => 'Inserte el telefono']) }}
                        <div class="d-flex justify-content-end">
                            <small class="badge text-danger font-medium bg-danger-subtle form-text fs-1">Obligatorio</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        {{ Form::label('email', 'Correo', ['class' => 'form-label']) }}
                        {{ Form::email('email', $candidato->email, ['class' => 'form-control', 'required', 'placeholder' => 'Inserte el correo']) }}
                        <div class="d-flex justify-content-end">
                            <small class="badge text-danger font-medium bg-danger-subtle form-text fs-1">Obligatorio</small>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->hasRole(1))
                    <div class="col-md-6">
                        {{ Form::label('empresa', 'Empresa', ['class' => 'form-label']) }}
                        <div>
                        {{ Form::select('empresa', $empresas, $candidato->empresa_id, ['class' => 'select2 form-control', 'required', 'placeholder' => 'Seleccionar']) }}
                        </div>
                        <div class="d-flex justify-content-end">
                            <small class="badge text-danger font-medium bg-danger-subtle form-text fs-1">Obligatorio</small>
                        </div>
                    </div>
                @endif
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6 mb-3">
                    {{ Form::label('ci', 'C.I', ['class' => 'form-label']) }}
                    @if ($candidato->ci)
                        <a href="{{ asset('uploads/candidatos/' . $candidato->id . '/documentos/' . $candidato->ci . '') }}"
                            target="_blank" class="text-center rounded-1 bg-info text-white p-1 fs-1 ms-2">
                            <i class="ti ti-eye"></i>
                        </a>
                    @endif
                    {{ Form::file('ci', ['class' => 'form-control']) }}
                    <div class="d-flex justify-content-end">
                        <small class="badge badge-default text-info font-medium bg-info-subtle form-text fs-1">pdf,docx,doc,jpg,jpeg,png | Máximo: 10mb</small>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    {{ Form::label('licencia_municipal', 'Licencia Municipal', ['class' => 'form-label']) }}
                    @if ($candidato->licencia_municipal)
                        <a href="{{ asset('uploads/candidatos/' . $candidato->id . '/documentos/' . $candidato->licencia_municipal . '') }}"
                            target="_blank" class="text-center rounded-1 bg-info text-white p-1 fs-1 ms-2">
                            <i class="ti ti-eye"></i>
                        </a>
                    @endif
                    {{ Form::file('licencia_municipal', ['class' => 'form-control']) }}
                    <div class="d-flex justify-content-end">
                        <small class="badge badge-default text-info font-medium bg-info-subtle form-text fs-1">pdf,docx,doc,jpg,jpeg,png | Máximo: 10mb</small>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    {{ Form::label('licencia_interna', 'Licencia Interna', ['class' => 'form-label']) }}
                    @if ($candidato->licencia_interna)
                        <a href="{{ asset('uploads/candidatos/' . $candidato->id . '/documentos/' . $candidato->licencia_interna . '') }}"
                            target="_blank" class="text-center rounded-1 bg-info text-white p-1 fs-1 ms-2">
                            <i class="ti ti-eye"></i>
                        </a>
                    @endif
                    {{ Form::file('licencia_interna', ['class' => 'form-control']) }}
                    <div class="d-flex justify-content-end">
                        <small class="badge badge-default text-info font-medium bg-info-subtle form-text fs-1">pdf,docx,doc,jpg,jpeg,png | Máximo: 10mb</small>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    {{ Form::label('cv', 'CV', ['class' => 'form-label']) }}
                    @if ($candidato->cv)
                        <a href="{{ asset('uploads/candidatos/' . $candidato->id . '/documentos/' . $candidato->cv . '') }}"
                            target="_blank" class="text-center rounded-1 bg-info text-white p-1 fs-1 ms-2">
                            <i class="ti ti-eye"></i>
                        </a>
                    @endif
                    {{ Form::file('cv', ['class' => 'form-control']) }}
                    <div class="d-flex justify-content-end">
                        <small class="badge badge-default text-info font-medium bg-info-subtle form-text fs-1">pdf,docx,doc,jpg,jpeg,png | Máximo: 10mb</small>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    {{ Form::label('foto', 'Foto', ['class' => 'form-label']) }}
                    @if ($candidato->foto)
                        <a href="{{ asset('uploads/candidatos/' . $candidato->id . '/foto/' . $candidato->foto . '') }}"
                            target="_blank" class="text-center rounded-1 bg-info text-white p-1 fs-1 ms-2">
                            <i class="ti ti-eye"></i>
                        </a>
                    @endif
                    {{ Form::file('foto', ['class' => 'form-control']) }}
                    <div class="d-flex justify-content-end">
                        <small class="badge badge-default text-info font-medium bg-info-subtle form-text fs-1">jpg,jpeg,png | Máximo: 3mb</small>
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