@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Escritorio')
@section('descripcion', 'Escritorio de usuario')
@section('contenido')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100 bg-info-subtle overflow-hidden shadow-none">
                <div class="card-body position-relative">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="d-flex align-items-center mb-7">
                                <div class="rounded-circle overflow-hidden me-6">
                                    <img src="{{ URL::to('assets') }}/images/profile/user-1.jpg" alt="" width="40"
                                        height="40">
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-0 fs-5">Bienvenido</h5>
                                    <h5>{{ Auth::user()->perfil->nombre }} {{ Auth::user()->perfil->apellido }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="welcome-bg-img mb-n7 text-end">
                                <img src="{{ URL::to('assets') }}/images/backgrounds/welcome-bg.svg" alt=""
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->hasRole(1))
        <div class="owl-carousel counter-carousel owl-theme">
            <div class="item">
                <div class="card border-0 zoom-in bg-primary-subtle shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="./assets/images/svgs/icon-user-male.svg" width="50" height="50" class="mb-3"
                                alt="" />
                            <p class="fw-semibold fs-3 text-primary mb-1">
                                Candidatos
                            </p>
                            <h5 class="fw-semibold text-primary mb-0">{{ $candidatos }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card border-0 zoom-in bg-warning-subtle shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="./assets/images/svgs/icon-briefcase.svg" width="50" height="50" class="mb-3"
                                alt="" />
                            <p class="fw-semibold fs-3 text-warning mb-1">Clientes</p>
                            <h5 class="fw-semibold text-warning mb-0">{{ $clientes }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="item">
                <div class="card border-0 zoom-in bg-info-subtle shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="./assets/images/svgs/icon-bar.svg" width="50" height="50" class="mb-3"
                                alt="" />
                            <p class="fw-semibold fs-3 text-info mb-1">Evaluaciones</p>
                            <h5 class="fw-semibold text-info mb-0">{{ $evaluaciones }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card border-0 zoom-in bg-danger-subtle shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-database mb-3"
                                width="50" height="50" viewBox="0 0 24 24" stroke-width="2" stroke="#fa896b"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <ellipse cx="12" cy="6" rx="8" ry="3" />
                                <path d="M4 6v6a8 3 0 0 0 16 0v-6" />
                                <path d="M4 12v6a8 3 0 0 0 16 0v-6" />
                            </svg>
                            <p class="fw-semibold fs-3 text-danger mb-1">Perfiles</p>
                            <h5 class="fw-semibold text-danger mb-0">{{ $perfiles }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Evaluaciones por Perfil</h5>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div id="perfiles"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Aprobados vs No Aprobados</h5>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div id="vsaprobados"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
    <script>
        var por_perfil = {
            series: @json($evaluacionesPorPerfil->values()),
            chart: {
                fontFamily: '"Nunito Sans", sans-serif',
                width: 380,
                height: '300px',
                type: "pie",
            },
            colors: ["var(--bs-primary)", "var(--bs-secondary)", "#ffae1f", "#fa896b", "#39b69a"],
            labels: @json($evaluacionesPorPerfil->keys()),
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200,
                    },
                    legend: {
                        position: "bottom",
                    },
                },
            }, ],
            legend: {
                labels: {
                    colors: ["#a1aab2"],
                },
                position: "bottom",
            },
        };
        var chart_por_perfil = new ApexCharts(
            document.querySelector("#perfiles"),
            por_perfil
        );
        chart_por_perfil.render();

        var vs_aprobados = {
            series: {{ $aprobaciones->values() }},
            chart: {
                fontFamily: '"Nunito Sans", sans-serif',
                width: 380,
                height: '300px',
                type: "pie",
            },
            colors: ["var(--bs-danger)", "var(--bs-info)", "#ffae1f", "#fa896b", "#39b69a"],
            labels: ["No Aprobados", "Aprobados"],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200,
                    },
                    legend: {
                        position: "bottom",
                    },
                },
            }, ],
            legend: {
                labels: {
                    colors: ["#a1aab2"],
                },
                position: "bottom",
            },
        };
        var chart_vs_aprobados = new ApexCharts(
            document.querySelector("#vsaprobados"),
            vs_aprobados
        );
        chart_vs_aprobados.render();
    </script>
@endsection
