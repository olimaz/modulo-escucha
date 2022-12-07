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

    @include('adminlte-templates::common.errors')


    <!-- /.login-logo -->
        <div class="login-box-body">
            <div class="text-center">
                <h3>Consulta de entrevistas</h3>
                <p class="login-box-msg">Utilice sus credenciales de para iniciar sesión</p>
            </div>

            <form action="{{ url('/login/portable') }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="text" name="email" class="form-control" value="{{ old('email') }}"
                           placeholder="Correo-e">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control" id="password"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" onclick="mostrar_clave()"> Mostrar contraseña
                            </label>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-xs-6 text-left">
                        <a href ='{{ url("login") }}'
                           class="btn btn-default btn-block btn-flat">Cancelar</a>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6 text-right">
                        <button type="submit"
                                class="btn btn-primary btn-block btn-flat">{{ trans('adminlte::adminlte.sign_in') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <div class="auth-links">

            </div>

        </div>
        <!-- /.login-box-body -->
        <div class="box-footer">
            Este aplicativo tiene su propia gestión de usuarios: si no puede acceder, consulte al administrador.
        </div>
    </div><!-- /.login-box -->

@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>

        function mostrar_clave() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
    @yield('js')
@stop
