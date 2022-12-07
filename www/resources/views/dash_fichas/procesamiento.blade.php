
{{-- CONSENTIMEINTO INFORMADO --}}
<div class="box box-success ">
    <div class="box-header">
        <h3 class="box-title text-success">Tablas de avance</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_tab"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding">
        {{-- Tablas de datos --}}
        <div class="col-sm-6">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                        Algunas referencias
                    </h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered table-striped">
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

        <div class="clearfix"></div>
        {{-- TOTALES POR TERRITORIO--}}
        <div class="col-sm-12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                        Avance en los territorios
                    </h3>

                    <div class="box-tools pull-right">
                        <a class='btn btn-success btn-xs' href="#" id="b_tabla_macro"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_ret"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-condensed table-bordered" id='tabla_macro'>
                        <thead>
                        <tr>
                            <th>Macroterritorio</th>
                            <th>Territorio</th>
                            <th>Entrevistas totales</th>
                            <th>Transcritas</th>
                            <th>Etiquetadas</th>
                            <th>Fichas diligenciada en línea</th>
                            <th>Entrevista cerrada</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($datos->procesamiento_macro->estructura as $id_macro => $detalle)
                            <tr>
                                <th>{{ $detalle['nombre'] }}</th>
                                <td>&nbsp;</td>
                                <th class="text-center ">{{ $datos->procesamiento_macro->entrevistas->datos_macro[$id_macro] }}</th>
                                <th class="text-center">{{ $datos->procesamiento_macro->transcritas->datos_macro[$id_macro][1] }}</th>
                                <th class="text-center">{{ $datos->procesamiento_macro->etiquetadas->datos_macro[$id_macro][1] }}</th>
                                <th class="text-center">{{ $datos->procesamiento_macro->fichas->datos_macro[$id_macro][1] }}</th>
                                <th class="text-center">{{ $datos->procesamiento_macro->cerrado->datos_macro[$id_macro][1] }}</th>
                            </tr>
                            @foreach($detalle['hijos'] as $id_territorio => $texto)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>{{ $texto }}</td>
                                    <td class="text-center"> {{ $datos->procesamiento_macro->entrevistas->datos[$id_territorio] }}</td>
                                    <td class="text-center"> {{ $datos->procesamiento_macro->transcritas->datos[$id_territorio][1]}}</td>
                                    <td class="text-center"> {{ $datos->procesamiento_macro->etiquetadas->datos[$id_territorio][1] }}</td>
                                    <td class="text-center"> {{ $datos->procesamiento_macro->fichas->datos[$id_territorio][1] }}</td>
                                    <td class="text-center"> {{ $datos->procesamiento_macro->cerrado->datos[$id_territorio][1] }}</td>
                                </tr>
                            @endforeach
                        @endforeach

                        </tbody>
                        <tfoot>
                            <tr class="bg-gray">
                                <th colspan="2">Total</th>
                                <th class="text-center"> {{ $datos->procesamiento_macro->entrevistas->total }} </th>
                                <th class="text-center"> {{ $datos->procesamiento_macro->transcritas->total }} </th>
                                <th class="text-center"> {{ $datos->procesamiento_macro->etiquetadas->total }} </th>
                                <th class="text-center"> {{ $datos->procesamiento_macro->fichas->total }} </th>
                                <th class="text-center"> {{ $datos->procesamiento_macro->cerrado->total }} </th>

                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
        @push('js')
            <script>
                // This must be a hyperlink
                $("#b_tabla_macro").on('click', function(event) {
                    $("#tabla_macro").table2excel({
                        name: "SIM",
                        //filename: "sat_problemas_" + new Date().toISOString().replace(/[\-\:\.]/g, "").substring(0,8),
                        filename: "datos_territorios_" + new Date().toLocaleString("en-GB", {timeZone: "America/Bogota"}).replace(/[\-\:\.]/g, "").substring(0,10)+ ".xls",
                        fileext: ".xls",
                        exclude_img: true,
                        exclude_links: true,
                        exclude_inputs: true
                    });
                });
            </script>
        @endpush
    </div>
</div>

