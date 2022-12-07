@extends('layouts.app')


@section('content')
    {{-- Entrevistas anuladas --}}
    @if($entrevistaIndividual->id_activo <> 1)
        @include("partials.anulada")
    @endif

    {{-- Marcas y botones --}}
    @php($marcas = \App\Models\marca_entrevista::listado_marcas($entrevistaIndividual->id_subserie,$entrevistaIndividual->id_e_ind_fvt))
    @include('partials.marcas')
    {{-- Botones superiores --}}
    <div class="pull-right">

        {{-- Anular entrevista --}}
        @php($anular_id= $entrevistaIndividual->id_e_ind_fvt)
        @php($anular_url = action('entrevista_individualController@anular',$anular_id))
        @include("partials.anular")


        {{-- Nube de etiquetas --}}
        @if($entrevistaIndividual->puede_acceder_adjuntos())

            @if($entrevistaIndividual->html_transcripcion)
                @include("partials.nube",['txt_nube' => strip_tags(nl2br($entrevistaIndividual->fmt_html_transcripcion))])
            @endif

            @if($entrevistaIndividual->json_etiquetado)
                @include("partials.nube_tesauro",['txt_nube_tesauro' => strip_tags(nl2br($entrevistaIndividual->etiquetas_a_texto()))])
            @endif

        @endif

        @if($entrevistaIndividual->puede_modificar_entrevista())
            @if($entrevistaIndividual->puede_acceder_adjuntos())
                {{--adjuntos --}}
                <a class='btn btn-default pull-right no-print ' data-toggle="tooltip" title="Gestionar archivos adjuntos"  href="{!! action('entrevista_individualController@gestionar_adjuntos', [$entrevistaIndividual->id_e_ind_fvt]) !!}" ><i class="glyphicon glyphicon-paperclip"></i></a>
                {{-- fichas --}}
                @if($entrevistaIndividual->id_subserie == config('expedientes.vi'))
                    <a data-toggle="tooltip" title="Diligenciar fichas: {{ $entrevistaIndividual->diligenciada->situacion_texto }} "  href="{!! action('entrevista_individualController@fichas', [$entrevistaIndividual->id_e_ind_fvt]) !!}" class='btn {{ $entrevistaIndividual->diligenciada->situacion_boton }} pull-right '><i class="glyphicon glyphicon-send"></i></a>
                @endif

            @endif
        @endif

        {{-- Ver fichas --}}
        @if($entrevistaIndividual->id_subserie == config('expedientes.vi'))
            @if($entrevistaIndividual->puede_acceder_adjuntos())
                @if( $entrevistaIndividual->diligenciada->situacion==3)
                    <a data-toggle="tooltip" title="Fichas diligenciadas"  href="{!! action('entrevista_individualController@fichas_show', [$entrevistaIndividual->id_e_ind_fvt]) !!}" class='btn btn-default  pull-right  '><i class="fa fa-paper-plane-o"></i></a>
                @endif
            @endif
        @endif
        {{-- MArcar entrevista --}}
        @php($id_subserie = $entrevistaIndividual->id_subserie)
        @php($id_entrevista = $entrevistaIndividual->id_e_ind_fvt)
        @php($codigo_entrevista = $entrevistaIndividual->entrevisa_codigo)

        @include("partials.boton_marca")

    </div>

    <h1 class="page-title">
        {!! $entrevistaIndividual->entrevista_codigo !!} <small> {{ $entrevistaIndividual->fmt_id_subserie }} [R-{{ $entrevistaIndividual->clasifica_nivel }}]</small>
    </h1>


    {{-- Entrevista remitida por --}}
    @if(!is_null($entrevistaIndividual->id_remitido))
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-warning">
                    Entrevista remitida por {{ $entrevistaIndividual->fmt_id_remitido }}.
                </div>
            </div>
        </div>
    @endif


    {{-- TABS --}}
    <div class="nav-tabs-custom">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs pull-right"  role="tablist">

            <li role="presentation"><a href="#traza" aria-controls="traza" role="tab" data-toggle="tab">Traza</a></li>
            @if($entrevistaIndividual->clasifica_nivel<=3)
                <li role="presentation"><a href="#permisos" aria-controls="permisos" role="tab" data-toggle="tab">Permisos</a></li>
            @endif
            <li role="presentation"><a href="#priorizacion" aria-controls="priorizacion" role="tab" data-toggle="tab">Priorizacion</a></li>
            <li role="presentation"><a href="#procesamiento" aria-controls="procesamiento" role="tab" data-toggle="tab">Procesamiento</a></li>
            <li role="presentation"><a href="#consentimiento" aria-controls="consentimiento" role="tab" data-toggle="tab">Consentimiento</a></li>
            <li role="presentation"><a href="#adjuntos" aria-controls="adjuntos" role="tab" data-toggle="tab">Adjuntos</a></li>
            <li role="presentation"><a href="#transcripcion" aria-controls="transcripcion" role="tab" data-toggle="tab">Transcripción</a></li>
            <li role="presentation" class="active"><a href="#metadatos" aria-controls="metadatos" role="tab" data-toggle="tab">Metadatos</a></li>

        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            {{-- metadatos --}}
            <div role="tabpanel" class="tab-pane active" id="metadatos" >
                {{-- CONSENTIMIENTO--}}
                @include("entrevista_individuals.alerta_consentimiento")
                {{-- METADATOS --}}
                <div class="box box-primary box-solid">
                    <div class="box-header">
                        <h3 class="box-title"> Código de entrevista: {!! $entrevistaIndividual->entrevista_codigo !!}</h3>

                        <div class="box-tools pull-right">
                            @if($entrevistaIndividual->nna == 1)
                                <span data-toggle="tooltip" title="Entrevista a niño, niña o adolescente"  data-original-title="Entrevista a niño, niña o adolescente"><i class="fa fa-child fa-2x" aria-hidden="true"></i></span>
                            @endif
                            @if($entrevistaIndividual->id_prioritario == 1)
                                <span data-toggle="tooltip" title="Entrevista prioritaria"  data-original-title="Entrevista prioritaria"><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                            @endif
                        </div>

                    </div>
                    <div class="box-body">
                        <div class="row" >
                            <div class="col-xs-12">
                                @include('entrevista_individuals.show_fields')
                            </div>
                        </div>
                    </div>
                </div>
                {{--  Condiciones de la entrevista --}}
                @include('entrevista_individuals.show_especs')


                <div class="clearfix"></div>
            </div>
            {{-- transcripcion --}}
            <div role="tabpanel" class="tab-pane" id="transcripcion">
                {{-- Mostrar la transcripción o el etiquetado, si lo hubiera --}}
                @if($entrevistaIndividual->puede_acceder_adjuntos())  {{-- Proteger R3 y R2 --}}
                    @if($entrevistaIndividual->json_etiquetado)
                        @if($entrevistaIndividual->json_etiquetado)

                        @endif
                        <div class="box box-info  collapsed-box box-solid">
                            <div class="box-header ">
                                <h3 class="box-title">Etiquetas aplicadas: {{ $entrevistaIndividual->rel_etiquetas()->count() }}</h3>


                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                    </button>
                                </div>

                            </div>
                            <div class="box-body">
                                {{--
                                @include("partials.tesauro_cuadros",['json_datos_cuadros' => \App\Models\etiqueta_entrevista::json_jerarquico_entrevista($entrevistaIndividual->id_subserie, $entrevistaIndividual->id_e_ind_fvt)])
                                --}}
                                <ol>
                                    @foreach($entrevistaIndividual->listar_etiquetas() as $marca)
                                        <li>{{ $marca->fmt_etiqueta }}. {{-- <span class="text-muted">{{ $marca->fmt_texto }}</span> --}}
                                            <br> <span class="text-success">{{ $marca->texto }}</span>
                                        </li>
                                    @endforeach
                                </ol>

                            </div>
                        </div>

                        <div class="box box-info box-solid">
                            <div class="box-header ">
                                <h3 class="box-title"> Transcripción etiquetada, {{ number_format(\App\Models\entrevista_individual::transcripcion_conteo_palabras($entrevistaIndividual),0,",",'.') }}  palabras. </h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>

                            </div>
                            <div class="box-body">
                                {!! $entrevistaIndividual->etiquetado->texto_resaltado !!}
                            </div>
                        </div>
                    @else
                        @if($entrevistaIndividual->html_transcripcion)
                            <div class="box box-info   box-solid">
                                <div class="box-header ">
                                    <h3 class="box-title"> Transcripción, {{ number_format(\App\Models\entrevista_individual::transcripcion_conteo_palabras($entrevistaIndividual),0,",",'.') }} palabras.</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>

                                </div>
                                <div class="box-body">
                                    {!! nl2br($entrevistaIndividual->fmt_html_transcripcion) !!}
                                </div>
                            </div>

                        @endif

                    @endif
                @else
                    <div class="text-yellow text-center">
                        <h4><i class="icon fa fa-warning"></i> Acceso restringido a los archivos anexos</h4>
                        <p>Expediente clasificado como <span class="text-bold">RESERVADO-{{ $entrevistaIndividual->clasificacion_nivel }}</span> </p>
                        <br>

                        @if($entrevistaIndividual->clasificacion_nivel == 1)
                            <p><i class="fa fa-hand-o-right"></i> El acceso a los anexos de una entrevista R-1 únicamente puede ser autorizado por el responsable de la entrevista.</p>
                        @else
                            <p><i class="fa fa-hand-o-right"></i> El acceso a los anexos debe ser autorizado por Comité de Acceso a la Información.</p>
                        @endif
                    </div>



                @endif
                <div class="clearfix"></div>
            </div>
            {{-- adjuntos --}}
            <div role="tabpanel" class="tab-pane" id="adjuntos">


                {{-- ARCHIVOS ADJUNTOS --}}
                @php($solo_lectura=true)
                @include('entrevista_individuals.tabla_adjuntos')

                <div class="clearfix"></div>
            </div>
            {{-- consentimiento --}}
            <div role="tabpanel" class="tab-pane" id="consentimiento">
                <div class="clearfix"></div>
                @include('entrevista_individuals.clasificacion_show')
                <div class="clearfix"></div>
                @include('entrevista_individuals.show_concentimiento')
                <div class="clearfix"></div>
            </div>
            {{-- procesamiento --}}
            <div role="tabpanel" class="tab-pane" id="procesamiento">
                @php($entrevista = $entrevistaIndividual)
                @include('partials.procesamiento')
                <div class="clearfix"></div>
            </div>
            {{-- priorizacion --}}
            <div role="tabpanel" class="tab-pane" id="priorizacion">
                <div class="box box-info box-solid">
                    <div class="box-header">
                        <h3 class="box-title">Priorización de la entrevista</h3>
                    </div>
                    <div class="box-body">
                        {{-- Campo de priorizacion --}}
                        @if($entrevistaIndividual->id_prioritario == 1)
                            <i class="fa fa-hand-o-right"></i> Recomendada por: {!! $entrevistaIndividual->prioritario_tema !!}
                        @endif

                        {{-- Criterio de priorizacion --}}
                        @php($prioridad = $entrevistaIndividual->prioridad)
                        @include('partials.prioridad_tabs')
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
            {{-- traza --}}
            <div role="tabpanel" class="tab-pane" id="traza">
                @include('traza_actividads.por_expediente',['control_codigo'=>$entrevista->entrevista_codigo])
                <div class="clearfix"></div>
            </div>
            @if($entrevistaIndividual->clasifica_nivel<=3)
                <div role="tabpanel" class="tab-pane" id="permisos">
                    @include('entrevista_individuals.tabla_accesos')
                    <div class="clearfix"></div>
                </div>
            @endif
        </div>
    </div>
        <a href="{!! route('entrevistaIndividuals.index') !!}?id_subserie={{ $entrevistaIndividual->id_subserie }}" class="btn btn-default">Listado general de entrevistas</a>

        <div class="clearfix"></div>

@endsection
