<!-- Entrevista Fecha Field -->
<div class="form-group col-sm-4">
    {!! Form::label('entrevista_fecha', 'Fecha de la entrevista:') !!}
    <p>{!! $diagnosticoComunitario->fmt_entrevista_fecha_rango !!}

        @if($diagnosticoComunitario->tiempo_entrevista>0)
           <br> ({{ $diagnosticoComunitario->tiempo_entrevista }} minutos)
        @endif

    </p>
</div>


<!-- Entrevista Lugar Field -->
<div class="form-group col-sm-4">
    <label>Lugar de la entrevista: {!!   $diagnosticoComunitario->es_virtual == 1 ? "<span class='text-success'>-Medios virtuales-</span>" : "" !!}</label>
    <p>{!! $diagnosticoComunitario->fmt_entrevista_lugar !!}</p>
</div>

{{--
<!-- Id Entrevistador Field -->
<div class="form-group col-sm-3">
    {!! Form::label('id_entrevistador', 'Entrevistador:') !!}
    <p>{!! $diagnosticoComunitario->fmt_id_entrevistador !!}</p>
</div>
--}}


<!-- Id Territorio Field -->
<div class="form-group col-sm-4">
    {!! Form::label('id_territorio', 'Territorio:') !!}
    <p>{!! $diagnosticoComunitario->fmt_id_territorio !!}</p>
</div>

<hr>

<div class="col-sm-12">
    <h4>Miembros del equipo que realizan la entrevista</h4>
</div>

<!-- Equipo Facilitador Field -->
<div class="form-group col-sm-3">
    {!! Form::label('equipo_facilitador', 'Facilitador:') !!}
    <p>{!! $diagnosticoComunitario->equipo_facilitador !!}</p>
</div>
<div class="form-group col-sm-3">
    {!! Form::label('equipo_relator', 'Relator:') !!}
    <p>{!! $diagnosticoComunitario->equipo_relator !!}</p>
</div>
{{--
<!-- Equipo Memorista Field -->
<div class="form-group col-sm-3">
    {!! Form::label('equipo_memorista', 'Memorista:') !!}
    <p>{!! $diagnosticoComunitario->equipo_memorista !!}</p>
</div>
--}}
<div class="form-group col-sm-3">
    {!! Form::label('equipo_otros', 'Otros miembros del equipo:') !!}
    <p>{!! $diagnosticoComunitario->equipo_otros !!}</p>
</div>

<div class="clearfix"></div>
<div class="col-sm-12">
    <h4>Acerca del contenido de la entrevista</h4>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('tema_comunidad', 'Nombre de la comunidad/organización:') !!}
    <p>{!! nl2br($diagnosticoComunitario->tema_comunidad) !!}</p>
</div>

<!-- Tema Del Field -->
<div class="form-group  col-sm-3">
    {!! Form::label('tema_del', 'Alcance temporal:') !!}
    <p>{!! $diagnosticoComunitario->fmt_tema_fecha !!}</p>
</div>

<!-- Tema Al Field -->
<div class="form-group  col-sm-3">
    {!! Form::label('tema_al', 'Alcance geográfico:') !!}
    <p>{!! $diagnosticoComunitario->fmt_tema_lugar !!}</p>
</div>

<!-- Observaciones Field -->
<div class="form-group  col-sm-12">
    {!! Form::label('observaciones', 'Objetivo del diagnóstico:') !!}
    <p>{!! nl2br($diagnosticoComunitario->tema_objetivo) !!}</p>
</div>


<!-- Cantidad Participantes Field -->
<div class="form-group  col-sm-3">
    {!! Form::label('cantidad_participantes', 'Cantidad Participantes:') !!}
    <p>{!! $diagnosticoComunitario->cantidad_participantes !!}</p>
</div>

<!-- Id Sector Field -->
<div class="form-group  col-sm-9">
    {!! Form::label('id_sector', 'Sector al que pertenecen:') !!}
    <p>{!! $diagnosticoComunitario->fmt_id_sector !!}</p>
</div>


<!-- Tema Objetivo Field -->
<div class="form-group col-sm-12">
    {!! Form::label('tema_objetivo', 'Nombre de las dinámicas:') !!}
    <p>{!! nl2br($diagnosticoComunitario->tema_dinamica) !!}</p>
</div>


<div class="form-group col-sm-12">
    {!! Form::label('titulo', 'Descripción de la entrevista (título):') !!}
    <p>{!! nl2br($diagnosticoComunitario->titulo) !!}</p>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('dinámicas', 'Dinámicas identificadas en la entrevista:') !!}
    <ul>
        @foreach($diagnosticoComunitario->rel_dinamica as $dinamica)
            <li>{{ $dinamica->dinamica }}</li>
        @endforeach
    </ul>
</div>

<!-- Nucleos temáticos -->
<div class="form-group  col-sm-12">
    {!! Form::label('interes', 'Puede ser de interés para los siguientes núcleos temáticos:') !!}
    <ul>
        @foreach($diagnosticoComunitario->rel_interes as $interes)
            <li>{{ $interes->fmt_id_interes }}</li>
        @endforeach
    </ul>
</div>


<!-- Mandato -->
<div class="form-group  col-sm-12">
    {!! Form::label('mandato', 'Coincide con los siguientes puntos del mandato::') !!}
    <ul>
        @foreach($diagnosticoComunitario->rel_mandato as $mandato)
            <li>{{ $mandato->fmt_id_mandato }}</li>
        @endforeach
    </ul>
</div>

<!-- Observaciones Field -->
<div class="form-group  col-sm-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    <p>{!! nl2br($diagnosticoComunitario->observaciones) !!}</p>
</div>
