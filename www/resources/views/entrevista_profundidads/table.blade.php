<div class="table-responsive">
    <table class="table" id="entrevistaProfundidads-table">
        <thead>
            <tr>
                <th data-toggle="tooltip" title="Consecutivo asignado a la entrevista"># Entrev.</th>
                <th data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que la entrevista ha sido consultada por algún usuario">Código entrevista <br><i>(Consultas)</i></th>
                <th>Clasificación</th>
                <th class="text-center">Tipo</th>
                <th data-toggle="tooltip" title="Se muestra la fecha de inicio">Fecha  entrevista</th>
                <th>Macroterritorio</th>
                <th>Territorio</th>
                <th>Sector</th>
                <th>Situación</th>
                <th data-toggle="tooltip" title="Cantidad de archivos adjuntos">Adjuntos</th>
                <th data-toggle="tooltip" title="Transcrita / Etiquetada / Cerrada" style="width:90px">Trans / Etiq / Cerrada</th>
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
        @foreach($entrevistaProfundidads as $entrevistaProfundidad)
            @php($link = "style='cursor: pointer;' onclick='window.location.href=".'"'.action('entrevista_profundidadController@show',$entrevistaProfundidad->id_entrevista_profundidad).'"'.";'")
            <tr>
                <td>{!! $entrevistaProfundidad->entrevista_correlativo !!}</td>
                <td {!! $link !!} class="text-center" data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que la entrevista ha sido consultada por algún usuario" >{!! $entrevistaProfundidad->entrevista_codigo !!}
                    <br>
                    <i>
                        ({{ \App\Models\entrevista_individual::conteo_hits($entrevistaProfundidad) }})
                    </i>
                </td>
                <td > Reservada-{!! $entrevistaProfundidad->clasificacion_nivel !!}
                    {{-- Priorizar --}}
                    <br>
                    {!! \App\Models\entrevista_individual::ico_prioridad($entrevistaProfundidad) !!}
                </td>
                <td {!! $link !!} >{!! $entrevistaProfundidad->fmt_id_tipo !!}</td>
                <td {!! $link !!} >{!! $entrevistaProfundidad->fmt_entrevista_fecha_inicio !!}</td>
                <td {!! $link !!} >{!! $entrevistaProfundidad->fmt_id_macroterritorio !!}</td>
                <td {!! $link !!} >{!! $entrevistaProfundidad->fmt_id_territorio !!}</td>
                <td {!! $link !!} >{!! $entrevistaProfundidad->fmt_id_sector !!}</td>
                <td {!! $link !!} >{!! $entrevistaProfundidad->fmt_entrevista_avance !!}</td>
                <td {!! $link !!} class="text-center">{!! count($entrevistaProfundidad->adjuntos) !!}</td>
                {{--
                <td {!! $link !!} >{!! $entrevistaProfundidad->fmt_estado_transcripcion !!} {!! $entrevistaProfundidad->fmt_id_cerrado !!}</td>
                --}}
                <td {!! $link !!}>
                    <span title="Transcrita" data-toggle="tooltip">{{ is_null($entrevistaProfundidad->html_transcripcion) ? "No" : "Sí" }} </span> /
                    <span title="Etiquetada" data-toggle="tooltip">{{ is_null($entrevistaProfundidad->json_etiquetado) ? "No" : "Sí" }} </span> /
                    <span title="Cerrada" data-toggle="tooltip">{!!   $entrevistaProfundidad->id_cerrado==1 ? '<i class="fa fa-lock" aria-hidden="true"></i>' : '<i class="fa fa-unlock" aria-hidden="true"></i>' !!} </span>
                </td>
                <td>
                    <div class='btn-group'>
                        <a data-toggle="tooltip" title="Ver detalles del expediente"  href="{!! route('entrevistaProfundidads.show', [$entrevistaProfundidad->id_entrevista_profundidad]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                        @if($entrevistaProfundidad->puede_modificar_entrevista() )
                            <a data-toggle="tooltip" title="Modificar expediente" href="{!! route('entrevistaProfundidads.edit', [$entrevistaProfundidad->id_entrevista_profundidad]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-toggle="tooltip" title="Gestionar archivos adjuntos"  href="{!! action('entrevista_profundidadController@gestionar_adjuntos', [$entrevistaProfundidad->id_entrevista_profundidad]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-paperclip"></i></a>
                            {!!  $entrevistaProfundidad->diligenciada->btn_consentimiento !!}
                        @endif
                        {!!  $entrevistaProfundidad->diligenciada->btn_show !!}
                        {{-- Otorgar acceso --}}
                        @if(\App\Models\entrevista_individual::revisar_conceder_acceso($entrevistaProfundidad))
                            @can('sistema-abierto')
                            <a data-toggle="tooltip" title="Conceder acceso para modificar la entrevista"  href="{!! action('acceso_edicionController@create')."?id_subserie=".config('expedientes.pr')."&id_entrevista=$entrevistaProfundidad->id_entrevista_profundidad" !!}" class='btn btn-default btn-sm '>
                                <i class="fa fa-share-alt text-danger" aria-hidden="true"></i>
                            </a>
                            @endcan
                            @if($entrevistaProfundidad->clasificacion_nivel <=3 )
                                <a data-toggle="tooltip" title="Desclasificar: facilitar el acceso a los adjuntos"  href="{!! action('entrevista_profundidadController@desclasificar',$entrevistaProfundidad->id_entrevista_profundidad) !!}" class='btn btn-default btn-sm '><i class="fa fa-eye-slash text-danger" aria-hidden="true"></i> </a>
                            @endif

                        @endif
                    </div>
                </td>
                @can('sistema-abierto')
                    {{-- transcribir --}}
                    @can('nivel-10')
                        @can('escritura')
                            <td>
                                <div class='btn-group'>
                                    {{-- Asignar para transcribir --}}
                                    @if($entrevistaProfundidad->tiene_audio == 1)
                                        @if($entrevistaProfundidad->tiene_tf==0)
                                            <a data-toggle="tooltip" title="Asignar transcripcion. {{ $entrevistaProfundidad->puede_transcribirse ? 'Cumple requisitos' :'Imcompleta' }}" href="{!! url('transcribirAsignacions/create')."?id_pr=".$entrevistaProfundidad->id_entrevista_profundidad !!}" class='btn {{ $entrevistaProfundidad->puede_transcribirse ? 'btn-primary' :'btn-default' }}  btn-sm'><i class="fa fa-headphones" aria-hidden="true"></i> </a>
                                        @else
                                            <a data-toggle="tooltip" title="Transcripción realizada" href="{!! url('transcribirAsignacions/create')."?id_pr=".$entrevistaProfundidad->id_entrevista_profundidad !!}" class='btn btn-default btn-sm'><i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                                        @endif

                                    @else
                                        <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Sin archivo de audio">
                                            <i class="fa fa-volume-up text-danger" data-toggle="tooltip" title="Sin archivo de audio"></i>
                                        </button>
                                    @endif

                                    {{-- Asignar para etiquetar --}}
                                    @if($entrevistaProfundidad->tiene_etiquetado)
                                        <a data-toggle="tooltip" title="Etiquetado realizado" href="{!! url('etiquetarAsignacions/create')."?id_pr=".$entrevistaProfundidad->id_entrevista_profundidad !!}" class='btn btn-default btn-sm'><i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                                    @else
                                        @if($entrevistaProfundidad->tiene_transcripcion)  {{-- Con transcripcion --}}
                                            @if( $entrevistaProfundidad->asignado_etiquetado == 0) {{-- No asignada --}}
                                                <a data-toggle="tooltip" title="Asignar etiquetado. " href="{!! url('etiquetarAsignacions/create')."?id_pr=".$entrevistaProfundidad->id_entrevista_profundidad !!}" class='btn btn-primary btn-sm'><i class="fa fa-tags" aria-hidden="true"></i> </a>
                                            @else
                                                <a data-toggle="tooltip" title="Asignada para etiquetar. " href="#" class='btn btn-default btn-sm'><i class="fa fa-tags text-warning" aria-hidden="true"></i> </a>
                                            @endif
                                        @else
                                            <a data-toggle="tooltip" title="Sin transcripción. " href="#" class='btn btn-default btn-sm'><i class="fa fa-tags text-danger" aria-hidden="true"></i> </a>
                                        @endif
                                    @endif

                                    {{-- Unificar entrevistas --}}
                                    <span data-toggle="tooltip" title="Unificar con otra entrevista">
                                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_unifica_{{ $entrevistaProfundidad->id_entrevista_profundidad  }}">
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
                            <a class="btn btn-default btn-sm " data-toggle="tooltip" title="Reportar problemas que requieran seguimiento"  href="{{ action('seguimientoController@create') }}?id_subserie={{ config('expedientes.pr') }}&id_entrevista={{$entrevistaProfundidad->id_entrevista_profundidad }}&devolver={{ urlencode(Request::fullurl()) }}"><i class="fa fa-warning text-yellow " aria-hidden="true"></i></a>
                        @endcan
                        @can('nivel-10-al-11')
                            {{-- Enlazar entrevistas --}}
                            <span data-toggle="tooltip" title="Enlazar con otra entrevista">
                                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_enlaza_{{ $entrevistaProfundidad->id_entrevista_profundidad  }}">
                                    <i class="fa fa-magnet " aria-hidden="true"></i>
                                </button>
                            </span>
                            {{-- Trasladar a CO --}}
                            <span data-toggle="tooltip" title="Trasladar a entrevista coleciva">
                                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_traslada_co_{{ $entrevistaProfundidad->id_entrevista_profundidad  }}">
                                    <i class="fa fa-users text-danger " aria-hidden="true"></i>
                                </button>
                            </span>
                        @endcan
                        {{-- Aplicar marcas --}}
                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_marca_{{ config('expedientes.pr') }}_{{ $entrevistaProfundidad->id_entrevista_profundidad  }}">
                            <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                        </button>
                        {!!   \App\Models\marca_entrevista::listado_marcas(config('expedientes.pr'),$entrevistaProfundidad->id_entrevista_profundidad) !!}
                    </td>
                @endcan
            </tr>
            @php($id_subserie = config('expedientes.pr'))
            @php($id_entrevista = $entrevistaProfundidad->id_entrevista_profundidad)
            @php($codigo_entrevista = $entrevistaProfundidad->entrevista_codigo)
            @include('marca_entrevistas.create')
            @include('partials.frm_enlazar')
            @include('partials.frm_unificar')
            @include('partials.frm_trasladar_pr_co')
        @endforeach
        </tbody>
    </table>
</div>



{{-- Priorizacion del entrevistador --}}
@include("seguimiento.modal_priorizar")