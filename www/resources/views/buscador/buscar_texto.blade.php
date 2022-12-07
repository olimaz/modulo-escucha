{!!  Form::model($filtros, ['action' =>'statController@buscadora', 'method' => 'get']) !!}
<div class="col-sm-6 col-sm-offset-3">
    <div class="input-group">
        {!! Form::text('fts', null, ['class' => 'form-control', 'placeholder'=>'Términos a buscar. ']) !!}
        <input type="hidden" name="p" value="1">
        <span class="input-group-btn">
                    <button class="btn bg-purple" type="submit" title="Realizar búsqueda" data-toggle="tooltip"> <i class="fa fa-magic"></i> </button>
                  </span>
    </div><!-- /input-group -->
</div>
<div class="col-sm-3">
    <a  class="btn btn-default " id="btn_frm_avanzado" data-toggle="collapse" href="#frm_avanzado"  ><i class="fa fa-eyedropper "></i> Opciones avanzadas</a>
</div>
<div class="clearfix"></div>
<div class="text-center">
    <span class="text-muted text-sm"><b>Tip:</b>  Para búsquedas exactas indicar la frase entre comillas.  Ej.: "líder sindical".  </span>
</div>
<div class="clearfix"></div>

@php($mostrar_filtro_excel=true)
@include("buscador.frm_filtros")
{!! Form::close() !!}




