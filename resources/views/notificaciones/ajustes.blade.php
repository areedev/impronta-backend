@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Notificaciones')
@section('descripcion', 'Mantenedor de notificaciones')
@section('contenido')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Notificaciones</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ URL::to('/') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Notificaciones
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
        <div class="card card-body">
            {!! Form::open([
                'route' => ['notificaciones.actualizar'],
                'method' => 'POST',
                'enctype' => 'multipart/form-data',
            ]) !!}
            <div class="modal-body">
                <div class="add-contact-box">
                    <div class="add-contact-content">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    {{ Form::label('usuarios', 'Usuarios', ['class' => 'form-label']) }}
                                    <div>
                                        {{ Form::select('usuarios[]', $usuarios, $activos, ['class' => 'form-control select2', 'multiple']) }}
                                    </div>
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
@endsection
@section('customjs')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Seleccionar'
            });
        });
        $('body').on('click', '.editar-faena', function(e) {
            e.preventDefault();
        });
    </script>
@endsection
