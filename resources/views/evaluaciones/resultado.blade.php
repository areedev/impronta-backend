@extends('layouts.principal')
@section('customcss')
@endsection
@section('titulo', 'Resultado Evaluación')
@section('descripcion', 'Resultado de evaluación practica')
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
        {!! Form::open([
            'route' => ['evaluaciones.comentarios_post', $evaluacion->id],
            'method' => 'POST',
            'enctype' => 'multipart/form-data',
        ]) !!}

        <div class="row">
            <div class="col-md-12">
                <h4 class="mb-3">{{ $evaluacion->perfilEvaluacion->nombre }}</h4>
                <div class="card card-body">
                    <div class="mb-3">
                        {{ Form::label('estado_evaluacion', 'Estado de la evaluación', ['class' => 'form-label']) }}
                        <div>
                            {{ Form::select('estado_evaluacion', config('constantes.estados_evaluacion'), $evaluacion->estado, ['class' => 'form-control select2', 'placeholder' => 'Seleccionar']) }}
                        </div>
                    </div>
                    <hr>
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
                                                        <td class="{{ in_array($item->competencia->id,$brechas) ? 'bg-danger text-white' : ''}}">{{$i}}</td>
                                                        <td class="{{ in_array($item->competencia->id,$brechas) ? 'bg-danger text-white' : ''}}">{{ $item->competencia->nombre }}
                                                            @if ($resultado->comentario)
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
                                                            <td colspan="2" class="bg-primary text-white border-0">Item Criterio Interno</td>
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
                                                                <td colspan="2" class="bg-primary text-white border-0">- {{ $criterio->criterio }}
                                                                    @if ($resultadocriterio->comentarios)
                                                                    <hr>
                                                                    <p><span class="fw-bold">Comentarios:</span>
                                                                        {{ $resultadocriterio->comentarios }}</p>
                                                                @endif
                                                                </td>
                                                                <td class="bg-primary text-white border-0">
                                                                    {{ $resultadocriterio->nota }}</td>
                                                                    <td class="bg-primary text-white border-0">{{ number_format(($resultadocriterio->nota / 4) * 100, 2) }}</td>
                                                           
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
                            <button type="button" class="btn btn-lg btn-outline-primary d-block mb-3 w-100">Nota final:
                                {{$evaluacion->nota_practica}}</button>
                            <button type="button" class="btn btn-lg btn-{{$evaluacion->porcentaje_practica < 75 ? 'danger' : ''}}{{$evaluacion->aprobacion->estado == 0 ? 'danger' : 'success text-dark'}} d-block mb-3 w-100">Porcentaje de aprobación: {{$evaluacion->porcentaje_practica}}%</button>
                            <div class="mb-3">
                                {{ Form::label('comentarios', 'Comentarios de la evaluación', ['class' => 'form-label']) }}
                                {{ Form::textarea('comentarios', $evaluacion->comentarios, ['class' => 'form-control']) }}
                            </div>
                            <div class="mb-3">
                                {{ Form::label('firma_evaluador', 'Firma del evaluador', ['class' => 'form-label']) }}
                                @if ($evaluacion->firma_evaluador)
                                    <a href="{{ asset('uploads/evaluacion/' . $evaluacion->id . '/firmas/' . $evaluacion->firma_evaluador . '') }}"
                                        target="_blank" class="text-center rounded-1 bg-info text-white p-1 fs-1 ms-2">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                @endif
                                {{ Form::file('firma_evaluador', ['class' => 'form-control']) }}
                            </div>
                            <div class="mb-3">
                                {{ Form::label('firma_supervisor', 'Firma del supervisor', ['class' => 'form-label']) }}
                                @if ($evaluacion->firma_supervisor)
                                    <a href="{{ asset('uploads/evaluacion/' . $evaluacion->id . '/firmas/' . $evaluacion->firma_supervisor . '') }}"
                                        target="_blank" class="text-center rounded-1 bg-info text-white p-1 fs-1 ms-2">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                @endif
                                {{ Form::file('firma_supervisor', ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-12 d-flex justify-content-between">
                            <a href="{{ route('evaluaciones.practica', $evaluacion->id) }}"
                                class="btn btn-danger rounded-pill">
                                Atras
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
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
