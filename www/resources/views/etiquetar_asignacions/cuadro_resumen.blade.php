@extends('layouts.app')

@section('content_header')
    @include("etiquetar_asignacions.frm_filtros")
@endsection
@section('content')
        <h1 class="pull-left">Asignación de etiquetado <small>Cuadro de resumen</small></h1>
        {{--
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('transcribirAsignacions.create') !!}">Nueva Asignación</a>
        </h1>
        --}}
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">

            <div class="box-body">
                <a class='btn btn-info btn-xs pull-right' href="#" id="d_cuadro_resumen"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>
                <table class="table table-condensed table-striped" id="t_cuadro_resumen">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Transcriptor</th>
                            @foreach($datos->a_estado as $id_estado=>$estado)
                                <th class="text-center">{!! $estado !!}</th>
                            @endforeach
                            <th class="text-center">Total</th>
                            <th class="text-center">Tiempo utilizado para etiquetar <br>(horas:minutos)</th>
                            <th class="text-center">Tiempo promedio  por entrevista</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php($i=1)
                        @foreach($datos->a_transcriptores as $id_transcriptor=>$transcriptor)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{!! $transcriptor !!}</td>
                                @foreach($datos->a_estado as $id_estado=>$estado)
                                    <td class="text-center">{!! $datos->a_datos[$id_transcriptor][$id_estado] !!}</td>
                                @endforeach
                                <th class="text-center">
                                    {{ $datos->a_total_trans[$id_transcriptor] }}
                                </th>
                                <td class="text-center">
                                    {{ $datos->a_minutos_horas[$id_transcriptor] }}
                                </td>
                                <td class="text-center">
                                    {{ $datos->a_promedio_horas[$id_transcriptor] }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-center">Total</th>
                            @foreach($datos->a_estado as $id_estado=>$estado)
                                <th class="text-center">{!! $datos->a_total_estado[$id_estado] !!}</th>
                            @endforeach
                            <th class="text-center">
                                {{ $datos->total }}
                            </th>
                            <th class="text-center">
                                {{ $datos->total_minutos_horas }}
                            </th>
                            <th class="text-center">
                                {{ $datos->total_promedio_horas }}
                            </th>


                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
        <div class="text-center">
        
        </div>

@endsection


@push('js')
    <script>
        // This must be a hyperlink
        $("#d_cuadro_resumen").on('click', function(event) {
            $("#t_cuadro_resumen").table2excel({
                name: "Cuadro Resumen",
                //filename: "sat_problemas_" + new Date().toISOString().replace(/[\-\:\.]/g, "").substring(0,8),
                filename: "asignaciones_resumen" + new Date().toLocaleString("en-GB", {timeZone: "America/Guatemala"}).replace(/[\-\:\.]/g, "").substring(0,10)+ ".xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        });

    </script>
@endpush

