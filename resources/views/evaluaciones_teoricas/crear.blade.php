@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Evaluaciones')
@section('descripcion', 'Crear evaluación teórica')
@section('contenido')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Evaluaciones</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="{{ URL::to('/') }}">Inicio</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Evaluaciones
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <img src="../assets/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4" />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="widget-content searchable-container list">
    <div class="d-flex flex-row gap-3 customizer-box mb-3" role="group">
        <input type="radio" class="btn-check" name="layout" id="boxed-layout" autocomplete="off">
        <label class="btn p-9 btn-outline-primary" for="boxed-layout"><i
                class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Contraer</label>

        <input type="radio" class="btn-check" name="layout" id="full-layout" autocomplete="off">
        <label class="btn p-9 btn-outline-primary" for="full-layout"><i
                class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Expandir</label>
    </div>
    {!! Form::open([
    'route' => ['evaluaciones.teorica.post', $evaluacion->id],
    'method' => 'POST',
    'enctype' => 'multipart/form-data',
    ]) !!}
    <div class="card card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    {{ Form::label('preguntas', 'Total de preguntas', ['class' => 'form-label']) }}
                    {{ Form::number('preguntas', null, ['class' => 'form-control', 'required']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    {{ Form::label('preguntas_buenas', 'Preguntas buenas', ['class' => 'form-label']) }}
                    {{ Form::number('preguntas_buenas', null, ['class' => 'form-control', 'required']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    {{ Form::label('archivo', 'Subir archivo', ['class' => 'form-label']) }}
                    {{ Form::file('archivo', ['class' => 'form-control', 'required']) }}
                </div>
            </div>
        </div>
        <hr>
        <div class="row preguntascontenedor">
            <div class="col-md-12 pregunta">
                <div class="row d-flex">
                    <div class="col-md-1">
                        {{ Form::label('tipo[1]', 'Tipo', ['class' => 'form-label']) }}
                        <div class="mb-2">
                            {{ Form::select('tipo[1]', $tipos, null, ['data-select2-id' => 1, 'class' => 'select2 tipo', 'placeholder' => 'Seleccionar', 'required']) }}
                        </div>
                    </div>
                    <div class="col-md-5">
                        {{ Form::label('competencia[1]', 'Item', ['class' => 'form-label']) }}
                        <div class="mb-3">
                            {{ Form::select('competencia[1]', ['' => ''], null, ['data-select2-id' => 2, 'class' => 'select2 competencia', 'placeholder' => 'Seleccionar', 'required']) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('pregunta[1]', 'Pregunta', ['class' => 'form-label']) }}
                        {{ Form::text('pregunta[1]', null, ['class' => 'form-control', 'placeholder' => '', 'required']) }}
                    </div>
                    <div class="col-md-1">
                        <div class="mb-2">
                            {{ Form::label('comentario', 'Comentario', ['class' => 'form-label']) }}
                            <button type="button"
                                class="justify-content-center w-100 btn mb-1 btn-primary d-flex align-items-center abrir-modal"
                                data-bs-toggle="modal" data-bs-target="#modalComentario1">
                                <i class="ti ti-message fs-4"></i>
                            </button>
                        </div>
                        <div class="modal fade" id="modalComentario1" tabindex="-1" role="dialog"
                            aria-labelledby="modalComentario1Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalComentario1Label">Agregar Comentario
                                        </h5>
                                        <button type="button" class="btn btn-outline-gray" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            x
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{ Form::textarea('comentario[1]', null, ['class' => 'form-control mb-3']) }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary guardar-comentario"
                                            data-comentario-id="1" data-bs-dismiss="modal">Guardar</button>
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
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <button type="button"
                    class="justify-content-center w-100 btn mb-1 btn-rounded btn-outline-dark d-flex align-items-center nueva-pregunta"
                    data-action="{{ route('evaluaciones.teorica.nueva_pregunta') }}">
                    <i class="ti ti-plus fs-4 me-2"></i>
                    Agregar Pregunta
                </button>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="d-flex justify-content-center">
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        {{ Form::label('nota', 'Nota de la evaluación', ['class' => 'form-label']) }}
                        {{ Form::number('nota', null, ['class' => 'form-control', 'required', 'min' => 0, 'max' => 4, 'step' => '0.1']) }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
    {!! Form::close() !!}
</div>
@endsection
@section('customjs')
<script>
    $(document).ready(function() {
        $('.select2').each(function() {
            $(this).select2({
                placeholder: 'Seleccionar',
                language: {
                    noResults: function() {
                        return "No hay resultado";
                    },
                    searching: function() {
                        return "Buscando..";
                    }
                }
            });
        });
    });
    $('body').on('change', '.tipo', function(e) {
        var tipo = $(this).val();
        var action = "{{ route('perfilevaluaciones.competencia') }}";
        var $this = $(this);
        $(this).parent().parent().parent().find('.competencia').val(null).trigger('change');
        $(this).parent().parent().parent().find('.competencia').select2({
            dropdownParent: $this.parent(),
            placeholder: "Seleccionar",
            language: {
                noResults: function() {
                    return "No hay resultado";
                },
                searching: function() {
                    return "Buscando..";
                }
            },
            width: '100%',
            ajax: {
                url: "{{ route('perfilevaluaciones.competencia') }}",
                type: "post",
                dataType: "json",
                data: function(params) {
                    return {
                        _token: '{{ csrf_token() }}',
                        search: params.term,
                        tipo: tipo
                    };
                },
                processResults: function(response) {
                    return {
                        results: response,
                    };
                },
                cache: true,
            },
        });
    });
    $('body').on('click', '.nueva-pregunta', function(e) {
        e.preventDefault();
        var action = $(this).attr('data-action');
        var $this = $(this);
        $.get(action, function(response) {
            $('.preguntascontenedor').append(response.html);
            $('.pregunta:last-child .select2').each(function() {
                $(this).select2({
                    placeholder: 'Seleccionar',
                    language: {
                        noResults: function() {
                            return "No hay resultado";
                        },
                        searching: function() {
                            return "Buscando..";
                        }
                    }
                    // Consider using data-select2-id attribute here for unique identification
                });
            });
        })
    });
    $('body').on('click', '.eliminar-pregunta', function(e) {
        e.preventDefault();
        $(this).closest('.pregunta').remove();
    });
</script>
@endsection