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
        <div class="col-md-3">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ number_format($datos->conteos->entrevistas,0,",",".") }}</h3>
                    <p>Entrevistas a víctimas<span class="hidden">, familiares o testigos.</p>
                </div>
                <div class="icon">
                    <i class="fa fa-flag"></i>
                </div>
            </div>


        </div>
        <div class="col-md-3">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ number_format($datos->conteos->estado[1],0,",",".") }}</h3>
                    <p>Entrevistas diligenciadas al 100%</p>
                </div>
                <div class="icon">
                    <i class="fa fa-battery-full"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ number_format($datos->conteos->estado[2],0,",",".") }}</h3>
                    <p>Entrevistas diligenciadas parcialmente</p>
                </div>
                <div class="icon">
                    <i class="fa fa-battery-three-quarters"></i>
                </div>
            </div>
        </div>
        @if(!$filtros->hay_filtro)
            <div class="col-md-3">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ number_format($datos->conteos->estado[0],0,",",".") }}</h3>
                        <p>Entrevistas sin diligenciar</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-battery-quarter"></i>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Tabs --}}
    <div class="row">
        <section class="col-xs-12 ">
            <div class="nav-tabs-custom" >
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="" id="t_exilio"><a href="#exilio" data-toggle="tab" aria-expanded="false">Exilio</a></li>
                    <li class="" id="t_impactos"><a href="#impactos" data-toggle="tab" aria-expanded="false">Impactos y afrontamiento</a></li>
                    <li class="" id="t_violencia"><a href="#contexto" data-toggle="tab" aria-expanded="false">Dinámicas y contexto</a></li>
                    <li class="active" id="t_violencia"><a href="#violencia" data-toggle="tab" aria-expanded="false">Violencia</a></li>
                    <li class="" id="t_pri"><a href="#pri" data-toggle="tab" aria-expanded="false">Presunto responsable</a></li>
                    <li class="" id="t_victima"><a href="#victima" data-toggle="tab" aria-expanded="false">Víctimas</a></li>
                    <li class="" id="t_entrevistado"><a href="#entrevistado" data-toggle="tab" aria-expanded="true">Persona entrevistada</a></li>
                    <li class="" id="t_diligenciadao"><a href="#diligenciada" data-toggle="tab" aria-expanded="true">Procesamiento</a></li>
                    <li class="pull-left header text-primary"><i class="fa fa-pie-chart"></i> Estadísticas generales</li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane " id="diligenciada" style="min-height: 300px;">
                        @include('dash_fichas.procesamiento')
                        <div class="clearfix"></div>
                    </div>
                    <div class="tab-pane " id="entrevistado" style="min-height: 300px;">
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

@push('js')
    <script>
        function corregir_grafico() {
            a_chart.forEach(element => element.resize());
        }

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            corregir_grafico();
        });

        //let activo = 'diligenciada';
        //$("#t_"+activo).addClass('active');
        //$("#"+activo).addClass('active');

    </script>


@endpush
