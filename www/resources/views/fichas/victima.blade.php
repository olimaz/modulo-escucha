@extends('layouts.app3')

@section('content_header')
    @include('fichas.victima_filtro')
@endsection
@section('content')
    <div class="row">
        {{-- Violencia --}}
        <div class="col">
            <div class="card card-primary card-outline ">

                <div class="card-header">
                    @if($filtros->id_tipo_listado==1)
                        <div class="row">
                            <div class="col-sm-3">
                                <h3 class="card-title"><i class="fas fa-users"></i> Listado de victimizaciones: {{ $total_filas }} resultados </h3>
                            </div>
                            <div class="col-sm-2">

                                <div class="direct-chat-msg right">
                                    <div class="direct-chat-text ">
                                        <a href="{{ action('fichasController@stats_comprension') }}" target="_blank">
                                            <i class="far fa-lightbulb"></i> ¿Qué implican estas opciones?
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center">
                                @include("fichas.partials.listados_victimas")
                            </div>
                            <div class="col-sm-2 text-right">
                                <a href="{{ action("fichasController@exportar_victima")."?".$filtros->url }}" class="btn btn-info btn-xs"><i class="far fa-file-excel"></i> Descargar excel con datos</a>
                            </div>

                        </div>

                    @elseif($filtros->id_tipo_listado==2)
                        <div class="row">
                            <div class="col-sm-3">
                                <h3 class="card-title"><i class="fas fa-user"></i> Listado de personas: {{ $total_filas }} resultados </h3>
                            </div>
                            <div class="col-sm-2">

                                <div class="direct-chat-msg right">
                                    <div class="direct-chat-text ">
                                        <a href="{{ action('fichasController@stats_comprension') }}" target="_blank">
                                            <i class="far fa-lightbulb"></i> ¿Qué implican estas opciones?
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center">
                                @include("fichas.partials.listados_victimas")
                            </div>
                            <div class="col-sm-2 text-right">
                                <a href="{{ action("fichasController@exportar_victima_persona")."?".$filtros->url }}" class="btn btn-info btn-xs"><i class="far fa-file-excel"></i> Descargar excel con datos</a>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-sm-3">
                                <h3 class="card-title"><i class="fas fa-comments"></i> Listado de entrevistas: {{ $total_filas }} resultados </h3>
                            </div>
                            <div class="col-sm-2">

                                <div class="direct-chat-msg right">
                                    <div class="direct-chat-text ">
                                        <a href="{{ action('fichasController@stats_comprension') }}" target="_blank">
                                            <i class="far fa-lightbulb"></i> ¿Qué implican estas opciones?
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center">
                                @include("fichas.partials.listados_victimas")
                            </div>
                            <div class="col-sm-2 text-right">
                                <a href="{{ action("entrevista_individualController@generar_excel_filtrado_victima")."?".$filtros->url }}" class="btn btn-info btn-xs"><i class="far fa-file-excel"></i> Descargar excel con metadatos</a>
                            </div>

                        </div>
                    @endif

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($filtros->id_tipo_listado==1)
                            @include("fichas.victima_table")
                        @elseif($filtros->id_tipo_listado==2)
                            @include("fichas.victima_table_persona")
                        @else
                                @include("fichas.victima_table_entrevista")
                        @endif
                    </div>
                </div>
                <div class="card-footer">

                    <div class="text-center">
                        <nav aria-label="Navegacion">
                            <ul class="pagination justify-content-center">
                                @if($listado->currentPage() >1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $listado->appends(Request::all())->previousPageUrl() }}" aria-label="Anterior">
                                        <span aria-hidden="true">Anterior</span>
                                        <span class="sr-only">Anterior</span>
                                    </a>
                                </li>
                                @endif
                                @if($listado->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $listado->appends(Request::all())->nextPageUrl() }}" aria-label="Siguiente">
                                            <span aria-hidden="true">Siguiente</span>
                                            <span class="sr-only">Siguiente</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection