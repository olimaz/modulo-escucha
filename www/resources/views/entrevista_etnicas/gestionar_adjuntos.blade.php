@extends('layouts.app')
@section('content_header')
    <h1 class="page-header">
        Gestión de archivos adjuntos,  Entrevista <a href="{{ action("entrevista_etnicaController@show",$entrevistaEtnica->id_entrevista_etnica) }}"> {!! $entrevistaEtnica->entrevista_codigo !!} </a> <small># {!! $entrevistaEtnica->entrevista_correlativo !!}</small>
        {{-- <a href="{{ action("entrevista_etnicaController@show",$entrevistaEtnica->id_entrevista_etnica) }}" class="btn btn-default pull-right">Regresar a la ficha de la entrevista</a> --}}
    </h1>
    @if($entrevistaEtnica->id_subserie == config('expedientes.ee'))
        <ol class="breadcrumb">
            
            @if ($conteos->entrevista == 0)
                <li><a href="{{ action('entrevista_etnicaController@edit',$entrevistaEtnica->id_entrevista_etnica) }}?hecho_id"> 
                    1. Metadatos
                    </a>
                </li>
            @else
                {{-- <li class="active">1. Metadatos</li> --}}
                <li ><a href="{{ action('entrevista_etnicaController@edit',$entrevistaEtnica->id_entrevista_etnica) }}"> 1. Metadatos</a></li>
            @endif            

            <li class="active"> 2. <i class="fa fa-paperclip"></i> Adjuntos</li>
            <li><a href="{{ action('entrevista_etnicaController@fichas',$entrevistaEtnica->id_entrevista_etnica) }}">3. Fichas</a></li>
        </ol>
    @endif    
@endsection

@section('content')

        <div class="row">
            <div class="col-xs-12" id="div_tabla_adjuntos">
                @php($edicion=true)
                @include("entrevista_etnicas.tabla_adjuntos")
            </div>
        </div>

    {{-- Boton morado para diligenciar fichas --}}    
    @if($entrevistaEtnica->id_subserie == config('expedientes.ee'))
        <div class="row">
            <div class="col-xs-12 text-center">
                <div id="btn_no" class="hidden">
                    <button class="btn btn-lg  bg-purple" disabled title="Por favor, adjunte el consentimiento informado." data-toggle="tooltip"><i class="fa fa-send-o"></i> Diligenciar ficha digital </button>
                </div>
                <div id="btn_si"  class="hidden">
                    <a href="{{ action('entrevista_etnicaController@fichas',$entrevistaEtnica->id_entrevista_etnica) }}" class="btn btn-lg  bg-purple"><i class="fa fa-send-o"></i> Diligenciar ficha digital </a>
                </div>
            </div>
        </div>
        <br>
    @endif

        <div class="box box-primary box-solid">
            <div class="box-header ">
                <h3 class="box-title"> Adjuntar archivos al expediente</h3>
            </div>
            <div class="box-body">
                @include("entrevista_etnicas.adjuntos")
            </div>
        </div>


        <div class="box box-info  collapsed-box box-solid">
            <div class="box-header ">
                <h3 class="box-title"> Detalles de la entrevista: {!! $entrevistaEtnica->entrevista_codigo !!}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>

            </div>
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('entrevista_etnicas.show_fields')
                </div>
            </div>

        </div>
        <a href="{!! action('entrevista_etnicaController@index') !!}" class="btn btn-default">Regresar al listado de entrevistas</a>

@endsection


@include("controles.js_cargar_adjuntar_generico",
                [
                    'id_primaria' => $entrevistaEtnica->id_entrevista_etnica,
                    'url_upload' => "upload_adjuntar_ee",
                    'url_adjuntos' => "tabla_adjuntos_ee",
                    //Para la traza de fallas
                    'codigo' => $entrevistaEtnica->entrevista_codigo
                ])



@include("entrevista_etnicas.js_transcribir_google")

@push("js")

<script>

$(function() {
    @if(empty($entrevistaEtnica->archivo_ci))
        
        $("#btn_no").removeClass('hidden');
    @else
        $("#btn_si").removeClass('hidden');
    @endif
});

</script>
@endpush