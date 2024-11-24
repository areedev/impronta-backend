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
        <div class="card card-body">
            {!! Form::open([
                'route' => ['perfilevaluaciones.store'],
                'method' => 'POST',
                'enctype' => 'multipart/form-data',
            ]) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        {{ Form::label('nombre', 'Nombre', ['class' => 'form-label']) }}
                        {{ Form::text('nombre', null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-12  d-flex justify-content-between">
                    <a href="{{ route('perfilevaluaciones.index') }}" class="btn btn-danger rounded-pill">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        Siguiente
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('customjs')
    <script>
        $('body').on('click', '.editar-item', function(e) {
            e.preventDefault();
            var action = $(this).data('action');
            var modal = $('#modalgeneral');
            $.get(action, function(response) {
                modal.find('.modal-content-general').html(response.html);
                modal.modal('show');
            })
        });
    </script>
@endsection
