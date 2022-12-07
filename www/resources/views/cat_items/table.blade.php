<table class="table table-responsive" id="catItems-table">
    <thead>
        <tr>
            <th>Id Cat</th>
        <th>Descripcion</th>
        <th>Abreviado</th>
        <th>Texto</th>
        <th>Orden</th>
        <th>Predeterminado</th>
        <th>Otro</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($catItems as $catItem)
        <tr>
            <td>{!! $catItem->id_cat !!}</td>
            <td>{!! $catItem->descripcion !!}</td>
            <td>{!! $catItem->abreviado !!}</td>
            <td>{!! $catItem->texto !!}</td>
            <td>{!! $catItem->orden !!}</td>
            <td>{!! $catItem->predeterminado !!}</td>
            <td>{!! $catItem->otro !!}</td>
            <td>
                {!! Form::open(['route' => ['catItems.destroy', $catItem->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('catItems.show', [$catItem->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('catItems.edit', [$catItem->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>