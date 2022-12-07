@if($prioridad)
    <ul class="list-inline">
        <li><a href="{{ url('explicar/prioridad') }}" target="_blank" data-toggle="tooltip" title="Establecida por: {{ $prioridad->id_tipo==1 ? 'Documentador' : 'Transcriptor' }}"><i class="fa fa-star"></i> Prioridad: {{ $prioridad->ponderacion }}</a></li>
        @if(!empty($prioridad->ahora_entiendo))
            <li data-toggle="tooltip" title="{{ $prioridad->ahora_entiendo }}"><i class="fa fa-info-circle"></i> Elementos explicativos.</li>
        @endif
        @if(!empty($prioridad->cambio_perspectiva))
            <li data-toggle="tooltip" title="{{ $prioridad->cambio_perspectiva }}"><i class="fa fa-info-circle"></i> Nuevas explicaciones.</li>
        @endif
    </ul>
@endif