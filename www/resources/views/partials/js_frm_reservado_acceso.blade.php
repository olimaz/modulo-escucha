
@include("controles.js_carga_archivo")
{{-- Este dateRange2, usa hoy como fecha mínima --}}
@push("js")
    <script>
        $(".dateRange2").daterangepicker({
            showDropdowns: true,
            //autoUpdateInput: false,
            autoApply: true,
            minDate: new Date(),
            linkedCalendars: false,
            //maxDate: new Date(),
            "locale": {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "Seleccionar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "weekLabel": "S",

                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            }
        });
    </script>

@endpush


@push('js')
    <script>
        $('#frm_acceso').submit(function() {
            return true;


            // Ya no se valida
            var pendientes = false;
            if($("#archivo_20_filename").val().length < 1) {
                pendientes = true;
            }
            if(pendientes) {
                alert("No cargó el archivo.  Antes de autorizar el acceso debe adjuntar el archivo de soporte");
                return false;
            }
            else {
                return true;
            }
        });
    </script>
@endpush
