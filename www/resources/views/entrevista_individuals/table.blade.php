<table class="table table-responsive table-hover" id="entrevistaIndividuals-table">
    <thead>
        <tr>
            <th data-toggle="tooltip" title="Consecutivo asignado a la entrevista"># Entrev.</th>
            <th data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que la entrevista ha sido consultada por algún usuario">Código entrevista <br><i>(Consultas)</i></th>
            <th>Clasificación</th>
            <th>Macroterritorio</th>
            <th>Territorio</th>
            <th>Fecha de los hechos</th>
            <th data-toggle="tooltip" title="Cantidad de archivos adjuntos">Adjuntos</th>
            <th data-toggle="tooltip" title="Transcrita / Etiquetada / Cerrada" style="width:90px">Trans / Etiq / Cerrada</th>
            <th >Acciones</th>
            @can('sistema-abierto')
                @can('nivel-10')
                    @can('escritura')
                        <th>Procesamiento</th>
                    @endcan
                @endcan
                <th>Seguimiento</th>
            @endcan
        </tr>
    </thead>
    <tbody>
    @foreach($entrevistaIndividuals as $entrevistaIndividual)
        <tr >
            @php($link = "style='cursor: pointer;' onclick='window.location.href=".'"'.action('entrevista_individualController@show',$entrevistaIndividual->id_e_ind_fvt).'"'.";'")
            <td {!! $link !!} class="text-center {{ \Gate::allows('nivel-6') && \Gate::allows('es-propio',$entrevistaIndividual->id_entrevistador) ? "bg-red " : "" }}">
                {!! $entrevistaIndividual->entrevista_correlativo !!}
            </td>
            {{--
            <td {!! $link !!} class="text-center">{!! $entrevistaIndividual->numero_entrevistador !!}</td>
            --}}
            <td {!! $link !!} data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que la entrevista ha sido consultada por algún usuario" >{!! $entrevistaIndividual->entrevista_codigo !!}
                <br>
                <i>
                ({{ \App\Models\entrevista_individual::conteo_hits($entrevistaIndividual) }})
                </i>
            </td>
            <td >Reservada-{!! $entrevistaIndividual->clasifica_nivel !!}
                {{-- Priorizar --}}
                <br>
                {!! \App\Models\entrevista_individual::ico_prioridad($entrevistaIndividual) !!}
            </td>
            {{--
            <td {!! $link !!}>{!! $entrevistaIndividual->fmt_entrevista_fecha !!}</td>
            --}}
            <td {!! $link !!}>{!! $entrevistaIndividual->fmt_id_macroterritorio !!}</td>
            <td {!! $link !!}>{!! $entrevistaIndividual->fmt_id_territorio !!}</td>
            <td {!! $link !!}>{!! $entrevistaIndividual->fmt_fecha_hechos !!}</td>
            <td {!! $link !!} class="text-center">{!! $entrevistaIndividual->rel_adjunto()->count() !!}</td>
            {{--
                <td {!! $link !!} class="text-center">{!! $entrevistaIndividual->fmt_estado_transcripcion !!} {!! $entrevistaIndividual->fmt_id_cerrado !!}</td>
            --}}
            <td {!! $link !!}>
                <span title="Transcrita" data-toggle="tooltip">{{ is_null($entrevistaIndividual->html_transcripcion) ? "No" : "Sí" }} </span> /
                <span title="Etiquetada" data-toggle="tooltip">{{ is_null($entrevistaIndividual->json_etiquetado) ? "No" : "Sí" }} </span> /
                <span title="Cerrada" data-toggle="tooltip">{!!   $entrevistaIndividual->id_cerrado==1 ? '<i class="fa fa-lock" aria-hidden="true"></i>' : '<i class="fa fa-unlock" aria-hidden="true"></i>' !!} </span>

            </td>

            {{--
            <td {!! $link !!}>{!! $entrevistaIndividual->fmt_nna !!}</td>
            --}}
            <td>

                <div class='btn-group'>
                    <a data-toggle="tooltip" title="Ver detalles del expediente"  href="{!! route('entrevistaIndividuals.show', [$entrevistaIndividual->id_e_ind_fvt]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                    {!! $entrevistaIndividual->icono !!}
                    @if($entrevistaIndividual->puede_modificar_entrevista() )
                        <a data-toggle="tooltip" title="Modificar expediente" href="{!! route('entrevistaIndividuals.edit', [$entrevistaIndividual->id_e_ind_fvt]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                        <a data-toggle="tooltip" title="Gestionar archivos adjuntos"  href="{!! action('entrevista_individualController@gestionar_adjuntos', [$entrevistaIndividual->id_e_ind_fvt]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-paperclip"></i></a>
                        {{-- diligenciar fichas --}}
                        @if($entrevistaIndividual->id_subserie == config('expedientes.vi'))
                            @if($entrevistaIndividual->fichas_estado==1)
                                <a data-toggle="tooltip" title="Fichas diligenciadas por completo "  href="{!! action('entrevista_individualController@fichas', [$entrevistaIndividual->id_e_ind_fvt]) !!}" class='btn btn-success btn-sm '><i class="glyphicon glyphicon-send"></i></a>
                            @elseif($entrevistaIndividual->fichas_estado==2)
                                <a data-toggle="tooltip" title="Fichas parcialmente diligenciadas "  href="{!! action('entrevista_individualController@fichas', [$entrevistaIndividual->id_e_ind_fvt]) !!}" class='btn btn-warning btn-sm '><i class="glyphicon glyphicon-send"></i></a>
                            @else
                                <a data-toggle="tooltip" title="Fichas sin diligenciar "  href="{!! action('entrevista_individualController@fichas', [$entrevistaIndividual->id_e_ind_fvt]) !!}" class='btn btn-info btn-sm '><i class="glyphicon glyphicon-send"></i></a>
                            @endif
                        @else
                            {!!  $entrevistaIndividual->diligenciada_pe->btn_consentimiento !!}
                        @endif
                        {{--
                        @if($entrevistaIndividual->id_subserie == config('expedientes.aa'))
                           <a data-toggle="tooltip" title="Diligenciar fichas: {{ $entrevistaIndividual->diligenciada->situacion_texto }} "  href="{!! action('entrevista_individualController@fichas', [$entrevistaIndividual->id_e_ind_fvt]) !!}" class='btn {{ $entrevistaIndividual->diligenciada->situacion_boton }} btn-sm '><i class="glyphicon glyphicon-send"></i></a>
                        @endif
                        --}}
                    @endif
                    {{-- Ver fichas --}}

                    @if($entrevistaIndividual->id_subserie == config('expedientes.vi'))
                        @cannot('sistema-abierto')
                            <a data-toggle="tooltip" title="Fichas diligenciadas"  href="{!! action('entrevista_individualController@fichas_show', [$entrevistaIndividual->id_e_ind_fvt]) !!}" class='btn btn-default  btn-sm '><i class="fa fa-paper-plane-o"></i></a>
                        @endcannot

                        @if($entrevistaIndividual->clasifica_nivel == 3 && Gate::check('solo-lectura'))
                            {{--
                            <button class="btn btn-sm btn-default" disabled title="Restringida-3" data-toggle="tooltip"><i class="glyphicon glyphicon-send"></i></button>
                            --}}
                        @else
                            @if( $entrevistaIndividual->diligenciada->situacion==3)
                                <a data-toggle="tooltip" title="Fichas diligenciadas"  href="{!! action('entrevista_individualController@fichas_show', [$entrevistaIndividual->id_e_ind_fvt]) !!}" class='btn btn-default  btn-sm '><i class="fa fa-paper-plane-o"></i></a>
                            @else
                                {{--
                                <button class="btn btn-sm btn-default" disabled title="Sin fichas diligenciadas" data-toggle="tooltip"><i class="glyphicon glyphicon-send"></i></button>
                                --}}
                            @endif
                        @endif
                    @else
                        {!!  $entrevistaIndividual->diligenciada_pe->btn_show !!}
                    @endif
                    {{-- Otorgar acceso --}}
                    @if(\App\Models\entrevista_individual::revisar_conceder_acceso($entrevistaIndividual))
                        @can('sistema-abierto')
                            <a data-toggle="tooltip" title="Compartir para editar: Conceder acceso para modificar la entrevista"  href="{!! action('acceso_edicionController@create')."?id_subserie=".config('expedientes.vi')."&id_entrevista=$entrevistaIndividual->id_e_ind_fvt" !!}" class='btn btn-default btn-sm '><i class="fa fa-share-alt text-danger" aria-hidden="true"></i> </a>
                        @endcan
                        @if($entrevistaIndividual->clasifica_nivel <=3 )
                            <a data-toggle="tooltip" title="Desclasificar: facilitar el acceso a los adjuntos"  href="{!! action('entrevista_individualController@desclasificar',$entrevistaIndividual->id_e_ind_fvt) !!}" class='btn btn-default btn-sm '><i class="fa fa-eye-slash text-danger" aria-hidden="true"></i> </a>
                        @endif

                    @endif





                </div>


            </td>
            @can('sistema-abierto')
            @can('nivel-10')
                @can('escritura')
                    <td>
                        <div class='btn-group'>
                            @if($entrevistaIndividual->tiene_audio == 1)
                                @if($entrevistaIndividual->tiene_tf==0)
                                    <a data-toggle="tooltip" title="Asignar transcripcion. {{ $entrevistaIndividual->puede_transcribirse ? 'Cumple requisitos' :'Imcompleta' }}" href="{!! url('transcribirAsignacions/create')."?id=".$entrevistaIndividual->id_e_ind_fvt !!}" class='btn {{ $entrevistaIndividual->puede_transcribirse ? 'btn-primary' :'btn-default' }} btn-sm'><i class="fa fa-headphones" aria-hidden="true"></i> </a>
                                @else
                                    <a data-toggle="tooltip" title="Transcripción realizada" href="{!! url('transcribirAsignacions/create')."?id=".$entrevistaIndividual->id_e_ind_fvt !!}" class='btn btn-default btn-sm'><i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                                @endif
                            @else
                                <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Sin archivo de audio">
                                    <i class="fa fa-volume-up text-danger" data-toggle="tooltip" title="Sin archivo de audio"></i>
                                </button>
                            @endif

                            {{-- Asignar para etiquetar --}}

                            @if($entrevistaIndividual->tiene_etiquetado)
                                    <a data-toggle="tooltip" title="Etiquetado realizado" href="{!! url('etiquetarAsignacions/create')."?id=".$entrevistaIndividual->id_e_ind_fvt !!}" class='btn btn-default btn-sm'><i class="fa fa-check text-success" aria-hidden="true"></i> </a>
                            @else
                                @if($entrevistaIndividual->tiene_transcripcion)  {{-- Con transcripcion --}}
                                    @if( $entrevistaIndividual->asignado_etiquetado == 0) {{-- No asignada --}}
                                    <a data-toggle="tooltip" title="Asignar etiquetado. " href="{!! url('etiquetarAsignacions/create')."?id=".$entrevistaIndividual->id_e_ind_fvt !!}" class='btn btn-primary btn-sm'><i class="fa fa-tags" aria-hidden="true"></i> </a>
                                    @else
                                        <a data-toggle="tooltip" title="Asignada para etiquetar. " href="#" class='btn btn-default btn-sm'><i class="fa fa-tags text-warning" aria-hidden="true"></i> </a>
                                    @endif
                                @else
                                        <a data-toggle="tooltip" title="Sin transcripción. " href="#" class='btn btn-default btn-sm'><i class="fa fa-tags text-danger" aria-hidden="true"></i> </a>
                                @endif
                            @endif

                            {{-- Unificar entrevistas --}}
                            <span data-toggle="tooltip" title="Unificar con otra entrevista">
                                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_unifica_{{ $entrevistaIndividual->id_e_ind_fvt  }}">
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
                    <a class="btn btn-default btn-sm " data-toggle="tooltip" title="Reportar problemas que requieran seguimiento"  href="{{ action('seguimientoController@create') }}?id_subserie={{ config('expedientes.vi') }}&id_entrevista={{$entrevistaIndividual->id_e_ind_fvt}}&devolver={{ urlencode(Request::fullurl()) }}"><i class="fa fa-warning text-yellow " aria-hidden="true"></i></a>
                @endcan
                @can('nivel-10-al-11')
                    {{-- Enlazar entrevistas --}}
                    <span data-toggle="tooltip" title="Enlazar con otra entrevista">
                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_enlaza_{{ $entrevistaIndividual->id_e_ind_fvt  }}">
                            <i class="fa fa-magnet " aria-hidden="true"></i>
                        </button>
                    </span>

                        {{-- Trasladar a PR --}}
                        <span data-toggle="tooltip" title="Trasladar a entrevista a profundidad">
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_traslada_{{ $entrevistaIndividual->id_e_ind_fvt  }}">
                                <i class="fa fa-handshake-o text-danger " aria-hidden="true"></i>
                            </button>
                        </span>
                        {{-- Trasladar a HV --}}
                        <span data-toggle="tooltip" title="Trasladar a Historia de Vida">
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_traslada_hv_{{ $entrevistaIndividual->id_e_ind_fvt  }}">
                                <i class="fa fa-street-view text-danger " aria-hidden="true"></i>
                            </button>
                        </span>
                        {{-- Trasladar a CO --}}
                        <span data-toggle="tooltip" title="Trasladar a entrevista coleciva">
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_traslada_co_{{ $entrevistaIndividual->id_e_ind_fvt  }}">
                                <i class="fa fa-users text-danger " aria-hidden="true"></i>
                            </button>
                        </span>


                @endcan
                {{-- Aplicar marcas --}}
                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_marca_{{ $entrevistaIndividual->id_subserie }}_{{ $entrevistaIndividual->id_e_ind_fvt  }}">
                    <i class="fa fa-flag text-primary" aria-hidden="true"></i>
                </button>

                {!!   \App\Models\marca_entrevista::listado_marcas($filtros->id_subserie,$entrevistaIndividual->id_e_ind_fvt) !!}
            </td>
            @endcan
        </tr>
        @php($id_subserie = $filtros->id_subserie)
        @php($id_entrevista = $entrevistaIndividual->id_e_ind_fvt)
        @php($codigo_entrevista = $entrevistaIndividual->entrevista_codigo)
        @include('marca_entrevistas.create')
        @include('partials.frm_enlazar')
        @include('partials.frm_unificar')
        @include('partials.frm_trasladar_pr')
        @include('partials.frm_trasladar_hv')
        @include('partials.frm_trasladar_co')
    @endforeach
    </tbody>
</table>


{{-- Priorizacion del entrevistador --}}
@include("seguimiento.modal_priorizar")
