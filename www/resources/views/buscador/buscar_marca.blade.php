<br>
<div class="col-sm-6 col-sm-offset-3">
    {!!  Form::model($filtros, ['action' =>'statController@buscadora', 'method' => 'get']) !!}
    <input type="hidden" name="p" value="4">


    <div class="col-xs-10">
        @include('controles.marca', ['control_control' => 'marca'
                                                        , 'control_id'=>"marca_buscar_filtro"
                                                        , 'control_nuevos' => false
                                                        , 'control_mostrar_grupo' => true
                                                        , 'control_default' => $filtros->marca
                                                        , 'control_resaltar' => false
                                                       ,'control_texto'=>'Marcadas como:'])
    </div>
    <div class="col-xs-2 text-left">
        <label>&nbsp;</label>
        <button class="btn bg-purple" type="submit">Listar <i class="fa fa-search"></i></button>
    </div>

    {!! Form::close() !!}
</div>



<div class="clearfix"></div>


@if(count($filtros->marca) > 0)
    <section id="resultados" class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-tags"></i> Entrevistas marcadas
                </h2>
            </div>
            <div class="col-xs-12 table-responsive">
                <table class="table table-condensed table-striped ">
                    <thead>
                    <tr>
                        <th style="width:2ch">#</th>
                        <th style="width:15ch">Entrevista</th>
                        <th style="width:15vw">Título</th>
                        <th style="width:20vw">Anotaciones</th>
                        <th>Transcripción</th>
                        <th style="width:15ch">Marcas</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i=1)
                    @foreach($listado as $entrevista)
                        <tr>
                            <td>{{ $i++ }}
                                {{-- Enlaces y unificaciones --}}
                                @php($listado_enlaces = \App\Models\enlace::listado_enlaces($entrevista->id_subserie,$entrevista->id_entrevista))
                                @if(count($listado_enlaces)>0)
                                    <a href="{{ $entrevista->entrevista_enlace->link_show }}"  target="_blank" class="btn btn-sm btn-default" data-toggle="tooltip" title="Esta entrevista tiene enlaces a otras entrevistas"><i class="fa fa-link"></i></a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ $entrevista->entrevista_enlace->link_show }}">
                                    {{ $entrevista->entrevista->entrevista_codigo }}
                                </a>
                                @php($prioridad = $entrevista->entrevista->prioridad)
                                @include('partials.prioridad_ico')
                            </td>
                            <td >
                                <span class="resaltable">{{ $entrevista->entrevista->titulo }} </span>
                                @if($entrevista->entrevista->rel_dinamica()->count() > 0)
                                    <br><strong>Dinámicas:</strong>
                                    <ol>
                                        @foreach($entrevista->entrevista->rel_dinamica as $d)
                                            <li>{{ $d->dinamica }}</li>
                                        @endforeach
                                    </ol>
                                @endif
                            </td>
                            <td class="resaltable">
                                {{ nl2br($entrevista->entrevista->observaciones) }}

                            </td>
                            <td>
                                @if($entrevista->entrevista->puede_acceder_adjuntos())
                                    @if(strlen($entrevista->entrevista->html_transcripcion)>0)
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
                                                {!! nl2br($entrevista->entrevista->html_transcripcion)  !!}
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                    @else
                                        <span class="text-muted"> Entrevista sin transcripción</span>
                                    @endif
                                @else
                                    <span class="text-danger">Acceso restringido.</span>  Entrevista clasificada como R-{{ $entrevista->entrevista->clasifica_nivel }}
                                @endif
                            </td>
                            <td>
                                {{-- Aplicar marcas --}}
                                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_marca_{{ $entrevista->entrevista->id_e_ind_fvt  }}">
                                    <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                                </button>
                                {!!   \App\Models\marca_entrevista::listado_marcas_buscadora($entrevista->id_subserie,$entrevista->id_entrevista) !!}
                            </td>

                            @php($id_subserie = $entrevista->id_subserie)
                            @php($id_entrevista = $entrevista->id_entrevista)
                            @php($codigo_entrevista = $entrevista->entrevista->entrevista_codigo)
                            @include('marca_entrevistas.create')

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 no-print">
                {!! $listado->appends(Request::all())->render() !!}
            </div>
        </div>
    </section>



@else  {{-- Tabla de marcas y uso --}}
    <section id="resultados" class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-flag"></i> Marcas utilizadas por el usuario
                </h2>
            </div>
            <div class="col-xs-12 table-responsive">
                <table class="table table-condensed  table-hover">
                    <thead>
                        <tr>
                            <th style="width:2ch">#</th>
                            <th>Etiqueta</th>
                            <th style="width:4ch">Entrevistas marcadas</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php($i=1)
                    @foreach($uso_marcas as $fila)
                        @php($link = Request::url()."?marca[]=$fila->id_marca")
                        @php($link2 = "style='cursor: pointer;' onclick=\"window.location.href='$link';\" ")
                        <tr >
                            <td ><a href="{{ $link }}">{{ $i++ }}</a></td>
                            <td><a href="{{ $link }}">{{ $fila->texto }}</a></td>
                            <td class="text-center" ><a href="{{ $link }}">{{ $fila->conteo }}</a></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </section>


@endif





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

@endpush