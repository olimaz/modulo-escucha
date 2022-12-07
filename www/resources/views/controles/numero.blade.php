{{--

Control tipo numerico.  Se sobresalta cuando es usado con el parametro $control_resaltar

Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_id: identificador del control (id='xx').  Si no se especifica, utiliza el valor de $control_control
$control_texto: Etiqueta a desplegar
$control_default: valor pre definido
$control_requerido: falso/verdadero según se agrega "required" para html5
$control_resaltar: resaltar cuando tiene un valor
$control_min: valor minimo a aceptar, default 0
$control_max: valor maximo a aceptar, default 100
$control_step: saltos del control, default 1 (enteros)

--}}

@php
    //Por si no lo definen
    $control_default = isset($control_default) ? $control_default : "";
    $control_resaltar = isset($control_resaltar) ? $control_resaltar : true;
    $control_requerido = isset($control_requerido) ? $control_requerido : false;
    $control_min = isset($control_min) ? $control_min : 0;
    $control_max = isset($control_max) ? $control_max : 100;
    $control_step = isset($control_step) ? $control_step : 1;
    $clase_resaltar="";
    //Logica interna
    $control_id = isset($control_id) ? $control_id : $control_control;
    $control_default=trim($control_default);
    //Resaltar si tiene algun valor.  Usado en formularios de filtros
    if($control_resaltar) {
        $clase_resaltar = $control_default=="" ? "" :' has-success text-success' ;
    }
    // Opciones para el Html5
    $input_opciones =  ['class' => "form-control  ",'id'=>$control_id,'name'=>$control_control,'autocomplete'=>'off'];
    if($control_requerido) {
        $input_opciones['required'] = 'required';
    }
    $input_opciones['min'] = $control_min;
    $input_opciones['max'] = $control_max;
    $input_opciones['step'] = $control_step;

@endphp

<div class="form-group {{ $clase_resaltar }}">
    {!! Form::label($control_control, $control_texto, ['class'=>$clase_resaltar]) !!}
    {!! Form::number($control_control, $control_default, $input_opciones) !!}
</div>
