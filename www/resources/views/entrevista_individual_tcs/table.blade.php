<table class="table table-responsive" id="entrevistaIndividualTcs-table">
    <thead>
        <tr>
            <th>Id E Ind Fvt</th>
        <th>Id Tc</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($entrevistaIndividualTcs as $entrevistaIndividualTc)
        <tr>
            <td>{!! $entrevistaIndividualTc->id_e_ind_fvt !!}</td>
            <td>{!! $entrevistaIndividualTc->id_tc !!}</td>
            <td>
                {!! Form::open(['route' => ['entrevistaIndividualTcs.destroy', $entrevistaIndividualTc->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('entrevistaIndividualTcs.show', [$entrevistaIndividualTc->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('entrevistaIndividualTcs.edit', [$entrevistaIndividualTc->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>