@php($colapsar_menu = true)
@extends('layouts.app')

@push("css")
    <style>
        .grafica { width: 100%; height:350px; }
    </style>
@endpush

@section('content_header')
    <div class="col-md-3">
        <a href="{{ action("entrevista_individualController@index") }}">
        <div class="info-box ">
            <span class="info-box-icon bg-blue"><i class="fa fa-flag"></i></span>
            <div class="info-box-content" title="Transcritas / etiquetadas: {{ $datos->conteos->a_transcritas['vi'] }} /  {{ $datos->conteos->a_etiquetadas['vi'] }}" data-toggle="tooltip">
                <span >VI: Entrevistas a víctimas<span class="hidden">, familiares o testigos. </span></span>
                <span class="info-box-number">{{ number_format($datos->conteos->vi,0,",",".") }}</span>
                 <span class="hidden-xs hidden-sm hidden-md text-muted"> {{ $datos->conteos->entrevistadores }} entrevistadores</span>
            </div>
        </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ action("entrevista_individualController@index") }}?id_subserie={{ config('expedientes.aa') }}">
        <div class="info-box ">
            <span class="info-box-icon bg-blue"><i class="fa fa-user-secret"></i></span>
            <div class="info-box-content" title="Transcritas / etiquetadas: {{ $datos->conteos->a_transcritas['aa'] }} /  {{ $datos->conteos->a_etiquetadas['aa'] }}" data-toggle="tooltip">
                <span >AA: Entrevistas a <br>actores armados</span>
                <span class="info-box-number">{{ number_format($datos->conteos->aa,0,",",".") }}</span>
            </div>
        </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ action("entrevista_individualController@index") }}?id_subserie={{ config('expedientes.tc') }}">
        <div class="info-box " title="Transcritas / etiquetadas: {{ $datos->conteos->a_transcritas['tc'] }} /  {{ $datos->conteos->a_etiquetadas['tc'] }}" data-toggle="tooltip">
            <span class="info-box-icon bg-blue"><i class="fa fa-user-circle"></i></span>
            <div class="info-box-content">
                <span >TC: Entrevistas a <br>terceros civiles</span>
                <span class="info-box-number">{{ number_format($datos->conteos->tc,0,",",".") }}</span>
            </div>
        </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ action("entrevista_profundidadController@index") }}?id_subserie={{ config('expedientes.pr') }}">
        <div class="info-box " title="Transcritas / etiquetadas: {{ $datos->conteos->a_transcritas['pr'] }} /  {{ $datos->conteos->a_etiquetadas['pr'] }}" data-toggle="tooltip">
            <span class="info-box-icon bg-blue"><i class="fa fa-handshake-o"></i></span>
            <div class="info-box-content">
                <span >PR: Entrevistas a profundidad</span>
                <span class="info-box-number">{{ number_format($datos->conteos->pr,0,",",".") }}</span>
            </div>
        </div>
        </a>
    </div>
    <div class="clearfix"></div>

    {{-- Segunda fila --}}
    <div class="col-md-3">
        <a href="{{ action("entrevista_colectivaController@index") }}?id_subserie={{ config('expedientes.co') }}">
        <div class="info-box " title="Transcritas / etiquetadas: {{ $datos->conteos->a_transcritas['co'] }} /  {{ $datos->conteos->a_etiquetadas['co'] }}" data-toggle="tooltip">
            <span class="info-box-icon bg-aqua"><i class="fa fa-wechat"></i></span>
            <div class="info-box-content">
                <span >CO: Entrevistas colectivas</span>
                <span class="info-box-number">{{ number_format($datos->conteos->co,0,",",".") }}</span>
            </div>
        </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ action("entrevista_etnicaController@index") }}?id_subserie={{ config('expedientes.ee') }}">
        <div class="info-box " title="Transcritas / etiquetadas: {{ $datos->conteos->a_transcritas['ee'] }} /  {{ $datos->conteos->a_etiquetadas['ee'] }}" data-toggle="tooltip">
            <span class="info-box-icon bg-aqua"><i class="fa fa-comments-o"></i></span>
            <div class="info-box-content">
                <span >EE: Entrevistas a sujetos colectivos</span>
                <span class="info-box-number">{{ number_format($datos->conteos->ee,0,",",".") }}</span>
            </div>
        </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ action("diagnostico_comunitarioController@index") }}?id_subserie={{ config('expedientes.dc') }}">
        <div class="info-box " title="Transcritas / etiquetadas: {{ $datos->conteos->a_transcritas['dc'] }} /  {{ $datos->conteos->a_etiquetadas['dc'] }}" data-toggle="tooltip">
            <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
                <span >DC: Diagnósticos comunitarios</span>
                <span class="info-box-number">{{ number_format($datos->conteos->dc,0,",",".") }}</span>
            </div>
        </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ action("historia_vidaController@index") }}?id_subserie={{ config('expedientes.hv') }}">
        <div class="info-box " title="Transcritas / etiquetadas: {{ $datos->conteos->a_transcritas['hv'] }} /  {{ $datos->conteos->a_etiquetadas['hv'] }}" data-toggle="tooltip">
            <span class="info-box-icon bg-blue"><i class="fa fa-street-view"></i></span>
            <div class="info-box-content">
                <span >HV: Historias de vida</span>
                <span class="info-box-number">{{ number_format($datos->conteos->hv,0,",",".") }}</span>
            </div>
        </div>
        </a>
    </div>

    {{-- Tercera fila --}}
    <div class="clearfix"></div>
    <div class="col-md-3">
        <div class="info-box ">
            <span class="info-box-icon bg-yellow"><i class="fa fa-comments"></i></span>
            <div class="info-box-content">
                <span >Personas escuchadas</span>
                <span class="info-box-number">{{ number_format($datos->conteos->entrevistados->total,0,",",".") }}</span>
                <span class="text-muted hidden-xs hidden-sm hidden-md">{{ number_format($datos->conteos->entrevistas_total,0,",",".") }} entrevistas en total</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box ">
            <span class="info-box-icon bg-yellow"><i class="fa fa-headphones"></i></span>
            <div class="info-box-content">
                <span >Entrevistas transcritas</span>
                @if($datos->conteos->entrevistas_total > 0)
                    <span class="info-box-number" data-toggle="tooltip" title="{{ number_format($datos->conteos->transcripcion->entrevistas/$datos->conteos->entrevistas_total *100, 0 ,"," ,".") }}%">{{ number_format($datos->conteos->transcripcion->entrevistas,0,",",".") }}</span>
                    <span class="text-muted hidden-xs hidden-sm hidden-md" data-toggle="tooltip" title="{{ number_format($datos->conteos->etiquetadas/$datos->conteos->entrevistas_total *100, 0 ,"," ,".") }}%" data-placement="bottom" >{{ number_format($datos->conteos->etiquetadas,0,",",".") }} entrevistas etiquetadas</span>
                @else
                    <span class="info-box-number">{{ number_format($datos->conteos->transcripcion->entrevistas,0,",",".") }}</span>
                    <span class="text-muted hidden-xs hidden-sm hidden-md" >{{ number_format($datos->conteos->etiquetadas,0,",",".") }} entrevistas etiquetadas</span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box ">
            <span class="info-box-icon bg-yellow"><i class="fa fa-clock-o"></i></span>
            <div class="info-box-content">
                <span >Tiempo transcrito</span>
                <span class="info-box-number">{{ $datos->conteos->transcripcion->minutos_horas }}</span>
                <span class="text-muted hidden-xs hidden-sm hidden-md">{{ $datos->conteos->transcripcion->promedio_horas }} duración promedio de c/entrevista</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box ">
            <span class="info-box-icon bg-green"><i class="fa fa-check-square-o"></i></span>
            <div class="info-box-content">
                @if($datos->conteos->vi > 0)
                    <span >Entrevistas a víctimas procesadas y cerradas</span>
                    <span class="info-box-number" data-toggle="tooltip" title="{{ number_format($datos->conteos->cerradas / $datos->conteos->vi *  100, 0)  }} %">{{ number_format($datos->conteos->cerradas,0,",",".")  }}</span>
                @else
                    <span >Entrevistas a víctimas procesadas y cerradas</span>
                    <span class="info-box-number">{{ number_format($datos->conteos->cerradas,0,",",".")  }}</span>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('content')



    {{-- Fin de los cuadritos --}}

    {{-- Filtros --}}
    <section>
        @can('nivel-1-2-3')
            @include("entrevista_individuals.frm_filtro")
        @endcan
    </section>

    {{--  Graficas de tiempo --}}
    {{-- Gráficas --}}
    <div class="row">
        <div class="col-sm-6">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                        Cantidad de entrevistas realizadas por día
                    </h3>
                </div>
                <div class="box-body">
                    <div id="g_dia" class="grafica">
                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                        <span class="sr-only">Cargando...</span>
                        Reportes por día
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                        Cantidad de entrevistas por macroterritorio
                    </h3>
                </div>
                <div class="box-body">
                    <div id="g_macro" class="grafica">
                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                        <span class="sr-only">Cargando...</span>
                        Reportes por macroterritorio
                    </div>
                </div>
                <div class="box-footer">

                    @include("partials.tabla_datos_stack_3", ['tabla_datos' => $datos->macro
                                                       , 'tabla_titulo'=>'Entrevistas por macroterritorio '
                                                       ,'tabla_click'=>action("entrevista_individualController@index")."?$filtros->url&id_macroterritorio"
                                                       ,'tabla_nombre'=>'t_macro'])

                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12">

        </div>
    </div>



    <div class="row">
        <div class="col-sm-6">

        </div>



    </div>
    <div class="clearfix"></div>
    {{-- Super tabla, de avance y procesamiento por territorio--}}
    <div class="row">
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
                            <tr >
                                <th colspan="2" class="text-center">Ubicación</th>
                                <th colspan="9" class="text-center">Entrevistas realizadas</th>
                                <th colspan="2" class="text-center bg-gray">Procesamiento</th>
                                <th colspan="9" class="text-center">Personas escuchadas</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th> <th></th> <th></th> <th></th> <th></th> <th></th> <th></th> <th></th> <th></th>
                                <th></th>
                                <th></th> <th></th> <th></th> <th></th> <th></th> <th></th> <th></th> <th></th> <th></th>
                            </tr>
                            <tr>
                                <th>Macroterritorio</th>
                                <th>Territorio</th>
                                @foreach($datos->territorio->tipos_entrevista as $id_tipo => $txt_tipo)
                                    <th>{{ $txt_tipo }}</th>
                                @endforeach
                                <th>Total</th>
                                <th class="bg-gray">Transcritas</th>
                                <th class="bg-gray">Etiquetadas</th>
                                @foreach($datos->territorio->tipos_entrevista as $id_tipo => $txt_tipo)
                                    <th>{{ $txt_tipo }}</th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($datos->territorio->estructura as $id_macro => $detalle)
                            <tr>
                                <th>{{ $detalle['nombre'] }}</th>
                                <th>&nbsp;</th>
                                @foreach($datos->territorio->tipos_entrevista as $id_tipo => $txt_tipo)
                                    <th>{{ $datos->territorio->entrevistas->datos_macro[$id_macro][$id_tipo] }}</th>
                                @endforeach
                                <th>{{ $datos->territorio->entrevistas->totales_macro[$id_macro] }}</th>
                                {{-- Procesamiento --}}
                                <th class="text-center bg-gray">{{ $datos->territorio->transcritas_macro[$id_macro] }}</th>
                                <th class="text-center bg-gray">{{ $datos->territorio->etiquetadas_macro[$id_macro] }}</th>
                                {{-- --}}
                                @foreach($datos->territorio->tipos_entrevista as $id_tipo => $txt_tipo)
                                    <th>{{ $datos->territorio->personas->datos_macro[$id_macro][$id_tipo] }}</th>
                                @endforeach
                                <th>{{ $datos->territorio->personas->totales_macro[$id_macro] }}</th>
                            </tr>
                            @foreach($detalle['hijos'] as $id_territorio => $texto)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>{{ $texto }}</td>
                                    @foreach($datos->territorio->tipos_entrevista as $id_tipo => $txt_tipo)
                                        <td>{{ $datos->territorio->entrevistas->datos[$id_territorio][$id_tipo] }}</td>
                                    @endforeach
                                    <td>{{ $datos->territorio->entrevistas->totales[$id_territorio] }}</td>
                                    {{-- Procesamiento --}}
                                    <td class="text-center bg-gray">{{ $datos->territorio->transcritas[$id_territorio] }}</td>
                                    <td class="text-center bg-gray">{{ $datos->territorio->etiquetadas[$id_territorio] }}</td>
                                    {{-- --}}
                                    @foreach($datos->territorio->tipos_entrevista as $id_tipo => $txt_tipo)
                                        <td>{{ $datos->territorio->personas->datos[$id_territorio][$id_tipo] }}</td>
                                    @endforeach
                                    <td>{{ $datos->territorio->personas->totales[$id_territorio] }}</td>

                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
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


    {{-- Sección: entrevistas VI --}}
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">{{ \App\Models\cat_item::find(config('expedientes.vi'))->descripcion }}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_ret"><i class="fa fa-minus"></i> </button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-solid box-primary">
                        <div class="box-header">
                            <h3 class="box-title">
                                Cantidad de entrevistas según entrevistador
                            </h3>
                        </div>
                        <div class="box-body">
                            <div id="g_entrevistador" class="grafica">
                                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                                <span class="sr-only">Cargando...</span>
                                Reportes por entrevistador
                            </div>
                        </div>
                        <div class="box-footer">
                            @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->entrevistador
                                                                    , 'tabla_titulo'=>'Entrevistas por entrevistador'
                                                                    ,'tabla_click'=>action("entrevista_individualController@index")."?$filtros->url&id_entrevistador"
                                                                    ,'tabla_nombre'=>'t_entrevistador'])
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="box box-solid box-primary">
                        <div class="box-header">
                            <h3 class="box-title">
                                Cantidad de entrevistas según grupo al que pertenece el entrevistador
                            </h3>
                        </div>
                        <div class="box-body">
                            <div id="g_entrevistador_grupo" class="grafica">
                                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                                <span class="sr-only">Cargando...</span>
                                Reportes por grupo del entrevistador
                            </div>
                        </div>
                        <div class="box-footer">
                            @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->entrevistador_grupo
                                                               , 'tabla_titulo'=>'Entrevistas por grupo '
                                                               ,'tabla_click'=>action("entrevista_individualController@index")."?$filtros->url&id_grupo"
                                                               ,'tabla_nombre'=>'t_grupo'])
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Distribución por Responsable/Participante
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_fr" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por Responsable/Participante
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->fr
                                                           , 'tabla_titulo'=>'Entrevistas por responsable/participante '
                                                           ,'tabla_click'=>action("entrevista_individualController@index")."?$filtros->url&fr"
                                                           ,'tabla_nombre'=>'t_responsable'])
                    </div>
                </div>
            </div>

            <div class="col-sm-6" >
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Distribución por Violencia mencionada
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_tv" class="grafica" style="height: 500px">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por Tipo de Violación
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->tv
                                                           , 'tabla_titulo'=>'Entrevistas por tipo de violencia '
                                                           ,'tabla_click'=>action("entrevista_individualController@index")."?$filtros->url&tv"
                                                           ,'tabla_nombre'=>'t_violencia'])
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Cantidad de entrevistas según su clasificación de acceso
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_clasificacion" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Reportes por clasificacion de acceso
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->clasificacion
                                                           , 'tabla_titulo'=>'Entrevistas por clasificación de acceos '
                                                           //,'tabla_click'=>action("entrevista_individualController@index")."?$filtros->url&id_grupo"
                                                           ,'tabla_nombre'=>'t_acceso'])
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Sección AA --}}
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">{{ \App\Models\cat_item::find(config('expedientes.aa'))->descripcion }}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_ret"><i class="fa fa-minus"></i> </button>
            </div>
        </div>
        <div class="box-body">
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Actores en las que hace/hacía parte:
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_aa_fr" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por Fuerza
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Temas de la entrevista
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_aa" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por Temas de la entrevista
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SEcción TC --}}
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">{{ \App\Models\cat_item::find(config('expedientes.tc'))->descripcion }}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_ret"><i class="fa fa-minus"></i> </button>
            </div>
        </div>

        <div class="box-body">
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Sectores en los que hace/hacía parte:
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_stc" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por sector
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Temas de la entrevista
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_tc" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por Temas de la entrevista
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección PR --}}
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Entrevistas a profundidad</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_ret"><i class="fa fa-minus"></i> </button>
            </div>
        </div>

        <div class="box-body">
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Sectores en los que hace/hacía parte:
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_pr_sector" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por sector
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->profundidad->sector
                                                           , 'tabla_titulo'=>'Sector de persona entrevistada '
                                                           ,'tabla_click'=>action("entrevista_profundidadController@index")."?$filtros->url&id_sector"
                                                           ,'tabla_nombre'=>'t_pr_sector'])
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Tipo de entrevista
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_pr_tipo" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por tipo de entrevista
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->profundidad->tipo
                                                           , 'tabla_titulo'=>'Tipo de entrevista a profundidad '
                                                           ,'tabla_click'=>action("entrevista_profundidadController@index")."?$filtros->url&id_tipo"
                                                           ,'tabla_nombre'=>'t_pr_tipo'])
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- entrevistas etnicas --}}
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Entrevistas a sujeto colectivo</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_ret"><i class="fa fa-minus"></i> </button>
            </div>
        </div>

        <div class="box-body">
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Situación actual de la entrevista
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_ee_avance" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por avance
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->etnica->avance
                                                           , 'tabla_titulo'=>'Situación actual de la entrevista'
                                                           ,'tabla_click'=>action("entrevista_etnicaController@index")."?$filtros->url&entrevista_avance"
                                                           ,'tabla_nombre'=>'t_ee_avance'])
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Sectores en los que hace/hacía parte:
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_ee_sector" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por sector
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->etnica->sector
                                                           , 'tabla_titulo'=>'Sector '
                                                           ,'tabla_click'=>action("entrevista_etnicaController@index")."?$filtros->url&id_sector"
                                                           ,'tabla_nombre'=>'t_ee_sector'])
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Tipo de entrevista
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_ee_tipo" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por tipo
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->etnica->tipo
                                                           , 'tabla_titulo'=>'Tipo de entrevista'
                                                           ,'tabla_click'=>action("entrevista_etnicaController@index")."?$filtros->url&id_tipo_entrevista"
                                                           ,'tabla_nombre'=>'t_ee_tipo'])
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Tipo de sujeto colectivo
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_ee_tipo_sujeto" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por tipo de sujeto colectivo
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->etnica->tipo_sujeto
                                                           , 'tabla_titulo'=>'Tipo de sujeto colectivo '
                                                           ,'tabla_click'=>action("entrevista_etnicaController@index")."?$filtros->url&id_tipo_sujeto"
                                                           ,'tabla_nombre'=>'t_ee_tipo_sujeto'])
                    </div>
                </div>
            </div>


            <div class="clearfix"></div>
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Pueblos indígenas
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_ee_pueblo_i" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por pueblos indigenas
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->etnica->pueblo_i
                                                           , 'tabla_titulo'=>'Pueblos indígenas'
                                                           ,'tabla_click'=>action("entrevista_etnicaController@index")."?$filtros->url&id_indigena"
                                                           ,'tabla_nombre'=>'t_ee_pueblo_i'])
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Pueblos afro
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_ee_pueblo_a" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por pueblos afro
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->etnica->pueblo_a
                                                           , 'tabla_titulo'=>'Pueblos afro'
                                                           ,'tabla_click'=>action("entrevista_etnicaController@index")."?$filtros->url&id_narp"
                                                           ,'tabla_nombre'=>'t_ee_pueblo_a'])
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Kumpany rrom
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_ee_pueblo_r" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por kumpany
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->etnica->pueblo_r
                                                           , 'tabla_titulo'=>'Kumpany rrom'
                                                           ,'tabla_click'=>action("entrevista_etnicaController@index")."?$filtros->url&id_rrom"
                                                           ,'tabla_nombre'=>'t_ee_pueblo_r'])
                    </div>
                </div>
            </div>


            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Número de personas escuchadas en la entrevista
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_ee_cantidad" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por número de personas escuchadas en la entrevista
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->etnica->cantidad
                                                           , 'tabla_titulo'=>'Número de personas escuchadas en la entrevista '
                                                           ,'tabla_click'=>action("entrevista_etnicaController@index")."?$filtros->url&cantidad_participantes"
                                                           ,'tabla_nombre'=>'t_ee_cantidad'])
                    </div>
                </div>
            </div>


        </div>
    </div>


    {{-- entrevistas colectivas --}}
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Entrevistas colectivas</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_ret"><i class="fa fa-minus"></i> </button>
            </div>
        </div>

        <div class="box-body">
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Situación actual de la entrevista
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_co_avance" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por avance
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->colectiva->avance
                                                           , 'tabla_titulo'=>'Situación actual de la entrevista'
                                                           ,'tabla_click'=>action("entrevista_colectivaController@index")."?$filtros->url&entrevista_avance"
                                                           ,'tabla_nombre'=>'t_co_avance'])
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Sectores en los que hace/hacía parte:
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_co_sector" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por sector
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->colectiva->sector
                                                           , 'tabla_titulo'=>'Sector '
                                                           ,'tabla_click'=>action("entrevista_colectivaController@index")."?$filtros->url&id_sector"
                                                           ,'tabla_nombre'=>'t_co_sector'])
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Número de personas escuchadas en la entrevista
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_co_cantidad" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por número de personas escuchadas en la entrevista
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->colectiva->cantidad
                                                           , 'tabla_titulo'=>'Número de personas escuchadas en la entrevista '
                                                           ,'tabla_click'=>action("entrevista_colectivaController@index")."?$filtros->url&cantidad_participantes"
                                                           ,'tabla_nombre'=>'t_co_cantidad'])
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Diagnosticos comunitarios --}}
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Diagnósticos comunitarios</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_ret"><i class="fa fa-minus"></i> </button>
            </div>
        </div>

        <div class="box-body">
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Sectores en los que hace/hacía parte:
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_dc_sector" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por avance
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->dc->sector
                                                           , 'tabla_titulo'=>'Sectores en los que hace/hacía parte'
                                                           ,'tabla_click'=>action("diagnostico_comunitarioController@index")."?$filtros->url&id_sector"
                                                           ,'tabla_nombre'=>'t_dc_sector'])
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Entrevistas por departamento del diagnóstico
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_dc_depto" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Entrevistas por departamento
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->dc->depto
                                                           , 'tabla_titulo'=>'Departamento del diagnóstico'
                                                           ,'tabla_click'=>action("diagnostico_comunitarioController@index")."?$filtros->url&tema_lugar_depto"
                                                           ,'tabla_nombre'=>'t_dc_depto'])
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Número de personas escuchadas en la entrevista
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_dc_cantidad" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por número de personas escuchadas en la entrevista
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->dc->cantidad
                                                           , 'tabla_titulo'=>'Número de personas escuchadas en la entrevista '
                                                           ,'tabla_click'=>action("diagnostico_comunitarioController@index")."?$filtros->url&cantidad_participantes"
                                                           ,'tabla_nombre'=>'t_dc_cantidad'])
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Historia de vida --}}
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Historias de vida</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_ret"><i class="fa fa-minus"></i> </button>
            </div>
        </div>

        <div class="box-body">
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Sectores en los que hace/hacía parte:
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_hv_sector" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por sector
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->hv->sector
                                                           , 'tabla_titulo'=>'Sectores en los que hace/hacía parte'
                                                           ,'tabla_click'=>action("historia_vidaController@index")."?$filtros->url&id_sector"
                                                           ,'tabla_nombre'=>'t_hv_sector'])
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Entrevistas por sexo de la persona entrevistada
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_hv_sexo" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Entrevistas por sexo de la persona entrevistada
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->hv->sexo
                                                           , 'tabla_titulo'=>'Sexo de la persona entrevistada'
                                                           ,'tabla_click'=>action("historia_vidaController@index")."?$filtros->url&id_sexo"
                                                           ,'tabla_nombre'=>'t_hv_sexo'])
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Pertenencia étnico racial
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_hv_etnia" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Entrevistas por pertenencia étnico racial
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->hv->etnia
                                                           , 'tabla_titulo'=>'Pertenencia étnico racial'
                                                           ,'tabla_click'=>action("historia_vidaController@index")."?$filtros->url&id_pertenencia_etnico_racial"
                                                           ,'tabla_nombre'=>'t_hv_etnia'])
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Casos e informes --}}
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Casos e informes</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_ret"><i class="fa fa-minus"></i> </button>
            </div>
        </div>

        <div class="box-body">
            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Tipo de organización que realiza la entrega
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_ci_remitente" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Distribución por tipo de organización
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->ci->remitente
                                                           , 'tabla_titulo'=>'Remitente: tipo de organización'
                                                           ,'tabla_click'=>action("casos_informesController@index")."?$filtros->url&remitente_id_tipo_organizacion"
                                                           ,'tabla_nombre'=>'t_ci_remitente'])
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            Clasificación
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="g_ci_tipo" class="grafica">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                            Caracterización: clasificacion
                        </div>
                    </div>
                    <div class="box-footer">
                        @include("partials.tabla_datos_arreglo", ['tabla_datos' => $datos->ci->tipo
                                                           , 'tabla_titulo'=>'Clasificación'
                                                           ,'tabla_click'=>action("casos_informesController@index")."?$filtros->url&caracterizacion_id_tipo"
                                                           ,'tabla_nombre'=>'t_ci_tipo'])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>



