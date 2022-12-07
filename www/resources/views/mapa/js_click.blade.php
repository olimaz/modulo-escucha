{{-- Mouseover --}}
<script type='text/javascript'>
    var displayFeatureInfo = function(pixel) {
        var features = [];
        map.forEachFeatureAtPixel(pixel, function(feature, layer) {
            features.push(feature);
        });
        if (features.length > 0) {
            var info = [];
            var i, ii;
            for (i = 0, ii = features.length; i < ii; ++i) {
                var codigo=features[i].get('codigo');
                var fecha=features[i].get('fecha');
                var fuente=features[i].get('fuente');
                var id=features[i].get('id');
                var link="";
                if(fuente=="e_ind_fvt") {
                    link="<a class='alert-link' target='_blank' href='{{ url("entrevistaIndividuals")  }}/"+id+" ' title='mirame'>"+codigo+'</a><br>';
                    //link="<a class='alert-link' target='_blank' href='conflictos/"+codigo+" ' title='mirame'>Conflicto # "+codigo+'</a><br>';
                }

                if(id > 0) {
                    info.push(link);
                }
            }
            //quitar duplicados
            uniqueArray = info.filter(function(item, pos, self) {
                return self.indexOf(item) == pos;
            });
            document.getElementById('info').innerHTML = '<ol><li>' + uniqueArray.join(' <li> ') || '(ninguno)' +"</ol>";
            //map.getTarget().style.cursor = 'pointer';
        } else {
            document.getElementById('info').innerHTML = '&nbsp;';
            //map.getTarget().style.cursor = '';
        }
    };






    // change mouse cursor when over marker
    /*
    map.on('pointermove', function(e) {
        if (e.dragging) {
            $(element).popover('destroy');
            return;
        }
        var pixel = map.getEventPixel(e.originalEvent);
        var hit = map.hasFeatureAtPixel(pixel);
        //map.getTarget().style.cursor = hit ? 'pointer' : '';
    });

     */

    /*
    map.on('click', function(evt) {
        displayFeatureInfo(evt.pixel);
    });
    /*

     */
    map.on('click', function(evt) {
        var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {
            return feature;
        });
        if (feature) {
            var info = [];
            var features = feature.get('features');
            var i;
            if(features) {  //Click en algún cluster
                for (i = 0; i < features.length; ++i) {
                    //console.log(features[i].get('codigo'));
                    //
                    var codigo=features[i].get('codigo');
                    var fecha=features[i].get('fecha');
                    var fuente=features[i].get('fuente');
                    var id=features[i].get('id');
                    var link="";
                    if(fuente=="e_ind_fvt") {
                        link="<a class='alert-link' target='_blank' href='{{ url("entrevistaIndividuals")  }}/"+id+" ' title='mirame'>"+codigo+'</a><br>';
                        //link="<a class='alert-link' target='_blank' href='conflictos/"+codigo+" ' title='mirame'>Conflicto # "+codigo+'</a><br>';
                    }

                    if(id > 0) {
                        info.push(link);
                    }
                }
            }
            else { //Click en algo que no es cluster
                var features = [];
                map.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {
                    features.push(feature);
                });
                if (features.length > 0) {
                    var info = [];
                    var i, ii;
                    for (i = 0, ii = features.length; i < ii; ++i) {
                        var codigo=features[i].get('codigo');
                        var fecha=features[i].get('fecha');
                        var fuente=features[i].get('fuente');
                        var id=features[i].get('id');
                        var link="";
                        if(fuente=="e_ind_fvt") {
                            link="<a class='alert-link' target='_blank' href='{{ url("entrevistaIndividuals")  }}/"+id+" ' title='mirame'>"+codigo+'</a><br>';
                            //link="<a class='alert-link' target='_blank' href='conflictos/"+codigo+" ' title='mirame'>Conflicto # "+codigo+'</a><br>';
                        }

                        if(id > 0) {
                            info.push(link);
                        }
                    }

                } else {
                    document.getElementById('info').innerHTML = '&nbsp;';
                    //map.getTarget().style.cursor = '';
                }


            }

            //quitar duplicados
            uniqueArray = info.filter(function(item, pos, self) {
                return self.indexOf(item) == pos;
            });
            document.getElementById('info').innerHTML = '<ol><li>' + uniqueArray.join(' <li> ') || '(ninguno)' +"</ol>";
        }
        else {
           // displayFeatureInfo(evt.pixel);
        }
    });
</script>
