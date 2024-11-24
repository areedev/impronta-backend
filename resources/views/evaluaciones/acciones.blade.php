<div class="d-flex justify-content-center">
    <form class="d-inline">
        <div class="btn-group mb-2 me-1">
            <button class="btn btn-primary dropdown-toggle" type="button" id="acciones" data-bs-toggle="dropdown"
                aria-expanded="false">
                Acciones
            </button>
            <ul class="dropdown-menu" aria-labelledby="acciones">
                <li>
                    <a class="dropdown-item" href="{{ URL::to('evaluaciones') }}/{{ $evaluacion->id }}/">
                        Ver Evaluación
                    </a>
                </li>
                @if ($evaluacion->resultado->isNotEmpty())
                    <li>
                        <a class="dropdown-item" href="{{ URL::to('evaluaciones') }}/resultados/{{ $evaluacion->id }}/">
                            Ver Resultados
                        </a>
                    </li>
                @endif
                @if ($evaluacion->estado != 2 && Auth::user()->hasRole(['administrador','evaluador']))
                    <li>
                        <a class="dropdown-item" href="{{ URL::to('evaluaciones') }}/teorica/{{ $evaluacion->id }}/">Evaluación Teorica</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ URL::to('evaluaciones') }}/practica/{{ $evaluacion->id }}">Modificar Evaluación</a>
                    </li>
                @endif
                <li>
                    <a class="dropdown-item" href="{{ URL::to('evaluaciones') }}/pdf/{{ $evaluacion->id }}" target="_blank">Ver Informe</a>
                </li>
            </ul>
        </div>
    </form>
    @if (Auth::user()->hasRole('administrador'))
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['evaluaciones.destroy', $evaluacion->id],
        'id' => 'delete-form-' . $evaluacion->id,
        'class' => 'd-inline',
    ]) !!}
    <a class="btn btn-danger mostrar_confirmacion border me-2" id="delete-form-{{ $evaluacion->id }}">
        <i class="las la-trash-alt"></i> Eliminar
    </a>
    {!! Form::close() !!}
    @endif
</div>
