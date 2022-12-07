@extends('layouts.app')

@section('content')
    {{-- Entrevistas anuladas --}}
    @if($entrevistaEtnica->id_activo <> 1)
        @include("partials.anulada")
    @endif

    {{-- Marcas del usuario--}}
    @php($marcas = \App\Models\marca_entrevista::listado_marcas(config('expedientes.ee'), $entrevistaEtnica->id_entrevista_etnica))
    @include('partials.marcas')
    <div class="pull-right">
        {{-- Anular entrevista --}}
        @php($anular_id= $entrevistaEtnica->id_entrevista_etnica)
        @php($anular_url = action('entrevista_etnicaController@anular',$anular_id))
        @include("partials.anular")

        {{-- Nube de etiquetas --}}
        @if($entrevistaEtnica->puede_acceder_adjuntos())
            @if($entrevistaEtnica->json_etiquetado)
                @include("partials.nube_tesauro",['txt_nube_tesauro' => strip_tags(nl2br($entrevistaEtnica->etiquetas_a_texto()))])
            @endif
            @if($entrevistaEtnica->html_transcripcion)
                @include("partials.nube",['txt_nube' => strip_tags(nl2br($entrevistaEtnica->fmt_html_transcripcion))])
            @endif
        @endif
        @if($entrevistaEtnica->puede_modificar_entrevista())
            @if($entrevistaEtnica->puede_acceder_adjuntos())
                <a class='btn btn-default pull-right no-print ' data-toggle="tooltip" title="Gestionar archivos adjuntos"  href="{!! action('entrevista_etnicaController@gestionar_adjuntos', [$entrevistaEtnica->id_entrevista_etnica]) !!}" ><i class="glyphicon glyphicon-paperclip"></i></a>
                {{--
                <a data-toggle="tooltip" title="Diligenciar fichas: {{ $entrevistaEtnica->diligenciada->situacion_texto }} "  href="{!! action('entrevista_etnicaController@fichas', [$entrevistaEtnica->id_entrevista_etnica]) !!}" class='btn {{ $entrevistaEtnica->diligenciada->situacion_boton }} pull-right '><i class="glyphicon glyphicon-send"></i></a>
                --}}
            @endif
        @endif
            {{-- MArcar entrevista --}}
            @php($id_subserie = config('expedientes.ee'))
            @php($id_entrevista = $entrevistaEtnica->id_entrevista_etnica)
            @php($codigo_entrevista = $entrevistaEtnica->entrevisa_codigo)
            @include("partials.boton_marca")
    </div>


    <h1 class="page-title">
        {!! $entrevistaEtnica->entrevista_codigo !!} <small> Entrevista a sujeto colectivo [R-{{ $entrevistaEtnica->clasificacion_nivel }}]</small>


    </h1>

    {{-- Criterio de priorizacion --}}
    @php($prioridad = $entrevistaEtnica->prioridad)
    @include('partials.prioridad')

    {{-- Etiquetado o transcripcion --}}
    @php($entrevista = $entrevistaEtnica)
    @include('partials.show_etiquetado',['id_subserie'=>config("expedientes.ee"), 'id_entrevista'=>$entrevistaEtnica->id_entrevista_etnica])

    {{-- CONSENTIMIENTO  (esto ya no, porque pueden ser varias)
        @php($consentimiento = $entrevistaEtnica->diligenciada)
        @include("partials.consentimiento_alertas")
    --}}

    {{-- Consentimientos informados --}}
    @php($consentimientos = $entrevista->rel_consentimiento_listado)
    @if(count($consentimientos)>0)
        @include("consentimientos.table")
    @endif




        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title"> Código de entrevista: {!! $entrevistaEtnica->entrevista_codigo !!}</h3>
            </div>
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('entrevista_etnicas.show_fields')

                </div>
            </div>
        </div>


    @php($edicion=false)
    @include('entrevista_etnicas.tabla_adjuntos')

        @include('entrevista_etnicas.clasificacion_show')


    {{-- Consentimiento informado --}}
    @php($consentimiento = $entrevistaEtnica->consentimiento)
    @include('partials.consentimiento_show')

    {{-- Accesos autorizados --}}
    @include('entrevista_etnicas.tabla_accesos')

    {{--
    <div class="col-sm-12">
        <a href="{!! action('entrevista_etnicaController@index') !!}" class="btn btn-default">Regresar al listado de entrevistas</a>
    </div>
    --}}
    <div class="clearfix"></div>
    @include('traza_actividads.por_expediente',['control_codigo'=>$entrevistaEtnica->entrevista_codigo])

@endsection
