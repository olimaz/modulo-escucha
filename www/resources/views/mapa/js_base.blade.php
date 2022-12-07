@push("css")
    <link rel="stylesheet" href="{{ url('css/ol.css') }}">
    <link rel="stylesheet" href="{{ url('css/pace-theme-center-circle.css') }}">
    <script src="{{ url('js/pace.min.js') }}"  type="text/javascript"></script>

    <style>
        #map {
            height: 90vh;
            background-color: dimgray;
            /* background-image: url(data:image/jpeg;base64,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);
            background-repeat: repeat; */
        }
        @media print {
            #map {
                height: 50%;
            }
        }
    </style>
    <style>
        .ol-popup {
            position: absolute;
            background-color: white;
            -webkit-filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
            filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #cccccc;
            bottom: 12px;
            left: -50px;
            min-width: 280px;
        }
        .ol-popup:after, .ol-popup:before {
            top: 100%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }
        .ol-popup:after {
            border-top-color: white;
            border-width: 10px;
            left: 48px;
            margin-left: -10px;
        }
        .ol-popup:before {
            border-top-color: #cccccc;
            border-width: 11px;
            left: 48px;
            margin-left: -11px;
        }
        .ol-popup-closer {
            text-decoration: none;
            position: absolute;
            top: 2px;
            right: 8px;
        }
        .ol-popup-closer:after {
            content: "✖";
        }
        .alert-link {
            font-size:14px;
        }
        .map:-moz-full-screen {
            height: 100%;
        }
        .map:-webkit-full-screen {
            height: 100%;
        }
        .map:-ms-fullscreen {
            height: 100%;
        }
        .map:fullscreen {
            height: 100%;
        }
        .ol-rotate {
            top: 3em;
        }
        .map {
            height: 100%;
            width: 100%;
            border-radius: 5px;
            border: 0.2em solid #209CA6;
        }
    </style>
@endpush

@push('js')
    <script src="{{ url('js/ol.js') }}"  type="text/javascript"></script>

    <script type="text/javascript">
        var ver_bing=false;
        var ver_osm=false;
        var ver_casas=false;
        var ver_despliegue=false;


        var map;

        var base_osm = new ol.layer.Tile({
            source: new ol.source.OSM({crossOrigin: 'anonymous'}),
            visible : ver_osm
        });
        var base_bing = new ol.layer.Tile({
            title: ' Bing Maps',
            preload: Infinity,
            visible: ver_bing,
            source: new ol.source.BingMaps({
                key: '{{ env("BING_MAP") }}',
                imagerySet: 'AerialWithLabels'
                ,crossOrigin: 'anonymous'
            })
        });



        var base_casas = new ol.layer.Image({
            visible: ver_casas,
            source: new ol.source.ImageArcGISRest({
                ratio: 1,
                crossOrigin: 'anonymous',
                params: {},
                url: 'https://mapas.comisiondelaverdad.co/server/rest/services/Casas_de_la_Verdad/MapServer'
            })
        });

        var base_despliegue = new ol.layer.Image({
            visible: ver_despliegue,

            source: new ol.source.ImageArcGISRest({
                ratio: 1,
                crossOrigin: "anonymous",
                params: {LAYERS:0},
                url: 'https://mapas.comisiondelaverdad.co/server/rest/services/Despliegue_Territorial/MapServer'
            })
        });




        var map = new ol.Map({
            controls: ol.control.defaults().extend([
                new ol.control.FullScreen()
            ]),
            target: 'map',
            layers: [
                    base_bing, base_osm, base_despliegue
            ],
            renderer:'canvas',
            view: new ol.View({
                // projection: 'EPSG:900913'
                //defaultProjection: 'EPSG:4326'
                //center: ol.proj.fromLonLat([-74.063644, 4.624335]),
                 center: [-8081534.126535121, 472075.08668924856 ]
                , zoom: 5.5
                , reset: true
            })
        });

        map.getLayers().insertAt(22, base_casas);

        //map.addLayer(base_casas);

        zoomslider = new ol.control.ZoomSlider();
        map.addControl(zoomslider);
        var myFullScreenControl = new ol.control.FullScreen();
        map.addControl(myFullScreenControl);

        window.onresize = function()
        {
            setTimeout( function() { map.updateSize();}, 200);
        };


        var container = document.getElementById('popup');
        var content = document.getElementById('popup-content');
        var closer = document.getElementById('popup-closer');


        /**
         * Create an overlay to anchor the popup to the map.
         */
        var overlay = new ol.Overlay(/** @type {olx.OverlayOptions} */ ({
            element: container,
            autoPan: true,
            autoPanAnimation: {
                duration: 250
            }
        }));
        /**
         * Add a click handler to hide the popup.
         * @return {boolean} Don't follow the href.
         */
        closer.onclick = function() {
            overlay.setPosition(undefined);
            closer.blur();
            return false;
        };
    </script>

@endpush
