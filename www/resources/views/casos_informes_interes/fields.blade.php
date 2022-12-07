<!-- Id Casos Informes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_casos_informes', 'Id Casos Informes:') !!}
    {!! Form::number('id_casos_informes', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Interes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_interes', 'Id Interes:') !!}
    {!! Form::number('id_interes', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('casosInformesInteres.index') !!}" class="btn btn-default">Cancel</a>
</div>
