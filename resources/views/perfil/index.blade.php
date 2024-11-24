@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Gerencias')
@section('descripcion', 'Mantenedor de Gerencias')
@section('contenido')
    <div class="row">
        <div class="col-lg-12 mb-4">
            <a href="{{ route('perfil.index') }}" class="btn btn-primary"><i class="bi bi-person-fill-gear fs-4 me-2"></i>
                Cuenta</a>
            <a href="{{ route('perfil.seguridad') }}" class="btn btn-light"><i class="bi bi-person-fill-lock fs-4 me-2"></i>
                Seguridad</a>
        </div>
        <div class="col-12">
            <!-- profile -->
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Detalles de Usuario</h4>
                </div>
                <div class="card-body py-2 my-25">
                    <!-- header section -->
                    <!-- form -->
                    <form class="validate-form mt-2 pt-50" action="{{ route('perfil.update') }}" method="POST"
                        enctype="multipart/form-data">
                        <div class="d-flex">
                            <a href="#" class="me-25">
                                <img src="{{ asset('uploads/avatars/' . Auth::user()->perfil->avatar . '') }}"
                                    id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image"
                                    width="100" />
                            </a>
                            <!-- upload and reset button -->
                            <div class="d-flex align-items-end mt-75 ms-1">
                                <div>
                                    <label for="account-upload" class="btn btn-sm btn-primary mb-75 me-75">Cambiar</label>
                                    <input type="file"hidden name="imagen" id="account-upload"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" filesize="1073741824" />
                                    <p class="mb-0">Tipos de archivo permitidos: png, jpg, jpeg.</p>
                                </div>
                            </div>
                            <!--/ upload and reset button -->
                        </div>
                        <!--/ header section -->


                        @csrf
                        <div class="row mt-4">
                            <div class="col-12 col-sm-6 mb-4">
                                <label class="form-label" for="accountFirstName">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    placeholder="Nombre" value="{{ $usuario->perfil->nombre }}"
                                    data-msg="Por favor, introduzca el nombre" />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountLastName">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido"
                                    placeholder="Apellido" value="{{ $usuario->perfil->apellido }}"
                                    data-msg="Por favor, introduzca su apellido" />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                    value="{{ $usuario->email }}" />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="movil">Teléfono</label>
                                <input type="text" class="form-control " id="telefono" name="telefono"
                                    placeholder="+56123456789" value="{{ $usuario->perfil->telefono }}" />
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">Guardar Cambios</button>
                            </div>
                        </div>
                    </form>
                    <!--/ form -->
                </div>
            </div>
            <!--/ profile -->
        </div>
    </div>
@endsection
@section('customjs')
    <script>
        $(function() {
            ('use strict');

            var accountUploadBtn = $('#account-upload'),
                accountUploadImg = $('#account-upload-img'),
                accountPerfilUploadImg = $('#account-upload-img-perfil'),
                accountUserImage = $('.uploadedAvatar'),
                accountResetBtn = $('#account-reset');
            if (accountUserImage) {
                var resetImage = accountUserImage.attr('src');
                accountUploadBtn.on('change', function(e) {
                    var reader = new FileReader(),
                        files = e.target.files;
                    reader.onload = function() {
                        if (accountUploadImg) {
                            accountUploadImg.attr('src', reader.result);
                        }
                        if (accountPerfilUploadImg)
                            accountPerfilUploadImg.attr('src', reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                });

                accountResetBtn.on('click', function() {
                    accountUserImage.attr('src', resetImage);
                });
            }
        });
    </script>
@endsection
