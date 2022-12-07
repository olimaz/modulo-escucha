@extends('layouts.app')

@section('content')
    {{-- Entrevistas anuladas --}}
    @if($entrevistaProfundidad->id_activo <> 1)
        @include("partials.anulada")
    @endif
    {{-- Marcas del usuario--}}
    @php($marcas = \App\Models\marca_entrevista::listado_marcas(config('expedientes.pr'), $entrevistaProfundidad->id_entrevista_profundidad))
    @include('partials.marcas')
    <div class="pull-right">
        {{-- Anular entrevista --}}
        @php($anular_id= $entrevistaProfundidad->id_entrevista_profundidad)
        @php($anular_url = action('entrevista_profundidadController@anular',$anular_id))
        @include("partials.anular")

        {{-- Nube de etiquetas --}}
        @if($entrevistaProfundidad->puede_acceder_adjuntos())
            @if($entrevistaProfundidad->json_etiquetado)
                @include("partials.nube_tesauro",['txt_nube_tesauro' => strip_tags(nl2br($entrevistaProfundidad->etiquetas_a_texto()))])
            @endif
            @if($entrevistaProfundidad->html_transcripcion)
                @include("partials.nube",['txt_nube' => strip_tags(nl2br($entrevistaProfundidad->fmt_html_transcripcion))])
            @endif
        @endif
        @if($entrevistaProfundidad->puede_modificar_entrevista())
            @if($entrevistaProfundidad->puede_acceder_adjuntos())
                <a class='btn btn-default pull-right no-print ' data-toggle="tooltip" title="Gestionar archivos adjuntos"  href="{!! action('entrevista_profundidadController@gestionar_adjuntos', [$entrevistaProfundidad->id_entrevista_profundidad]) !!}" ><i class="glyphicon glyphicon-paperclip"></i></a>
            @endif
            {!!  $entrevistaProfundidad->diligenciada->btn_consentimiento !!}
        @endif
        {!!  $entrevistaProfundidad->diligenciada->btn_show !!}
            {{-- MArcar entrevista --}}
            @php($id_subserie = config('expedientes.pr'))
            @php($id_entrevista = $entrevistaProfundidad->id_entrevista_profundidad)
            @php($codigo_entrevista = $entrevistaProfundidad->entrevisa_codigo)
            @include("partials.boton_marca")
    </div>
    <h1 class="page-title">
         {!! $entrevistaProfundidad->entrevista_codigo !!} <small> Entrevista a profundidad [R-{{ $entrevistaProfundidad->clasificacion_nivel }}]</small>
        {{--
            <a href="{!! action('entrevista_profundidadController@index') !!}" class="btn btn-default pull-right">Regresar al listado de entrevistas</a>
        --}}
    </h1>

    {{-- Criterio de priorizacion --}}
    @php($prioridad = $entrevistaProfundidad->prioridad)
    @include('partials.prioridad')

    {{-- Etiquetado o transcripcion --}}
    @php($entrevista = $entrevistaProfundidad)
    @include('partials.show_etiquetado',['id_subserie'=>config("expedientes.pr"), 'id_entrevista'=>$entrevistaProfundidad->id_entrevista_profundidad])


    {{-- CONSENTIMIENTO--}}
    @php($consentimiento = $entrevistaProfundidad->diligenciada)
    @include("partials.consentimiento_alertas")

    <div class="box box-primary">
        <div class="box-body">
            <div class="row" style="padding-left: 20px">
                @include('entrevista_profundidads.show_fields')
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    @php($edicion=false)
    @include('entrevista_profundidads.tabla_adjuntos')
    <div class="clearfix"></div>

    @include('entrevista_profundidads.clasificacion_show')
    <div class="clearfix"></div>

    @php($consentimiento = $entrevistaProfundidad->consentimiento)
    @include('partials.consentimiento_show')

    @include('entrevista_profundidads.tabla_accesos')
    <div class="clearfix"></div>

    @include('traza_actividads.por_expediente',['control_codigo'=>$entrevistaProfundidad->entrevista_codigo])



@endsection
