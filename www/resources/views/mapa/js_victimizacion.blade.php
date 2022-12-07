{{-- Version con simbolos proporcionales  --}}
@push('js')

    <script type='text/javascript'>

        function cargar_capa() {
            var max=3;  //Para simbolos proporcionales


            //PARA EL ESTILO
            //Determinar el valor maximo para los simbolos proporcionales
            var url = '{!!   url("json/mapa/hechos_ficha?".$filtros->url) !!}'
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

            if(json_original.max > 0) {
                max = json_original.max;
            }
            //console.log("maximo establecido");
            //console.log(max);

            const radiusCalculation = (val) => {
                //return (val / Math.PI) ** 0.5 * coeff;
                return Math.sqrt(val / max) * 11
            };
            const fillCircle = new ol.style.Fill({
                color: 'rgba(255, 0, 0, 0.6)'
            });
            const strokeCircle = new ol.style.Stroke({
                color: 'rgba(255,0,0,0.9)',
                width: 1
            });
            //Fin de preliminares del estilo





            // Cargar datos
            var url = '{!!   url("json/mapa/hechos_ficha?".$filtros->url) !!}'
            var datos_victimizacion = new ol.source.Vector({
                url: url,
                format: new ol.format.GeoJSON()
            });




            ///////// CAPAS

            //Crear capa, asignarle estilo
            var capa_victimizacion = new ol.layer.Vector({
                source: datos_victimizacion
                , title: 'Eventos de violencia'
                //, style : estilo_victimizacion
                , style: function(feature, resolution) {

                    const extent = feature.getGeometry().getExtent();
                    const center = ol.extent.getCenter(extent);
                    const geom = new ol.geom.Point(center);
                    //console.log('mirame');
                    //console.log(feature.get('rank'));
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
                , visible : true

            });






            // Disparador que actualiza mapa
            datos_victimizacion.on('change', function (evt) {
                var src = evt.target;
                if (src.getState() === 'ready') {
                    var extent = capa_victimizacion.getSource().getExtent();
                    //console.log('capa actualizada');
                    base_osm.setVisible(true);
                    swal.close();
                }
            });

            //Lugar de la entrevista
            //map.addLayer(capa_victimizacion);
            map.getLayers().insertAt(30, capa_victimizacion);
            //map.getLayers().extend([capa_victimizacion]);


            ///On click
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
                            if(fuente=="e_ind_fvt") {
                                //link="<a class='alert-link' target='_blank' href='{{ url("entrevistaIndividuals")  }}/"+id+" ' title='mirame'>"+nombre+":" +cantidad +' violencias</a><br>';
                                link = "Hechos de violencia en "+nombre+": "+cantidad
                            }

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

    </script>



@endpush
