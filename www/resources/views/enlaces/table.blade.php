<div class="table-responsive">
    <table class="table" id="enlaces-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Entrevista #1</th>
                <th>Tipo</th>
                <th>Entrevista #2</th>
                <th>Responsable</th>
                <th>Fecha</th>
                <th>Anotaciones</th>
        </thead>
        <tbody>
        @foreach($enlaces as $enlace)
            <tr>
                <td> {{ $loop->iteration }}

                <td> <a href="{{ $enlace->fmt_primaria->link_show }}">
                        {{ $enlace->fmt_primaria->codigo }}
                    </a>
                </td>
                <td>{!!  $enlace->fmt_id_tipo_simple !!} </td>
                <td><a href="{{ $enlace->fmt_secundaria->link_show }}">
                    {{ $enlace->fmt_secundaria->codigo }}
                    </a>
                </td>
                <td>{{ $enlace->fmt_id_entrevistador }}</td>
                <td>{{ $enlace->fmt_fh_insert }}</td>
                <td>{!! nl2br($enlace->anotaciones) !!} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
