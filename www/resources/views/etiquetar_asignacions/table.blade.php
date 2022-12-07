<div class="table-responsive">
    <table class="table table-condensed table-bordered table-hover" id="transcribirAsignacions-table">
        <thead>
        <tr>

            <th>Código</th>
            <th>Etiquetador</th>
            <th>Autorizado por</th>
            <th>¿Urgente?</th>
            <th>Situación</th>
            <th>Fecha Situación</th>
            {{--
            <th>Duración del etiquetado</th>
            --}}
            <th>Causas no etiquetado</th>
            <th>Observaciones</th>
            <th width="100px">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($etiquetarAsignacions as $etiquetarAsignacion)
            <tr>
                {{--
                    <td class="text-center">{!! $transcribirAsignacion->rel_id_e_ind_fvt->entrevista_correlativo !!}</td>
                --}}
                <td>{!! $etiquetarAsignacion->codigo_entrevista !!}</td>
                <td>{!! $etiquetarAsignacion->fmt_id_transcriptor !!}</td>
                <td>{!! $etiquetarAsignacion->fmt_id_autoriza !!}</td>
                <td class="text-center">{!! $etiquetarAsignacion->fmt_urgente !!}</td>
                <td>{!! $etiquetarAsignacion->fmt_id_situacion !!}</td>
                <td>{!! $etiquetarAsignacion->fmt_fecha_situacion !!}</td>
                {{--
                <td class="text-center">{!! $etiquetarAsignacion->duracion_etiquetado_minutos !!}</td>
                --}}
                <td>@if($etiquetarAsignacion->id_situacion==4)
                        {!! $etiquetarAsignacion->fmt_id_causa !!}
                    @else
                        &nbsp;
                    @endif
                </td>
                <td>{!! $etiquetarAsignacion->observaciones !!}</td>
                <td>
                    {!! Form::open(['route' => ['etiquetarAsignacions.destroy', $etiquetarAsignacion->id_etiquetar_asignacion], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {{--
                        <a href="{!! route('transcribirAsignacions.show', [$transcribirAsignacion->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        --}}
                        @if($etiquetarAsignacion->id_situacion==1)
                            {{-- diligenciar fichas --}}
                            @if($etiquetarAsignacion->id_e_ind_fvt > 0)
                                @php($entrevistaIndividual = \App\Models\entrevista_individual::find($etiquetarAsignacion->id_e_ind_fvt))
                                @if($entrevistaIndividual->id_subserie == config('expedientes.vi'))
                                    <a data-toggle="tooltip" title="Diligenciar fichas: {{ $entrevistaIndividual->diligenciada->situacion_texto }} "  href="{!! action('entrevista_individualController@fichas', [$entrevistaIndividual->id_e_ind_fvt]) !!}" class='btn {{ $entrevistaIndividual->diligenciada->situacion_boton }}  '><i class="glyphicon glyphicon-send"></i></a>
                                @endif
                            @endif
                            <a data-toggle="tooltip" title="Finalizar etiquetado"  href="{!! route('etiquetarAsignacions.edit', [$etiquetarAsignacion->id_etiquetar_asignacion]) !!}" class='btn btn-primary'><i class="glyphicon glyphicon-tag"></i></a>
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger ', 'onclick' => "return confirm('¿Seguro que desea revocar la asignación?')",'data-toggle'=>'tooltip','title'=>'Revocar asignación']) !!}
                        @else
                            <a data-toggle="tooltip" title="Mostrar detalles del etiquetado"  href="{!! route('etiquetarAsignacions.show', [$etiquetarAsignacion->id_etiquetar_asignacion]) !!}" class='btn btn-default'><i class="glyphicon glyphicon-eye-open"></i></a>
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
                filename: "datos_etiquetado_" + new Date().toLocaleString("en-GB", {timeZone: "America/Bogota"}).replace(/[\-\:\.]/g, "").substring(0,10),
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        });

    </script>
@endpush


