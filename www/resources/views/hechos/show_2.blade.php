@extends('layouts.app')
@section('content_header')

    <h1 class="page-header">Información de los hechos de violencia - Entrevista {{ $hecho->expediente()->entrevista_codigo }}


    <div class="pull-right no-print">
        @php($edicion = isset($edicion) ? $edicion : 0 )
        @if($edicion==1)
            @if ($hecho->tipo_expediente()=='individual')
                <a href="{{ action('entrevista_individualController@fichas',$hecho->id_e_ind_fvt) }}" class="btn btn-default">Volver</a>    
            @else 
                <a href="{{ action('entrevista_etnicaController@fichas',$hecho->id_entrevista_etnica) }}" class="btn btn-default">Volver</a>    
            @endif
            
        @else
            @if ($hecho->tipo_expediente()=='individual')
                <a href="{{ action('entrevista_individualController@fichas_show',$hecho->id_e_ind_fvt) }}" class="btn btn-default">Volver</a>
            @else 

                @if (isset($volver_ficha_show) && $volver_ficha_show=='fs')
                    <a href="{{ action('entrevista_etnicaController@fichas_show',$hecho->id_entrevista_etnica) }}?fs" class="btn btn-default">Volver</a>        
                @else 
                    <a href="{{ action('entrevista_etnicaController@fichas',$hecho->id_entrevista_etnica) }}" class="btn btn-default">Volver</a>    
                @endif
                
            @endif                
        @endif
    </div>

    </h1>
@endsection

@php($no_editar=true)

@section('content')
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


@endsection