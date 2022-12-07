{{--

Control tipo dropdown igual a criterio fijo.  Muestra los privilegios menores o iguales al usuario logeado
Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_texto: Etiqueta a desplegar

$control_default: valor pre-seleccionado
$control_requerido: falso/verdadero según se agrega "required" para html5

--}}

@php
    //Hard code por si las moscas
    $control_grupo=4;
    $control_vacio=null;
    $control_multiple=false;
        //Por si no lo definen
        if(!isset($control_default)) {
            $control_default=null;
        }
        if(!isset($control_requerido)) {
            $control_requerido=false;
        }
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

    {!! Form::select($control_control, \App\Models\criterio_fijo::listado_privilegios_validos(), $control_default,$opciones) !!}

    {!! $errors->first($control_control,'<span class="help-block" style="color:red;">:message</span>') !!}
</div>


@push('js')
    <script>
        var control ='#{!! $control_control !!}';

        $(control).select2({
            placeholder: 'Seleccione una opción'

        });

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