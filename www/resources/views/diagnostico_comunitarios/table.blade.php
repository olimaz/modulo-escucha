<div class="table-responsive table-condensed table-hover">
    <table class="table" id="diagnosticoComunitarios-table">
        <thead>
            <tr>
                <th data-toggle="tooltip" title="Consecutivo asignado a la entrevista"># Entrev.</th>
                <th data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que la entrevista ha sido consultada por algún usuario">Código entrevista <br><i>(Consultas)</i></th>
                <th>Clasificación</th>
                <th data-toggle="tooltip" title="Se muestra la fecha de inicio">Fecha  entrevista</th>
                <th>Macroterritorio</th>
                <th>Territorio</th>
                {{--
                <th>Territorio</th>
                --}}
                <th>Comunidad/Organización</th>
                <th>Sector</th>
                <th>Situación</th>
                <th data-toggle="tooltip" title="Cantidad de personas escuchadas">Participantes</th>
                <th data-toggle="tooltip" title="Cantidad de archivos adjuntos">Adjuntos</th>
                <th data-toggle="tooltip" title="Transcrita / Etiquetada / Cerrada" style="width:90px">Trans / Etiq / Cerrada</th>
                <th>Acciones</th>
                @can('sistema-abierto')
                    @can('nivel-10-al-11')
                        <th>Procesamiento</th>
                    @endcan
                    <th>Marcas</th>
                @endcan

            </tr>
        </thead>
        <tbody>
        @foreach($diagnosticoComunitarios as $diagnosticoComunitario)
            @php($link = "style='cursor: pointer;' onclick='window.location.href=".'"'.action('diagnostico_comunitarioController@show',$diagnosticoComunitario->id_diagnostico_comunitario).'"'.";'")
            <tr>
                <td>{!! $diagnosticoComunitario->entrevista_correlativo !!}</td>
                <td {!! $link !!} class="text-center" data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que la entrevista ha sido consultada por algún usuario"  >{!! $diagnosticoComunitario->entrevista_codigo !!}
                    <br>
                    <i>
                        ({{ \App\Models\entrevista_individual::conteo_hits($diagnosticoComunitario) }})
                    </i>
                </td>
                <td class="text-center">Reservada-{!! $diagnosticoComunitario->clasificacion_nivel !!}
                    {{-- Priorizar --}}
                    <br>
                    {!! \App\Models\entrevista_individual::ico_prioridad($diagnosticoComunitario) !!}
                </td>
                <td {!! $link !!} >{!! $diagnosticoComunitario->fmt_entrevista_fecha_inicio !!}</td>

                <td {!! $link !!} >{!! $diagnosticoComunitario->fmt_id_macroterritorio !!}</td>
                <td {!! $link !!} >{!! $diagnosticoComunitario->fmt_id_territorio !!}</td>


                <td {!! $link !!} >{!! $diagnosticoComunitario->tema_comunidad !!}</td>
                <td {!! $link !!} >{!! $diagnosticoComunitario->fmt_id_sector !!}</td>
                <td {!! $link !!} >{!! $diagnosticoComunitario->fmt_entrevista_avance !!}</td>
                <td {!! $link !!} >{!! $diagnosticoComunitario->cantidad_participantes !!}</td>
                <td {!! $link !!} class="text-center">{!! count($diagnosticoComunitario->adjuntos) !!}</td>
                {{--
                    <td {!! $link !!} class="text-center">{!! $diagnosticoComunitario->fmt_estado_transcripcion !!} {!! $diagnosticoComunitario->fmt_id_cerrado !!}</td>
                --}}
                <td {!! $link !!}>
                    <span title="Transcrita" data-toggle="tooltip">{{ is_null($diagnosticoComunitario->html_transcripcion) ? "No" : "Sí" }} </span> /
                    <span title="Etiquetada" data-toggle="tooltip">{{ is_null($diagnosticoComunitario->json_etiquetado) ? "No" : "Sí" }} </span> /
                    <span title="Cerrada" data-toggle="tooltip">{!!   $diagnosticoComunitario->id_cerrado==1 ? '<i class="fa fa-lock" aria-hidden="true"></i>' : '<i class="fa fa-unlock" aria-hidden="true"></i>' !!} </span>
                </td>
                <td>
                    <div class='btn-group'>
                        <a data-toggle="tooltip" title="Ver detalles del expediente"  href="{!! route('diagnosticoComunitarios.show', [$diagnosticoComunitario->id_diagnostico_comunitario]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                        @if($diagnosticoComunitario->puede_modificar_entrevista() )
                            <a data-toggle="tooltip" title="Modificar expediente" href="{!! route('diagnosticoComunitarios.edit', [$diagnosticoComunitario->id_diagnostico_comunitario]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-toggle="tooltip" title="Gestionar archivos adjuntos"  href="{!! action('diagnostico_comunitarioController@gestionar_adjuntos', [$diagnosticoComunitario->id_diagnostico_comunitario]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-paperclip"></i></a>
                        @endif
                        {{-- Otorgar acceso --}}
                        @if(\App\Models\entrevista_individual::revisar_conceder_acceso($diagnosticoComunitario))
                            @can('sistema-abierto')
                                <a data-toggle="tooltip" title="Conceder acceso para modificar la entrevista"  href="{!! action('acceso_edicionController@create')."?id_subserie=".config('expedientes.dc')."&id_entrevista=$diagnosticoComunitario->id_diagnostico_comunitario" !!}" class='btn btn-default btn-sm '><i class="fa fa-share-alt text-danger" aria-hidden="true"></i>
                                </a>
                            @endcan
                            @if($diagnosticoComunitario->clasificacion_nivel <=3 )
                                <a data-toggle="tooltip" title="Desclasificar: facilitar el acceso a los adjuntos"  href="{!! action('diagnostico_comunitarioController@desclasificar',$diagnosticoComunitario->id_diagnostico_comunitario) !!}" class='btn btn-default btn-sm '><i class="fa fa-eye-slash text-danger" aria-hidden="true"></i> </a>
                            @endif
                        @endif
                    </div>
                </td>
                @can('sistema-abierto')
                    {{-- transcribir --}}
                    @can('nivel-10-al-11')
                        <td>
                            <div class='btn-group'>
                                {{-- Asignar para transcribir --}}
                                @if(in_array(\Auth::user()->id_nivel,[1,2,10])  )

                                    @if($diagnosticoComunitario->tiene_audio == 1)
                                        @if($diagnosticoComunitario->tiene_tf==0)
                                            <a data-toggle="tooltip" title="Asignar transcripcion" href="{!! url('transcribirAsignacions/create')."?id_dc=".$diagnosticoComunitario->id_diagnostico_comunitario !!}" class='btn btn-default btn-sm'><i class="fa fa-headphones" aria-hidden="true"></i> </a>
                                        @else
                                            <a data-toggle="tooltip" title="Transcripción realizada" href="{!! url('transcribirAsignacions/create')."?id_dc=".$diagnosticoComunitario->id_diagnostico_comunitario !!}" class='btn btn-default btn-sm'><i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                                        @endif

                                    @else
                                        <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Sin archivo de audio">
                                            <i class="fa fa-volume-up text-danger" data-toggle="tooltip" title="Sin archivo de audio"></i>
                                        </button>
                                    @endif

                                    {{-- Asignar para etiquetar --}}

                                    @if($diagnosticoComunitario->tiene_etiquetado)
                                        <a data-toggle="tooltip" title="Etiquetado realizado" href="{!! url('etiquetarAsignacions/create')."?id_dc=".$diagnosticoComunitario->id_diagnostico_comunitario !!}" class='btn btn-default btn-sm'><i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                                    @else
                                        @if($diagnosticoComunitario->tiene_transcripcion)  {{-- Con transcripcion --}}
                                            @if( $diagnosticoComunitario->asignado_etiquetado == 0) {{-- No asignada --}}
                                                <a data-toggle="tooltip" title="Asignar etiquetado. " href="{!! url('etiquetarAsignacions/create')."?id_dc=".$diagnosticoComunitario->id_diagnostico_comunitario  !!}" class='btn btn-primary btn-sm'><i class="fa fa-tags" aria-hidden="true"></i> </a>
                                            @else
                                                <a data-toggle="tooltip" title="Asignada para etiquetar. " href="#" class='btn btn-default btn-sm'><i class="fa fa-tags text-warning" aria-hidden="true"></i> </a>
                                            @endif
                                        @else
                                            <a data-toggle="tooltip" title="Sin transcripción. " href="#" class='btn btn-default btn-sm'><i class="fa fa-tags text-danger" aria-hidden="true"></i> </a>
                                        @endif
                                    @endif
                                @endif
                            </div>

                            {{-- Trasladar a EE --}}
                            <span data-toggle="tooltip" title="Trasladar a entrevista a sujeto colectivo">
                                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_traslada_ee_{{ $diagnosticoComunitario->id_diagnostico_comunitario  }}">
                                    <i class="fa fa-users text-danger " aria-hidden="true"></i>
                                </button>
                            </span>

                        </td>
                    @endcan
                    <td>
                        {{-- Aplicar marcas --}}
                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" title='Marcar entrevista' data-target="#modal_marca_{{ config('expedientes.dc') }}_{{ $diagnosticoComunitario->id_diagnostico_comunitario  }}">
                            <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                        </button>
                        {!!   \App\Models\marca_entrevista::listado_marcas(config('expedientes.dc'),$diagnosticoComunitario->id_diagnostico_comunitario) !!}
                    </td>
                @endcan

            </tr>
            @php($id_subserie = config('expedientes.dc'))
            @php($id_entrevista = $diagnosticoComunitario->id_diagnostico_comunitario)
            @php($codigo_entrevista = $diagnosticoComunitario->entrevista_codigo)
            @include('marca_entrevistas.create')
            @include('partials.frm_trasladar_dc_ee')
        @endforeach
        </tbody>
    </table>
</div>

{{-- Priorizacion del entrevistador --}}
@include("seguimiento.modal_priorizar")
