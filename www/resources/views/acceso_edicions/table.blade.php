<div class="table-responsive">
    <table class="table  table-condensed table-striped table-hover" id="accesoEdicions-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Código de entrevista</th>
                <th>Quién autoriza</th>
                <th>Autorizado</th>
                <th>Observaciones</th>
                <th>Estado actual</th>
                <th>Fecha autorizado</th>
                <th>Quién revoca</th>
                <th>Fecha revocado</th>
                <th>Revocar</th>
            </tr>
        </thead>
        <tbody>
        @php($i = $accesoEdicions->firstItem())
        @foreach($accesoEdicions as $accesoEdicion)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $accesoEdicion->codigo_entrevista }}</td>
                <td>{{ $accesoEdicion->fmt_id_autoriza }}</td>
                <td>{{ $accesoEdicion->fmt_id_autorizado }}</td>
                <td>{{ $accesoEdicion->observaciones }}</td>
                <td>{{ $accesoEdicion->fmt_id_situacion }}</td>
                <td>{{ $accesoEdicion->fh_autorizado }}</td>
                <td>{{ $accesoEdicion->fmt_id_revocado }}</td>
                <td>{{ $accesoEdicion->fh_revocado }}</td>
                <td class="text-center">
                    {!! Form::open(['action' => ['acceso_edicionController@destroy', $accesoEdicion->id_acceso_edicion], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {{-- <a href="{{ route('accesoEdicions.show', [$accesoEdicion->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>--}}
                        {{-- <a href="{{ route('accesoEdicions.edit', [$accesoEdicion->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a> --}}
                        @if($accesoEdicion->puede_conceder_acceso)
                            @if(empty($accesoEdicion->id_revocado))
                                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit','data-toggle'=>'tooltip','title'=>'Anular el acceso concedido', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Desea revocar el acceso?')"]) !!}
                            @endif
                        @endif
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
