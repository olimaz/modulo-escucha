@extends('layouts.app3')

@section('content_header')
    <h1>Prueba de mapa</h1>
@endsection

@section('content')



    <div class="row">
        <div class="col">
            {{-- DIV del mapa--}}
            <div name='map' id='map' class="map"></div>
        </div>
    </div>

    <div class="row container">
        <div class="col-xs-2">
            <button class="btn btn-xs btn-info"  onclick='setMapToFullScreen()' >Mostrar mapa en pantalla completa</button>

        </div>
        <div class="col-xs-10">
            <div name='info' id='info'></div>

        </div>
    </div>


    {{-- maiz --}}

    <div id='popup' class='ol-popup' style='width:150px'>
        <a href='#' id='popup-closer' class='ol-popup-closer'></a>
        <div id='popup-content'></div>
    </div>


@endsection

@include("mapa.js_base")


@push('js')

    <script>
        $(function () {
            //base_osm.setVisible(true);
        })

        function setMapToFullScreen(){
            //if your map element id is other than 'map' change it here
            var elem = document.getElementById('map');
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
            }
        }


    </script>
    @include('mapa.js_victimizacion')

@endpush

@push('head')
    <style type="text/css">
        .map {
            background-color: dimgray;
            height: 70vh;
            width: 100%;
            border-radius: 5px;
            border: 0.2em solid #209CA6;
        }


    </style>


@endpush