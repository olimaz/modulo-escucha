<!-- Id E Ind Fvt Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_e_ind_fvt', 'Id E Ind Fvt:') !!}
    {!! Form::number('id_e_ind_fvt', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Stc Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_stc', 'Id Stc:') !!}
    {!! Form::number('id_stc', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('entrevistaIndividualStcs.index') !!}" class="btn btn-default">Cancel</a>
</div>
