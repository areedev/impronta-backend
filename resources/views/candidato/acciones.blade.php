<div class="d-flex justify-content-center">
    <a class="btn btn-sm btn-info border me-2"
            href="{{ URL::to('candidatos') }}/{{ $candidato->id }}"><i class="las la-eye"></i> Ver</a>
    @if (Auth::user()->hasRole('administrador'))
    <form class="d-inline">
        <a class="btn btn-sm btn-warning border me-2 editar-candidato"
            data-action="{{ URL::to('candidatos') }}/{{ $candidato->id }}/edit"><i class="las la-edit"></i> Editar</a>
    </form>   
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['candidatos.destroy', $candidato->id],
        'id' => 'delete-form-' . $candidato->id,
        'class' => 'd-inline',
    ]) !!}
        <a class="btn btn-sm btn-danger mostrar_confirmacion border me-2" id="delete-form-{{ $candidato->id }}">
            <i class="las la-trash-alt"></i> Eliminar
        </a>
    {!! Form::close() !!}
    @endif
</div>
