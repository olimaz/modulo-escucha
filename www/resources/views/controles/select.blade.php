{{--

Control tipo dropdown de un catalogo
Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_texto: Etiqueta a desplegar
$control_default: valor pre-seleccionado.  Puede ser un valor o un arreglo
$control_multiple: Si se acepta seleccionar más de una opcion  (true,false)
$control_requerido: falso/verdadero según se agrega "required" para html5
$control_arreglo: Arreglo con las opciones el arreglo

--}}

@php
        //Por si no lo definen
        $control_default = isset($control_default) ? $control_default : null;
        $control_multiple = isset($control_multiple) ? $control_multiple : false;
        $control_requerido = isset($control_requerido) ? $control_requerido : false;
        $control_arreglo = isset($control_arreglo) ? $control_arreglo : array();
@endphp

<!-- Catalogo  -->
<div class="form-group  {{ $errors->has($control_control) ? 'has-error' :'' }}">
    {!! Form::label($control_control, $control_texto) !!}
    @php
        $opciones = ['class' => 'form-control','id'=>$control_control,'style'=>'width:100%'];
        if($control_multiple) {
            $opciones['multiple']="multiple";
            $opciones['name']=$control_control."[]"; //agregarle los corchetes
        }
        else {
            $opciones['name']=$control_control;
        }
        if($control_requerido) {
            $opciones['required']="required";
        }
    @endphp

    {!! Form::select($control_control, $control_arreglo, $control_default,$opciones) !!}

    {!! $errors->first($control_control,'<span class="help-block" style="color:red;">:message</span>') !!}
</div>


@push('js')
    <script>
        var control ='#{!! $control_control !!}';

        @if($control_multiple)
            $(control).select2({
                placeholder: 'Seleccione las opciones que apliquen'
            });
        @else
            $(control).select2({
                placeholder: 'Seleccione una opción'
            });
        @endif

        {{-- Para cuando son varios los seleccionados --}}
        @if(is_array($control_default))
            $("#{{ $control_control }}").val({!!   json_encode($control_default) !!});
            $("#{{ $control_control }}").trigger('change');
        @elseif(is_numeric($control_default))
            $("#{{ $control_control }}").val({{ $control_default }});
            $("#{{ $control_control }}").trigger('change');
        @endif

    </script>
@endpush