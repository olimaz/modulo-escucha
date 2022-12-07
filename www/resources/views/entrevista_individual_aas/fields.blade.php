<!-- Id E Ind Fvt Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_e_ind_fvt', 'Id E Ind Fvt:') !!}
    {!! Form::number('id_e_ind_fvt', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Aa Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_aa', 'Id Aa:') !!}
    {!! Form::number('id_aa', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('entrevistaIndividualAas.index') !!}" class="btn btn-default">Cancel</a>
</div>
