@extends('layouts.app')

@section('content_header')
    @include("traza_actividads.frm_filtro")
@endsection

@section('content')


        <h1 class="pull-left">
            Traza de actividad del usuario
            <small>{{ $trazaActividads->total() }} en total</small>
        </h1>



        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-primary">
            <div class="box-header">
                <a class='btn btn-info btn-xs pull-right' href="#" id="b_tabla_datos"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>
            </div>
            <div class="box-body table-responsive">

                    @include('traza_actividads.table')
            </div>
        </div>
        <div class="text-center">
            <div class="no-print">
                {!! $trazaActividads->appends(Request::all())->render() !!}
            </div>
        </div>

@endsection


@push('js')
    <script>
        // This must be a hyperlink
        $("#b_tabla_datos").on('click', function(event) {
            $("#trazaActividads-table").table2excel({
                name: "traza",
                //filename: "sat_problemas_" + new Date().toISOString().replace(/[\-\:\.]/g, "").substring(0,8),
                filename: "traza_actividad_" + new Date().toLocaleString("en-GB", {timeZone: "America/Bogota"}).replace(/[\-\:\.]/g, "").substring(0,10)+".xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        });

    </script>
@endpush

