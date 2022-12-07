@php
//Muestra la traza, recibe por parametro el código de la entrevista/caso
$codigo = isset($control_codigo) ? $control_codigo : "YYZ";
$trazaActividads = \App\Models\traza_actividad::codigo($codigo)->orderby('fecha_hora')->paginate(50);

@endphp
<div class="box box-default box-solid collapsed-box">
    <div class="box-header">
        <h3 class="box-title">
            Registro de actividad
        </h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
        <a class='btn btn-info btn-xs pull-right' href="#" id="b_traza_excel"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>

    </div>
    <div class="box-body table-responsive">

        @include('traza_actividads.table')
    </div>
    <div class="box-footer text-center">
        <div class="no-print">
            {!! $trazaActividads->appends(Request::all())->render() !!}
        </div>
    </div>

</div>
<div class="clearfix"></div>



@push('js')
    <script>
        // This must be a hyperlink
        $("#b_traza_excel").on('click', function(event) {
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