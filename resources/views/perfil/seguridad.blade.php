@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Gerencias')
@section('descripcion', 'Mantenedor de Gerencias')
@section('contenido')
    <div class="row">
        <div class="col-lg-12 mb-4">
            <a href="{{ route('perfil.index') }}" class="btn btn-light"><i class="bi bi-person-fill-gear fs-4 me-2"></i>
                Cuenta</a>
            <a href="{{ route('perfil.seguridad') }}" class="btn btn-primary"><i class="bi bi-person-fill-lock fs-4 me-2"></i>
                Seguridad</a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Cambiar Contraseña</h4>
                </div>
                <div class="card-body pt-1">
                    @if (session('status'))
                        <div class="alert alert-success p-1">
                            <p><i data-feather="check-circle" class="me-50"></i> {{ session('status') }}</p>
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger p-1">
                            <p><i data-feather="alert-octagon" class="me-50"></i> {{ session('error') }}</p>
                        </div>
                    @endif
                    <!-- form -->
                    <form class="validate-form" method="POST" action="{{ route('update-password') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-6 mb-4">
                                <label class="form-label" for="account-old-password">Contraseña Actual</label>
                                <div class="input-group form-password-toggle input-group-merge">
                                    <input type="password" class="form-control" id="account-old-password"
                                        name="old_password" placeholder="Introduzca la contraseña actual"
                                        data-msg="Por favor, la contraseña actual" />
                                    <div class="input-group-text cursor-pointer">
                                        <i class="bi bi-eye"></i>
                                    </div>
                                </div>
                                @error('old_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 mb-4">
                                <label class="form-label" for="account-new-password">Nueva contraseña</label>
                                <div class="input-group form-password-toggle input-group-merge">
                                    <input type="password" id="account-new-password" name="new_password"
                                        class="form-control" placeholder="Introduzca la contraseña nuevo" />
                                    <div class="input-group-text cursor-pointer">
                                        <i class="bi bi-eye"></i>
                                    </div>
                                </div>
                                @error('new_password')
                                    <div class="alert alert-danger mt-1 alert-validation-msg p-1" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6 mb-4">
                                <label class="form-label" for="account-retype-new-password">Repetir Nueva contraseña</label>
                                <div class="input-group form-password-toggle input-group-merge">
                                    <input type="password" class="form-control" id="account-retype-new-password"
                                        name="new_password_confirmation" placeholder="Confirma la contraseña" />
                                    <div class="input-group-text cursor-pointer"><i class="bi bi-eye"></i></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="alert alert-dismissible bg-primary d-flex flex-column flex-sm-row mb-10">
                                    <i class="bi bi-info-circle fs-4 me-4 text-white"></i>
                                    <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                                        <span>Mínimo 8 caracteres - cuanto más, mejor</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary me-1 mt-1">Guardar</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1">Descartar</button>
                            </div>
                        </div>
                    </form>
                    <!--/ form -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
    <script>
        $('.form-password-toggle .input-group-text').on('click', function(e) {
            e.preventDefault();
            var $this = $(this),
                inputGroupText = $this.closest('.form-password-toggle'),
                formPasswordToggleIcon = $this,
                formPasswordToggleInput = inputGroupText.find('input');

            if (formPasswordToggleInput.attr('type') === 'text') {
                formPasswordToggleInput.attr('type', 'password');
                formPasswordToggleIcon.find('i').replaceWith('<i class="bi bi-eye"></i>');

            } else if (formPasswordToggleInput.attr('type') === 'password') {
                formPasswordToggleInput.attr('type', 'text');
                formPasswordToggleIcon.find('i').replaceWith('<i class="bi bi-eye-slash"></i>');
            }
        });
    </script>
@endsection