@endsection


@push("js")

    <script type="text/javascript">

        var a_chart = [];




        $(function () {
            var myChart = echarts.init(document.getElementById('g_dia'), 'light');
            var option = {!! $datos->g_dia !!};
            myChart.setOption(option);
            a_chart.push(myChart);
            myChart.on('click', function (params) {
                document.location='{{ url('entrevistaIndividuals') }}'+'{!!   '?'.$filtros->url_sin_fechas !!}'+'entrevista_del_submit='+params.name+'&entrevista_al_submit='+params.name;
            });
        });

        $(function () {
            var myChart = echarts.init(document.getElementById('g_entrevistador'), 'light');
            var option = {!! $datos->g_entrevistador !!};
            myChart.setOption(option);
            a_chart.push(myChart);
            myChart.on('click', function (params) {
                document.location='{{ url('entrevistaIndividuals') }}'+'{!!   '?'.$filtros->url !!}'+'id_entrevistador='+params.name;
            });
        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_entrevistador_grupo'), 'light');
            var option = {!! $datos->g_entrevistador_grupo !!};
            myChart.setOption(option);
            a_chart.push(myChart);
            myChart.on('click', function (params) {
                document.location='{{ url('entrevistaIndividuals') }}'+'{!!   '?'.$filtros->url !!}'+'id_grupo='+params.name;
            });
        });

        $(function () {
            var myChart = echarts.init(document.getElementById('g_macro'), 'light');
            var option = {!! $datos->g_macro !!};
            myChart.setOption(option);
            a_chart.push(myChart);
            myChart.on('click', function (params) {
                document.location='{{ url('entrevistaIndividuals') }}'+'{!!   '?'.$filtros->url !!}'+'id_territorio_macro='+params.name;
            });
        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_clasificacion'), 'light');
            var option = {!! $datos->g_clasificacion !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });

        {{-- VI --}}
        $(function () {
            var myChart = echarts.init(document.getElementById('g_fr'), 'light');
            var option = {!! $datos->g_fr !!};
            myChart.setOption(option);
            a_chart.push(myChart);
            myChart.on('click', function (params) {
                document.location='{{ url('entrevistaIndividuals') }}'+'{!!   '?'.$filtros->url !!}'+'fr='+params.name;
            });
        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_tv'), 'light');
            var option = {!! $datos->g_tv !!};
            myChart.setOption(option);
            a_chart.push(myChart);
            myChart.on('click', function (params) {
                document.location='{{ url('entrevistaIndividuals') }}'+'{!!   '?'.$filtros->url !!}'+'tv='+params.name;
            });
        });
        {{-- AA --}}
        $(function () {
            var myChart = echarts.init(document.getElementById('g_aa_fr'), 'light');
            var option = {!! $datos->g_aa_fr !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_aa'), 'light');
            var option = {!! $datos->g_aa !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });
        {{-- TC --}}
        $(function () {
            var myChart = echarts.init(document.getElementById('g_stc'), 'light');
            var option = {!! $datos->g_stc !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_tc'), 'light');
            var option = {!! $datos->g_tc !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });

        {{-- PR --}}
        $(function () {
            var myChart = echarts.init(document.getElementById('g_pr_tipo'), 'light');
            var option = {!! $datos->profundidad->tipo->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_pr_sector'), 'light');
            var option = {!! $datos->profundidad->sector->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });

        {{-- EE --}}
        $(function () {
            var myChart = echarts.init(document.getElementById('g_ee_avance'), 'light');
            var option = {!! $datos->etnica->avance->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);

        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_ee_sector'), 'light');
            var option = {!! $datos->etnica->sector->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_ee_tipo'), 'light');
            var option = {!! $datos->etnica->tipo->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_ee_tipo_sujeto'), 'light');
            var option = {!! $datos->etnica->tipo_sujeto->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });

        $(function () {
            var myChart = echarts.init(document.getElementById('g_ee_pueblo_i'), 'light');
            var option = {!! $datos->etnica->pueblo_i->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_ee_pueblo_a'), 'light');
            var option = {!! $datos->etnica->pueblo_a->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_ee_pueblo_r'), 'light');
            var option = {!! $datos->etnica->pueblo_r->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_ee_cantidad'), 'light');
            var option = {!! $datos->etnica->cantidad->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });

        {{-- CO --}}
        $(function () {
            var myChart = echarts.init(document.getElementById('g_co_avance'), 'light');
            var option = {!! $datos->colectiva->avance->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_co_sector'), 'light');
            var option = {!! $datos->colectiva->sector->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_co_cantidad'), 'light');
            var option = {!! $datos->colectiva->cantidad->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });


        {{-- DC --}}

        $(function () {
            var myChart = echarts.init(document.getElementById('g_dc_sector'), 'light');
            var option = {!! $datos->dc->sector->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });

        $(function () {
            var myChart = echarts.init(document.getElementById('g_dc_depto'), 'light');
            var option = {!! $datos->dc->depto->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });

        $(function () {
            var myChart = echarts.init(document.getElementById('g_dc_cantidad'), 'light');
            var option = {!! $datos->dc->cantidad->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });

        {{-- HV --}}
        $(function () {
            var myChart = echarts.init(document.getElementById('g_hv_sector'), 'light');
            var option = {!! $datos->hv->sector->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });

        $(function () {
            var myChart = echarts.init(document.getElementById('g_hv_sexo'), 'light');
            var option = {!! $datos->hv->sexo->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });
        $(function () {
            var myChart = echarts.init(document.getElementById('g_hv_etnia'), 'light');
            var option = {!! $datos->hv->etnia->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });

        {{-- CI --}}
        $(function () {
            var myChart = echarts.init(document.getElementById('g_ci_tipo'), 'light');
            var option = {!! $datos->ci->tipo->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });

        $(function () {
            var myChart = echarts.init(document.getElementById('g_ci_remitente'), 'light');
            var option = {!! $datos->ci->remitente->grafica !!};
            myChart.setOption(option);
            a_chart.push(myChart);
        });

        function corregir_grafico() {
            console.log('resize');
            a_chart.forEach(element => element.resize());
        }

        window.onresize = function() {
            corregir_grafico();
        }







    </script>
@endpush

