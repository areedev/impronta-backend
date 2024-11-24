@extends('layouts.principal')
@section('customcss')
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
    <style>
        .fm .fm-navbar .text-right .btn-group:nth-child(3) {
            display: none !important;
        }
    </style>
@endsection
@section('titulo', 'Biblioteca')
@section('descripcion', 'Biblioteca de archivos')
@section('contenido')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Biblioteca</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ URL::to('/') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Biblioteca
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
            <div id="fm" style="height: 600px;"></div>
        </div>
    </div>
@endsection
@section('customjs')
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endsection
