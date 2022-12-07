@if($prioridad)

    <ul class="list-inline">
        <li><a href="{{ url('explicar/prioridad') }}" target="_blank" data-toggle="tooltip" title="Establecida por: {{ $prioridad->id_tipo==1 ? 'Documentador' : 'Transcriptor' }}"><i class="fa fa-star"></i> Prioridad: {{ $prioridad->ponderacion }}:</a></li>
        <li>Detalle de los hechos: {{ $prioridad->d_hecho }}.</li>
        <li>Detalle del contexto: {{ $prioridad->d_contexto }}.</li>
        <li>Detalle de los impactos: {{ $prioridad->d_impacto }}.</li>
        <li>Detalle del acceso a la justicia y N.R.: {{ $prioridad->d_justicia }}.</li>

    </ul>
    @if(!empty($prioridad->ahora_entiendo))
        <ul class="list-inline">
            <li><i class="fa fa-info-circle"></i> Elementos explicativos: {{ $prioridad->ahora_entiendo }}</li>
        </ul>
    @endif
    @if(!empty($prioridad->cambio_perspectiva))
        <ul class="list-inline">
            <li><i class="fa fa-info-circle"></i> Nuevas explicaciones: {{ $prioridad->cambio_perspectiva }}</li>
        </ul>
    @endif
@endif