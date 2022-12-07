<div class="table-responsive">
    <table class="table table-condensed table-bordered table-hover" id="transcribirAsignacions-table">
        <thead>
            <tr>

                <th>Código</th>
                <th>Transcriptor</th>
                <th>Autorizado por</th>
                <th>¿Urgente?</th>
                <th>Situación</th>
                <th>Fecha Situación</th>
                <th>Minutos de la entrevista</th>
                <th>Causas no transcrito</th>
                <th>Observaciones</th>
                <th width="100px">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($transcribirAsignacions as $transcribirAsignacion)
            <tr>
                {{--
                    <td class="text-center">{!! $transcribirAsignacion->rel_id_e_ind_fvt->entrevista_correlativo !!}</td>
                --}}
                <td>{!! $transcribirAsignacion->codigo_entrevista !!}</td>
                <td>{!! $transcribirAsignacion->fmt_id_transcriptor !!}</td>
                <td>{!! $transcribirAsignacion->fmt_id_autoriza !!}</td>
                <td class="text-center">{!! $transcribirAsignacion->fmt_urgente !!}</td>
                <td>{!! $transcribirAsignacion->fmt_id_situacion !!}</td>
                <td>{!! $transcribirAsignacion->fmt_fecha_situacion !!}</td>
                <td class="text-center">{!! $transcribirAsignacion->duracion_entrevista_minutos !!}</td>
                <td>@if($transcribirAsignacion->id_situacion==4)
                        {!! $transcribirAsignacion->fmt_id_causa !!}
                    @else
                        &nbsp;
                    @endif
                </td>
                <td>{!! $transcribirAsignacion->observaciones !!}</td>
                <td>
                    {!! Form::open(['route' => ['transcribirAsignacions.destroy', $transcribirAsignacion->id_transcribir_asignacion], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                      {{--
                      <a href="{!! route('transcribirAsignacions.show', [$transcribirAsignacion->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                      --}}
                        @if($transcribirAsignacion->id_situacion==1)
                            {{-- diligenciar fichas --}}
                            @if($transcribirAsignacion->id_e_ind_fvt > 0)
                                @php($entrevistaIndividual = \App\Models\entrevista_individual::find($transcribirAsignacion->id_e_ind_fvt))
                                @if($entrevistaIndividual->id_subserie == config('expedientes.vi'))
                                    <a data-toggle="tooltip" title="Diligenciar fichas: {{ $entrevistaIndividual->diligenciada->situacion_texto }} "  href="{!! action('entrevista_individualController@fichas', [$entrevistaIndividual->id_e_ind_fvt]) !!}" class='btn {{ $entrevistaIndividual->diligenciada->situacion_boton }}  '><i class="glyphicon glyphicon-send"></i></a>
                                @endif
                            @endif
                            <a data-toggle="tooltip" title="Finalizar transcripción"  href="{!! route('transcribirAsignacions.edit', [$transcribirAsignacion->id_transcribir_asignacion]) !!}" class='btn btn-primary'><i class="glyphicon glyphicon-headphones"></i></a>
                            {{-- Enviar transcripcion a dataturk --}}
                            @if($transcribirAsignacion->tiene_transcripcion)
                                <a data-toggle="tooltip" title="Enviar texto a etiquetado "  href="{!! $transcribirAsignacion->link_enviar_dataturk."&id_transcriptor=$transcribirAsignacion->id_transcriptor" !!}" class='btn btn-default '><i class="glyphicon glyphicon-link"></i></a>
                            @endif
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger ', 'onclick' => "return confirm('¿Seguro que desea revocar la asignación?')",'data-toggle'=>'tooltip','title'=>'Revocar asignación']) !!}

                        @else
                            <a data-toggle="tooltip" title="Mostrar detalles de la  transcripción"  href="{!! route('transcribirAsignacions.show', [$transcribirAsignacion->id_transcribir_asignacion]) !!}" class='btn btn-default'><i class="glyphicon glyphicon-eye-open"></i></a>
                        @endif

                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>



@push('js')
    <script>
        // This must be a hyperlink
        $("#b_tabla_datos").on('click', function(event) {
            $("#transcribirAsignacions-table").table2excel({
                name: "transcripciones",
                //filename: "sat_problemas_" + new Date().toISOString().replace(/[\-\:\.]/g, "").substring(0,8),
                filename: "datos_transcripciones_" + new Date().toLocaleString("en-GB", {timeZone: "America/Bogota"}).replace(/[\-\:\.]/g, "").substring(0,10),
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        });

    </script>
@endpush