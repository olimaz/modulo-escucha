{{-- Version optimizada de puntos + calor --}}
@push('js')

    <script type='text/javascript'>

        var individual_estilo_entrevista = new ol.style.Style({
            image: new ol.style.Circle({
                radius: 7,
                fill: new ol.style.Fill({color: 'black'}),
                stroke: new ol.style.Stroke({
                    color: [0,0,255], width: 2
                })
            })
        });
        var individual_estilo_hechos = new ol.style.Style({
            image: new ol.style.Circle({
                radius: 7,
                fill: new ol.style.Fill({color: 'black'}),
                stroke: new ol.style.Stroke({
                    color: [255,0,0], width: 2
                })
            })
        });

        var estilo_fa_entrevista = new ol.style.Style({
            text: new ol.style.Text({
                text: '\uf005',
                font: 'normal 18px FontAwesome',
                textBaseline: 'bottom',
                fill: new ol.style.Fill({
                    color: 'blue',
                })
            })
        });
        var estilo_fa_hechos = new ol.style.Style({
            text: new ol.style.Text({
                text: '\uf041',
                font: 'normal 18px FontAwesome',
                textBaseline: 'bottom',
                fill: new ol.style.Fill({
                    color: 'red',
                })
            })
        });



        // Cargar datos
        var individual_datos_entrevista = new ol.source.Vector({
            url: '{!!   url("json/e_ind_fvt/entrevista?".$filtros->url) !!}',
            format: new ol.format.GeoJSON()
        });

        //Para el cluster
        var individual_datos_entrevista_cluster = new ol.source.Cluster({
            distance: 30,
            source: individual_datos_entrevista
        });


        var individual_datos_hechos = new ol.source.Vector({
            url: '{!!   url("json/e_ind_fvt/hechos?".$filtros->url) !!}',
            format: new ol.format.GeoJSON()
        });
        //Para el cluster
        var individual_datos_hechos_cluster = new ol.source.Cluster({
            distance: 30,
            source: individual_datos_hechos
        });

        ///////// CAPAS

        //Crear capa, asignarle estilo
        var individual_capa_entrevista = new ol.layer.Vector({
            source: individual_datos_entrevista
            , title: 'Entrevista individual, lugar de la entrevista'
            //, style : individual_estilo_entrevista
            , style : estilo_fa_entrevista
            , visible : false

        });
        // Crear  capa tipo HeatMap
        var individual_capa_entrevista_calor = new ol.layer.Heatmap({
            source: individual_datos_entrevista
            , title: 'Entrevista individual, lugar de la entrevista - mapa de calor'
            , visible : false
           // , format: new ol.format.GeoJSON()
        });
        //capa de cluster lugar_entrevista
        var styleCache_e = {};
        var individual_capa_entrevista_cluster = new ol.layer.Vector({
            source: individual_datos_entrevista_cluster,
            title: 'Lugar de la entrevista',
            visible : true,
            style: function(feature, resolution) {
                var size = feature.get('features').length;
                if(size==1) {
                    //size=feature.getProperties().features[0].get('identificador');
                }
                var style = styleCache_e[size];
                if (!style) {
                    style = [new ol.style.Style({
                        image: new ol.style.Circle({
                            radius: 10,
                            stroke: new ol.style.Stroke({
                                color: '#fff'
                            }),
                            fill: new ol.style.Fill({
                                color: '#0000ff'
                            })
                        }),
                        text: new ol.style.Text({
                            text: size.toString(),
                            fill: new ol.style.Fill({
                                color: '#fff'
                            })
                        })
                    })];
                    styleCache_e[size] = style;
                }
                return style;
            }

        });

        //Crear capa, asignarle estilo
        var styleCache_h = {};
        var individual_capa_hechos = new ol.layer.Vector({
            source: individual_datos_hechos
            , title: 'Entrevista individual, lugar de los hechos'
            //, style : individual_estilo_hechos
            , style : estilo_fa_hechos
            , visible : false

        });
        // Crear  capa tipo HeatMap
        var individual_capa_hechos_calor = new ol.layer.Heatmap({
            source: individual_datos_hechos
            , title: 'Entrevista individual, lugar de los hechos - mapa de calor'
            , visible : false
            // , format: new ol.format.GeoJSON()
        });
        //capa de cluster lugar_entrevista
        var individual_capa_hechos_cluster = new ol.layer.Vector({
            source: individual_datos_hechos_cluster,
            title: 'Lugar de los hechos',
             visible : false,
            style: function(feature, resolution) {
                var size = feature.get('features').length;
                if(size==1) {
                    //size=feature.getProperties().features[0].get('identificador');
                }
                var style = styleCache_h[size];
                if (!style) {
                    style = [new ol.style.Style({
                        image: new ol.style.Circle({
                            radius: 10,
                            stroke: new ol.style.Stroke({
                                color: '#fff'
                            }),
                            fill: new ol.style.Fill({
                                color: '#ff0000'
                            })
                        }),
                        text: new ol.style.Text({
                            text: size.toString(),
                            fill: new ol.style.Fill({
                                color: '#fff'
                            })
                        })
                    })];
                    styleCache_h[size] = style;
                }
                return style;
            }

        });



        // Disparador que actualiza mapa
        individual_datos_entrevista.on('change', function (evt) {
            var src = evt.target;
            if (src.getState() === 'ready') {
                var extent = individual_capa_entrevista.getSource().getExtent();
                //map.getView().fit(extent, map.getSize());
            }
            //var conteo=problemas_datos.getFeatures().length;
            //problemas_capa.set('title','Problemas ('+conteo+')');
        });

        //Lugar de la entrevista
        map.getLayers().insertAt(10, individual_capa_entrevista);
        map.getLayers().insertAt(11, individual_capa_entrevista_calor);
        map.getLayers().insertAt(14, individual_capa_entrevista_cluster);

        //Lugar de los hechos
        map.getLayers().insertAt(20, individual_capa_hechos);
        map.getLayers().insertAt(21, individual_capa_hechos_calor);
        map.getLayers().insertAt(24, individual_capa_hechos_cluster);





    </script>
@endpush
