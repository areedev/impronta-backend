@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Clientes')
@section('descripcion', 'Listado de clientes')
@section('contenido')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Clientes</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="{{ URL::to('/') }}">Inicio</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Clientes
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
                <button data-bs-toggle="modal" data-bs-target="#nuevocliente"
                    class="btn btn-info d-flex align-items-center">
                    <i class="ti ti-plus text-white me-1 fs-5"></i> Nuevo Cliente
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
    <div class="modal fade" id="nuevocliente" tabindex="-1" role="dialog" aria-labelledby="nuevoclienteTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary d-flex align-items-center rounded-top">
                    <h5 class="modal-title  text-white ">Nuevo Cliente</h5>
                    <button type="button" class="btn-close  text-white " data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                {!! Form::open(['route' => 'empresas.store', 'method' => 'Post', 'enctype' => 'multipart/form-data']) !!}
                <div class="modal-body">
                    <div class="add-contact-box">
                        <div class="add-contact-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('nombre', 'Nombre de la Empresa', ['class' => 'form-label']) }}
                                        {{ Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Inserte el nombre']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('rut', 'RUT', ['class' => 'form-label']) }}
                                        <div class="input-group">
                                            <span class="input-group-text bg-warning text-white"><i
                                                    class="ti ti-alert-circle"></i></span>
                                            {{ Form::text('rut', null, ['class' => 'form-control bg-transparent rut', 'placeholder' => 'Inserte un RUT válido']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('contacto', 'Persona de contacto', ['class' => 'form-label']) }}
                                        {{ Form::text('contacto', null, ['class' => 'form-control', 'placeholder' => 'Inserte la persona de contacto']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('email', 'Correo', ['class' => 'form-label']) }}
                                        {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Inserte el correo']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('telefono', 'Teléfono de la persona de contacto', ['class' => 'form-label']) }}
                                        {{ Form::text('telefono', null, ['class' => 'form-control', 'placeholder' => 'Inserte el teléfono']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('faena', 'Faenas', ['class' => 'form-label']) }}
                                    {{ Form::select('faena[]', $faenas, null, ['class' => 'select2 form-control', 'multiple']) }}
                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('area', 'Areas', ['class' => 'form-label']) }}
                                    {{ Form::select('area[]', $areas, null, ['class' => 'select2 form-control', 'multiple']) }}
                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('logo', 'Logo', ['class' => 'form-label']) }}
                                    {{ Form::file('logo', ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    {{ Form::label('usuario', 'Usuario asociado a esta Empresa', ['class' => 'form-label']) }}
                                    <div>
                                        {{ Form::select('usuario', Arr::prepend($usuarios->toArray(),'',''), null, ['class' => 'select2 form-control']) }}
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
            dropdownParent: $('#nuevocliente'),
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
    $('body').on('click', '.editar-empresa', function(e) {
        e.preventDefault();
        var action = $(this).data('action');
        var modal = $('#modalgeneral');
        $.get(action, function(response) {
            modal.find('.modal-dialog').addClass('modal-lg');
            modal.find('.modal-content-general').html(response.html);
            $('.modal-content-general .select2').select2({
                dropdownParent: $('#modalgeneral'),
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
            $(".rut-editar").rut({
                validateOn: 'blur live keyup change',
                formatOn: 'change',
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
            });
            modal.modal('show');
        })
    });
    $('#buscador').on('keyup', function() {
        var valorBusqueda = $(this).val();
        $('#empresa-table').DataTable().search(valorBusqueda).draw();
    });
    $(function() {
        $(".rut").rut({
            validateOn: 'blur live keyup change',
            formatOn: 'change',
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
        });
    })
</script>
@endsection
@push('script')
{{ $dataTable->scripts() }}
<script>
    $('#empresa-table').on('draw.dt', function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endpush