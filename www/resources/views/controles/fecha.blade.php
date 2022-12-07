{{--

Control para pedir fecha
Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_texto: Etiqueta a desplegar
$control_default: valor pre-seleccionado
$control_min: fecha minima que acepta
$control_max: fecha maxima que acepta
$control_resaltar: falso/verdadero.  si es verdadero muestra en otro color si tiene algo seleccionado (usado para los formularios de busqueda)
$control_requerido: banderita para "required"
--}}

@php
    if(!isset($control_default)) {
        $control_default=null;
    }
    else {
        $control_default = substr($control_default,0,10); //Quitar hora u otros caracteres
    }
    $control_min = isset($control_min) ? $control_min : ' new Date(1900,0,1) ';
    $control_max = isset($control_max) ? $control_max : ' true  ';
    $control_requerido = isset($control_requerido) ? $control_requerido : ' false  ';


$opciones['class']='form-control pull-right datepicker';
$opciones['data-value']=$control_default;
if($control_requerido) {
    $opciones['required']='required';
}


    //Resaltar el control con 'has-success'
    $control_resaltar = isset($control_resaltar) ? $control_resaltar : false;
    $texto_resaltar='';
    if($control_resaltar) {
        if($control_default) {
             $texto_resaltar=' has-success ';
        }
    }

@endphp


<!-- Pedir fecha  -->
<div class="form-group {{ $texto_resaltar }}">
    {!! Form::label($control_control, $control_texto) !!}
    <div class="input-group date">
        {{--
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        --}}
    </div>
    {!! Form::text($control_control, '', $opciones) !!}
</div>


@push("js")
    <script>
        var tmp_{{ $control_control }} =
        $('.datepicker').pickadate({
            selectMonths: true // Creates a dropdown to control month
            , selectYears: 75 // Creates a dropdown of 15 years to control year
            //The format to show on the `input` element
            , format: 'dd-mmmm-yyyy'   //Como se muestra al usuario
            , formatSubmit: 'yyyy-mm-dd',  //IMPORTANTE: para el submit
            //The title label to use for the month nav buttons
            labelMonthNext: 'Mes siguiente',
            labelMonthPrev: 'Mes anterior',
            //The title label to use for the dropdown selectors
            labelMonthSelect: 'Elegir mes',
            labelYearSelect: 'Elegir año',
            //Months and weekdays
            monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            //Materialize modified
            weekdaysLetter: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            //Today and clear
            today: 'Hoy',
            clear: 'Limpiar',
            close: 'Cerrar',
            //Limites
            min: {{ $control_min }},
            max: {{ $control_max }}
        });

        var picker_{{ $control_control }} = tmp_{{ $control_control }}.pickadate('picker');



    </script>
@endpush
