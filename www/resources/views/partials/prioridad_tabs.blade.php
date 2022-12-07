@if($prioridad)


    <h4>Puntuación general: {{ $prioridad->ponderacion }}</h4>
    <p>Establecida por: {{ $prioridad->id_tipo==1 ? 'Documentador' : 'Transcriptor' }}</p>

    <ul >
        <li>Establecida por: {{ $prioridad->id_tipo==1 ? 'Documentador' : 'Transcriptor' }}</li>
        <li>Fluidez: {{ $prioridad->fmt_fluidez }}</li>
        <li>Detalle de los hechos: {{ $prioridad->fmt_d_hecho }}</li>
        <li>Detalle del contexto: {{ $prioridad->fmt_d_contexto }}.</li>
        <li>Detalle de los impactos: {{ $prioridad->fmt_d_impacto }}.</li>
        <li>Detalle del acceso a la justicia y N.R.: {{ $prioridad->fmt_d_justicia }}.</li>
        <li>Cierre final: {{ $prioridad->fmt_cierre }}</li>

    </ul>
    @if(!empty($prioridad->ahora_entiendo) && !empty($prioridad->cambio_perspectiva))
        <p><i class="fa fa-info-circle"></i> Aspectos cualitativos:</p>

    @endif
    <ul>

    @if(!empty($prioridad->ahora_entiendo))
            <li><span class="text-primary">Elementos explicativos:</span> {{ $prioridad->ahora_entiendo }}</li>
    @endif
    @if(!empty($prioridad->cambio_perspectiva))
            <li><span class="text-primary">Nuevas explicaciones:</span> {{ $prioridad->cambio_perspectiva }}</li>
    @endif
    </ul>

    <i class="fa fa-hand-o-right"></i> Para una explicación del proceso de priorización, <a href="{{ url('explicar/prioridad') }}" target="_blank" >puede utilizar este enlace.</a>
@endif