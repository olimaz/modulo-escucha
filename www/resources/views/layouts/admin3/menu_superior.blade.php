<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-{{ config('adminlte.skin', 'blue') }} navbar-dark text-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url("/home") }}" class="nav-link"><i class="fas fa-coffee"></i> Módulo de captura</a>
        </li>
    </ul>

    {{--
    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Buscar nombres" aria-label="Buscar">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    --}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">

                @if(\Auth::check())
                   <b>{{ \Auth::user()->fmt_numero_entrevistador }}</b> <i class="fas fa-user-circle"></i> {{ \Auth::user()->name }}
                @else
                    <i class="far fa-user"></i>
                @endif

            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right ">

                @if(\Auth::check())
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            @if(\Auth::user()->avatar)
                                <img src="{{ \Auth::user()->avatar }}" class="img-size-50 mr-3" alt="de google">
                            @endif


                            <div class="media-body">

                                <h3 class="dropdown-item-title">
                                    @if(\Auth::user()->isImpersonating())
                                        <i class="fa fa-user-secret" aria-hidden="true" title="Actuando como otro usuario" data-toggle="tooltip" data-placement="bottom"></i>
                                    @endif

                                    Entrevistador # {{ \Auth::user()->fmt_numero_entrevistador }}
                                </h3>
                                <p class="text-sm">{{ \Auth::user()->name }}</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                @endif
                    <div class="dropdown-divider"></div>
                    <div class="media">
                        <div class="media-body">
                            <ul>
                                <li>
                                    {{ \Auth::user()->fmt_macroterritorio }}
                                </li>
                                <li>
                                    {{ \Auth::user()->fmt_territorio }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    @if(\Auth::user()->isImpersonating())
                        <a href="{{ action('entrevistadorController@ya_no') }}" class="dropdown-item dropdown-footer">
                            Cerrar sesión
                        </a>
                    @else
                        @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                            <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" class="dropdown-item dropdown-footer">
                                Cerrar sesión.
                            </a>
                        @else
                            <a class='dropdown-item dropdown-footer' href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            >
                                Cerrar sesión
                            </a>
                            <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                @if(config('adminlte.logout_method'))
                                    {{ method_field(config('adminlte.logout_method')) }}
                                @endif
                                {{ csrf_field() }}
                            </form>
                        @endif
                    @endif

            </div>

        </li>
        @if($con_sidebar)
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                        class="fas fa-th-large"></i></a>
        </li>
        @endif
    </ul>
</nav>
<!-- /.navbar -->