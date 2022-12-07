@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Enlaces establecidos entre 2 entrevistas</h1>

    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="pull-right">
            <a class='btn btn-success btn-xs' href="#" id="b_tabla_macro"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>
        </div>
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('enlaces.table')
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script>
        // This must be a hyperlink
        $("#b_tabla_macro").on('click', function(event) {
            $("#enlaces-table").table2excel({
                name: "SIM",
                //filename: "sat_problemas_" + new Date().toISOString().replace(/[\-\:\.]/g, "").substring(0,8),
                filename: "listado_enlaces_" + new Date().toLocaleString("en-GB", {timeZone: "America/Bogota"}).replace(/[\-\:\.]/g, "").substring(0,10)+ ".xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        });

    </script>
@endpush

