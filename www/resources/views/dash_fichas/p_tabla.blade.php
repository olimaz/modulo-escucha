<div class="box box-solid box-info" id="box-{{ $tabla_nombre }}" >
    <div class="box-header with-border">
        <h3 class="box-title">{{ $info_titulo }}</h3>
        <a class='btn btn-success btn-xs pull-right' href="#" id="b_{{ $tabla_nombre }}"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>
    </div>

    <table  id="{{ $tabla_nombre }}" class="table table-condensed table-bordered table-hover ">
        <thead>
        <tr>
            <th>#</th>
            <th>Opción</th>
            <th class="text-center">Valor</th>

        </tr>
        </thead>

        <tbody>
        <?php $i=1; $total=0; ?>

        @foreach($info_tabla->categorias as $id_categoria=>$categoria)
            @if( isset($info_tabla->valores[$id_categoria]) )
                <tr>
                    <td> {{ $i++ }}</td>
                    <td> {{ $categoria }}</td>
                    <td class="text-center"> {{ number_format($info_tabla->valores[$id_categoria],0,",",".")  }}</td>
                </tr>
                @php($total+=$info_tabla->valores[$id_categoria])
            @endif
        @endforeach

        </tbody>
        <tfoot>
        <tr>
            <th colspan="2" class="text-center">Total</th>
            <th class="text-center"> {{ number_format($total,0,",",".") }}</th>
        </tr>
        </tfoot>
    </table>
</div>

@push('js')
    <script>
        // This must be a hyperlink
        $("#b_{{ $tabla_nombre }}").on('click', function(event) {
            $("#{{ $tabla_nombre }}").table2excel({
                name: "CEV",
                //filename: "sat_problemas_" + new Date().toISOString().replace(/[\-\:\.]/g, "").substring(0,8),
                filename: "datos_{{ $tabla_nombre }}_" + new Date().toLocaleString("en-GB", {timeZone: "America/Bogota"}).replace(/[\-\:\.]/g, "").substring(0,10)+ ".xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        });

    </script>
@endpush