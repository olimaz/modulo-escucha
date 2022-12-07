<table class="table table-responsive table-striped table-hover" id="documentos-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Objetivo</th>
            <th>Instrumento</th>
            <th>Referencia</th>
            @can('sistema-abierto')
                @can('nivel-1-2')
                    <th>Acción</th>
                @endcan
            @endcan
        </tr>
    </thead>
    <tbody>
    @foreach($documentos as $i=>$documento)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{!! $documento->fmt_id_objetivo !!}</td>
            <td>{!! $documento->fmt_id_instrumento !!}</td>


            <td>{!! $documento->fmt_url !!}</td>
            @can('sistema-abierto')
                @can('nivel-1-2')
                <td>

                        {!! Form::open(['route' => ['documentos.destroy', $documento->id_documento], 'method' => 'delete']) !!}
                        <div class='btn-group'>

                            <a href="{!! route('documentos.edit', [$documento->id_documento]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Seguro/a?')"]) !!}
                        </div>
                        {!! Form::close() !!}

                </td>
                @endcan
            @endcan
        </tr>
    @endforeach
    </tbody>
</table>

@push("js")
    <script>
        $(function () {
            $("#documentos-table").DataTable({
                "language": {
                    "url": "{{ url('js/dataTables.spanish.lang') }}"
                },
                "paging":   false,
                "ordering": false,
                "info":     false
            });
        });
    </script>
@endpush