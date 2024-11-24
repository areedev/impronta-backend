<div class="d-flex justify-content-center">
    <form class="d-inline">
        <a class="btn btn-primary border me-2 editar-criterio"
            data-action="{{ URL::to('criterios') }}/{{ $criterio->id }}/edit"><i class="las la-edit"></i> Modificar</a>
    </form>
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['criterios.destroy', $criterio->id],
        'id' => 'delete-form-' . $criterio->id,
        'class' => 'd-inline',
    ]) !!}
    <a class="btn btn-danger mostrar_confirmacion border me-2" id="delete-form-{{ $criterio->id }}">
        <i class="las la-trash-alt"></i> Eliminar
    </a>
    {!! Form::close() !!}
</div>
