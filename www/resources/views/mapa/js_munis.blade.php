<script type='text/javascript'>
    // municipios
    var ver_munis=false;
    var styleCache = {};
    var mupios = new ol.layer.Vector({
        title : 'Municipios',

        source: new ol.source.Vector({
            url: '{{ url("json/mupios") }}'
            , format: new ol.format.GeoJSON()
        }),
        //type: 'base',
        visible: ver_munis,
        style: function(feature, resolution) {
            var text = resolution < {{ config("expedientes.etiquetas_muni") }} ? feature.get('NOMBRE_MPI') : '';
            var cual="m_"+text;
            if (!styleCache[cual]) {
                styleCache[cual] = [new ol.style.Style({
                    fill: new ol.style.Fill({
                        color: 'rgba(0, 0, 0, 0)'
                    }),
                    stroke: new ol.style.Stroke({
                        color: 'rgba(255, 255, 255, 1)',
                        width: 0.5
                    }),
                    text: new ol.style.Text({
                        font: '12px Calibri,sans-serif',
                        text: text,
                        fill: new ol.style.Fill({
                            color: '#04a8f4'
                        }),
                        stroke: new ol.style.Stroke({
                            color: '#fff',
                            width: 3
                        })
                    })
                })];
            }
            return styleCache[cual];
        }
    });

    //map.addLayer(mupios);
    map.getLayers().insertAt(4, mupios);
    //Layer switcher
    //overlayGroup.getLayers().push(guate_m);
    //guate.setVisible(true);

    // Por si use la funcion para crear el boton de encendido apagado
    //$('.btn_depto').show();
</script>