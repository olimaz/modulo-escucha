<!-- Entrevista Fecha Field -->
<div class="form-group col-sm-4">
    {!! Form::label('entrevista_fecha', 'Fecha de la entrevista:') !!}
    <p>{!! $historiaVida->fmt_entrevista_fecha_rango !!}
        @if($historiaVida->tiempo_entrevista>0)
            <br> ({{ $historiaVida->tiempo_entrevista }} minutos)
        @endif
    </p>
</div>

<!-- Entrevista Lugar Field -->
<div class="form-group col-sm-4">
    <label>Lugar de la entrevista: {!!   $historiaVida->es_virtual == 1 ? "<span class='text-success'>-Medios virtuales-</span>" : "" !!}</label>
    <p>{!! $historiaVida->fmt_entrevista_lugar !!}</p>
</div>

{{--
<!-- Id Entrevistador Field -->
<div class="form-group col-sm-3">
    {!! Form::label('id_entrevistador', 'Entrevistador:') !!}
    <p>{!! $historiaVida->fmt_id_entrevistador !!}</p>
</div>
--}}

<!-- Id Territorio Field -->
<div class="form-group col-sm-4">
    {!! Form::label('id_territorio', 'Territorio:') !!}
    <p>{!! $historiaVida->fmt_id_territorio !!}</p>
</div>

<hr>



<!-- Equipo Facilitador Field -->
<div class="form-group col-sm-3">
    {!! Form::label('entrevista_avance', 'Situación actual de la entrevista:') !!}
    <p>{!! $historiaVida->fmt_entrevista_avance !!}</p>
</div>


<!-- Entrevistado Nombres Field -->
<div class="form-group col-sm-3">
    {!! Form::label('entrevistado_nombres', 'Persona entrevistada:') !!}
    <p>{!! $historiaVida->entrevistado_nombres !!} {!! $historiaVida->entrevistado_apellidos !!} </p>
</div>
<div class="form-group col-sm-3">
    {!! Form::label('entrevistado_nombres', 'Otros nombres:') !!}
    <p>{!! $historiaVida->entrevistado_otros_nombres !!}</p>
</div>

<!-- Id Sector Field -->
<div class="form-group col-sm-3">
    {!! Form::label('id_sector', 'Sector:') !!}
    <p>{!! $historiaVida->fmt_id_sector !!}</p>
</div>

<div class="clearfix"></div>
<div class="form-group col-sm-3">
    {!! Form::label('id_sexo', 'Sexo:') !!}
    <p>{!! $historiaVida->fmt_id_sexo !!}</p>
</div>
<div class="form-group col-sm-3">
    {!! Form::label('id_orientacion_sexual', 'Orientación sexual:') !!}
    <p>{!! $historiaVida->fmt_id_orientacion_sexual !!}</p>
</div>
<div class="form-group col-sm-3">
    {!! Form::label('id_identidad_genero', 'Identidad de género:') !!}
    <p>{!! $historiaVida->fmt_id_identidad_genero !!}</p>
</div>
<div class="form-group col-sm-3">
    {!! Form::label('id_pertenencia_etnico_racial', 'Pertenencia ético racial:') !!}
    <p>{!! $historiaVida->fmt_id_pertenencia_etnico_racial!!}</p>
</div>


<div class="form-group col-sm-12">
    {!! Form::label('entrevista_objetivo', 'Objetivo de la entrevista:') !!}
    <p>{!! nl2br($historiaVida->entrevista_objetivo) !!}</p>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('tema', 'Temas de la entrevista:') !!}
    <ul>
        @foreach($historiaVida->rel_tema as $tema)
            <li> {{ $tema->tema }}</li>
        @endforeach
    </ul>

</div>


<div class="form-group col-sm-12">
    {!! Form::label('titulo', 'Descripción de la entrevista (título):') !!}
    <p>{!! nl2br($historiaVida->titulo) !!}</p>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('dinámicas', 'Dinámicas identificadas en la entrevista:') !!}
    <ul>
        @foreach($historiaVida->rel_dinamica as $dinamica)
            <li>{{ $dinamica->dinamica }}</li>
        @endforeach
    </ul>
</div>

<!-- Nucleos temáticos -->
<div class="form-group  col-sm-12">
    {!! Form::label('interes', 'Puede ser de interés para los siguientes núcleos temáticos:') !!}
    <ul>
        @foreach($historiaVida  ->rel_interes as $interes)
            <li>{{ $interes->fmt_id_interes }}</li>
        @endforeach
    </ul>
</div>

<!-- Mandato -->
<div class="form-group  col-sm-12">
    {!! Form::label('mandato', 'Coincide con los siguientes puntos del mandato::') !!}
    <ul>
        @foreach($historiaVida->rel_mandato as $mandato)
            <li>{{ $mandato->fmt_id_mandato }}</li>
        @endforeach
    </ul>
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    <p>{!! nl2br($historiaVida->observaciones) !!}</p>
</div>

