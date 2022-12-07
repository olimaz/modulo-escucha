{{-- Version con simbolos proporcionales  --}}
@push('js')

    <script type='text/javascript'>

        var datos;
        var arreglo_capas = [];
        var max=3; //Default para los simbolos proporcionales


        function cargar_capa() {
            console.time("Leer datos");
            //Lectura del json
            var url = '{!!   url("json/mapa/hechos_ficha_v2?".$filtros->url) !!}'
            var json_original = (function () {
                var json = null;
                $.ajax({
                    'async': false,
                    'global': false,
                    'url': url,
                    'dataType': "json",
                    'success': function (data) {
                        json = data;
                    }
                });
                return json;
            })();
            console.timeEnd("Leer datos");
            //Para debug
            datos = json_original;
            //console.log(datos);

            //Establecer el mayor valor, para la formula de los simbolos proporcionales
            if (json_original[0].max > 0) {
                max = json_original[0].max;
            }

            //Crear las capas
            console.time("Carga capas");
            for (const [key, value] of Object.entries(datos)) {
                //console.log(key, value);
                //console.log(value);
                crear_capa(value, key);
            }
            console.timeEnd("Carga capas");

            //crear_capa(datos[0],0);


            //Actualizar mapa
            var extent = arreglo_capas[0].getSource().getExtent();
            //console.log('capa actualizada');
            base_osm.setVisible(true);
            swal.close();



            //On clickk
            map.on('click', function(evt) {
                var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {
                    return feature;
                });
                if (feature) {
                    var info = [];
                    var features = feature.get('features');
                    var i;
                    var features = [];
                    map.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {
                        features.push(feature);
                    });
                    if (features.length > 0) {
                        var info = [];
                        var i, ii;
                        for (i = 0, ii = features.length; i < ii; ++i) {
                            var codigo=features[i].get('codigo');
                            var nombre=features[i].get('titulo');
                            var cantidad=features[i].get('conteo');
                            var id=features[i].get('id');
                            var fuente=features[i].get('fuente');
                            var link="";
                            link = "Hechos de "+fuente+" en "+nombre+": "+cantidad


                            if(id > 0) {
                                info.push(link);
                            }
                        }

                    } else {
                        document.getElementById('info').innerHTML = '&nbsp;';
                        //map.getTarget().style.cursor = '';
                    }

                    //quitar duplicados
                    uniqueArray = info.filter(function(item, pos, self) {
                        return self.indexOf(item) == pos;
                    });
                    document.getElementById('info').innerHTML = '<ul><li>' + uniqueArray.join(' <li> ') || '(ninguno)' +"</ul>";
                }
                else {
                    document.getElementById('info').innerHTML = '&nbsp;';
                }
            });

        }




        function crear_capa(info, id) {
            var hexColor = info.color;
            var color = ol.color.asArray(hexColor);
            var color2 = ol.color.asArray(hexColor);
            color = color.slice();
            color2 = color2.slice();

            color[3] = 0.3;
            color2[3] = 0.9;

            //console.log("color:",color);
            //console.log("color2:",color2);



            //Estilos
            const radiusCalculation = (val) => {
                //return (val / Math.PI) ** 0.5 * coeff;
                return Math.sqrt(val / max) * 11
            };
            const fillCircle = new ol.style.Fill({
                //color: 'rgba(255, 0, 0, 0.6)'
                color : color
            });
            const strokeCircle = new ol.style.Stroke({
                //color: 'rgba(255,0,0,0.9)',
                color : color2,
                width: 1
            });

            //Crear la capa

            var vectorSource = new ol.source.Vector({
                features: new ol.format.GeoJSON().readFeatures(info,{
                    featureProjection: 'EPSG:3857'
                })
            });

            const vectorLayer = new ol.layer.Vector({
                source: vectorSource
                //,  projection : 'EPSG:3857'
                , style: function(feature, resolution) {
                    const extent = feature.getGeometry().getExtent();
                    const center = ol.extent.getCenter(extent);
                    const geom = new ol.geom.Point(center);
                    return new ol.style.Style({
                        geometry: geom,
                        image: new ol.style.Circle({
                            stroke: strokeCircle,
                            fill: fillCircle,
                            //radius: radiusCalculation(feature.get('conteo'), 0.02)
                            radius: radiusCalculation(feature.get('conteo'))

                        }),
                        zIndex: feature.get('rank')
                    });
                }
                , renderMode: 'image'
                , visible : id==0
            });

            arreglo_capas.push(vectorLayer);

            map.getLayers().insertAt(30, vectorLayer);

            //Control de apagado/encendido
            if(id==0) {
                $('#div_botones').append('<input type="checkbox" id="capa_'+id+'" checked /> <span style="color:'+info.color+';" ><i class="fas fa-flag"></i> </span>' + info.tipo + ' ('+info.conteo+' municipios)' + '<br />');
            }
            else {
                $('#div_botones').append('<input type="checkbox" id="capa_'+id+'" /> <span style="color:'+info.color+';" ><i class="fas fa-flag"></i> </span>' + info.tipo + ' ('+info.conteo+' municipios)' + '<br />');
            }

            //Bind al checked
            $('#capa_'+id).on('change', function() {
                vectorLayer.setVisible(this.checked);
            });


        }


    </script>



@endpush
