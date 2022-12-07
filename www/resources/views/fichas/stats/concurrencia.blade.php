
<div class="row">
    <div class="col">
        <div class="card card-info collapsed-card" id="card_concu_impactos" >
            <div class="card-header ">
                <h3 class="card-title">Impactos y afrontamientos</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body ">
                <div class="row">
                    <div class="col-xs-12">
                        <p><i class="fas fa-hand-point-right"></i>El análisis de concurrencia de impactos/afrontamientos, representa criterios que coinciden en una misma entrevista.
                            @if($filtros->hay_filtro)
                                Los filtros especificados se convierten en una tercera dimensión aplicada en el cálculo de estos cuadros.
                            @endif
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {!! Form::label('id_cat1',"Primer criterio") !!}
                            {!! Form::select('id_cat1', $lis_cat, null, ["class"=>"form-control"]) !!}
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            {!! Form::label('id_cat2',"Segundo criterio") !!}
                            {!! Form::select('id_cat2', $lis_cat, null, ["class"=>"form-control"]) !!}
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <br>
                            <button class="btn btn-success" onclick="calcular_concurrencia()">Analizar concurrencia</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="float-right">
                            <a class='btn btn-secondary btn-xs  '  style='display: none' href="#" id="b_tabla_concurrencia_impactos"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>
                        </div>
                    </div>
                </div>
                <div class="w-100"></div>
                <div class="row">
                    <div  class="col">
                        <table class="table table-condensed table-bordered table-hover" id="tabla_concurrencia_impactos">
                            <thead></thead>
                            <tbody></tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div id="tabla_concurrencia_impactos_chi"></div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                Respuestas recolectadas en un total de {{ $datos->violencia->total_entrevistas }} entrevistas.
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <p><i class="fas fa-hand-point-right"></i>La información mostrada a partir de este punto, representa criterios que coinciden en un mismo hecho de violencia.
            @if($filtros->hay_filtro)
                Los filtros especificados se convierten en una tercera dimensión aplicada en el cálculo de estos cuadros.
            @endif
        </p>
        <p><i class="fas fa-hand-point-right"></i> Todos los cuadros corresponden a respuestas recolectadas de un total de <span class="text-primary">{{ $datos->violencia->total_hechos }} hechos de violencia.</span></p>
    </div>
</div>
<div class="row">

    @php($i=0)
    @foreach($datos->concurrencia as $id => $info)

        <div class="col-sm-6">
            @include("fichas.stats.p_tabla_concurrencia",
                                    ['info_titulo' => $info->descripcion
                                       , 'info_tabla' => $info
                                       , 'tabla_nombre' => 'concurrencia_'.$id
                                       , 'tabla_pie' => 'Respuestas recolectadas en un total de '.$datos->violencia->total_hechos.' hechos de violencia'
                                        ]
                               )

        </div>

        @if($id == 3 )
            <div class="w-100"></div>
        @endif

    @endforeach

</div>


@push("js")
    <script>
        function calcular_concurrencia() {

            var url =  "{!!   action('fichasController@json_concurrencia_impactos')."?".$filtros->url !!}";


            var c1 = $("#id_cat1").val();
            var c2 = $("#id_cat2").val();
            url = url+"&id_c1="+c1+"&id_c2="+c2;
            //alert( url);
            Swal.fire({
                title: "",
                text: "Calculando concurrencia indicada, gracias por su paciencia.",
                showConfirmButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            });
            //console.log("Actualizando graficas de procesamiento");
            $.getJSON( url)
                .done(function( json ) {
                    json_victima = json;
                    //console.log(json);
                    actualizar_tabla_concurrencia_impactos(json);
                    swal.close()
                })
                .fail(function( jqxhr, textStatus, error ) {
                    var err = textStatus + ", " + error;
                    console.log( "Problema al leer los datos, ajax concurrencia:" + err );
                });
        }

        function actualizar_tabla_concurrencia_impactos(datos) {
            var tabla= 'tabla_concurrencia_impactos';
            var thead =$("#"+tabla+" > thead");
            var tbody =$("#"+tabla+" > tbody");
            var tfoot =$("#"+tabla+" > tfoot");
            //Vaciar tabla
            $("#"+tabla+" tr").remove();

            var i =1;
            var total=datos.total;
            //console.log("total: "+total);

            var porcentaje=0;
            $.each(datos.datos, function( index, concurrencia ) {
                if(total>0) {
                    porcentaje = concurrencia.conteo/total * 100;
                }
                var fila = "<tr><td>"+i+"</td><td>"+concurrencia.c1+"</td><td>"+concurrencia.c2+"</td><td class='text-center'>"+concurrencia.conteo+"</td><td class='text-center'>"+porcentaje.toFixed(1)+"</td></tr>";

                tbody.append(fila);
                i=i+1;

                //var fila = [i,value,objeto.datos[index]];
                //a_datos.push(fila);
            });
            //Pie
            var fila = "<tr><td> &nbsp; </td><th colspan=2>Total</th><th class='text-center'>"+total+"</th><th class='text-center'>100%</th></tr>";
            tfoot.append(fila);
            //Head
            var fila = "<tr><th>#</th><th>"+datos.c1+"</th><th>"+datos.c2+"</th><th>conteo</th><th>%</th></tr>";
            thead.append(fila);

            if(total>0) {
                $("#b_tabla_concurrencia_impactos").show();
            }
            else {
                $("#b_tabla_concurrencia_impactos").hide();
            }

            //Chi cuadrado
            var chi = "Prueba de chi cuadrado: <ul>";
            chi = chi + "<li>Valor de chi cuadrado para la tabla mostrada: "+datos.chi.chi+"</li>";
            chi = chi + "<li>Valor de la tabla de chi cuadrado para "+datos.chi.grados_libertad+" grados de libertad y significancia de "+datos.chi.significancia+": "+datos.chi.tabla_chi+"</li>";
            chi = chi + "<li>Conclusión: "+datos.chi.conclusion_color+"</li>";
            chi = chi + "</ul>";
            $("#tabla_concurrencia_impactos_chi").html(chi);

            //


            {{--
            var tabla_html = $("#"+tabla);
            var tmp = tabla_html.DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
            --}}

        }

        $("#b_tabla_concurrencia_impactos").on('click', function(event) {
            $("#tabla_concurrencia_impactos").table2excel({
                name: "CEV",
                //filename: "sat_problemas_" + new Date().toISOString().replace(/[\-\:\.]/g, "").substring(0,8),
                filename: "datos_concurrencia_impactos_" + new Date().toLocaleString("en-GB", {timeZone: "America/Bogota"}).replace(/[\-\:\.]/g, "").substring(0,10)+ ".xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        });
    </script>


@endpush