<div class="table-responsive">
    <table class="table" id="directorioCatalogos-table">
        <thead>
            <tr>
                <th>Id Catalogo</th>
        <th>Tabla</th>
        <th>Campo</th>
        <th>Descripcion</th>
        <th>Created At</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($directorioCatalogos as $directorioCatalogo)
            <tr>
                <td>{!! $directorioCatalogo->id_catalogo !!}</td>
            <td>{!! $directorioCatalogo->tabla !!}</td>
            <td>{!! $directorioCatalogo->campo !!}</td>
            <td>{!! $directorioCatalogo->descripcion !!}</td>
            <td>{!! $directorioCatalogo->created_at !!}</td>
                <td>
                    {!! Form::open(['route' => ['directorioCatalogos.destroy', $directorioCatalogo->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('directorioCatalogos.show', [$directorioCatalogo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('directorioCatalogos.edit', [$directorioCatalogo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
