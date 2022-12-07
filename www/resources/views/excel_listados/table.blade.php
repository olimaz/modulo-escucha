<div class="table-responsive">
    <table class="table" id="excelListados-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Descripción</th>
                <th>Entrevistador</th>
                <th>Disponible para</th>
                <th>Códigos válidos</th>
                <th>Códigos no válidos</th>
                <th>Fecha de carga</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @php($i=1)
        @foreach($excelListados as $excelListados)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $excelListados->descripcion }}</td>
                <td class="text-center">{{ $excelListados->fmt_id_entrevistador }}</td>
                <td>{{ $excelListados->fmt_id_acceso_publico }}</td>
                <td class="text-center">{{ $excelListados->cantidad_codigos_si }}</td>
                <td class="text-center">{{ $excelListados->cantidad_codigos_no }}</td>
                <td>{{ $excelListados->fmt_created_at }}</td>
                <td>
                    {!! Form::open(['route' => ['excelListados.destroy', $excelListados->id_excel_listados], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('excelListados.show', [$excelListados->id_excel_listados]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('excelListados.edit', [$excelListados->id_excel_listados]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {{--
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
