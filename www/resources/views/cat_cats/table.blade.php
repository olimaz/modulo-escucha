<table class="table table-responsive" id="catCats-table">
    <thead>
        <tr>
            <th>Nombre</th>
        <th>Descripcion</th>
        <th>Editable</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($catCats as $catCat)
        <tr>
            <td>{!! $catCat->nombre !!}</td>
            <td>{!! $catCat->descripcion !!}</td>
            <td>{!! $catCat->editable !!}</td>
            <td>
                {!! Form::open(['route' => ['catCats.destroy', $catCat->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('catCats.show', [$catCat->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('catCats.edit', [$catCat->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>