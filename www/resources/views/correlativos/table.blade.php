<table class="table table-responsive" id="correlativos-table">
    <thead>
        <tr>
            <th>Id Subserie</th>
        <th>Correlativo</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($correlativos as $correlativo)
        <tr>
            <td>{!! $correlativo->id_subserie !!}</td>
            <td>{!! $correlativo->correlativo !!}</td>
            <td>
                {!! Form::open(['route' => ['correlativos.destroy', $correlativo->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('correlativos.show', [$correlativo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('correlativos.edit', [$correlativo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>