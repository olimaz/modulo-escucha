<!-- Id E Ind Fvt Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_e_ind_fvt', 'Id E Ind Fvt:') !!}
    {!! Form::number('id_e_ind_fvt', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha', 'Fecha:') !!}
    {!! Form::date('fecha', null, ['class' => 'form-control','id'=>'fecha']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#fecha').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Identificacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('identificacion', 'Identificacion:') !!}
    {!! Form::text('identificacion', null, ['class' => 'form-control']) !!}
</div>

<!-- Acuerdo Entrevista Field -->
<div class="form-group col-sm-6">
    {!! Form::label('acuerdo_entrevista', 'Acuerdo Entrevista:') !!}
    {!! Form::number('acuerdo_entrevista', null, ['class' => 'form-control']) !!}
</div>

<!-- Acuerdo Audio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('acuerdo_audio', 'Acuerdo Audio:') !!}
    {!! Form::number('acuerdo_audio', null, ['class' => 'form-control']) !!}
</div>

<!-- Acuerdo Informe Field -->
<div class="form-group col-sm-6">
    {!! Form::label('acuerdo_informe', 'Acuerdo Informe:') !!}
    {!! Form::number('acuerdo_informe', null, ['class' => 'form-control']) !!}
</div>

<!-- Personales Analisis Field -->
<div class="form-group col-sm-6">
    {!! Form::label('personales_analisis', 'Personales Analisis:') !!}
    {!! Form::number('personales_analisis', null, ['class' => 'form-control']) !!}
</div>

<!-- Personales Informe Field -->
<div class="form-group col-sm-6">
    {!! Form::label('personales_informe', 'Personales Informe:') !!}
    {!! Form::number('personales_informe', null, ['class' => 'form-control']) !!}
</div>

<!-- Personales Publicar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('personales_publicar', 'Personales Publicar:') !!}
    {!! Form::number('personales_publicar', null, ['class' => 'form-control']) !!}
</div>

<!-- Sensibles Analisis Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sensibles_analisis', 'Sensibles Analisis:') !!}
    {!! Form::number('sensibles_analisis', null, ['class' => 'form-control']) !!}
</div>

<!-- Sensibles Informe Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sensibles_informe', 'Sensibles Informe:') !!}
    {!! Form::number('sensibles_informe', null, ['class' => 'form-control']) !!}
</div>

<!-- Sensibles Publicar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sensibles_publicar', 'Sensibles Publicar:') !!}
    {!! Form::number('sensibles_publicar', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Usuario Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_usuario', 'Id Usuario:') !!}
    {!! Form::number('id_usuario', null, ['class' => 'form-control']) !!}
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

<!-- Updated At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('updated_at', 'Updated At:') !!}
    {!! Form::date('updated_at', null, ['class' => 'form-control','id'=>'updated_at']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#updated_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('consentimientos.index') !!}" class="btn btn-default">Cancel</a>
</div>
