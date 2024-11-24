<div class="col-md-12 pregunta">
    <div class="row d-flex">
        <div class="col-md-1">
            {{ Form::label('tipo[' . $random . ']', 'Tipo', ['class' => 'form-label']) }}
            <div class="mb-2">
                {{ Form::select('tipo[' . $random . ']', $tipos, null, ['data-select2-id' => $random, 'class' => 'select2 tipo', 'placeholder' => 'Seleccionar', 'required']) }}
            </div>
        </div>
        <div class="col-md-5">
            {{ Form::label('competencia[' . $random . ']', 'Item', ['class' => 'form-label']) }}
            <div class="mb-3">
                {{ Form::select('competencia[' . $random . ']', ['' => ''], null, ['data-select2-id' => $random2, 'class' => 'select2 competencia', 'placeholder' => 'Seleccionar', 'required']) }}
            </div>
        </div>
        <div class="col-md-4">
            {{ Form::label('pregunta[' . $random . ']', 'Pregunta', ['class' => 'form-label']) }}
            {{ Form::text('pregunta[' . $random . ']', null, ['class' => 'form-control', 'required']) }}
        </div>
        <div class="col-md-1">
            <div class="mb-2">
                {{ Form::label('comentario', 'Comentario', ['class' => 'form-label']) }}
                <button type="button"
                    class="justify-content-center w-100 btn mb-1 btn-primary d-flex align-items-center abrir-modal"
                    data-bs-toggle="modal" data-bs-target="#modalComentario{{ $random }}">
                    <i class="ti ti-message fs-4"></i>
                </button>
                <div class="modal fade" id="modalComentario{{ $random }}" tabindex="-1" role="dialog"
                    aria-labelledby="modalComentario{{ $random }}Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalComentario{{ $random }}Label">Agregar Comentario
                                </h5>
                                <button type="button" class="btn btn-outline-gray" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    x
                                </button>
                            </div>
                            <div class="modal-body">
                                {{ Form::textarea('comentario[' . $random . ']', null, ['class' => 'form-control mb-3']) }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary guardar-comentario"
                                    data-comentario-id="{{ $random }}" data-bs-dismiss="modal">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1 align-self-center">
            <button type="button"
                class="justify-content-center btn btn-sm mb-1 btn-rounded btn-outline-danger d-flex align-items-center eliminar-pregunta">
                <i class="ti ti-minus fs-4"></i>
            </button>
        </div>
    </div>
</div>
