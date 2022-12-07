{{--

Control tipo dropdown para entrevistadores
Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_texto: Etiqueta a desplegar
$control_default: valor pre-seleccionado
$control_vacio: Si se desea crear una opción con valor cero, en esta variable se coloca el texto a mostrar
$control_multiple: Si se acepta seleccionar más de una opcion  (true,false)
$control_requerido: falso/verdadero según se agrega "required" para html5

--}}

@php
        //Por si no lo definen
        if(!isset($control_default)) {
            $control_default=null;
        }
        if(!isset($control_vacio)) {
            $control_vacio=null;
        }
        if(!isset($control_multiple)) {
            $control_multiple=false;
        }
        if(!isset($control_requerido)) {
            $control_requerido=false;
        }

@endphp

<!-- Catalogo  -->
<div class="form-group  {{ $errors->has($control_control) ? 'has-error' :'' }}">
    {!! Form::label($control_control, $control_texto) !!}
    @php
        $opciones = ['class' => 'form-control','id'=>$control_control,'name'=>$control_control,'style'=>'width:100%'];
        if($control_multiple) {
            $opciones['multiple']="multiple";
        }
        if($control_requerido) {
            $opciones['required']="required";
        }
    @endphp

    {!! Form::select($control_control, \App\User::listado_items($control_vacio), $control_default,$opciones) !!}

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