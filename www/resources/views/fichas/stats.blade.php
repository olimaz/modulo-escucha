@extends('layouts.app3')

@php($con_sidebar = $filtros->hay_filtro)

@section('content_header')
    {{-- TOP de cuadritos --}}
    <div class="row">
        <div class="col-sm-10">
            <div class="row">
                {{--
                <div class="col-md-3">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ number_format($datos->conteos->personas_entrevistadas,0,",",".") }}</h3>
                            <p>Personas entrevistadas  </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-comment"></i>
                        </div>
                    </div>
                </div>
                --}}
                <div class="col-md-3">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($datos->conteos->hechos,0,",",".") }}</h3>
                            <p>Hechos con {{  number_format($datos->conteos->violencias,0,",",".") }} violencias</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ number_format($datos->conteos->victimas_total,0,",",".") }}</h3>
                            <p>Víctimas totales</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ number_format($datos->conteos->victimas_conocidas,0,",",".") }}</h3>
                            <p>Víctimas cuyos datos son conocidos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($datos->conteos->personas,0,",",".") }}</h3>
                            <p>Personas identificadas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                    </div>

                </div>



            </div>
        </div>
        <div class="col-sm-2">
            <div class="direct-chat-msg ">
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text ">
                    <a href="{{ action('fichasController@stats_comprension') }}" target="_blank">
                        <i class="far fa-lightbulb"></i> ¿Qué implican estas cifras?
                    </a>
                </div>
                <!-- /.direct-chat-text -->
                @if(strlen($filtros->fecha_corte)==10)
                    <br><div class="bg-yellow text-center ">
                        <span class="text-danger">
                            Datos previos al {{ $filtros->fecha_corte }}
                        </span>
                    </div>

                @endif
            </div>
        </div>
    </div>

    @include("fichas.stats_filtro")

@endsection

@section('content')





    {{-- Tabs  generales--}}
    <div class="row  ">
        <div class="col">
            @include("fichas.partials.tabs_general")
        </div>

    </div>
    <div class="w-100"></div>


    {{-- Listado de graficos --}}
    <script>
        var a_chart = [];


    </script>
@endsection

{{-- Mostrar criterios de filtrado en el sidebar derecho --}}
@include("fichas.partials.sidebar")

{{-- Este script lo usan todas las pestañas --}}
@push("js")
    <script>
        var datos_debug;
        function actualizar_tabla(tabla,objeto,filtro=false) {
            //console.log(objeto.categorias);
            var tbody =$("#"+tabla+" > tbody");
            var tfoot =$("#"+tabla+" > tfoot");
            //console.log(tabla);
            var i =1;
            var total=0;
            var a_datos=[];
            //Calcular total
            $.each(objeto.categorias, function( index, value ) {
                total = total + parseInt(objeto.datos[index]);
            })
            var porcentaje=0;
            $.each(objeto.categorias, function( index, value ) {
                if(total>0) {
                    porcentaje = objeto.datos[index]/total * 100;
                }


                if(filtro) {
                    var fila = "<tr><td>"+i+"</td><td>"+value+"</td><td class='text-center'><a href='"+filtro+index+"'>"+objeto.datos[index]+"</a></td><td class='text-center'>"+porcentaje.toFixed(1)+"</td></tr>";
                }
                else {
                    var fila = "<tr><td>"+i+"</td><td>"+value+"</td><td class='text-center'>"+objeto.datos[index]+"</td><td class='text-center'>"+porcentaje.toFixed(1)+"</td></tr>";
                }

                tbody.append(fila);
                i=i+1;
                //total = total + parseInt(objeto.datos[index]);
                var fila = [i,value,objeto.datos[index]];
                a_datos.push(fila);
            });

            var fila = "<tr><td> &nbsp; </td><th>Total</th><th class='text-center'>"+total+"</th><th class='text-center'>100%</th></tr>";
            tfoot.append(fila);
            //



            var tabla_html = $("#"+tabla);
            var tmp = tabla_html.DataTable({
                "language": {
                    "url": "{{ url('js/dataTables.spanish.lang') }}"
                },
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });


            //tmp.responsive.recalc();

            //console.log(objeto.datos);



        }
    </script>
@endpush

@push('js')
    <script>
        //Hacerle un resize a todas las gráficas
        function corregir_grafico() {
            a_chart.forEach(element => element.resize());
        }

        //Actualizar graficas por ajax
        var activo;

        $(function() {
            $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
                //corregir_grafico();
                activo=e.target.parentElement.id;

                //console.log(activo);
                if(activo=="t_procesamiento") {
                    actualizar_procesamiento();
                }
                if(activo=="t_entrevistada") {
                    actualizar_entrevistada();
                }
                if(activo=="t_victima") {
                    actualizar_victima();
                }

                if(activo=="t_pri") {
                    actualizar_pri();
                }
                if(activo=="t_violencia") {
                    actualizar_violencia();
                }
                if(activo=="t_exilio") {
                    actualizar_exilio();
                }
                if(activo=="t_3") {
                    // console.log("antes de actualizar violencia");
                    // actualizar_violencia();
                    // console.log("despues de actualizar violencia");
                    // $('[href="#violencia"]').tab('show');
                    // console.log("despues del show");
                    if(!ya_violencia) {
                        $('[href="#violencia"]').tab('show');
                    }

                }

                corregir_grafico();
            });

        });

        //Mostrar "procesamiento" por default.
        //Debe ser una distinta a la activa del html para que se dispare el actualizador respectivo
        $(function() {

            actualizar_procesamiento();

        });
    </script>




@endpush

@push("head")
    <style>
        .grafica { width: 100%; height:350px; }
    </style>
@endpush

