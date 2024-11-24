<div class="d-flex justify-content-center">
    <a class="btn btn-sm btn-info border me-2 d-none"
            href="{{ URL::to('usuarios') }}/{{ $user->id }}"><i class="las la-eye"></i> Ver</a>
    <form class="d-inline">
        <a class="btn btn-sm btn-warning border me-2 editar-usuario"
            data-action="{{ URL::to('usuarios') }}/{{ $user->id }}/edit"><i class="las la-edit"></i> Editar</a>
    </form>
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['usuarios.destroy', $user->id],
        'id' => 'delete-form-' . $user->id,
        'class' => 'd-inline',
    ]) !!}
    <a class="btn btn-sm btn-danger mostrar_confirmacion border me-2" id="delete-form-{{ $user->id }}">
        <i class="las la-trash-alt"></i> Eliminar
    </a>
    {!! Form::close() !!}
</div>
