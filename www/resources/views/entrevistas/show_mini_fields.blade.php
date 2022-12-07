{{-- Esta vista se utiliza para diligenciar las fichas --}}

<!-- Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha', 'Fecha de la entrevista:') !!}
    <p>{!! $expediente->fmt_entrevista_fecha !!}</p>
</div>

<!-- Id Lugar Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_lugar', 'Lugar de la entrevista:') !!}
    <p>{!! $expediente->fmt_entrevista_lugar !!}</p>
</div>
<!-- detalles -->
<div class="form-group col-sm-6">
    <label>Información relacionada</label>
    <ul>
        <li>Aporta documentación: {{ $entrevista->fmt_documentacion_aporta }}</li>
        <li>Menciona testigos: {{ $entrevista->fmt_identifica_testigos }}</li>
    </ul>

</div>
<div class="form-group col-sm-6">
    <label>Acerca de la entrevista</label>
    <ul>
        <li>Se recomienda ampliar el relato: {{ $entrevista->fmt_ampliar_relato }}</li>
        <li>Se recomienda priorizar la entrevista: {{ $entrevista->fmt_priorizar_entrevista }}</li>
        <li>¿Identifica patrones? {{ $entrevista->fmt_contiene_patrones }}</li>
    </ul>
</div>


<!-- Anotaciones Field -->
<div class="form-group col-sm-12">
    {!! Form::label('anotaciones', 'Observaciones:') !!}
    <p>{!! nl2br($entrevista->observaciones) !!}</p>
</div>



