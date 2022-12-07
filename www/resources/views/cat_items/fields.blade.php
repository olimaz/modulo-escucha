<!-- Id Cat Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_cat', 'Id Cat:') !!}
    {!! Form::number('id_cat', null, ['class' => 'form-control']) !!}
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Abreviado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('abreviado', 'Abreviado:') !!}
    {!! Form::text('abreviado', null, ['class' => 'form-control']) !!}
</div>

<!-- Texto Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('texto', 'Texto:') !!}
    {!! Form::textarea('texto', null, ['class' => 'form-control']) !!}
</div>

<!-- Orden Field -->
<div class="form-group col-sm-6">
    {!! Form::label('orden', 'Orden:') !!}
    {!! Form::number('orden', null, ['class' => 'form-control']) !!}
</div>

<!-- Predeterminado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('predeterminado', 'Predeterminado:') !!}
    {!! Form::number('predeterminado', null, ['class' => 'form-control']) !!}
</div>

<!-- Otro Field -->
<div class="form-group col-sm-6">
    {!! Form::label('otro', 'Otro:') !!}
    {!! Form::text('otro', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('catItems.index') !!}" class="btn btn-default">Cancel</a>
</div>
