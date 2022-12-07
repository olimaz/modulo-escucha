<div class="card card-info collapsed-card" id="card-{{ $tabla_nombre }}" >
    <div class="card-header ">
        <h3 class="card-title">Combinaciones para: {{ $info_titulo }}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
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



        <div class="w-100"></div>
        <div class="row">
            <div class="col-xs-12">
                <table  id="{{ $tabla_nombre }}" class="table table-condensed table-bordered table-hover ">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Criterio 1</th>
                        <th>Criterio 2</th>
                        <th class="text-center">Valor</th>
                        <th class="text-center">%</th>

                    </tr>
                    </thead>

                    <tbody>
                    <?php $i=1; $total=$info_tabla->total; ?>


                    @foreach($info_tabla->datos as $id=>$fila)
                        <tr>
                            <td> {{ $i++ }}</td>
                            <td> {{ $fila->c1 }}</td>
                            <td> {{ $fila->c2 }}</td>
                            <td class="text-center"> {{ number_format($fila->conteo,0,",",".")  }}</td>
                            @if($total>0)
                                <td class="text-center"> {{ number_format($fila->conteo/$total*100,1,",",".") }}</td>
                            @else
                                -
                            @endif
                        </tr>
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="3" class="text-center">Total</th>
                        <th class="text-center"> {{ number_format($total,0,",",".") }}</th>
                        <th class="text-center"> 100%</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Datos para chi cuadrado --}}
        <div class="row">
            <div class="col">
                <div id="{{ $tabla_nombre }}_chi">
                    Prueba de chi cuadrado:
                    <ul>
                        <li>Valor de chi cuadrado para la tabla mostrada: {{ $info_tabla->chi->chi  }}</li>
                        <li>Valor de la tabla de chi cuadrado para {{ $info_tabla->chi->grados_libertad }} grados de libertad y significancia de {{ $info_tabla->chi->significancia }}: {{ $info_tabla->chi->tabla_chi }}</li>
                        <li>Conclusión: {!! $info_tabla->chi->conclusion_color !!}  </li>
                    </ul>
                </div>
            </div>
        </div>



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

        $(function() {

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
        })

    </script>
@endpush