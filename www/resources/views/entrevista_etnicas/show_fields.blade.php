<!-- Entrevista Fecha Field -->
<div class="form-group col-sm-4">
    {!! Form::label('entrevista_fecha', 'Fecha de la entrevista:') !!}
    <p>{!! $entrevistaEtnica->fmt_entrevista_fecha_rango !!}
        @if($entrevistaEtnica->tiempo_entrevista>0)
            <br> ({{ $entrevistaEtnica->tiempo_entrevista }} minutos)
        @endif
    </p>
</div>

<!-- Entrevista Lugar Field -->
<div class="form-group col-sm-4">
    <label>Lugar de la entrevista: {!!   $entrevistaEtnica->es_virtual == 1 ? "<span class='text-success'>-Medios virtuales-</span>" : "" !!}</label>
    <p>{!! $entrevistaEtnica->fmt_entrevista_lugar !!}</p>
</div>

{{--
<!-- Id Entrevistador Field -->
<div class="form-group col-sm-3">
    {!! Form::label('id_entrevistador', 'Entrevistador:') !!}
    <p>{!! $entrevistaEtnica->fmt_id_entrevistador !!}</p>
</div>
--}}

<!-- Id Territorio Field -->
<div class="form-group col-sm-4">
    {!! Form::label('id_territorio', 'Territorio:') !!}
    <p>{!! $entrevistaEtnica->fmt_id_territorio !!}</p>
</div>

<hr>

<!-- Equipo Facilitador Field -->
<div class="form-group col-sm-3">
    {!! Form::label('entrevista_avance', 'Situación actual de la entrevista:') !!}
    <p>{!! $entrevistaEtnica->fmt_entrevista_avance !!}</p>
</div>
<!-- Equipo Facilitador Field -->
<div class="form-group col-sm-3">
    {!! Form::label('equipo_facilitador', 'Facilitador:') !!}
    <p>{!! $entrevistaEtnica->equipo_facilitador !!}</p>
</div>

<!-- Equipo Memorista Field -->
<div class="form-group col-sm-3">
    {!! Form::label('equipo_memorista', 'Memorista:') !!}
    <p>{!! $entrevistaEtnica->equipo_memorista !!}</p>
</div>

@if(strlen($entrevistaEtnica->equipo_otros) > 0)
    <!-- Equipo Otros Field -->
    <div class="form-group col-sm-3">
        {!! Form::label('equipo_otros', 'Otros miembros del equipo:') !!}
        <p>{!! $entrevistaEtnica->equipo_otros !!}</p>
    </div>
@endif


<!-- Cantidad Participantes Field -->
<div class="form-group  col-sm-3">
    {!! Form::label('id_tipo_entrevista', 'Tipo de entrevista:') !!}
    <p>{!! $entrevistaEtnica->fmt_id_tipo_entrevista !!}</p>
</div>
<div class="form-group  col-sm-3">
    {!! Form::label('id_tipo_sujeto', 'Tipo de sujeto:') !!}
    <p>{!! $entrevistaEtnica->fmt_id_tipo_sujeto !!}</p>
</div>


<!-- Cantidad Participantes Field -->
<div class="form-group  col-sm-3">
    {!! Form::label('cantidad_participantes', 'Cantidad de participantes:') !!}
    <p>{!! $entrevistaEtnica->cantidad_participantes !!}</p>
</div>

<!-- Id Sector Field -->
<div class="form-group  col-sm-3">
    {!! Form::label('id_sector', 'Sector:') !!}
    <p>{!! $entrevistaEtnica->fmt_id_sector !!}</p>
</div>

<div class="clearfix"></div>

<div class="form-group  col-sm-4">
    {!! Form::label('indigena', 'Pueblos indígenas participantes:') !!}
    @if(count($entrevistaEtnica->rel_indigena)<1)
        <br> No aplica / Sin especificar
    @else
        <ul>
            @foreach($entrevistaEtnica->rel_indigena as $detalle)
                <li>{{ $detalle->fmt_id_indigena }}</li>
            @endforeach
        </ul>
    @endif
