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

<div class="card ">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle mr-1"></i> {{ $info_titulo }}
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
        <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body" style="display: block;">
        <div id="{{ $info_div }}" class="grafica">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
            <span class="sr-only">Cargando...</span>
        </div>
    </div>
    <!-- /.card-body -->
    @if(strlen($info_pie)>0)
        <div class="card-footer">
            <span class="text-muted"> {!!  $info_pie!!}  </span>
        </div>
    @endif
</div>


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