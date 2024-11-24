@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Evaluaciones')
@section('descripcion', 'Crear evaluación práctica')
@section('contenido')
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
    'route' => ['evaluaciones.store'],
    'method' => 'POST',
    'enctype' => 'multipart/form-data',
    ]) !!}

    <div class="row">
        <div class="col-md-4">
            <h4 class="mb-3">Datos del Colaborador</h4>
            <div class="card card-body">
                <div class="mb-3">
                    {{ Form::label('rut', 'RUT', ['class' => 'form-label']) }}
                    <div class="input-group">
                        <span class="input-group-text bg-warning text-white"><i class="ti ti-alert-circle"></i></span>
                        {{ Form::text('rut', null, ['class' => 'form-control bg-transparent rut', 'required', 'placeholder' => 'Inserte un RUT válido']) }}
                    </div>
                    <div class="d-flex justify-content-end">
                        <small class="badge text-danger font-medium bg-danger-subtle form-text fs-1">Obligatorio</small>
                    </div>
                </div>
                <div class="mb-3">
                    {{ Form::label('nombre', 'Nombre', ['class' => 'form-label']) }}
                    {{ Form::text('nombre', null, ['class' => 'form-control']) }}
                </div>
                <div class="mb-3">
                    {{ Form::label('cargo', 'Cargo', ['class' => 'form-label']) }}
                    {{ Form::text('cargo', null, ['class' => 'form-control']) }}
                </div>
                <div class="mb-3">
                    {{ Form::label('evaluador', 'Evaluador Asignado', ['class' => 'form-label']) }}
                    {{ Form::text('evaluador', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h4 class="mb-3">Datos de Empresa</h4>
            <div class="card card-body">
                <div class="mb-3">
                    {{ Form::label('empresa', 'Empresa', ['class' => 'form-label']) }}
                    <div>
                        {{ Form::select('empresa', ['' => 'seleccionar'], null, ['class' => 'form-control select2', 'placeholder' => 'Seleccionar']) }}
                    </div>
                </div>
                <div class="mb-3">
                    {{ Form::label('faena', 'Faena', ['class' => 'form-label']) }}
                    <div>
                        {{ Form::select('faena', ['' => 'seleccionar'], null, ['class' => 'form-control select2', 'placeholder' => 'Seleccionar']) }}
                    </div>
                </div>
                <div class="mb-3">
                    {{ Form::label('area', 'Area', ['class' => 'form-label']) }}
                    <div>
                        {{ Form::select('area', ['' => 'seleccionar'], null, ['class' => 'form-control select2', 'placeholder' => 'Seleccionar']) }}
                    </div>
                </div>
                <div class="mb-3">
                    {{ Form::label('fecha_solicitud', 'Fecha de Solicitud', ['class' => 'form-label']) }}
                    {{ Form::date('fecha_solicitud', null, ['class' => 'form-control']) }}
                </div>
                <div class="mb-3">
                    {{ Form::label('fecha_ejecucion', 'Fecha de Ejecución', ['class' => 'form-label']) }}
                    {{ Form::date('fecha_ejecucion', null, ['class' => 'form-control']) }}
                </div>
                <div class="mb-3">
                    {{ Form::label('fecha_emision', 'Fecha de Emisión', ['class' => 'form-label']) }}
                    {{ Form::date('fecha_emision', null, ['class' => 'form-control']) }}
                </div>
                <div class="mb-3">
                    {{ Form::label('certificado', 'Certificado/Informe', ['class' => 'form-label']) }}
                    {{ Form::text('certificado', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h4 class="mb-3">Datos de la Evaluación</h4>
            <div class="card card-body">
                <div class="mb-3">
                    {{ Form::label('equipo', 'Equipo', ['class' => 'form-label']) }}
                    {{ Form::text('equipo', null, ['class' => 'form-control']) }}
                </div>
                <div class="mb-3">
                    {{ Form::label('marca', 'Marca', ['class' => 'form-label']) }}
                    {{ Form::text('marca', null, ['class' => 'form-control']) }}
                </div>
                <div class="mb-3">
                    {{ Form::label('modelo', 'Modelo', ['class' => 'form-label']) }}
                    {{ Form::text('modelo', null, ['class' => 'form-control']) }}
                </div>
                <div class="mb-3">
                    {{ Form::label('year', 'Año', ['class' => 'form-label']) }}
                    {{ Form::text('year', null, ['class' => 'form-control yearpicker']) }}
                </div>
                <div class="mb-3">
                    {{ Form::label('perfil_evaluacion', 'Tipo de perfil', ['class' => 'form-label']) }}
                    <div>
                        {{ Form::select('perfil_evaluacion', $perfiles, null, ['class' => 'form-control select2', 'placeholder' => 'Seleccionar']) }}
                    </div>
                </div>
                <div class="mb-3">
                    {{ Form::label('condiciones', 'Chequeo de condiciones', ['class' => 'form-label']) }}
                    {{ Form::file('condiciones', ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="col-md-12  d-flex justify-content-between">
            <a href="{{ route('evaluaciones.index') }}" class="btn btn-danger rounded-pill">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary rounded-pill px-4">
                Guardar
            </button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection
@section('customjs')
<script>
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