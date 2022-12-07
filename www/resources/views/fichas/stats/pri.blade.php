<div class="row">
    {{-- Sexo --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Sexo'
                        , 'info_pie' => "Información para un total de ". $datos->pri->total ." personas con fichas diligenciadas digitalmente."
                        , 'info_div' => "g_pri_sexo"
                         ]
                )
    </div>




    {{-- Edad --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Edad al momento de los hechos'
                        , 'info_pie' => "Información para un total de ". $datos->pri->total ." personas con fichas diligenciadas digitalmente."
                        , 'info_div' => "g_pri_edad"
                         ]
                )
    </div>




    {{-- Pertenencia etnica --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => ' Pertenencia étnico-racial'
                        , 'info_pie' => "Información para un total de ". $datos->pri->total ."  fichas diligenciadas digitalmente."
                        , 'info_div' => "g_pri_etnia"
                         ]
        )
    </div>




    {{-- Actor del que hacía parte --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Actor armado del que hacía parte'
                        , 'info_pie' => 'Información para valores conocidos. No se muestran los valores "Sin especificar".'
                        , 'info_div' => "g_pri_actor"
                        ]
        )
    </div>

    <div class="w-100"></div>

    {{-- Responsabilidades --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => '¿Cúal es la presunta responsabilidad en el hecho?'
                        , 'info_pie' => 'Información para valores conocidos. No se muestran los valores "Sin especificar".'
                        , 'info_div' => "g_pri_responsabilidad"
                         ]
                )
    </div>

    {{-- Rango paramilitar --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Paramilitares: rango'
                        , 'info_pie' => 'Información para valores conocidos. No se muestran los valores "Sin especificar".'
                        , 'info_div' => "g_pri_rango_para"
                         ]
                )
    </div>

    <div class="w-100"></div>

    {{-- Rango guerrilla --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Guerrilla: rango'
                        , 'info_pie' => 'Información para valores conocidos. No se muestran los valores "Sin especificar".'
                        , 'info_div' => "g_pri_rango_gue"
                         ]
                )
    </div>

    {{-- Rango fuerza publica --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Fuerza pública: rango'
                        , 'info_pie' => 'Información para valores conocidos. No se muestran los valores "Sin especificar".'
                        , 'info_div' => "g_pri_rango_fp"
                         ]
                )
    </div>

    <div class="w-100"></div>

    {{-- Sabe que hace ahora? --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => '¿Sabe qué hace y dónde está el responsable ahora?'
                        , 'info_pie' => "Información para un total de ". $datos->pri->total ." fichas diligenciadas digitalmente."
                        , 'info_div' => "g_pri_ahora"
                         ]
                )
    </div>

    {{-- ¿Sabe si participó en otros hechos de violencia? --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => '¿Sabe si participó en otros hechos de violencia?'
                        , 'info_pie' => "Información para un total de ". $datos->pri->total ." fichas diligenciadas digitalmente."
                        , 'info_div' => "g_pri_otros"
                         ]
                )
    </div>
</div>




<div class="w-100"></div>

@push("js")
    {{-- Actualizar  --}}
    <script>
        //Por si necesito depurar lo que viene del ajax
        var json_pri;

        //Bandera para evitar repetir el calculo innecesariamente
        var ya_pri=false;
        //Funcion para hacer la lectura AJAX
        function actualizar_pri() {
            if(ya_pri) {
                //console.log("Graficas de victima ya calculadas");
            }
            else {
                Swal.fire({
                    title: "",
                    text: "Actualizando gráficas de presunto responsable individual, gracias por su paciencia.",
                    showConfirmButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });
                //console.log("Actualizando graficas de procesamiento");
                $.getJSON( "<?php echo url('dash/json/pri')."?".$filtros->url; ?>" )
                    .done(function( json ) {
                        json_pri = json;
                        actualizar_graficos_pri(json_pri);
                        ya_pri=true; //Para que no lo haga de nuevo
                        swal.close()
                    })
                    .fail(function( jqxhr, textStatus, error ) {
                        var err = textStatus + ", " + error;
                        console.log( "Problema al leer los datos, ajax pri:" + err );
                    });
            }
        }

        //Funcion para actualizar los gráficos
        function actualizar_graficos_pri(json) {
            //Sexo
            chart_g_pri_sexo.setOption(JSON.parse(json.sexo.grafico));
            actualizar_tabla("t_g_pri_sexo",json.sexo);
            //Edad
            chart_g_pri_edad.setOption(JSON.parse(json.edad.grafico));
            actualizar_tabla("t_g_pri_edad",json.edad);
            //Pertenencia etnica
            chart_g_pri_etnia.setOption(JSON.parse(json.etnia.grafico));
            actualizar_tabla("t_g_pri_etnia",json.etnia);
            //Actor del que hacía parte
            chart_g_pri_actor.setOption(JSON.parse(json.actor.grafico));
            actualizar_tabla("t_g_pri_actor",json.actor);
            //Responsabilidad
            chart_g_pri_responsabilidad.setOption(JSON.parse(json.responsabilidad.grafico));
            actualizar_tabla("t_g_pri_responsabilidad",json.responsabilidad);
            //Rango paramilitar
            chart_g_pri_rango_para.setOption(JSON.parse(json.rango_para.grafico));
            actualizar_tabla("t_g_pri_rango_para",json.rango_para);
            //RAngo guerrilla
            chart_g_pri_rango_gue.setOption(JSON.parse(json.rango_gue.grafico));
            actualizar_tabla("t_g_pri_rango_gue",json.rango_gue);
            //Rango fuerza publica
            chart_g_pri_rango_fp.setOption(JSON.parse(json.rango_fp.grafico));
            actualizar_tabla("t_g_pri_rango_fp",json.rango_fp);
            //que hace ahora
            chart_g_pri_ahora.setOption(JSON.parse(json.ahora.grafico));
            actualizar_tabla("t_g_pri_ahora",json.ahora);
            //otros hechos
            chart_g_pri_otros.setOption(JSON.parse(json.otros.grafico));
            actualizar_tabla("t_g_pri_otros",json.otros);
        }
    </script>


@endpush