@extends('layouts.app')

@section('content')
    {{-- Entrevistas anuladas --}}
    @if($entrevistaColectiva->id_activo <> 1)
        @include("partials.anulada")
    @endif
    {{-- Marcas del usuario --}}
    @php($marcas = \App\Models\marca_entrevista::listado_marcas(config('expedientes.co'), $entrevistaColectiva->id_entrevista_colectiva))
    @include('partials.marcas')

    <div class="pull-right">
        {{-- Anular entrevista --}}
        @php($anular_id= $entrevistaColectiva->id_entrevista_colectiva)
        @php($anular_url = action('entrevista_colectivaController@anular',$anular_id))
        @include("partials.anular")

        {{-- Nube de etiquetas --}}
        @if($entrevistaColectiva->puede_acceder_adjuntos())
            @if($entrevistaColectiva->json_etiquetado)
                @include("partials.nube_tesauro",['txt_nube_tesauro' => strip_tags(nl2br($entrevistaColectiva->etiquetas_a_texto()))])
            @endif
            @if($entrevistaColectiva->html_transcripcion)
                @include("partials.nube",['txt_nube' => strip_tags(nl2br($entrevistaColectiva->fmt_html_transcripcion))])
            @endif
        @endif


        @if($entrevistaColectiva->puede_modificar_entrevista())
            @if($entrevistaColectiva->puede_acceder_adjuntos())
                <a class='btn btn-default pull-right no-print ' data-toggle="tooltip" title="Gestionar archivos adjuntos"  href="{!! action('entrevista_colectivaController@gestionar_adjuntos', [$entrevistaColectiva->id_entrevista_colectiva]) !!}" ><i class="glyphicon glyphicon-paperclip"></i></a>
            @endif
        @endif
        {{-- MArcar entrevista --}}
        @php($id_subserie = config('expedientes.co'))
        @php($id_entrevista = $entrevistaColectiva->id_entrevista_colectiva)
        @php($codigo_entrevista = $entrevistaColectiva->entrevisa_codigo)
        @include("partials.boton_marca")

    </div>
    <h1 class="page-title">
        {!! $entrevistaColectiva->entrevista_codigo !!} <small> Entrevista colectiva [R-{{ $entrevistaColectiva->clasificacion_nivel }}]</small>
    </h1>

    {{-- Criterio de priorizacion --}}
    @php($prioridad = $entrevistaColectiva->prioridad)
    @include('partials.prioridad')
    @php($entrevista = $entrevistaColectiva)

    @include('partials.show_etiquetado',['id_subserie'=>config("expedientes.co"), 'id_entrevista'=>$entrevistaColectiva->id_entrevista_colectiva])



    {{-- Consentimientos informados --}}
    @php($consentimientos = $entrevista->rel_consentimiento)
    @if(count($consentimientos)>0)
        @include("consentimientos.table")
    @endif



        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title"> Código de entrevista: {!! $entrevistaColectiva->entrevista_codigo !!}</h3>
            </div>
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('entrevista_colectivas.show_fields')

                </div>
            </div>
        </div>


    @php($edicion=false)
    @include('entrevista_colectivas.tabla_adjuntos')

        @include('entrevista_colectivas.clasificacion_show')
        @include('entrevista_colectivas.tabla_accesos')

    {{--
    <div class="col-sm-12">
        <a href="{!! action('entrevista_colectivaController@index') !!}" class="btn btn-default">Regresar al listado de entrevistas</a>
        <br>
        <br>
    </div>
    --}}

    <div class="clearfix"></div>
    @include('traza_actividads.por_expediente',['control_codigo'=>$entrevistaColectiva->entrevista_codigo])

@endsection
