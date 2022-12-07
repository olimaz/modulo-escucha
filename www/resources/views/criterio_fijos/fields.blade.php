<!-- Id Grupo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_grupo', 'Id Grupo:') !!}
    {!! Form::number('id_grupo', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Opcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_opcion', 'Id Opcion:') !!}
    {!! Form::number('id_opcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::textarea('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Orden Field -->
<div class="form-group col-sm-6">
    {!! Form::label('orden', 'Orden:') !!}
    {!! Form::number('orden', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('criterioFijos.index') !!}" class="btn btn-default">Cancel</a>
</div>
