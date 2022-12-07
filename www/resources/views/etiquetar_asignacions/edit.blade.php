@extends('layouts.app')
@section('content_header')
    <h1>
        Finalizar asignación de etiquetado
    </h1>
@endsection

@section('content')
    @include('adminlte-templates::common.errors')

    <section>
        <div class="row">
            <div class="col-xs-12" id="div_tabla_adjuntos">
                @if($etiquetarAsignacion->id_e_ind_fvt>0)
                    @php($entrevistaIndividual=$entrevista)
                    @include("entrevista_individuals.tabla_adjuntos")
                @elseif($etiquetarAsignacion->id_entrevista_profundidad > 0)
                    @php($entrevistaProfundidad=$entrevista)
                    @include("entrevista_profundidads.tabla_adjuntos")
                @elseif($etiquetarAsignacion->id_entrevista_colectiva > 0)
                    @php($entrevistaColectiva=$entrevista)
                    @include("entrevista_colectivas.tabla_adjuntos")
                @elseif($etiquetarAsignacion->id_entrevista_etnica > 0)
                    @php($entrevistaEtnica=$entrevista)
                    @include("entrevista_etnicas.tabla_adjuntos")
                @elseif($etiquetarAsignacion->id_diagnostico_comunitario > 0)
                    @php($diagnosticoComunitario=$entrevista)
                    @include("diagnostico_comunitarios.tabla_adjuntos")
                @elseif($etiquetarAsignacion->id_historia_vida > 0)
                    @php($historiaVida=$entrevista)
                    @include("historia_vidas.tabla_adjuntos")
                @endif

            </div>
        </div>
    </section>
    <section>
        <div class="box box-primary box-solid">
            <div class="box-header ">
                <h3 class="box-title"> Adjuntar archivos adicionales</h3>
            </div>
            <div class="box-body">
                <div class="col-sm-3">
                    @include('controles.carga_archivo', ['control_control' => 'archivo_25'
                                                               , 'control_texto'=>"<i class='fa fa-tags' aria-hidden='true'></i> Etiquetado"])
                </div>
            </div>

        </div>
    </section>
    <h1>Actualizar estado de la asignación</h1>
    @include('adminlte-templates::common.errors')
    <div class="box box-primary">
        <div class="box-body row">
            {!! Form::model($etiquetarAsignacion, ['route' => ['etiquetarAsignacions.update', $etiquetarAsignacion->id_etiquetar_asignacion], 'method' => 'patch','id'=>'frm_abc']) !!}
            <div class="col-sm-6">
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">1. Procesamiento de la entrevista {!! $etiquetarAsignacion->codigo_entrevista !!}</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-sm-4">
                            {!! Form::label('id_transcriptor', 'Transcriptor:') !!}
                            <p>{!! $etiquetarAsignacion->fmt_id_transcriptor !!}</p>
                        </div>
                        <div class="form-group col-sm-4">
                            {!! Form::label('id_autoriza', 'Asignado por:') !!}
                            <p>{!! $etiquetarAsignacion->fmt_id_autoriza !!}</p>
                        </div>
                        <div class="form-group col-sm-4">
                            {!! Form::label('id_autoriza', '¿Urgente?') !!}
                            <p>{!! $etiquetarAsignacion->fmt_urgente !!}</p>
                        </div>

                        <div  class="clearfix"></div>

                        {{-- --}}
                        <div class="form-group col-sm-6">
                            {!! Form::label('id_situacion', 'Resultado del etiquetado:') !!}

                            {!! Form::select('id_situacion', \App\Models\criterio_fijo::listado_resultados_etiquetado(),null, ['class' => 'form-control','rows'=>3]) !!}
                        </div>
                        <div class="form-group col-sm-6 ">
                            @include('controles.catalogo', ['control_control' => 'id_causa'
                                             ,'control_id_cat'=>86
                                             , 'control_default'=>$etiquetarAsignacion->id_causa
                                             , 'control_multiple' => false
                                             , 'control_requerido' => false
                                             , 'control_vacio' => 'No Aplica: sí se etiquetó'
                                             ,'control_texto'=>'Si no fué etiquetado, clasifique la causa:'])
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-6">
                            @include('controles.fecha', [
                                                        'control_control' => 'fecha_inicio'
                                                        , 'control_requerido' => true
                                                        , 'control_texto' => 'Fecha en que inició el procesamiento'
                                                        , 'control_default' => date("Y-m-d")
                                                        ])
                        </div>
                        <div class="form-group col-sm-6">
                            @include('controles.hora', [
                                                        'control_control' => 'hora_inicio'
                                                        , 'control_requerido' => true
                                                        , 'control_texto' => 'Hora en que inició el procesamiento'
                                                        , 'control_default' => date("H:i")
                                                        ])
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-6">
                            @include('controles.fecha', [
                                                        'control_control' => 'fecha_fin'
                                                        , 'control_requerido' => true
                                                        , 'control_texto' => 'Fecha en que finalizó el procesamiento'
                                                        , 'control_default' => date("Y-m-d")
                                                        ])
                        </div>
                        <div class="form-group col-sm-6">
                            @include('controles.hora', [
                                                        'control_control' => 'hora_fin'
                                                        , 'control_requerido' => true
                                                        , 'control_texto' => 'Hora en que finalizó el procesamiento'
                                                        , 'control_default' => date("H:i")
                                                        ])
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-12">
                            @include('controles.radio_si_no', [
                                                        'control_control' => 'terceros'
                                                        , 'control_texto' => 'Esta entrevista ya contaba con una transcripción de otra persona'
                                                        , 'control_default' => 2
                                                        ])
                        </div>
                        <div class="clearfix"></div>

                        <!-- Observaciones Field -->
                        <div class="form-group col-sm-12 ">
                            {!! Form::label('observaciones', 'Observaciones respecto al etiquetado:') !!}
                            {!! Form::textarea('observaciones', null, ['class' => 'form-control','rows'=>3]) !!}
                        </div>

                    </div>
                </div>
            </div>

            {{-- TIEMPOS --}}

            <div class="col-sm-6">
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">2. Tiempo consumido en el procesamiento</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-sm-12">
                            {!! Form::label('duracion_entrevista_minutos', 'Duración total de la entrevista, calculada en minutos:') !!}
                            {!! Form::number('duracion_entrevista_minutos', null, ['class' => 'form-control','min'=>1,'step'=>'1']) !!}
                        </div>
                        <div class="form-group col-sm-12">
                            {!! Form::label('duracion_transcripcion_minutos', 'Tiempo utilizado para la transcripción, calculada en minutos:') !!}
                            {!! Form::number('duracion_transcripcion_minutos', null, ['class' => 'form-control','min'=>0,'step'=>'1']) !!}
                        </div>
                        <div class="form-group col-sm-12">
                            {!! Form::label('duracion_etiquetado_minutos', 'Tiempo utilizado para el etiquetado, calculada en minutos:') !!}
                            {!! Form::number('duracion_etiquetado_minutos', null, ['class' => 'form-control','min'=>0, 'step'=>'1']) !!}
                        </div>
                        <div class="form-group col-sm-12">
                            {!! Form::label('duracion_fichas_minutos', 'Tiempo utilizado para el diligenciado de fichas, calculada en minutos:') !!}
                            {!! Form::number('duracion_fichas_minutos', null, ['class' => 'form-control','min'=>0, 'step'=>'1']) !!}
                        </div>
                    </div>
                </div>
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">3. Priorización de la entrevista</h3>
                    </div>
                    <div class="box-body">
                        @php($default_fluidez = $etiquetarAsignacion->fluidez)
                        @php($default_cierre = $etiquetarAsignacion->cierre)
                        @php($default_d_hecho = $etiquetarAsignacion->d_hecho)
                        @php( $default_d_contexto = $etiquetarAsignacion->d_contexto)
                        @php($default_d_impacto = $etiquetarAsignacion->d_impacto)
                        @php($default_d_justicia = $etiquetarAsignacion->d_justicia)
                        @php($default_ahora_entiendo = $etiquetarAsignacion->ahora_entiendo)
                        @php($default_cambio_perspectiva = $etiquetarAsignacion->cambio_perspectiva)

                        @include("seguimiento.p_priorizacion")
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>


            {{-- Seguimiento --}}
            <div class="col-sm-12">
                <div class="box box-default box-solid">
                    <div class="box-header">
                        <h3 class="box-title">4. Reportar problemas / realizar seguimiento a la entrevista</h3>
                    </div>
                    <div class="box-body">
                        @include('seguimiento.fields')
                    </div>
                </div>
            </div>

            <!-- Submit Field -->
            <div class="form-group col-sm-12">
                {!! Form::button('Grabar', ['class' => 'btn btn-primary','id'=>'btn_asignar']) !!}
                <a href="{!! route('etiquetarAsignacions.index') !!}" class="btn btn-default">Cancelar</a>
            </div>




            {!! Form::close() !!}
        </div>
    </div>




