<div class="d-flex justify-content-center">
    <form class="d-inline">
        <a class="btn btn-primary border me-2 editar-faena"
            data-action="{{ URL::to('faenas') }}/{{ $faena->id }}/edit"><i class="las la-edit"></i> Modificar</a>
    </form>
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['faenas.destroy', $faena->id],
        'id' => 'delete-form-' . $faena->id,
        'class' => 'd-inline',
    ]) !!}
    <a class="btn btn-danger mostrar_confirmacion border me-2" id="delete-form-{{ $faena->id }}">
        <i class="las la-trash-alt"></i> Eliminar
    </a>
    {!! Form::close() !!}
</div>
