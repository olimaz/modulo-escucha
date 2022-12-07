{{-- Igual que tabla de datos, pero espera un arreglo diferente--}}
<div class="text-center" >
    <button class="btn btn-default text-right" onclick="$('#box-{{ $tabla_nombre }}').toggle()">
        Mostrar/Ocultar tabla de datos <i class="fa fa-arrow-down" aria-hidden="true"></i>
    </button>
</div>



<div class="box box-solid box-default" id="box-{{ $tabla_nombre }}" style="display: none">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $tabla_titulo }}</h3>
        <a class='btn btn-info btn-xs pull-right' href="#" id="b_{{ $tabla_nombre }}"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>

    </div>

    <table  id="{{ $tabla_nombre }}" class="table table-condensed table-bordered table-striped ">
        <thead>
        <tr>
            <th>#</th>
            <th>Descripción</th>
            @foreach($tabla_datos->nombre_serie as $nombre_serie)
                <th>{{ $nombre_serie }}</th>
            @endforeach

        </tr>
        </thead>

        <tbody>
            <?php $i=1; $total=0; ?>
            @foreach($tabla_datos->categorias as $id_categoria=>$categoria)
                <tr>
                    <td> {{ $i++ }}</td>
                    <td> {{ $categoria }}</td>
                    @foreach($tabla_datos->a_serie as $id_serie => $valores)
                        <td class="text-center">
                            @if(isset($tabla_click))
                                <a href="{{ $tabla_click."=".$id_categoria }}">
                            @endif
                                {{ isset($valores[$id_categoria]) ? $valores[$id_categoria] : "-" }}
                            @if(isset($tabla_click))
                                </a>
                            @endif
                        </td>
                        @php($total+= isset($valores[$id_categoria]) ? $valores[$id_categoria] : 0)
                    @endforeach
                </tr>
            @endforeach

        </tbody>
        <tfoot>
        <tr>
            <th colspan="2" class="text-center">Total</th>
            <th class="text-center"> {{ number_format($total,0) }}</th>
        </tr>
        </tfoot>
    </table>
</div>


@push('js')
    <script>
        // This must be a hyperlink
        $("#b_{{ $tabla_nombre }}").on('click', function(event) {
            $("#{{ $tabla_nombre }}").table2excel({
                name: "CAIMU",
                //filename: "sat_problemas_" + new Date().toISOString().replace(/[\-\:\.]/g, "").substring(0,8),
                filename: "datos_{{ $tabla_nombre }}" + new Date().toLocaleString("en-GB", {timeZone: "America/Guatemala"}).replace(/[\-\:\.]/g, "").substring(0,10)+ ".xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        });

    </script>
@endpush