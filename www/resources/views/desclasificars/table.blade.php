<div class="table-responsive">
    <table class="table" id="desclasificars-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Instrumento</th>
                <th>Nivel</th>
                <th>Acceso otorgado a</th>
                <th>Autorizado por</th>
                <th>Fecha gestión</th>
                <th>Autorizado desde</th>
                <th>Autorizado hasta</th>
                <th>Soporte</th>
                @can('sistema-abierto')
                    <th>Retirar autorización</th>
                @endcan
            </tr>
        </thead>
        <tbody>
        @php($i = $desclasificars->firstItem())
        @foreach($desclasificars as $desclasificar)
            <tr>
                <td>{{ $i++ }}</td>
                <td>
                    <a href="{!! $desclasificar->entrevista->url !!}">
                        {{ $desclasificar->entrevista->entrevista->entrevista_codigo }}
                    </a>
                </td>
                <td> {{ isset($desclasificar->entrevista->entrevista->clasifica_nivel) ? $desclasificar->entrevista->entrevista->clasifica_nivel : $desclasificar->entrevista->entrevista->clasificacion_nivel }}</td>
                <td>{{ $desclasificar->fmt_id_autorizado }}</td>
                <td>{{ $desclasificar->fmt_id_autorizador }}</td>
                <td>{{ $desclasificar->fmt_fh_insert }}</td>
                <td>{{ $desclasificar->fmt_fh_del }}</td>
                <td>{{ $desclasificar->fmt_fh_al }}</td>
                <td>{!! $desclasificar->fmt_url_soporte !!} </td>
                @can('sistema-abierto')
                <td>
                    {!! Form::open(['action' => ['reservado_accesoController@destroy', $desclasificar->id_reservado_acceso], 'method' => 'delete']) !!}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Seguro que desea eliminar la autorización?')"]) !!}
                    {!! Form::close()  !!}
                </td>
                @endcan
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
