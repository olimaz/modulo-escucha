<div class="table-responsive">
    <table class="table" id="misCasos-table">
        <thead>
        <tr>
            <th data-toggle="tooltip" title="Consecutivo asignado a la entrevista"># Caso.</th>
            <th>Código</th>
            {{--
            <th>Macroterritorio</th>
            <th>Territorio</th>
            --}}

            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Avance</th>

            <th data-toggle="tooltip" title="Cantidad de archivos adjuntos">Adjuntos</th>
            <th data-toggle="tooltip" title="Cantidad de entrevistas asociadas">Entrevistas</th>

            <th>Acciones</th>

        </tr>
        </thead>
        <tbody>
        @foreach($misCasos as $miCaso)
            @php($link = "style='cursor: pointer;' onclick='window.location.href=".'"'.action('mis_casosController@show',$miCaso->id_mis_casos).'"'.";'")
            <tr>
                <td class="text-center"  {!! $link !!}>{!! $miCaso->entrevista_correlativo !!}</td>
                <td {!! $link !!} >{!! $miCaso->entrevista_codigo !!}</td>
                 {{--

                <td {!! $link !!} >{!! $miCaso->fmt_id_macroterritorio !!}</td>
                <td {!! $link !!} >{!! $miCaso->fmt_id_territorio !!}</td>
                --}}

                <td {!! $link !!} >{!! $miCaso->nombre !!}</td>
                <td  >{!! $miCaso->fmt_descripcion !!}</td>
                <td  {!! $link !!} >{!! $miCaso->fmt_id_avance !!}</td>

                <td {!! $link !!} class="text-center">{!! $miCaso->rel_adjuntos()->count() !!}</td>
                <td {!! $link !!} class="text-center">{!! count($miCaso->listado_entrevistas) !!}</td>
                <td>
                    {!! Form::open(['route' => ['misCasos.destroy', $miCaso->id_mis_casos], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a data-toggle="tooltip" title="Ver detalles del caso"  href="{!! action('mis_casosController@show', [$miCaso->id_mis_casos]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                        @can('sistema-abierto')
                            @if(in_array($miCaso->privilegios,[1]) )
                                <a data-toggle="tooltip" title="Modificar caso" href="{!! action('mis_casosController@edit', [$miCaso->id_mis_casos]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'title'=>'Borrar caso', 'data-toggle'=> 'tooltip' ,'onclick' => "return confirm('¿ Segura ?')"]) !!}
                            @endif
                        @endif

                    </div>
                    {!! Form::close() !!}
                </td>

            </tr>

        @endforeach
        </tbody>
    </table>
</div>
