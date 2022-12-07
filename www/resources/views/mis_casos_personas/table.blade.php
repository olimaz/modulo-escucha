<div class="table-responsive">
    <table class="table" id="misCasosPersonas-table">
        <thead>
            <tr>
                <th>Id Mis Casos</th>
        <th>Nombre</th>
        <th>Id Sexo</th>
        <th>Contacto</th>
        <th>Id Contactado</th>
        <th>Id Entrevistado</th>
        <th>Id Subserie</th>
        <th>Id Entrevista</th>
        <th>Anotaciones</th>
        <th>Fh Insert</th>
        <th>Fh Update</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($misCasosPersonas as $misCasosPersona)
            <tr>
                <td>{{ $misCasosPersona->id_mis_casos }}</td>
            <td>{{ $misCasosPersona->nombre }}</td>
            <td>{{ $misCasosPersona->id_sexo }}</td>
            <td>{{ $misCasosPersona->contacto }}</td>
            <td>{{ $misCasosPersona->id_contactado }}</td>
            <td>{{ $misCasosPersona->id_entrevistado }}</td>
            <td>{{ $misCasosPersona->id_subserie }}</td>
            <td>{{ $misCasosPersona->id_entrevista }}</td>
            <td>{{ $misCasosPersona->anotaciones }}</td>
            <td>{{ $misCasosPersona->fh_insert }}</td>
            <td>{{ $misCasosPersona->fh_update }}</td>
                <td>
                    {!! Form::open(['route' => ['misCasosPersonas.destroy', $misCasosPersona->id_mis_casos_persona], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('misCasosPersonas.show', [$misCasosPersona->id_mis_casos_persona]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('misCasosPersonas.edit', [$misCasosPersona->id_mis_casos_persona]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
