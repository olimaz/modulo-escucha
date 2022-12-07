<div class="row">
    {{-- Se reconoce como --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Se reconoce en una o varias de las siguientes categorías:'
                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                        , 'info_div' => "g_exilio_reconoce"
                         ]
                )
    </div>

    {{-- Tipos de movimientos --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Tipos de movimientos registrados en el sistema'
                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                        , 'info_div' => "g_exilio_movimiento"
                         ]
                )
    </div>


    <div class="w-100"></div>


    {{-- ha retornado --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => '¿Ha tenido uno o más procesos de retorno? '
                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                        , 'info_div' => "g_retorno"
                         ]
                )
    </div>


    {{-- otros exilios --}}
    <div class="col-sm-6">
        @include("fichas.stats.p_grafico",
                     ['info_titulo' => 'Después del retorno, ¿volvió a exiliarse? '
                        , 'info_pie' => "Información para quienes han indicado haber retornado."
                        , 'info_div' => "g_otro_exilio"
                        ]
                )
    </div>
</div>

{{-- Primera salida --}}

<div class="row">
    <div class="col-xs-12">
        <div class="card card-primary card-outline ">
            <div class="card-header">
                <h3 class="card-title">Información de la primera salida</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Motivo de salida --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Motivos de salida del país"
                                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                                        , 'info_div' => "g_exilio_salida_motivo" ]
                                )
                    </div>

                    {{-- Modalidad de salida --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Modalidad de salida del país"
                                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                                        , 'info_div' => "g_exilio_salida_modalidad"
                                         ]
                                )
                    </div>

                    <div class="w-100"></div>
                    {{-- Año de salida --}}
                    <div class="col-sm-6">

                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Año de salida del país"
                                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                                        , 'info_div' => "g_exilio_salida_anio"
                                         ]
                                )
                    </div>

                    {{-- Lugar de salida --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Lugar de salida del país"
                                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                                        , 'info_div' => "g_exilio_salida_lugar_s"
                                        ]
                                )
                    </div>

                    {{-- Lugar de llegada --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Lugar de llegada"
                                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                                        , 'info_div' => "g_exilio_salida_lugar_ll"
                                         ]
                                )
                    </div>

                    {{-- Lugar de asentamiento --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Lugar de asentamiento posterior"
                                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                                        , 'info_div' => "g_exilio_salida_lugar_ll_as"
                                        ]
                                )
                    </div>

                    <div class="w-100"></div>


                    {{-- Solicitado proteccion --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Ha solicitado status de proteccion"
                                        , 'info_pie' => "Información para quienes responden la pregunta."
                                        , 'info_div' => "g_exilio_salida_p_s"
                                         ]
                                )
                    </div>

                    {{-- Estado de la solicitud de proteccion --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Estado de la solicitud de proteccion"
                                        , 'info_pie' => "Información para quienes responden la pregunta."
                                        , 'info_div' => "g_exilio_salida_p_e"
                                         ]
                                )
                    </div>


                    <div class="w-100"></div>


                    {{-- Solicitado proteccion --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Si aprobada, por:"
                                        , 'info_pie' => "Información para quienes responden la pregunta."
                                        , 'info_div' => "g_exilio_salida_p_si"
                                         ]
                                )
                    </div>

                    {{-- Estado de la solicitud de proteccion --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Si denegada, ¿en qué condición se encuentra? "
                                        , 'info_pie' => "Información para quienes responden la pregunta."
                                        , 'info_div' => "g_exilio_salida_p_no"
                                         ]
                                )
                    </div>


                    {{-- Residencia --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "¿Ha obtenido residencia en el país de acogida?"
                                        , 'info_pie' => "Información para quienes responden la pregunta."
                                        , 'info_div' => "g_exilio_salida_residencia"
                                         ]
                                )
                    </div>

                    {{-- Expulsión --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "¿Ha sufrido un proceso de expulsión, deportación y/o devolución?"
                                        , 'info_pie' => "Información para quienes responden la pregunta."
                                        , 'info_div' => "g_exilio_salida_expulsion"
                                        ]
                                )
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Reasentamientos --}}

