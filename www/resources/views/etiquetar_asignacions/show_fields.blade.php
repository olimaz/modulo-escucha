
<!-- Id E Ind Fvt Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_e_ind_fvt', 'Entrevista:') !!}
    <p>{!! $etiquetarAsignacion->codigo_entrevista !!}</p>
</div>

<!-- Id Transcriptor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_transcriptor', 'Etiquetador asignado:') !!}
    <p>{!! $etiquetarAsignacion->fmt_id_transcriptor !!}</p>
</div>


<div class="form-group col-sm-6">
    {!! Form::label('id_transcriptor', 'Asignado por:') !!}
    <p>{!! $etiquetarAsignacion->fmt_id_autoriza !!}</p>
</div>


<div class="form-group col-sm-6">
    {!! Form::label('id_transcriptor', 'Es urgente:') !!}
    <p>{!! $etiquetarAsignacion->fmt_urgente !!}</p>
</div>


<!-- Id Situacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_situacion', 'Estado actual:') !!}
    <p>{!! $etiquetarAsignacion->fmt_id_situacion !!}</p>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('id_situacion', 'Si no fué etiquetado, clasifique la causa:') !!}
    <p>{!! $etiquetarAsignacion->fmt_id_causa !!}</p>
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    <p>{!! $etiquetarAsignacion->observaciones !!}</p>
</div>


<div class="clearfix"></div>
<!-- Fh Asignado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_asignado', 'FH Inicio transcripción:') !!}
    <p>{!! $etiquetarAsignacion->fh_inicio !!}</p>
</div>

<!-- Fh Revocado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_revocado', 'FH Fin transcripción:') !!}
    <p>{!! $etiquetarAsignacion->fh_fin !!}</p>
</div>

<!-- Fh Transcrito Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_transcrito', 'Tiempo real de etiquetado (calculado a partir de fechas de inicio/fin):') !!}
    <p>{!! $etiquetarAsignacion->duracion_transcripcion_real_minutos !!} minutos</p>
</div>

<!-- Fh Transcrito Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_transcrito', 'Tiempo efectivo de etiquetado (calculado por el transcriptor):') !!}
    <p>{!! $etiquetarAsignacion->duracion_transcripcion_minutos !!} minutos</p>
</div>

<div class="clearfix"></div>

<!-- Fh Asignado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_asignado', 'FH Asignado:') !!}
    <p>{!! $etiquetarAsignacion->fh_asignado !!}</p>
</div>

<!-- Fh Revocado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_revocado', 'FH Revocado:') !!}
    <p>{!! $etiquetarAsignacion->fh_revocado !!}</p>
</div>

<!-- Fh Transcrito Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_transcrito', 'FH Finalizado:') !!}
    <p>{!! $etiquetarAsignacion->fh_transcrito !!}</p>
</div>

<!-- Fh Transcrito Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fh_transcrito', 'FH Anulado:') !!}
    <p>{!! $etiquetarAsignacion->fh_anulado !!}</p>
</div>

