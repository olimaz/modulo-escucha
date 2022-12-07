<table class="table table-responsive" id="entrevistaIndividualStcs-table">
    <thead>
        <tr>
            <th>Id E Ind Fvt</th>
        <th>Id Stc</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($entrevistaIndividualStcs as $entrevistaIndividualStc)
        <tr>
            <td>{!! $entrevistaIndividualStc->id_e_ind_fvt !!}</td>
            <td>{!! $entrevistaIndividualStc->id_stc !!}</td>
            <td>
                {!! Form::open(['route' => ['entrevistaIndividualStcs.destroy', $entrevistaIndividualStc->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('entrevistaIndividualStcs.show', [$entrevistaIndividualStc->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('entrevistaIndividualStcs.edit', [$entrevistaIndividualStc->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>