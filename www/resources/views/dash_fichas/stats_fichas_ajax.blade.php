@php($colapsar_menu=true)
@extends('layouts.app')

@push("css")
    <style>
        .grafica { width: 100%; height:350px; }
    </style>
@endpush

@section('content_header')
    @include("dash_fichas.frm_filtro_fichas")

@endsection

@section('content')

    {{-- TOP de cuadritos --}}
    <div class="row">
        <div class="col-sm-10">
            <div class="row">
                {{--
                <div class="col-md-3">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ number_format($datos->conteos->personas_entrevistadas,0,",",".") }}</h3>
                            <p>Personas entrevistadas.</span></p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-comment"></i>
                        </div>
                    </div>
                </div>
                --}}
                <div class="col-md-3">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ number_format($datos->conteos->violencias,0,",",".") }}</h3>
                            <p>Violencias en {{  number_format($datos->conteos->hechos,0,",",".") }} eventos</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-bolt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ number_format($datos->conteos->victimas_total,0,",",".") }}</h3>
                            <p>Víctimas totales</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
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
                                <i class="fa fa-user-tag"></i>
                            </div>
                        </div>
                    </div>

                <div class="col-md-3">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ number_format($datos->conteos->personas,0,",",".") }}</h3>
                            <p>Personas identificadas</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-id-card"></i>
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
                        <i class="fa fa-lightbulb-o"></i> ¿Qué implican estas cifras?
                    </a>
                    @if(strlen($filtros->fecha_corte)==10)
                        <br>
                        Datos previos al {{ $filtros->fecha_corte }}
                    @endif
                </div>
                <!-- /.direct-chat-text -->
            </div>

        </div>
    </div>



    {{-- Tabs --}}
    <div class="row">
        <section class="col-xs-12 ">
            <div class="nav-tabs-custom" >
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right ui-sortable-handle" id="myTabs">
                    <li class="" id="t_exilio"><a href="#exilio" data-toggle="tab" aria-expanded="false">Exilio</a></li>
                    <li class="" id="t_impactos"><a href="#impactos" data-toggle="tab" aria-expanded="false">Impactos y afrontamiento</a></li>
                    <li class="" id="t_contexto"><a href="#contexto" data-toggle="tab" aria-expanded="false">Dinámicas y contexto</a></li>
                    <li class="" id="t_violencia"><a href="#violencia" data-toggle="tab" aria-expanded="false">Violencia</a></li>
                    <li class="" id="t_pri"><a href="#pri" data-toggle="tab" aria-expanded="false">Presunto responsable</a></li>
                    <li class="" id="t_victima"><a href="#victima" data-toggle="tab" aria-expanded="false">Víctimas</a></li>
                    <li class="active" id="t_entrevistada"><a href="#entrevistada" data-toggle="tab" aria-expanded="true">Persona entrevistada</a></li>
                    <li class="" id="t_procesamiento"><a href="#procesamiento" data-toggle="tab" aria-expanded="true">Procesamiento</a></li>

                    <li class="pull-left header text-primary visible-lg-block"><i class="fa fa-pie-chart"></i> Estadísticas generales</li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane " id="procesamiento" style="min-height: 300px;">
                        @include('dash_fichas.procesamiento')
                        <div class="clearfix"></div>
                    </div>

                    <div class="tab-pane active " id="entrevistada" style="min-height: 300px;">
                        @include('dash_fichas.entrevistada')
                        <div class="clearfix"></div>
                    </div>

                    <div class="tab-pane" id="victima" style=" min-height: 300px;">
                        @include('dash_fichas.victima')
                        <div class="clearfix"></div>
                    </div>

                    <div class="tab-pane" id="pri" style=" min-height: 300px;">
                        @include('dash_fichas.pri')
                        <div class="clearfix"></div>
                    </div>

                    <div class="tab-pane active" id="violencia" style=" min-height: 300px;">
                        @include('dash_fichas.violencia')
                        <div class="clearfix"></div>
                    </div>
                    <div class="tab-pane" id="contexto" style=" min-height: 300px;">
                        @include('dash_fichas.contexto')
                        <div class="clearfix"></div>
                    </div>

                    <div class="tab-pane" id="impactos" style=" min-height: 300px;">
                        @include('dash_fichas.impactos')
                        <div class="clearfix"></div>
                    </div>

                    <div class="tab-pane" id="exilio" style=" min-height: 300px;">
                        @include('dash_fichas.exilio')
                        <div class="clearfix"></div>
                    </div>

                </div>
            </div>
        </section>
    </div>
    <div class="clearfix"></div>


    {{-- Listado de graficos --}}
    <script>
        var a_chart = [];


    </script>
@endsection

{{-- Este script lo usan todas las pestañas --}}
@push("js")
    <script>
        function actualizar_tabla(tabla,objeto,filtro=false) {
            //console.log(objeto.categorias);
            var tbody =$("#"+tabla+" > tbody");
            var tfoot =$("#"+tabla+" > tfoot");
            //console.log(tabla);
            var i =1;
            var total=0;
            $.each(objeto.categorias, function( index, value ) {
                if(filtro) {
                    var fila = "<tr><td>"+i+"</td><td>"+value+"</td><td class='text-center'><a href='"+filtro+index+"'>"+objeto.datos[index]+"</a></td></tr>";
                }
                else {
                    var fila = "<tr><td>"+i+"</td><td>"+value+"</td><td class='text-center'>"+objeto.datos[index]+"</td></tr>";
                }

                tbody.append(fila);
                i=i+1;
                total = total + objeto.datos[index];
            });

            var fila = "<tr><td> &nbsp; </td><th>Total</th><th class='text-center'>"+total+"</th></tr>";
            tfoot.append(fila);

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
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
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
                corregir_grafico();
            });

        });

        //Mostrar "procesamiento" por default.
        //Debe ser una distinta a la activa del html para que se dispare el actualizador respectivo
        $(function() {
            $('#myTabs a[href="#procesamiento"]').tab('show')
        });
    </script>


@endpush
