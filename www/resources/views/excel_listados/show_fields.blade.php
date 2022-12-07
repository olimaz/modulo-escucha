
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('created_at', 'Fecha de carga:') !!}
        <p>{{ $excelListados->fmt_created_at }}</p>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('id_entrevistador', 'Entrevistador:') !!}
        <p>{{ $excelListados->fmt_id_entrevistador }}</p>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        {!! Form::label('cantidad_codigos_si', 'Códigos válidos:') !!}
        <p>{{ $excelListados->cantidad_codigos_si }}</p>
    </div>
</div>
<div class="col-md-3">
    <!-- Cantidad Codigos No Field -->
    <div class="form-group">
        {!! Form::label('cantidad_codigos_no', 'Códigos no válidos:') !!}
        <p>{{ $excelListados->cantidad_codigos_no }}</p>
    </div>
</div>

<div class="col-md-6">
    <!-- Descripcion Field -->
    <div class="form-group">
        {!! Form::label('descripcion', 'Descripción:') !!}
        <p>
            {{ $excelListados->descripcion }}

        </p>
    </div>
</div>
<div class="col-md-6">

    <div class="form-group">
        {!! Form::label('descarga', 'Archivo cargado:') !!}
        <p><a href="{{ action('adjuntoController@show_excel',$excelListados->id_adjunto) }}">
            {{ $excelListados->rel_id_adjunto->nombre_original }}
            </a>
        </p>
    </div>
</div>
