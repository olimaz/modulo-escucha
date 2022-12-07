{{--

Control tipo dropdown de un criterio fijo
Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_id: id del control  (id='xxx').  Si no se especifica, usa el mismo que control_control
$control_texto: Etiqueta a desplegar
$control_listado: Arreglo de opciones
$control_default: valor pre-seleccionado
$control_multiple: Si se acepta seleccionar más de una opcion  (true,false)
$control_requerido: falso/verdadero según se agrega "required" para html5
$control_resaltar: falso/verdadero.  si es verdadero muestra en otro color si tiene algo seleccionado (usado para los formularios de busqueda)
$control_onchange: para modificar el evento, por si fuera necesario

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
        $control_nulo = isset($control_nulo) ? $control_nulo : '';

        $control_onchange = $control_onchange ?? false;

        $control_resaltar = isset($control_resaltar) ? $control_resaltar : false;
        $control_id = isset($control_id) ? $control_id : $control_control;

        //Resaltar el control con 'has-success'
        $texto_resaltar='';
        if($control_resaltar) {
            if($control_default>0) {
                 $texto_resaltar=' has-success text-success ';
            }
        }




@endphp

<!-- Catalogo  -->
<div class="form-group  {{ $errors->has($control_control) ? 'has-error' :'' }} {{ $texto_resaltar }}">
    <label for="{{$control_control}}" class="{{ $texto_resaltar }}">{!! $control_texto !!}</label>

    @php
        $opciones = ['class' => 'form-control','id'=>$control_id,'style'=>'width:100%'];
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

    {!! Form::select($control_control, $control_listado, $control_default,$opciones) !!}

    {!! $errors->first($control_control,'<span class="help-block" style="color:red;">:message</span>') !!}
</div>


@push('js')
    <script>
        var control ='#{!! $control_id !!}';

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
            $(control).val({!!   json_encode($control_default) !!});
            $(control).trigger('change');
        @elseif(is_numeric($control_default))
            $(control).val({{ $control_default }});
            $(control).trigger('change');
        @endif

        @if($control_onchange)
            $(control).on('select2:select', function (e) {
                this.form.submit();
            });
        @endif

    </script>
@endpush