@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Ver Evaluación')
@section('descripcion', 'Ver evaluación')
@section('contenido')
    <div class="widget-content searchable-container list">
        <div class="d-flex flex-row gap-3 customizer-box mb-3" role="group">
            <input type="radio" class="btn-check" name="layout" id="boxed-layout" autocomplete="off">
            <label class="btn p-9 btn-outline-primary" for="boxed-layout"><i
                    class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Contraer</label>

            <input type="radio" class="btn-check" name="layout" id="full-layout" autocomplete="off">
            <label class="btn p-9 btn-outline-primary" for="full-layout"><i
                    class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Expandir</label>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <div class="row align-items-center">
                    <div class="col-lg-12 mt-n3 order-lg-2 order-1">
                        <div class="mt-1">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <div class="linear-gradient d-flex align-items-center justify-content-center rounded-circle"
                                    style="width: 110px; height: 110px;" ;>
                                    <div class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden"
                                        style="width: 100px; height: 100px;" ;>
                                        <img src="{{ $evaluacion->candidato->foto ? asset('uploads/candidatos/' . $evaluacion->candidato->id . '/foto/' . $evaluacion->candidato->foto . '') : '../uploads/avatars/avatar.png' }}"
                                            alt="" class="w-100 h-100">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h5 class="fs-5 mb-0 fw-semibold">{{ $evaluacion->candidato->nombre }}</h5>
                                <p class="mb-0 fs-4">{{ $evaluacion->candidato->empresa->nombre }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 mt-2 bg-light-subtle">
                    @if ($evaluacion->teorica && $evaluacion->resultado)
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Resultado</h4>
                                <div class="btn-group w-100">
                                    <button type="button" class="btn btn-outline-primary d-block mb-3 w-100">Nota Practica:
                                        {{ $evaluacion->nota_practica }}</button>
                                    <button type="button" class="btn btn-outline-primary d-block mb-3 w-100">Nota Teorica:
                                        {{ $evaluacion->teorica->nota }}</button>
                                    <button type="button" class="btn btn-outline-primary d-block mb-3 w-100">Nota Final:
                                        {{ $evaluacion->nota_total + $evaluacion->teorica->nota_total }}</button>
                                    <button type="button"
                                        class="btn d-block mb-3 w-100 {{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total < 75 ? 'btn-danger' : '' }} {{ $evaluacion->aprobacion->estado == 0 ? 'btn-danger' : 'btn-success text-dark' }}">Porcentaje
                                        Final:
                                        {{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total }}%</button>
                                    <button type="button"
                                        class="btn {{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total < 75 ? 'btn-outline-danger' : '' }} {{ $evaluacion->aprobacion->estado == 0 ? 'btn-outline-danger' : 'btn-outline-success text-dark' }} d-block mb-3 w-100">{{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total < 75 || $evaluacion->aprobacion->estado == 0 ? 'TRABAJADOR NO ACREDITADO' : 'TRABAJADOR ACREDITADO' }}</button>
                                </div>
                            </div>
                            <a href="{{ route('evaluaciones.pdf', $evaluacion->id) }}" class="btn btn-primary my-3"
                                target="_blank">Ver/Descargar Informe</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header text-bg-info">
                        <h4 class="mb-0 text-white card-title">Información del Candidato</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive rounded-2 mb-4">
                            <table class="table border text-nowrap customize-table mb-0 align-middle">
                                <tbody>
                                    <tr>
                                        <td class="text-dark fw-bolder fs-4">Nombre</td>
                                        <td class="fs-4">{{ $evaluacion->candidato->nombre }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark fw-bolder fs-4">RUT</td>
                                        <td class="fs-4">{{ $evaluacion->candidato->rut }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark fw-bolder fs-4">Email</td>
                                        <td class="fs-4">{{ $evaluacion->candidato->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark fw-bolder fs-4">Telefono</td>
                                        <td class="fs-4">{{ $evaluacion->candidato->telefono }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-dark fw-bolder fs-4">Empresa</td>
                                        <td class="fs-4">{{ $evaluacion->candidato->empresa->nombre }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 mb-3">
                <div class="card h-100">
                    <div class="card-header text-bg-info">
                        <h4 class="mb-0 text-white card-title">Archivos del Candidato</h4>
                    </div>
                    <div class="card-body">
                        @if (
                            $evaluacion->candidato->ci ||
                                $evaluacion->candidato->licencia_municipal ||
                                $evaluacion->candidato->licencia_interna ||
                                $evaluacion->candidato->cv)
                            <div class="row mt-3">
                                @if ($evaluacion->candidato->ci)
                                    <div class="col-6 mb-3">
                                        <a href="{{ asset('uploads/candidatos/' . $evaluacion->candidato->id . '/documentos/' . $evaluacion->candidato->ci . '') }}"
                                            target="_blank" class="text-center rounded-1 border py-3 d-block">
                                            <i class="ti ti-file-description display-6 text-info"></i>
                                            <span class="text-muted d-block">C.I</span>
                                        </a>
                                    </div>
                                @endif
                                @if ($evaluacion->candidato->licencia_municipal)
                                    <div class="col-6 mb-3">
                                        <a href="{{ asset('uploads/candidatos/' . $evaluacion->candidato->id . '/documentos/' . $evaluacion->candidato->licencia_municipal . '') }}"
                                            target="_blank" class="text-center rounded-1 border py-3 d-block">
                                            <i class="ti ti-file-description display-6 text-primary"></i>
                                            <span class="text-muted d-block">Licencia Municipal</span>
                                        </a>
                                    </div>
                                @endif
                                @if ($evaluacion->candidato->licencia_interna)
                                    <div class="col-6">
                                        <a href="{{ asset('uploads/candidatos/' . $evaluacion->candidato->id . '/documentos/' . $evaluacion->candidato->licencia_interna . '') }}"
                                            target="_blank" class="text-center rounded-1 border py-3 d-block">
                                            <i class="ti ti-file-description display-6 text-warning"></i>
                                            <span class="text-muted d-block">Licencia Interna</span>
                                        </a>
                                    </div>
                                @endif
                                @if ($evaluacion->candidato->cv)
                                    <div class="col-6">
                                        <a href="{{ asset('uploads/candidatos/' . $evaluacion->candidato->id . '/documentos/' . $evaluacion->candidato->cv . '') }}"
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
            <div class="col-lg-12 mb-3">
                <div class="card">
                    <div class="card-header bg-info d-flex align-items-center">
                        <h4 class="mb-0 text-white card-title">Información de la Evaluación</h4>
                        <div class="card-actions cursor-pointer ms-auto d-flex button-group">
                            <a class="link text-white d-flex align-items-center" data-action="collapse"><i
                                    class="ti fs-6 ti-minus"></i></a>
                            <a class="mb-0 text-white btn-minimize px-2 cursor-pointer link d-flex align-items-center"
                                data-action="expand"><i class="ti ti-arrows-maximize fs-6"></i></a>
                        </div>
                    </div>
                    <div class="card-body show">
                        @if (Auth::user()->hasRole(['administrador']))
                            {!! Form::open([
                                'route' => ['evaluaciones.informacion', $evaluacion->id],
                                'method' => 'PUT',
                                'enctype' => 'multipart/form-data',
                            ]) !!}
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="mb-3">Datos del Candidato y Evaluador</h4>
                                <div class="card card-body">
                                    <div class="mb-3">
                                        {{ Form::label('rut', 'RUT', ['class' => 'form-label']) }}
                                        <div class="input-group">
                                            {{ Form::text('rut', $evaluacion->candidato->rut, ['readonly', 'class' => 'form-control bg-transparent rut', 'required', 'placeholder' => 'Inserte un RUT válido']) }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('nombre', 'Nombre', ['class' => 'form-label']) }}
                                        {{ Form::text('nombre', $evaluacion->candidato->nombre, ['readonly', 'class' => 'form-control']) }}
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('cargo', 'Cargo', ['class' => 'form-label']) }}
                                        {{ Form::text('cargo', $evaluacion->cargo, ['readonly', 'class' => 'form-control']) }}
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('evaluador', 'Evaluador Asignado', ['class' => 'form-label']) }}
                                        {{ Form::text('evaluador', $evaluacion->evaluador_asignado, ['readonly', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4 class="mb-3">Datos de Empresa</h4>
                                <div class="card card-body">
                                    <div class="mb-3">
                                        {{ Form::label('empresa', 'Empresa', ['class' => 'form-label']) }}
                                        <div>
                                            {{ Form::select('empresa', [$evaluacion->empresa_id => $evaluacion->empresa->nombre], $evaluacion->candidato->empresa_id, ['disabled', 'class' => 'form-control select2', 'placeholder' => 'Seleccionar']) }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('faena', 'Faena', ['class' => 'form-label']) }}
                                        <div>
                                            {{ Form::select('faena', [$evaluacion->faena_id => $evaluacion->faena->nombre], $evaluacion->faena_id, [Auth::user()->hasRole(['administrador']) ? '' : 'disabled', 'class' => 'form-control select2', 'placeholder' => 'Seleccionar']) }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('area', 'Area', ['class' => 'form-label']) }}
                                        <div>
                                            {{ Form::select('area', [$evaluacion->area_id => $evaluacion->area->nombre], $evaluacion->area_id, [Auth::user()->hasRole(['administrador']) ? '' : 'disabled', 'class' => 'form-control select2', 'placeholder' => 'Seleccionar']) }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('fecha_solicitud', 'Fecha de Solicitud', ['class' => 'form-label']) }}
                                        {{ Form::date('fecha_solicitud', $evaluacion->fecha_solicitud, [Auth::user()->hasRole(['administrador']) ? '' : 'readonly', 'class' => 'form-control']) }}
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('fecha_ejecucion', 'Fecha de Ejecución', ['class' => 'form-label']) }}
                                        {{ Form::date('fecha_ejecucion', $evaluacion->fecha_ejecucion, [Auth::user()->hasRole(['administrador']) ? '' : 'readonly', 'class' => 'form-control']) }}
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('fecha_emision', 'Fecha de Emisión', ['class' => 'form-label']) }}
                                        {{ Form::date('fecha_emision', $evaluacion->fecha_emision, [Auth::user()->hasRole(['administrador']) ? '' : 'readonly', 'class' => 'form-control']) }}
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('certificado', 'Certificado/Informe', ['class' => 'form-label']) }}
                                        {{ Form::text('certificado', $evaluacion->certificado, [Auth::user()->hasRole(['administrador']) ? '' : 'readonly', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4 class="mb-3">Datos de la Evaluación</h4>
                                <div class="card card-body">
                                    <div class="mb-3">
                                        {{ Form::label('equipo', 'Equipo', ['class' => 'form-label']) }}
                                        {{ Form::text('equipo', $evaluacion->equipo, [Auth::user()->hasRole(['administrador']) ? '' : 'readonly', 'class' => 'form-control']) }}
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('marca', 'Marca', ['class' => 'form-label']) }}
                                        {{ Form::text('marca', $evaluacion->marca, [Auth::user()->hasRole(['administrador']) ? '' : 'readonly', 'class' => 'form-control']) }}
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('modelo', 'Modelo', ['class' => 'form-label']) }}
                                        {{ Form::text('modelo', $evaluacion->modelo, [Auth::user()->hasRole(['administrador']) ? '' : 'readonly', 'class' => 'form-control']) }}
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('year', 'Año', ['class' => 'form-label']) }}
                                        {{ Form::text('year', $evaluacion->year, ['class' => 'form-control yearpicker', Auth::user()->hasRole(['administrador']) ? '' : 'readonly']) }}
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('perfil_evaluacion', 'Tipo de perfil', ['class' => 'form-label']) }}
                                        <div>
                                            {{ Form::select('perfil_evaluacion', $perfiles, $evaluacion->perfil_evaluacion_id, ['class' => 'form-control select2', 'disabled', 'placeholder' => 'Seleccionar']) }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('condiciones', 'Chequeo de condiciones', ['class' => 'form-label']) }}
                                        @if (Auth::user()->hasRole(['administrador']))
                                            <div>
                                                {{ Form::file('condiciones', ['class' => 'form-control']) }}
                                            </div>
                                        @endif
                                        @if ($evaluacion->condiciones)
                                            <a href="{{ asset('uploads/evaluacion/' . $evaluacion->id . '/condiciones/' . $evaluacion->condiciones . '') }}"
                                                target="_blank"
                                                class="btn btn-outline-primary d-block mb-3 w-100">Descargar</a>
                                        @else
                                            <button class="btn btn-outline-danger d-block mt-3 w-100"> Archivo no
                                                disponible</button>
                                        @endif

                                    </div>
                                    @if (Auth::user()->hasRole(['administrador']))
                                        <button type="submit" class="btn btn-primary rounded-pill">
                                            Guardar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if (Auth::user()->hasRole(['administrador']))
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mb-3">
                <div class="card">
                    <div class="card-header text-bg-primary d-flex align-items-center">
                        <h4 class="mb-0 text-white card-title">Evaluación Practica:
                            {{ $evaluacion->perfilEvaluacion->nombre }}</h4>
                        <div class="card-actions cursor-pointer ms-auto d-flex button-group">
                            <a class="link text-white d-flex align-items-center" data-action="collapse"><i
                                    class="ti fs-6 ti-minus"></i></a>
                            <a class="mb-0 text-white btn-minimize px-2 cursor-pointer link d-flex align-items-center"
                                data-action="expand"><i class="ti ti-arrows-maximize fs-6"></i></a>
                        </div>
                    </div>
                    <div class="card-body show">
                        @if ($evaluacion->resultado->isNotEmpty())
                            @foreach ($evaluacion->perfilEvaluacion->secciones as $llave => $seccion)
                                <div class="col-md-12 mb-3">
                                    <h5 class="border-bottom border-primary pb-3">Resultados sección:
                                        {{ $seccion->nombre }}
                                    </h5>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="table-responsive rounded-4">
                                        <table class="table table-bordered border-primary">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item</th>
                                                    <th>Nota</th>
                                                    <th>% de evaluación</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i=1; @endphp
                                                @foreach ($seccion->items as $item)
                                                    @php
                                                        $resultado = $evaluacion->resultado
                                                            ->where('item_id', $item->id)
                                                            ->first();
                                                        $brechas = explode(
                                                            ',',
                                                            $evaluacion->aprobacion->brechas_criticas,
                                                        );

                                                    @endphp
                                                    <tr>
                                                        <td
                                                            class="{{ in_array($item->competencia->id, $brechas) ? 'bg-danger text-white' : '' }}">
                                                            {{ $i }}</td>
                                                        <td
                                                            class="{{ in_array($item->competencia->id, $brechas) ? 'bg-danger text-white' : '' }}">
                                                            {{ $item->competencia->nombre }}
                                                            @if ($resultado && $resultado->comentario)
                                                                <hr>
                                                                <p><span class="fw-bold">Comentarios:</span>
                                                                    {{ $resultado->comentario }}</p>
                                                            @endif
                                                        </td>
                                                        <td
                                                            class="{{ in_array($item->competencia->id, $brechas) ? 'bg-danger text-white' : '' }}">
                                                            {{ isset($resultado->nota) ? $resultado->nota : null }}
                                                        </td>
                                                        <td
                                                            class="{{ in_array($item->competencia->id, $brechas) ? 'bg-danger text-white' : '' }}">
                                                            {{ isset($resultado->porcentaje) ? $resultado->porcentaje : null }}
                                                        </td>
                                                    </tr>
                                                    @if (count($item->competencia->criterios) > 0)
                                                        <tr class="bg-primary text-white">
                                                            <td colspan="2" class="bg-primary text-white border-0">Item
                                                                Criterio Interno</td>
                                                            <td class="bg-primary text-white border-0">Nota</td>
                                                            <td class="bg-primary text-white border-0">Porcentaje</td>
                                                        </tr>
                                                        @foreach ($item->competencia->criterios as $criterio)
                                                            <tr>
                                                                @php
                                                                    $resultadocriterio = $evaluacion->criterios
                                                                        ->where('criterio_id', $criterio->id)
                                                                        ->first();
                                                                @endphp
                                                                <td colspan="2" class="bg-primary text-white border-0">
                                                                    -
                                                                    {{ $criterio->criterio }}
                                                                    @if ($resultadocriterio && $resultadocriterio->comentarios)
                                                                        <hr>
                                                                        <p><span class="fw-bold">Comentarios:</span>
                                                                            {{ $resultadocriterio->comentarios }}</p>
                                                                    @endif
                                                                </td>
                                                                <td class="bg-primary text-white border-0">
                                                                    {{ $resultadocriterio->nota }}</td>
                                                                <td class="bg-primary text-white border-0">
                                                                    {{ number_format(($resultadocriterio->nota / 4) * 100, 2) }}
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                            <h5>Leyenda</h5>
                            <hr>
                            <span class="bg-danger badge">Brecha Critica</span>
                        @else
                            <h3 class="text-center p-5">Aun no se han registrado resultados para la evaluación practica
                            </h3>
                        @endif
                    </div>
                </div>
            </div>
            @if ($evaluacion->resultado->isNotEmpty())
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header text-bg-primary d-flex align-items-center">
                            <h4 class="mb-0 text-white card-title">Resultado Evaluación Practica</h4>
                            <div class="card-actions cursor-pointer ms-auto d-flex button-group">
                                <a class="link text-white d-flex align-items-center" data-action="collapse"><i
                                        class="ti fs-6 ti-minus"></i></a>
                                <a class="mb-0 text-white btn-minimize px-2 cursor-pointer link d-flex align-items-center"
                                    data-action="expand"><i class="ti ti-arrows-maximize fs-6"></i></a>
                            </div>
                        </div>
                        <div class="card-body show">
                            <button type="button" class="btn btn-lg btn-outline-primary d-block mb-3 w-100">Nota final:
                                {{ $evaluacion->nota_practica }}</button>
                            <button type="button"
                                class="btn btn-lg {{ $evaluacion->porcentaje_practica < 75 || $evaluacion->aprobacion->estado == 0 ? 'btn-danger' : 'btn-success text-dark' }} d-block mb-3 w-100">Porcentaje
                                de aprobación: {{ $evaluacion->porcentaje_practica }}%</button>
                            <h5>Leyenda</h5>
                            <hr>
                            <span class="bg-success text-dark badge">ACREDITADO</span> <span class="bg-danger badge">NO
                                ACREDITADO</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header text-bg-primary d-flex align-items-center">
                            <h4 class="mb-0 text-white card-title">Comentarios de la evaluación</h4>
                            <div class="card-actions cursor-pointer ms-auto d-flex button-group">
                                <a class="link text-white d-flex align-items-center" data-action="collapse"><i
                                        class="ti fs-6 ti-minus"></i></a>
                                <a class="mb-0 text-white btn-minimize px-2 cursor-pointer link d-flex align-items-center"
                                    data-action="expand"><i class="ti ti-arrows-maximize fs-6"></i></a>
                            </div>
                        </div>
                        <div class="card-body show">
                            <p>{{ $evaluacion->comentarios }}</p>
                            <div class="mb-3">
                                <div class="btn-group" role="group">
                                    @if ($evaluacion->firma_evaluador)
                                        <a href="{{ asset('uploads/evaluacion/' . $evaluacion->id . '/firmas/' . $evaluacion->firma_evaluador . '') }}"
                                            target="_blank" class="btn btn-info text-center text-white p-2">
                                            Firma del evaluador
                                        </a>
                                    @endif
                                    @if ($evaluacion->firma_supervisor)
                                        <a href="{{ asset('uploads/evaluacion/' . $evaluacion->id . '/firmas/' . $evaluacion->firma_supervisor . '') }}"
                                            target="_blank" class="btn btn-primary text-center text-white p-2">
                                            Firma del supervisor
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-lg-12 mb-3">
                <div class="card">
                    <div class="card-header bg-info d-flex align-items-center">
                        <h4 class="mb-0 text-white card-title">Evaluación Teórica</h4>
                        <div class="card-actions cursor-pointer ms-auto d-flex button-group">
                            <a class="link text-white d-flex align-items-center" data-action="collapse"><i
                                    class="ti fs-6 ti-minus"></i></a>
                            <a class="mb-0 text-white btn-minimize px-2 cursor-pointer link d-flex align-items-center"
                                data-action="expand"><i class="ti ti-arrows-maximize fs-6"></i></a>
                        </div>
                    </div>
                    <div class="card-body show">
                        @if ($evaluacion->teorica)
                            <div class="btn-group w-100">
                                <button type="button" class="btn btn-outline-primary d-block mb-3 w-100">Total de
                                    Preguntas: {{ $evaluacion->teorica->preguntas }}</button>
                                <button type="button" class="btn btn-outline-info d-block mb-3 w-100">Preguntas Buenas:
                                    {{ $evaluacion->teorica->preguntas_buenas }}</button>
                                <button type="button" class="btn btn-info d-block mb-3 w-100">Nota de la evaluación:
                                    {{ $evaluacion->teorica->nota }}</button>
                                <button type="button"
                                    class="btn {{ $evaluacion->teorica->porcentaje_teorica < 75 ? 'btn-danger' : 'btn-success text-dark' }} d-block mb-3 w-100">%
                                    de la evaluación: {{ $evaluacion->teorica->porcentaje_teorica }}%</button>
                            </div>
                            <h5>Leyenda</h5>
                            <hr>
                            <span class="bg-success text-dark badge">ACREDITADO</span> <span class="bg-danger badge">NO
                                ACREDITADO</span>
                            <hr>
                            <table class="table table-bordered border-primary">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Competencia</th>
                                        <th>Pregunta</th>
                                        <th>Comentario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($evaluacion->teorica->items as $item)
                                        <tr>
                                            <td>{{ $item->competencia->nombre }}</td>
                                            <td>{{ $item->pregunta }}</td>
                                            <td><button type="button"
                                                    class="justify-content-center w-100 btn mb-1 btn-primary d-flex align-items-center abrir-modal"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalComentario{{ $item->id }}">
                                                    <i class="ti ti-message fs-4"></i>
                                                </button>
                                                <div class="modal fade" id="modalComentario{{ $item->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="modalComentario{{ $item->id }}Label"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalComentario1Label">
                                                                    Comentarios
                                                                </h5>
                                                                <button type="button" class="btn btn-outline-gray"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    x
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{ Form::textarea('comentario[' . $item->id . ']', $item->comentario, ['class' => 'form-control mb-3']) }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                    class="btn btn-primary guardar-comentario"
                                                                    data-comentario-id="1"
                                                                    data-bs-dismiss="modal">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h3 class="text-center p-5">Aun no se ha registrado una evaluacion teórica</h3>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mb-3">
                <div class="card">
                    <div class="card-header bg-success text-dark d-flex align-items-center">
                        <h4 class="mb-0 card-title text-dark ">Nota Final</h4>
                        <div class="card-actions cursor-pointer ms-auto d-flex button-group">
                            <a class="link text-dark e d-flex align-items-center" data-action="collapse"><i
                                    class="ti fs-6 ti-minus"></i></a>
                            <a class="mb-0 text-dark  btn-minimize px-2 cursor-pointer link d-flex align-items-center"
                                data-action="expand"><i class="ti ti-arrows-maximize fs-6"></i></a>
                        </div>
                    </div>
                    <div class="card-body show">
                        @if ($evaluacion->teorica && $evaluacion->resultado->isNotEmpty())
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('nota_practica', 'Nota Practica', ['class' => 'form-label']) }}
                                        <button type="button"
                                            class="btn btn-lg btn-outline-info d-block mb-3 w-100">{{ $evaluacion->nota_total }}</button>
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('porcentaje_practica', '% de Ponderación Practica', ['class' => 'form-label']) }}
                                        <button type="button"
                                            class="btn btn-lg btn-outline-info d-block mb-3 w-100">{{ $evaluacion->porcentaje_total }}%</button>
                                    </div>
                                    <div class="mb-3">
                                        <div class="alert customize-alert alert-dismissible text-primary text-primary alert-light-primary bg-primary-subtle fade show remove-close-icon"
                                            role="alert">
                                            <div class="d-flex align-items-center font-medium me-3 me-md-0">
                                                <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                                                La evaluación practica representa un 80% del total de la evaluación.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('nota_teorica', 'Nota Teórica', ['class' => 'form-label']) }}
                                        <button type="button"
                                            class="btn btn-lg btn-outline-info d-block mb-3 w-100">{{ $evaluacion->teorica->nota_total }}</button>
                                    </div>
                                    <div class="mb-3">
                                        {{ Form::label('nota_teorica', '% de Ponderación Teórico', ['class' => 'form-label']) }}
                                        <button type="button"
                                            class="btn btn-lg btn-outline-info d-block mb-3 w-100">{{ $evaluacion->teorica->porcentaje_total }}%</button>
                                    </div>
                                    <div class="mb-3">
                                        <div class="alert customize-alert alert-dismissible text-primary text-primary alert-light-primary bg-primary-subtle fade show remove-close-icon"
                                            role="alert">
                                            <div class="d-flex align-items-center font-medium me-3 me-md-0">
                                                <i class="ti ti-info-circle fs-5 me-2 flex-shrink-0 text-primary"></i>
                                                La evaluación teórica representa un 20% del total de la evaluación.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('nota_final', 'Nota Final', ['class' => 'form-label']) }}
                                        <button type="button"
                                            class="btn btn-lg {{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total < 75 ? 'btn-danger' : '' }} {{ $evaluacion->aprobacion->estado == 0 ? 'btn-danger' : 'btn-success text-dark' }} d-block mb-3 w-100">{{ $evaluacion->nota_total + $evaluacion->teorica->nota_total }}
                                        </button>
                                        <button type="button"
                                            class="btn btn-lg {{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total < 75 ? ' btn-outline-danger' : '' }} {{ $evaluacion->aprobacion->estado == 0 ? 'btn-outline-danger' : 'btn-outline-success text-dark' }} d-block mb-3 w-100">{{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total < 75 || $evaluacion->aprobacion->estado == 0 ? 'TRABAJADOR NO ACREDITADO' : 'TRABAJADOR ACREDITADO' }}</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('porcentaje', '% de Aprobación', ['class' => 'form-label']) }}
                                        <button type="button"
                                            class="btn btn-lg {{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total < 75 ? 'btn-danger' : '' }} {{ $evaluacion->aprobacion->estado == 0 ? 'btn-danger' : 'btn-success text-dark' }} d-block mb-3 w-100">{{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total }}%</button>
                                        <button type="button"
                                            class="btn btn-lg {{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total < 75 ? 'btn-outline-danger' : '' }} {{ $evaluacion->aprobacion->estado == 0 ? 'btn-outline-danger' : 'btn-outline-success text-dark' }} d-block mb-3 w-100">{{ $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total < 75 || $evaluacion->aprobacion->estado == 0 ? 'TRABAJADOR NO ACREDITADO' : 'TRABAJADOR ACREDITADO' }}</button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="text-center p-5">Aun no se han registrado todas las evaluaciones necesarias
                                    </h3>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
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
    </script>
@endsection
