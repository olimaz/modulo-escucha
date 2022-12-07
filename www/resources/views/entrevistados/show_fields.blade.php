
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
    {!! Form::label('nombres', 'Nombres:') !!}
    <p>{!! $entrevistado->nombres !!}</p>
</div>

<!-- Apellidos Field -->
<div class="form-group  col-sm-6">
    {!! Form::label('apellidos', 'Apellidos:') !!}
    <p>{!! $entrevistado->apellidos !!}</p>
</div>

<!-- Otros Nombres Field -->
<div class="form-group  col-sm-6">
    {!! Form::label('otros_nombres', 'Otros Nombres:') !!}
    <p>{!! $entrevistado->otros_nombres !!}</p>
</div>

<!-- Nacimiento Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nacimiento_fecha', 'Fecha de nacimiento:') !!}
    <p>{!! $entrevistado->fmt_nacimiento_fecha !!}</p>
</div>

<!-- Nacimiento Lugar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nacimiento_lugar', 'Lugar de nacimiento:') !!}
    <p>{!! $entrevistado->fmt_nacimiento_lugar !!}</p>
</div>

<!-- Sexo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sexo', 'Sexo:') !!}
    <p>{!! $entrevistado->fmt_sexo !!}</p>
</div>

<!-- Orientacion Sexual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('orientacion_sexual', 'Orientacion Sexual:') !!}
    <p>{!! $entrevistado->fmt_orientacion_sexual !!}</p>
</div>

<!-- Identidad Genero Field -->
<div class="form-group col-sm-6">
    {!! Form::label('identidad_genero', 'Identidad Genero:') !!}
    <p>{!! $entrevistado->fmt_identidad_genero !!}</p>
</div>

<!-- Pertenencia Etnico Racial Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pertenencia_etnico_racial', 'Pertenencia Etnico Racial:') !!}
    <p>{!! $entrevistado->fmt_pertenencia_etnico_racial !!}</p>
</div>
