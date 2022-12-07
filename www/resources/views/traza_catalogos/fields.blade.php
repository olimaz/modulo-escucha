<!-- Id Directorio Catalogo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_directorio_catalogo', 'Id Directorio Catalogo:') !!}
    {!! Form::number('id_directorio_catalogo', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Entrevistador Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_entrevistador', 'Id Entrevistador:') !!}
    {!! Form::number('id_entrevistador', null, ['class' => 'form-control']) !!}
</div>

<!-- Valor Anterior Field -->
<div class="form-group col-sm-6">
    {!! Form::label('valor_anterior', 'Valor Anterior:') !!}
    {!! Form::number('valor_anterior', null, ['class' => 'form-control']) !!}
</div>

<!-- Valor Nuevo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('valor_nuevo', 'Valor Nuevo:') !!}
    {!! Form::number('valor_nuevo', null, ['class' => 'form-control']) !!}
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_at', 'Created At:') !!}
    {!! Form::date('created_at', null, ['class' => 'form-control','id'=>'created_at']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#created_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('trazaCatalogos.index') !!}" class="btn btn-default">Cancel</a>
</div>
