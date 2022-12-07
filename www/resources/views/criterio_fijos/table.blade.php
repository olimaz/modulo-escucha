<table class="table table-responsive" id="criterioFijos-table">
    <thead>
        <tr>
            <th>Id Grupo</th>
        <th>Id Opcion</th>
        <th>Descripcion</th>
        <th>Orden</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($criterioFijos as $criterioFijo)
        <tr>
            <td>{!! $criterioFijo->id_grupo !!}</td>
            <td>{!! $criterioFijo->id_opcion !!}</td>
            <td>{!! $criterioFijo->descripcion !!}</td>
            <td>{!! $criterioFijo->orden !!}</td>
            <td>
                {!! Form::open(['route' => ['criterioFijos.destroy', $criterioFijo->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('criterioFijos.show', [$criterioFijo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('criterioFijos.edit', [$criterioFijo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>