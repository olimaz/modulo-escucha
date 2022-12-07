<div class="table-responsive">
    <table class="table table-bordered table-condensed table-hover" id="hechos-table">
        <thead>
            <tr>
                @if ($expediente->tipo_entrevista()=='individual')
                    <th>Fecha</th>
                    <th>Lugar</th>                    
                @endif
                <th>Violencia</th>
                {{-- <th>Víctimas</th> --}}
                <th>Responsabilidad</th>
                {{--
                <th>Cant. Víctimas</th>
                --}}
                @if(!isset($no_editar))
                    <th>Avance</th>
                @endif
                <th>Acciones</th>
                <th title="Quien diligencia" data-toggle="tooltip">Q.D.</th>
            </tr>
        </thead>
        <tbody>
        @foreach($hechos as $detalle_hecho)
            <tr>
                @if ($expediente->tipo_entrevista()=='individual')
                    <td>{!! $detalle_hecho->fmt_fecha_ocurrencia !!}</td>
                    <td><small>{!! $detalle_hecho->fmt_id_lugar !!}</small></td>
                @endif
                <td>{!! $detalle_hecho->fmt_violencia !!}</td>
                {{-- <td class="text-center">{!! $detalle_hecho->cantidad_victimas !!}</td> --}}
                <td>{!! $detalle_hecho->fmt_responsabilidad !!}</td>
                @if(!isset($no_editar))
                    <td class="text-center">{!! $detalle_hecho->control_calidad->fmt_completo !!}</td>
                @endif


                <td>
                    @if(isset($no_editar))

                        @if (!isset($show))
                            <a href="{!! action('hechoController@show', [$detalle_hecho->id_hecho]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                        @else 
                            <a href="{!! action('hechoController@show', [$detalle_hecho->id_hecho]) !!}?fs" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                        @endif
                    @else
                        {!! Form::open(['route' => ['hechos.destroy', $detalle_hecho->id_hecho], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{!! action('hechoController@show', [$detalle_hecho->id_hecho]) !!}{{ isset($no_editar) ? '' : '?edicion=1' }}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a href="{!! action('hechoController@edit', [$detalle_hecho->id_hecho]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('¿Desea borrar la ficha de hecho?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    @endif
                </td>
                <td>{{ \App\Models\entrevistador::cual_codigo($detalle_hecho->insert_ent) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
