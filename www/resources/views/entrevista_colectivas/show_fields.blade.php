<!-- Entrevista Fecha Field -->
<div class="form-group col-sm-4">
    {!! Form::label('entrevista_fecha', 'Fecha de la entrevista:') !!}
    <p>{!! $entrevistaColectiva->fmt_entrevista_fecha_rango !!}
        @if($entrevistaColectiva->tiempo_entrevista>0)
            <br> ({{ $entrevistaColectiva->tiempo_entrevista }} minutos)
        @endif
    </p>
</div>

<!-- Entrevista Lugar Field -->
<div class="form-group col-sm-4">
    <label>Lugar de la entrevista: {!!   $entrevistaColectiva->es_virtual == 1 ? "<span class='text-success'>-Medios virtuales-</span>" : "" !!}</label>
    <p>{!! $entrevistaColectiva->fmt_entrevista_lugar !!}</p>
</div>

{{--
<!-- Id Entrevistador Field -->
<div class="form-group col-sm-3">
    {!! Form::label('id_entrevistador', 'Entrevistador:') !!}
    <p>{!! $entrevistaColectiva->fmt_id_entrevistador !!}</p>
</div>
--}}

<!-- Id Territorio Field -->
<div class="form-group col-sm-4">
    {!! Form::label('id_territorio', 'Territorio:') !!}
    <p>{!! $entrevistaColectiva->fmt_id_territorio !!}</p>
</div>

<hr>

<!-- Equipo Facilitador Field -->
<div class="form-group col-sm-3">
    {!! Form::label('entrevista_avance', 'Situación actual de la entrevista:') !!}
    <p>{!! $entrevistaColectiva->fmt_entrevista_avance !!}</p>
</div>
<!-- Equipo Facilitador Field -->
<div class="form-group col-sm-3">
    {!! Form::label('equipo_facilitador', 'Facilitador:') !!}
    <p>{!! $entrevistaColectiva->equipo_facilitador !!}</p>
</div>

<!-- Equipo Memorista Field -->
<div class="form-group col-sm-3">
    {!! Form::label('equipo_memorista', 'Memorista:') !!}
    <p>{!! $entrevistaColectiva->equipo_memorista !!}</p>
</div>

@if(strlen($entrevistaColectiva->equipo_otros) > 0)
    <!-- Equipo Otros Field -->
    <div class="form-group col-sm-3">
        {!! Form::label('equipo_otros', 'Otros miembros del equipo:') !!}
        <p>{!! $entrevistaColectiva->equipo_otros !!}</p>
    </div>
@endif
    <div class="clearfix"></div>
<!-- Cantidad Participantes Field -->
<div class="form-group  col-sm-6">
    {!! Form::label('cantidad_participantes', 'Cantidad de participantes:') !!}
    <p>{!! $entrevistaColectiva->cantidad_participantes !!}</p>
</div>

<!-- Id Sector Field -->
<div class="form-group  col-sm-6">
    {!! Form::label('id_sector', 'Sector:') !!}
    <p>{!! $entrevistaColectiva->fmt_id_sector !!}</p>
</div>

<!-- Tema Descripcion Field -->
<div class="form-group col-sm-12">
    {!! Form::label('tema_descripcion', 'Tema de la entrevista:') !!}
    <p>{!! nl2br($entrevistaColectiva->tema_descripcion) !!}</p>
</div>

<!-- Tema Objetivo Field -->
<div class="form-group col-sm-12">
    {!! Form::label('tema_objetivo', 'Objetivo de la entrevista:') !!}
    <p>{!! nl2br($entrevistaColectiva->tema_objetivo) !!}</p>
</div>

<!-- Tema Del Field -->
<div class="form-group  col-sm-6">
    {!! Form::label('tema_del', 'Alcance temporal:') !!}
    <p>{!! $entrevistaColectiva->fmt_tema_fecha !!}</p>
</div>

<!-- Tema Al Field -->
<div class="form-group  col-sm-6">
    {!! Form::label('tema_al', 'Alcance geográfico:') !!}
    <p>{!! $entrevistaColectiva->fmt_tema_lugar !!}</p>
</div>




<!-- Eventos Descripcion Field -->
<div class="form-group col-sm-12">
    {!! Form::label('eventos_descripcion', 'Descripción de los eventos:') !!}
    <p>{!! nl2br($entrevistaColectiva->eventos_descripcion) !!}</p>
</div>


<div class="form-group col-sm-12">
    {!! Form::label('titulo', 'Descripción de la entrevista (título):') !!}
    <p>{!! nl2br($entrevistaColectiva->titulo) !!}</p>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('dinámicas', 'Dinámicas identificadas en la entrevista:') !!}
    <ul>
        @foreach($entrevistaColectiva->rel_dinamica as $dinamica)
            <li>{{ $dinamica->dinamica }}</li>
        @endforeach
    </ul>
</div>

<!-- Nucleos temáticos -->
<div class="form-group  col-sm-12">
    {!! Form::label('interes', 'Puede ser de interés para los siguientes núcleos temáticos:') !!}
    <ul>
        @foreach($entrevistaColectiva->rel_interes as $interes)
            <li>{{ $interes->fmt_id_interes }}</li>
        @endforeach
    </ul>
</div>

<!-- Mandato -->
<div class="form-group  col-sm-12">
    {!! Form::label('mandato', 'Coincide con los siguientes puntos del mandato:') !!}
    <ul>
        @foreach($entrevistaColectiva->rel_mandato as $mandato)
            <li>{{ $mandato->fmt_id_mandato }}</li>
        @endforeach
    </ul>
</div>

<!-- Observaciones Field -->
<div class="form-group  col-sm-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    <p>{!! nl2br($entrevistaColectiva->observaciones) !!}</p>
</div>

{{-- Enlaces y unificaciones --}}
@php($listado_enlaces = \App\Models\enlace::listado_enlaces(config('expedientes.co'),$entrevistaColectiva->id_entrevista_colectiva))
@if(count($listado_enlaces)>0)
    <div class="col-sm-12">
        {!! Form::label('enlaces', 'Enlaces con otras entrevistas:') !!}
        @include('partials.tabla_enlaces')
    </div>
@endif
<div class="clearfix"></div>
