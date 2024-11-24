@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Resultado Evaluación')
@section('descripcion', 'Resultado de evaluación')
@section('contenido')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Resultado Evaluación</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ URL::to('/') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Evaluaciones
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
        @if (Auth::user()->hasRole(['administrador']))
            <div class="card">
                <div class="card-body">
                    {!! Form::open([
                        'route' => ['evaluaciones.estado', $evaluacion->id],
                        'method' => 'PUT',
                        'enctype' => 'multipart/form-data',
                    ]) !!}
                    <div class="mb-3">
                        {{ Form::label('estado_evaluacion', 'Estado de la evaluación', ['class' => 'form-label']) }}
                        <div>
                            {{ Form::select('estado_evaluacion', config('constantes.estados_evaluacion'), $evaluacion->estado, ['class' => 'form-control select2', 'placeholder' => 'Seleccionar']) }}
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        Guardar
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        @endif
        <div class="card card-body">
            <ul class="nav nav-pills nav-fill mt-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#practica" role="tab">
                        <span>Evaluación Practica</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#teorica" role="tab">
                        <span>Evaluación Teórica</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#final" role="tab">
                        <span>Nota Final</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content mt-2">
                <div class="tab-pane active p-3" id="practica" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            @foreach ($evaluacion->perfilEvaluacion->secciones as $llave => $seccion)
                                <div class="col-md-12 mb-3">
                                    <h5 class="border-bottom border-primary pb-3">Resultados sección: {{ $seccion->nombre }}
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
                                                            $brechas = explode(',', $evaluacion->aprobacion->brechas_criticas);
                                                    @endphp
                                                    <tr>
                                                        <td class="{{ in_array($item->competencia->id,$brechas) ? 'bg-danger text-white' : ''}}">{{ $i }}</td>
                                                        <td class="{{ in_array($item->competencia->id,$brechas) ? 'bg-danger text-white' : ''}}">{{ $item->competencia->nombre }}
                                                            @if ($resultado)
                                                                <hr>
                                                                <p><span class="fw-bold">Comentarios:</span>
                                                                    {{ $resultado->comentario }}</p>
                                                            @endif
                                                        </td>
                                                        <td class="{{ in_array($item->competencia->id,$brechas) ? 'bg-danger text-white' : ''}}">{{ isset($resultado->nota) ? $resultado->nota : null }}
                                                        </td>
                                                        <td class="{{ in_array($item->competencia->id,$brechas) ? 'bg-danger text-white' : ''}}">{{ isset($resultado->porcentaje) ? $resultado->porcentaje : null }}
                                                        </td>
                                                    </tr>
                                                    @if (count($item->competencia->criterios) > 0)
                                                        <tr class="bg-primary text-white">
                                                            <td colspan="2" class="bg-primary text-white border-0">Item
                                                                Criterio Interno</td>
                                                            <td class="bg-primary text-white border-0">Nota
                                                            </td>
                                                            <td class="bg-primary text-white border-0">Porcentaje
                                                            </td>
                                                        </tr>
                                                        @foreach ($item->competencia->criterios as $criterio)
                                                            <tr>
                                                                @php
                                                                    $resultadocriterio = $evaluacion->criterios
                                                                        ->where('criterio_id', $criterio->id)
                                                                        ->first();
                                                                @endphp
                                                                <td colspan="2" class="bg-primary text-white border-0">-
                                                                    {{ $criterio->criterio }}
                                                                    @if (isset($resultadocriterio->comentarios))
                                                                        <hr>
                                                                        <p><span class="fw-bold">Comentarios:</span>
                                                                            {{ $resultadocriterio->comentarios }}</p>
                                                                    @endif
                                                                </td>
                                                                <td class="bg-primary text-white border-0">
                                                                    @if (isset($resultadocriterio->nota))
                                                                    {{ $resultadocriterio->nota }}
                                                                    @endif
                                                                </td>
                                                                <td class="bg-primary text-white border-0">
                                                                    @if (isset($resultadocriterio->nota))
                                                                    {{ number_format(($resultadocriterio->nota / 4) * 100, 2) }}
                                                                    @endif
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
                        </div>
                        <div class="col-md-6">
                            <h5 class="border-bottom border-primary pb-3">Resultado final</h5>
                            <button type="button" class="btn btn-lg btn-{{$evaluacion->porcentaje_practica < 75 ? 'danger' : ''}}{{$evaluacion->aprobacion->estado == 0 ? 'danger' : 'success text-dark'}} d-block mb-3 w-100">{{$evaluacion->porcentaje_practica < 75 ? 'TRABAJADOR NO ACREDITADO' : ''}}{{$evaluacion->aprobacion->estado == 0 ? 'TRABAJADOR NO ACREDITADO' : 'TRABAJADOR ACREDITADO'}}</button>
                            <button type="button" class="btn btn-lg btn-outline-primary d-block mb-3 w-100">Nota final:
                                {{$evaluacion->nota_practica}}</button>
                                <button type="button" class="btn btn-lg btn-{{$evaluacion->porcentaje_practica < 75 ? 'danger' : ''}}{{$evaluacion->aprobacion->estado == 0 ? 'danger' : 'success text-dark'}} d-block mb-3 w-100">Porcentaje de aprobación: {{$evaluacion->porcentaje_practica}}%</button>
                            <div class="mb-3">
                                {{ Form::label('comentarios', 'Comentarios de la evaluación', ['class' => 'form-label']) }}
                                {{ Form::textarea('comentarios', $evaluacion->comentarios, ['class' => 'form-control','disabled']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane p-3" id="teorica" role="tabpanel">
                    @if ($evaluacion->teorica)
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-lg btn-outline-primary d-block mb-3 w-100">Total de Preguntas: {{$evaluacion->teorica->preguntas}}</button>
                            <button type="button" class="btn btn-lg btn-outline-info d-block mb-3 w-100">Preguntas Buenas: {{$evaluacion->teorica->preguntas_buenas}}</button>
                            <button type="button" class="btn btn-lg btn-info d-block mb-3 w-100">Nota de la evaluación: {{$evaluacion->teorica->nota}}</button>
                            <button type="button" class="btn btn-lg btn-{{$evaluacion->teorica->porcentaje_teorica < 75 ? 'danger' : 'success text-dark'}} d-block mb-3 w-100">Porcentaje de la evaluación: {{$evaluacion->teorica->porcentaje_teorica}}%</button>
                        </div>
                        <div class="col-md-6">
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
                                            <td>{{$item->competencia->nombre}}</td>
                                            <td>{{$item->pregunta}}</td>
                                            <td><button type="button"
                                                class="justify-content-center w-100 btn mb-1 btn-primary d-flex align-items-center abrir-modal"
                                                data-bs-toggle="modal" data-bs-target="#modalComentario{{$item->id}}">
                                                <i class="ti ti-message fs-4"></i>
                                            </button>
                                            <div class="modal fade" id="modalComentario{{$item->id}}" tabindex="-1" role="dialog"
                                                aria-labelledby="modalComentario{{$item->id}}Label" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalComentario1Label">Comentarios
                                                            </h5>
                                                            <button type="button" class="btn btn-outline-gray" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                x
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ Form::textarea('comentario['.$item->id.']', $item->comentario, ['class' => 'form-control mb-3']) }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary guardar-comentario"
                                                                data-comentario-id="1" data-bs-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                        <div class="row">
                            <div class="col-12">
                                <h3 class="text-center p-5">Aun no se ha registrado una evaluacion teórica</h3>
                            </div>
                        </div>
                    @endif
                    
                    
                </div>
                <div class="tab-pane p-3" id="final" role="tabpanel">
                    @if ($evaluacion->teorica)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                {{ Form::label('nota_practica', 'Nota Practica', ['class' => 'form-label']) }}
                                <button type="button" class="btn btn-lg btn-outline-info d-block mb-3 w-100">{{$evaluacion->nota_total}}</button>
                            </div>
                            <div class="mb-3">
                                {{ Form::label('porcentaje_practica', '% de Ponderación Practica', ['class' => 'form-label']) }}
                                <button type="button" class="btn btn-lg btn-outline-info d-block mb-3 w-100">{{$evaluacion->porcentaje_total}}%</button>
                            </div>
                            <div class="mb-3">
                                <div class="alert customize-alert alert-dismissible text-primary text-primary alert-light-primary bg-primary-subtle fade show remove-close-icon" role="alert">
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
                                <button type="button" class="btn btn-lg btn-outline-info d-block mb-3 w-100">{{$evaluacion->teorica->nota_total}}</button>
                            </div>
                            <div class="mb-3">
                                {{ Form::label('nota_teorica', '% de Ponderación Teórico', ['class' => 'form-label']) }}
                                <button type="button" class="btn btn-lg btn-outline-info d-block mb-3 w-100">{{$evaluacion->teorica->porcentaje_total}}%</button>
                            </div>
                            <div class="mb-3">
                                <div class="alert customize-alert alert-dismissible text-primary text-primary alert-light-primary bg-primary-subtle fade show remove-close-icon" role="alert">
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
                            <h3 class="text-center p-5">Aun no se han registrado todas las evaluaciones necesarias</h3>
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
@endsection
