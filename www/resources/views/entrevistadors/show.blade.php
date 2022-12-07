@extends('layouts.app')

@section('content_header')
    <h1 class="page-header">
        Perfil del entrevistador #{!! $entrevistador->numero_entrevistador !!}
    </h1>
@endsection
@section('content')
    {{--  TOP --}}


    {{-- Detalles y privilegios--}}
    <div class="content">
        <div class="col-sm-6">
            @include("entrevistadors.ficha",['usuario'=>$entrevistador->rel_usuario])
        </div>
        <div class="col-sm-6">
            <div class="box box-primary box-solid">
                <div class="box-header">
                    <h3 class="box-title">
                        <small class="text-gray">Privilegios del usuario:</small>
                        {!! $entrevistador->fmt_id_nivel !!}
                    </h3>
                        @if($entrevistador->solo_lectura==1)
                            <span class="label label-danger pull-right">Restricciones de investigador</span>
                        @endif


                </div>
                <div class="box-body">
                    <div class="row" style="padding-left: 20px">
                        @include('entrevistadors.show_fields')
                    </div>
                </div>
                <div class="box-footer">
                    <a class="btn btn-default" href="{{ action("entrevistadorController@edit",$entrevistador->id_entrevistador) }}" {{ \Auth::user()->nivel==1 ?  "title=(".$entrevistador->id_usuario.")" : '' }}>Actualizar estos datos</a>


                    @if($entrevistador->id_usuario == \Auth::user()->id )
                        @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                            <a class='btn btn-default pull-right' href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                            </a>
                        @else
                            <a class='btn btn-default pull-right' href="#"
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

                    @endif
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-sm-12">
                @if($entrevistador->compromiso_reserva <= 0)
                    <div class="callout callout-warning">
                        <h4><i class="icon fa fa-warning"></i> Compromiso con la reserva no aceptado</h4>

                        <p>El usuario no ha aceptado el compromiso con la reserva de la información </p>
                    </div>
                @else
                    <div class="callout callout-success">
                        <h4><i class="icon fa fa-info-circle"></i> Compromiso con la reserva aceptado</h4>

                        <p>El usuario aceptó el compromiso con la reserva de la información.  Este es el registro de aceptación: </p>
                        <ul>
                            @foreach($entrevistador->rel_compromiso()->orderby('fh_aceptacion')->get() as $compromiso)
                                <li> {{ $compromiso->fh_aceptacion->formatLocalized("%a %d-%b-%Y %H:%M hrs.") }}</li>
                            @endforeach

                        </ul>
                    </div>
                @endif
            </div>
        </div>


        <div class="clearfix"></div>
        <div class="col-sm-12">
            @include("entrevistadors.privilegios")
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Compromiso de reserva</h3>
        </div>
        <div class="box-body">
            @include('pages.compromiso_reserva_txt')

        </div>

    </div>
    <div class="clearfix"></div>



@endsection

@push("js")

    <script>
        function alerta_cambio_clave() {
            Swal.fire({
                title: 'Debe cambiar su clave antes de  {{ $entrevistador->rel_usuario->dias_pendientes  }} días.',
                type: 'info',
                html:
                    'Si no la cambia, <b>su cuenta será bloqueada</b>. <br> ' +
                    '<a href="{{ config('expedientes.url_clave') }}" target="_blank">Deseo cambiar mi clave.</a> ',
                //showCloseButton: true,
                //showCancelButton: true,
                focusConfirm: false,
                confirmButtonText:
                    '<i class="fa fa-thumbs-up"></i> ¡Entendido!',
                //confirmButtonAriaLabel: 'Thumbs up, great!',

            })
        }
        @if($entrevistador->rel_usuario)
            @if($entrevistador->rel_usuario->toca_cambio)
                alerta_cambio_clave();
                @else
                    console.log("Cambiar clave antes de {{ $entrevistador->rel_usuario->dias_pendientes }} dias");
            @endif
        @endif

    </script>

@endpush
