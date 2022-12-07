{{--
@php($colapsar_menu= $filtros->id_tesauro > 0 || count($filtros->marca) > 0 || strlen($filtros->fts) > 0)
--}}
@extends('layouts.app')

@section('content_header')
    <div class="pull-left">
        <h1 class="page-header">Buscadora de transcripciones </h1>
    </div>

    <div class="pull-right">
        <ul class="list-unstyled">
            <li><i class="fa fa-magic"></i> Puede buscar texto libre en las transcripciones,  en el título o las anotaciones de las entrevistas.</li>
            <li><i class="fa fa-tags"></i> Buscar etiquetas aplicadas a las transcripciones.</li>
        </ul>
    </div>

@endsection
@section('content')



    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom-XX">
                <ul class="nav nav-tabs">
                    <li class="{{ $activa == 1 ? " active " : "  " }}"><a href="#b-texto" data-toggle="tab"><i class="fa fa-magic"></i> Buscar en transcripciones</a></li>
                    <li class="{{ $activa == 2 ? " active " : " " }}"><a href="#b-tesauro" data-toggle="tab"><i class="fa fa-tags"></i> Buscar en etiquetado</a></li>
                    <li class="{{ $activa == 3 ? " active " : " " }}"><a href="#b-tesauro-comparativo" data-toggle="tab"><i class="fa fa-bookmark"></i> Comparar uso del etiquetado</a></li>
                    @can('sistema-abierto')
                        <li class="{{ $activa == 4 ? " active " : " " }}"><a href="#b-marca" data-toggle="tab"><i class="fa fa-flag"></i> Entrevistas marcadas</a></li>
                    @endcan
                </ul>
                <div class="tab-content" >
                    <div class="tab-pane {{ $activa == 1  ? " active " : "  " }}" id="b-texto" style="padding-top: 20px">
                        @include("buscador.buscar_texto")
                    </div>
                    <div class="tab-pane  {{ $activa == 2 ? " active " : " " }}" id="b-tesauro">
                        @include("buscador.buscar_tesauro")
                    </div>
                    <div class="tab-pane  {{ $activa == 3  ? " active " : " " }}" id="b-tesauro-comparativo"  style="padding-top: 20px">
                        @include("buscador.comparar_tesauro")
                    </div>
                    <div class="tab-pane  {{ $activa == 4 ? " active " : " " }}" id="b-marca">
                        @include("buscador.buscar_marca")
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push("js")

    <script>
        $( "#frm_avanzado222" ).click(function() {
            $("#frm_avanzado").toggle();
        });
    </script>
@endpush
