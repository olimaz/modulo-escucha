<div class="table-responsive">
    <table class="table" id="trazaActividads-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha y hora</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Destino</th>
                <th>Codigo</th>

            </tr>
        </thead>
        <tbody>
        @php($i = $trazaActividads->firstItem())
        @foreach($trazaActividads as $trazaActividad)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{!! $trazaActividad->fmt_fecha_hora !!}</td>
                <td>
                    @if($trazaActividad->id_personificador)
                        <span title="Usuario real: {{ $trazaActividad->fmt_id_personificador }}" data-toggle="tooltip"><i class="fa fa-user-secret text-danger"></i></span>
                    @endif
                    {!! $trazaActividad->fmt_id_usuario !!}

                </td>
                <td>{!! $trazaActividad->fmt_id_accion !!}</td>
                <td>{!! $trazaActividad->fmt_id_objeto !!}</td>
                <td>
                    <span title="{{ $trazaActividad->referencia }}" data-toggle="tooltip">
                        {!! $trazaActividad->codigo !!}
                    </span>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>
