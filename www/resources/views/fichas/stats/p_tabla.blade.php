<div class="card card-info" id="box-{{ $tabla_nombre }}" >
    <div class="card-header with-border">
        <h3 class="card-title">{{ $info_titulo }}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>

    </div>
    <div class="card-body ">
        <div class="row">
            <div class="col-xs-12">
                <div class="float-right">
                    <a class='btn btn-secondary btn-xs ' href="#" id="b_{{ $tabla_nombre }}"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>
                </div>
            </div>
        </div>
        <table  id="{{ $tabla_nombre }}" class="table table-condensed table-bordered table-hover ">
            <thead>
            <tr>
                <th>#</th>
                <th>Opción</th>
                <th class="text-center">Valor</th>
                <th class="text-center">%</th>

            </tr>
            </thead>

            <tbody>
            <?php $i=1; $total=array_sum($info_tabla->valores); ?>

            @foreach($info_tabla->categorias as $id_categoria=>$categoria)
                @if( isset($info_tabla->valores[$id_categoria]) )
                    <tr>
                        <td> {{ $i++ }}</td>
                        <td> {{ $categoria }}</td>
                        <td class="text-center"> {{ number_format($info_tabla->valores[$id_categoria],0,",",".")  }}</td>
                        @if($total>0)
                            <td class="text-center"> {{ number_format($info_tabla->valores[$id_categoria]/$total*100,1,",",".") }}</td>
                        @else
                            -
                        @endif
                    </tr>

                @endif
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th colspan="2" class="text-center">Total</th>
                <th class="text-center"> {{ number_format($total,0,",",".") }}</th>
                <th class="text-center"> 100%</th>
            </tr>
            </tfoot>
        </table>

    </div>
    @if(isset($tabla_pie))
        <div class="card-footer">
            {!! $tabla_pie !!}
        </div>

    @endif


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

        var tabla_html = $("#{{ $tabla_nombre }}");
        var tmp = tabla_html.DataTable({
            "language": {
                "url": "{{ url('js/dataTables.spanish.lang') }}"
            },
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });

    </script>
@endpush