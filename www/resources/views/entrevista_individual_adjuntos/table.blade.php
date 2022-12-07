<table class="table table-responsive" id="entrevistaIndividualAdjuntos-table">
    <thead>
        <tr>
            <th>Id Tipo</th>
        <th>Id Adjunto</th>
        <th>Id E Ind Fvt</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($entrevistaIndividualAdjuntos as $entrevistaIndividualAdjunto)
        <tr>
            <td>{!! $entrevistaIndividualAdjunto->id_tipo !!}</td>
            <td>{!! $entrevistaIndividualAdjunto->id_adjunto !!}</td>
            <td>{!! $entrevistaIndividualAdjunto->id_e_ind_fvt !!}</td>
            <td>
                {!! Form::open(['route' => ['entrevistaIndividualAdjuntos.destroy', $entrevistaIndividualAdjunto->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('entrevistaIndividualAdjuntos.show', [$entrevistaIndividualAdjunto->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('entrevistaIndividualAdjuntos.edit', [$entrevistaIndividualAdjunto->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>