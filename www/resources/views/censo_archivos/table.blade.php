<div class="table-responsive">
    <table class="table" id="censoArchivos-table">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Tipo</th>
                <th>Productor</th>
                <th>Reseña</th>
                <th>Ubicación</th>

                <th >Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($censoArchivos as $censoArchivos)
            @php($link = "style='cursor: pointer;' onclick='window.location.href=".'"'.action('censo_archivosController@show',$censoArchivos->id_censo_archivos).'"'.";'")
            <tr>
                <td {!!  $link!!} >{{ $censoArchivos->entrevista_codigo }}</td>
                <td {!!  $link!!}> {{ $censoArchivos->fmt_id_tipo }}</td>
                <td {!!  $link!!}> {!! nl2br($censoArchivos->perfil_productor) !!} </td>
                <td {!!  $link!!}> {!! nl2br($censoArchivos->sintesis) !!} </td>
                <td {!!  $link!!}> {{ $censoArchivos->fmt_id_geo }}</td>

                <td>
                    {!! Form::open(['route' => ['censoArchivos.destroy', $censoArchivos->id_censo_archivos], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('censoArchivos.show', [$censoArchivos->id_censo_archivos]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        @if($censoArchivos->puede_modificar_entrevista())
                            <a href="{{ route('censoArchivos.edit', [$censoArchivos->id_censo_archivos]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        @endif
                        {{-- Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) --}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
