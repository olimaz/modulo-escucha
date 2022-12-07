
<!-- Es Victima Field -->
<div class="form-group col-sm-6">
    {!! Form::label('es_victima', '¿Es víctima de los hechos?:') !!}
    <p>{!! $entrevistado->fmt_es_victima !!}</p>
</div>

<!-- Es Testigo Field -->
<div class="form-group  col-sm-6">
    {!! Form::label('es_testigo', '¿Ha sido testigo/a presencial de los hechos?:') !!}
    <p>{!! $entrevistado->fmt_es_testigo !!}</p>
</div>

<!-- Nombres Field -->
<div class="form-group  col-sm-6">
    {!! Form::label('nombres', 'Nombre:') !!}
    <p>{!! $entrevistado->nombres !!} {!! $entrevistado->apellidos !!}</p>
</div>

<!-- Nacimiento Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nacimiento_fecha', 'Fecha de nacimiento:') !!}
    <p>{!! $entrevistado->fmt_nacimiento_fecha !!}</p>
</div>
