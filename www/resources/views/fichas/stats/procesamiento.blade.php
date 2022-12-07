<div class="row">
    {{-- Indicadores --}}
    <div class="col-sm-6">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    Algunas referencias del proceso de diligenciar fichas
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body ">
                <div class="table-responsive no-padding">
                    <table class="table table-bordered table-striped table-condensed table-xs">
                        <thead>
                        <tr>
                            <th>Indicador</th>
                            <th style="width:15ch">Valor</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Total de entrevistas </td>
                            <td class="text-right"> {{ $datos->conteos->entrevistas }} </td>
                        </tr>
                        <tr>
                            <td>Entrevistas con al menos una víctima </td>
                            <td class="text-right"> {{ $datos->con_victima }} ({{ floor($datos->con_victima_porcentaje) }} %)</td>
                        </tr>

                        <tr>
                            <td>Entrevistas con ficha de persona entrevistada </td>
                            <td class="text-right"> {{ $datos->con_persona_entrevistada }} ({{ floor($datos->con_persona_entrevistada_porcentaje) }} %)</td>
                        </tr>

                        <tr>
                            <td>Entrevistas con transcripción </td>
                            <td class="text-right"> {{ $datos->con_transcripcion }}  ({{ floor($datos->con_transcripcion_porcentaje) }} %)</td>
                        </tr>
                        <tr>
                            <td>Entrevistas con etiquetado </td>
                            <td class="text-right"> {{ $datos->con_etiquetado }} ({{ floor($datos->con_etiquetado_porcentaje) }} %)</td>
                        </tr>
                        <tr>
                            <td>Entrevistas con ficha diligenciada digitalmente</td>
                            <td class="text-right"> {{ $datos->con_fichas }} ({{ floor($datos->con_fichas_porcentaje) }} %)</td>
                        </tr>
                        <tr>
                            <td>Promedio de tiempo de duración de las entrevistas </td>
                            <td class="text-right"> {{ floor($datos->tiempos[0]) }} minutos</td>
                        </tr>
                        <tr>
                            <td>Promedio de tiempo utilizado para transcribir una entrevista </td>
                            <td class="text-right">{{ floor($datos->tiempos[1]) }} minutos</td>
                        </tr>
                        <tr>
                            <td>Promedio de tiempo utilizado para etiquetar una entrevista </td>
                            <td class="text-right"> {{ floor($datos->tiempos[2]) }} minutos</td>
                        </tr>
                        <tr>
                            <td>Promedio de tiempo utilizado para diligenciar las fichas de una entrevista </td>
                            <td class="text-right">{{ floor($datos->tiempos[3]) }} minutos</td>
                        </tr>

                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>


    <div class="col-md-6">
        @include("fichas.stats.p_tabla",
                      ['info_titulo' => $datos->entrevistas->sectores->descripcion
                         , 'info_tabla' =>  $datos->entrevistas->sectores
                         , 'tabla_nombre' => 'entrevistas_sectores'
                         , 'tabla_pie' => "Información de las entrevistas ."
                          ]
                 )
    </div>

</div>

<div class="w-100"></div>

