@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body">
            <h3 class="box-title text-center">Módulo de carga de entrevistas</h3>
            <p class="login-box-msg">Para ingresar, puede autenticarse con uno de los siguientes métodos:</p>



            <a href="{{ url("redirect") }}" class="btn btn-block btn-social  btn-success btn-flat btn-block"><span class="glyphicon glyphicon-ice-lolly" aria-hidden="true"></span> Tengo cuenta  @comisiondelaverdad.co</a>
            <br>
            <br>
            <a href="{{ url("login2") }}" class="btn btn-warning btn-social btn-warning btn-flat btn-block"><span class="glyphicon glyphicon-ice-lolly-tasted" aria-hidden="true"></span> No tengo cuenta  @comisiondelaverdad.co</a>
        </div>
        <!-- /.login-box-body -->
        <div class="box-footer">
            ¿Necesita ayuda? <a target="_blank" href="mailto:soporte.TIC@comisiondelaverdad.co">soporte.TIC@comisiondelaverdad.co </a>
        </div>


    </div><!-- /.login-box -->

    <div class="row">
        <div class="text-center">
            <a href="https://capacitacion.comisiondelaverdad.co/sim/captura.html" class="btn btn-primary">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> Video tutoriales de ayuda y referencia
            </a>
        </div>
    </div>

@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    @yield('js')
@stop
