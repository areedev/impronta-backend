<div class="d-flex justify-content-center">
    <form class="d-inline">
        <a class="btn btn-primary border me-2 editar-competencia"
            data-action="{{ URL::to('competencias') }}/{{ $competencia->id }}/edit"><i class="las la-edit"></i> Modificar</a>
    </form>
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['competencias.destroy', $competencia->id],
        'id' => 'delete-form-' . $competencia->id,
        'class' => 'd-inline',
    ]) !!}
    <a class="btn btn-danger mostrar_confirmacion border me-2" id="delete-form-{{ $competencia->id }}">
        <i class="las la-trash-alt"></i> Eliminar
    </a>
    {!! Form::close() !!}
</div>
