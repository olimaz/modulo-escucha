<p class="lead">Línea de tiempo de la entrevista</p>

<ul class="timeline">
    @if($conteos->hechos==0)
        <li>
            <i class="fa fa-clock-o bg-gray"></i>
        </li>
        <li>
            <div class="timeline-item">
                <div class="timeline-body">
                    No se han ingresado fichas de hechos
                </div>
            </div>
        </li>

    @else
        @foreach($expediente->rel_ficha_hecho as $item)
            <li class="time-label">
                        <span class="bg-purple">
                            {{ $item->fmt_fecha_ocurrencia }}
                        </span>
            </li>
            <li>
                <!-- timeline icon -->
                <i class="fa fa-bolt bg-red"></i>
                <div class="timeline-item">
                    <span class="time">Violaciones: {{ $item->conteo_violaciones }}.(víctimas: {{ $item->cantidad_victimas }} , víctimas identificadas: {{ $item->rel_victima()->count() }}). </span>

                    <h3 class="timeline-header ">{{ $item->fmt_id_lugar }} <small></small></h3>

                    <div class="timeline-body row">
                        <div class="col-sm-6">
                            <span class="text-primary">
                                Violencia:
                            </span>

                            <ul>
                                @foreach($item->rel_violencia as $violacion)
                                    <li>
                                        {{ $violacion->fmt_violencia }}
                                        @if($violacion->rel_id_tipo_violencia->codigo=='21')
                                            ({{ $violacion->fmt_id_lugar_salida }} -> {{ $violacion->fmt_id_lugar_llegada }})
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            <span class="text-primary">
                                Víctimas:
                            </span>
                            <ul>
                                @foreach($item->rel_victima as $victima)

                                    <li>
                                        <a href="{{ url("victimas/show/".$victima->rel_id_victima->id_persona."/entrevista/$expediente->id_e_ind_fvt") }}?id_hecho={{$item->id_hecho}}">
                                        {{ $victima->datos_completos }}
                                        </a>
                                    </li>

                                @endforeach
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-success">
                                Responsabilidad colectiva:
                            </span>
                            <ul>
                                @foreach($item->rel_responsabilidad as $fuerza)
                                    <li>
                                        {!! $fuerza->detalle->nombre !!}
                                        {!! $fuerza->detalle->detalle !!}

                                    </li>
                                @endforeach
                            </ul>
                            @if($item->rel_responsable()->count() > 0)
                                <span class="text-success">
                                    Presunto responsable individual:
                                </span>
                                <ul>
                                    @foreach($item->rel_responsable as $responsable)
                                        <li>
                                            <a href="{{ url("persona_responsable/show/".$responsable->rel_id_persona_responsable->id_persona."/entrevista/$expediente->id_e_ind_fvt") }}">
                                                {{ $responsable->rel_id_persona_responsable->persona->nombre_completo }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                {{--
                                <br>
                                <p class="text-muted">Sin datos de responsable individual</p>
                                --}}
                            @endif
                        </div>


                    </div>
                    <div class="timeline-footer">
                        @if($item->fecha_fin_a >0 )
                            Los hechos finalizaron el {{ $item->fmt_fecha_fin }}.
                        @endif
                        @if($item->aun_continuan==1)
                                <span class="text-muted">Los hechos aún continúan.</span>
                        @endif

                        @if(!isset($no_editar))
                            <a href="{{ action('hechoController@edit',$item->id_hecho) }}" class="btn btn-default btn-sm pull-right">Modificar estos hechos</a>
                        @endif
                            <a href="{{ url("hechos/$item->id_hecho") }}" class="btn btn-info btn-sm pull-right" title="Todos los detalles del hecho" data-toggle="tooltip"><i class="fa fa-envelope-open-o"></i></a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </li>
        @endforeach
    <!-- timeline time label -->
@endif


    <!-- FIN DE LA LINEA DE TIEMPO, DATOS DE LA ENTREVISTA -->
    <li class="time-label">
        <span class="bg-purple">
             {{ $expediente->fmt_entrevista_fecha }}
        </span>
    </li>
    <li>
        <!-- timeline icon -->
        <i class="fa fa-comments bg-green"></i>
        <div class="timeline-item">


            <h3 class="timeline-header">Entrevista {{ $expediente->entrevista_codigo }}</h3>

            <div class="timeline-body">
                <ul>
                    <li>Lugar: {{ $expediente->fmt_entrevista_lugar }}</li>
                    @if($conteos->entrevista == 0)
                        <li class="text-danger">No se ha completado la ficha de entrevista</li>
                    @endif
                    @if($expediente->rel_ficha_persona_entrevistada()->count() > 0)
                        <li>Persona entrevistada:
                            <a href="{{ url("personas/show/".$expediente->entrevistado->id_persona."/entrevista/$expediente->id_e_ind_fvt") }}">
                                {{ $expediente->entrevistado->nombre_completo }}
                            </a>
                        </li>
                    @else
                        <li class="text-danger">No se ha completado la ficha de persona entrevistada</li>
                    @endif
                </ul>

            </div>


        </div>
    </li>
    <li>
        <i class="fa fa-clock-o bg-gray"></i>
    </li>
</ul>

<div class="clearfix"></div>