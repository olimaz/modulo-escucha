{{-- Mostrar los datos de la grafica tipo stack --}}
<div class="text-center">
    <button class="btn btn-default text-right" onclick="$('#box-{{ $tabla_nombre }}').toggle()">

        Mostrar/Ocultar tabla de datos <i class="fa fa-arrow-down" aria-hidden="true"></i>
    </button>
</div>



<div class="box" id="box-{{ $tabla_nombre }}" style="display: none">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $tabla_titulo }}</h3>
        <a class='btn btn-default btn-xs pull-right' href="#" id="b_{{ $tabla_nombre }}"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>

    </div>

    <table  id="{{ $tabla_nombre }}" class="table table-condensed table-bordered table-striped ">
        <thead>
        <tr >
            <th class="text-center">#</th>
            <th class="text-center">Descripción</th>
            @foreach($tabla_datos->series as $id_serie=>$serie)
                <th class="text-center">{{ $serie }}</th>
            @endforeach
            <th class="text-center">Total</th>
        </tr>
        </thead>

        <tbody>

            <?php $i=1; $total=0; ?>
            @foreach($tabla_datos->grupos as $id_grupo => $grupo)
                    <tr>
                        <td class="text-center"> {{ $i++ }}</td>
                        <td> {{ $grupo }}</td>
                        @php($total=0)
                        @foreach($tabla_datos->series as $id_serie=>$serie)
                            <td class="text-center">
                            @if(isset($tabla_datos->datos[$id_serie][$id_grupo] ))
                                {{ number_format($tabla_datos->datos[$id_serie][$id_grupo],0) }}
                                @php( $total+=$tabla_datos->datos[$id_serie][$id_grupo])
                            @else
                                Cero
                            @endif
                            </td>
                        @endforeach
                        <th class="text-center">{{ number_format($total,0) }}</th>
                    </tr>
            @endforeach
        </tbody>
    </table>
</div>


@push('javascript')
    <script>
        // This must be a hyperlink
        $("#b_{{ $tabla_nombre }}").on('click', function(event) {
            $("#{{ $tabla_nombre }}").table2excel({
                name: "CAIMU",
                //filename: "sat_problemas_" + new Date().toISOString().replace(/[\-\:\.]/g, "").substring(0,8),
                filename: "datos_{{ $tabla_nombre }}" + new Date().toLocaleString("en-GB", {timeZone: "America/Guatemala"}).replace(/[\-\:\.]/g, "").substring(0,10),
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        });

    </script>
@endpush