<!-- Entrevista Fecha Field -->
<div class="form-group col-sm-4">
    {!! Form::label('entrevista_fecha', 'Fecha de la entrevista:') !!}
    <p>{!! $entrevistaProfundidad->fmt_entrevista_fecha_rango !!}
        @if($entrevistaProfundidad->tiempo_entrevista>0)
            <br> ({{ $entrevistaProfundidad->tiempo_entrevista }} minutos)
        @endif
    </p>
</div>

<!-- Entrevista Lugar Field -->
<div class="form-group col-sm-4">
    <label>Lugar de la entrevista: {!!   $entrevistaProfundidad->es_virtual == 1 ? "<span class='text-success'>-Medios virtuales-</span>" : "" !!}</label>
    <p>{!! $entrevistaProfundidad->fmt_entrevista_lugar !!}</p>
</div>

{{--
<!-- Id Entrevistador Field -->
<div class="form-group col-sm-4">
    {!! Form::label('id_entrevistador', 'Entrevistador:') !!}
    <p>{!! $entrevistaProfundidad->fmt_id_entrevistador !!}</p>
</div>
--}}

<!-- Id Territorio Field -->
<div class="form-group col-sm-4">
    {!! Form::label('id_territorio', 'Territorio:') !!}
    <p>{!! $entrevistaProfundidad->fmt_id_territorio !!}</p>
</div>


<hr>


<!-- Equipo Facilitador Field -->
<div class="form-group col-sm-4">
    {!! Form::label('entrevista_avance', 'Situación actual de la entrevista:') !!}
    <p>{!! $entrevistaProfundidad->fmt_entrevista_avance !!}</p>
</div>




<!-- Entrevistado Nombres Field -->
<div class="form-group col-sm-4">
    {!! Form::label('entrevistado_nombres', 'Persona entrevistada:') !!}

    <p>{!! $entrevistaProfundidad->entrevistado_nombres !!} {!! $entrevistaProfundidad->entrevistado_apellidos !!}</p>
</div>

<!-- Id Sector Field -->
<div class="form-group col-sm-4">
    {!! Form::label('id_sector', 'Sector:') !!}
    <p>{!! $entrevistaProfundidad->fmt_id_sector !!}</p>
</div>


<div class="form-group col-sm-6">
    {!! Form::label('id_tipo', 'Tipo de entrevista:') !!}
    <p>{!! nl2br($entrevistaProfundidad->fmt_id_tipo) !!}</p>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('entrevista_objetivo', 'Objetivo de la entrevista:') !!}
    <p>{!! nl2br($entrevistaProfundidad->entrevista_objetivo) !!}</p>
</div>
{{-- Nuevos metadatos --}}

<div class="clearfix"></div>