@endsection


@if($etiquetarAsignacion->id_e_ind_fvt>0)
    @include("controles.js_carga_archivo_adjuntar")
@elseif($etiquetarAsignacion->id_entrevista_colectiva)
    @include("entrevista_colectivas.js_carga_archivo_adjuntar")
@elseif($etiquetarAsignacion->id_entrevista_etnica)
    @include("entrevista_etnicas.js_carga_archivo_adjuntar")
@elseif($etiquetarAsignacion->id_entrevista_profundidad)
    @include("entrevista_profundidads.js_carga_archivo_adjuntar")
@elseif($etiquetarAsignacion->id_diagnostico_comunitario)
    @include("diagnostico_comunitarios.js_carga_archivo_adjuntar")
@elseif($etiquetarAsignacion->id_historia_vida)
    @include("historia_vidas.js_carga_archivo_adjuntar")
@endif

@push('js')
    <script>
        $(function(){
            $('#btn_asignar').click(function(){

                var minutos_trans =  $("#duracion_etiquetado_minutos").val();
                var correcto = true;

                if(minutos_trans <= 0) {
                    alert('Favor de especificar la duración del etiquetado como un número entero, sin signos de puntuación');
                    $("#duracion_etiquetado_minutos").focus();
                    correcto = false;
                }

                if(correcto) {
                    $('#frm_abc').submit();
                }
            });
        })
    </script>
@endpush



