<div class="table-responsive">
    <table class="table table-condensed table-bordered" id="exilios-table">
        <thead>
            <tr>
                <th>Fecha salida</th>
                <th>Fecha llegada</th>
                <th>Lugar llegada</th>
                <th>Lugar asentamiento</th>
                <th title="Cantidad de reasentamientos registrados " data-toggle="tooltip">Reasentamientos</th>
                <th>Hubo Retorno</th>
                <th>Lugar retorno</th>
                <th>Avance</th>
                <th>Acciones</th>
                <th title="Quien diligencia" data-toggle="tooltip">Q.D.</th>
            </tr>
        </thead>
        <tbody>
        @foreach($exilios as $exilio)

            @php($movimiento = $exilio->primera_salida())
            @php($retorno = $exilio->retorno())

            @if($movimiento)
                <tr>
                    <td>{!! $movimiento->fmt_fecha_salida !!}</td>
                    <td>{!! $movimiento->fmt_fecha_llegada !!}</td>
                    <td>{!! $movimiento->fmt_id_lugar_llegada !!}</td>
                    <td>{!! $movimiento->fmt_id_lugar_asentamiento !!}</td>
                    <td class="text-center"> {{ $exilio->listar_reasentamientos()->count() }}</td>
                    <td class="text-center">{!! $exilio->fmt_id_ha_tenido_retorno !!}</td>
                    @if($exilio->id_ha_tenido_retorno==1)
                        <td>{!! $retorno->fmt_id_lugar_llegada !!}</td>
                    @else
                        <td> - </td>
                    @endif
                    <td>{!! $exilio->fmt_completo->fmt_completa !!}</td>

                    <td>

                        <div class='btn-group'>

                            @if(isset($no_editar))
                                <a href="{!! route('exilios.show_lectura', [$exilio->id_exilio]) !!}{{ isset($hecho) ? "?id_hecho=$hecho->id_hecho" : "" }}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                            @else
                                {!! Form::open(['route' => ['exilios.destroy', $exilio->id_exilio], 'method' => 'delete']) !!}
                                    <a href="{!! route('exilios.show', [$exilio->id_exilio]) !!}{{ isset($hecho) ? "?id_hecho=$hecho->id_hecho" : "?x" }}&edicion=1" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>

                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('¿Está segura?')"]) !!}
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </td>
                    <td>{{ \App\Models\entrevistador::cual_codigo($exilio->insert_ent) }}</td>
                </tr>
            @else
                <tr>
                    <td> Sin especificar</td>
                    <td> Sin especificar</td>
                    <td> Sin especificar</td>
                    <td> Sin especificar</td>
                    <td>

                        <div class='btn-group'>

                            @if(isset($no_editar))
                                <a href="{!! route('exilios.show_lectura', [$exilio->id_exilio]) !!}{{ isset($hecho) ? "?id_hecho=$hecho->id_hecho" : "" }}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                            @else
                                {!! Form::open(['route' => ['exilios.destroy', $exilio->id_exilio], 'method' => 'delete']) !!}
                                <a href="{!! route('exilios.show', [$exilio->id_exilio]) !!}{{ isset($hecho) ? "?id_hecho=$hecho->id_hecho" : "?x" }}&edicion=1" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>

                                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('¿Está segura?')"]) !!}
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>