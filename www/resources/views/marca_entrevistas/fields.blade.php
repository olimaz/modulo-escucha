<!-- Id Subserie Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_subserie', 'Id Subserie:') !!}
    {!! Form::number('id_subserie', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Entrevista Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_entrevista', 'Id Entrevista:') !!}
    {!! Form::number('id_entrevista', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Entrevistador Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_entrevistador', 'Id Entrevistador:') !!}
    {!! Form::number('id_entrevistador', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Marca Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_marca', 'Id Marca:') !!}
    {!! Form::number('id_marca', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('marcaEntrevistas.index') !!}" class="btn btn-default">Cancel</a>
</div>