<div class="form-group col-sm-6">
    {!! Form::label('id_poilicia_parte', 'Hizo parte de los paramilitares:') !!}
    <p>{!! $entrevistaProfundidad->fmt_id_paramilitar_parte !!}.
        @if($entrevistaProfundidad->id_paramilitar_parte==1)
            {!! $entrevistaProfundidad->fmt_id_paramilitar_rango !!}.
        @endif
    </p>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('id_poilicia_parte', 'Hizo parte de la guerrilla:') !!}
    <p>{!! $entrevistaProfundidad->fmt_id_guerrilla_parte !!}.
        @if($entrevistaProfundidad->id_guerrilla_parte==1)
            {!! $entrevistaProfundidad->fmt_id_guerrilla_rango !!}.
        @endif
    </p>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('id_poilicia_parte', 'Hizo parte de la Policía:') !!}
    <p>{!! $entrevistaProfundidad->fmt_id_policia_parte !!}.

        @if($entrevistaProfundidad->id_policia_parte==1)
            {!! $entrevistaProfundidad->fmt_id_policia_rango !!}.
        @endif
    </p>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('id_poilicia_parte', 'Hizo parte del ejército:') !!}
    <p>{!! $entrevistaProfundidad->fmt_id_ejercito_parte !!}.
        @if($entrevistaProfundidad->id_ejercito_parte==1)
            {!! $entrevistaProfundidad->fmt_id_ejercito_rango !!}.
        @endif
    </p>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('id_poilicia_parte', 'Hizo parte de la fuerza aérea:') !!}
    <p>{!! $entrevistaProfundidad->fmt_id_fuerza_aerea_parte !!}.
        @if($entrevistaProfundidad->id_fuerza_aerea_parte==1)
            {!! $entrevistaProfundidad->fmt_id_fuerza_aerea_rango !!}.
        @endif
    </p>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('id_poilicia_parte', 'Hizo parte de la fuerza naval:') !!}
    <p>{!! $entrevistaProfundidad->fmt_id_fuerza_naval_parte !!}.
        @if($entrevistaProfundidad->id_fuerza_naval_parte==1)
            {!! $entrevistaProfundidad->fmt_id_fuerza_naval_rango !!}.
        @endif
    </p>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('id_poilicia_parte', 'Hizo parte de otros agentes del estado:') !!}
    <p>{!! $entrevistaProfundidad->fmt_id_agente_estado_parte !!}.
        @if($entrevistaProfundidad->id_agente_estado_parte ==1)
            {!! $entrevistaProfundidad->id_agente_estado_cual !!}.
        @endif
    </p>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('id_poilicia_parte', 'Hizo parte de terceros civiles:') !!}
    <p>{!! $entrevistaProfundidad->fmt_id_tercero_civil_parte !!}.
        @if($entrevistaProfundidad->id_tercero_civil_parte==1)
            {!! $entrevistaProfundidad->id_tercero_civil_cual !!}.
        @endif
    </p>
</div>

<div class="clearfix"></div>

<div class="form-group col-sm-6">
    {!! Form::label('id_violencia_victima', 'Hechos victimizantes mencionados por la víctima:') !!}
    {!! $entrevistaProfundidad->fmt_violencia_victima !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('id_violencia_victima', 'Hechos victimizantes reconocidos por el actor:') !!}
    {!! $entrevistaProfundidad->fmt_violencia_actor !!}
</div>





<div class="clearfix"></div>



<div class="form-group col-sm-12">
    {!! Form::label('tema', 'Temas de la entrevista:') !!}
    <ul>
        @foreach($entrevistaProfundidad->rel_tema as $tema)
            <li> {{ $tema->tema }}</li>
        @endforeach
    </ul>

</div>


<div class="form-group col-sm-12">
    {!! Form::label('titulo', 'Descripción de la entrevista (título):') !!}
    <p>{!! nl2br($entrevistaProfundidad->titulo) !!}</p>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('dinámicas', 'Dinámicas identificadas en la entrevista:') !!}
    <ul>
        @foreach($entrevistaProfundidad->rel_dinamica as $dinamica)
            <li>{{ $dinamica->dinamica }}</li>
        @endforeach
    </ul>
</div>

<!-- Nucleos temáticos -->
<div class="form-group  col-sm-12">
    {!! Form::label('interes', 'Puede ser de interés para los siguientes núcleos temáticos:') !!}
    <ul>
        @foreach($entrevistaProfundidad->rel_interes as $interes)
            <li>{{ $interes->fmt_id_interes }}</li>
        @endforeach
    </ul>
</div>
<!-- Mandato -->
<div class="form-group  col-sm-12">
    {!! Form::label('mandato', 'Coincide con los siguientes puntos del mandato::') !!}
    <ul>
        @foreach($entrevistaProfundidad->rel_mandato as $mandato)
            <li>{{ $mandato->fmt_id_mandato }}</li>
        @endforeach
    </ul>
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    <p>{!! nl2br($entrevistaProfundidad->observaciones) !!}</p>
</div>

{{-- Enlaces y unificaciones --}}
@php($listado_enlaces = \App\Models\enlace::listado_enlaces(config('expedientes.pr'),$entrevistaProfundidad->id_entrevista_profundidad))
@if(count($listado_enlaces)>0)
    <div class="col-sm-12">
        {!! Form::label('enlaces', 'Enlaces con otras entrevistas:') !!}
        @include('partials.tabla_enlaces')
    </div>
@endif
<div class="clearfix"></div>

