@extends('layouts.app')

@section('content')

    <div class="col-xs-12">
        <a class='btn btn-info btn-xs pull-right' href="#" id="b_tabla_datos" style="margin-top: 5px"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>

        <h2 >Árbol de etiquetas. <small>Para descripciones específicas, <a href="https://capacitacion.comisiondelaverdad.co/tesauro/vocab/index.php" target="_blank">puede utilizar este enlace</a></small></h2>

    </div>
    <div class="col-xs-12">
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
        <div class="box collapsed-box">
            <div class="box-header">
                <h3 class="box-title">Vista de árbol jerárquico</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body ">
                <div id="tree">

                </div>
            </div>
        </div>


        <div class="box box-primary">


            <div class="box-body table-responsive">
                <table class="table table-condensed table-bordered" id="tabla-tesauro">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Dominio Temático</th>
                        <th>Categoría</th>
                        <th>Sub categoría</th>
                        <th>Nomenclatura</th>
                        <th>Entrevistas con esta etiqueta</th>
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
                            <td class="text-center"> {{ $txt1['conteo_entrevistas'] }}</td>
                            <td class="text-center">
                                @if($txt1['conteo_aplicaciones'] > 0)
                                    <a href="{{ url("buscador?id_tesauro=$n1") }}" target="_blank">
                                    {{ $txt1['conteo_aplicaciones'] }}
                                    </a>
                                @endif
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
                                    <td class="text-center"> {{ $txt2['conteo_entrevistas'] }}</td>
                                    <td class="text-center">
                                        @if($txt2['conteo_aplicaciones'] > 0)
                                            <a href="{{ url("buscador?id_tesauro=$n2") }}" target="_blank">
                                            {{ $txt2['conteo_aplicaciones'] }}
                                            </a>
                                        @endif
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
                                            <td class="text-center"> {{ $txt3['conteo_entrevistas'] }}</td>
                                            <td class="text-center">
                                                @if($txt3['conteo_aplicaciones'] > 0)
                                                    <a href="{{ url("buscador?id_tesauro=$n3") }}" target="_blank">
                                                        {{ $txt3['conteo_aplicaciones'] }}
                                                    </a>
                                                @endif
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

@push("head")
    {{-- wysiwyg CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/jtree/themes/default/style.min.css') }}">
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
    <script src="{{ url('vendor/jtree/jstree.js') }}"></script>
    <script>
        arbolito = {!! \App\Models\tesauro::json_tree($quitar,$poner) !!}  ;
        $('#tree').jstree(arbolito);
    </script>

@endpush
