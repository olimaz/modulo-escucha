@extends('layouts.mensajes')



@section('content')
    Usuario deshabilitado<br><br>
    <small>El usuario ha sido deshabilitado y no puede utilizar el sistema</small>
    <br>
    @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
        <a class='btn btn-default ' href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
            <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
        </a>
    @else
        <a class='btn btn-default ' href="#"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           title="Cerrar sesión "
        >
            <i class="fa fa-fw fa-power-off"></i> Cerrar sesión
        </a>
        <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
            @if(config('adminlte.logout_method'))
                {{ method_field(config('adminlte.logout_method')) }}
            @endif
            {{ csrf_field() }}
        </form>
    @endif
@stop