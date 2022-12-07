<script type='text/javascript'>
    // departamentos
    var ver_deptos=true;

    var styleCache = {};
    var deptos = new ol.layer.Vector({
        title : 'Division administrativa',

        source: new ol.source.Vector({
            url: '{{ url("json/deptos") }}'
            , format: new ol.format.GeoJSON()
        }),
        //type: 'base',
        visible: ver_deptos,
        style: function(feature, resolution) {
            var text = resolution < {{ config("expedientes.etiquetas_depto") }} ? feature.get('NOMBRE_DPT') : '';
            //var text = resolution < 350 ? feature.get('DEPARTAMEN') : '';
            var cual="d_"+text;
            if (!styleCache[cual]) {
                styleCache[cual] = [new ol.style.Style({
                    fill: new ol.style.Fill({
                        color: 'rgba(255, 255, 255, 0.2)'
                    }),
                    stroke: new ol.style.Stroke({
                        color: '#ffffff',
                        width: 2
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

    //map.addLayer(deptos);
    map.getLayers().insertAt(5, deptos);

    //Layer switcher
    //overlayGroup.getLayers().push(guate);
    //guate.setVisible(true);

    // Por si use la funcion para crear el boton de encendido apagado
    //$('.btn_depto').show();
</script>