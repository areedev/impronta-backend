<h5 class="mb-0 fs-5 p-1">Candidatos</h5>
<ul class="list mb-0 py-2">
    @foreach ($candidatos as $candidato)
        <li class="p-1 mb-1 bg-hover-light-black">
            <a href="{{route('candidatos.show', $candidato->id)}}">
                <span class="fs-3 text-dark fw-normal d-block">{{ $candidato->nombre }}</span>
                <span class="fs-3 text-muted d-block">Cliente: {{ $candidato->empresa->nombre ?? 'Sin empresa asignada' }}</span>
            </a>
        </li>
    @endforeach
</ul>
<h5 class="mb-0 fs-5 p-1">Clientes</h5>
<ul class="list mb-0 py-2">
    @foreach ($empresas as $empresa)
        <li class="p-1 mb-1 bg-hover-light-black">
            <a href="{{route('empresas.show', $empresa->id)}}">
                <span class="fs-3 text-dark fw-normal d-block">{{ $empresa->nombre }}</span>
            </a>
        </li>
    @endforeach
</ul>
<h5 class="mb-0 fs-5 p-1">Evaluaciones</h5>
<ul class="list mb-0 py-2">
    @foreach ($evaluaciones as $evaluacion)
        <li class="p-1 mb-1 bg-hover-light-black">
            <a href="{{route('evaluaciones.show', $evaluacion->id)}}">
                <span class="fs-3 text-dark fw-normal d-block">{{ $evaluacion->candidato->nombre }}</span>
                <span class="fs-3 text-muted d-block">Evaluación #: {{ $evaluacion->id }}</span>
            </a>
        </li>
    @endforeach
</ul>
