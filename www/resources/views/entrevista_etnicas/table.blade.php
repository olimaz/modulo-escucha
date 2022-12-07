<div class="table-responsive table-condensed table-hover">
    <table class="table" id="entrevistaEtnicas-table">
        <thead>
            <tr>
                <th data-toggle="tooltip" title="Consecutivo asignado a la entrevista"># Entrev.</th>
                <th data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que la entrevista ha sido consultada por algún usuario">Código entrevista <br><i>(Consultas)</i></th>
                <th>Clasificación</th>
                <th>Macroterritorio</th>
                <th>Territorio</th>
                <th>Situación</th>
                <th data-toggle="tooltip" title="Cantidad de personas escuchadas">Participantes</th>
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
        @foreach($entrevistaEtnicas as $entrevistaEtnica)
            @php($link = "style='cursor: pointer;' onclick='window.location.href=".'"'.action('entrevista_etnicaController@show',$entrevistaEtnica->id_entrevista_etnica).'"'.";'")
            <tr>
                <td>{!! $entrevistaEtnica->entrevista_correlativo !!}</td>
                <td {!! $link !!} class="text-center" data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que la entrevista ha sido consultada por algún usuario">{!! $entrevistaEtnica->entrevista_codigo !!}
                    <br>
                    <i>
                        ({{ \App\Models\entrevista_individual::conteo_hits($entrevistaEtnica) }})
                    </i>
                </td>
                <td  >Reservada-{!! $entrevistaEtnica->clasificacion_nivel !!}
                    {{-- Priorizar --}}
                    <br>
                    {!! \App\Models\entrevista_individual::ico_prioridad($entrevistaEtnica) !!}
                </td>
                <td {!! $link !!}>{!! $entrevistaEtnica->fmt_id_macroterritorio !!}</td>
                <td {!! $link !!}>{!! $entrevistaEtnica->fmt_id_territorio !!}</td>
                <td {!! $link !!}>{!! $entrevistaEtnica->fmt_entrevista_avance !!}</td>

                <td {!! $link !!} class="text-center">{!! $entrevistaEtnica->cantidad_participantes !!}</td>
                <td {!! $link !!} class="text-center">{!! count($entrevistaEtnica->adjuntos) !!}</td>
                {{--
                <td {!! $link !!} class="text-center">{!! $entrevistaEtnica->fmt_estado_transcripcion !!} {!! $entrevistaEtnica->fmt_id_cerrado !!}</td>
                --}}
                <td {!! $link !!}>
                    <span title="Transcrita" data-toggle="tooltip">{{ is_null($entrevistaEtnica->html_transcripcion) ? "No" : "Sí" }} </span> /
                    <span title="Etiquetada" data-toggle="tooltip">{{ is_null($entrevistaEtnica->json_etiquetado) ? "No" : "Sí" }} </span> /
                    <span title="Cerrada" data-toggle="tooltip">{!!   $entrevistaEtnica->id_cerrado==1 ? '<i class="fa fa-lock" aria-hidden="true"></i>' : '<i class="fa fa-unlock" aria-hidden="true"></i>' !!} </span>
                </td>
                <td>
                    <div class='btn-group'>
                        <a data-toggle="tooltip" title="Ver detalles del expediente"  href="{!! route('entrevistaEtnicas.show', [$entrevistaEtnica->id_entrevista_etnica]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                        @if($entrevistaEtnica->puede_modificar_entrevista() )
                            <a data-toggle="tooltip" title="Modificar expediente" href="{!! route('entrevistaEtnicas.edit', [$entrevistaEtnica->id_entrevista_etnica]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-toggle="tooltip" title="Gestionar archivos adjuntos"  href="{!! action('entrevista_etnicaController@gestionar_adjuntos', [$entrevistaEtnica->id_entrevista_etnica]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-paperclip"></i></a>
                        
                            {{-- diligenciar fichas: cambio 03/2020 --}}
                            @if($entrevistaEtnica->id_subserie == config('expedientes.ee'))
                                <a data-toggle="tooltip" title="Diligenciar fichas: {{ $entrevistaEtnica->diligenciada->situacion_texto }}"  href="{!! action('entrevista_etnicaController@fichas', [$entrevistaEtnica->id_entrevista_etnica]) !!}" class='btn {{ $entrevistaEtnica->diligenciada->situacion_boton }} btn-sm '><i class="glyphicon glyphicon-send"></i></a>                                
                            @endif                        

                        @endcan

                    {{-- Ver fichas --}}
                    @if($entrevistaEtnica->id_subserie == config('expedientes.ee'))
                        @if($entrevistaEtnica->clasifica_nivel == 3 && Gate::check('solo-lectura'))
                            {{--
                            <button class="btn btn-sm btn-default" disabled title="Restringida-3" data-toggle="tooltip"><i class="glyphicon glyphicon-send"></i></button>
                            --}}
                        @else
                            @if( $entrevistaEtnica->diligenciada->situacion==3)
                                <a data-toggle="tooltip" title="Fichas diligenciadas"  href="{!! action('entrevista_etnicaController@fichas_show', [$entrevistaEtnica->id_entrevista_etnica]) !!}" class='btn btn-default  btn-sm '><i class="fa fa-paper-plane-o"></i></a>
                            @else
                                {{--
                                <button class="btn btn-sm btn-default" disabled title="Sin fichas diligenciadas" data-toggle="tooltip"><i class="glyphicon glyphicon-send"></i></button>
                                --}}
                            @endif
                        @endif
                    @endif

                        {{-- Otorgar acceso --}}
                        @if(\App\Models\entrevista_individual::revisar_conceder_acceso($entrevistaEtnica))
                            @can('sistema-abierto')
                            <a data-toggle="tooltip" title="Conceder acceso para modificar la entrevista"  href="{!! action('acceso_edicionController@create')."?id_subserie=".config('expedientes.ee')."&id_entrevista=$entrevistaEtnica->id_entrevista_etnica" !!}" class='btn btn-default btn-sm  '>
                                <i class="fa fa-share-alt text-danger" aria-hidden="true"></i>
                            </a>
                            @endcan
                            @if($entrevistaEtnica->clasificacion_nivel <=3 )
                                <a data-toggle="tooltip" title="Desclasificar: facilitar el acceso a los adjuntos"  href="{!! action('entrevista_etnicaController@desclasificar',$entrevistaEtnica->id_entrevista_etnica) !!}" class='btn btn-default btn-sm '><i class="fa fa-eye-slash text-danger" aria-hidden="true"></i> </a>
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
                                    @if($entrevistaEtnica->tiene_audio == 1)
                                        @if($entrevistaEtnica->tiene_tf==0)
                                            <a data-toggle="tooltip" title="Asignar transcripcion" href="{!! url('transcribirAsignacions/create')."?id_ee=".$entrevistaEtnica->id_entrevista_etnica !!}" class='btn btn-default btn-sm'><i class="fa fa-headphones" aria-hidden="true"></i> </a>
                                        @else
                                            <a data-toggle="tooltip" title="Transcripción realizada" href="{!! url('transcribirAsignacions/create')."?id_ee=".$entrevistaEtnica->id_entrevista_etnica !!}" class='btn btn-default btn-sm'><i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                                        @endif

                                    @else
                                        <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Sin archivo de audio">
                                            <i class="fa fa-volume-up text-danger" data-toggle="tooltip" title="Sin archivo de audio"></i>
                                        </button>
                                    @endif

                                    {{-- Asignar para etiquetar --}}
                                    @if($entrevistaEtnica->tiene_etiquetado)
                                        <a data-toggle="tooltip" title="Etiquetado realizado" href="{!! url('etiquetarAsignacions/create')."?id_ee=".$entrevistaEtnica->id_entrevista_etnica !!}" class='btn btn-default btn-sm'><i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                                    @else
                                        @if($entrevistaEtnica->tiene_transcripcion)  {{-- Con transcripcion --}}
                                        @if( $entrevistaEtnica->asignado_etiquetado == 0) {{-- No asignada --}}
                                        <a data-toggle="tooltip" title="Asignar etiquetado. " href="{!! url('etiquetarAsignacions/create')."?id_ee=".$entrevistaEtnica->id_entrevista_etnica !!}" class='btn btn-primary btn-sm'><i class="fa fa-tags" aria-hidden="true"></i> </a>
                                        @else
                                            <a data-toggle="tooltip" title="Asignada para etiquetar. " href="#" class='btn btn-default btn-sm'><i class="fa fa-tags text-warning" aria-hidden="true"></i> </a>
                                        @endif
                                        @else
                                            <a data-toggle="tooltip" title="Sin transcripción. " href="#" class='btn btn-default btn-sm'><i class="fa fa-tags text-danger" aria-hidden="true"></i> </a>
                                        @endif
                                    @endif

                                    {{-- Unificar entrevistas --}}
                                    <span data-toggle="tooltip" title="Unificar con otra entrevista">
                                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_unifica_{{ $entrevistaEtnica->id_entrevista_etnica  }}">
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
                            <a class="btn btn-default btn-sm " data-toggle="tooltip" title="Reportar problemas que requieran seguimiento"  href="{{ action('seguimientoController@create') }}?id_subserie={{ config('expedientes.ee') }}&id_entrevista={{ $entrevistaEtnica->id_entrevista_etnica  }}&devolver={{ urlencode(Request::fullurl()) }}"><i class="fa fa-warning text-yellow " aria-hidden="true"></i></a>
                        @endcan
                        @can('nivel-10-al-11')
                            {{-- Enlazar entrevistas --}}
                            <span data-toggle="tooltip" title="Enlazar con otra entrevista">
                                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_enlaza_{{ $entrevistaEtnica->id_entrevista_etnica  }}">
                                    <i class="fa fa-magnet " aria-hidden="true"></i>
                                </button>
                            </span>

                        @endcan
                        {{-- Aplicar marcas --}}
                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_marca_{{ config('expedientes.ee') }}_{{ $entrevistaEtnica->id_entrevista_etnica  }}">
                            <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                        </button>
                        {!!   \App\Models\marca_entrevista::listado_marcas(config('expedientes.ee'),$entrevistaEtnica->id_entrevista_etnica) !!}
                    </td>
                @endcan
            </tr>
            @php($id_subserie = config('expedientes.ee'))
            @php($id_entrevista = $entrevistaEtnica->id_entrevista_etnica)
            @php($codigo_entrevista = $entrevistaEtnica->entrevista_codigo)
            @include('marca_entrevistas.create')
            @include('partials.frm_enlazar')
            @include('partials.frm_unificar')
        @endforeach
        </tbody>
    </table>
</div>


{{-- Priorizacion del entrevistador --}}
@include("seguimiento.modal_priorizar")