@if($activa==1)
    <div class="clearfix" id="ir_resultados"></div>
    @if($filtros->hay_filtro_buscadora || strlen($filtros->fts) > 0 )
        {{-- VI --}}
        <div class="box box-solid  {{  $entrevistaIndividuals->total() > 0 ? " box-success " : " box-warning "  }}">
            <div class="box-header">
                <h3 class="box-title">
                    Resultados para entrevistas a víctimas, familiares o testigos: {{  $entrevistaIndividuals->total() }}
                </h3>
                <div class="box-tools pull-right">
                    @if($entrevistaIndividuals->total() > 0)
                        @php( $filtros->url .= "&id_subserie=".config('expedientes.vi'))
                        @include("entrevista_individuals.boton_descargar")
                    @endif
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            @if($entrevistaIndividuals->total() > 0)
                <div class="box-body table-responsive no-padding">
                    <table class="table table-condensed table-striped ">
                        <thead>
                        <tr>
                            <th style="width:2ch">#</th>
                            <th style="width:15ch">Entrevista</th>
                            <th style="width:15vw">Título</th>
                            <th style="width:20vw">Anotaciones</th>
                            <th>Transcripción</th>
                            @can('sistema-abierto')
                                <th style="width:15ch">Marcas</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = $entrevistaIndividuals->firstItem())
                        @foreach($entrevistaIndividuals as $entrevistaIndividual)
                            <tr>
                                <td>{{ $i++ }}
                                    {{-- Enlaces y unificaciones --}}
                                    @php($listado_enlaces = \App\Models\enlace::listado_enlaces($entrevistaIndividual->id_subserie,$entrevistaIndividual->id_e_ind_fvt))
                                    @if(count($listado_enlaces)>0)
                                        <a href="{{ action('entrevista_individualController@show',$entrevistaIndividual->id_e_ind_fvt) }}"  target="_blank" class="btn btn-sm btn-default" data-toggle="tooltip" title="Esta entrevista tiene enlaces a otras entrevistas"><i class="fa fa-link"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ action('entrevista_individualController@show',$entrevistaIndividual->id_e_ind_fvt) }}"> {{ $entrevistaIndividual->entrevista_codigo }} </a>
                                    @php($prioridad = $entrevistaIndividual->prioridad)
                                    @include('partials.prioridad_ico')
                                </td>
                                <td >
                                    <span class="resaltable">{{ $entrevistaIndividual->titulo }} </span>
                                    @if($entrevistaIndividual->rel_dinamica()->count() > 0)
                                        <br><strong>Dinámicas:</strong>
                                        <ol>
                                            @foreach($entrevistaIndividual->rel_dinamica as $d)
                                                <li>{{ $d->dinamica }}</li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                                <td class="resaltable">


                                    {{-- texto --}}
                                    {{ nl2br($entrevistaIndividual->observaciones) }}

                                </td>
                                <td>
                                    @if($entrevistaIndividual->puede_acceder_adjuntos())
                                        @if(strlen($entrevistaIndividual->html_transcripcion)>0)
                                            <div class="box box-default collapsed-box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Transcripción completa</h3>

                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <!-- /.box-tools -->
                                                </div>
                                                <!-- /.box-header -->
                                                <div class="box-body resaltable">
                                                    {!! nl2br($entrevistaIndividual->html_transcripcion)  !!}
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                        @else
                                            <span class="text-muted"> Entrevista sin transcripción</span>
                                        @endif
                                    @else
                                        <span class="text-danger">Acceso restringido.</span>  Entrevista clasificada como R-{{ $entrevistaIndividual->clasifica_nivel }}
                                    @endif
                                </td>
                                @can('sistema-abierto')
                                <td>
                                    {{-- Aplicar marcas --}}
                                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_marca_{{ config('expedientes.vi') }}_{{ $entrevistaIndividual->id_e_ind_fvt  }}">
                                        <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                                    </button>
                                    {!!   \App\Models\marca_entrevista::listado_marcas_buscadora($entrevistaIndividual->id_subserie,$entrevistaIndividual->id_e_ind_fvt) !!}
                                </td>
                                @endcan

                                @php($id_subserie = config('expedientes.vi'))
                                @php($id_entrevista = $entrevistaIndividual->id_e_ind_fvt)
                                @php($codigo_entrevista = $entrevistaIndividual->entrevista_codigo)
                                @include('marca_entrevistas.create')

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {!! $entrevistaIndividuals->appends(Request::all())->render() !!}
                </div>
            @endif
        </div>

        {{-- AA --}}
        <div class="box box-solid  {{  $entrevistasAA->total() > 0 ? " box-success " : " box-warning "  }}">
            <div class="box-header">
                <h3 class="box-title">
                    Resultados para entrevistas a Actores Armados: {{  $entrevistasAA->total() }}
                </h3>
                <div class="box-tools pull-right">
                    @if($entrevistasAA->total() > 0)
                        @php( $filtros->url = str_replace('id_subserie=','id_subserie_2',$filtros->url))
                        @php( $filtros->url .= "&id_subserie=".config('expedientes.aa'))
                        @include("entrevista_individuals.boton_descargar")
                    @endif
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            @if($entrevistasAA->total() > 0)
                <div class="box-body table-responsive no-padding">
                    <table class="table table-condensed table-striped ">
                        <thead>
                        <tr>
                            <th style="width:2ch">#</th>
                            <th style="width:15ch">Entrevista</th>
                            <th style="width:15vw">Título</th>
                            <th style="width:20vw">Anotaciones</th>
                            <th>Transcripción</th>
                            @can('sistema-abierto')
                                <th style="width:15ch">Marcas</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = $entrevistasAA->firstItem())
                        @foreach($entrevistasAA as $entrevistaIndividual)
                            <tr>
                                <td>{{ $i++ }}
                                    {{-- Enlaces y unificaciones --}}
                                    @php($listado_enlaces = \App\Models\enlace::listado_enlaces($entrevistaIndividual->id_subserie,$entrevistaIndividual->id_e_ind_fvt))
                                    @if(count($listado_enlaces)>0)
                                        <a href="{{ action('entrevista_individualController@show',$entrevistaIndividual->id_e_ind_fvt) }}"  target="_blank" class="btn btn-sm btn-default" data-toggle="tooltip" title="Esta entrevista tiene enlaces a otras entrevistas"><i class="fa fa-link"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ action('entrevista_individualController@show',$entrevistaIndividual->id_e_ind_fvt) }}"> {{ $entrevistaIndividual->entrevista_codigo }} </a>
                                    @php($prioridad = $entrevistaIndividual->prioridad)
                                    @include('partials.prioridad_ico')
                                </td>
                                <td >
                                    <span class="resaltable">{{ $entrevistaIndividual->titulo }} </span>
                                    @if($entrevistaIndividual->rel_dinamica()->count() > 0)
                                        <br><strong>Dinámicas:</strong>
                                        <ol>
                                            @foreach($entrevistaIndividual->rel_dinamica as $d)
                                                <li>{{ $d->dinamica }}</li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                                <td class="resaltable">


                                    {{-- texto --}}
                                    {{ nl2br($entrevistaIndividual->observaciones) }}

                                </td>
                                <td>
                                    @if($entrevistaIndividual->puede_acceder_adjuntos())
                                        @if(strlen($entrevistaIndividual->html_transcripcion)>0)
                                            <div class="box box-default collapsed-box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Transcripción completa</h3>

                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <!-- /.box-tools -->
                                                </div>
                                                <!-- /.box-header -->
                                                <div class="box-body resaltable">
                                                    {!! nl2br($entrevistaIndividual->html_transcripcion)  !!}
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                        @else
                                            <span class="text-muted"> Entrevista sin transcripción</span>
                                        @endif
                                    @else
                                        <span class="text-danger">Acceso restringido.</span>  Entrevista clasificada como R-{{ $entrevistaIndividual->clasifica_nivel }}
                                    @endif
                                </td>
                                @can('sistema-abierto')
                                <td>
                                    {{-- Aplicar marcas --}}
                                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_marca_{{ config('expedientes.aa') }}_{{ $entrevistaIndividual->id_e_ind_fvt  }}">
                                        <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                                    </button>
                                    {!!   \App\Models\marca_entrevista::listado_marcas_buscadora($entrevistaIndividual->id_subserie,$entrevistaIndividual->id_e_ind_fvt) !!}
                                </td>
                                @endcan

                                @php($id_subserie = config('expedientes.aa'))
                                @php($id_entrevista = $entrevistaIndividual->id_e_ind_fvt)
                                @php($codigo_entrevista = $entrevistaIndividual->entrevista_codigo)
                                @include('marca_entrevistas.create')

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {!! $entrevistasAA->appends(Request::all())->render() !!}
                </div>
            @endif
        </div>

        {{-- TC --}}
        <div class="box box-solid  {{  $entrevistasTC->total() > 0 ? " box-success " : " box-warning "  }}">
            <div class="box-header">
                <h3 class="box-title">
                    Resultados para entrevistas a Terceros Civiles: {{  $entrevistasTC->total() }}
                </h3>
                <div class="box-tools pull-right">
                    @if($entrevistasTC->total() > 0)
                        @php( $filtros->url = str_replace('id_subserie=','id_subserie_3',$filtros->url))
                        @php( $filtros->url .= "&id_subserie=".config('expedientes.tc'))
                        @include("entrevista_individuals.boton_descargar")
                    @endif
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            @if($entrevistasTC->total() > 0)
                <div class="box-body table-responsive no-padding">
                    <table class="table table-condensed table-striped ">
                        <thead>
                        <tr>
                            <th style="width:2ch">#</th>
                            <th style="width:15ch">Entrevista</th>
                            <th style="width:15vw">Título</th>
                            <th style="width:20vw">Anotaciones</th>
                            <th>Transcripción</th>
                            @can('sistema-abierto')
                                <th style="width:15ch">Marcas</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = $entrevistasTC->firstItem())
                        @foreach($entrevistasTC as $entrevistaIndividual)
                            <tr>
                                <td>{{ $i++ }}
                                    {{-- Enlaces y unificaciones --}}
                                    @php($listado_enlaces = \App\Models\enlace::listado_enlaces($entrevistaIndividual->id_subserie,$entrevistaIndividual->id_e_ind_fvt))
                                    @if(count($listado_enlaces)>0)
                                        <a href="{{ action('entrevista_individualController@show',$entrevistaIndividual->id_e_ind_fvt) }}"  target="_blank" class="btn btn-sm btn-default" data-toggle="tooltip" title="Esta entrevista tiene enlaces a otras entrevistas"><i class="fa fa-link"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ action('entrevista_individualController@show',$entrevistaIndividual->id_e_ind_fvt) }}"> {{ $entrevistaIndividual->entrevista_codigo }} </a>
                                    @php($prioridad = $entrevistaIndividual->prioridad)
                                    @include('partials.prioridad_ico')
                                </td>
                                <td >
                                    <span class="resaltable">{{ $entrevistaIndividual->titulo }} </span>
                                    @if($entrevistaIndividual->rel_dinamica()->count() > 0)
                                        <br><strong>Dinámicas:</strong>
                                        <ol>
                                            @foreach($entrevistaIndividual->rel_dinamica as $d)
                                                <li>{{ $d->dinamica }}</li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                                <td class="resaltable">


                                    {{-- texto --}}
                                    {{ nl2br($entrevistaIndividual->observaciones) }}

                                </td>
                                <td>
                                    @if($entrevistaIndividual->puede_acceder_adjuntos())
                                        @if(strlen($entrevistaIndividual->html_transcripcion)>0)
                                            <div class="box box-default collapsed-box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Transcripción completa</h3>

                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <!-- /.box-tools -->
                                                </div>
                                                <!-- /.box-header -->
                                                <div class="box-body resaltable">
                                                    {!! nl2br($entrevistaIndividual->html_transcripcion)  !!}
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                        @else
                                            <span class="text-muted"> Entrevista sin transcripción</span>
                                        @endif
                                    @else
                                        <span class="text-danger">Acceso restringido.</span>  Entrevista clasificada como R-{{ $entrevistaIndividual->clasifica_nivel }}
                                    @endif
                                </td>
                                @can('sistema-abierto')
                                    <td>
                                        {{-- Aplicar marcas --}}
                                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_marca_{{ config('expedientes.tc') }}_{{ $entrevistaIndividual->id_e_ind_fvt  }}">
                                            <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                                        </button>
                                        {!!   \App\Models\marca_entrevista::listado_marcas_buscadora($entrevistaIndividual->id_subserie,$entrevistaIndividual->id_e_ind_fvt) !!}
                                    </td>

                                    @php($id_subserie = config('expedientes.tc'))
                                    @php($id_entrevista = $entrevistaIndividual->id_e_ind_fvt)
                                    @php($codigo_entrevista = $entrevistaIndividual->entrevista_codigo)
                                    @include('marca_entrevistas.create')
                                @endcan

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {!! $entrevistasTC->appends(Request::all())->render() !!}
                </div>
            @endif
        </div>



        {{-- Entrevistas profundidad --}}
        <div class="clearfix"></div>
        <div class="box box-solid  {{  $entrevistasPR->total() > 0 ? " box-success " : " box-warning "  }}">
            <div class="box-header">
                <h3 class="box-title">
                    Resultados para entrevistas a profundidad: {{  $entrevistasPR->total() }}
                </h3>
                <div class="box-tools pull-right">
                    @if($entrevistasPR->total() > 0)
                        @include("entrevista_profundidads.boton_descargar")
                    @endif
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            @if($entrevistasPR->total() > 0)
                <div class="box-body table-responsive no-padding">
                    <table class="table table-condensed table-striped table-bordered ">
                        <thead>
                        <tr>
                            <th style="width:2ch">#</th>
                            <th style="width:15ch">Entrevista</th>
                            <th style="width:30ch">Entrevistado</th>
                            <th style="width:20vw">Objetivo</th>
                            <th>Transcripción</th>
                            @can('sistema-abierto')
                                <th style="width:15ch">Marcas</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = $entrevistasPR->firstItem())
                        @foreach($entrevistasPR as $entrevista)
                            <tr>
                                <td>{{ $i++ }}
                                    {{-- Enlaces y unificaciones --}}
                                    @php($listado_enlaces = \App\Models\enlace::listado_enlaces(config('expedientes.pr'),$entrevista->id_entrevista_profundidad))
                                    @if(count($listado_enlaces)>0)
                                        <a href="{{ action('entrevista_profundidadController@show',$entrevista->id_entrevista_profundidad) }}"  target="_blank" class="btn btn-sm btn-default" data-toggle="tooltip" title="Esta entrevista tiene enlaces a otras entrevistas"><i class="fa fa-link"></i></a>
                                    @endif
                                </td>
                                <td> <a href="{{ action('entrevista_profundidadController@show',$entrevista->id_entrevista_profundidad) }}"> {{ $entrevista->entrevista_codigo }} </a>
                                    @php($prioridad = $entrevista->prioridad)
                                    @include('partials.prioridad_ico')
                                </td>
                                <td>
                                    <span  class="resaltable">{{ $entrevista->entrevistado_nombres }} {{ $entrevista->entrevistado_apellidos }}</span>
                                    @if($entrevista->rel_dinamica()->count() > 0)
                                        <br><strong>Dinámicas:</strong>
                                        <ol>
                                            @foreach($entrevista->rel_dinamica as $d)
                                                <li>{{ $d->dinamica }}</li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                                <td class="resaltable">


                                    {{-- texto --}}
                                    {!!nl2br($entrevista->entrevista_objetivo)  !!}
                                </td>
                                <td>
                                    @if($entrevista->puede_acceder_adjuntos())
                                        @if(strlen($entrevista->html_transcripcion)>0)
                                            <div class="box box-default collapsed-box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Transcripción completa</h3>

                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <!-- /.box-tools -->
                                                </div>
                                                <!-- /.box-header -->
                                                <div class="box-body resaltable">
                                                    {!! nl2br($entrevista->fmt_html_transcripcion)  !!}
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                        @else
                                            <span class="text-muted"> Entrevista sin transcripción</span>
                                        @endif
                                    @else
                                        <span class="text-danger">Acceso restringido.</span>  Entrevista clasificada como R-{{ $entrevista->clasificacion_nivel }}
                                    @endif
                                </td>
                                @can('sistema-abierto')
                                    <td>
                                        {{-- Aplicar marcas --}}
                                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_marca_{{ config('expedientes.pr') }}_{{ $entrevista->id_entrevista_profundidad  }}">
                                            <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                                        </button>
                                        {!!   \App\Models\marca_entrevista::listado_marcas_buscadora(config('expedientes.pr'),$entrevista->id_entrevista_profundidad) !!}
                                    </td>

                                    @php($id_subserie = config('expedientes.pr'))
                                    @php($id_entrevista = $entrevista->id_entrevista_profundidad)
                                    @php($codigo_entrevista = $entrevista->entrevista_codigo)
                                    @include('marca_entrevistas.create')
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer no-print">
                    {!! $entrevistasPR->appends(Request::all())->render() !!}
                </div>
            @endif
        </div>

        {{-- Entrevistas colectivas --}}
        <div class="clearfix"></div>
        <div class="box box-solid  {{  $entrevistasCO->total() > 0 ? " box-success " : " box-warning "  }}">
            <div class="box-header">
                <h3 class="box-title">
                    Resultados para entrevistas colectivas: {{  $entrevistasCO->total() }}
                </h3>
                <div class="box-tools pull-right">
                    @if($entrevistasCO->total() > 0)
                        @include("entrevista_colectivas.boton_descargar")
                    @endif
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            @if($entrevistasCO->total() > 0)
                <div class="box-body table-responsive no-padding">
                    <table class="table table-condensed table-striped table-bordered ">
                        <thead>
                        <tr>
                            <th style="width:2ch">#</th>
                            <th style="width:15ch">Entrevista</th>
                            <th style="width:30ch">Tema y dinámicas</th>
                            <th style="width:20vw">Objetivo</th>
                            <th>Transcripción</th>
                            @can('sistema-abierto')
                                <th style="width:15ch">Marcas</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = $entrevistasCO->firstItem())
                        @foreach($entrevistasCO as $entrevista)
                            <tr>
                                <td>{{ $i++ }}
                                    {{-- Enlaces y unificaciones --}}
                                    @php($listado_enlaces = \App\Models\enlace::listado_enlaces(config('expedientes.co'),$entrevista->id_entrevista_colectiva))
                                    @if(count($listado_enlaces)>0)
                                        <a href="{{ action('entrevista_colectivaController@show',$entrevista->id_entrevista_colectiva) }}"  target="_blank" class="btn btn-sm btn-default" data-toggle="tooltip" title="Esta entrevista tiene enlaces a otras entrevistas"><i class="fa fa-link"></i></a>
                                    @endif
                                </td>
                                <td> <a href="{{ action('entrevista_colectivaController@show',$entrevista->id_entrevista_colectiva) }}"> {{ $entrevista->entrevista_codigo }} </a>
                                    @php($prioridad = $entrevista->prioridad)
                                    @include('partials.prioridad_ico')
                                </td>
                                <td>
                                    <span  class="resaltable">{{ $entrevista->tema_descripcion }}</span>
                                    @if($entrevista->rel_dinamica()->count() > 0)
                                        <br><strong>Dinámicas:</strong>
                                        <ol>
                                            @foreach($entrevista->rel_dinamica as $d)
                                                <li>{{ $d->dinamica }}</li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                                <td class="resaltable">


                                    {{-- texto --}}
                                    {!!nl2br($entrevista->tema_objetivo)  !!}
                                </td>
                                <td>
                                    @if($entrevista->puede_acceder_adjuntos())
                                        @if(strlen($entrevista->html_transcripcion)>0)
                                            <div class="box box-default collapsed-box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Transcripción completa</h3>

                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <!-- /.box-tools -->
                                                </div>
                                                <!-- /.box-header -->
                                                <div class="box-body resaltable">
                                                    {!! nl2br($entrevista->fmt_html_transcripcion)  !!}
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                        @else
                                            <span class="text-muted"> Entrevista sin transcripción</span>
                                        @endif
                                    @else
                                        <span class="text-danger">Acceso restringido.</span>  Entrevista clasificada como R-{{ $entrevista->clasificacion_nivel }}
                                    @endif
                                </td>
                                @can('sistema-abierto')
                                    <td>
                                        {{-- Aplicar marcas --}}
                                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_marca_{{ config('expedientes.co') }}_{{ $entrevista->id_entrevista_colectiva }}">
                                            <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                                        </button>
                                        {!!   \App\Models\marca_entrevista::listado_marcas_buscadora(config('expedientes.co'),$entrevista->id_entrevista_colectiva) !!}
                                    </td>

                                    @php($id_subserie = config('expedientes.co'))
                                    @php($id_entrevista = $entrevista->id_entrevista_colectiva)
                                    @php($codigo_entrevista = $entrevista->entrevista_codigo)
                                    @include('marca_entrevistas.create')
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer no-print">
                    {!! $entrevistasCO->appends(Request::all())->render() !!}
                </div>
            @endif
        </div>

        {{-- Entrevistas etnicas --}}
        <div class="clearfix"></div>
        <div class="box box-solid  {{  $entrevistasEE->total() > 0 ? " box-success " : " box-warning "  }}">
            <div class="box-header">
                <h3 class="box-title">
                    Resultados para entrevistas a sujeto colectivo: {{  $entrevistasEE->total() }}
                </h3>
                <div class="box-tools pull-right">
                    @if($entrevistasEE->total() > 0)
                        @include("entrevista_etnicas.boton_descargar")
                    @endif
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            @if($entrevistasEE->total() > 0)
                <div class="box-body table-responsive no-padding">
                    <table class="table table-condensed table-striped table-bordered ">
                        <thead>
                        <tr>
                            <th style="width:2ch">#</th>
                            <th style="width:15ch">Entrevista</th>
                            <th style="width:30ch">Tema y dinámicas</th>
                            <th style="width:20vw">Objetivo</th>
                            <th>Transcripción</th>
                            @can('sistema-abierto')
                                <th style="width:15ch">Marcas</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = $entrevistasEE->firstItem())
                        @foreach($entrevistasEE as $entrevista)
                            <tr>
                                <td>{{ $i++ }}
                                    {{-- Enlaces y unificaciones --}}
                                    @php($listado_enlaces = \App\Models\enlace::listado_enlaces(config('expedientes.ee'),$entrevista->id_entrevista_etnica))
                                    @if(count($listado_enlaces)>0)
                                        <a href="{{ action('entrevista_etnicaController@show',$entrevista->id_entrevista_etnica) }}"  target="_blank" class="btn btn-sm btn-default" data-toggle="tooltip" title="Esta entrevista tiene enlaces a otras entrevistas"><i class="fa fa-link"></i></a>
                                    @endif
                                </td>
                                <td> <a href="{{ action('entrevista_etnicaController@show',$entrevista->id_entrevista_etnica) }}"> {{ $entrevista->entrevista_codigo }} </a>
                                    @php($prioridad = $entrevista->prioridad)
                                    @include('partials.prioridad_ico')
                                </td>
                                <td>
                                    <span  class="resaltable">{{ $entrevista->tema_descripcion }}</span>
                                    @if($entrevista->rel_dinamica()->count() > 0)
                                        <br><strong>Dinámicas:</strong>
                                        <ol>
                                            @foreach($entrevista->rel_dinamica as $d)
                                                <li>{{ $d->dinamica }}</li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                                <td class="resaltable">


                                    {{-- texto --}}
                                    {!!nl2br($entrevista->tema_objetivo)  !!}
                                </td>
                                <td>
                                    @if($entrevista->puede_acceder_adjuntos())
                                        @if(strlen($entrevista->html_transcripcion)>0)
                                            <div class="box box-default collapsed-box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Transcripción completa</h3>

                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <!-- /.box-tools -->
                                                </div>
                                                <!-- /.box-header -->
                                                <div class="box-body resaltable">
                                                    {!! nl2br($entrevista->fmt_html_transcripcion)  !!}
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                        @else
                                            <span class="text-muted"> Entrevista sin transcripción</span>
                                        @endif
                                    @else
                                        <span class="text-danger">Acceso restringido.</span>  Entrevista clasificada como R-{{ $entrevista->clasificacion_nivel }}
                                    @endif
                                </td>
                                @can('sistema-abierto')
                                    <td>
                                        {{-- Aplicar marcas --}}
                                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_marca_{{ config('expedientes.ee') }}_{{ $entrevista->id_entrevista_etnica }}">
                                            <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                                        </button>
                                        {!!   \App\Models\marca_entrevista::listado_marcas_buscadora(config('expedientes.ee'),$entrevista->id_entrevista_etnica) !!}
                                    </td>

                                    @php($id_subserie = config('expedientes.ee'))
                                    @php($id_entrevista = $entrevista->id_entrevista_etnica)
                                    @php($codigo_entrevista = $entrevista->entrevista_codigo)
                                    @include('marca_entrevistas.create')
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer no-print">
                    {!! $entrevistasEE->appends(Request::all())->render() !!}
                </div>
            @endif
        </div>

        {{-- Diagnosticos comunitarios --}}
        <div class="clearfix"></div>
        <div class="box box-solid  {{  $entrevistasDC->total() > 0 ? " box-success " : " box-warning "  }}">
            <div class="box-header">
                <h3 class="box-title">
                    Resultados para diagnósticos comunitarios: {{  $entrevistasDC->total() }}
                </h3>
                <div class="box-tools pull-right">
                    @if($entrevistasDC->total() > 0)
                        @include("diagnostico_comunitarios.boton_descargar")
                    @endif
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            @if($entrevistasDC->total() > 0)
                <div class="box-body table-responsive no-padding">
                    <table class="table table-condensed table-striped table-bordered ">
                        <thead>
                        <tr>
                            <th style="width:2ch">#</th>
                            <th style="width:15ch">Entrevista</th>
                            <th style="width:30ch">Comunidad y dinámicas</th>
                            <th style="width:20vw">Objetivo</th>
                            <th>Transcripción</th>
                            @can('sistema-abierto')
                                <th style="width:15ch">Marcas</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = $entrevistasDC->firstItem())
                        @foreach($entrevistasDC as $entrevista)
                            <tr>
                                <td>{{ $i++ }}
                                    {{-- Enlaces y unificaciones --}}
                                    @php($listado_enlaces = \App\Models\enlace::listado_enlaces(config('expedientes.dc'),$entrevista->id_diagnostico_comunitario))
                                    @if(count($listado_enlaces)>0)
                                        <a href="{{ action('diagnostico_comunitarioController@show',$entrevista->id_diagnostico_comunitario) }}"  target="_blank" class="btn btn-sm btn-default" data-toggle="tooltip" title="Esta entrevista tiene enlaces a otras entrevistas"><i class="fa fa-link"></i></a>
                                    @endif
                                </td>
                                <td> <a href="{{ action('diagnostico_comunitarioController@show',$entrevista->id_diagnostico_comunitario) }}"> {{ $entrevista->entrevista_codigo }} </a>
                                    @php($prioridad = $entrevista->prioridad)
                                    @include('partials.prioridad_ico')
                                </td>
                                <td>
                                    <span  class="resaltable">{{ $entrevista->tema_comunidad }}</span>
                                    @if($entrevista->rel_dinamica()->count() > 0)
                                        <br><strong>Dinámicas:</strong>
                                        <ol>
                                            @foreach($entrevista->rel_dinamica as $d)
                                                <li>{{ $d->dinamica }}</li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                                <td class="resaltable">


                                    {{-- texto --}}
                                    {!!nl2br($entrevista->tema_objetivo)  !!}
                                </td>
                                <td>
                                    @if($entrevista->puede_acceder_adjuntos())
                                        @if(strlen($entrevista->html_transcripcion)>0)
                                            <div class="box box-default collapsed-box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Transcripción completa</h3>

                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <!-- /.box-tools -->
                                                </div>
                                                <!-- /.box-header -->
                                                <div class="box-body resaltable">
                                                    {!! nl2br($entrevista->fmt_html_transcripcion)  !!}
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                        @else
                                            <span class="text-muted"> Entrevista sin transcripción</span>
                                        @endif
                                    @else
                                        <span class="text-danger">Acceso restringido.</span>  Entrevista clasificada como R-{{ $entrevista->clasificacion_nivel }}
                                    @endif
                                </td>
                                @can('sistema-abierto')
                                    <td>
                                        {{-- Aplicar marcas --}}
                                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_marca_{{ config('expedientes.dc') }}_{{ $entrevista->id_diagnostico_comunitario }}">
                                            <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                                        </button>
                                        {!!   \App\Models\marca_entrevista::listado_marcas_buscadora(config('expedientes.dc'),$entrevista->id_diagnostico_comunitario) !!}
                                    </td>

                                    @php($id_subserie = config('expedientes.dc'))
                                    @php($id_entrevista = $entrevista->id_diagnostico_comunitario)
                                    @php($codigo_entrevista = $entrevista->entrevista_codigo)
                                    @include('marca_entrevistas.create')
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer no-print">
                    {!! $entrevistasDC->appends(Request::all())->render() !!}
                </div>
            @endif
        </div>

        {{-- Historias de vida --}}
        <div class="clearfix"></div>
        <div class="box box-solid  {{  $entrevistasHV->total() > 0 ? " box-success " : " box-warning "  }}">
            <div class="box-header">
                <h3 class="box-title">
                    Resultados para historias de vida: {{  $entrevistasHV->total() }}
                </h3>
                <div class="box-tools pull-right">
                    @if($entrevistasHV->total() > 0)
                        @include("historia_vidas.boton_descargar")
                    @endif
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            @if($entrevistasHV->total() > 0)
                <div class="box-body table-responsive no-padding">
                    <table class="table table-condensed table-striped table-bordered ">
                        <thead>
                        <tr>
                            <th style="width:2ch">#</th>
                            <th style="width:15ch">Entrevista</th>
                            <th style="width:30ch">Persona entrevistada y dinámicas</th>
                            <th style="width:20vw">Objetivo</th>
                            <th>Transcripción</th>
                            @can('sistema-abierto')
                                <th style="width:15ch">Marcas</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = $entrevistasHV->firstItem())
                        @foreach($entrevistasHV as $entrevista)
                            <tr>
                                <td>{{ $i++ }}
                                    {{-- Enlaces y unificaciones --}}
                                    @php($listado_enlaces = \App\Models\enlace::listado_enlaces(config('expedientes.hv'),$entrevista->id_historia_vida))
                                    @if(count($listado_enlaces)>0)
                                        <a href="{{ action('historia_vidaController@show',$entrevista->id_historia_vida) }}"  target="_blank" class="btn btn-sm btn-default" data-toggle="tooltip" title="Esta entrevista tiene enlaces a otras entrevistas"><i class="fa fa-link"></i></a>
                                    @endif
                                </td>
                                <td> <a href="{{ action('historia_vidaController@show',$entrevista->id_historia_vida) }}"> {{ $entrevista->entrevista_codigo }} </a>
                                    @php($prioridad = $entrevista->prioridad)
                                    @include('partials.prioridad_ico')
                                </td>
                                <td>
                                    <span  class="resaltable">{{ $entrevista->entrevistado_nombres }} {{ $entrevista->entrevistado_apellidos }}
                                        @if($entrevista->entrevistado_otros_nombres)
                                            ({{ $entrevista->entrevistado_otros_nombres }})
                                        @endif
                                    </span>
                                    @if($entrevista->rel_dinamica()->count() > 0)
                                        <br><strong>Dinámicas:</strong>
                                        <ol>
                                            @foreach($entrevista->rel_dinamica as $d)
                                                <li>{{ $d->dinamica }}</li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                                <td class="resaltable">
                                    {{-- texto --}}
                                    {!!nl2br($entrevista->entrevista_objetivo)  !!}
                                </td>
                                <td>
                                    @if($entrevista->puede_acceder_adjuntos())
                                        @if(strlen($entrevista->html_transcripcion)>0)
                                            <div class="box box-default collapsed-box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Transcripción completa</h3>

                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <!-- /.box-tools -->
                                                </div>
                                                <!-- /.box-header -->
                                                <div class="box-body resaltable">
                                                    {!! nl2br($entrevista->fmt_html_transcripcion)  !!}
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                        @else
                                            <span class="text-muted"> Entrevista sin transcripción</span>
                                        @endif
                                    @else
                                        <span class="text-danger">Acceso restringido.</span>  Entrevista clasificada como R-{{ $entrevista->clasificacion_nivel }}
                                    @endif
                                </td>
                                @can('sistema-abierto')
                                    <td>
                                        {{-- Aplicar marcas --}}
                                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_marca_{{ config('expedientes.hv') }}_{{ $entrevista->id_historia_vida }}">
                                            <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                                        </button>
                                        {!!   \App\Models\marca_entrevista::listado_marcas_buscadora(config('expedientes.hv'),$entrevista->id_historia_vida) !!}
                                    </td>

                                    @php($id_subserie = config('expedientes.hv'))
                                    @php($id_entrevista = $entrevista->id_historia_vida)
                                    @php($codigo_entrevista = $entrevista->entrevista_codigo)
                                    @include('marca_entrevistas.create')
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer no-print">
                    {!! $entrevistasHV->appends(Request::all())->render() !!}
                </div>
            @endif
        </div>
        @can('rol-descarga-transcripciones')
            <div class="clearfix"></div>

            <div class="col-xs-12 text-center">
                <a href="{{ action('statController@descarga_acepto') }}?{!! $filtros->url !!}" class="btn btn-primary">Descargar todas las transcripciones</a>
            </div>
        @endcan

        {{-- FIN --}}
        <div class="clearfix"></div>

    @endif
@endif
<div class="clearfix" id="ir_resultados"></div>


@push('js')
        <script>
            var options;
            $(function() {
                var str = "{!! str_replace('"',"'",$filtros->fts) !!}";
                var n = str.indexOf("'");
                var m = str.indexOf('"');

                if(n>=0 || m >=0) {
                    options = {
                        separateWordSearch: false,
                        accuracy: "exactly"
                    };
                }
                else {
                    options = {
                        separateWordSearch: true,
                        accuracy: "exactly"
                    };
                }


                $(".resaltable").mark(['{!! trim(str_replace("'","",str_replace('"',"",$filtros->fts))) !!}'], options);
            });

        </script>
        @if($filtros->hay_filtro_buscadora)
            <Script>
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#ir_resultados").offset().top
                }, 2000);
            </Script>

        @endif

@endpush