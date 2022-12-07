
<div class="box box-default">
    <div class="box-header">
        Personalización del mapa
    </div>
    <div class="box-body">
        <div class="btn-group  btn-block">
            <button type="button" class="btn btn-success col-lg-10">Mapa de fondo</button>
            <button type="button" class="btn btn-success dropdown-toggle col-lg-2" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="#" onclick="fondo_bing()" id="f_satelite">Satelital</a></li>
                <li><a href="#" onclick="fondo_osm()" id="f_vectorial">Vectorial</a></li>
                <li class="divider"></li>
                <li><a href="#" onclick="fondo_vacio()"  id="f_vacio">Ninguno</a></li>
            </ul>
        </div>
        <br>
        <br>

        <button type="button" class="btn btn-success btn-block" onclick="ocultar_deptos()">Departamentos</button>
        <br>
        <button type="button" class="btn btn-success btn-block" onclick="ocultar_mupios()">Municipios</button>
        <br>
        <button type="button" class="btn btn-success btn-block" onclick="ocultar_despliegue()">Macroterritorios</button>
        <br>
        <button type="button" class="btn btn-success btn-block" onclick="ocultar_casas()">Casas de la verdad</button>
        <br>
        <br>
        <a id="export-png" class="btn btn-default btn-block"><i class="fa fa-download"></i> Descargar imagen</a>
    </div>
    <div class="box-footer">
        <a class="btn btn-warning btn-sm " href="#" onclick="map.updateSize();return false">¿mapa distorsionado?</a>
    </div>
</div>




@push('js')
    <script>
        function fondo_bing() {
            base_osm.setVisible(false);
            base_bing.setVisible(true);
        }
        function fondo_osm() {
            base_bing.setVisible(false);
            base_osm.setVisible(true);
        }
        function fondo_vacio() {
            base_bing.setVisible(false);
            base_osm.setVisible(false);
        }
        function ocultar_deptos() {
            deptos.setVisible(!deptos.getVisible());
        }
        function ocultar_mupios() {
            mupios.setVisible(!mupios.getVisible());
        }
        function ocultar_casas() {
            base_casas.setVisible(!base_casas.getVisible());
            base_casas.setZIndex(34);
        }
        function ocultar_base() {
            base_bing.setVisible(!base_bing.getVisible());
        }
        function ocultar_osm() {
            base_osm.setVisible(!base_osm.getVisible());
        }
        function ocultar_despliegue() {
            base_despliegue.setVisible(!base_despliegue.getVisible());
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>
    <script type='text/javascript'>
        document.getElementById('export-png').addEventListener('click', function() {
            map.once('rendercomplete', function(event) {
                var canvas = event.context.canvas;
                if (navigator.msSaveBlob) {
                    navigator.msSaveBlob(canvas.msToBlob(), 'map.png');
                } else {
                    canvas.toBlob(function(blob) {
                        saveAs(blob, 'map.png');
                    });
                }
            });
            map.renderSync();
        });








    </script>

@endpush