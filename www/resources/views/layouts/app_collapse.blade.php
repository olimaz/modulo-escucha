{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')




@push('js')
    <script>

        $(".dateRange").daterangepicker({
            showDropdowns: true,
            //autoUpdateInput: false,
            autoApply: true,
            minDate: new Date(1958,0,1),
            maxDate: new Date(),
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
        /*
        $(".dateRange").on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $(".dateRange").on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

         */
    </script>
@endpush

{{-- Para que los AJAX no den problemas, este script utiliza el header definido al principio --}}


@push('js')
    <script>
        $(function(){
            $.ajaxSetup({
                headers:{'X-CSRF-Token': '{{ csrf_token() }}'}
            });
        });
    </script>
@endpush