{{-- Para mostrar un gráfico simple --}}
{{--
    $info_titulo: titulo del box
    $info_div: nombre del div, para desplegar el gráfico, debe ser único
    $info_json: para desplegar el frafico
    $info_pie: texto al pié del box
    $info_tabla: datos para mostrar la tabla.  Es opcional: si no se especifica, no se muestra
--}}
@php
    $info_titulo = isset($info_titulo) ? $info_titulo : "";
    $info_pie = isset($info_pie) ? $info_pie : "";
    $info_div = isset($info_div) ? $info_div : "div_".date('isu');
    $tabla_nombre = "t_".$info_div;
    $info_json = isset($info_json) ? $info_json : "";
    $mostrar_tabla = isset($mostrar_tabla) ? $mostrar_tabla : true;
    $tabla_link = isset($tabla_link) ? $tabla_link : false;
@endphp

{{-- Card utilizado para mostrar la gráfica --}}
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                {{ $info_titulo }}
            </h3>
        </div>
        <div class="card-body">
            <div id="{{ $info_div }}" class="grafica">
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
        @if(strlen($info_pie)>0)
            <div class="card-footer">
                <span class="text-muted"> {!!  $info_pie!!}  </span>
            </div>
        @endif
    </div>
@if($mostrar_tabla)
    <div style="margin-top: -15px; margin-bottom: 30px">
        {{-- Tabla de datos --}}
        <div class="text-center" >
            <button class="btn btn-default btn-sm text-right" onclick="$('#box-{{ $tabla_nombre }}').toggle()">
                Mostrar/Ocultar tabla de datos <i class="fa fa-arrow-down" aria-hidden="true"></i>
            </button>
        </div>



        <div class="card  card-secondary card-outline" id="box-{{ $tabla_nombre }}" style="display: none">
            <div class="card-header with-border">
                <h3 class="card-title">{{ $info_titulo }}</h3>
                <div class="card-tools">
                    <a class='btn btn-secondary btn-xs pull-right' href="#" id="b_{{ $tabla_nombre }}"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <table  id="{{ $tabla_nombre }}" class="table table-condensed table-bordered table-hover " >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Opción</th>
                                <th class="text-center">Valor</th>
                                <th class="text-center">%</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- contenido establecido por JS/Ajax--}}
                            </tbody>
                            <tfoot>
                            {{-- contenido establecido por JS/Ajax--}}
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            @if(strlen($info_pie)>0)
                <div class="card-footer">
                    <span class="text-muted"> {!!  $info_pie!!}  </span>
                </div>
            @endif
        </div>
    </div>

@endif

@push('js')
    {{-- Desplegar el gráfico --}}
    <script>
        var chart_{{ $info_div }};
        $(function () {
            chart_{{ $info_div }} = echarts.init(document.getElementById('{{ $info_div }}'), 'light');
            a_chart.push(chart_{{ $info_div }});
        });
    </script>



@endpush


@if($mostrar_tabla)
    {{-- Exportar a excel  --}}
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
@endif