<div class="clearfix"></div>


<h3 >
    Información de los hechos de violencia <small> Entrevista <a href="{{ action('entrevista_individualController@show', $hecho->expediente()->id_e_ind_fvt) }}">{{ $hecho->expediente()->entrevista_codigo }}</a></small></h3>

<a  href="{!! route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default pull-right">Mostrar línea de tiempo</a>
</h3>

<div class="clearfix"></div>

@php($no_editar=true)


    {{--
    @php($id_hecho=27)
    @php($id_persona=201)
    @include("hechos.hecho_victima")
    --}}

    <div class="col-sm-6">
        <div class="box  box-primary">
            <div class="box-header">
                <h3 class="box-title">Violencia</h3>
            </div>
            <div class="box-body">
                @if ($hecho->tipo_expediente()=='individual')
                    @include("hechos.p_hecho")
                    <hr>
                @endif

                <h5>Tipos de violencia</h5>
                @if(count($hecho->rel_violencia)==0)
                    <div class="text-yellow text-center">
                        <h4><i class="icon fa fa-warning"></i> Atención</h4>
                        No se ha especificado ninguna violencia
                    </div>
                @else
                    <table class="table table-condensed ">
                        @foreach($hecho->rel_violencia as $violencia)
                            <tr>
                                <td>
                                    {!! $violencia->descripcion->nombre !!}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
    </div>
    {{-- Estadisticas y alarmas --}}
    <div class="col-sm-6">
        @if(!$hecho->control_calidad->completo)
            <div>
                <div class="callout callout-warning">
                    <h4>Ficha incompleta</h4>
                    <ul>
                        @foreach($hecho->control_calidad->alarma as $txt)
                            <li>{{ $txt }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="box box-info ">
            <div class="box-header ">
                <h3 class="box-title">Datos cuantitativos</h3>
            </div>
            <div class="box-body no-padding">
                @include("hechos.p_stats")
            </div>
        </div>

        {{-- Contexto --}}
        <div class="box {{ count($hecho->rel_contexto)>0 ? ' box-info ' : ' box-danger ' }}">
            <div class="box-header ">
                <h3 class="box-title">Información de contexto</h3>
            </div>
            <div class="box-body no-padding">
                @include("hechos.p_contexto_detalle")
            </div>
        </div>
    </div>



    <div class="clearfix"></div>

    {{-- VICTIMAS --}}
    @if ($hecho->tipo_expediente()=='individual')
        <div class="clearfix"></div>
        <div class="col-xs-12">
            <div class="box {{ count($hecho->rel_victima) == 0 ? ' box-danger ' : ' box-success ' }} ">
                <div class="box-header ">
                    <h3 class="box-title">Víctimas de estos hechos</h3>
                </div>
                <div class="box-body no-padding">
                    @if(count($hecho->rel_victima) == 0)
                        <div class="text-yellow text-center">
                            <h4><i class="icon fa fa-warning"></i> Atención</h4>
                            No se ha seleccionado ninguna ficha de víctima
                        </div>
                    @else
                        @include("hechos.t_victima")
                    @endif
                </div>
            </div>
        </div>
    @endif






    {{-- RESPONSABILIDAD COLECTIVA Y PRESUNTO RESPONSABLE INDIVIDUAL --}}
    <div class="col-sm-12">
        <div class="box   {{ count($hecho->rel_responsabilidad)==0 ? ' box-danger ' :' box-success ' }}">
            <div class="box-header">
                <h3 class="box-title">
                    Responsabilidad colectiva
                </h3>

            </div>
            <div class="box-body  no-padding">
                @if(count($hecho->rel_responsabilidad)==0)
                    <div class="text-yellow text-center">
                        <h4><i class="icon fa fa-warning"></i> Atención</h4>
                        No se ha especificado ninguna responsabilidad colectiva
                    </div>
                @else
                    <table class="table table-hover table-condensed "> {{-- probé con div y queda mejor con tabla :-\ --}}

                        @foreach($hecho->rel_responsabilidad as $responsabilidad)
                            <tr>
                                <td>
                                    {!! $responsabilidad->descripcion->nombre !!}
                                </td>
                                <td>
                                    {!! $responsabilidad->descripcion->detalle !!}
                                </td>

                            </tr>
                        @endforeach
                    </table>
                @endif

            </div>
        </div>

        {{-- Responsabilidad individual --}}
        @if(count($hecho->rel_responsable) > 0)

            <div class="box box-success">
                <div class="box-header ">
                    <h3 class="box-title">Presuntos responsables individuales</h3>
                </div>
                <div class="box-body no-padding">
                    @include("hechos.p_responsable")
                </div>
            </div>
        @endif
    </div>




    {{-- SALTO DE fila --}}
    {{--

        @if($hecho->control_calidad->hay_exilio)
            <div class="col-sm-6">

                <div class="box box-success">
                    <div class="box-header ">
                        <h3 class="box-title">Información del exilio</h3>
                    </div>
                    <div class="box-body no-padding">
                        @php($exilios = \App\Models\exilio::where('id_e_ind_fvt',$hecho->id_e_ind_fvt)->ordenado()->get())
                        @include("exilios.table")
                    </div>
                </div>
            </div>
        @endif
    --}}


    <div class="clearfix"></div>