<div class="clearfix"></div>
{{-- FICHAS diligenciadas --}}
<div class="box box-success ">
    <div class="box-header">
        <h3 class="box-title text-success">Fichas diligenciadas en el sistema</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_fic"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding">
        {{-- Víctimas --}}
        <div class="col-sm-6">
            @include("dash_fichas.p_grafico",
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
        <div class="col-sm-6">
            @include("dash_fichas.p_grafico",
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
                                                            <li>Víctimas: 10 (5 de amenaza, 5 de desplazamiento)</li>
                                                        </ul>
                                                    </span>
                                                    '
                                   , 'info_div' => "g_procesamiento_h"
                                    ]
                           )
        </div>


        {{--  Salto de fila --}}
        <div class="clearfix"></div>


        {{-- Presunto Responsable Individual --}}

        <div class="col-sm-6">
            @include("dash_fichas.p_grafico",
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
        <div class="col-sm-6">
            @include("dash_fichas.p_grafico",
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


{{-- Totales en territorios --}}
<div class="clearfix"></div>

{{-- CONSENTIMEINTO INFORMADO --}}
<div class="box box-success ">
    <div class="box-header">
        <h3 class="box-title text-success">Consentimiento informado</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_ret"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding">

        {{-- Consentimiento informado --}}
        <div class="col-sm-6">
            @include("dash_fichas.p_grafico",
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
            @include("dash_fichas.p_grafico",
                         ['info_titulo' => "¿Está de acuerdo en conceder entrevistas a la Comisión de la Verdad?"
                            , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                            , 'info_div' => "g_ci_conceder"
                             ]
                    )
        </div>
        {{--Grabar entrevista --}}
        <div class="col-sm-6">
            @include("dash_fichas.p_grafico",
                         ['info_titulo' => "¿Está de acuerdo en que la Comisión grabe el audio para la entrevista? "
                            , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                            , 'info_div' => "g_ci_grabar"
                            ]
                    )
        </div>
        <div class="clearfix"></div>
        {{-- utilizar en informe --}}
        <div class="col-sm-6">
            @include("dash_fichas.p_grafico",
                         ['info_titulo' => "¿Está de acuerdo en que su entrevista sea utilizada para elaborar el informe Final? "
                            , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                            , 'info_div' => "g_ci_elaborar_informe"
                            ]
                    )
        </div>
        {{-- Publicar en informe  --}}
        <div class="col-sm-6">
            @include("dash_fichas.p_grafico",
                         ['info_titulo' => "Autorización para el tratamientos de datos personales: Publicar su nombre en el Informe Final. "
                            , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                            , 'info_div' => "g_ci_td_publicar"
                             ]
                    )
        </div>

        {{-- analizar datos personales --}}
        <div class="col-sm-6">
            @include("dash_fichas.p_grafico",
                         ['info_titulo' => "Datos personales. Autoriza su uso para Analizarlos, compararlos, contrastarlos con otros datos e información recolectada. "
                            , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                            , 'info_div' => "g_ci_td_analizar_p"
                            ]
                    )
        </div>
        {{-- analizar datos sensibles  --}}
        <div class="col-sm-6">
            @include("dash_fichas.p_grafico",
                         ['info_titulo' => "Datos sensibles. Autoriza su uso para Analizarlos, compararlos, contrastarlos con otros datos e información recolectada. "
                            , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                            , 'info_div' => "g_ci_td_analizar_s"
                            ]
                    )
        </div>

        {{-- utilizar para informe datos personales --}}
        <div class="col-sm-6">
            @include("dash_fichas.p_grafico",
                         ['info_titulo' => "Datos personales. Autoriza su uso para utilizarlos para la elaboración del informe final de la Comisión de la Verdad. "
                            , 'info_pie' => "Información para entrevistas con consentimiento informado diligenciado."
                            , 'info_div' => "g_ci_td_utilizar_p"
                            ]
                    )
        </div>
        {{-- utilizar para informe datos sensibles  --}}
        <div class="col-sm-6">
            @include("dash_fichas.p_grafico",
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
                //alert("antes de actualizar");
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




