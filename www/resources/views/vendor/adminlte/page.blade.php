@extends('adminlte::master')
@php($colapsar_menu = isset($colapsar_menu) ? $colapsar_menu : false)

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') || $colapsar_menu ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>

                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
                <!-- Logo -->
                <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                    </a>
                    @can('revisar-m-nivel',[[1,2,6,10]])
                        <ul class="nav navbar-nav hidden-sm hidden-xs">
                            <li>
                                <a href="{{ action("fichasController@dash") }}" class="pull-left"><i class="fa fa-coffee"></i> Explorar fichas</a>
                            </li>
                        </ul>
                    @endcan


            @endif

                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">
                        @can('nivel-1')
                                <li class="hidden-md hidden-lg">
                                    <a href="{{ action("fichasController@dash") }}" class="pull-left"><i class="fa fa-coffee"></i> Explorar fichas</a>
                                </li>
                        @endcan

                        {{-- REFERENCIAS --}}
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-book"></i>

                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">Referencias</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        @can('mis-casos')
                                            <li>
                                                <a href="{{ url('misCasos') }}">
                                                    <i class="fa fa-briefcase text-primary"></i> Casos transversales
                                                </a>
                                            </li>
                                        @endcan
                                        <li>
                                            <a href="{{ url('documentos') }}">
                                                <i class="fa fa-file-pdf-o text-aqua"></i> Guías y documentos
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('explicar/prioridad') }}">
                                                <i class="fa fa-star "></i> Criterios de priorización
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('listado_geo') }}">
                                                <i class="fa fa-map-o text-green"></i> Departamentos y municipios
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('listado_geo_cev') }}">
                                                <i class="fa fa-map-marker text-green"></i> Macro territoriales
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('listados/4') }}">
                                                <i class="fa fa-circle-o text-yellow"></i> Responsables/Participantes
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('listados/5') }}">
                                                <i class="fa fa-circle-o text-yellow"></i> Tipos de violencia
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('catalogos') }}">
                                                <i class="fa fa-list-alt text-purple"></i> Listados del sistema
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="{{ url('faq') }}"><i class="fa fa-question-circle text-red"></i> Ayuda</a></li>
                            </ul>
                        </li>
                        {{-- perfil del usuario --}}
                        @if(\Auth::check())

                            <li class="dropdown user user-menu ">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    @if(\Auth::user()->isImpersonating())
                                        <i class="fa fa-user-secret" aria-hidden="true" title="Actuando como otro usuario" data-toggle="tooltip" data-placement="bottom"></i>
                                    @endif
                                    @cannot('login-local')
                                    @if(strlen(\Auth::user()->avatar) > 4)
                                            <img src="{{ \Auth::user()->avatar }}" class="user-image" alt="de google">
                                    @endif
                                    @endif
                                    <span >{{ \Auth::user()->id_entrevistador > 0 ? \Auth::user()->fmt_numero_entrevistador." - " : "" }}  {{ \Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        {{-- <img src="{!! \Auth::user()->imagen !!}" class="img-circle" alt="User Image"> --}}
                                        @if(\Auth::user()->tiene_perfil())
                                            <ul class="text-gray text-left">
                                                <li>Entrevistador # {{ \Auth::user()->fmt_numero_entrevistador }}</li>
                                                <li>Macro: {{ \Auth::user()->fmt_macroterritorio }}</li>
                                                <li>Territorio: {{ \Auth::user()->fmt_territorio }}</li>
                                                <li>Perfil: <b>{{ \Auth::user()->fmt_privilegios }}</b></li>

                                                <li style="margin-top: 15px"><a href="{{ url('entrevistadors')."?id_entrevistador=".\Auth::user()->id_entrevistador }}" class="btn btn-default btn-sm">Ir a mis entrevistas</a></li>
                                            </ul>


                                        @else
                                            <p>
                                                {{ \Auth::user()->name }}
                                            </p>
                                            <a href="{{ url('llenar_perfil') }}" class="btn btn-success">Completar perfil</a>
                                        @endif
                                    </li>

                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="{{ url('ver_perfil') }}" class="btn btn-default btn-flat">Mi perfil</a>

                                        </div>
                                        <div class="pull-right">
                                            @if(\Auth::user()->isImpersonating())
                                                <a href="{{ action('entrevistadorController@ya_no') }}" class='btn btn-default'>
                                                    <i class="fa fa-fw fa-power-off"></i> Salir
                                                </a>
                                            @else
                                                @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                                    <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                                        <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                                    </a>
                                                @else
                                                    <a class='btn btn-default' href="#"
                                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                    >
                                                        <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
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
                                </ul>
                            </li>
                        @endif

                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <form method="get" class="sidebar-form" id="sidebar-form" action="{{ action("statController@busqueda_rapida") }}">
                    <input type="hidden" name="br_url" id="br_url"  value="{{ Request::fullUrl() }}">
                    <div class="input-group" title="Buscar por número, código, titulo o anotaciones" data-toggle="tooltip" data-placement="bottom" >
                        <input type="text" name="br" class="form-control" placeholder="Buscar..." id="search-input" value="{{ isset($filtros->br) ? $filtros->br : "" }}">
                        <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                    </div>
                </form>

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>



            <!-- Main content -->
            <section class="content">
                <div class="clearfix"></div>
                @include('flash::message')
                <div class="clearfix"></div>
                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->
        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
                <a href="{{ url("faq") }}">
                Módulo de carga de entrevistas
                </a>
            </div>
            <!-- Default to the left -->
            Sistema de Información Misional <strong>-SIM-</strong>  2019.
        </footer>

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')

    @stack('js')
    @yield('js')
    <script>
        $('#flash-overlay-modal').modal();
    </script>
@stop
