<div class="table-responsive table-condensed table-hover">
    <table class="table" id="entrevistaColectivas-table">
        <thead>
            <tr>

                <th data-toggle="tooltip" title="Consecutivo asignado a la entrevista"># Entrev.</th>
                <th data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que la entrevista ha sido consultada por algún usuario">Código entrevista <br><i>(Consultas)</i></th>
                <th>Clasificación</th>
                <th data-toggle="tooltip" title="Se muestra la fecha de inicio">Fecha  entrevista</th>

                <th>Lugar de la entrevista</th>
                {{--
                <th>Territorio</th>
                --}}

                <th>Fecha de los hechos</th>
                <th>Sector</th>
                <th>Situación</th>
                <th data-toggle="tooltip" title="Cantidad de personas escuchadas">Participantes</th>
                <th data-toggle="tooltip" title="Cantidad de archivos adjuntos">Adjuntos</th>
                <th data-toggle="tooltip" title="Transcrita / Etiquetada / Cerrada" style="width:90px" >Trans / Etiq / Cerrada</th>
                <th>Acciones</th>
                @can('sistema-abierto')
                @can('nivel-10')
                    <th>Procesamiento</th>
                @endcan
                <th>Seguimiento</th>
                @endcan

            </tr>
        </thead>
        <tbody>
        @foreach($entrevistaColectivas as $entrevistaColectiva)
            @php($link = "style='cursor: pointer;' onclick='window.location.href=".'"'.action('entrevista_colectivaController@show',$entrevistaColectiva->id_entrevista_colectiva).'"'.";'")
            <tr>
                <td>{!! $entrevistaColectiva->entrevista_correlativo !!}</td>
                <td {!! $link !!} class="text-center" data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que la entrevista ha sido consultada por algún usuario">{!! $entrevistaColectiva->entrevista_codigo !!}
                    <br>
                    <i>
                        ({{ \App\Models\entrevista_individual::conteo_hits($entrevistaColectiva) }})
                    </i>
                </td>
                <td  class="text-center">Reservada-{!! $entrevistaColectiva->clasificacion_nivel !!}
                    <br>
                    {{-- Priorizar --}}
                    {!! \App\Models\entrevista_individual::ico_prioridad($entrevistaColectiva) !!}
                </td>
                <td {!! $link !!} >{!! $entrevistaColectiva->fmt_entrevista_fecha_inicio !!}</td>

                <td {!! $link !!} >{!! $entrevistaColectiva->fmt_entrevista_lugar !!}</td>
                {{--
                <td {!! $link !!} >{!! $entrevistaColectiva->fmt_id_territorio !!}</td>
                <td {!! $link !!} >{!! $entrevistaColectiva->equipo_facilitador !!}</td>
                --}}
                <td {!! $link !!} >{!! $entrevistaColectiva->fmt_tema_fecha !!}</td>
                <td {!! $link !!} >{!! $entrevistaColectiva->fmt_id_sector !!}</td>
                <td {!! $link !!} >{!! $entrevistaColectiva->fmt_entrevista_avance !!}</td>
                <td {!! $link !!} class="text-center">{!! $entrevistaColectiva->cantidad_participantes !!}</td>
                <td {!! $link !!} class="text-center">{!! count($entrevistaColectiva->adjuntos) !!}</td>
                {{--
                <td {!! $link !!} class="text-center">{!! $entrevistaColectiva->fmt_estado_transcripcion !!} {!! $entrevistaColectiva->fmt_id_cerrado !!}</td>
                --}}
                <td {!! $link !!}>
                    <span title="Transcrita" data-toggle="tooltip">{{ is_null($entrevistaColectiva->html_transcripcion) ? "No" : "Sí" }} </span> /
                    <span title="Etiquetada" data-toggle="tooltip">{{ is_null($entrevistaColectiva->json_etiquetado) ? "No" : "Sí" }} </span>  /
                    <span title="Cerrada" data-toggle="tooltip">{!!   $entrevistaColectiva->id_cerrado==1 ? '<i class="fa fa-lock" aria-hidden="true"></i>' : '<i class="fa fa-unlock" aria-hidden="true"></i>' !!} </span>
                </td>
                <td>
                    <div class='btn-group'>
                        <a data-toggle="tooltip" title="Ver detalles del expediente"  href="{!! route('entrevistaColectivas.show', [$entrevistaColectiva->id_entrevista_colectiva]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                        @if($entrevistaColectiva->puede_modificar_entrevista() )
                            <a data-toggle="tooltip" title="Modificar expediente" href="{!! route('entrevistaColectivas.edit', [$entrevistaColectiva->id_entrevista_colectiva]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-toggle="tooltip" title="Gestionar archivos adjuntos"  href="{!! action('entrevista_colectivaController@gestionar_adjuntos', [$entrevistaColectiva->id_entrevista_colectiva]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-paperclip"></i></a>
                        @endcan
                        {{-- Otorgar acceso --}}
                        @if(\App\Models\entrevista_individual::revisar_conceder_acceso($entrevistaColectiva))
                            @can('sistema-abierto')
                                <a data-toggle="tooltip" title="Conceder acceso para modificar la entrevista"  href="{!! action('acceso_edicionController@create')."?id_subserie=".config('expedientes.co')."&id_entrevista=$entrevistaColectiva->id_entrevista_colectiva" !!}" class='btn btn-default btn-sm '><i class="fa fa-share-alt text-danger" aria-hidden="true"></i>
                                </a>
                            @endcan
                            @if($entrevistaColectiva->clasificacion_nivel <=3 )
                                <a data-toggle="tooltip" title="Desclasificar: facilitar el acceso a los adjuntos"  href="{!! action('entrevista_colectivaController@desclasificar',$entrevistaColectiva->id_entrevista_colectiva) !!}" class='btn btn-default btn-sm '><i class="fa fa-eye-slash text-danger" aria-hidden="true"></i> </a>
                            @endif
                        @endif


                    </div>
                </td>
                @can('sistema-abierto')
                    @can('nivel-10')
                        @can('escritura')
                            <td>
                                <div class='btn-group'>
                                    {{-- Asignar para transcribir --}}
                                    @if($entrevistaColectiva->tiene_audio == 1)
                                        @if($entrevistaColectiva->tiene_tf==0)
                                            <a data-toggle="tooltip" title="Asignar transcripcion." href="{!! url('transcribirAsignacions/create')."?id_co=".$entrevistaColectiva->id_entrevista_colectiva !!}" class='btn btn-primary btn-sm'><i class="fa fa-headphones" aria-hidden="true"></i> </a>
                                        @else
                                            <a data-toggle="tooltip" title="Transcripción realizada" href="{!! url('transcribirAsignacions/create')."?id_co=".$entrevistaColectiva->id_entrevista_colectiva !!}" class='btn btn-default btn-sm'><i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                                        @endif

                                    @else
                                        <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Sin archivo de audio">
                                            <i class="fa fa-volume-up text-danger" data-toggle="tooltip" title="Sin archivo de audio"></i>
                                        </button>
                                    @endif

                                    {{-- Asignar para etiquetar --}}
                                    @if($entrevistaColectiva->tiene_etiquetado)
                                        <a data-toggle="tooltip" title="Etiquetado realizado" href="{!! url('etiquetarAsignacions/create')."?id_co=".$entrevistaColectiva->id_entrevista_colectiva !!}" class='btn btn-default btn-sm'><i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                                    @else
                                        @if($entrevistaColectiva->tiene_transcripcion)  {{-- Con transcripcion --}}
                                        @if( $entrevistaColectiva->asignado_etiquetado == 0) {{-- No asignada --}}
                                        <a data-toggle="tooltip" title="Asignar etiquetado. " href="{!! url('etiquetarAsignacions/create')."?id_co=".$entrevistaColectiva->id_entrevista_colectiva !!}" class='btn btn-primary btn-sm'><i class="fa fa-tags" aria-hidden="true"></i> </a>
                                        @else
                                            <a data-toggle="tooltip" title="Asignada para etiquetar. " href="#" class='btn btn-default btn-sm'><i class="fa fa-tags text-warning" aria-hidden="true"></i> </a>
                                        @endif
                                        @else
                                            <a data-toggle="tooltip" title="Sin transcripción. " href="#" class='btn btn-default btn-sm'><i class="fa fa-tags text-danger" aria-hidden="true"></i> </a>
                                        @endif
                                    @endif

                                    {{-- Unificar entrevistas --}}
                                    <span data-toggle="tooltip" title="Unificar con otra entrevista">
                                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_unifica_{{ $entrevistaColectiva->id_entrevista_colectiva  }}">
                                            <i class="fa fa-gavel text-danger" aria-hidden="true"></i>
                                        </button>
                                    </span>

                                </div>
                            </td>
                        @endcan
                    @endcan


                    <td>
                        {{-- Seguimiento: Reportar problemas--}}
                        @can('seguimiento')
                            <a class="btn btn-default btn-sm " data-toggle="tooltip" title="Reportar problemas que requieran seguimiento"  href="{{ action('seguimientoController@create') }}?id_subserie={{ config('expedientes.co') }}&id_entrevista={{ $entrevistaColectiva->id_entrevista_colectiva }}&devolver={{ urlencode(Request::fullurl()) }}"><i class="fa fa-warning text-yellow " aria-hidden="true"></i></a>
                        @endcan
                        @can('nivel-10-al-11')
                            {{-- Enlazar entrevistas --}}
                            <span data-toggle="tooltip" title="Enlazar con otra entrevista">
                                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_enlaza_{{ $entrevistaColectiva->id_entrevista_colectiva  }}">
                                    <i class="fa fa-magnet " aria-hidden="true"></i>
                                </button>
                            </span>

                            {{-- Trasladar a EE --}}
                            <span data-toggle="tooltip" title="Trasladar a entrevista a sujeto colectivo">
                                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_traslada_ee_{{ $entrevistaColectiva->id_entrevista_colectiva  }}">
                                    <i class="fa fa-users text-danger " aria-hidden="true"></i>
                                </button>
                            </span>
                        @endcan
                        {{-- Aplicar marcas --}}
                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" title='Marcar entrevista' data-target="#modal_marca_{{ config('expedientes.co') }}_{{ $entrevistaColectiva->id_entrevista_colectiva  }}">
                            <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                        </button>
                        {!!   \App\Models\marca_entrevista::listado_marcas(config('expedientes.co'),$entrevistaColectiva->id_entrevista_colectiva) !!}
                    </td>
                @endcan

            </tr>
            @php($id_subserie = config('expedientes.co'))
            @php($id_entrevista = $entrevistaColectiva->id_entrevista_colectiva)
            @php($codigo_entrevista = $entrevistaColectiva->entrevista_codigo)
            @include('marca_entrevistas.create')
            @include('partials.frm_enlazar')
            @include('partials.frm_unificar')
            @include('partials.frm_trasladar_co_ee')
        @endforeach
        </tbody>
    </table>
</div>



{{-- Priorizacion del entrevistador --}}
@include("seguimiento.modal_priorizar")