{{-- FICHAS diligenciadas --}}
<div class="card card-info card-outline">
    <div class="card-header">
        <h3 class="card-title ">Fichas diligenciadas en el sistema</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" ><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body ">
        <div class="row">
            {{-- Víctimas --}}
            <div class="col-md-6">
                @include("fichas.stats.p_grafico",
                                    ['info_titulo' => "Cantidad de fichas de víctimas"
                                       , 'info_pie' => '
                                                        <span class="text-muted">
                                                            <dl class="dl-horizontal">
                                                                <dt>Asignadas:</dt><dd>Se cuenta con información de la víctima y el hecho.</dd>
                                                                <dt>Sin asignar:</dt><dd>Se ha diligenciado información de la víctima, pero no del hecho</dd>
                                                            </dl>
                                                        </span>
                                                        '
                                       , 'info_div' => "g_procesamiento_v"
                                        ]
                               )
            </div>

            {{-- Hechos, violencia, victimas --}}
            <div class="col-md-6">
                @include("fichas.stats.p_grafico",
                                   ['info_titulo' => "Registro de violencia"
                                      , 'info_pie' => '
                                                      <span class="text-muted">
                                                           <dl class="dl-horizontal">
                                                               <dt>Hecho:</dt><dd>Evento de violencia ocurrido en el mismo lugar, fecha y víctima.</dd>
                                                               <dt>Violaciones:</dt><dd> Violaciones a DIH registradas en cada hecho</dd>
                                                               <dt>Víctimas:</dt><dd> Cantidad de personas que sufrieron las violaciones a DIH registradas en cada hecho</dd>
                                                           </dl>
                                                           <p><strong>Ejemplo:</strong> Amenaza y desplazamiento a una familia de 5:</p>
                                                           <ul>
                                                               <li>Hechos: 1</li>
                                                               <li>Violaciones: 2 (Amenaza, desplazamiento)</li>
                                                               <li>Víctimas total: 10 (5 de amenaza, 5 de desplazamiento)</li>
                                                           </ul>
                                                       </span>
                                                       '
                                      , 'info_div' => "g_procesamiento_h"
                                       ]
                              )
            </div>


            {{--  Salto de fila --}}
            <div class="w-100"></div>


            {{-- Presunto Responsable Individual --}}

            <div class="col-md-6">
                @include("fichas.stats.p_grafico",
                                   ['info_titulo' => "Cantidad de fichas de presuntos responsables individuales"
                                      , 'info_pie' => '
                                                       <span class="text-muted">
                                                           <dl class="dl-horizontal">
                                                               <dt>Asignadas:</dt><dd>Se cuenta con información del presunto responsable individual y su participación en el hecho.</dd>
                                                               <dt>Sin asignar:</dt><dd>Se ha diligenciado información del presunto responsable individual, pero no del hecho.</dd>
                                                           </dl>
                                                       </span>
                                                       '
                                      , 'info_div' => "g_procesamiento_pri"
                                       ]
                              )
            </div>


            {{-- Exilio --}}
            <div class="col-md-6">
                @include("fichas.stats.p_grafico",
                                   ['info_titulo' => "Exilio"
                                      , 'info_pie' => '
                                                       <span class="text-muted">
                                                           <dl class="dl-horizontal">
                                                               <dt>Hechos con exilio:</dt><dd> Fichas de hechos que registran "Exilio" como violencia.</dd>
                                                               <dt>Fichas de exilio:</dt><dd> Fichas de exilio diligenciadas</dd>
                                                           </dl>
                                                       </span>
                                                       '
                                      , 'info_div' => "g_procesamiento_e"
                                       ]
                              )

            </div>
        </div>
    </div>
</div>


{{-- Totales en territorios --}}
<div class="w-100"></div>

