@extends('layouts.app')
@include('layouts.js_contrae')

@section('content')
    <section class="content-header">
        <h1>
            {{ $exilio->rel_id_e_ind_fvt->entrevista_codigo }} - Ficha de exilio
            <div class="pull-right">
                @if($id_hecho <=0)
                    @if($edicion==1)
                        <a href="{!! action('entrevista_individualController@fichas',$exilio->id_e_ind_fvt) !!}" class="btn btn-default">Volver</a>
                    @else
                        <a href="{!! action('entrevista_individualController@fichas_show',$exilio->id_e_ind_fvt) !!}" class="btn btn-default">Volver</a>
                    @endif
                @else
                    @if($edicion==1)
                        <a href="{!! action('hechoController@edit',$id_hecho) !!}" class="btn btn-default">Volver</a>
                    @else
                        <a href="{!! action('hechoController@show',$id_hecho) !!}" class="btn btn-default">Volver</a>
                    @endif
                @endif
            </div>
        </h1>
    </section>
    <div class="content">
        {{-- Primera salida --}}
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">
                    1. Ficha de primera salida
                </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('exilios.show_fields')
                </div>
            </div>
            @if(!isset($no_editar))
                <div class="box-footer">
                    <a href="{!! action('exilioController@edit',$exilio->id_exilio) !!}" class="btn btn-primary">Modificar esta sección</a>
                </div>
            @endif
        </div>
        {{-- Reasentamientos--}}
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title">
                    2. Reasentamientos
                </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body ">
                <div class="row" >
                    @php($fila=1)
                    @foreach($exilio->listar_reasentamientos() as $salida)
                        @if($fila>1)
                            <hr>
                        @endif
                        <h4 style="padding-left: 20px">
                            Reasentamiento #{{ $fila++ }}
                            @if(!isset($no_editar))
                                <div class="pull-right">
                                    {!! Form::open(['action' => ['exilio_movimientoController@destroy', $salida->id_exilio_movimiento], 'method' => 'delete']) !!}
                                    <div class='btn-group'>
                                        <div class="pull-right" style="margin-right: 50px">
                                            <a class='btn btn-default' href="{{ action('exilio_movimientoController@edit',$salida->id_exilio_movimiento) }}">Modificar</a>
                                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger ', 'onclick' => "return confirm('¿Está segura?')"]) !!}
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            @endif
                        </h4>
                        @include('exilio_movimiento.show_fields_2')
                    @endforeach
                </div>
            </div>
            @if(!isset($no_editar))
                <div class="box-footer">
                    <a href="{{ action('exilio_movimientoController@create',$exilio->id_exilio) }}?id_tipo_movimiento=2" class="btn btn-primary">Agregar reasentamiento</a>
                </div>
            @endif
        </div>
        {{-- Impactos y afrontamientos del exilio --}}

        <div class="box  box-solid {{ $exilio->fmt_completo->impactos == 0 ? 'box-warning' : 'box-primary' }}">
            <div class="box-header">
                <h3 class="box-title">
                    3. Impactos y afrontamientos específicos del exilio
                </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                        @include('exilio_impacto.show_fields')
                </div>
            </div>
            @if(!isset($no_editar))
                <div class="box-footer">
                    <a href="{{ action('exilio_impactoController@edit',$exilio->id_exilio) }}" class="btn btn-primary">Diligenciar información de impactos y afrontamientos</a>
                </div>
            @endif
        </div>
        {{-- Retorno --}}
        @php($retorno = $exilio->retorno())
        <div class="box box-solid {{ $exilio->fmt_completo->mov_3 == 0 ? 'box-warning' : 'box-primary' }}">
            <div class="box-header">
                <h3 class="box-title">
                    4. Retorno
                </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body no-padding">
                {{-- HAY información del retorno   --}}
                @if(!empty($retorno))
                    @php($movimiento = clone $retorno)
                    <div class="col-sm-6">
                        {!! Form::label('id_ha_tenido_retorno', '¿Ha tenido uno o más procesos de retorno?') !!}
                        <p> {{ $exilio->fmt_id_ha_tenido_retorno }}</p>
                    </div>
                    <div class="col-sm-6">
                        @if($exilio->id_ha_tenido_retorno==1)
                            {!! Form::label('porque_si', '¿Porqué retornó?') !!}
                            <ul>
                                @foreach($movimiento->arreglo_motivo(212) as $id)
                                    <li>{{ \App\Models\cat_item::describir($id) }}</li>
                                @endforeach
                            </ul>
                        @else
                            {!! Form::label('porque_no', '¿Porqué no ha retornado?') !!}
                            <ul>
                                @foreach($movimiento->arreglo_motivo(213) as $id)
                                    <li>{{ \App\Models\cat_item::describir($id) }}</li>
                                @endforeach
                            </ul>

                        @endif
                    </div>
                    {{-- Sí retornó --}}
                    @if($exilio->id_ha_tenido_retorno==1)
                        @php($salida = $movimiento)
                        <div class="clearfix"></div>
                        @include('exilio_movimiento.show_fields_3')
                    @endif
                @endif

            </div>
            @if(!isset($no_editar))
                <div class="box-footer">
                        @if(empty($retorno))
                            <a href="{{ action('exilio_movimientoController@create',$exilio->id_exilio) }}?id_tipo_movimiento=3" class="btn btn-primary">Agregar información del retorno</a>
                        @else
                            {!! Form::open(['action' => ['exilio_movimientoController@destroy', $retorno->id_exilio_movimiento], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <div class="pull-right" style="margin-right: 50px">
                                    <a class='btn btn-primary' href="{{ action('exilio_movimientoController@edit',$retorno->id_exilio_movimiento) }}">Modificar esta sección</a>
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger ', 'onclick' => "return confirm('¿Está segura?')"]) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        @endif
                </div>
            @endif
        </div>
    </div>
    {{-- Fin --}}
    @if(!isset($no_editar))
        <div class="col-sm-12 ">
            @if($exilio->fmt_completo->completa)
                <div class="text-center">
                    <a href="{!! action('entrevista_individualController@fichas',$exilio->id_e_ind_fvt) !!}" class="btn btn-success btn-lg" >Finalizar</a>
                </div>


            @else
                <div class="callout callout-warning">
                    <h4>Datos incompletos</h4>
                    <ul>
                        @foreach($exilio->fmt_completo->alerta as $txt)
                            <li>{{ $txt }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif
    <div class="clearfix"></div>
@endsection
