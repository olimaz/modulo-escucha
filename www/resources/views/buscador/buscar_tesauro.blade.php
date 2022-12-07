{!!  Form::model($filtros, ['action' =>'statController@buscadora', 'method' => 'get']) !!}
<input type="hidden" name="p" value="2">
<div class="col-sm-12" >

    <div class="col-xs-8">
        @include('controles.tesauro3', ['control_control' => 'id_tesauro'
                                            , 'control_default'=>$filtros->id_tesauro
                                            , 'control_vacio' => '[Mostrar todos]'
                                           ,'control_texto'=>'&nbsp;'])

    </div>
    <div class="col-xs-4 text-left" style="padding-top: 50px">

        <button class="btn bg-purple" type="submit" title="Realizar búsqueda" data-toggle="tooltip">Buscar <i class="fa fa-search"></i></button>
        <a  class="btn btn-default"  data-toggle="collapse" href="#frm_avanzado_tes"  ><i class="fa fa-eyedropper "></i> Opciones avanzadas</a>
    </div>
</div>
<div class="clearfix"></div>
@include("buscador.frm_filtros", ["frm_id"=>"frm_avanzado_tes", "ocultar_tes"=>true])
{!! Form::close() !!}






@if($activa==2)
    <div class="clearfix" ></div>
    @if($filtros->id_tesauro > 0 )

    <div class="box {{  $tesauro->total() > 0 ? " box-success " : " box-warning "  }} " id="box_general">
        <div class="box-header">
            <h3 class="box-title">
                Resultados para la búsqueda: {{  $tesauro->total() }} párrafos
            </h3>
            <div class="box-tools pull-right">
                @if($tesauro->total() > 0)
                    @include("buscador.boton_descargar_etiquetado")
                @endif

            </div>
        </div>
        <div class="box-body no-padding table-responsive">
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                <tr>
                    <th style="width:2ch">#</th>
                    <th style="width:15ch">Entrevista</th>
                    <th style="width:15vw">Etiqueta</th>
                    <th style="width:25vw">Texto marcado</th>
                    <th>Transcripción</th>
                    @can('sistema-abierto')
                        <th style="width:2ch">Marcas</th>
                    @endcan
                </tr>
                </thead>
                <tbody>
                @php($i = $tesauro->firstItem())
                @foreach($tesauro as $fila)
                    <tr>
                        <td> {{ $i++ }}
                            {{-- Enlaces y unificaciones --}}
                            @php($listado_enlaces = \App\Models\enlace::listado_enlaces($fila->id_subserie,$fila->id_entrevista))
                            @if(count($listado_enlaces)>0)
                                <a href="{{ $fila->entrevista->url }}"  target="_blank" class="btn btn-sm btn-default" data-toggle="tooltip" title="Esta entrevista tiene enlaces a otras entrevistas"><i class="fa fa-link"></i></a>
                            @endif
                        </td>
                        <td> {!!   $fila->entrevista_codigo !!}


                            @php($prioridad = $fila->entrevista->entrevista->prioridad)
                            @include('partials.prioridad_ico')
                        </td>
                        <td> {!! $fila->fmt_id_etiqueta !!}</td>
                        <td> {{ $fila->texto }}</td>
                        <td>
                            @if($fila->entrevista->entrevista->puede_acceder_adjuntos())
                                @if(strlen($fila->entrevista->entrevista->html_transcripcion)>0)
                                    <div class="box box-default collapsed-box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Etiquetado completo</h3>

                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                            <!-- /.box-tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body resaltable">
                                            {!! nl2br($fila->entrevista->entrevista->etiquetado->texto_resaltado)  !!}
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                @else
                                    <span class="text-muted"> Entrevista sin transcripción</span>
                                @endif
                            @else
                                <span class="text-danger">Acceso restringido.</span>  Entrevista clasificada como R-{{ $fila->entrevista->entrevista->clasifica_nivel }}
                            @endif
                        </td>
                        @can('sistema-abierto')
                        <td>
                            @include("retroalimentacion.frm_reporte")
                            {{-- Aplicar marcas --}}
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_marca_{{ $fila->id_entrevista }}_{{ $fila->id_subserie }}">
                                <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                            </button>
                            {!!   \App\Models\marca_entrevista::listado_marcas_buscadora($fila->id_subserie,$fila->id_entrevista) !!}
                        </td>
                        @endcan

                    </tr>

                @endforeach

                </tbody>

            </table>
        </div>
        <div class="box-footer">
            {!! $tesauro->appends(Request::all())->render() !!}
        </div>
    </div>

    @foreach($tesauro as $fila)
        @php($id_subserie = $fila->id_subserie)
        @php($id_entrevista = $fila->id_entrevista)
        @php($codigo_entrevista = $fila->entrevista->entrevista->entrevista_codigo)
        @include('marca_entrevistas.create2')
    @endforeach

@endif
@endif

<div class="clearfix" ></div>



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
        @if($filtros->hay_filtro_buscadora && $filtros->id_tesauro > 0)
            <Script>
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#ir_resultados_tes").offset().top
                }, 2000);
            </Script>

        @endif


@endpush