<!DOCTYPE html>
<html lang="es" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme">

<head>
    <base href="{{ URL::to('/') }}" />
    <title>@yield('titulo') | Impronta</title>
    <meta name="description" content="@yield('descripcion')">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ URL::to('assets') }}/images/logos/favicon.png" />

    <link rel="stylesheet" href="{{ URL::to('assets') }}/css/styles.css" />
    <link rel="stylesheet" href="{{ URL::to('assets') }}/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ URL::to('assets') }}/libs/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ URL::to('assets') }}/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="{{ URL::to('assets') }}/libs/dragula/dist/dragula.min.css">
    <link rel="stylesheet"
        href="{{ URL::to('assets') }}/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ URL::to('assets') }}/libs/owl.carousel/dist/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="{{ URL::to('assets') }}/css/custom.css" />
    @yield('customcss')
</head>

<body>
    <div class="preloader">
        <img src="{{ URL::to('assets') }}/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        @include('layouts.includes.menu')
        <div class="page-wrapper">
            <header class="topbar">
                <div class="with-vertical">
                    <nav class="navbar navbar-expand-lg p-0 justify-content-between d-flex">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse"
                                    href="javascript:void(0)">
                                    <i class="ti ti-menu-2"></i>
                                </a>
                            </li>
                        </ul>

                        <div class="d-none d-lg-block w-50">
                            <input type="search" class="form-control fs-3 bg-white" placeholder="Buscar..."
                                id="buscadorglobal" />
                            <div id="resultados-busqueda"
                                class="message-body resultados-busqueda d-none bg-white rounded p-3 mb-2 shadow position-absolute w-50"
                                data-simplebar="">

                            </div>
                        </div>

                        <div class="d-block d-lg-none">
                            <img src="{{ URL::to('assets') }}/images/logos/logo.png"
                                style="filter: brightness(0) invert(1);" width="180" alt="" />
                        </div>
                        <a class="navbar-toggler nav-icon-hover p-0 border-0" href="javascript:void(0)"
                            data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="p-2">
                                <i class="ti ti-dots fs-7"></i>
                            </span>
                        </a>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <div class="d-flex align-items-center justify-content-between">

                                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">

                                    <li class="nav-item dropdown">
                                        <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-bell-ringing"></i>
                                            @if (count(Auth::user()->unreadNotifications) > 0)
                                            <div class="notification bg-info rounded-circle"></div>
                                            @endif     
                                        </a>
                                        <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                            aria-labelledby="drop2">
                                            <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                                <h5 class="mb-0 fs-5 fw-semibold">Notificaciones</h5>
                                                <span
                                                    class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">{{ count(Auth::user()->unreadNotifications) }}
                                                    nuevas</span>
                                            </div>
                                            <div class="message-body" data-simplebar>
                                                @foreach (Auth::user()->notifications->take(10) as $item)
                                                    <a href="{{ $item->data['url'] }}"
                                                        class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                        <div class="w-100 d-inline-block v-middle">
                                                            <h6 class="mb-1 fw-semibold lh-base text-wrap">
                                                                @if (!$item->read_at)
                                                                    <span
                                                                        class="badge badge-sm font-medium bg-primary-subtle text-primary">Nueva</span>
                                                                @endif
                                                                {{ $item->data['notificacion'] }}
                                                            </h6>
                                                            <span
                                                                class="fs-2 d-block text-body-secondary">{{ $item->created_at->format('d-m-Y h:m') }}</span>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                            <div class="py-6 px-7 mb-1">
                                                <a class="btn btn-outline-primary w-100"
                                                    href="{{ route('notificaciones.index') }}">Ver todas las
                                                    notificaciones</a>
                                            </div>

                                        </div>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link pe-0" href="javascript:void(0)" id="drop1"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <div class="user-profile-img">
                                                    <img src="{{ asset('uploads/avatars/' . Auth::user()->perfil->avatar . '') }}"
                                                        class="rounded-circle" width="35" height="35"
                                                        alt="" />
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                            aria-labelledby="drop1">
                                            <div class="profile-dropdown position-relative" data-simplebar>
                                                <div class="py-3 px-7 pb-0">
                                                    <h5 class="mb-0 fs-5 fw-semibold">Perfil de Usuario</h5>
                                                </div>
                                                <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                                    <img src="{{ asset('uploads/avatars/' . Auth::user()->perfil->avatar . '') }}"
                                                        class="rounded-circle" width="80" height="80"
                                                        alt="" />
                                                    <div class="ms-3">
                                                        <h5 class="mb-1 fs-3">{{ Auth::user()->perfil->nombre }}
                                                            {{ Auth::user()->perfil->apellido }}</h5>
                                                        <span
                                                            class="mb-1 d-block">{{ ucfirst(Auth::user()->roles[0]->name) }}</span>
                                                        <p class="mb-0 d-flex align-items-center gap-2">
                                                            <i class="ti ti-mail fs-4"></i> {{ Auth::user()->email }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="message-body">
                                                    <a href="{{ route('perfil.index') }}"
                                                        class="py-8 px-7 mt-8 d-flex align-items-center">
                                                        <span
                                                            class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                            <img src="{{ URL::to('assets') }}/images/svgs/icon-account.svg"
                                                                alt="" width="24" height="24" />
                                                        </span>
                                                        <div class="w-75 d-inline-block v-middle ps-3">
                                                            <h6 class="mb-1 fs-3 fw-semibold lh-base">Mi Perfil</h6>
                                                            <span class="fs-2 d-block text-body-secondary">Ajustes de
                                                                la cuenta</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="d-grid py-4 px-7 pt-8">
                                                    <a href="{{ URL::to('salir') }}"
                                                        class="btn btn-outline-primary">Cerrar Sesión</a>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>


            <div class="body-wrapper">
                <div class="container-fluid mw-100">
                    @include('layouts.includes.alertas')
                    @yield('contenido')
                    <!-- Modal genal -->
                    <div class="modal fade" id="modalgeneral" tabindex="-1" role="dialog"
                        aria-labelledby="modalgeneralTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-general">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function handleColorTheme(e) {
                    $("html").attr("data-color-theme", e);
                    $(e).prop("checked", !0);
                }
            </script>
            <button
                class="d-none btn btn-primary p-3 rounded-circle d-flex align-items-center justify-content-center customizer-btn"
                type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                aria-controls="offcanvasExample">
                <i class="icon ti ti-settings fs-7"></i>
            </button>

            <div class="offcanvas customizer offcanvas-end" tabindex="-1" id="offcanvasExample"
                aria-labelledby="offcanvasExampleLabel">
                <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                    <h4 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">
                        Settings
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body" data-simplebar style="height: calc(100vh - 80px)">
                    <h6 class="fw-semibold fs-4 mb-2">Theme</h6>

                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <input type="radio" class="btn-check" name="theme-layout" id="light-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="light-layout"><i
                                class="icon ti ti-brightness-up fs-7 me-2"></i>Light</label>

                        <input type="radio" class="btn-check" name="theme-layout" id="dark-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="dark-layout"><i
                                class="icon ti ti-moon fs-7 me-2"></i>Dark</label>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Direction</h6>
                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <input type="radio" class="btn-check" name="direction-l" id="ltr-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="ltr-layout"><i
                                class="icon ti ti-text-direction-ltr fs-7 me-2"></i>LTR</label>

                        <input type="radio" class="btn-check" name="direction-l" id="rtl-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="rtl-layout"><i
                                class="icon ti ti-text-direction-rtl fs-7 me-2"></i>RTL</label>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Colors</h6>

                    <div class="d-flex flex-row flex-wrap gap-3 customizer-box color-pallete" role="group">
                        <input type="radio" class="btn-check" name="color-theme-layout" id="Blue_Theme"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Blue_Theme')" for="Blue_Theme" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="BLUE_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-1">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="Aqua_Theme"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Aqua_Theme')" for="Aqua_Theme" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="AQUA_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-2">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="Purple_Theme"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Purple_Theme')" for="Purple_Theme" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="PURPLE_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-3">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="green-theme-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Green_Theme')" for="green-theme-layout"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="GREEN_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-4">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="cyan-theme-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Cyan_Theme')" for="cyan-theme-layout" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="CYAN_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-5">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="orange-theme-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Orange_Theme')" for="orange-theme-layout"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ORANGE_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-6">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Layout Type</h6>
                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <div>
                            <input type="radio" class="btn-check" name="page-layout" id="vertical-layout"
                                autocomplete="off" />
                            <label class="btn p-9 btn-outline-primary" for="vertical-layout"><i
                                    class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Vertical</label>
                        </div>
                        <div>
                            <input type="radio" class="btn-check" name="page-layout" id="horizontal-layout"
                                autocomplete="off" />
                            <label class="btn p-9 btn-outline-primary" for="horizontal-layout"><i
                                    class="icon ti ti-layout-navbar fs-7 me-2"></i>Horizontal</label>
                        </div>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Container Option</h6>

                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <input type="radio" class="btn-check" name="layout" id="boxed-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="boxed-layout"><i
                                class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Boxed</label>

                        <input type="radio" class="btn-check" name="layout" id="full-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="full-layout"><i
                                class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Full</label>
                    </div>

                    <h6 class="fw-semibold fs-4 mb-2 mt-5">Sidebar Type</h6>
                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <a href="javascript:void(0)" class="fullsidebar">
                            <input type="radio" class="btn-check" name="sidebar-type" id="full-sidebar"
                                autocomplete="off" />
                            <label class="btn p-9 btn-outline-primary" for="full-sidebar"><i
                                    class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Full</label>
                        </a>
                        <div>
                            <input type="radio" class="btn-check " name="sidebar-type" id="mini-sidebar"
                                autocomplete="off" />
                            <label class="btn p-9 btn-outline-primary" for="mini-sidebar"><i
                                    class="icon ti ti-layout-sidebar fs-7 me-2"></i>Collapse</label>
                        </div>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Card With</h6>

                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <input type="radio" class="btn-check" name="card-layout" id="card-with-border"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="card-with-border"><i
                                class="icon ti ti-border-outer fs-7 me-2"></i>Border</label>

                        <input type="radio" class="btn-check" name="card-layout" id="card-without-border"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="card-without-border"><i
                                class="icon ti ti-border-none fs-7 me-2"></i>Shadow</label>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="dark-transparent sidebartoggler"></div>

    <script src="{{ URL::to('assets') }}/libs/jquery/dist/jquery.min.js"></script>
    <script src="{{ URL::to('assets') }}/js/app.min.js"></script>
    <script src="{{ URL::to('assets') }}/js/app.init.js"></script>
    <script src="{{ URL::to('assets') }}/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::to('assets') }}/libs/simplebar/dist/simplebar.min.js"></script>

    <script src="{{ URL::to('assets') }}/js/sidebarmenu.js"></script>
    <script src="{{ URL::to('assets') }}/js/theme.js"></script>
    <script src="{{ URL::to('assets') }}/js/custom.js"></script>

    <script src="{{ URL::to('assets') }}/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="{{ URL::to('assets') }}/libs/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="{{ URL::to('assets') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="{{ URL::to('assets') }}/libs/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="{{ URL::to('assets') }}/js/jquery.rut.min.js"></script>
    <script src="{{ URL::to('assets') }}/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="{{ URL::to('assets') }}/libs/dragula/dist/dragula.min.js"></script>
    <script src="{{ URL::to('assets') }}/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ URL::to('assets') }}/libs/block-ui/jquery.blockUI.js"></script>
    <script src="{{ URL::to('assets') }}/js/widget/ui-card-init.js"></script>
    @if (request()->is('/'))
        <script src="{{ URL::to('assets') }}/js/dashboards/dashboard.js"></script>
    @endif
    <script>
        $(document).ready(function() {
            $('#buscadorglobal').on('input', function() {
                let searchTerm = $(this).val();
                if (searchTerm.length >= 2) {
                    $.ajax({
                        url: '/buscar',
                        data: {
                            search: searchTerm,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            $('#resultados-busqueda').html(response.html);
                            new SimpleBar(document.getElementById('resultados-busqueda'));
                            $('#resultados-busqueda').removeClass('d-none');
                        }
                    });
                } else {
                    // Ocultar los resultados
                    $('#resultados-busqueda').addClass('d-none');
                }
            });
        });
    </script>
    @yield('customjs')
    @stack('script')

</body>

</html>
