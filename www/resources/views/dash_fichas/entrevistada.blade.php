
{{-- Es víctima? --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => '¿La persona entrevistada es víctima de los hechos?'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_victima" ]
            )
</div>

{{-- Es testigo? --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => '¿La persona entrevistada es testigo de los hechos?'
                    , 'info_pie' => "Información para personas entrevistadas que no se identifican como víctima de los hechos."
                    , 'info_div' => "g_entrevistada_testigo"]
            )
</div>


<div class="clearfix"></div>

{{-- Lugar de nacimiento --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Departamento de nacimiento'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_l_nacimiento" ]
            )
</div>

{{-- Lugar de residencia --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Departamento de residencia'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_l_residencia"
                     ]
            )
</div>



<div class="clearfix"></div>

{{-- Sexo --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Sexo'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_sexo"
                     ]
            )
</div>



{{-- Sexo - Identidad de género --}}
<div class="col-sm-6">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">
                Sexo, identidad de género y preferencia sexual
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
                    @foreach($datos->entrevistada->sexo_identidad->categorias['id_identidad'] as $id_identidad => $txt_identidad)
                        <th style="vertical-align: top"> {{ $txt_identidad }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($datos->entrevistada->sexo_identidad->categorias['id_sexo'] as $id_sexo => $txt_sexo)
                    <tr>
                        <td> {{ $txt_sexo }}</td>
                        @foreach($datos->entrevistada->sexo_identidad->categorias['id_identidad'] as $id_identidad => $txt_identidad)
                            <td class="text-center"> {{ isset($datos->entrevistada->sexo_identidad->datos[$id_sexo][$id_identidad]) ? $datos->entrevistada->sexo_identidad->datos[$id_sexo][$id_identidad] : 0 }}</td>
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
                    @foreach($datos->entrevistada->sexo_orientacion->categorias['id_orientacion'] as $id_identidad => $txt_identidad)
                        <th style="vertical-align: top"> {{ $txt_identidad }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($datos->entrevistada->sexo_orientacion->categorias['id_sexo'] as $id_sexo => $txt_sexo)
                    <tr>
                        <td> {{ $txt_sexo }}</td>
                        @foreach($datos->entrevistada->sexo_orientacion->categorias['id_orientacion'] as $id_identidad => $txt_identidad)
                            <td class="text-center"> {{ isset($datos->entrevistada->sexo_orientacion->datos[$id_sexo][$id_identidad]) ? $datos->entrevistada->sexo_orientacion->datos[$id_sexo][$id_identidad] : 0 }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        <div class="box-footer">
            <span class="text-muted">Información para un total de {{ $datos->entrevistada->total }} personas con fichas diligenciadas digitalmente.</span>
        </div>

    </div>
</div>

<div class="clearfix"></div>

{{-- Orientacion sexual --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Orientación sexual (se siente atraído por)'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_orientacion"
                    ]
            )
</div>




{{-- Identidad de género --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Identidad de género (cómo se identifica)'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_identidad_g"
                     ]
            )
</div>



<div class="clearfix"></div>
{{-- Edad  --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Edad al momento de ser entrevistado/a'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_edad"
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
                    @foreach($datos->entrevistada->sexo_edad->categorias['id_sexo'] as $id_sexo => $txt_sexo)
                        <th style="vertical-align: top"> {{ $txt_sexo }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($datos->entrevistada->sexo_edad->categorias['id_edad'] as $id_edad => $txt_edad)
                    <tr>
                        <td> {{ $txt_edad }}</td>
                        @foreach($datos->entrevistada->sexo_edad->categorias['id_sexo'] as  $id_sexo => $txt_sexo)
                            <td class="text-center"> {{ isset($datos->entrevistada->sexo_edad->datos[$id_sexo][$id_edad]) ? $datos->entrevistada->sexo_edad->datos[$id_sexo][$id_edad] : 0 }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <span class="text-muted">Información para un total de {{ $datos->entrevistada->total }} personas con fichas diligenciadas digitalmente.</span>
        </div>

    </div>
</div>



<div class="clearfix"></div>

{{-- Pertenencia etnica --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => ' Pertenencia étnico-racial'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_etnico"
                     ]
    )
</div>




{{-- Grupo indígena--}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => ' Pertenencia a grupos indígenas'
                    , 'info_pie' => 'Información para valores conocidos. No se muestran los valores "Sin especificar".'
                    , 'info_div' => "g_entrevistada_indigena"
                     ]
    )
</div>

<div class="clearfix"></div>
{{-- Estado civil --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Estado Civil'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_estado_civil"
                     ]
            )
</div>

{{-- Discapacidad --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Condición de discapacidad'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_discapacidad"
                     ]
            )
</div>

<div class="clearfix"></div>

{{-- Educacion --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Educación formal'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_educacion"
                     ]
            )
</div>

{{-- Nacionalidad --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Nacionalidad'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_nacionalidad"
                     ]
            )
</div>

{{-- Cargo público --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Ejerce autoridad o cargo público'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_cargo"
                     ]
            )
</div>

{{-- Autoridad etnica --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Es autoridad étnico territorial'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_autoridad_t"
                    ]
            )
</div>

{{-- Fuerza pública --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Es o fué miembro de la fuerza pública'
                    , 'info_pie' => 'Información para valores conocidos. No se muestran los valores "Sin especificar".'
                    , 'info_div' => "g_entrevistada_f_publica"
                     ]
            )
</div>

{{-- Actor armado ilegal --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Fué miembro de un actor armado ilegal'
                    , 'info_pie' => 'Información para valores conocidos. No se muestran los valores "Sin especificar".'
                    , 'info_div' => "g_entrevistada_aai"
                     ]
            )
</div>


{{-- Participa en organizacion  --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Participa o participaba en alguna organización, colectivo, grupo, pueblo'
                    , 'info_pie' => "Información para un total de ". $datos->entrevistada->total ." personas con fichas diligenciadas digitalmente."
                    , 'info_div' => "g_entrevistada_organizacion_participa"
                     ]
            )
</div>

{{-- Tipo de organizacion  --}}
<div class="col-sm-6">
    @include("dash_fichas.p_grafico",
                 ['info_titulo' => 'Tipo de organización en la que participa o participaba'
                    , 'info_pie' => "Información para quienes aplica la respuesta."
                    , 'info_div' => "g_entrevistada_organizacion_tipo"
                     ]
            )
</div>



<div class="clearfix"></div>

@push("js")
    {{-- Actualizar  --}}
    <script>
        //Por si necesito depurar lo que viene del ajax
        var json_entrevistada;

        //Bandera para evitar repetir el calculo innecesariamente
        var ya_entrevistada=false;
        //Funcion para hacer la lectura AJAX
        function actualizar_entrevistada() {
            if(ya_entrevistada) {
                console.log("Graficas de persona entrevistada ya calculadas");
            }
            else {
                Swal.fire({
                    title: "",
                    text: "Actualizando gráficas de persona entrevistada, gracias por su paciencia.",
                    showConfirmButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });
                //console.log("Actualizando graficas de procesamiento");
                $.getJSON( "<?php echo url('dash/json/entrevistada')."?".$filtros->url; ?>" )
                    .done(function( json ) {
                        json_entrevistada = json;
                        actualizar_graficos_entrevistada(json_entrevistada);
                        ya_entrevistada=true; //Para que no lo haga de nuevo
                        swal.close()
                    })
                    .fail(function( jqxhr, textStatus, error ) {
                        var err = textStatus + ", " + error;
                        console.log( "Problema al leer los datos, ajax procesamiento:" + err );
                    });
            }
        }

        //Funcion para actualizar los gráficos
        function actualizar_graficos_entrevistada(json) {
            //Para lo link
            //var enlace_base = '{!!   action("entrevista_individualController@generar_excel_filtrado").$filtros->url !!}';
            var enlace_base = '{!!   action("entrevista_individualController@index").$filtros->url !!}';
            //console.log(enlace_base);
            //Es victima
            chart_g_entrevistada_victima.setOption(JSON.parse(json.es_victima.grafico));
            actualizar_tabla("t_g_entrevistada_victima",json.es_victima);
            //Es testigo
            chart_g_entrevistada_testigo.setOption(JSON.parse(json.es_testigo.grafico));
            actualizar_tabla("t_g_entrevistada_testigo",json.es_testigo);
            //Lugar de nacimiento
            chart_g_entrevistada_l_nacimiento.setOption(JSON.parse(json.lugar_n.grafico));
            actualizar_tabla("t_g_entrevistada_l_nacimiento",json.lugar_n);
            //Lugar de residencia
            chart_g_entrevistada_l_residencia.setOption(JSON.parse(json.lugar_r.grafico));
            actualizar_tabla("t_g_entrevistada_l_residencia",json.lugar_r);
            //SExo
            chart_g_entrevistada_sexo.setOption(JSON.parse(json.sexo.grafico));
            actualizar_tabla("t_g_entrevistada_sexo",json.sexo, enlace_base+'?pe_id_sexo=');
            //Orientacion sexual
            chart_g_entrevistada_orientacion.setOption(JSON.parse(json.orientacion.grafico));
            actualizar_tabla("t_g_entrevistada_orientacion",json.orientacion);
            //Identidad de genero
            chart_g_entrevistada_identidad_g.setOption(JSON.parse(json.identidad_g.grafico));
            actualizar_tabla("t_g_entrevistada_identidad_g",json.identidad_g);
            //Edad
            chart_g_entrevistada_edad.setOption(JSON.parse(json.edad.grafico));
            actualizar_tabla("t_g_entrevistada_edad",json.edad, enlace_base+'?pe_id_grupo_etario=');
            //Pertenencia etinca
            chart_g_entrevistada_etnico.setOption(JSON.parse(json.etnia.grafico));
            actualizar_tabla("t_g_entrevistada_etnico",json.etnia, enlace_base+'?pe_id_etnia=');
            //Pertenencia indigena
            chart_g_entrevistada_indigena.setOption(JSON.parse(json.indigena.grafico));
            actualizar_tabla("t_g_entrevistada_indigena",json.indigena);
            //Estado civil
            chart_g_entrevistada_estado_civil.setOption(JSON.parse(json.estado_civil.grafico));
            actualizar_tabla("t_g_entrevistada_estado_civil",json.estado_civil);
            //Discapacidad
            chart_g_entrevistada_discapacidad.setOption(JSON.parse(json.discapacidad.grafico));
            actualizar_tabla("t_g_entrevistada_discapacidad",json.discapacidad,  enlace_base+'?pe_id_discapacidad=');
            //Educación formal
            chart_g_entrevistada_educacion.setOption(JSON.parse(json.educacion.grafico));
            actualizar_tabla("t_g_entrevistada_educacion",json.educacion);
            //Nacionalidad
            chart_g_entrevistada_nacionalidad.setOption(JSON.parse(json.nacionalidad.grafico));
            actualizar_tabla("t_g_entrevistada_nacionalidad",json.nacionalidad);
            //Ejerce autoridad o cargo publico
            chart_g_entrevistada_cargo.setOption(JSON.parse(json.cargo.grafico));
            actualizar_tabla("t_g_entrevistada_cargo",json.cargo);
            //Autoridad etnico territorial
            chart_g_entrevistada_autoridad_t.setOption(JSON.parse(json.autoridad.grafico));
            actualizar_tabla("t_g_entrevistada_autoridad_t",json.autoridad);
            //Miembro de fuerza publica
            chart_g_entrevistada_f_publica.setOption(JSON.parse(json.f_publica.grafico));
            actualizar_tabla("t_g_entrevistada_f_publica",json.f_publica);
            //Miembro de actor armado ilegal
            chart_g_entrevistada_aai.setOption(JSON.parse(json.actor.grafico));
            actualizar_tabla("t_g_entrevistada_aai",json.actor);
            //Participa en organizacion
            chart_g_entrevistada_organizacion_participa.setOption(JSON.parse(json.organizacion.grafico));
            actualizar_tabla("t_g_entrevistada_organizacion_participa",json.organizacion);
            //Tipo de organizacion en que participaba
            chart_g_entrevistada_organizacion_tipo.setOption(JSON.parse(json.organizacion_tipo.grafico));
            actualizar_tabla("t_g_entrevistada_organizacion_tipo",json.organizacion_tipo);



        }



    </script>


@endpush