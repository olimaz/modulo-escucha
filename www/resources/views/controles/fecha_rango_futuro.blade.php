{{--

Control para pedir fecha
Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_texto: Etiqueta a desplegar
$control_default: valor pre-seleccionado
$control_requerido: mete "required" para el html5

--}}

@php
    if(!isset($control_default)) {
        $control_default="";
    }
    $control_requerido = isset($control_requerido) ? $control_requerido : false;


@endphp


<!-- Pedir fecha  -->
<div class="form-group">
    {!! Form::label($control_control, $control_texto) !!}
    @if($control_requerido)
        {!! Form::text($control_control, $control_default, ['class' => 'form-control dateRange2','required'=>'required']) !!}
    @else
        {!! Form::text($control_control, $control_default, ['class' => 'form-control dateRange2']) !!}
    @endif
</div>


