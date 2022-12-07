
<!-- Id Objetivo Field -->
<div class="form-group">
    {!! Form::label('id_objetivo', 'Objetivo:') !!}
    <p>{!! $documento->fmt_id_objetivo !!}</p>
</div>

<!-- Id Instrumento Field -->
<div class="form-group">
    {!! Form::label('id_instrumento', 'Instrumento:') !!}
    <p>{!! $documento->fmt_id_instrumento !!}</p>
</div>



<!-- Descripcion Field -->
<div class="form-group">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    <p>{!! $documento->descripcion !!}</p>
</div>

<!-- Id Adjunto Field -->
<div class="form-group">
    {!! Form::label('id_adjunto', 'Adjunto:') !!}
    <p>{!! $documento->fmt_url !!}</p>
</div>


