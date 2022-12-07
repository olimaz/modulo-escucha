
<!-- Id E Ind Fvt Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_e_ind_fvt', 'Entrevista:') !!}
    <p>{!! $transcribirAsignacion->codigo_entrevista !!}</p>
</div>

<!-- Id Transcriptor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_transcriptor', 'Transcriptor asignado:') !!}
    <p>{!! $transcribirAsignacion->fmt_id_transcriptor !!}</p>
</div>


<div class="form-group col-sm-6">
    {!! Form::label('id_transcriptor', 'Asignado por:') !!}
    <p>{!! $transcribirAsignacion->fmt_id_autoriza !!}</p>
</div>


<div class="form-group col-sm-6">
    {!! Form::label('id_transcriptor', 'Es urgente:') !!}
    <p>{!! $transcribirAsignacion->fmt_urgente !!}</p>
</div>


<!-- Id Situacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_situacion', 'Estado actual:') !!}
    <p>{!! $transcribirAsignacion->fmt_id_situacion !!}</p>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('id_situacion', 'Si no fué transcrito, clasifique la causa:') !!}
    <p>{!! $transcribirAsignacion->fmt_id_causa !!}</p>
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    <p>{!! $transcribirAsignacion->observaciones !!}</p>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('duracion_entrevista_minutos', 'Duración de la entrevista en minutos:') !!}
    <p>{!! $transcribirAsignacion->duracion_entrevista_minutos !!}</p>
</div>


<div class="clearfix"></div>
<!-- Fh Asignado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_asignado', 'FH Inicio transcripción:') !!}
    <p>{!! $transcribirAsignacion->fh_inicio !!}</p>
</div>

<!-- Fh Revocado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_revocado', 'FH Fin transcripción:') !!}
    <p>{!! $transcribirAsignacion->fh_fin !!}</p>
</div>

<!-- Fh Transcrito Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_transcrito', 'Tiempo real de transcripción (calculado a partir de fechas de inicio/fin):') !!}
    <p>{!! $transcribirAsignacion->duracion_transcripcion_real_minutos !!} minutos</p>
</div>

<!-- Fh Transcrito Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_transcrito', 'Tiempo efectivo de transcripción (calculado por el transcriptor):') !!}
    <p>{!! $transcribirAsignacion->duracion_transcripcion_minutos !!} minutos</p>
</div>

<div class="clearfix"></div>

<!-- Fh Asignado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_asignado', 'FH Asignado:') !!}
    <p>{!! $transcribirAsignacion->fh_asignado !!}</p>
</div>

<!-- Fh Revocado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_revocado', 'FH Revocado:') !!}
    <p>{!! $transcribirAsignacion->fh_revocado !!}</p>
</div>

<!-- Fh Transcrito Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_transcrito', 'FH Finalizado:') !!}
    <p>{!! $transcribirAsignacion->fh_transcrito !!}</p>
</div>

<!-- Fh Transcrito Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_transcrito', 'FH Anulado:') !!}
    <p>{!! $transcribirAsignacion->fh_anulado !!}</p>
</div>

