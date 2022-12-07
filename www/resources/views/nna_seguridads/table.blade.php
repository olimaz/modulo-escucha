<div class="table-responsive">
    <table class="table" id="nnaSeguridads-table">
        <thead>
            <tr>
                <th>Correlativo</th>
                <th>Codigo</th>
                <th># NNA</th>
                <th>Fecha Evaluacion</th>
                <th>Dictamen</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
        @foreach($nnaSeguridads as $nnaSeguridad)
            <tr>

            <td>{!! $nnaSeguridad->correlativo !!}</td>
            <td>{!! $nnaSeguridad->codigo !!}</td>
            <td>{!! $nnaSeguridad->fmt_codigo_vulnerabilidad !!}</td>
                <td>{!! $nnaSeguridad->fmt_fecha_evaluacion !!}</td>
            <td>{!! $nnaSeguridad->fmt_dictamen_corto !!}</td>

                <td>
                    {!! Form::open(['route' => ['nnaSeguridads.destroy', $nnaSeguridad->id_nna_seguridad], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('nnaSeguridads.show', [$nnaSeguridad->id_nna_seguridad]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        {{--
                        <a href="{!! route('nnaSeguridads.edit', [$nnaSeguridad->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        --}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
