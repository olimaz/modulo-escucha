<div class="table-responsive">
    <table class="table" id="entrevistados-table">
        <thead>
            <tr>
                <th>Id E Ind Fvt</th>
        <th>Id Entrevista</th>
        <th>Es Victima</th>
        <th>Es Testigo</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Otros Nombres</th>
        <th>Nacimiento Fecha</th>
        <th>Nacimiento Lugar</th>
        <th>Sexo</th>
        <th>Orientacion Sexual</th>
        <th>Identidad Genero</th>
        <th>Pertenencia Etnico Racial</th>
        <th>Id Usuario</th>
        <th>Created At</th>
        <th>Updated At</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($entrevistados as $entrevistado)
            <tr>
                <td>{!! $entrevistado->id_e_ind_fvt !!}</td>
            <td>{!! $entrevistado->id_entrevista !!}</td>
            <td>{!! $entrevistado->es_victima !!}</td>
            <td>{!! $entrevistado->es_testigo !!}</td>
            <td>{!! $entrevistado->nombres !!}</td>
            <td>{!! $entrevistado->apellidos !!}</td>
            <td>{!! $entrevistado->otros_nombres !!}</td>
            <td>{!! $entrevistado->nacimiento_fecha !!}</td>
            <td>{!! $entrevistado->nacimiento_lugar !!}</td>
            <td>{!! $entrevistado->sexo !!}</td>
            <td>{!! $entrevistado->orientacion_sexual !!}</td>
            <td>{!! $entrevistado->identidad_genero !!}</td>
            <td>{!! $entrevistado->pertenencia_etnico_racial !!}</td>
            <td>{!! $entrevistado->id_usuario !!}</td>
            <td>{!! $entrevistado->created_at !!}</td>
            <td>{!! $entrevistado->updated_at !!}</td>
                <td>
                    {!! Form::open(['route' => ['entrevistados.destroy', $entrevistado->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('entrevistados.show', [$entrevistado->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('entrevistados.edit', [$entrevistado->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