</div>
<div class="form-group  col-sm-4">
    {!! Form::label('narp', 'Pueblos afro participantes:') !!}
    @if(count($entrevistaEtnica->rel_narp)<1)
        <br>No aplica / Sin especificar
    @else
        <ul>
            @foreach($entrevistaEtnica->rel_narp as $detalle)
                <li>{{ $detalle->fmt_id_narf }}</li>
            @endforeach
        </ul>
    @endif
</div>
<div class="form-group  col-sm-4">
    {!! Form::label('rrom', 'Kumpany participantes:') !!}
    @if(count($entrevistaEtnica->rel_rrom)<1)
        <br>No aplica / Sin especificar
    @else
        <ul>
            @foreach($entrevistaEtnica->rel_rrom as $detalle)
                <li>{{ $detalle->fmt_id_rrom }}</li>
            @endforeach
        </ul>
    @endif
</div>



<!-- Tema Descripcion Field -->
<div class="form-group col-sm-12">
    {!! Form::label('tema_descripcion', 'Tema de la entrevista:') !!}
    <p>{!! nl2br($entrevistaEtnica->tema_descripcion) !!}</p>
</div>

<!-- Tema Objetivo Field -->
<div class="form-group col-sm-12">
    {!! Form::label('tema_objetivo', 'Objetivo de la entrevista:') !!}
    <p>{!! nl2br($entrevistaEtnica->tema_objetivo) !!}</p>
</div>

<!-- Tema Del Field -->
<div class="form-group  col-sm-6">
    {!! Form::label('tema_del', 'Alcance temporal:') !!}
    <p>{!! $entrevistaEtnica->fmt_tema_fecha !!}</p>
</div>

<!-- Tema Al Field -->
<div class="form-group  col-sm-6">
    {!! Form::label('tema_al', 'Alcance geográfico:') !!}
    <p>{!! $entrevistaEtnica->fmt_tema_lugar !!}</p>
</div>




<!-- Eventos Descripcion Field -->
<div class="form-group col-sm-12">
    {!! Form::label('eventos_descripcion', 'Descripción de los eventos:') !!}
    <p>{!! nl2br($entrevistaEtnica->eventos_descripcion) !!}</p>
</div>


<div class="form-group col-sm-12">
    {!! Form::label('titulo', 'Descripción de la entrevista (título):') !!}
    <p>{!! nl2br($entrevistaEtnica->titulo) !!}</p>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('dinámicas', 'Dinámicas identificadas en la entrevista:') !!}
    <ul>
        @foreach($entrevistaEtnica->rel_dinamica as $dinamica)
            <li>{{ $dinamica->dinamica }}</li>
        @endforeach
    </ul>
</div>

<!-- Nucleos temáticos -->
<div class="form-group  col-sm-12">
    {!! Form::label('interes', 'Puede ser de interés para los siguientes núcleos temáticos:') !!}
    <ul>
        @foreach($entrevistaEtnica->rel_interes as $interes)
            <li>{{ $interes->fmt_id_interes }}</li>
        @endforeach
    </ul>
</div>

<!-- Mandato -->
<div class="form-group  col-sm-12">
    {!! Form::label('mandato', 'Coincide con los siguientes puntos del mandato:') !!}
    <ul>
        @foreach($entrevistaEtnica->rel_mandato as $mandato)
            <li>{{ $mandato->fmt_id_mandato }}</li>
        @endforeach
    </ul>
</div>

<!-- Observaciones Field -->
<div class="form-group  col-sm-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    <p>{!! nl2br($entrevistaEtnica->observaciones) !!}</p>
</div>

{{-- Enlaces y unificaciones --}}
@php($listado_enlaces = \App\Models\enlace::listado_enlaces(config('expedientes.ee'),$entrevistaEtnica->id_entrevista_etnica))
@if(count($listado_enlaces)>0)
    <div class="col-sm-12">
        {!! Form::label('enlaces', 'Enlaces con otras entrevistas:') !!}
        @include('partials.tabla_enlaces')
    </div>
@endif
<div class="clearfix"></div>