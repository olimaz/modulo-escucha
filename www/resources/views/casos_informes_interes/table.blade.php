<table class="table table-responsive" id="casosInformesInteres-table">
    <thead>
        <tr>
            <th>Id Casos Informes</th>
        <th>Id Interes</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($casosInformesInteres as $casosInformesInteres)
        <tr>
            <td>{!! $casosInformesInteres->id_casos_informes !!}</td>
            <td>{!! $casosInformesInteres->id_interes !!}</td>
            <td>
                {!! Form::open(['route' => ['casosInformesInteres.destroy', $casosInformesInteres->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('casosInformesInteres.show', [$casosInformesInteres->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('casosInformesInteres.edit', [$casosInformesInteres->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>