<!-- Id E Ind Fvt Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_e_ind_fvt', 'Id E Ind Fvt:') !!}
    {!! Form::number('id_e_ind_fvt', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Fr Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_fr', 'Id Fr:') !!}
    {!! Form::number('id_fr', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('entrevistaIndividualFrs.index') !!}" class="btn btn-default">Cancel</a>
</div>
