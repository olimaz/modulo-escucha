<div class="table-responsive">
    <table class="table" id="exilios-table">
        <thead>
            <tr>
                <th>Fecha salida</th>
                <th>Lugar salida</th>
                <th>Fecha llegada</th>
                <th>Lugar llegada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($exilios as $exilio)
            @php($movimiento = $exilio->primera_salida())

            @if($movimiento)
                <tr>
                    <td>{!! $movimiento->fmt_fecha_salida !!}</td>
                    <td>{!! $movimiento->fmt_id_lugar_salida !!}</td>
                    <td>{!! $movimiento->fmt_fecha_llegada !!}</td>
                    <td>{!! $movimiento->fmt_lugar_llegada !!}</td>

                    <td>
                        {!! Form::open(['route' => ['exilios.destroy', $exilio->id_exilio], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{!! route('exilios.show', [$exilio->id_exilio]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a href="{!! route('exilios.edit', [$exilio->id_exilio]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Está segura?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>
