{{--

Control tipo dropdown para entrevistadores
Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_texto: Etiqueta a desplegar
$control_default: valor pre-seleccionado
$control_vacio: Si se desea crear una opción con valor cero, en esta variable se coloca el texto a mostrar
$control_multiple: Si se acepta seleccionar más de una opcion  (true,false)
$control_requerido: falso/verdadero según se agrega "required" para html5
$control_mi_mismo: falso/verdadero.    En falso no incluye al usuario logeado.
$control_resaltar: falso/verdadero.  si es verdadero muestra en otro color si tiene algo seleccionado (usado para los formularios de busqueda)
$control_deshabilitados: falso/verdadero.  En verdadero, muestra los que tienen nivel=99
--}}

@php

        $control_id = isset($control_id) ? $control_id : $control_control;
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
        $control_mi_mismo = isset($control_mi_mismo) ? $control_mi_mismo : true;


        //$control_confidenciales = \Gate::allows('nivel-6') ? true : false;
        $control_confidenciales = true; //No hay razon para ocultarlos
        $control_deshabilitados = isset($control_deshabilitados) ? $control_deshabilitados : false ;

        //Resaltar el control con 'has-success'
        $control_resaltar = isset($control_resaltar) ? $control_resaltar : false;
        $texto_resaltar='';
        if($control_resaltar) {
            if($control_default>0) {
                 $texto_resaltar=' has-success ';
            }
        }





@endphp

<!-- Catalogo  -->
<div class="form-group  {{ $errors->has($control_control) ? 'has-error' :'' }} {{ $texto_resaltar }}">
    {!! Form::label($control_control, $control_texto) !!}
    @php
        $opciones = ['class' => 'form-control','id'=>$control_id,'name'=>$control_control,'style'=>'width:100%'];
        if($control_multiple) {
            $opciones['multiple']="multiple";
        }
        if($control_requerido) {
            $opciones['required']="required";
        }
    @endphp

    {!! Form::select($control_control, \App\Models\entrevistador::listado_todos($control_vacio,$control_mi_mismo,false,$control_confidenciales,$control_confidenciales), $control_default,$opciones) !!}

    {!! $errors->first($control_control,'<span class="help-block" style="color:red;">:message</span>') !!}
</div>


@push('js')
    <script>
        var control ='#{!! $control_id !!}';

        $(control).select2({
            placeholder: 'Seleccione una opción'
        });

        {{-- Para cuando son varios los seleccionados --}}
        @if(is_array($control_default))
            $("#{{ $control_id}}").val({!!   json_encode($control_default) !!});
            $("#{{ $control_id }}").trigger('change');
        @elseif(is_numeric($control_default))
            $("#{{ $control_id }}").val({{ $control_default }});
            $("#{{ $control_id }}").trigger('change');
        @endif

    </script>
@endpush