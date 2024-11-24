<!DOCTYPE html>
<html lang="es" dir="ltr" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/png" href="{{ URL::to('assets') }}/images/logos/favicon.png" />
    <link rel="stylesheet" href="{{ URL::to('assets') }}/css/styles.css" />
    <title>404</title>
</head>

<body>
    <div class="preloader">
        <img src="{{ URL::to('assets') }}/images/logos/favicon.png" alt="loader"
            class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        <div
            class="position-relative overflow-hidden min-vh-100 w-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-lg-4">
                        <div class="text-center">
                            <img src="{{ URL::to('assets') }}/images/svgs/404.svg" alt=""
                                class="img-fluid" width="500">
                            <h1 class="fw-semibold my-7 fs-9">Página no encontrada </h1>
                            <h4 class="fw-semibold mb-7">Es posible que la página que está buscando se haya eliminado, se haya cambiado de nombre o no esté disponible temporalmente.</h4>
                            <a class="btn btn-primary" href="{{URL::to('/')}}" role="button">Volver al inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ URL::to('assets') }}/libs/jquery/dist/jquery.min.js"></script>
    <script src="{{ URL::to('assets') }}/js/app.min.js"></script>
    <script src="{{ URL::to('assets') }}/js/app.init.js"></script>
    <script src="{{ URL::to('assets') }}/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::to('assets') }}/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="{{ URL::to('assets') }}/js/sidebarmenu.js"></script>
    <script src="{{ URL::to('assets') }}/js/theme.js"></script>
</body>

</html>
