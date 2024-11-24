@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Evaluaciones')
@section('descripcion', 'Crear evaluación práctica')
@section('contenido')
<div class="widget-content searchable-container list">
    <div class="d-flex flex-row gap-3 customizer-box mb-3" role="group">
        <input type="radio" class="btn-check" name="layout" id="boxed-layout" autocomplete="off">
        <label class="btn p-9 btn-outline-primary" for="boxed-layout"><i class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Contraer</label>

        <input type="radio" class="btn-check" name="layout" id="full-layout" autocomplete="off">
        <label class="btn p-9 btn-outline-primary" for="full-layout"><i class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Expandir</label>
    </div>
    {!! Form::open([
    'route' => ['evaluaciones.notas', $evaluacion->id],
    'method' => 'POST',
    'enctype' => 'multipart/form-data',
    ]) !!}

    <div class="row">

        <div class="col-md-12">
            <h4 class="mb-3">{{ $evaluacion->perfilEvaluacion->nombre }}</h4>
            <div class="card card-body">
                <ul class="nav nav-pills nav-fill mt-4" role="tablist">
                    @php $i = 0; @endphp
                    @foreach ($evaluacion->perfilEvaluacion->secciones as $seccion)
                    <li class="nav-item">
                        <a class="nav-link {{ $i == 0 ? 'active' : '' }}" data-bs-toggle="tab" href="#navpill-{{ $seccion->orden }}" role="tab">
                            <span>{{ $seccion->nombre }}</span>
                        </a>
                    </li>
                    @php $i++; @endphp
                    @endforeach
                </ul>
                <div class="alert mt-3 customize-alert text-danger border border-danger fade show" role="alert">
                    <div class="d-flex align-items-center  me-3 me-md-0 fw-bolder">
                        <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-danger"></i>
                        Todos los campos de notas y porcentaje son necesarios.
                    </div>
                </div>
                <div class="tab-content border mt-2">
                    @php $i = 0; @endphp
                    @foreach ($evaluacion->perfilEvaluacion->secciones as $llave => $seccion)
                    <div class="tab-pane {{ $i == 0 ? 'active' : '' }} p-3" id="navpill-{{ $seccion->orden }}" role="tabpanel">
                        <div class="row">
                            <div class="col-md-3">
                                <h6>Item</h6>
                            </div>
                            <div class="col-md-6">
                                <h6>Descripción</h6>
                            </div>
                            <div class="col-md-1  d-flex justify-content-center">
                                <h6 class="fs-1">Nota</h6>
                            </div>
                            <div class="col-md-1  d-flex justify-content-center">
                                <h6 class="fs-1">% Evaluación</h6>
                            </div>
                            <div class="col-md-1 d-flex justify-content-center">
                                <h6 class="fs-1">Comentario</h6>
                            </div>
                        </div>
                        @foreach ($seccion->items as $item)
                        @php
                        $resultado = $evaluacion->resultado->where('item_id', $item->id)->first();
                        @endphp
                        @if(isset($item->competencia))
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="m-2 p-3 bg-light h-100 w-100 rounded rounded d-flex align-items-center">
                                    <h6>{{ $item->competencia->nombre }}</h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="m-2 p-3 bg-light h-100 w-100 rounded rounded d-flex align-items-center ">
                                    <p>{{ $item->competencia->definicion }}</p>
                                </div>
                            </div>
                            <div class="col-md-1  d-flex align-items-center justify-content-center">
                                <div class="mb-3">
                                    {{ Form::number('nota[' . $item->id . ']', isset($resultado->nota) ? $resultado->nota : null, ['class' => 'form-control nota', 'step' => '0.01', 'min' => 0, 'max' => 4]) }}
                                </div>
                            </div>
                            <div class="col-md-1  d-flex align-items-center justify-content-center">
                                <div class="mb-3">
                                    {{ Form::number('porcentaje[' . $item->id . ']', isset($resultado->porcentaje) ? $resultado->porcentaje : null, ['class' => 'form-control porcentaje', 'disabled', 'step' => '0.01']) }}
                                </div>
                            </div>

                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                <div class="mb-3">
                                    <button type="button" class="justify-content-center w-100 btn mb-1 btn-primary d-flex align-items-center abrir-modal" data-bs-toggle="modal" data-bs-target="#modalComentario{{ $item->id }}">
                                        <i class="ti ti-message fs-4"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="modal fade" id="modalComentario{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalComentario{{ $item->id }}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalComentario{{ $item->id }}Label">Agregar Comentario
                                            </h5>
                                            <button type="button" class="btn btn-outline-gray" data-bs-dismiss="modal" aria-label="Close">
                                                x
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{ Form::textarea('comentario[' . $item->id . ']', isset($resultado->comentario) ? $resultado->comentario : null, ['class' => 'form-control mb-3']) }}
                                            {{ Form::file('archivo_comentario[' . $item->id . ']', ['class' => 'form-control']) }}
                                            @if(isset($resultado->archivo) && !is_null($resultado->archivo))
                                            <a class="btn btn-primary mt-3" target="_blank" href="{{URL::to('uploads/evaluacion/resultados/'.$resultado->id.'/'.$resultado->archivo.'')}}">Ver Archivo</a>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary guardar-comentario" data-comentario-id="{{ $item->id }}" data-bs-dismiss="modal">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if (count($item->competencia->criterios) > 0)
                        <hr>
                        <div class="row mb-3 text-white p-3">
                            <div class="col-md-12 bg-primary p-3 rounded">
                                <h5 class="text-white">Criterios de desempeño interno</h5>
                                <div class="row text-white">
                                    <div class="col-md-9">
                                        <h6 class="text-white fs-1">Criterio</h6>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <h6 class="text-white fs-1">Nota</h6>
                                    </div>
                                    <div class="col-md-1  d-flex justify-content-center">
                                        <h6 class="text-white fs-1">Comentario</h6>
                                    </div>
                                </div>
                                @foreach ($item->competencia->criterios as $criterio)
                                @php
                                $resultadocriterio = $evaluacion->criterios->where('criterio_id', $criterio->id)->first();
                                @endphp
                                <div class="row mb-3">
                                    <div class="col-md-9">
                                        <div class="p-2 bg-light h-100 w-100 rounded rounded d-flex align-items-center">
                                            <h6>{{ $criterio->criterio }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="p-2 bg-light h-100 w-100 rounded rounded d-flex align-items-center">
                                            {{ Form::number('calificacion_criterio[' . $item->id . ']['.$criterio->id.']', isset($resultadocriterio->nota) ? $resultadocriterio->nota : null, ['class' => 'form-control', 'step' => '0.01', 'min' => 0, 'max' => 4]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="justify-content-center w-100 btn mb-1 btn-light h-100 d-flex align-items-center  abrir-modal-criterio" data-bs-toggle="modal" data-bs-target="#modalComentarioCriterio{{ $item->id }}-{{$criterio->id}}">
                                            <i class="ti ti-message fs-4"></i>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="modalComentarioCriterio{{ $item->id }}-{{$criterio->id}}" tabindex="-1" role="dialog" aria-labelledby="modalComentario{{ $item->id }}-{{$criterio->id}}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalComentarioCriterio{{ $item->id }}Label">Agregar Comentario
                                                    </h5>
                                                    <button type="button" class="btn btn-outline-gray" data-bs-dismiss="modal" aria-label="Close">
                                                        x
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ Form::textarea('comentario_criterio[' . $item->id . ']['.$criterio->id.']', isset($resultadocriterio->comentarios) ? $resultadocriterio->comentarios : null, ['class' => 'form-control mb-3']) }}
                                                    {{ Form::file('archivo_comentario_criterio[' . $item->id . ']['.$criterio->id.']', ['class' => 'form-control']) }}
                                                    @if(isset($resultadocriterio->archivo) && !is_null($resultadocriterio->archivo))
                                                    <a class="btn btn-primary mt-3" target="_blank" href="{{URL::to('uploads/evaluacion/resultados/criterios/'.$resultadocriterio->id.'/'.$resultadocriterio->archivo.'')}}">Ver Archivo</a>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary guardar-comentario-criterio" data-comentario-criterio-id="{{ $item->id }}" data-bs-dismiss="modal">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                            </div>
                        </div>
                        @endif
                        @endforeach
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div>
                                    @if ($llave == 0)
                                    <a href="{{ route('evaluaciones.index') }}" class="btn btn-danger rounded-pill">
                                        Cancelar
                                    </a>
                                    @endif
                                    @if ($llave > 0)
                                    <button type="button" class="btn btn-primary rounded-pill px-4 btnPrevious">
                                        Anterior
                                    </button>
                                    @endif
                                    @if (!$loop->last)
                                    <button type="button" class="btn btn-primary rounded-pill px-4 btnNext">
                                        Siguiente
                                    </button>
                                    @endif
                                    @if ($loop->last)
                                    <button type="submit" id="submitButton" class="btn btn-primary rounded-pill px-4 btnNext">
                                        Guardar
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $i++; @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection
@section('customjs')
<script>
    $('.btnNext').click(function() {
        const nextTabLinkEl = $('.nav-pills .active').closest('li').next('li').find('a')[0];
        const nextTab = new bootstrap.Tab(nextTabLinkEl);
        nextTab.show();
    });

    $('.btnPrevious').click(function() {
        const prevTabLinkEl = $('.nav-pills .active').closest('li').prev('li').find('a')[0];
        const prevTab = new bootstrap.Tab(prevTabLinkEl);
        prevTab.show();
    });

    $(document).ready(function() {
        $('.select2').select2({
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
    $(function() {
        $(".rut").rut({
            validateOn: 'keyup',
            formatOn: 'keyup',
            useThousandsSeparator: false
        }).on('rutInvalido', function(e) {
            $(this).siblings('span').removeClass('bg-warning').removeClass(
                'bg-success').addClass('bg-danger');
            $(this).closest('.input-group').find('i').removeClass('ti-check')
                .removeClass('ti-alert-circle').addClass('ti-ban');
        }).on('rutValido', function(e, rut, dv) {

            $(this).siblings('span').removeClass('bg-warning').removeClass(
                'bg-danger').addClass('bg-success');
            $(this).closest('.input-group').find('i').removeClass(
                    'ti-alert-circle')
                .removeClass('ti-ban').addClass('ti-check');
            $.blockUI({
                message: '<i class="ti ti-refresh fa-sync text-white fs-5">Procesando...</i>',
                overlayCSS: {
                    backgroundColor: "#000",
                    opacity: 0.5,
                    cursor: "wait",
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: "transparent",
                },
            });

            let action = "{{ route('evaluaciones.validar') }}";
            let rutvalor = $('#rut').val();
            $.get(action, {
                rut: rutvalor
            }, function(response) {
                if (response.success) {
                    llenarform(response);
                    $.unblockUI();
                } else {
                    $('#rut').val('');
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "El RUT ingresado no pertenece a ningun candidato. Primero debe registrar el candidato para proceder.",
                    });
                    $.unblockUI();
                }
            })
        });
    })
    $(".yearpicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });
    $('body').on('click', '.editar-item', function(e) {
        e.preventDefault();
        var action = $(this).data('action');
        var modal = $('#modalgeneral');
        $.get(action, function(response) {
            modal.find('.modal-content-general').html(response.html);
            modal.modal('show');
        })
    });
    $('body').on('click', '.editar-item', function(e) {
        e.preventDefault();
        var action = $(this).data('action');
        var modal = $('#modalgeneral');
        $.get(action, function(response) {
            modal.find('.modal-content-general').html(response.html);
            modal.modal('show');
        })
    });
    $('body').on('change', '.nota', function() {
        var notaValue = $(this).val();
        var notaContainer = $(this).closest('.row'); // Find the closest row container
        var porcentajeInput = notaContainer.find('.porcentaje'); // Find the porcentaje input within the container
        var porcentajeValue = (notaValue / 4) * 100;
        porcentajeInput.val(porcentajeValue.toFixed(2));
    });

    function llenarform(datos) {
        $('#nombre').val(datos.candidato.nombre ? datos.candidato.nombre : null);
        $('#empresa').val(datos.candidato.empresa_id ? datos.candidato.empresa_id : null);
        $('#empresa').trigger('change');
        $('#empresa').empty();
        $('#empresa').trigger('change');
        $('#area').empty();
        $('#area').trigger('change');
        $('#faena').empty();
        $('#faena').trigger('change');
        const empresaData = datos.empresa;
        const faenasData = datos.faenas;
        const areasData = datos.areas;
        const optionsempresa = Object.keys(empresaData).map(key => ({
            id: key,
            text: empresaData[key]
        }));
        const optionsfaenas = Object.keys(faenasData).map(key => ({
            id: key,
            text: faenasData[key]
        }));
        const optionsareas = Object.keys(areasData).map(key => ({
            id: key,
            text: areasData[key]
        }));
        $('#faena').select2({
            data: optionsfaenas,
            language: {
                noResults: function() {
                    return "No hay resultado";
                },
                searching: function() {
                    return "Buscando..";
                }
            }
        });
        $('#area').select2({
            data: optionsareas,
            language: {
                noResults: function() {
                    return "No hay resultado";
                },
                searching: function() {
                    return "Buscando..";
                }
            }
        });
        $('#empresa').select2({
            data: optionsempresa,
            language: {
                noResults: function() {
                    return "No hay resultado";
                },
                searching: function() {
                    return "Buscando..";
                }
            }
        });
    }
</script>
@endsection