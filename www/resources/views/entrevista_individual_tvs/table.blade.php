<table class="table table-responsive" id="entrevistaIndividualTvs-table">
    <thead>
        <tr>
            <th>Id E Ind Fvt</th>
        <th>Id Tv</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($entrevistaIndividualTvs as $entrevistaIndividualTv)
        <tr>
            <td>{!! $entrevistaIndividualTv->id_e_ind_fvt !!}</td>
            <td>{!! $entrevistaIndividualTv->id_tv !!}</td>
            <td>
                {!! Form::open(['route' => ['entrevistaIndividualTvs.destroy', $entrevistaIndividualTv->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('entrevistaIndividualTvs.show', [$entrevistaIndividualTv->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('entrevistaIndividualTvs.edit', [$entrevistaIndividualTv->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>