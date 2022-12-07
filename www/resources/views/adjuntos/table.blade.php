<table class="table table-responsive" id="adjuntos-table">
    <thead>
        <tr>
            <th>Ubicacion</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($adjuntos as $adjunto)
        <tr>
            <td>{!! $adjunto->ubicacion !!}</td>
            <td>
                {!! Form::open(['route' => ['adjuntos.destroy', $adjunto->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('adjuntos.show', [$adjunto->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('adjuntos.edit', [$adjunto->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>