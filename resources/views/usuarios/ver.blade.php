@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Candidato ' . $candidato->nombre . '')
@section('descripcion', 'Vista de detalles del candidato')
@section('contenido')
<div class="d-flex flex-row gap-3 customizer-box mb-3" role="group">
    <input type="radio" class="btn-check" name="layout" id="boxed-layout" autocomplete="off">
    <label class="btn p-9 btn-outline-primary" for="boxed-layout"><i class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Contraer</label>

    <input type="radio" class="btn-check" name="layout" id="full-layout" autocomplete="off">
    <label class="btn p-9 btn-outline-primary" for="full-layout"><i class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Expandir</label>
</div>
    <div class="row">
        <div class="col-lg-6 col-md-6 mb-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <img src="{{ $candidato->foto ? asset('uploads/candidatos/' . $candidato->id . '/foto/' . $candidato->foto . '') : '../assets/images/profile/user-1.jpg' }}"
                        class="rounded-1 img-fluid" width="180">
                    <div class="mt-n2">
                        @if ($candidato->estado == 1)
                            <span class="badge text-bg-success">Activo</span>
                        @else
                            <span class="badge text-bg-primary">Inactivo</span>
                        @endif

                        <h3 class="card-title mt-3">Nombre: {{ $candidato->nombre }}</h3>
                        <h6 class="card-subtitle">Empresa: {{ $candidato->empresa->nombre }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title mb-0">Archivos</h4>
                    </div>
                    @if ($candidato->ci || $candidato->licencia_municipal || $candidato->licencia_interna || $candidato->cv)
                    <div class="row mt-3">
                        @if ($candidato->ci)
                            <div class="col-6 mb-3">
                                <a href="{{ asset('uploads/candidatos/' . $candidato->id . '/documentos/' . $candidato->ci . '') }}"
                                    target="_blank" class="text-center rounded-1 border py-3 d-block">
                                    <i class="ti ti-file-description display-6 text-info"></i>
                                    <span class="text-muted d-block">C.I</span>
                                </a>
                            </div>
                        @endif
                        @if ($candidato->licencia_municipal)
                            <div class="col-6 mb-3">
                                <a href="{{ asset('uploads/candidatos/' . $candidato->id . '/documentos/' . $candidato->licencia_municipal . '') }}"
                                    target="_blank" class="text-center rounded-1 border py-3 d-block">
                                    <i class="ti ti-file-description display-6 text-primary"></i>
                                    <span class="text-muted d-block">Licencia Municipal</span>
                                </a>
                            </div>
                        @endif
                        @if ($candidato->licencia_interna)
                            <div class="col-6">
                                <a href="{{ asset('uploads/candidatos/' . $candidato->id . '/documentos/' . $candidato->licencia_interna . '') }}"
                                    target="_blank" class="text-center rounded-1 border py-3 d-block">
                                    <i class="ti ti-file-description display-6 text-warning"></i>
                                    <span class="text-muted d-block">Licencia Interna</span>
                                </a>
                            </div>
                        @endif
                        @if ($candidato->cv)
                            <div class="col-6">
                                <a href="{{ asset('uploads/candidatos/' . $candidato->id . '/documentos/' . $candidato->cv . '') }}"
                                    target="_blank" class="text-center rounded-1 border py-3 d-block">
                                    <i class="ti ti-file-description display-6 text-secondary"></i>
                                    <span class="text-muted d-block">CV</span>
                                </a>
                            </div>
                        @endif
                    </div>
                    @else
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <h6>Aun no se han cargado archivos</h6>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4>Historial de Evaluaciones</h4>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table border">
                            <tbody>
                                <tr>
                                    <td>Lorem ipsum</td>
                                    <td><span class="mb-1 badge font-medium bg-success-subtle text-success fw-bold">Aprobado</span></td>
                                    <td><button class="btn btn-sm btn-info">Ver</button></td>
                                </tr>      
                                <tr>
                                    <td>Lorem ipsum</td>
                                    <td><span class="mb-1 badge font-medium bg-danger-subtle text-danger fw-bold">Reprobado</span></td>
                                    <td><button class="btn btn-sm btn-info">Ver</button></td>
                                </tr>      
                                <tr>
                                    <td>Lorem ipsum</td>
                                    <td><span class="mb-1 badge font-medium bg-info-subtle text-info fw-bold">En Proceso</span></td>
                                    <td><button class="btn btn-sm btn-info">Ver</button></td>
                                </tr>                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
