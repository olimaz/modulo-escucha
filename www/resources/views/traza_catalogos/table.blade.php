<div class="table-responsive">
    <table class="table" id="trazaCatalogos-table">
        <thead>
            <tr>
                <th>Id Directorio Catalogo</th>
        <th>Id Entrevistador</th>
        <th>Valor Anterior</th>
        <th>Valor Nuevo</th>
        <th>Created At</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($trazaCatalogos as $trazaCatalogo)
            <tr>
                <td>{!! $trazaCatalogo->id_directorio_catalogo !!}</td>
            <td>{!! $trazaCatalogo->id_entrevistador !!}</td>
            <td>{!! $trazaCatalogo->valor_anterior !!}</td>
            <td>{!! $trazaCatalogo->valor_nuevo !!}</td>
            <td>{!! $trazaCatalogo->created_at !!}</td>
                <td>
                    {!! Form::open(['route' => ['trazaCatalogos.destroy', $trazaCatalogo->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('trazaCatalogos.show', [$trazaCatalogo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('trazaCatalogos.edit', [$trazaCatalogo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
