<!-- Id Subserie Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_subserie', 'Id Subserie:') !!}
    {!! Form::number('id_subserie', null, ['class' => 'form-control']) !!}
</div>

<!-- Correlativo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('correlativo', 'Correlativo:') !!}
    {!! Form::number('correlativo', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('correlativos.index') !!}" class="btn btn-default">Cancel</a>
</div>
