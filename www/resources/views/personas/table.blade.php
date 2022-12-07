<div class="table-responsive">
    <table class="table" id="personas-table">
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Documento identidad</th>                  
                <th>Otros nombres</th>
                <th>Lugar de nacimiento</th>
                <th>Fecha de nacimiento</th>                                 
                <th colspan="3"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($personas as $persona)
            <tr>
            <td>{!! $persona->nombre !!}</td>
            <td>{!! $persona->apellido !!}</td>
            <td>{!! $persona->DocumentoIdentidad !!}</td>
            <td>{!! $persona->alias !!}</td>
            <td>{!! $persona->fmt_id_lugar_nacimiento !!}</td>
            <td>{!! $persona->fechaNacimiento !!}</td>            
                <td>
                    {!! Form::open(['route' => ['personas.destroy', $persona->id_persona], 'method' => 'delete']) !!} 
                    {!! Form::hidden('id_e_ind_fvt', $persona->id_e_ind_fvt) !!}
                    <div class='btn-group'>
                        <a href="{!! route('personas.show', [$persona->id_persona, $persona->id_e_ind_fvt]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('personas.edit', [$persona->id_persona, $persona->id_e_ind_fvt]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>                        
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Desea borrar la persona entrevistada?')"]) !!}                        
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
