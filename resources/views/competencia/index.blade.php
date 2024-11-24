@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Competencias')
@section('descripcion', 'Mantenedor de competencias')
@section('contenido')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Competencias</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="{{ URL::to('/') }}">Inicio</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Competencias
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
                <button data-bs-toggle="modal" data-bs-target="#addContactModal"
                    class="btn btn-info d-flex align-items-center">
                    <i class="ti ti-plus text-white me-1 fs-5"></i> Nueva Competencia
                </button>
            </div>
        </div>
    </div>
    <div class="d-flex flex-row gap-3 customizer-box mb-3" role="group">
        <input type="radio" class="btn-check" name="layout" id="boxed-layout" autocomplete="off">
        <label class="btn p-9 btn-outline-primary" for="boxed-layout"><i class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Contraer</label>

        <input type="radio" class="btn-check" name="layout" id="full-layout" autocomplete="off">
        <label class="btn p-9 btn-outline-primary" for="full-layout"><i class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Expandir</label>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary d-flex align-items-center rounded-top">
                    <h5 class="modal-title  text-white ">Nueva Competencia</h5>
                    <button type="button" class="btn-close  text-white " data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                {!! Form::open(['route' => 'competencias.store', 'method' => 'Post', 'enctype' => 'multipart/form-data']) !!}
                <div class="modal-body">
                    <div class="add-contact-box">
                        <div class="add-contact-content">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        {{ Form::label('tipo', 'Tipo', ['class' => 'form-label']) }}
                                        <div>
                                            {{ Form::select('tipo', $tipos, null, ['class' => 'form-control select2']) }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('llave', 'Llave', ['class' => 'form-label']) }}
                                        {{ Form::text('llave', null, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('nombre', 'Nombre', ['class' => 'form-label']) }}
                                        {{ Form::textarea('nombre', null, ['class' => 'form-control', 'rows' => 2]) }}
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('definicion', 'Definición', ['class' => 'form-label']) }}
                                        {{ Form::textarea('definicion', null, ['class' => 'form-control', 'rows' => 2]) }}
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('proyecto', 'Proyecto', ['class' => 'form-label']) }}
                                        {{ Form::text('proyecto', null, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('alcance', 'Alcance', ['class' => 'form-label']) }}
                                        {{ Form::text('alcance', null, ['class' => 'form-control']) }}
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
            dropdownParent: $('#addContactModal'),
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
    $('body').on('click', '.editar-competencia', function(e) {
        e.preventDefault();
        var action = $(this).data('action');
        var modal = $('#modalgeneral');
        $.get(action, function(response) {
            modal.find('.modal-content-general').html(response.html);
            modal.find('.select2').select2({
                dropdownParent: $('#modalgeneral'),
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
            modal.modal('show');
        })
    });
    $('#buscador').on('keyup', function() {
        var valorBusqueda = $(this).val();
        $('#competencia-table').DataTable().search(valorBusqueda).draw();
    });
</script>
@endsection
@push('script')
{{ $dataTable->scripts() }}
<script>
    $('#competencia-table').on('draw.dt', function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endpush