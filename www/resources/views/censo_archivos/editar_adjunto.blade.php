@extends('layouts.app')
@section('content_header')
    <div class="text-right">
        <a href="{{ action("censo_archivosController@show",$censoArchivo->id_censo_archivos) }}" class="btn btn-default pull-right">Regresar a la ficha del registro</a>
    </div>
    <h1 class="page-title">
        Modificar archivos adjuntos,  Registro de archivos en el exilio <a href="{{ action("censo_archivosController@show",$censoArchivo->id_censo_archivos) }}"> {!! $censoArchivo->entrevista_codigo !!} </a>
    </h1>
@endsection

@section('content')



    <div class="box box-primary box-solid">
        <div class="box-header ">
            <h3 class="box-title"> Modificar archivo anexado al registro de archivo en el exilio</h3>
        </div>
        <div class="box-body">


            {!! Form::model($adjuntado,['action' => ['censo_archivos_adjuntoController@update',$adjuntado->id_censo_archivos_adjunto],'id'=>'frm_adjunto','files' => true]) !!}
                @include("censo_archivos.adjuntos")
            {!! Form::close() !!}
        </div>
    </div>


@endsection


{{--
@include("controles.js_cargar_adjuntar_generico",
                [
                    'id_primaria' => $miCaso->id_mis_casos,
                    'url_upload' => "upload_adjuntar_mc",
                    'url_adjuntos' => "tabla_adjuntos_mc",
                ])

--}}

@include("controles.js_carga_archivo")
@push('js')
    <script>
        $('#frm_adjunto').submit(function() {
            //Ver que haya cargado algo
            var pendientes = false;
            if($("#archivo_4_filename").val().length < 1) {
                pendientes = true;
            }
            if(pendientes) {
                alert("No cargó el archivo.  Antes de grabar el adjunto, debe cargar el archivo");
                return false;
            }
            else {
                return true;
            }
        });
    </script>
@endpush
