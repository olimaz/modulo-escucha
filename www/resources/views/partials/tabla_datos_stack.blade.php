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
        <tr>
            <th>#</th>
            <th>Grupo</th>
            <th>Descripcion</th>
            <th>Valor</th>
        </tr>
        </thead>

        <tbody>

            <?php $i=1; $total=0; ?>
            @foreach($tabla_datos->grupos as $id_grupo => $grupo)
                @foreach($tabla_datos->datos[$id_grupo] as  $id => $info)
                    @php($total+=$info['valor'])
                    <tr>
                        <td> {{ $i++ }}</td>
                        <td> {{ $grupo }}</td>

                        <td>
                            {{ $info['txt'] }}
                        </td>
                        <td class="text-center">
                            @if(isset($tabla_click))
                                <a href="{{ $tabla_click."=".$id }}">
                            @endif
                                    {{ isset($info['valor']) ? $info['valor'] : "-" }}
                            @if(isset($tabla_click))
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th class="text-center" colspan="3">
                Total
            </th>
            <th class="text-center">
                {{ number_format($total,0) }}
            </th>
        </tr>
        </tfoot>
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