<div class="table-responsive">
    <table class="table" id="historiaVidas-table">
        <thead>
            <tr>
                <th data-toggle="tooltip" title="Consecutivo asignado a la entrevista"># Entrev.</th>
                <th data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que la entrevista ha sido consultada por algún usuario">Código entrevista <br><i>(Consultas)</i></th>
                <th>Clasificación</th>
                <th data-toggle="tooltip" title="Se muestra la fecha de inicio">Fecha  entrevista</th>
                <th>Macroterritorio</th>
                <th>Territorio</th>
                {{--
                <th>Lugar de la entrevista</th>
                --}}
                <th>Nombre</th>
                <th>Otros nombres</th>

                <th>Sector</th>
                <th>Situación</th>
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
        @foreach($historiaVidas as $historiaVida)
            @php($link = "style='cursor: pointer;' onclick='window.location.href=".'"'.action('historia_vidaController@show',$historiaVida->id_historia_vida).'"'.";'")
            <tr>
                <td class="text-center">{!! $historiaVida->entrevista_correlativo !!}</td>
                <td {!! $link !!} data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que la entrevista ha sido consultada por algún usuario">{!! $historiaVida->entrevista_codigo !!}
                    <br>
                    <i>
                        ({{ \App\Models\entrevista_individual::conteo_hits($historiaVida) }})
                    </i>
                </td>
                <td>Reservada-{!! $historiaVida->clasificacion_nivel !!}
                    {{-- Priorizar --}}
                    <br>
                    {!! \App\Models\entrevista_individual::ico_prioridad($historiaVida) !!}
                </td>
                <td {!! $link !!} >{!! $historiaVida->fmt_entrevista_fecha_inicio !!}</td>

                <td {!! $link !!} >{!! $historiaVida->fmt_id_macroterritorio !!}</td>
                <td {!! $link !!} >{!! $historiaVida->fmt_id_territorio !!}</td>


                {{--
                <td {!! $link !!} >{!! $historiaVida->fmt_entrevista_lugar !!}</td>
                --}}
                {{--
                <td {!! $link !!} >{!! $entrevistaColectiva->fmt_id_territorio !!}</td>
                --}}
                <td {!! $link !!} >{!! $historiaVida->entrevistado_nombres !!}</td>
                <td {!! $link !!} >{!! $historiaVida->entrevistado_otros_nombres !!}</td>
                <td {!! $link !!} >{!! $historiaVida->fmt_id_sector !!}</td>
                <td {!! $link !!} >{!! $historiaVida->fmt_entrevista_avance !!}</td>
                <td {!! $link !!} class="text-center">{!! count($historiaVida->adjuntos) !!}</td>
                {{--
                    <td {!! $link !!} class="text-center">{!! $historiaVida->fmt_estado_transcripcion !!} {!! $historiaVida->fmt_id_cerrado !!}</td>
                --}}
                <td {!! $link !!}>
                    <span title="Transcrita" data-toggle="tooltip">{{ is_null($historiaVida->html_transcripcion) ? "No" : "Sí" }} </span> /
                    <span title="Etiquetada" data-toggle="tooltip">{{ is_null($historiaVida->json_etiquetado) ? "No" : "Sí" }} </span> /
                    <span title="Cerrada" data-toggle="tooltip">{!!   $historiaVida->id_cerrado==1 ? '<i class="fa fa-lock" aria-hidden="true"></i>' : '<i class="fa fa-unlock" aria-hidden="true"></i>' !!} </span>
                </td>
                <td>
                    <div class='btn-group'>
                        <a data-toggle="tooltip" title="Ver detalles del expediente"  href="{!! route('historiaVidas.show', [$historiaVida->id_historia_vida]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                        @if($historiaVida->puede_modificar_entrevista() )
                            <a data-toggle="tooltip" title="Modificar expediente" href="{!! route('historiaVidas.edit', [$historiaVida->id_historia_vida]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-toggle="tooltip" title="Gestionar archivos adjuntos"  href="{!! action('historia_vidaController@gestionar_adjuntos', [$historiaVida->id_historia_vida]) !!}" class='btn btn-default btn-sm'> <i class="glyphicon glyphicon-paperclip"></i></a>
                            {!!  $historiaVida->diligenciada->btn_consentimiento !!}
                        @endif
                        {{-- Otorgar acceso --}}
                        @if(\App\Models\entrevista_individual::revisar_conceder_acceso($historiaVida))
                            @can('sistema-abierto')
                                <a data-toggle="tooltip" title="Conceder acceso para modificar la entrevista"  href="{!! action('acceso_edicionController@create')."?id_subserie=".config('expedientes.hv')."&id_entrevista=$historiaVida->id_historia_vida" !!}" class='btn btn-default btn-sm '><i class="fa fa-share-alt text-danger" aria-hidden="true"></i>
                                </a>
                            @endcan
                            @if($historiaVida->clasificacion_nivel <=3 )
                                <a data-toggle="tooltip" title="Desclasificar: facilitar el acceso a los adjuntos"  href="{!! action('historia_vidaController@desclasificar',$historiaVida->id_historia_vida) !!}" class='btn btn-default btn-sm '><i class="fa fa-eye-slash text-danger" aria-hidden="true"></i> </a>
                            @endif
                        @endif
                    </div>
                </td>
                @can('sistema-abierto')
                    @can('nivel-10-al-11')
                        <td>
                            <div class='btn-group'>
                                {{-- Asignar para transcribir --}}
                                @if(in_array(\Auth::user()->id_nivel,[1,2,10])  )

                                    @if($historiaVida->tiene_audio == 1)
                                        @if($historiaVida->tiene_tf==0)
                                            <a data-toggle="tooltip" title="Asignar transcripcion." href="{!! url('transcribirAsignacions/create')."?id_hv=".$historiaVida->id_historia_vida !!}" class='btn btn-primary btn-sm'><i class="fa fa-headphones" aria-hidden="true"></i> </a>
                                        @else
                                            <a data-toggle="tooltip" title="Transcripción realizada" href="{!! url('transcribirAsignacions/create')."?id_hv=".$historiaVida->id_historia_vida !!}" class='btn btn-default btn-sm'><i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                                        @endif

                                    @else
                                        <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Sin archivo de audio">
                                            <i class="fa fa-volume-up text-danger" data-toggle="tooltip" title="Sin archivo de audio"></i>
                                        </button>
                                    @endif

                                    {{-- Asignar para etiquetar --}}

                                    @if($historiaVida->tiene_etiquetado)
                                        <a data-toggle="tooltip" title="Etiquetado realizado" href="{!! url('etiquetarAsignacions/create')."?id_hv=".$historiaVida->id_historia_vida !!}" class='btn btn-default btn-sm'><i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                                    @else
                                        @if($historiaVida->tiene_transcripcion)  {{-- Con transcripcion --}}
                                            @if( $historiaVida->asignado_etiquetado == 0) {{-- No asignada --}}
                                                <a data-toggle="tooltip" title="Asignar etiquetado. " href="{!! url('etiquetarAsignacions/create')."?id_hv=".$historiaVida->id_historia_vida !!}" class='btn btn-primary btn-sm'><i class="fa fa-tags" aria-hidden="true"></i> </a>
                                            @else
                                                <a data-toggle="tooltip" title="Asignada para etiquetar. " href="#" class='btn btn-default btn-sm'><i class="fa fa-tags text-warning" aria-hidden="true"></i> </a>
                                            @endif
                                        @else
                                            <a data-toggle="tooltip" title="Sin transcripción. " href="#" class='btn btn-default btn-sm'><i class="fa fa-tags text-danger" aria-hidden="true"></i> </a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </td>
                    @endcan

                    {{-- Marcas --}}
                    <td>
                        {{-- Aplicar marcas --}}
                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" title='Marcar entrevista' data-target="#modal_marca_{{ config('expedientes.hv') }}_{{ $historiaVida->id_historia_vida  }}">
                            <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                        </button>
                        {!!   \App\Models\marca_entrevista::listado_marcas(config('expedientes.hv'),$historiaVida->id_historia_vida) !!}
                    </td>
                @endcan
            </tr>
            @php($id_subserie = config('expedientes.hv'))
            @php($id_entrevista = $historiaVida->id_historia_vida)
            @php($codigo_entrevista = $historiaVida->entrevista_codigo)
            @include('marca_entrevistas.create')

        @endforeach
        </tbody>
    </table>
</div>


{{-- Priorizacion del entrevistador --}}
@include("seguimiento.modal_priorizar")

