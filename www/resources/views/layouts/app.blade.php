{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')




@push('js')
    <script>
        //No acepta fechas a futuro
        $(".dateRange").daterangepicker({
            showDropdowns: true,
            //autoUpdateInput: false,
            autoApply: true,
            minDate: new Date(1958,0,1),
            linkedCalendars: false,
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

@push("js")
    <script>
        //Sí acepta fechas a futuro
        $(".dateRange2").daterangepicker({
            showDropdowns: true,
            //autoUpdateInput: false,
            autoApply: true,
            //minDate: new Date(),
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


@push('js')
    @if(config('app.env')=='production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-155138230-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-155138230-1',  {
                cookie_flags: 'max-age=7200;secure;samesite=none'
            });
        </script>
    @endif
@endpush