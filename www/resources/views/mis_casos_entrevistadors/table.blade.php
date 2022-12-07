<div class="table-responsive">
    <table class="table" id="misCasosEntrevistadors-table">
        <thead>
            <tr>
                <th>Id Mis Casos</th>
        <th>Id Entrevistador</th>
        <th>Id Perfil</th>
        <th>Fh Insert</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($misCasosEntrevistadors as $misCasosEntrevistador)
            <tr>
                <td>{{ $misCasosEntrevistador->id_mis_casos }}</td>
            <td>{{ $misCasosEntrevistador->id_entrevistador }}</td>
            <td>{{ $misCasosEntrevistador->id_perfil }}</td>
            <td>{{ $misCasosEntrevistador->fh_insert }}</td>
                <td>
                    {!! Form::open(['route' => ['misCasosEntrevistadors.destroy', $misCasosEntrevistador->id_mis_casos_entreivstador], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('misCasosEntrevistadors.show', [$misCasosEntrevistador->id_mis_casos_entreivstador]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('misCasosEntrevistadors.edit', [$misCasosEntrevistador->id_mis_casos_entreivstador]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
