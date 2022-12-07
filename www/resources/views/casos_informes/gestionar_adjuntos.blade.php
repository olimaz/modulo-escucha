@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="page-header">
            Gestión de archivos adjuntos,  Caso/Informe  {!! $casosInformes->codigo !!}  <small># {!! $casosInformes->correlativo !!}</small>
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-xs-12" id="div_tabla_adjuntos">
                @include("casos_informes.tabla_adjuntos")
            </div>
        </div>

        <div class="box box-primary box-solid">
            <div class="box-header ">
                <h3 class="box-title"> Adjuntar archivos adicionales</h3>
            </div>
            <div class="box-body">
                {!! Form::open( ['action' => ['casos_informesController@agregar_adjuntos', $casosInformes->id_casos_informes]]) !!}
                    @include("casos_informes.adjuntos")
                {!! Form::close() !!}
            </div>
            <div class="box-footer">
                <a href="{{ action("casos_informesController@index") }}" class="btn btn-default">Cancelar</a>
            </div>

        </div>






        <div class="box box-info  box-solid">
            <div class="box-header ">
                <h3 class="box-title"> Detalles de la caso/informe: {!! $casosInformes->codigo !!}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>

            </div>
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('casos_informes.show_fields')
                    <a href="{!! route('casosInformes.index') !!}" class="btn btn-default">Listado general</a>
                </div>
            </div>
        </div>
    </div>
@endsection



@include("controles.js_cargar_adjuntar_generico",
                [
                    'id_primaria' => $casosInformes->id_casos_informes,
                    'url_upload' => "upload_adjuntar_caso_informe",
                    'url_adjuntos' => "tabla_adjuntos_casos",
                ])


