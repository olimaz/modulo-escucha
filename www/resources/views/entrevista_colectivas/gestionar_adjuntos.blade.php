@extends('layouts.app')
@section('content_header')
    <h1 class="page-header">
        Gestión de archivos adjuntos,  Entrevista <a href="{{ action("entrevista_colectivaController@show",$entrevistaColectiva->id_entrevista_colectiva) }}"> {!! $entrevistaColectiva->entrevista_codigo !!} </a> <small># {!! $entrevistaColectiva->entrevista_correlativo !!}</small>
        <a href="{{ action("entrevista_colectivaController@show",$entrevistaColectiva->id_entrevista_colectiva) }}" class="btn btn-default pull-right">Regresar a la ficha de la entrevista</a>
    </h1>
@endsection

@section('content')

        <div class="row">
            <div class="col-xs-12" id="div_tabla_adjuntos">
                @php($edicion=true)
                @include("entrevista_colectivas.tabla_adjuntos")
            </div>
        </div>

        <div class="box box-primary box-solid">
            <div class="box-header ">
                <h3 class="box-title"> Adjuntar archivos al expediente</h3>
            </div>
            <div class="box-body">
                @include("entrevista_colectivas.adjuntos")
            </div>
        </div>


        <div class="box box-info  collapsed-box box-solid">
            <div class="box-header ">
                <h3 class="box-title"> Detalles de la entrevista: {!! $entrevistaColectiva->entrevista_codigo !!}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>

            </div>
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('entrevista_colectivas.show_fields')
                </div>
            </div>

        </div>
        <a href="{!! action('entrevista_colectivaController@index') !!}" class="btn btn-default">Regresar al listado de entrevistas</a>

@endsection

@include("controles.js_cargar_adjuntar_generico",
                [
                    'id_primaria' => $entrevistaColectiva->id_entrevista_colectiva,
                    'url_upload' => "upload_adjuntar_co",
                    'url_adjuntos' => "tabla_adjuntos_colectiva",
                    //Para la traza de fallas
                    'codigo' => $entrevistaColectiva->entrevista_codigo
                ])

