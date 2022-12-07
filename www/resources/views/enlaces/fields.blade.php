<!-- Id Subserie Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_subserie', 'Id Subserie:') !!}
    {!! Form::number('id_subserie', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Primaria Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_primaria', 'Id Primaria:') !!}
    {!! Form::number('id_primaria', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Subserie E Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_subserie_e', 'Id Subserie E:') !!}
    {!! Form::number('id_subserie_e', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Primaria E Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_primaria_e', 'Id Primaria E:') !!}
    {!! Form::number('id_primaria_e', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Tipo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_tipo', 'Id Tipo:') !!}
    {!! Form::number('id_tipo', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Entrevistador Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_entrevistador', 'Id Entrevistador:') !!}
    {!! Form::number('id_entrevistador', null, ['class' => 'form-control']) !!}
</div>

<!-- Anotaciones Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('anotaciones', 'Anotaciones:') !!}
    {!! Form::textarea('anotaciones', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Activo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_activo', 'Id Activo:') !!}
    {!! Form::number('id_activo', null, ['class' => 'form-control']) !!}
</div>

<!-- Fh Insert Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fh_insert', 'Fh Insert:') !!}
    {!! Form::date('fh_insert', null, ['class' => 'form-control','id'=>'fh_insert']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#fh_insert').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('enlaces.index') }}" class="btn btn-default">Cancel</a>
</div>
