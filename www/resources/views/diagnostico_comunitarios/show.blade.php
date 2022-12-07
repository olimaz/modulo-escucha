@extends('layouts.app')
@section('content_header')

@endsection

@section('content')
    {{-- Entrevistas anuladas --}}
    @if($diagnosticoComunitario->id_activo <> 1)
        @include("partials.anulada")
    @endif
    {{-- Marcas del usuario--}}
    @php($marcas = \App\Models\marca_entrevista::listado_marcas(config('expedientes.dc'), $diagnosticoComunitario->id_diagnostico_comunitario))
    @include('partials.marcas')
    <div class="pull-right">
        {{-- Anular entrevista --}}
        @php($anular_id= $diagnosticoComunitario->id_diagnostico_comunitario)
        @php($anular_url = action('diagnostico_comunitarioController@anular',$anular_id))
        @include("partials.anular")

        {{-- Nube de etiquetas --}}
        @if($diagnosticoComunitario->puede_acceder_adjuntos())
            @if($diagnosticoComunitario->json_etiquetado)
                @include("partials.nube_tesauro",['txt_nube_tesauro' => strip_tags(nl2br($diagnosticoComunitario->etiquetas_a_texto()))])
            @endif
            @if($diagnosticoComunitario->html_transcripcion)
                @include("partials.nube",['txt_nube' => strip_tags(nl2br($diagnosticoComunitario->fmt_html_transcripcion))])
            @endif
        @endif
        @if($diagnosticoComunitario->puede_modificar_entrevista())
            @if($diagnosticoComunitario->puede_acceder_adjuntos())
                <a class='btn btn-default pull-right no-print ' data-toggle="tooltip" title="Gestionar archivos adjuntos"  href="{!! action('diagnostico_comunitarioController@gestionar_adjuntos', [$diagnosticoComunitario->id_diagnostico_comunitario]) !!}" ><i class="glyphicon glyphicon-paperclip"></i></a>
            @endif
        @endif
            {{-- MArcar entrevista --}}
            @php($id_subserie = config('expedientes.dc'))
            @php($id_entrevista = $diagnosticoComunitario->id_diagnostico_comunitario)
            @php($codigo_entrevista = $diagnosticoComunitario->entrevisa_codigo)
            @include("partials.boton_marca")
    </div>
    <h1 class="page-title">
         {!! $diagnosticoComunitario->entrevista_codigo !!} <small> Diagnóstico comunitario [R-{{ $diagnosticoComunitario->clasificacion_nivel }}]</small>
    </h1>

    {{-- Etiquetado o transcripcion --}}
    @php($entrevista = $diagnosticoComunitario)
    @include('partials.show_etiquetado',['id_subserie'=>config("expedientes.dc"), 'id_entrevista'=>$diagnosticoComunitario->id_diagnostico_comunitario])

    {{-- Criterio de priorizacion --}}
    @php($prioridad = $diagnosticoComunitario->prioridad)
    @include('partials.prioridad')

    {{-- Consentimientos informados --}}
    @php($consentimientos = $entrevista->rel_consentimiento)
    @if(count($consentimientos)>0)
        @include("consentimientos.table")
    @endif


    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title"> Código de entrevista: {!! $diagnosticoComunitario->entrevista_codigo !!}</h3>
        </div>
        <div class="box-body">
            <div class="row" style="padding-left: 20px">
                @include('diagnostico_comunitarios.show_fields')

            </div>
        </div>
    </div>
    @php($edicion=false)
    @include('diagnostico_comunitarios.tabla_adjuntos')

    @include('diagnostico_comunitarios.clasificacion_show')
    @include('diagnostico_comunitarios.tabla_accesos')
    {{--
    <div class="col-sm-12">
        <a href="{!! action('diagnostico_comunitarioController@index') !!}" class="btn btn-default">Regresar al listado de entrevistas</a>
    </div>
    --}}
    <div class="clearfix"></div>
    @include('traza_actividads.por_expediente',['control_codigo'=>$diagnosticoComunitario->entrevista_codigo])

@endsection
