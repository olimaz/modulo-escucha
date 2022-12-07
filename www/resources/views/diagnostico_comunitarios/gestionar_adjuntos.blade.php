@extends('layouts.app')
@section('content_header')
    <h1 class="page-header">
        Gestión de archivos adjuntos,  Entrevista  <a href="{{ action("diagnostico_comunitarioController@show",$diagnosticoComunitario->id_diagnostico_comunitario) }}">{!! $diagnosticoComunitario->entrevista_codigo !!} </a> <small># {!! $diagnosticoComunitario->entrevista_correlativo !!}</small>
        <a href="{{ action("diagnostico_comunitarioController@show",$diagnosticoComunitario->id_diagnostico_comunitario) }}" class="btn btn-default pull-right">Regresar a la ficha de la entrevista</a>
    </h1>
@endsection

@section('content')

        <div class="row">
            <div class="col-xs-12" id="div_tabla_adjuntos">
                @php($edicion=true)
                @include("diagnostico_comunitarios.tabla_adjuntos")
            </div>
        </div>

        <div class="box box-primary box-solid">
            <div class="box-header ">
                <h3 class="box-title"> Adjuntar archivos al expediente</h3>
            </div>
            <div class="box-body">
                @include("diagnostico_comunitarios.adjuntos")
            </div>
        </div>


        <div class="box box-info  collapsed-box box-solid">
            <div class="box-header ">
                <h3 class="box-title"> Detalles de la entrevista: {!! $diagnosticoComunitario->entrevista_codigo !!}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>

            </div>
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('diagnostico_comunitarios.show_fields')
                </div>
            </div>

        </div>
        <a href="{!! action('diagnostico_comunitarioController@index') !!}" class="btn btn-default">Regresar al listado de entrevistas</a>

@endsection


@include("controles.js_cargar_adjuntar_generico",
                [
                    'id_primaria' => $diagnosticoComunitario->id_diagnostico_comunitario,
                    'url_upload' => "upload_adjuntar_dc",
                    'url_adjuntos' => "tabla_adjuntos_dc",
                    //Para la traza de fallas
                    'codigo' => $diagnosticoComunitario->entrevista_codigo
                ])

