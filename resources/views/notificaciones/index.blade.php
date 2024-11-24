@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Notificaciones')
@section('descripcion', 'Notificaciones')
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
            <div class="col-4"><a href="{{route('notificaciones.leer')}}" class="btn btn-primary border mb-2">Marcar notificaciones como leídas</a></div>

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th>Notificacion</th>
                            <th>Fecha</th>
                            <th>Enlace</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Auth::user()->notifications->take(100) as $item)
                            <tr>
                                <td>
                                    @if (!$item->read_at)
                                        <span class="badge badge-sm font-medium bg-primary-subtle text-primary">Nueva</span>
                                    @endif {{ $item->data['notificacion'] }}
                                </td>
                                <td>{{ $item->created_at->format('d-m-Y h:m') }}</td>
                                <td><a href="{{ $item->data['url'] }}" class="btn btn-info border me-2">Ver</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
