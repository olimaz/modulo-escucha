@php($usuario = isset($usuario) ? $usuario : \Auth::user())
@php($entrevistador = $usuario->rel_entrevistador)
<div class="box box-primary">
    <div class="box-body box-profile">
        <img class="profile-user-img img-responsive " src="{!! $usuario->imagen !!}" alt="Imagen tomada del correo-e">

        <h3 class="profile-username text-center">{!! $usuario->name !!}</h3>
        @if($entrevistador)
            <p class="text-muted text-center">{!! $entrevistador->correo !!}</p>
        @endif

        <ul class="list-group list-group-unbordered">
            @if($usuario->dias_pendientes) {{-- Mostrar sólo para usuarios de active directory --}}
                <li class="list-group-item">
                    <b>Su clave vence en </b> <a class="pull-right"> <i class="fa fa-hand-o-right"></i> {{ $usuario->dias_pendientes }} días</a>
                </li>
                <li class="list-group-item text-center">
                    <a href=" {{ config('expedientes.url_clave') }}" target="_blank">Portal para cambiar su clave</a>
                </li>
            @endif
            @if($entrevistador)

                    <li class="list-group-item">
                        <b>Restricciones de investigador</b> <a class="pull-right"> {{ $entrevistador->solo_lectura==1 ? "Sí" : "No" }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Acceso a "Otro, ¿Cuál?"</b> <a class="pull-right"> {{ \App\Models\lista_negra::revisar_bloqueo($entrevistador->id_entrevistador) ? "Bloqueado" : "Permitido" }}</a>
                    </li>
                    @if($entrevistador->r3_nna == 1 )
                        <li class="list-group-item">
                            Liberación de entrevistas R3
                            <a class="pull-right"> NNA </a>
                        </li>
                    @endif
                    @if($entrevistador->r3_vs == 1 )
                        <li class="list-group-item">
                            Liberación de entrevistas R3
                            <a class="pull-right"> Violencia Sexual </a>
                        </li>
                    @endif
                    @if($entrevistador->r3_ri == 1 )
                        <li class="list-group-item">
                            Liberación de entrevistas R3
                            <a class="pull-right"> Reconocimiento de responsabilidades </a>
                        </li>
                    @endif
                    @if($entrevistador->r3_aa == 1 )
                        <li class="list-group-item">
                            Liberación de entrevistas R3
                            <a class="pull-right">Entrevistas a Actores Armados o Terceros Civiles </a>
                        </li>
                    @endif

                </ul>

                <a href="{{ url('entrevistadors')."?id_entrevistador=$entrevistador->id_entrevistador" }}"  class="btn btn-primary btn-block"><b>Entrevistas cargadas en el sistema</b></a>
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