{{-- CONSENTIMEINTO INFORMADO --}}
<div class="card card-info card-outline ">
    <div class="card-header">
        <h3 class="card-title text-success">Consentimiento informado</h3>
        <div class="card-tools pull-right">
            <button type="button" class="btn btn-tool" data-widget="collapse" id="btn_card_ret"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body no-padding row">

        {{-- Consentimiento informado --}}
        <div class="col-sm-6">
            @include("fichas.stats.p_grafico",
                        ['info_titulo' => "Consentimiento informado"
                           //, 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                           , 'info_div' => "g_procesamiento_ci"
                           , 'info_tabla' => true
                           //, 'info_json' => $datos->consentimiento->conceder_entrevista->grafico
                           ]
                   )
        </div>
        <div class="clearfix"></div>
        {{-- Conceder entrevista --}}
        <div class="col-sm-6">
            @include("fichas.stats.p_grafico",
                        ['info_titulo' => "¿Está de acuerdo en conceder entrevistas a la Comisión de la Verdad?"
                           , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                           , 'info_div' => "g_ci_conceder"
                            ]
                   )
        </div>
        {{--Grabar entrevista --}}
        <div class="col-sm-6">
            @include("fichas.stats.p_grafico",
                         ['info_titulo' => "¿Está de acuerdo en que la Comisión grabe el audio para la entrevista? "
                            , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                            , 'info_div' => "g_ci_grabar"
                            ]
                    )
        </div>
        <div class="clearfix"></div>
        {{-- utilizar en informe --}}
        <div class="col-sm-6">
            @include("fichas.stats.p_grafico",
                         ['info_titulo' => "¿Está de acuerdo en que su entrevista sea utilizada para elaborar el informe Final? "
                            , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                            , 'info_div' => "g_ci_elaborar_informe"
                            ]
                    )
        </div>
        {{-- Publicar en informe  --}}
        <div class="col-sm-6">
            @include("fichas.stats.p_grafico",
                         ['info_titulo' => "Autorización para el tratamientos de datos personales: Publicar su nombre en el Informe Final. "
                            , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                            , 'info_div' => "g_ci_td_publicar"
                             ]
                    )
        </div>

        {{-- analizar datos personales --}}
        <div class="col-sm-6">
            @include("fichas.stats.p_grafico",
                        ['info_titulo' => "Datos personales. Autoriza su uso para Analizarlos, compararlos, contrastarlos con otros datos e información recolectada. "
                           , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                           , 'info_div' => "g_ci_td_analizar_p"
                           ]
                   )
        </div>
        {{-- analizar datos sensibles  --}}
        <div class="col-sm-6">
            @include("fichas.stats.p_grafico",
                         ['info_titulo' => "Datos sensibles. Autoriza su uso para Analizarlos, compararlos, contrastarlos con otros datos e información recolectada. "
                            , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                            , 'info_div' => "g_ci_td_analizar_s"
                            ]
                    )
        </div>

        {{-- utilizar para informe datos personales --}}
        <div class="col-sm-6">
            @include("fichas.stats.p_grafico",
                        ['info_titulo' => "Datos personales. Autoriza su uso para utilizarlos para la elaboración del informe final de la Comisión de la Verdad. "
                           , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                           , 'info_div' => "g_ci_td_utilizar_p"
                           ]
                   )
        </div>
        {{-- utilizar para informe datos sensibles  --}}
        <div class="col-sm-6">
            @include("fichas.stats.p_grafico",
                         ['info_titulo' => "Datos sensibles. Autoriza su uso para utilizarlos para la elaboración del informe final de la Comisión de la Verdad. "
                            , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                            , 'info_div' => "g_ci_td_utilizar_s"
                            ]
                    )
        </div>


    </div>
</div>

