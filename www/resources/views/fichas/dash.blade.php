@extends('layouts.app3')

@push("head")
    <style>
        .grafica { width: 100%; height:300px; }
    </style>
@endpush


@section('content')
    {{-- Cuadritos superiores --}}
    <div class="row">
        {{-- VICTIMA --}}
        <div class="col-lg-4 col-12 col-sm-6">
            <a href="{{ action('fichasController@victimas') }}">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Víctimas</span>
                        <span class="info-box-number"> <small>Buscar en </small>
                      {{ $datos->victimas }}
                      <small>fichas en el sistema</small>
                    </span>
                    </div>
                </div>
            </a>
        </div>
        {{-- P.E.  --}}
        <div class="col-lg-4 col-12 col-sm-6">
            <a href="{{ action('fichasController@persona_entrevistada') }}">
                <div class="info-box">
                    <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-comment"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Personas entrevistadas</span>
                        <span class="info-box-number"><small>Buscar en </small>
                        {{ $datos->persona_entrevistada }}
                            <small>fichas en el sistema</small>
                    </span>
                    </div>
                </div>
            </a>
        </div>

        {{-- PRI --}}
        <div class="col-lg-4 col-12 col-sm-6">
            <a href="{{ action('fichasController@pri') }}">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-vest-patches"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Presunto responsable individual</span>
                        <span class="info-box-number"><small>Buscar en </small>
                      {{ $datos->responsable_individual }}
                      <small>fichas en el sistema</small>
                    </span>
                    </div>
                </div>
            </a>
        </div>
        <!-- ./col -->

    </div>

    {{-- Grafico por Año de los hechos --}}
    <div class="row">
        <div class="col">
            @include("fichas.grafico",
                         ['info_titulo' =>"Hechos de violencia por año, registrada en $datos->entrevistas entrevistas a víctimas, familiares y testigos"

                            , 'info_div' => "g_violencia_anyo"
                            ]
                    )
        </div>
    </div>


    <div class="clearfix"></div>

@endsection



@push("js")
    {{-- Actualizar  --}}
    <script>
        {{-- Listado de graficos --}}
        var a_chart = [];

        //Hacerle un resize a todas las gráficas
        function corregir_grafico() {
            a_chart.forEach(element => element.resize());
        }

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
        var mirame;
        function actualizar_graficos_violencia(json) {
            mirame = json;
            console.log(mirame.anio.grafico);
            //Año de violencia
            chart_g_violencia_anyo.setOption(JSON.parse(json.anio.grafico));

            var cambios = {
                legend: {show:false},
                series : {color:'#663399'},
                //backgroundColor: '#2c343c',


            };
            chart_g_violencia_anyo.setOption(cambios);
            //actualizar_tabla("t_g_violencia_anyo",json.anio);

        }

        //Llamar al AJAX al cargar la pagina
        $(function() {
            actualizar_violencia();
        });



    </script>


@endpush
