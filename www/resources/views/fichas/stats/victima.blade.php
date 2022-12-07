<div class="row">

    {{-- Lugar de nacimiento --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Departamento de nacimiento'
                        , 'info_pie' => "Información para un total de ". $datos->victima->total ." victimizaciones."
                        , 'info_div' => "g_victima_l_nacimiento"
                         ]
                )
    </div>

    {{-- Lugar de residencia --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Departamento de residencia'
                        , 'info_pie' => "Información para un total de ". $datos->victima->total ." victimizaciones."
                        , 'info_div' => "g_victima_l_residencia"
                         ]
                )
    </div>



    <div class="w-100"></div>

    {{-- Sexo --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Sexo'
                        , 'info_pie' => "Información para un total de ". $datos->victima->total ." victimizaciones."
                        , 'info_div' => "g_victima_sexo"
                        ]
                )
    </div>



    {{-- Sexo - Identidad de género --}}
    <div class="col-sm-6">
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">
                    Sexo, identidad de género y orientación sexual
                </h3>
            </div>
            <div class="box-body table-responsive">
                <h4 class="text-primary">Sexo e identidad de género</h4>
                <table class="table table-condensed table-bordered table-striped">
                    <thead>
                    <tr>
                        <td>
                            <p class="text-right text-muted">
                                Cómo se identifica  <i class="fa fa-hand-o-right"></i>
                            </p>
                            <p class="text-muted"> <i class="fa fa-hand-o-down"></i> Sexo</p>
                        </td>
                        @foreach($datos->victima->sexo_identidad->categorias['id_identidad'] as $id_identidad => $txt_identidad)
                            <th style="vertical-align: top"> {{ $txt_identidad }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datos->victima->sexo_identidad->categorias['id_sexo'] as $id_sexo => $txt_sexo)
                        <tr>
                            <td> {{ $txt_sexo }}</td>
                            @foreach($datos->victima->sexo_identidad->categorias['id_identidad'] as $id_identidad => $txt_identidad)
                                <td class="text-center"> {{ isset($datos->victima->sexo_identidad->datos[$id_sexo][$id_identidad]) ? $datos->victima->sexo_identidad->datos[$id_sexo][$id_identidad] : 0 }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <h4 class="text-primary">Sexo y orientación sexual</h4>
                <table class="table table-condensed table-bordered table-striped">
                    <thead>
                    <tr>
                        <td>
                            <p class="text-right text-muted">
                                Se siente atraído/a por  <i class="fa fa-hand-o-right"></i>
                            </p>
                            <p class="text-muted"> <i class="fa fa-hand-o-down"></i> Sexo</p>
                        </td>
                        @foreach($datos->victima->sexo_orientacion->categorias['id_orientacion'] as $id_identidad => $txt_identidad)
                            <th style="vertical-align: top"> {{ $txt_identidad }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datos->victima->sexo_orientacion->categorias['id_sexo'] as $id_sexo => $txt_sexo)
                        <tr>
                            <td> {{ $txt_sexo }}</td>
                            @foreach($datos->victima->sexo_orientacion->categorias['id_orientacion'] as $id_identidad => $txt_identidad)
                                <td class="text-center"> {{ isset($datos->victima->sexo_orientacion->datos[$id_sexo][$id_identidad]) ? $datos->victima->sexo_orientacion->datos[$id_sexo][$id_identidad] : 0 }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <div class="box-footer">
                <span class="text-muted">Información para un total de {{ $datos->victima->total }} victimizaciones.</span>
            </div>

        </div>
    </div>

    <div class="w-100"></div>

    {{-- Orientacion sexual --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Orientación sexual (se siente atraído por)'
                        , 'info_pie' => "Información para un total de ". $datos->victima->total ." victimizaciones."
                        , 'info_div' => "g_victima_orientacion"
                         ]
                )
    </div>




    {{-- Identidad de género --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Identidad de género (cómo se identifica)'
                        , 'info_pie' => "Información para un total de ". $datos->victima->total ." victimizaciones."
                        , 'info_div' => "g_victima_identidad_g"
                         ]
                )
    </div>




    <div class="w-100"></div>
    {{-- Edad  --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Edad al momento de los hechos'
                        , 'info_pie' => "Información para víctimas y cada hecho de violencia."
                        , 'info_div' => "g_victima_edad"
                         ]
                )
    </div>

    {{-- Sexo - edad --}}
    <div class="col-sm-6">
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">
                    Sexo y edad
                </h3>
            </div>
            <div class="box-body table-responsive">
                <h4 class="text-primary">Sexo y edad</h4>
                <table class="table table-condensed table-bordered table-striped">
                    <thead>
                    <tr>
                        <td>
                            <p class="text-right text-muted">
                                Sexo <i class="fa fa-hand-o-right"></i>
                            </p>
                            <p class="text-muted"> <i class="fa fa-hand-o-down"></i> Edad</p>
                        </td>
                        @foreach($datos->victima->sexo_edad->categorias['id_sexo'] as $id_sexo => $txt_sexo)
                            <th style="vertical-align: top"> {{ $txt_sexo }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datos->victima->sexo_edad->categorias['id_edad'] as $id_edad => $txt_edad)
                        <tr>
                            <td> {{ $txt_edad }}</td>
                            @foreach($datos->victima->sexo_edad->categorias['id_sexo'] as  $id_sexo => $txt_sexo)
                                <td class="text-center"> {{ isset($datos->victima->sexo_edad->datos[$id_sexo][$id_edad]) ? $datos->victima->sexo_edad->datos[$id_sexo][$id_edad] : 0 }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-footer">

                <span class="text-muted">Información para víctimas y cada hecho de violencia.</span>
            </div>

        </div>
    </div>



    <div class="w-100"></div>

    {{-- Pertenencia etnica --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => ' Pertenencia étnico-racial'
                        , 'info_pie' => "Información para un total de ". $datos->victima->total ." victimizaciones."
                        , 'info_div' => "g_victima_etnico"
                         ]
        )
    </div>




    {{-- Grupo indígena--}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => ' Pertenencia a grupos indígenas'
                        , 'info_pie' => 'Información para valores conocidos. No se muestran los valores "Sin especificar".'
                        , 'info_div' => "g_victima_indigena"
                         ]
        )
    </div>

    <div class="w-100"></div>
    {{-- Estado civil --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Estado Civil'
                        , 'info_pie' => "Información para un total de ". $datos->victima->total ." victimizaciones."
                        , 'info_div' => "g_victima_estado_civil"
                        ]
                )
    </div>

    {{-- Discapacidad --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Condición de discapacidad'
                        , 'info_pie' => "Información para valores conocidos. No se muestran los valores 'Sin especificar'. "
                        , 'info_div' => "g_victima_discapacidad"
                         ]
                )
    </div>

    <div class="w-100"></div>

    {{-- Educacion --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Educación formal'
                        , 'info_pie' => "Información para un total de ". $datos->victima->total ." victimizaciones."
                        , 'info_div' => "g_victima_educacion"
                         ]
                )
    </div>

    {{-- Nacionalidad --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Nacionalidad'
                        , 'info_pie' => "Información para un total de ". $datos->victima->total ." victimizaciones."
                        , 'info_div' => "g_victima_nacionalidad"
                        ]
                )
    </div>

    {{-- Cargo público --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Ejerce autoridad o cargo público'
                        , 'info_pie' => "Información para un total de ". $datos->victima->total ." victimizaciones."
                        , 'info_div' => "g_victima_cargo"
                        ]
                )
    </div>

    {{-- Autoridad etnica --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Es/fué autoridad étnico territorial'
                        , 'info_pie' => "Información para un total de ". $datos->victima->total ." victimizaciones. No se muestran los valores 'Sin especificar'. "
                        , 'info_div' => "g_victima_autoridad_t"
                         ]
                )
    </div>

    {{-- Fuerza pública --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Es o fué miembro de la fuerza pública'
                        , 'info_pie' => "Información para un total de ". $datos->victima->total ." victimizaciones. No se muestran los valores 'Sin especificar'. "
                        , 'info_div' => "g_victima_f_publica"
                         ]
                )
    </div>

    {{-- Actor armado ilegal --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Fué miembro de un actor armado ilegal'
                        , 'info_pie' => "Información para un total de ". $datos->victima->total ." victimizaciones. No se muestran los valores 'Sin especificar'. "
                        , 'info_div' => "g_victima_aai"
                        ]
                )
    </div>


    {{-- Participa en organizacion  --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Participa o participaba en alguna organización, colectivo, grupo, pueblo'
                        , 'info_pie' => "Información para personas (no victimizaciones) a quienes aplica la pregunta."
                        , 'info_div' => "g_victima_organizacion_participa"
                         ]
                )
    </div>

    {{-- Tipo de organizacion  --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Tipo de organización en la que participa o participaba'
                        , 'info_pie' => "Información para personas (no victimizaciones) a quienes aplica la pregunta."
                        , 'info_div' => "g_victima_organizacion_tipo"
                        ]
                )
    </div>

    {{-- Nombre de la organizacion--}}
    <div class="col-sm-6">
        @include("fichas.stats.p_tabla",
                   ['info_titulo' => $datos->victima->organizacion->descripcion
                      , 'info_tabla' =>  $datos->victima->organizacion
                      , 'tabla_nombre' => 'victima_organizacion'
                      , 'tabla_pie' => "Información para personas (no victimizaciones) a quienes aplica la pregunta."
                       ]
              )
    </div>

</div>


<div class="w-100"></div>

@push("js")
    {{-- Actualizar  --}}
    <script>
        //Por si necesito depurar lo que viene del ajax
        var json_victima;

        //Bandera para evitar repetir el calculo innecesariamente
        var ya_victima=false;
        //Funcion para hacer la lectura AJAX
        function actualizar_victima() {
            if(ya_victima) {
                //console.log("Graficas de victima ya calculadas");
            }
            else {
                Swal.fire({
                    title: "",
                    text: "Actualizando gráficas de víctimas, gracias por su paciencia.",
                    showConfirmButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });
                //console.log("Actualizando graficas de procesamiento");
                $.getJSON( "<?php echo url('dash/json/victima')."?".$filtros->url; ?>" )
                    .done(function( json ) {
                        json_victima = json;
                        actualizar_graficos_victima(json_victima);
                        ya_victima=true; //Para que no lo haga de nuevo
                        swal.close()
                    })
                    .fail(function( jqxhr, textStatus, error ) {
                        var err = textStatus + ", " + error;
                        console.log( "Problema al leer los datos, ajax violencia:" + err );
                    });
            }
        }

        //Funcion para actualizar los gráficos
        function actualizar_graficos_victima(json) {

            //Lugar de nacimiento
            chart_g_victima_l_nacimiento.setOption(JSON.parse(json.lugar_n.grafico));
            actualizar_tabla("t_g_victima_l_nacimiento",json.lugar_n);
            //Lugar de residencia
            chart_g_victima_l_residencia.setOption(JSON.parse(json.lugar_r.grafico));
            actualizar_tabla("t_g_victima_l_residencia",json.lugar_r);
            //SExo
            chart_g_victima_sexo.setOption(JSON.parse(json.sexo.grafico));
            actualizar_tabla("t_g_victima_sexo",json.sexo);
            //Orientacion sexual
            chart_g_victima_orientacion.setOption(JSON.parse(json.orientacion.grafico));
            actualizar_tabla("t_g_victima_orientacion",json.orientacion);
            //Identidad de genero
            chart_g_victima_identidad_g.setOption(JSON.parse(json.identidad_g.grafico));
            actualizar_tabla("t_g_victima_identidad_g",json.identidad_g);
            //Edad
            chart_g_victima_edad.setOption(JSON.parse(json.edad.grafico));
            actualizar_tabla("t_g_victima_edad",json.edad);
            //Pertenencia etinca
            chart_g_victima_etnico.setOption(JSON.parse(json.etnia.grafico));
            actualizar_tabla("t_g_victima_etnico",json.etnia);
            //Pertenencia indigena
            chart_g_victima_indigena.setOption(JSON.parse(json.indigena.grafico));
            actualizar_tabla("t_g_victima_indigena",json.indigena);
            //Estado civil
            chart_g_victima_estado_civil.setOption(JSON.parse(json.estado_civil.grafico));
            actualizar_tabla("t_g_victima_estado_civil",json.estado_civil);
            //Discapacidad
            chart_g_victima_discapacidad.setOption(JSON.parse(json.discapacidad.grafico));
            actualizar_tabla("t_g_victima_discapacidad",json.discapacidad);
            //Educación formal
            chart_g_victima_educacion.setOption(JSON.parse(json.educacion.grafico));
            actualizar_tabla("t_g_victima_educacion",json.educacion);
            //Nacionalidad
            chart_g_victima_nacionalidad.setOption(JSON.parse(json.nacionalidad.grafico));
            actualizar_tabla("t_g_victima_nacionalidad",json.nacionalidad);
            //Ejerce autoridad o cargo publico
            chart_g_victima_cargo.setOption(JSON.parse(json.cargo.grafico));
            actualizar_tabla("t_g_victima_cargo",json.cargo);
            //Autoridad etnico territorial
            chart_g_victima_autoridad_t.setOption(JSON.parse(json.autoridad.grafico));
            actualizar_tabla("t_g_victima_autoridad_t",json.autoridad);
            //Miembro de fuerza publica
            chart_g_victima_f_publica.setOption(JSON.parse(json.f_publica.grafico));
            actualizar_tabla("t_g_victima_f_publica",json.f_publica);
            //Miembro de actor armado ilegal
            chart_g_victima_aai.setOption(JSON.parse(json.actor.grafico));
            actualizar_tabla("t_g_victima_aai",json.actor);
            //Participa en organizacion
            chart_g_victima_organizacion_participa.setOption(JSON.parse(json.organizacion.grafico));
            actualizar_tabla("t_g_victima_organizacion_participa",json.organizacion);
            //Tipo de organizacion en que participaba
            chart_g_victima_organizacion_tipo.setOption(JSON.parse(json.organizacion_tipo.grafico));
            actualizar_tabla("t_g_victima_organizacion_tipo",json.organizacion_tipo);



        }



    </script>


@endpush