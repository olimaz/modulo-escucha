<!-- Fecha Hora Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_hora', 'Fecha Hora:') !!}
    {!! Form::date('fecha_hora', null, ['class' => 'form-control','id'=>'fecha_hora']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#fecha_hora').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Id Usuario Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_usuario', 'Id Usuario:') !!}
    {!! Form::number('id_usuario', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Accion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_accion', 'Id Accion:') !!}
    {!! Form::number('id_accion', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Objeto Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_objeto', 'Id Objeto:') !!}
    {!! Form::number('id_objeto', null, ['class' => 'form-control']) !!}
</div>

<!-- Referencia Field -->
<div class="form-group col-sm-6">
    {!! Form::label('referencia', 'Referencia:') !!}
    {!! Form::text('referencia', null, ['class' => 'form-control']) !!}
</div>

<!-- Codigo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('codigo', 'Codigo:') !!}
    {!! Form::text('codigo', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('trazaActividads.index') !!}" class="btn btn-default">Cancel</a>
</div>