<div class="row">
    <div class="col-xs-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"> Información de reasentamientos posteriores</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body no-padding ">
                <div class="row">
                    {{-- Motivo de salida --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Motivos de salida"
                                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                                        , 'info_div' => "g_exilio_rea_motivo"
                                         ]
                                )
                    </div>

                    {{-- Modalidad de salida --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Modalidad de salida"
                                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                                        , 'info_div' => "g_exilio_rea_modalidad"
                                         ]
                                )
                    </div>

                    <div class="w-100"></div>
                    {{-- Año de salida --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Año de salida "
                                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                                        , 'info_div' => "g_exilio_rea_anio"
                                         ]
                                )
                    </div>

                    {{-- Lugar de salida --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Lugar de salida"
                                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                                        , 'info_div' => "g_exilio_rea_lugar_s"
                                         ]
                                )
                    </div>

                    {{-- Lugar de llegada --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Lugar de llegada"
                                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                                        , 'info_div' => "g_exilio_rea_lugar_ll"
                                         ]
                                )
                    </div>

                    {{-- Lugar de asentamiento --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Lugar de asentamiento posterior"
                                        , 'info_pie' => "Información para un total de ". $datos->exilio->total ." fichas diligenciadas digitalmente."
                                        , 'info_div' => "g_exilio_rea_lugar_ll_as"
                                         ]
                                )
                    </div>

                    <div class="w-100"></div>


                    {{-- Solicitado proteccion --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Ha solicitado status de proteccion"
                                        , 'info_pie' => "Información para quienes responden la pregunta."
                                        , 'info_div' => "g_exilio_rea_p_s"
                                        ]
                                )
                    </div>

                    {{-- Estado de la solicitud de proteccion --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Estado de la solicitud de proteccion"
                                        , 'info_pie' => "Información para quienes responden la pregunta."
                                        , 'info_div' => "g_exilio_rea_p_e"
                                         ]
                                )
                    </div>


                    <div class="w-100"></div>
                    {{-- Solicitado proteccion --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Si aprobada, por:"
                                        , 'info_pie' => "Información para quienes responden la pregunta."
                                        , 'info_div' => "g_exilio_rea_p_si"
                                         ]
                                )
                    </div>

                    {{-- Estado de la solicitud de proteccion --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Si denegada, ¿en qué condición se encuentra? "
                                        , 'info_pie' => "Información para quienes responden la pregunta."
                                        , 'info_div' => "g_exilio_rea_p_no"
                                         ]
                                )
                    </div>


                    {{-- Residencia --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "¿Ha obtenido residencia en el país de acogida?"
                                        , 'info_pie' => "Información para quienes responden la pregunta."
                                        , 'info_div' => "g_exilio_rea_residencia"
                                         ]
                                )
                    </div>

                    {{-- Expulsión --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "¿Ha sufrido un proceso de expulsión, deportación y/o devolución?"
                                        , 'info_pie' => "Información para quienes responden la pregunta."
                                        , 'info_div' => "g_exilio_rea_expulsion"
                                         ]
                                )
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="w-100"></div>


<div class="row">

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"> Información del retorno</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body no-padding ">
                <div class="row">

                    {{-- Año de retorno --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Año de retorno"
                                        , 'info_pie' => "Información para quienes han tenido retorno."
                                        , 'info_div' => "g_exilio_ret_anio"
                                         ]
                                )
                    </div>

                    {{-- Modalidad de retorno --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Modalidad de retorno"
                                        , 'info_pie' => "Información para quienes han tenido retorno."
                                        , 'info_div' => "g_exilio_ret_modalidad"
                                         ]
                                )
                    </div>

                    <div class="w-100"></div>
                    {{-- Porqué retornó --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "¿Por qué retornó?"
                                        , 'info_pie' => "Información para quienes aplica la pregunta."
                                        , 'info_div' => "g_exilio_ret_ha_tenido_si"
                                         ]
                                )
                    </div>

                    {{-- Porqué no retornó --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "¿Por qué no ha retornado?"
                                        , 'info_pie' => "Información para quienes aplica la pregunta."
                                        , 'info_div' => "g_exilio_ret_ha_tenido_no"
                                         ]
                                )
                    </div>


                    <div class="w-100"></div>
                    {{-- Lugar de salida --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Lugar de salida"
                                        , 'info_pie' => "Información para quienes aplica la pregunta."
                                        , 'info_div' => "g_exilio_ret_salida"
                                         ]
                                )
                    </div>
                    {{-- Lugar de llegada --}}
                    <div class="col-sm-6">
                        @include("fichas.stats.p_grafico",
                                     ['info_titulo' => "Lugar de llegada"
                                        , 'info_pie' => "Información para quienes aplica la pregunta."
                                        , 'info_div' => "g_exilio_ret_llegada"
                                         ]
                                )
                    </div>
                </div>
            </div>
        </div>

</div>

    <div class="w-100"></div>

<div class="row">
    <div class="col-xs-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"> Impactos y afrontamientos</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body no-padding ">
                <div class="row">

                    @php($i=0)
                    @foreach($datos->exilio->impactos as $id => $info)

                        <div class="col-sm-6">
                            @include("fichas.stats.p_tabla",
                                                    ['info_titulo' => $info->descripcion
                                                       , 'info_tabla' => $info
                                                       , 'tabla_nombre' => 'imp_exi_'.$id
                                                        ]
                                               )

                        </div>

                        @if(++$i%2 == 0 )
                            <div class="w-100"></div>
                        @endif

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>



