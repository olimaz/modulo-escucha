<!-- Id Catalogo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_catalogo', 'Id Catalogo:') !!}
    {!! Form::number('id_catalogo', null, ['class' => 'form-control']) !!}
</div>

<!-- Tabla Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tabla', 'Tabla:') !!}
    {!! Form::text('tabla', null, ['class' => 'form-control']) !!}
</div>

<!-- Campo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('campo', 'Campo:') !!}
    {!! Form::text('campo', null, ['class' => 'form-control']) !!}
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
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
    <a href="{!! route('directorioCatalogos.index') !!}" class="btn btn-default">Cancel</a>
</div>
