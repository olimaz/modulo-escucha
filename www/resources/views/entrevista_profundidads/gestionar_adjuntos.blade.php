@extends('layouts.app')
@section('content_header')
    <h1 class="page-header">
        Gestión de archivos adjuntos,  Entrevista  <a href="{{ action("entrevista_profundidadController@show",$entrevistaProfundidad->id_entrevista_profundidad) }}" >{!! $entrevistaProfundidad->entrevista_codigo !!} </a> <small># {!! $entrevistaProfundidad->entrevista_correlativo !!}</small>
        <a href="{{ action("entrevista_profundidadController@show",$entrevistaProfundidad->id_entrevista_profundidad) }}" class="btn btn-default pull-right">Regresar a la ficha de la entrevista</a>
    </h1>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12" id="div_tabla_adjuntos">
            @php($edicion=true)
            @include("entrevista_profundidads.tabla_adjuntos")
        </div>
    </div>

    <div class="box box-primary box-solid">
        <div class="box-header ">
            <h3 class="box-title"> Adjuntar archivos al expediente</h3>
        </div>
        <div class="box-body">
            @include("entrevista_profundidads.adjuntos")
        </div>
    </div>


    <div class="box box-info  collapsed-box box-solid">
        <div class="box-header ">
            <h3 class="box-title"> Detalles de la entrevista: {!! $entrevistaProfundidad->entrevista_codigo !!}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div>

        </div>
        <div class="box-body">
            <div class="row" style="padding-left: 20px">
                @include('entrevista_profundidads.show_fields')
            </div>
        </div>

    </div>
    <a href="{!! action('entrevista_profundidadController@index') !!}" class="btn btn-default">Regresar al listado de entrevistas</a>

@endsection



@include("controles.js_cargar_adjuntar_generico",
                [
                    'id_primaria' => $entrevistaProfundidad->id_entrevista_profundidad,
                    'url_upload' => "upload_adjuntar_pr",
                    'url_adjuntos' => "tabla_adjuntos_pr",
                    //Para la traza de fallas
                    'codigo' => $entrevistaProfundidad->entrevista_codigo
                ])

@include('entrevista_profundidads.js_transcribir_google')