@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Evaluaciones')
@section('descripcion', 'Mantenedor de evaluaciones')
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
    <div class="card card-body">
        <div class="row">
            <div class="col-md-4 col-xl-3">
                <form class="position-relative">
                    <input type="text" class="form-control product-search ps-5" id="buscador"
                        placeholder="Buscar..." />
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                </form>
            </div>
            @if (Auth::user()->hasRole(1))
            <div
                class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                <a href="{{ route('evaluaciones.create') }}" class="btn btn-info d-flex align-items-center">
                    <i class="ti ti-plus text-white me-1 fs-5"></i> Nueva Evaluación Practica
                </a>
            </div>
            @endif
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
    <div class="card card-body">
        <div class="table-responsive">
            {{ $dataTable->table(['width' => '100%', 'height' => '100%', 'class' => 'table table-bordered text-center']) }}
        </div>
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
    $('#buscador').on('keyup', function() {
        var valorBusqueda = $(this).val();
        $('#evaluacion-table').DataTable().search(valorBusqueda).draw();
    });
    $('body').on('click', '.crear-teorica', function(e) {
        e.preventDefault();
        var action = $(this).data('action');
        var modal = $('#modalgeneral');
        $.get(action, function(response) {
            modal.find('.modal-dialog').addClass('modal-xl');
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
    $('body').on('change', '.tipo', function(e) {
        e.preventDefault();
        var tipo = $(this).val();
        var action = "{{ route('perfilevaluaciones.competencia') }}";
        var $this = $(this);
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
            $('.preguntas').append(response.html);
            $('.select2' + response.random).select2({
                dropdownParent: $this.parent(),
                language: {
                    noResults: function() {
                        return "No hay resultado";
                    },
                    searching: function() {
                        return "Buscando..";
                    }
                },
                placeholder: 'Seleccionar'
            });
        })
    });
</script>
@endsection
@push('script')
{{ $dataTable->scripts() }}
<script>
    $('#evaluacion-table').on('draw.dt', function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endpush