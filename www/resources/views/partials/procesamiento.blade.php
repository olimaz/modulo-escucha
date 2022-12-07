{{-- Muestra los avances --}}

<div class="box box-solid box-info ">
    <div class="box-header">
        <h3 class="box-title">
            Procesamiento de esta entrevista
        </h3>
    </div>
    <div class="box-body">

        @php($tiempo = $entrevista->tiempo_procesamiento)
        @if($tiempo)
            <div class="col-sm-6 col-sm-offset-6">
                <ul>
                    <li>Duración de la entrevista: {{ $tiempo[0] }} minutos</li>
                    <li>Tiempo usado para transcribir: {{ $tiempo[1] }} minutos</li>
                    <li>Tiempo usado para etiquetar: {{ $tiempo[2] }} minutos</li>
                    <li>Tiempo usado para diligenciar fichas: {{ $tiempo[3] }} minutos</li>
                </ul>
            </div>
        @endif

        @if(count($entrevista->rel_transcripcion) > 0 || count($entrevista->rel_etiquetado) > 0)

            <div class="clearfix"></div>
            <div class="box box-default box-solid">
                <div class="box-header">
                    <h3 class="box-title">Asignaciones</h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th>Asignación</th>
                            <th>Fecha</th>
                            <th>Responsable</th>
                            <th>Situación</th>
                            <th>Observaciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($entrevista->rel_transcripcion as $asigacion)
                            <tr>
                                <td>Transcripción</td>
                                <td>{!! $asigacion->fmt_fecha_situacion !!}</td>
                                <td>{!! $asigacion->fmt_id_transcriptor !!}</td>
                                <td>{!! $asigacion->fmt_id_situacion !!}</td>
                                <td>{!! nl2br($asigacion->observaciones) !!}</td>
                            </tr>
                        @endforeach
                        @foreach($entrevista->rel_etiquetado as $asigacion)
                            <tr>
                                <td>Etiquetado</td>
                                <td>{!! $asigacion->fmt_fecha_situacion !!}</td>
                                <td>{!! $asigacion->fmt_id_transcriptor !!}</td>
                                <td>{!! $asigacion->fmt_id_situacion !!}</td>
                                <td>{!! nl2br($asigacion->observaciones) !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif


        @if(count($entrevista->listado_prioridad)>0)
            <div class="clearfix"></div>
            <div class="box box-default box-solid">
                <div class="box-header">
                    <h3 class="box-title">Prioridad </h3>
                </div>

                <table class="table table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th>Definida por</th>
                        <th>Entrevista fluida</th>
                        <th>Descripción de los hechos</th>
                        <th>Descripción del contexto</th>
                        <th>Descripción de los impactos</th>
                        <th>Descripción del accso a la justicia e iniciativas de no repetición</th>
                        <th>Ponderación</th>
                        <th>Ahora entiendo</th>
                        <th>Cambio de perspectiva</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($entrevista->listado_prioridad as $pr)
                            <tr>
                                <td > {{ $pr->fmt_id_tipo }}</td>
                                <td> {{ $pr->fmt_fluidez }}</td>
                                <td> {{ $pr->fmt_d_hecho }}</td>
                                <td> {{ $pr->fmt_d_contexto }}</td>
                                <td> {{ $pr->fmt_d_impacto }}</td>
                                <td> {{ $pr->fmt_d_justicia }}</td>
                                <td> {{ $pr->ponderacion }}</td>
                                <td> {{ $pr->ahora_entiendo }}</td>
                                <td> {{ $pr->cambio_perspectiva }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if(count($entrevista->seguimiento) > 0)
            <div class="clearfix"></div>
            <div class="box box-default box-solid">
                <div class="box-header">
                    <h3 class="box-title">Seguimiento </h3>
                </div>
                <table class="table table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Responsable</th>
                        <th>Expediente cerrado</th>
                        <th>Anotaciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($entrevista->seguimiento as $fila)
                        <tr>
                            <td>{{ $fila->fmt_fecha_hora }}</td>
                            <td>{{ $fila->fmt_id_entrevistador }}</td>
                            <td>{{ $fila->fmt_id_cerrado }}</td>
                            <td>{{ nl2br($fila->anotaciones) }}</td>
                        </tr>
                        @foreach($fila->rel_seguimiento_problema as $problema)
                            <tr>
                                <td></td>
                                <th class="text-right text-danger">{{ $problema->fmt_id_tipo_problema }}:</th>
                                <td colspan="2">{{ $problema->descripcion }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>