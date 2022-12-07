@extends('layouts.app')

@section('content_header')
    <h1>Prueba de mapa</h1>
@endsection

@section('content')

    <div class="row">
        @include("mapa.botones_capa")
        <div class="col-sm-12">
            <div name='map' id='map' class="map"></div>
        </div>
    </div>

    <div id='popup' class='ol-popup' style='width:150px'>
        <a href='#' id='popup-closer' class='ol-popup-closer'></a>
        <div id='popup-content'></div>
    </div>

@endsection

@include("mapa.js_base")


@push('js')
    @include('mapa.js_deptos')
    @include('mapa.js_munis')
@endpush