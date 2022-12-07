@extends('layouts.app')



@section('content')
    {{-- Entrevistas anuladas --}}
    @if($historiaVida->id_activo <> 1)
        @include("partials.anulada")
    @endif
    {{-- Marcas del usuario--}}
    @php($marcas = \App\Models\marca_entrevista::listado_marcas(config('expedientes.hv'), $historiaVida->id_historia_vida))
    @include('partials.marcas')
    <div class="pull-right">
        {{-- Anular entrevista --}}
        @php($anular_id= $historiaVida->id_historia_vida)
        @php($anular_url = action('historia_vidaController@anular',$anular_id))
        @include("partials.anular")
        {{-- Nube de etiquetas --}}
        @if($historiaVida->puede_acceder_adjuntos())
            @if($historiaVida->json_etiquetado)
                @include("partials.nube_tesauro",['txt_nube_tesauro' => strip_tags(nl2br($historiaVida->etiquetas_a_texto()))])
            @endif
            @if($historiaVida->html_transcripcion)
                @include("partials.nube",['txt_nube' => strip_tags(nl2br($historiaVida->fmt_html_transcripcion))])
            @endif
        @endif
        @if($historiaVida->puede_modificar_entrevista())
            @if($historiaVida->puede_acceder_adjuntos())
                <a class='btn btn-default pull-right no-print ' data-toggle="tooltip" title="Gestionar archivos adjuntos"  href="{!! action('historia_vidaController@gestionar_adjuntos', [$historiaVida->id_historia_vida]) !!}" ><i class="glyphicon glyphicon-paperclip"></i></a>
            @endif
        @endif
            {{-- MArcar entrevista --}}
            @php($id_subserie = config('expedientes.hv'))
            @php($id_entrevista = $historiaVida->id_historia_vida)
            @php($codigo_entrevista = $historiaVida->entrevisa_codigo)
            @include("partials.boton_marca")
    </div>
    <h1 class="page-title">
       {!! $historiaVida->entrevista_codigo !!} <small> Historia de vida [R-{{ $historiaVida->clasificacion_nivel }}]</small>
    </h1>
    {{-- Etiquetado o transcripcion --}}
    @php($entrevista = $historiaVida)
    @include('partials.show_etiquetado',['id_subserie'=>config("expedientes.hv"), 'id_entrevista'=>$historiaVida->id_historia_vida])

    {{-- Criterio de priorizacion --}}
    @php($prioridad = $historiaVida->prioridad)
    @include('partials.prioridad')

    {{-- CONSENTIMIENTO--}}
    @php($consentimiento = $historiaVida->diligenciada)
    @include("partials.consentimiento_alertas")

    <div class="box box-primary">
        <div class="box-body">
            <div class="row" style="padding-left: 20px">
                @include('historia_vidas.show_fields')
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    @php($edicion=false)
    @include('historia_vidas.tabla_adjuntos')
    <div class="clearfix"></div>
    @include('historia_vidas.clasificacion_show')
    {{-- Consentimeinto informado --}}
    @php($consentimiento = $historiaVida->consentimiento)
    @include('partials.consentimiento_show')

    <div class="clearfix"></div>
    @include('historia_vidas.tabla_accesos')
    {{--
    <div class="col-sm-12">
        <a href="{!! action('historia_vidaController@index') !!}" class="btn btn-default">Regresar al listado de entrevistas</a>
    </div>
    --}}
    <div class="clearfix"></div>
    @include('traza_actividads.por_expediente',['control_codigo'=>$historiaVida->entrevista_codigo])


@endsection
