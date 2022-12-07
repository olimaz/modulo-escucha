{{--

Control tipo texto que autocompleta de un json obtenido por ajax.  El json debe ser GET y para filtar el criterio debe ser texto (?texto=abcd)

Parametros:
$control_url: url (sin path) de donde se obtienen los datos
$control_control: nombre del control/variable  (name='xxx')
$control_id: identificador del control (id='xx').  Si no se especifica, utiliza el valor de $control_control
$control_texto: Etiqueta a desplegar
$control_default: valor pre-seleccionado
$control_requerido: falso/verdadero según se agrega "required" para html5
$control_max: maxlenght del control

--}}

@php
    //Por si no lo definen
    if(!isset($control_default)) {
        $control_default="";
    }
    $control_resaltar = isset($control_resaltar) ? $control_resaltar : true;
    $control_default=trim($control_default);
    $clase_resaltar = empty($control_default) ? "" :' has-success text-success ' ;
    if(!$control_resaltar) {
        $clase_resaltar="";
    }


    if(!isset($control_requerido)) {
        $control_requerido=false;
    }

    $control_id = isset($control_id) ? $control_id : $control_control;
    $url = url($control_url);
    $input_opciones =  ['class' => "form-control ",'id'=>$control_id,'name'=>$control_control,'autocomplete'=>'off'];
    if($control_requerido) {
        $input_opciones['required'] = 'required';
    }
    if(isset($control_max)) {
        $input_opciones['maxlength'] = $control_max;
    }
    if(isset($control_placeholder)) {
        $input_opciones['placeholder'] = $control_placeholder;
    }

@endphp

<div class="form-group {{ $clase_resaltar }}">
    {!! Form::label($control_control, $control_texto, ['class'=>$clase_resaltar]) !!}
    {!! Form::text($control_control, $control_default, $input_opciones) !!}
</div>


@push("js")
    <script>
        $(document).ready(function () {
            var route = "{{ $url }}";
            $('#{{ $control_id }}').typeahead({
                minLength : 4 ,
                autoSelect : false,
                source:  function (term, process) {
                    return $.get(route, { texto: term }, function (data) {
                        return process(data);
                    });
                }
            });
        });
    </script>
@endpush