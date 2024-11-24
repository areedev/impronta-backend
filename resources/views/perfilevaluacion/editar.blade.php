@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Perfiles de Evaluaciones')
@section('descripcion', 'Mantenedor de perfiles de evaluaciones')
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
    'route' => ['perfilevaluaciones.update', $perfil->id],
    'method' => 'PUT',
    'enctype' => 'multipart/form-data',
    ]) !!}
    <div class="card card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    {{ Form::label('nombre', 'Nombre del Perfil', ['class' => 'form-label']) }}
                    {{ Form::text('nombre', $perfil->nombre, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="row secciones draggable-cards" id="draggable-area">
        @foreach ($perfil->secciones as $seccion)
        <div class="col-12">
            <div class="card seccion">
                <div class="card-header text-bg-primary">
                    <h4 class="mb-0 text-white fs-5">Arrastrar para ordenar</h4>
                </div>
                <div class="row card-body">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                {{ Form::label('nombre_seccion[' . $seccion->id . ']', 'Nombre de la sección', ['class' => 'form-label']) }}
                                <button type="button"
                                    class="mb-3 justify-content-center btn btn-sm mb-1 btn-rounded btn-outline-danger d-flex align-items-center eliminar-seccion"
                                    data-action="{{ route('perfilevaluaciones.eliminarseccion') }}"
                                    data-seccion="{{ $seccion->id }}">
                                    <i class="ti ti-minus fs-4 me-2"></i>
                                    Eliminar Sección
                                </button>
                            </div>
                            {{ Form::text('nombre_seccion[' . $seccion->id . ']', $seccion->nombre, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-12 seccion-items">
                        @foreach ($seccion->items as $item)
                        <div class="row d-flex item-seccion">
                            <div class="col-md-2">
                                {{ Form::label('tipo[' . $item->seccion_id . '][' . $item->id . ']', 'Tipo', ['class' => 'form-label']) }}
                                <div class="mb-2">
                                    {{ Form::select('tipo[' . $item->seccion_id . '][' . $item->id . ']', $tipos, isset($item->competencia->tipo_competencia_id) ?  $item->competencia->tipo_competencia_id : null, ['class' => 'select2 tipo', 'placeholder' => 'Seleccionar', 'data-id' => $item->id]) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                {{ Form::label('competencia[' . $item->seccion_id . '][' . $item->id . ']', 'Competencia', ['class' => 'form-label']) }}
                                <div class="mb-3">
                                    {{ Form::select('competencia[' . $item->seccion_id . '][' . $item->id . ']', isset($item->competencia) ? [$item->competencia_id => $item->competencia->nombre] : ['' => ''], isset($item->competencia_id) ? $item->competencia_id : null, ['class' => 'select2 competencia', 'placeholder' => 'Seleccionar', 'competencia-id' => $item->id]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{ Form::label('descripcion[' . $item->seccion_id . '][' . $item->id . ']', 'Descripción', ['class' => 'form-label']) }}
                                {{ Form::textarea('descripcion[' . $item->seccion_id . '][' . $item->id . ']', isset($item->competencia->definicion) ? $item->competencia->definicion : null , ['class' => 'form-control', 'disabled', 'rows' => 1, 'descripcion-id' => $item->id]) }}
                            </div>
                            <div class="col-md-1 align-self-center">
                                <button type="button"
                                    class="justify-content-center btn btn-sm mb-1 btn-rounded btn-outline-danger d-flex align-items-center eliminar-item"
                                    data-item="{{ $item->id }}"
                                    data-action="{{ route('perfilevaluaciones.eliminarcolumna') }}">
                                    <i class="ti ti-minus fs-4"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="col-md-12">
                        <button type="button"
                            class="justify-content-center w-100 btn mb-1 btn-rounded btn-outline-dark d-flex align-items-center nueva-columna"
                            data-action="{{ route('perfilevaluaciones.columna') }}"
                            data-perfil="{{ $perfil->id }}" data-seccion="{{ $seccion->id }}">
                            <i class="ti ti-plus fs-4 me-2"></i>
                            Agregar Columna
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="card card-body">
        <div class="col-md-12  d-flex justify-content-between">
            <button type="button"
                class="justify-content-center btn mb-1 btn-rounded btn-outline-primary d-flex align-items-center nueva-seccion"
                data-action="{{ route('perfilevaluaciones.nuevaseccion') }}" data-perfil="{{ $perfil->id }}">
                <i class="ti ti-plus fs-4 me-2"></i>
                Agregar Sección
            </button>
            <button type="submit" class="btn btn-rounded btn-primary px-4">
                Guadar
            </button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
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
    $('body').on('click', '.nueva-columna', function(e) {
        e.preventDefault();
        var perfil = $(this).attr('data-perfil');
        var seccion = $(this).attr('data-seccion');
        var action = $(this).attr('data-action');
        var $this = $(this);
        $.get(action, {
            perfil: perfil,
            seccion: seccion
        }, function(response) {
            $this.closest('.seccion').find('.seccion-items').append(response.html);
            $this.closest('.seccion').find('.seccion-items').find('.select2').select2({
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
        })
    });

    $('body').on('change', '.tipo', function(e) {
        e.preventDefault();
        var tipo = $(this).val();
        var id = $(this).attr('data-id');
        var tipo = $(this).val();
        var action = "{{ route('perfilevaluaciones.competencia') }}";
        var $this = $(this);
        $('[competencia-id=' + id + ']').select2({
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
    $('body').on('change', '.competencia', function(e) {
        var id = $(this).attr('competencia-id');
        var competencia = $(this).val();
        var action = "{{ route('perfilevaluaciones.descripcion') }}";
        var $this = $(this);
        $.post(action, {
            competencia: competencia,
            _token: '{{ csrf_token() }}'
        }, function(response) {
            if (response.status) {
                $('[descripcion-id=' + id + ']').val(response.definicion)
            }
        })
    });

    $('body').on('click', '.eliminar-item', function(e) {
        e.preventDefault();
        var item = $(this).attr('data-item');
        var action = $(this).attr('data-action');
        var $this = $(this);
        $.post(action, {
            item: item,
            _token: '{{ csrf_token() }}'
        }, function(response) {
            if (response.status) {
                $this.closest('.item-seccion').remove();
            }
        })
    });

    $('body').on('click', '.nueva-seccion', function(e) {
        e.preventDefault();
        var perfil = $(this).attr('data-perfil');
        var action = $(this).attr('data-action');
        var $this = $(this);
        $.post(action, {
            perfil: perfil,
            _token: '{{ csrf_token() }}'
        }, function(response) {
            $('.secciones').append(response.html);
        })
    });

    $('body').on('click', '.eliminar-seccion', function(e) {
        e.preventDefault();
        var seccion = $(this).attr('data-seccion');
        var action = $(this).attr('data-action');
        var $this = $(this);
        $.post(action, {
            seccion: seccion,
            _token: '{{ csrf_token() }}'
        }, function(response) {
            if (response.status) {
                $this.closest('.seccion').remove();
            }
        })
    });
    $(function() {
        dragula([document.getElementById("draggable-area")]);
    });
</script>
@endsection