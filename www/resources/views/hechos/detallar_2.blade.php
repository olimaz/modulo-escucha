@extends('layouts.app')
@section('content_header')

    <h1 class="page-header">Ficha de hechos - Entrevista {{ $hecho->rel_id_e_ind_fvt->entrevista_codigo }}

    <div class="pull-right no-print">
        <a href="{{ action('entrevista_individualController@fichas',$hecho->id_e_ind_fvt) }}" class="btn btn-default">Volver</a>
    </div>

    </h1>
    {{--
    @include('adminlte-templates::common.errors')
    --}}


@endsection

@section('content')
    <div class="col-sm-12">
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">Información del hecho y tipo de violencia</h3>
            </div>
            <div class="box-body">
                @include("hechos.p_hecho")
                {{-- Violencias --}}
                <div class="col-sm-6">
                    <div class="box  {{ count($hecho->rel_violencia)==0 ? ' box-danger ' :' box-success ' }}">
                        <div class="box-header">
                            <h3 class="box-title">
                                1. Tipos de violencias en este hecho
                            </h3>

                        </div>
                        <div class="box-body  no-padding"> {{-- probé con div y queda mejor con tabla :-\ --}}
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
                        <div class="box-footer">
                            <a href="{{ action('hechoController@edit',$hecho->id_hecho) }}" class="btn btn-default">Modificar</a>
                        </div>
                    </div>
                </div>
                {{-- Victimas --}}
                <div class="col-sm-6">
                    <div class="box {{ count($hecho->rel_victima) == 0 ? ' box-danger ' : ' box-success ' }} ">
                        <div class="box-header ">
                            <h3 class="box-title">2. Víctimas de este hecho</h3>
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
                        <div class="box-footer">
                            @if(count($hecho->rel_id_e_ind_fvt->arreglo_victimas()) > 0)
                                <a href="#" class="btn btn-success" onclick="mostrar_agregar_victima()"><i class="fa fa-tag" aria-hidden="true"></i> Seleccionar víctima</a>
                            @else
                                <button type="button" class="btn btn-default" disabled="disabled">No hay información de víctimas</button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                {{-- Responsabilidad colectiva --}}
                <div class="col-sm-6">
                    <div class="box   {{ count($hecho->rel_responsabilidad)==0 ? ' box-danger ' :' box-success ' }}">
                        <div class="box-header">
                            <h3 class="box-title">
                                3. Responsabilidad colectiva
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
                                            <td>
                                                {!! Form::open(['action' => ['hecho_responsabilidadController@quitar', $responsabilidad->id_hecho_responsabilidad]]) !!}
                                                <button type="submit"  class="btn btn-danger btn-sm" onclick = "return confirm('Seguro?')">Quitar</button>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif

                        </div>
                        <div class="box-footer no-padding bg-gray">
                            @include('hechos.p_agregar_responsabilidad')

                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    {{-- Responsabilidad individual --}}
                    <div class="box box-success">
                        <div class="box-header ">
                            <h3 class="box-title">4. Presuntos responsables individuales de este hecho</h3>
                        </div>
                        <div class="box-body no-padding">
                            @if(count($hecho->rel_responsable) == 0)
                                <div class="text-yellow text-center">
                                    <h4><i class="icon fa fa-warning"></i> Atención</h4>
                                    No se ha seleccionado ninguna ficha de presunto responsable individual
                                </div>
                            @endif
                            @include("hechos.p_responsable")
                        </div>
                        <div class="box-footer">
                            @if(count($hecho->rel_id_e_ind_fvt->arreglo_responsables()) > 0)
                                <a href="#" class="btn btn-success" onclick="mostrar_agregar_responsable()"><i class="fa fa-tag" aria-hidden="true"></i> Seleccionar presunto responsable</a>
                            @else
                                <a href="{{ url('persona_responsable/create')."?id_e_ind_fvt=$hecho->id_e_ind_fvt" }}" class="btn btn-default "><i class="fa fa-user-secret"></i> Agregar presunto responsable individual</a>
                            @endif
                        </div>
                    </div>
                    {{-- Control de Calidad y Estadísticas --}}
                    @if(!$hecho->control_calidad->completo)
                        <div class="callout callout-warning">
                            <h4>Ficha incompleta</h4>
                            <ul>
                                @foreach($hecho->control_calidad->alarma as $txt)
                                    <li>{{ $txt }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="box box-info box-solid">
                        <div class="box-header ">
                            <h3 class="box-title">Datos cuantitativos</h3>
                        </div>
                        <div class="box-body no-padding">
                            @include("hechos.p_stats")
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Contexto --}}
    <div class="col-sm-12">
        <div class="box {{ count($hecho->rel_contexto)>0 ? ' box-primary ' : ' box-danger ' }} box-solid">
            <div class="box-header">
                <h3 class="box-title">
                    Contexto (explicaciones, dinámicas y finalidades de las violencias)
                </h3>

            </div>
            @include("hechos.p_contexto")
        </div>
    </div>

<div class="clearfix"></div>


@endsection