<div class="w-100"></div>

@push("js")
    {{-- Actualizar  --}}
    <script>
        //Por si necesito depurar lo que viene del ajax
        var json_exilio;

        //Bandera para evitar repetir el calculo innecesariamente
        var ya_exilio=false;
        //Funcion para hacer la lectura AJAX
        function actualizar_exilio() {
            if(ya_exilio) {
                //console.log("Graficas de victima ya calculadas");
            }
            else {
                Swal.fire({
                    title: "",
                    text: "Actualizando gráficas de exilio, gracias por su paciencia.",
                    showConfirmButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });
                //console.log("Actualizando graficas de procesamiento");
                $.getJSON( "<?php echo url('dash/json/exilio')."?".$filtros->url; ?>" )
                    .done(function( json ) {
                        json_exilio = json;
                        actualizar_graficos_exilio(json_exilio);
                        ya_exilio=true; //Para que no lo haga de nuevo
                        swal.close()
                    })
                    .fail(function( jqxhr, textStatus, error ) {
                        var err = textStatus + ", " + error;
                        console.log( "Problema al leer los datos, ajax exilio:" + err );
                    });
            }
        }

        //Funcion para actualizar los gráficos
        function actualizar_graficos_exilio(json) {

            //Como se reconoce
            chart_g_exilio_reconoce.setOption(JSON.parse(json.reconoce.grafico));
            actualizar_tabla("t_g_exilio_reconoce",json.reconoce);

            //Fichas según tipo de movimiento
            chart_g_exilio_movimiento.setOption(JSON.parse(json.movimientos.grafico));
            actualizar_tabla("t_g_exilio_movimiento",json.movimientos);


            //Retorno
            chart_g_retorno.setOption(JSON.parse(json.retorno.ha_retornado.grafico));
            actualizar_tabla("t_g_retorno",json.retorno.ha_retornado);
            //Otro exilio
            chart_g_otro_exilio.setOption(JSON.parse(json.retorno.otro_exilio.grafico));
            actualizar_tabla("t_g_otro_exilio",json.retorno.otro_exilio);
            //---Primera salida
            //motivo
            chart_g_exilio_salida_motivo.setOption(JSON.parse(json.salida.motivos.grafico));
            actualizar_tabla("t_g_exilio_salida_motivo",json.salida.motivos);
            //modalidad
            chart_g_exilio_salida_modalidad.setOption(JSON.parse(json.salida.modalidad.grafico));
            actualizar_tabla("t_g_exilio_salida_modalidad",json.salida.modalidad);
            //Año
            chart_g_exilio_salida_anio.setOption(JSON.parse(json.salida.anio.grafico));
            actualizar_tabla("t_g_exilio_salida_anio",json.salida.anio);
            //Lugar salida
            chart_g_exilio_salida_lugar_s.setOption(JSON.parse(json.salida.lugar_salida.grafico));
            actualizar_tabla("t_g_exilio_salida_lugar_s",json.salida.lugar_salida);
            //Lugar llegada
            chart_g_exilio_salida_lugar_ll.setOption(JSON.parse(json.salida.lugar_llegada.grafico));
            actualizar_tabla("t_g_exilio_salida_lugar_ll",json.salida.lugar_llegada);
            //Lugar asentamiento
            chart_g_exilio_salida_lugar_ll_as.setOption(JSON.parse(json.salida.lugar_asentamiento.grafico));
            actualizar_tabla("t_g_exilio_salida_lugar_ll_as",json.salida.lugar_asentamiento);
            //Ha solicitado proteccion
            chart_g_exilio_salida_p_s.setOption(JSON.parse(json.salida.proteccion_solicita.grafico));
            actualizar_tabla("t_g_exilio_salida_p_s",json.salida.proteccion_solicita);
            //Ha solicitado proteccion, estado de la solicitud
            chart_g_exilio_salida_p_e.setOption(JSON.parse(json.salida.proteccion_estado.grafico));
            actualizar_tabla("t_g_exilio_salida_p_e",json.salida.proteccion_estado);
            //Ha solicitado proteccion, si
            chart_g_exilio_salida_p_si.setOption(JSON.parse(json.salida.proteccion_si.grafico));
            actualizar_tabla("t_g_exilio_salida_p_si",json.salida.proteccion_si);
            //Ha solicitado proteccion, no
            chart_g_exilio_salida_p_no.setOption(JSON.parse(json.salida.proteccion_no.grafico));
            actualizar_tabla("t_g_exilio_salida_p_no",json.salida.proteccion_no);
            //Ha obtenido residencia
            chart_g_exilio_salida_residencia.setOption(JSON.parse(json.salida.residencia.grafico));
            actualizar_tabla("t_g_exilio_salida_residencia",json.salida.residencia);
            //Ha sufrido expulsion
            chart_g_exilio_salida_expulsion.setOption(JSON.parse(json.salida.expulsion.grafico));
            actualizar_tabla("t_g_exilio_salida_expulsion",json.salida.expulsion);


            //---Reasentamientos
            //motivo
            chart_g_exilio_rea_motivo.setOption(JSON.parse(json.reasentamientos.motivos.grafico));
            actualizar_tabla("t_g_exilio_rea_motivo",json.reasentamientos.motivos);
            //modalidad
            chart_g_exilio_rea_modalidad.setOption(JSON.parse(json.reasentamientos.modalidad.grafico));
            actualizar_tabla("t_g_exilio_rea_modalidad",json.reasentamientos.modalidad);
            //Año
            chart_g_exilio_rea_anio.setOption(JSON.parse(json.reasentamientos.anio.grafico));
            actualizar_tabla("t_g_exilio_rea_anio",json.reasentamientos.anio);
            //Lugar salida
            chart_g_exilio_rea_lugar_s.setOption(JSON.parse(json.reasentamientos.lugar_salida.grafico));
            actualizar_tabla("t_g_exilio_rea_lugar_s",json.reasentamientos.lugar_salida);
            //Lugar llegada
            chart_g_exilio_rea_lugar_ll.setOption(JSON.parse(json.reasentamientos.lugar_llegada.grafico));
            actualizar_tabla("t_g_exilio_rea_lugar_ll",json.reasentamientos.lugar_llegada);
            //Lugar asentamiento
            chart_g_exilio_rea_lugar_ll_as.setOption(JSON.parse(json.reasentamientos.lugar_asentamiento.grafico));
            actualizar_tabla("t_g_exilio_rea_lugar_ll_as",json.reasentamientos.lugar_asentamiento);
            //Ha solicitado proteccion
            chart_g_exilio_rea_p_s.setOption(JSON.parse(json.reasentamientos.proteccion_solicita.grafico));
            actualizar_tabla("t_g_exilio_rea_p_s",json.reasentamientos.proteccion_solicita);
            //Ha solicitado proteccion, estado de la solicitud
            chart_g_exilio_rea_p_e.setOption(JSON.parse(json.reasentamientos.proteccion_estado.grafico));
            actualizar_tabla("t_g_exilio_rea_p_e",json.reasentamientos.proteccion_estado);
            //Ha solicitado proteccion, si
            chart_g_exilio_rea_p_si.setOption(JSON.parse(json.reasentamientos.proteccion_si.grafico));
            actualizar_tabla("t_g_exilio_rea_p_si",json.reasentamientos.proteccion_si);
            //Ha solicitado proteccion, no
            chart_g_exilio_rea_p_no.setOption(JSON.parse(json.reasentamientos.proteccion_no.grafico));
            actualizar_tabla("t_g_exilio_rea_p_no",json.reasentamientos.proteccion_no);
            //Ha obtenido residencia
            chart_g_exilio_rea_residencia.setOption(JSON.parse(json.reasentamientos.residencia.grafico));
            actualizar_tabla("t_g_exilio_rea_residencia",json.reasentamientos.residencia);
            //Ha sufrido expulsion
            chart_g_exilio_rea_expulsion.setOption(JSON.parse(json.reasentamientos.expulsion.grafico));
            actualizar_tabla("t_g_exilio_rea_expulsion",json.reasentamientos.expulsion);


            //---Retornos
            //año
            chart_g_exilio_ret_anio.setOption(JSON.parse(json.retorno.anio.grafico));
            actualizar_tabla("t_g_exilio_ret_anio",json.retorno.anio);
            //modalidad
            chart_g_exilio_ret_modalidad.setOption(JSON.parse(json.retorno.modalidad.grafico));
            actualizar_tabla("t_g_exilio_ret_modalidad",json.retorno.modalidad);
            //porqué retornó
            chart_g_exilio_ret_ha_tenido_si.setOption(JSON.parse(json.retorno.ha_tenido_si.grafico));
            actualizar_tabla("t_g_exilio_ret_ha_tenido_si",json.retorno.ha_tenido_si);
            //porqué no retornó
            chart_g_exilio_ret_ha_tenido_no.setOption(JSON.parse(json.retorno.ha_tenido_no.grafico));
            actualizar_tabla("t_g_exilio_ret_ha_tenido_no",json.retorno.ha_tenido_no);
            //Lugar de salida
            chart_g_exilio_ret_salida.setOption(JSON.parse(json.retorno.lugar_salida.grafico));
            actualizar_tabla("t_g_exilio_ret_salida",json.retorno.lugar_salida);
            //Lugar de llegada
            chart_g_exilio_ret_llegada.setOption(JSON.parse(json.retorno.lugar_llegada.grafico));
            actualizar_tabla("t_g_exilio_ret_llegada",json.retorno.lugar_llegada);
        }



    </script>


@endpush

