<div class="d-flex justify-content-center">
    <form class="d-inline">
        <a class="btn btn-primary border me-2 editar-area"
            data-action="{{ URL::to('areas') }}/{{ $area->id }}/edit"><i class="las la-edit"></i> Modificar</a>
    </form>
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['areas.destroy', $area->id],
        'id' => 'delete-form-' . $area->id,
        'class' => 'd-inline',
    ]) !!}
    <a class="btn btn-danger mostrar_confirmacion border me-2" id="delete-form-{{ $area->id }}">
        <i class="las la-trash-alt"></i> Eliminar
    </a>
    {!! Form::close() !!}
</div>
