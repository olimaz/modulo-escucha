<table class="table table-responsive" id="entrevistaIndividualFrs-table">
    <thead>
        <tr>
            <th>Id E Ind Fvt</th>
        <th>Id Fr</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($entrevistaIndividualFrs as $entrevistaIndividualFr)
        <tr>
            <td>{!! $entrevistaIndividualFr->id_e_ind_fvt !!}</td>
            <td>{!! $entrevistaIndividualFr->id_fr !!}</td>
            <td>
                {!! Form::open(['route' => ['entrevistaIndividualFrs.destroy', $entrevistaIndividualFr->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('entrevistaIndividualFrs.show', [$entrevistaIndividualFr->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('entrevistaIndividualFrs.edit', [$entrevistaIndividualFr->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>