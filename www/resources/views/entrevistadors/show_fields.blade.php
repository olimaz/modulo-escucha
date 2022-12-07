
<!-- Numero Entrevistador Field -->
<div class="form-group">
    {!! Form::label('numero_entrevistador', 'Numero Entrevistador:') !!}
    <p class="text-primary text-bold">{!! $entrevistador->numero_entrevistador !!}</p>
</div>

<!-- Id Territorial Field -->
<div class="form-group">
    {!! Form::label('id_macroterritorio', 'Macroterritorio:') !!}
    <p>{!! $entrevistador->fmt_id_macroterritorio !!}</p>
</div>
<div class="form-group">
    {!! Form::label('id_territorio', 'Territorio:') !!}
    <p>{!! $entrevistador->fmt_id_territorio !!}</p>
</div>

<div class="form-group">
    {!! Form::label('id_grupo', 'Grupo:') !!}
    <p>{!! $entrevistador->fmt_grupo !!}</p>
</div>


<!-- Id Ubicacion Field -->
<div class="form-group">
    {!! Form::label('id_ubicacion', 'Ubicación:') !!}
    <p>{!! $entrevistador->fmt_id_ubicacion !!}</p>
</div>

<div class="form-group">
    {!! Form::label('id_nivel', 'Perfil de usuario:') !!}
    <p>
        {!! $entrevistador->fmt_id_nivel !!}
        @if($entrevistador->solo_lectura==1)
            <span class="text-danger"> - Restricciones de investigador</span>

        @endif
    </p>
</div>

@if(count($entrevistador->rel_acceso)>0)
    <div class="form-group">
        {!! Form::label('id_acceso', 'Cuenta con acceso a los siguientes grupos:') !!}
        <ul>
            @foreach($entrevistador->rel_acceso as $grupo)
                <li>{!! $grupo->fmt_id_grupo_acceso !!}</li>
            @endforeach
        </ul>

    </div>

@endif

