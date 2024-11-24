@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Reportes')
@section('descripcion', 'Reportes generales')
@section('contenido')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Reportes</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ URL::to('/') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Reportes
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
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 col-xl-3">
                    <form class="position-relative">
                        <input type="text" class="form-control product-search ps-5" id="buscador"
                            placeholder="Buscar..." />
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </form>
                </div>
                <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                </div>
            </div>
        </div>
        <div class="d-flex flex-row gap-3 customizer-box mb-3" role="group">
            <input type="radio" class="btn-check" name="layout" id="boxed-layout" autocomplete="off">
            <label class="btn p-9 btn-outline-primary" for="boxed-layout"><i
                    class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Contraer</label>

            <input type="radio" class="btn-check" name="layout" id="full-layout" autocomplete="off">
            <label class="btn p-9 btn-outline-primary" for="full-layout"><i
                    class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Expandir</label>
        </div>
        <div class="card">
            <div class="card-body">
                <label>Filtros:</label>
                <div class="row mt-2">
                    <div class="col-2">
                        <div>
                            {{ Form::label('perfil_evaluacion', 'Tipo de perfil', ['class' => 'form-label']) }}
                            <div>
                                {{ Form::select('perfil_evaluacion', $perfiles, null, ['class' => 'form-control select2 filtros', 'placeholder' => 'Seleccionar']) }}
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->hasRole(1))
                    <div class="col-2">
                        <div>
                            {{ Form::label('empresa', 'Empresa', ['class' => 'form-label']) }}
                            <div>
                                {{ Form::select('empresa', $empresas, null, ['class' => 'form-control select2 filtros', 'placeholder' => 'Seleccionar']) }}
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-2">
                        <div>
                            {{ Form::label('area', 'Areas', ['class' => 'form-label']) }}
                            <div>
                                {{ Form::select('area', $areas, null, ['class' => 'form-control select2 filtros', 'placeholder' => 'Seleccionar']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div>
                            {{ Form::label('faena', 'Faenas', ['class' => 'form-label']) }}
                            <div>
                                {{ Form::select('faena', $faenas, null, ['class' => 'form-control select2 filtros', 'placeholder' => 'Seleccionar']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div>
                            {{ Form::label('estado', 'Estado', ['class' => 'form-label']) }}
                            <div>
                                {{ Form::select('estado', [0 => 'PENDIENTE', 1 => 'EN PROCESO', '2' => 'COMPLETADO'], null, ['class' => 'form-control select2 filtros', 'placeholder' => 'Seleccionar']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div>
                            {{ Form::label('aprobacion', 'Aprobación', ['class' => 'form-label']) }}
                            <div>
                                {{ Form::select('aprobacion', [0 => 'NO ACREDITADO', 1 => 'ACREDITADO', '2' => 'En Espera'], null, ['class' => 'form-control select2 filtros', 'placeholder' => 'Seleccionar']) }}
                            </div>
                        </div>
                    </div>
                    <hr class="my-2">
                    <div class="col-2">
                        <button type="button" id="limpiar" class="btn btn-info">Limpiar Filtros</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-body">
            <div class="table-responsive">
                {{ $dataTable->table(['width' => '100%', 'height' => '100%', 'class' => 'table table-bordered text-center']) }}
            </div>
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
        $('#limpiar').on('click', function() {
            $('#perfil_evaluacion').val('').trigger('change');
            $('#empresa').val('').trigger('change');
            $('#area').val('').trigger('change');
            $('#faena').val('').trigger('change');
            $('#estado').val('').trigger('change');
            $('#aprobacion').val('').trigger('change');
        });
        $('#buscador').on('keyup', function() {
            var valorBusqueda = $(this).val();
            $('#reporte-table').DataTable().search(valorBusqueda).draw();
        });
    </script>
@endsection
@push('script')
    {{ $dataTable->scripts() }}
    <script>
        $('#reporte-table').on('draw.dt', function() {
            $(".buttons-copy, .buttons-colvis, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel")
                .addClass("btn btn-primary");
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
        $(document).ready(function() {
            let tabla = $('#reporte-table')
            $('.filtros').on('change', function() {
                tabla.on('preXhr.dt', function(e, settings, data) {
                    data.perfil = $('#perfil_evaluacion').val();
                    data.empresa = $('#empresa').val();
                    data.area = $('#area').val();
                    data.faena = $('#faena').val();
                    data.estado = $('#estado').val();
                    data.aprobacion = $('#aprobacion').val();
                })
                tabla.DataTable().ajax.reload()
            })
        })
    </script>
@endpush
