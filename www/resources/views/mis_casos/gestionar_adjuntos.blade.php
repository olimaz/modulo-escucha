@extends('layouts.app')
@section('content_header')
    <div class="text-right">
        <a href="{{ action("mis_casosController@show",$miCaso->id_mis_casos) }}" class="btn btn-default pull-right">Regresar a la ficha del caso</a>
    </div>
    <h1 class="page-title">
        Gestión de archivos adjuntos,  Caso transversal <a href="{{ action("mis_casosController@show",$miCaso->id_mis_casos) }}"> {!! $miCaso->entrevista_codigo !!} </a>  <small># {!! $miCaso->nombre !!}</small>

    </h1>
@endsection

@section('content')



    <div class="box box-primary box-solid">
        <div class="box-header ">
            <h3 class="box-title"> Adjuntar archivos al caso transversal</h3>
        </div>
        <div class="box-body">
            {!! Form::open(['action' => 'mis_casosController@crear_adjunto','id'=>'frm_adjunto','files' => true]) !!}
                {!! Form::hidden('id_mis_casos',$miCaso->id_mis_casos) !!}
                {!! Form::hidden('id_seccion',$id_seccion) !!}
                @include("mis_casos.adjuntos")
            {!! Form::close() !!}
        </div>
    </div>
    {{--
    <div class="row">
        <div class="col-xs-12" id="div_tabla_adjuntos">
            @php($edicion=true)
            @include("mis_casos.tabla_adjuntos")
        </div>
    </div>
    --}}





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
