<table class="table table-responsive table-hover" id="casosInformes-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Código</th>
            <th>Clasificacion</th>
            <th>Acceso</th>
            <th>Titulo</th>
            <th>Autor</th>
            <th>Descripcion</th>
            <th>Adjuntos</th>
            <th >Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($casosInformes as $casosInformes)
        @php($link = "style='cursor: pointer;' onclick='window.location.href=".'"'.action('casos_informesController@show',$casosInformes->id_casos_informes).'"'.";'")
        <tr>
            <td {!! $link !!} >{!! $casosInformes->correlativo !!}</td>
            <td {!! $link !!} data-toggle="tooltip" title="El valor entre paréntesis indica la cantidad de veces que el caso/informe ha sido consultado por algún usuario" >
                {!! $casosInformes->codigo !!}
                <i>
                    ({{ \App\Models\entrevista_individual::conteo_hits($casosInformes) }})
                </i>
            </td>

            <td {!! $link !!} >{!! $casosInformes->fmt_caracterizacion_id_tipo !!}</td>
            <td {!! $link !!} >R-{!! $casosInformes->clasifica_nivel !!}</td>
            <td {!! $link !!} >{!! $casosInformes->titulo !!}</td>
            <td {!! $link !!} >{!! $casosInformes->autor !!}</td>
            <td {!! $link !!} >{!! $casosInformes->descripcion !!}</td>
            <td {!! $link !!} class="text-center">{!! count($casosInformes->adjuntos) !!}</td>
            <td>
                {!! Form::open(['route' => ['casosInformes.destroy', $casosInformes->id_casos_informes], 'method' => 'delete']) !!}
                <div class='btn-group no-print'>
                    <a data-toggle="tooltip" title="Ver detalles del expediente"  href="{!! route('casosInformes.show', [$casosInformes->id_casos_informes]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                    @can('sistema-abierto')
                        @if(Gate::check('escritura') or Gate::check('es-propio',$casosInformes->id_entrevistador))
                            <a data-toggle="tooltip" title="Modificar expediente" href="{!! route('casosInformes.edit', [$casosInformes->id_casos_informes]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-toggle="tooltip" title="Gestionar archivos adjuntos"  href="{!! action('casos_informesController@gestionar_adjuntos', [$casosInformes->id_casos_informes]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-paperclip"></i></a>
                        @endif
                    @endcan
                    <a data-toggle="tooltip" title="Ver estructura dublin core"  href="{!! action('casos_informesController@json_dublin', [$casosInformes->id_casos_informes]) !!}" class='btn btn-default btn-sm'><i class="fa fa-file-code-o" aria-hidden="true"></i></a>
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>