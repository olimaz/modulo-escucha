<!-- Id Tipo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_tipo', 'Id Tipo:') !!}
    {!! Form::number('id_tipo', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Adjunto Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_adjunto', 'Id Adjunto:') !!}
    {!! Form::number('id_adjunto', null, ['class' => 'form-control']) !!}
</div>

<!-- Id E Ind Fvt Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_e_ind_fvt', 'Id E Ind Fvt:') !!}
    {!! Form::number('id_e_ind_fvt', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('entrevistaIndividualAdjuntos.index') !!}" class="btn btn-default">Cancel</a>
</div>
