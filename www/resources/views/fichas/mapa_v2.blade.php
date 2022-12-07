@extends('layouts.app3')

@php($con_sidebar = $filtros->hay_filtro)

@section('content_header')
    @include("fichas.stats_filtro")

@endsection

@section('content')

    <div class="row container">
        <div class="col-sm-6">
            <span class="text-sm">
                Desplegando datos para <span class="text-primary">{{ $datos->conteos->hechos }} hechos de violencia</span> ({{ $datos->conteos->entrevistas }} entrevistas).
            </span>

        </div>
        <div class="col-sm-2">

            <button class="btn btn-xs btn-secondary"  onclick='setMapToFullScreen()' ><i class="fas fa-expand-arrows-alt"></i> Pantalla completa</button>
        </div>
        <div class="col-sm-4">
            <div name='info' id='info'></div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <div id="div_botones">
            </div>
        </div>
        <div class="col">
            {{-- DIV del mapa--}}
            <div name='map' id='map' class="map"></div>
            <div class="w-100"></div>
            <p>Importante: No se incluye la violencia especificada únicamente a nivel de departamento sin detalle de municipio o vereda.</p>
        </div>
    </div>





    {{-- maiz --}}

    <div id='popup' class='ol-popup' style='width:150px'>
        <a href='#' id='popup-closer' class='ol-popup-closer'></a>
        <div id='popup-content'></div>
    </div>


@endsection

{{-- Mostrar criterios de filtrado en el sidebar derecho --}}
@include("fichas.partials.sidebar")


@include("mapa.js_base")

@include('mapa.js_victimizacion_v2')

@push('js')

    <script>
        Swal.fire({
            title: "",
            text: "Procesando mapa de eventos de violencia.  Al finalizar el proceso, esta notificación se cierra automáticamente.",
            showConfirmButton: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        });


        //Disparar la lectura del mapa
        $(function () {
            cargar_capa();
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

        //para ocultar/mostrar capas
        function mostrar_capa(id) {
            arreglo_capas[id].setVisible()
        }


    </script>


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