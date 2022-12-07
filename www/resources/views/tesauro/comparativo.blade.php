@extends('layouts.app')

@section('content_header')
    <h2 class="page-header">Árbol de etiquetas <small>Análisis comparativo, concurrencia de etiquetas.</small></h2>
@endsection
@section('content')

    {{-- Opciones de filtrado --}}
    @include("tesauro.frm_filtros")

    {{-- Resultados --}}
    <div class="col-xs-12">
        {{-- Circulitos --}}
        <div class="box collapsed-box">
            <div class="box-header">
                <h3 class="box-title">Gráfica comparativa de la aplicación del árbol de etiquetas</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body text-center">
                @include("reportes.js_tesauro_circulos")
            </div>
        </div>

        {{-- Tabla de datos --}}
        <div class="box box-primary">
            <div class="box-header">
                <h1 class="box-title">Uso de etiquetas combinadas con la etiqueta base:  <span class="text-primary">{{ \App\Models\tesauro::nombre_completo($filtros->id_tesauro) }}</span></h1>

            </div>
            <div class="box-body table-responsive">
                <table class="table table-condensed table-bordered" id="tabla-tesauro">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Dominio Temático</th>
                        <th>Categoría</th>
                        <th>Sub categoría</th>
                        <th>Nomenclatura</th>
                        <th>Etiquetas aplicadas</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($filas=1)
                    @php($filas1=1)
                    @php($filas2=1)
                    @php($filas3=1)
                    @foreach($tesauro->n1 as $n1=>$txt1)
                        <tr >
                            <td>{{ $filas++ }}</td>
                            <td class="text-purple">{{ $filas1++ }}. {{$txt1['texto']}}</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>{{$txt1['etiqueta']}}</td>
                            <td class="text-center">
                                {{ $txt1['conteo_aplicaciones'] }}
                            </td>
                        </tr>
                        @if(isset($tesauro->n2[$n1]))

                            @foreach($tesauro->n2[$n1] as $n2 => $txt2)
                                <tr >
                                    <td>{{ $filas++ }}</td>
                                    <td>&nbsp;</td>
                                    <td  class="text-primary">{{ $filas2++ }}. {{ $txt2['texto'] }}</td>
                                    <td>&nbsp;</td>
                                    <td>{{$txt2['etiqueta']}}</td>
                                    <td class="text-center">
                                        {{ $txt2['conteo_aplicaciones'] }}
                                    </td>
                                </tr>
                                @if(isset($tesauro->n3[$n1][$n2]))
                                    @php($filas3=1)
                                    @foreach($tesauro->n3[$n1][$n2] as $n3 => $txt3)
                                        <tr>
                                            <td>{{ $filas++ }}</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>{{ $filas3++ }}. {{ $txt3['texto'] }}</td>
                                            <td>{{$txt3['etiqueta']}}</td>
                                            <td class="text-center">
                                                {{ $txt3['conteo_aplicaciones'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            @endforeach
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="clearfix"></div>
@endsection


@push('js')
    <script>
        // This must be a hyperlink
        $("#b_tabla_datos").on('click', function(event) {
            $("#tabla-tesauro").table2excel({
                name: "traza",
                //filename: "sat_problemas_" + new Date().toISOString().replace(/[\-\:\.]/g, "").substring(0,8),
                filename: "tesauro_" + new Date().toLocaleString("en-GB", {timeZone: "America/Bogota"}).replace(/[\-\:\.]/g, "").substring(0,10)+".xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        });

    </script>
@endpush


@push("js")
    <script>
        $(function () {
            $("#tabla-tesauro").DataTable({
                "language": {
                    "url": "{{ url('js/dataTables.spanish.lang') }}"
                },
                "paging":   false,
                "ordering": false,
                "info":     false
            });
        });
    </script>
@endpush
