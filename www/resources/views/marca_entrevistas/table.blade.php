<div class="table-responsive">
    <table class="table" id="marcaEntrevistas-table">
        <thead>
            <tr>
                <th>Id Subserie</th>
        <th>Id Entrevista</th>
        <th>Id Entrevistador</th>
        <th>Id Marca</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($marcaEntrevistas as $marcaEntrevista)
            <tr>
                <td>{!! $marcaEntrevista->id_subserie !!}</td>
            <td>{!! $marcaEntrevista->id_entrevista !!}</td>
            <td>{!! $marcaEntrevista->id_entrevistador !!}</td>
            <td>{!! $marcaEntrevista->id_marca !!}</td>
                <td>
                    {!! Form::open(['route' => ['marcaEntrevistas.destroy', $marcaEntrevista->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('marcaEntrevistas.show', [$marcaEntrevista->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('marcaEntrevistas.edit', [$marcaEntrevista->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
