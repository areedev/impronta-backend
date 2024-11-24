<!DOCTYPE html>
<html lang="es" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="shortcut icon" type="image/png" href="{{ URL::to('assets') }}/images/logos/favicon.png" />

    <link rel="stylesheet" href="{{ URL::to('assets') }}/css/styles.css" />

    <title>Impronta - Iniciar Sesión</title>
</head>

<body>
    <div class="preloader">
        <img src="{{ URL::to('assets') }}/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 w-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-10 col-xxl-6">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6 p-0">
                                <div class="h-100 p-2" style="background-image:url({{asset('assets/images/login/bg2.jpg')}}); background-size: cover; background-position: center;">
                                    <a href="#"
                                    class="text-nowrap logo-img text-center d-block mb-5 w-100">
                                    <img src="{{ URL::to('assets') }}/images/logos/logo.png"
                                        class="dark-logo" alt="Logo-Dark" />
                                    <img src="{{ URL::to('assets') }}/images/logos/logo.png"
                                        class="light-logo" alt="Logo-light" />
                                </a>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6 p-0">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <h2 class="mb-5 text-center mt-5">¡Bienvenido!</h2>
                                        <hr>
                                        @include('layouts.includes.alertas')
                                        <form method="post" action="{{route('login.post')}}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1">@</span>
                                                    <input type="email" name="email" id="email"
                                                        class="form-control" placeholder="Email" aria-label="Email"
                                                        aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="password" class="form-label">Contraseña</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1"><i
                                                            class="ti ti-key"></i></span></span>
                                                    <input type="password" name="password" id="password"
                                                        class="form-control" placeholder="Contraseña" aria-label="Contraseña"
                                                        aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <div class="form-check">
                                                    <input class="form-check-input primary" type="checkbox"
                                                        value="" id="recordar" checked>
                                                    <label class="form-check-label text-dark" for="recordar">
                                                        Recuerda este dispositivo
                                                    </label>
                                                </div>
                                                <a class="text-primary fw-medium" href="#">¿Olvidaste tu
                                                    contraseña?</a>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Iniciar
                                                Sesión</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
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

</body>

</html>
