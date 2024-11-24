<div class="d-flex justify-content-center">
    <form class="d-inline">
        <a class="btn btn-primary border me-2 editar-empresa"
            data-action="{{ URL::to('empresas') }}/{{ $empresa->id }}/edit"><i class="las la-edit"></i> Modificar</a>
    </form>
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['empresas.destroy', $empresa->id],
        'id' => 'delete-form-' . $empresa->id,
        'class' => 'd-inline',
    ]) !!}
    <a class="btn btn-danger mostrar_confirmacion border me-2" id="delete-form-{{ $empresa->id }}">
        <i class="las la-trash-alt"></i> Eliminar
    </a>
    {!! Form::close() !!}
</div>
