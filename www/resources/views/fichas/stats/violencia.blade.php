<div class="row">

    {{-- Tipo de violencia --}}
    @if($filtros->violencia_tipo<=0) {{-- Sin filtro de violencia, mostrar totales --}}
        <div class="col-md-12">
             @include("fichas.stats.p_grafico",
                         ['info_titulo' => $datos->violencia->tipo->titulo
                            , 'info_pie' => "Información para un total de ". $datos->conteos->victimas_conocidas ." victimizaciones."
                            , 'info_div' => "g_violencia_tipo"
                             ]
                    )
        </div>
    @else {{-- Con filtro de violencia, mostrar subtipos, mecanisos, terceros, etc. --}}

        {{-- tipo de violencia --}}
        <div class="col-md-6">
            @include("fichas.stats.p_grafico",
                        ['info_titulo' => $datos->violencia->tipo->titulo
                           , 'info_pie' => "Información para un total de ". $datos->conteos->victimas_conocidas ." victimizaciones."
                           , 'info_div' => "g_violencia_tipo"
                            ]
                   )
        </div>
        {{-- subtipo --}}
        @if($datos->violencia->subtipo->nivel > 0)
            <div class="col-md-6">
                @include("fichas.stats.p_grafico",
                        ['info_titulo' => $datos->violencia->subtipo->titulo
                           , 'info_pie' => "Información para un total de ". $datos->conteos->victimas_conocidas ." victimizaciones."
                           , 'info_div' => "g_violencia_subtipo"
                            ]
                   )
            </div>
        @endif
        {{-- Mecanismos --}}
        @if($datos->violencia->mecanismos->nivel > 0)
            <div class="col-md-6">
                @include("fichas.stats.p_grafico",
                        ['info_titulo' => $datos->violencia->mecanismos->titulo
                           , 'info_pie' => "Información para un total de ". $datos->conteos->victimas_conocidas ." victimizaciones."
                           , 'info_div' => "g_violencia_mecanismos"
                            ]
                   )
            </div>
        @endif
        {{-- Individual, familiar, colectivo --}}
        @if($datos->violencia->ifc->nivel > 0)
            <div class="col-md-6">
                @include("fichas.stats.p_grafico",
                        ['info_titulo' => $datos->violencia->ifc->titulo
                           , 'info_pie' => "Información para un total de ". $datos->conteos->victimas_conocidas ." victimizaciones."
                           , 'info_div' => "g_violencia_ifc"
                            ]
                   )
            </div>
        @endif
        {{-- Frente a otros --}}
        @if($datos->violencia->terceros->nivel > 0)
            <div class="col-md-6">
                @include("fichas.stats.p_grafico",
                        ['info_titulo' => $datos->violencia->terceros->titulo
                           , 'info_pie' => "Información para un total de ". $datos->conteos->victimas_conocidas ." victimizaciones."
                           , 'info_div' => "g_violencia_terceros"
                            ]
                   )
            </div>
        @endif
        {{-- Despojo: recupero sus tierras --}} {{-- Desplazamiento: sentido --}}
        @if($datos->violencia->tipo_otros->nivel > 0)
            <div class="col-md-6">
                @include("fichas.stats.p_grafico",
                        ['info_titulo' => $datos->violencia->tipo_otros->titulo
                           , 'info_pie' => "Información para un total de ". $datos->conteos->victimas_conocidas ." victimizaciones."
                           , 'info_div' => "g_violencia_tipo_otros"
                            ]
                   )
            </div>
        @endif


    @endif

    <div class="w-100"></div>
    {{-- Responsable: AA --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                    ['info_titulo' =>"Responsabilidad colectiva: Actores Armados"
                       , 'info_pie' => 'Información para valores conocidos. No se muestran los valores "Sin especificar".'
                       , 'info_div' => "g_violencia_aa"
                        ]
               )
    </div>
    {{-- Responsable: TC --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                    ['info_titulo' =>"Responsabilidad colectiva: Terceros Civiles"
                       , 'info_pie' => 'Información para valores conocidos. No se muestran los valores "Sin especificar".'
                       , 'info_div' => "g_violencia_tc"
                        ]
               )
    </div>


    {{-- Año de los hechos --}}
    <div class="col-sm-12">
         @include("fichas.stats.p_grafico",
                     ['info_titulo' =>"Distribución por año de los hechos"
                        , 'info_pie' => "Información para un total de ". $datos->conteos->victimas_conocidas ." victimizaciones."
                        , 'info_div' => "g_violencia_anyo"
                        ]
                )
    </div>



    {{-- Lugar de los hechos --}}
    <div class="col-sm-12">
         @include("fichas.stats.p_grafico",
                     ['info_titulo' => $datos->violencia->geo->titulo
                        , 'info_pie' => "Información para un total de ". $datos->violencia->total ." violencias registradas."
                        , 'info_div' => "g_violencia_lugar"
                         ]
                )
    </div>
</div>



<div class="w-100"></div>

@push("js")
    {{-- Actualizar  --}}
    <script>
        //Por si necesito depurar lo que viene del ajax
        var json_violencia;

        //Bandera para evitar repetir el calculo innecesariamente
        var ya_violencia=false;
        //Funcion para hacer la lectura AJAX
        function actualizar_violencia() {
            if(ya_violencia) {
                //console.log("Graficas de victima ya calculadas");
            }
            else {
                Swal.fire({
                    title: "",
                    text: "Actualizando gráficas de violencia, gracias por su paciencia.",
                    showConfirmButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });
                //console.log("Actualizando graficas de procesamiento");
                $.getJSON( "<?php echo url('dash/json/violencia')."?".$filtros->url; ?>" )
                    .done(function( json ) {
                        json_violencia = json;
                        actualizar_graficos_violencia(json_violencia);
                        ya_violencia=true; //Para que no lo haga de nuevo
                        swal.close()
                    })
                    .fail(function( jqxhr, textStatus, error ) {
                        var err = textStatus + ", " + error;
                        console.log( "Problema al leer los datos, ajax violencia:" + err );
                    });
            }
        }

        //Funcion para actualizar los gráficos
        function actualizar_graficos_violencia(json) {

            //tipo de violencia
            chart_g_violencia_tipo.setOption(JSON.parse(json.tipo.grafico));
            actualizar_tabla("t_g_violencia_tipo",json.tipo);
            @if($datos->violencia->subtipo->nivel > 0)
                chart_g_violencia_subtipo.setOption(JSON.parse(json.subtipo.grafico));
                actualizar_tabla("t_g_violencia_subtipo",json.subtipo);
            @endif
            @if($datos->violencia->mecanismos->nivel > 0)
                chart_g_violencia_mecanismos.setOption(JSON.parse(json.mecanismos.grafico));
                actualizar_tabla("t_g_violencia_mecanismos",json.mecanismos);
            @endif
            @if($datos->violencia->ifc->nivel > 0)
                chart_g_violencia_ifc.setOption(JSON.parse(json.ifc.grafico));
                actualizar_tabla("t_g_violencia_ifc",json.ifc);
            @endif
            @if($datos->violencia->terceros->nivel > 0)
                chart_g_violencia_terceros.setOption(JSON.parse(json.terceros.grafico));
                actualizar_tabla("t_g_violencia_terceros",json.terceros);
            @endif
            @if($datos->violencia->tipo_otros->nivel > 0)
                chart_g_violencia_tipo_otros.setOption(JSON.parse(json.tipo_otros.grafico));
                actualizar_tabla("t_g_violencia_tipo_otros",json.tipo_otros);
            @endif
            //Año de violencia
            chart_g_violencia_anyo.setOption(JSON.parse(json.anio.grafico));
            actualizar_tabla("t_g_violencia_anyo",json.anio);
            //Lugar de la violencia
            chart_g_violencia_lugar.setOption(JSON.parse(json.geo.grafico));
            actualizar_tabla("t_g_violencia_lugar",json.geo);
            //responsabilidad actor armado
            chart_g_violencia_aa.setOption(JSON.parse(json.respo_aa.grafico));
            actualizar_tabla("t_g_violencia_aa",json.respo_aa);
            //responsabilidad tercero civil
            chart_g_violencia_tc.setOption(JSON.parse(json.respo_tc.grafico));
            actualizar_tabla("t_g_violencia_tc",json.respo_tc);




        }



    </script>


@endpush