@push("js")
    {{-- Actualizar  --}}
    <script>
        //Por si necesito depurar lo que viene del ajax
        var json_procesamiento;

        //Bandera para evitar repetir el calculo innecesariamente
        var ya_procesamiento=false;
        //Funcion para hacer la lectura AJAX
        function actualizar_procesamiento() {
            if(ya_procesamiento) {
                //console.log("Graficas de procesamiento ya calculadas");
            }
            else {

                Swal.fire({
                    title: "",
                    text: "Actualizando gráficas de procesamiento, gracias por su paciencia.",
                    //imageUrl: "../../app/app-img/loading_spinner.gif",
                    showConfirmButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });
                //console.log("Actualizando graficas de procesamiento");
                $.getJSON( "<?php echo url('dash/json/procesamiento')."?".$filtros->url; ?>" )
                    .done(function( json ) {
                        json_procesamiento = json;
                        actualizar_graficos(json);
                        ya_procesamiento=true; //Para que no lo haga de nuevo
                        swal.close()
                    })
                    .fail(function( jqxhr, textStatus, error ) {
                        var err = textStatus + ", " + error;
                        console.log( "Problema al leer los datos, ajax procesamiento:" + err );
                    });
            }
        }

        //Funcion para actualizar los gráficos
        function actualizar_graficos(json) {
            //console.log(json);
            //Cantidad de fichas de victimas
            chart_g_procesamiento_v.setOption(JSON.parse(json.procesamiento.victimas.grafico));
            actualizar_tabla("t_g_procesamiento_v",json.procesamiento.victimas);
            //Registro de violencia
            chart_g_procesamiento_h.setOption(JSON.parse(json.procesamiento.hechos.grafico));
            actualizar_tabla("t_g_procesamiento_h",json.procesamiento.hechos);
            //Cantidad de fichas de PRI
            chart_g_procesamiento_pri.setOption(JSON.parse(json.procesamiento.pri.grafico));
            actualizar_tabla("t_g_procesamiento_pri",json.procesamiento.pri);
            //Cantidad de fichas de exilio
            chart_g_procesamiento_e.setOption(JSON.parse(json.procesamiento.exilio.grafico));
            actualizar_tabla("t_g_procesamiento_e",json.procesamiento.exilio);
            //entrevistas con CI diligenciado
            chart_g_procesamiento_ci.setOption(JSON.parse(json.procesamiento.ci.grafico));
            actualizar_tabla("t_g_procesamiento_ci",json.procesamiento.ci);

            //de acuerdo en conceder entrevista
            chart_g_ci_conceder.setOption(JSON.parse(json.consentimiento.conceder_entrevista.grafico));
            actualizar_tabla("t_g_ci_conceder",json.consentimiento.conceder_entrevista);
            //de acuerdo en grabar audio
            chart_g_ci_grabar.setOption(JSON.parse(json.consentimiento.grabar_audio.grafico));
            actualizar_tabla("t_g_ci_grabar",json.consentimiento.grabar_audio);
            //de acuerdo en usar para el informe
            chart_g_ci_elaborar_informe.setOption(JSON.parse(json.consentimiento.elaborar_informe.grafico));
            actualizar_tabla("t_g_ci_elaborar_informe",json.consentimiento.elaborar_informe);
            //Tratamiento de datos: publicar nombre
            chart_g_ci_td_publicar.setOption(JSON.parse(json.consentimiento.tratamiento_datos_publicar.grafico));
            actualizar_tabla("t_g_ci_td_publicar",json.consentimiento.tratamiento_datos_publicar);
            //Tratamiento de datos: analizar personales
            chart_g_ci_td_analizar_p.setOption(JSON.parse(json.consentimiento.tratamiento_datos_analizar.grafico));
            actualizar_tabla("t_g_ci_td_analizar_p",json.consentimiento.tratamiento_datos_analizar);
            //Tratamiento de datos: analizar sensibles
            chart_g_ci_td_analizar_s.setOption(JSON.parse(json.consentimiento.tratamiento_datos_analizar_sensible.grafico));
            actualizar_tabla("t_g_ci_td_analizar_s",json.consentimiento.tratamiento_datos_analizar_sensible);
            //Tratamiento de datos: utilizar personales
            chart_g_ci_td_utilizar_p.setOption(JSON.parse(json.consentimiento.tratamiento_datos_utilizar.grafico));
            actualizar_tabla("t_g_ci_td_utilizar_p",json.consentimiento.tratamiento_datos_utilizar);
            //Tratamiento de datos: utilizar sensibles
            chart_g_ci_td_utilizar_s.setOption(JSON.parse(json.consentimiento.tratamiento_datos_utilizar_sensible.grafico));
            actualizar_tabla("t_g_ci_td_utilizar_s",json.consentimiento.tratamiento_datos_utilizar_sensible);
        }

        //Llamada para que lo haga al cargar
        $(function() {
            //actualizar_procesamiento();
        });

    </script>


@endpush




