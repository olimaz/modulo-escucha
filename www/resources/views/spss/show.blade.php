<link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
<table class="table table-responsive table-condensed table-bordered">
    <thead>
    <tr>
        @foreach($info->encabezados as $id_seccion => $detalle_seccion)
            <th colspan="{{ count($detalle_seccion) }}"  class="{{ $id_seccion%2==0 ? 'bg-info ' : '' }}"> {{ $info->secciones[$id_seccion] }}</th>
        @endforeach
    </tr>
    <tr>
        @foreach($info->encabezados as $id_seccion => $detalle_seccion)
            @foreach($detalle_seccion as $txt)
                <th class="{{ $id_seccion%2==0 ? 'bg-info ' : '' }}">{{ $txt }}</th>
            @endforeach
        @endforeach
    </tr>
    </thead>

    <tbody>
    @foreach($info->datos as $seccion)
        <tr>
            @foreach($seccion as $info)
                @foreach($info as $txt)
                    <td>{{ $txt }}</td>
                @endforeach
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>