@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            {{ $excelListados->descripcion }} <small>Listado de códigos cargados mediante archivo de excel</small>
        </h1>
        <a class='btn btn-default  pull-right' href="{{ action('excel_listadosController@index') }}"><i class="fa fa-table" aria-hidden="true"></i> Volver al listado</a>

    </section>
    <div class="clearfix"></div>
    @include('flash::message')

    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('excel_listados.show_fields')

                </div>
            </div>
        </div>
        {{--  Detalle --}}
        <div class="box box-info box-solid">
            <div class="box-header">
                <h3 class="box-title">Códigos listados en el excel</h3>
                <a class='btn btn-success btn-xs pull-right' href="#" id="b_tabla-codigos"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-condensed table-bordered" id="tabla-codigos">
                    <thead>
                        <th>#</th>
                        <th>Código</th>
                        <th>Situación</th>
                        <th>Fichas diligenciadas</th>
                    </thead>

                    <tbody>
                        @php($i=1)
                        @foreach($excelListados->rel_codigos()->where('valido','>',0)->get() as $fila)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $fila->codigo }}</td>
                                <td>{{ $fila->fmt_valido }}</td>
                                <td>{{ $fila->estado_fichas }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // This must be a hyperlink
        $("#b_tabla-codigos").on('click', function(event) {
            $("#tabla-codigos").table2excel({
                name: "Listado Codigos",
                //filename: "sat_problemas_" + new Date().toISOString().replace(/[\-\:\.]/g, "").substring(0,8),
                filename: "listado_codigos_" + new Date().toLocaleString("en-GB", {timeZone: "America/Bogota"}).replace(/[\-\:\.]/g, "").substring(0,10)+ ".xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        });

    </script>
@endpush