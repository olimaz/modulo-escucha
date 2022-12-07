<table class="table table-responsive" id="entrevistaIndividualAas-table">
    <thead>
        <tr>
            <th>Id E Ind Fvt</th>
        <th>Id Aa</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($entrevistaIndividualAas as $entrevistaIndividualAa)
        <tr>
            <td>{!! $entrevistaIndividualAa->id_e_ind_fvt !!}</td>
            <td>{!! $entrevistaIndividualAa->id_aa !!}</td>
            <td>
                {!! Form::open(['route' => ['entrevistaIndividualAas.destroy', $entrevistaIndividualAa->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('entrevistaIndividualAas.show', [$entrevistaIndividualAa->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('entrevistaIndividualAas.edit', [$entrevistaIndividualAa->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    <button class="btn btn-sm btn-default" disabled title="Sin fichas diligenciadas" data-toggle="tooltip"><i class="glyphicon glyphicon-send"></i></button>

                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
