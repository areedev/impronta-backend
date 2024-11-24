<aside class="left-sidebar with-vertical">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="../main/index.html" class="text-nowrap logo-img">
                <img src="{{ URL::to('assets') }}/images/logos/logo.png" class="dark-logo" alt="Logo-Dark" />
                <img src="{{ URL::to('assets') }}/images/logos/logo.png" class="light-logo" alt="Logo-light" />
            </a>
            <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                <i class="ti ti-x"></i>
            </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Menú</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link fs-5" href="{{ URL::to('/') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-home"></i>
                        </span>
                        <span class="hide-menu">Inicio</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link fs-5 {{ request()->is('candidatos*') ? 'active' : '' }}"
                        href="{{ URL::to('candidatos') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">Candidatos</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link fs-5 {{ request()->is('evaluaciones*') ? 'active' : '' }}"
                        href="{{ URL::to('evaluaciones') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-chart-dots"></i>
                        </span>
                        <span class="hide-menu">Evaluaciones</span>
                    </a>
                </li>
                @if (Auth::user()->hasRole(1))
                    <li class="sidebar-item">
                        <a class="sidebar-link fs-5 {{ request()->is('perfilevaluaciones*') ? 'active' : '' }}"
                            href="{{ URL::to('perfilevaluaciones') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-id-badge"></i>
                            </span>
                            <span class="hide-menu">Perfiles</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->is('reportes*') ? 'active' : '' }}">
                        <a class="sidebar-link fs-5" href="{{ URL::to('reportes') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-chart-bar"></i>
                            </span>
                            <span class="hide-menu">Informes</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link fs-5" href="{{ URL::to('empresas') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-briefcase"></i>
                            </span>
                            <span class="hide-menu">Clientes</span>
                        </a>
                    </li>
                @endif
                <li class="sidebar-item">
                    <a class="sidebar-link fs-5" href="{{ route('biblioteca.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Biblioteca</span>
                    </a>
                </li>
                @if (Auth::user()->hasRole(1))
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow fs-5" href="#" aria-expanded="false">
                            <span>
                                <i class="ti ti-settings"></i>
                            </span>
                            <span class="hide-menu">Configuración</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{ route('faenas.index') }}" class="sidebar-link">
                                    <i class="ti ti-circle"></i>
                                    <span class="hide-menu">Faenas</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('areas.index') }}" class="sidebar-link">
                                    <i class="ti ti-circle"></i>
                                    <span class="hide-menu">Areas</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('competencias.index') }}" class="sidebar-link">
                                    <i class="ti ti-circle"></i>
                                    <span class="hide-menu">Competencias</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('criterios.index') }}" class="sidebar-link">
                                    <i class="ti ti-circle"></i>
                                    <span class="hide-menu">Criterios Internos</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('usuarios.index') }}" class="sidebar-link">
                                    <i class="ti ti-circle"></i>
                                    <span class="hide-menu">Usuarios</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>

        <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded sidebar-ad mt-3">
            <div class="hstack gap-3">
                <div class="john-img">
                    <img src="{{ asset('uploads/avatars/' . Auth::user()->perfil->avatar . '') }}" class="rounded-circle" width="40"
                        height="40" alt="" />
                </div>
                <div class="john-title">
                    <h6 class="mb-0 fs-4 fw-semibold">{{ Auth::user()->perfil->nombre }}</h6>
                    <span class="fs-2">{{ ucfirst(Auth::user()->roles[0]->name) }}</span>
                </div>
                <a href="{{ URL::to('salir') }}" class="border-0 bg-transparent text-primary ms-auto" tabindex="0"
                    type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="salir">
                    <i class="ti ti-power fs-6"></i>
                </a>
            </div>
        </div>

    </div>
</aside>
