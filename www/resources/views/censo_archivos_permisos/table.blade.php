<div class="table-responsive">
    <table class="table" id="censoArchivosPermisos-table">
        <thead>
            <tr>
                <th>Id Censo Archivos</th>
        <th>Id Entrevistador</th>
        <th>Id Perfil</th>
        <th>Fh Insert</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($censoArchivosPermisos as $censoArchivosPermisos)
            <tr>
                <td>{{ $censoArchivosPermisos->id_censo_archivos }}</td>
            <td>{{ $censoArchivosPermisos->id_entrevistador }}</td>
            <td>{{ $censoArchivosPermisos->id_perfil }}</td>
            <td>{{ $censoArchivosPermisos->fh_insert }}</td>
                <td>
                    {!! Form::open(['route' => ['censoArchivosPermisos.destroy', $censoArchivosPermisos->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('censoArchivosPermisos.show', [$censoArchivosPermisos->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('censoArchivosPermisos.edit', [$censoArchivosPermisos->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
