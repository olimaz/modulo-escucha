{{--

Control para pedir fecha
Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_texto: Etiqueta a desplegar
$control_default: valor pre-seleccionado
$control_requerido: banderita para "required"
--}}

@php
    if(!isset($control_default)) {
        $control_default=null;
    }
    else {
        $control_default = substr($control_default,0,10); //Quitar hora u otros caracteres
    }

    $control_requerido = isset($control_requerido) ? $control_requerido : ' false  ';


$opciones['class']='form-control pull-right timepicker';
$opciones['data-value']=$control_default;
if($control_requerido) {
    $opciones['required']='required';
}


@endphp


<!-- Pedir fecha  -->
<div class="form-group">
    {!! Form::label($control_control, $control_texto) !!}
    {!! Form::text($control_control, $control_default,$opciones) !!}
</div>


@push("js")
    <script>
        var tmp =
        $('.timepicker').pickatime({
            format: 'h:i A'   //Como se muestra al usuario
            , formatSubmit: 'HH:i'  //IMPORTANTE: para el submit
            , interval : 5
        });
        var picker_{{ $control_control }} = tmp.pickatime('picker');
        @if( is_null($control_default))
        picker_{{ $control_control }}.clear();
        @endif
    </script>
@endpush
