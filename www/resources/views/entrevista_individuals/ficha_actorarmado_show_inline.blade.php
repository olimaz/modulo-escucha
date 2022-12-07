<div class="table-responsive">
    <table class="table table-bordered table-condensed table-hover" id="hechos-table">
        <thead>
            <tr>
                <th>Grupo/Fuerza Armada</th>
                <th>Sub-Grupo</th>
                <th>Rango</th>
                <th>Dinamicas de la violencia</th>

                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($hechos as $detalle_hecho)
            <tr >
                <td>{!! $detalle_hecho->fmt_fecha_ocurrencia !!}</td>
                <td><small>{!! $detalle_hecho->fmt_id_lugar !!}</small></td>
                <td>{!! $detalle_hecho->fmt_violencia !!}</td>
                <td>{!! $detalle_hecho->fmt_responsabilidad !!}</td>
              


                <td>
                    @if(isset($no_editar))
                        <a href="{!! action('hechoController@show', [$detalle_hecho->id_hecho]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
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
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
