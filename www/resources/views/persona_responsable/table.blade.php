<div class="table-responsive">
    <table class="table" id="personas-table">
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Otros nombres</th>
                <th colspan="3"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($personas as $persona)
            <tr>
            <td>{!! $persona->nombre !!}</td>
            <td>{!! $persona->apellido !!}</td>
            <td>{!! $persona->alias !!}</td>
                <td>
                    {!! Form::open(['route' => ['persona_responsable.destroy', $persona->id_persona], 'method' => 'delete']) !!}
                    {!! Form::hidden('id_e_ind_fvt', $persona->id_e_ind_fvt) !!}

                    <div class='btn-group'>
                        <a href="{!! route('persona_responsable.show', [$persona->id_persona, $persona->id_e_ind_fvt]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('persona_responsable.edit', [$persona->id_persona, $persona->id_e_ind_fvt]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                      {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Desea borrar el responsable?')"]) !!}

                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
