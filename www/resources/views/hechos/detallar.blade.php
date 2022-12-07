@extends('layouts.app')
@section('content_header')

    <h1 class="page-header">Ficha de hechos - Entrevista {{ $hecho->rel_id_e_ind_fvt->entrevista_codigo }}

    <div class="pull-right no-print">
        <a href="{{ action('entrevista_individualController@fichas',$hecho->id_e_ind_fvt) }}" class="btn btn-default">Volver</a>
    </div>

    </h1>


@endsection

@section('content')
    <div class="col-sm-6">
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">Información del hecho</h3>
            </div>
            <div class="box-body">
                @include("hechos.p_hecho")
            </div>
            <div class="box-footer">
                <a href="{{ action('hechoController@edit',$hecho->id_hecho) }}" class="btn btn-default">Modificar</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
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

    <div class="clearfix"></div>

    <div class="col-sm-6">
        <div class="box {{ count($hecho->rel_victima) == 0 ? ' box-danger ' : ' box-success ' }} box-solid">
            <div class="box-header ">
                <h3 class="box-title">1. Víctimas de este hecho</h3>
            </div>
            <div class="box-body no-padding">
                @if(count($hecho->rel_victima) == 0)
                    <div class="text-yellow text-center">
                        <h4><i class="icon fa fa-warning"></i> Atención</h4>
                        No se ha seleccionado ninguna ficha de víctima
                    </div>
                @endif
                @include("hechos.t_victima")

            </div>
            <div class="box-footer">
                @if(count($hecho->rel_id_e_ind_fvt->arreglo_victimas()) > 0)
                    <a href="#" class="btn btn-success" onclick="mostrar_agregar_victima()"><i class="fa fa-tag" aria-hidden="true"></i> Seleccionar ficha de víctima</a>
                @else
                    <button type="button" class="btn btn-default" disabled="disabled">No hay fichas de víctimas</button>
                @endif
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="box box-success box-solid">
            <div class="box-header ">
                <h3 class="box-title">2. Presuntos responsables individuales de este hecho</h3>
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
                    <a href="#" class="btn btn-success" onclick="mostrar_agregar_responsable()"><i class="fa fa-tag" aria-hidden="true"></i> Seleccionar ficha de presunto responsable</a>
                @else
                    <button type="button" class="btn btn-default" disabled="disabled">No hay fichas de responsables</button>
                @endif
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    {{--  Violencia: agregar tipo --}}

    {{-- Detalle de violencia agregada --}}
    <div class="col-sm-12">
        <div class="box box-solid {{ count($hecho->rel_violencia)==0 ? ' box-danger ' :' box-success ' }}">
            <div class="box-header">
                <h3 class="box-title">
                    3. Tipos de violencias en este hecho
                </h3>

            </div>
            <div class="box-body bg-gray no-padding"> {{-- probé con div y queda mejor con tabla :-\ --}}
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
                                <td>
                                    {!! $violencia->descripcion->detalle !!}
                                </td>
                                <td>
                                    {!! Form::open(['action' => ['hecho_violenciaController@quitar', $violencia->id_hecho_violencia]]) !!}
                                    <button type="submit"  class="btn btn-danger btn-sm" onclick = "return confirm('Seguro?')">Quitar</button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
            <div class="box-footer no-padding">
                <div class="col-sm-12">
                    @include('hechos.p_agregar_violencia')
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>


    {{--  Responsabilidad colectiva: agregar tipo --}}

    {{-- Detalle de violencia agregada --}}
    <div class="col-sm-12">
        <div class="box box-solid  {{ count($hecho->rel_responsabilidad)==0 ? ' box-danger ' :' box-success ' }}">
            <div class="box-header">
                <h3 class="box-title">
                    4. Responsabilidad colectiva
                </h3>

            </div>
            <div class="box-body bg-gray no-padding">
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
            <div class="box-footer no-padding">
                @include('hechos.p_agregar_responsabilidad')

            </div>
        </div>
    </div>
    <div class="clearfix"></div>



    {{-- Contexto --}}
    <div class="col-sm-12">
        <div class="box {{ count($hecho->rel_contexto)>0 ? ' box-primary ' : ' box-danger ' }} box-solid">
            <div class="box-header">
                <h3 class="box-title">
                    Contexto (explicaciones, dinámicas y finalidades de las violencias)
                </h3>

            </div>
            @if(count($hecho->rel_contexto)>0)
                <div class="box-body">
                    <ol>
                        <li>Motivos específicos por los cuales cree que ocurrieron los hechos de violencia
                            <ul>
                                @foreach($hecho->arreglo_contexto_txt(127) as $id=>$txt)
                                    <li>{{$txt}}</li>
                                @endforeach
                            </ul>
                        </li>
                        <li>Contexto de control territorial y/o de la población
                        <ul>
                            @foreach($hecho->arreglo_contexto_txt(128) as $id=>$txt)
                                <li>{{$txt}}</li>
                            @endforeach
                        </ul>
                        </li>
                        <li>Si los hechos ocurrieron en lugares públicos, indique si dicho espacio es significativo para
                        <ul>
                            @foreach($hecho->arreglo_contexto_txt(129) as $id=>$txt)
                                <li>{{$txt}}</li>
                            @endforeach
                        </ul>
                        </li>
                        <li>Factores externos que influenciaron los hechos
                            <ul>
                                @foreach($hecho->arreglo_contexto_txt(130) as $id=>$txt)
                                    <li>{{$txt}}</li>
                                @endforeach
                            </ul>
                        </li>
                        <li>La persona entrevistada considera que estos hechos de violencia beneficiaron a
                            <ul>
                                @foreach($hecho->arreglo_contexto_txt(131) as $id=>$txt)
                                    <li>{{$txt}}</li>
                                @endforeach
                            </ul>
                        </li>
                    </ol>


                </div>
                <div class="box-footer">
                    <button class="btn btn-primary" onclick="$('#modal_contexto').modal('show')">Modificar contexto</button>
                </div>
            @else
                <div class="box-body">
                    <div class="text-yellow text-center">
                        <h4><i class="icon fa fa-warning"></i> Atención</h4>
                        No se ha diligenciado esta sección
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary" onclick="$('#modal_contexto').modal('show')">Especificar contexto</button>
                </div>
            @endif
        </div>
    </div>

<div class="clearfix"></div>


@endsection