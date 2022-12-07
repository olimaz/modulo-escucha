
<!-- Nombres Field -->
<div class="form-group">
    {!! Form::label('nombres', 'Nombres:') !!}
    <p>{!! $responsable->nombres !!}</p>
</div>

<!-- Apellidos Field -->
<div class="form-group">
    {!! Form::label('apellidos', 'Apellidos:') !!}
    <p>{!! $responsable->apellidos !!}</p>
</div>

<!-- Otros Nombres Field -->
<div class="form-group">
    {!! Form::label('otros_nombres', 'Otros Nombres:') !!}
    <p>{!! $responsable->otros_nombres !!}</p>
</div>

<!-- Sexo Field -->
<div class="form-group">
    {!! Form::label('sexo', 'Sexo:') !!}
    <p>{!! $responsable->fmt_sexo !!}</p>
</div>

<!-- Id Edad Field -->
<div class="form-group">
    {!! Form::label('id_edad', 'Edad:') !!}
    <p>{!! $responsable->fmt_id_edad !!}</p>
</div>

<!-- Pertenencia Etnico Racial Field -->
<div class="form-group">
    {!! Form::label('pertenencia_etnico_racial', 'Pertenencia étnico racial:') !!}
    <p>{!! $responsable->fmt_pertenencia_etnico_racial !!}</p>
</div>

