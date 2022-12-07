@extends('layouts.app')
@section('content_header')
    <h1>Reporte de personas entrevistadas <small>{{ count($listado) }} personas en total</small></h1>
    <p>Información obtenida de fichas diligenciadas de entrevistas a víctimas (VI), Actores Armados (AA), Terceros Civiles (TC), entrevistas a profundidad (PR) e Historias de Vida (HV).  En los instrumentos colectivos (CO, EE, DC), se utiliza información obtenida a partir de los consentimientos informados.</p>
@endsection
@section('content')
    <div class="box box-primary">
        @can('nivel-1')
            <div class="box-header">
                <a class='btn btn-info btn-xs pull-right' href="#" id="b_tabla_datos"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>
            </div>
        @endcan
        <div class="box-body table-responsive">
            <table class="table table-condensed table-striped table-condensed table-bordered" id="entrevistados-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Otros nombres</th>
                        <th>Sexo</th>
                        <th>Año nacimiento</th>
                        <th>Tipo de entrevista</th>
                        <th>Clasificación</th>
                        <th>Código</th>

                    </tr>
                </thead>
                <tbody>
                @php($i=1)
                    @foreach($listado as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->apellido }}</td>
                            <td>{{ $item->alias }}</td>
                            <td>{{ \App\Models\cat_item::describir($item->id_sexo)  }}</td>
                            <td class="text-center">{{ $item->fec_nac_a > 0 ? $item->fec_nac_a : "Sin Especificar" }}</td>
                            <td class="text-center">
                                @if($item->id_subserie == config('expedientes.pr'))
                                    Profundidad
                                @elseif($item->id_subserie == config('expedientes.hv'))
                                    Historia Vida
                                @else
                                    Víctimas
                                @endif
                            </td>
                            <td>
                                R-{{$item->clasificacion_nivel}}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm {{ $item->id_subserie == config('expedientes.vi') ? 'btn-success' : 'btn-primary' }} " target="_blank" href="{{ \App\Models\entrevista_prioridad::url_show_persona($item) }}">  {{ $item->entrevista_codigo  }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection



@push("js")
    <script>
        $(function () {
            $("#entrevistados-table").DataTable({
                "language": {
                    "url": "{{ url('js/dataTables.spanish.lang') }}"
                },
                "paging":   false,
                "ordering": false,
                "info":     false
            });
        });
    </script>
    @can('nivel-1')
        <script>
            // This must be a hyperlink
            $("#b_tabla_datos").on('click', function(event) {
                $("#entrevistados-table").table2excel({
                    name: "traza",
                    //filename: "sat_problemas_" + new Date().toISOString().replace(/[\-\:\.]/g, "").substring(0,8),
                    filename: "personas_entrevistadas_" + new Date().toLocaleString("en-GB", {timeZone: "America/Bogota"}).replace(/[\-\:\.]/g, "").substring(0,10)+".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true
                });
            });

        </script>
    @endcan
@endpush

