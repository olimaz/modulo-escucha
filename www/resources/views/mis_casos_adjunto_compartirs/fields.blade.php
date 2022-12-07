<!-- Id Mis Casos Adjunto Compartir Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_mis_casos_adjunto_compartir', 'Id Mis Casos Adjunto Compartir:') !!}
    {!! Form::number('id_mis_casos_adjunto_compartir', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Mis Casos Adjunto Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_mis_casos_adjunto', 'Id Mis Casos Adjunto:') !!}
    {!! Form::number('id_mis_casos_adjunto', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Autorizador Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_autorizador', 'Id Autorizador:') !!}
    {!! Form::number('id_autorizador', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Autorizado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_autorizado', 'Id Autorizado:') !!}
    {!! Form::number('id_autorizado', null, ['class' => 'form-control']) !!}
</div>

<!-- Anotaciones Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('anotaciones', 'Anotaciones:') !!}
    {!! Form::textarea('anotaciones', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Situacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_situacion', 'Id Situacion:') !!}
    {!! Form::number('id_situacion', null, ['class' => 'form-control']) !!}
</div>

<!-- Fh Autorizado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fh_autorizado', 'Fh Autorizado:') !!}
    {!! Form::date('fh_autorizado', null, ['class' => 'form-control','id'=>'fh_autorizado']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#fh_autorizado').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Fh Revocado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fh_revocado', 'Fh Revocado:') !!}
    {!! Form::date('fh_revocado', null, ['class' => 'form-control','id'=>'fh_revocado']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#fh_revocado').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('misCasosAdjuntoCompartirs.index') }}" class="btn btn-default">Cancel</a>
</div>
