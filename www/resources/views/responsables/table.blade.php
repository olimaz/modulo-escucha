<div class="table-responsive">
    <table class="table table-hover table-striped" id="responsables-table">
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Otros Nombres</th>
        </thead>
        <tbody>
        @foreach($responsables as $responsable)
            <tr>
                <td>{!! $responsable->nombres !!}</td>
                <td>{!! $responsable->apellidos !!}</td>
                <td>{!! $responsable->otros_nombres !!}</td>
                {{--
                <td>
                    {!! Form::open(['route' => ['responsables.destroy', $responsable->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('responsables.show', [$responsable->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('responsables.edit', [$responsable->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
                --}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
