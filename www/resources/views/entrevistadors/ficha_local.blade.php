@php($usuario = isset($usuario) ? $usuario : \Auth::user())
@php($entrevistador = $usuario->rel_entrevistador)
<div class="box box-primary">
    <div class="box-body box-profile">
        <div class="text-center">
            <i class="icon fa fa-user fa-5x "></i>
        </div>


        <h3 class="profile-username text-center">{!! $usuario->name !!}</h3>
        @if($entrevistador)
            <p class="text-muted text-center">{!! $entrevistador->correo !!}</p>
        @endif

        <ul class="list-group list-group-unbordered">

            @if($entrevistador)

                <li class="list-group-item">
                    <b>Privilegios del usuario</b> <a class="pull-right"> {{ $entrevistador->fmt_id_nivel }}</a>
                </li>
                <li class="list-group-item">
                    <b>Fecha de creacion</b> <a class="pull-right"> {{ $usuario->fmt_created_at }}</a>
                </li>
        </ul>
        <div class="row">
            <div class="col-sm-6 text-center">
                <a class='btn btn-warning ' href="{{ action('entrevistadorController@frm_cambiar_clave') }}">
                    Cambiar mi contraseña
                </a>

            </div>
            <div class="col-sm-6 text-center">
                @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                    <a class='btn btn-default ' href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                        <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                    </a>
                @else
                    <a class='btn btn-default ' href="#"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       title="Cerrar sesión "
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
            </div>
        </div>


        @endif
    </div>
</div>

{{--
<div class="box box-info">
    <div class="box-body">
        <div class="col-sm-4">
            <img src="{!! $usuario->imagen !!}" class="img-bordered" height="100px">
        </div>
        <div class="col-sm-8 text-center">
            <h4>{!! $usuario->name !!}</h4>
            <h3>
            @if(empty( $usuario->email))
                {!! $usuario->username !!}
            @else
            {!! $usuario->email !!}
            @endif
            </h3>
            @if(isset($entrevistador))
                <p class="text-primary">
                    {!! $entrevistador->fmt_id_nivel !!}
                    @if($entrevistador->solo_lectura==1)
                        <span class="text-danger"> - Restricciones de investigador</span>
                    @endif
                </p>
                @if($entrevistador->rel_usuario->dias_pendientes)
                <p>
                    <i class="fa fa-hand-o-right"></i> Su clave vence en <b> {{ $entrevistador->rel_usuario->dias_pendientes }}</b> días.
                    <a href=" {{ config('expedientes.url_clave') }}">Portal para cambiar su clave</a>
                </p>
                @endif
            @endif


        </div>
    </div>
</div>
--}}