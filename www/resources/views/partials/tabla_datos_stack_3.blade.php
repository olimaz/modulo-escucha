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
    <div class="box-body table-responsive no-padding">
        <table  id="{{ $tabla_nombre }}" class="table table-condensed table-bordered table-striped  ">
            <thead>
            <tr >
                <th class="text-center">#</th>
                <th class="text-center">Descripción</th>
                @foreach($tabla_datos->a_series as $id_serie=>$serie)
                    <th class="text-center">{{ $serie }}</th>
                @endforeach
                <th class="text-center">Total</th>
            </tr>
            </thead>

            <tbody>

            <?php $i=1; $total=0; $a_totales=array() ?>
            @foreach($tabla_datos->a_barra as $id_grupo => $grupo)

                <tr>
                    <td class="text-center"> {{ $i++ }}</td>
                    <td> {{ $grupo }}</td>
                    @php($total=0)

                    @foreach($tabla_datos->a_series as $id_serie=>$serie)
                        @php($a_totales[$id_serie] = isset($a_totales[$id_serie]) ? $a_totales[$id_serie] : 0)
                        <td class="text-center">
                            @if(isset($tabla_datos->a_datos[$id_grupo][$id_serie] ))
                                {{ number_format($tabla_datos->a_datos[$id_grupo][$id_serie],0,",",".") }}
                                @php( $total+=$tabla_datos->a_datos[$id_grupo][$id_serie])
                                @php( $a_totales[$id_serie]+=$tabla_datos->a_datos[$id_grupo][$id_serie])
                            @else
                                Cero
                            @endif
                        </td>
                    @endforeach
                    <th class="text-center">{{ number_format($total,0,",",".") }}</th>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-center">Totales</th>
                    @php($gran_total=0)
                    @foreach($a_totales as $val)
                        <th class="text-center">{{number_format($val,0,",",".")}}</th>
                        @php($gran_total+=$val)
                    @endforeach
                    <th class="text-center">{{ number_format($gran_total,0,",",".") }}</th>

                </tr>

            </tfoot>
        </table>
    </div>


</div>



@push('js')
    <script>
        // This must be a hyperlink
        $("#b_{{ $tabla_nombre }}").on('click', function(event) {
            $("#{{ $tabla_nombre }}").table2excel({
                name: "CAIMU",
                //filename: "sat_problemas_" + new Date().toISOString().replace(/[\-\:\.]/g, "").substring(0,8),
                filename: "datos_{{ $tabla_nombre }}" + new Date().toLocaleString("en-GB", {timeZone: "America/Guatemala"}).replace(/[\-\:\.]/g, "").substring(0,10)+".xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        });

    </script>
@endpush