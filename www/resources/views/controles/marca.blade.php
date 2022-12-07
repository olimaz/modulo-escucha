{{--

Control tipo dropdown para agregar marcas
Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_id: identificador del control (id='xx').  Si no se especifica, utiliza el valor de $control_control
$control_texto: Etiqueta a desplegar
$control_default: valor pre-seleccionado
$control_multiple: Si se acepta seleccionar más de una opcion  (true,false)
$control_requerido: falso/verdadero según se agrega "required" para html5
$control_resaltar: falso/verdadero.  si es verdadero muestra en otro color si tiene algo seleccionado (usado para los formularios de busqueda)


$control_mostrar_grupo=false.  Si verdadero, lista las del grupo, sino, las propias
--}}

@php
    $control_default = isset($control_default) ? $control_default : null;
    $control_vacio = isset($control_vacio) ? $control_vacio : null;
    $control_multiple = isset($control_multiple) ? $control_multiple : true;
    $control_requerido = isset($control_requerido) ? $control_requerido : false;
    $control_resaltar = isset($control_resaltar) ? $control_resaltar : true;
    $control_id = isset($control_id) ? $control_id : $control_control;
    $control_nuevos = isset($control_nuevos) ? $control_nuevos : true;
    $control_mostrar_grupo = isset($control_mostrar_grupo) ? $control_mostrar_grupo : false;
    if(!isset($control_placeholder)) {
        $control_placeholder = $control_multiple ? 'Escriba sus opciones separadas por coma' :  'Seleccione una opción';
    }






        //Resaltar el control con 'has-success'
        $texto_resaltar='';
        if($control_resaltar) {
            $elegido=false;
            if(is_array($control_default)) {
                    if(count($control_default) > 0) {
                        $elegido=true;
                    }
                }
            else {
                if($control_default>0) {
                    $elegido=true;
                }
            }
            $texto_resaltar = $elegido ? ' has-success ' : '';
        }

@endphp

<!-- Control SELECT  -->
<div class="form-group  {{ $errors->has($control_control) ? 'has-error' :'' }} {{ $texto_resaltar }}">
    @if(strlen($control_texto)>0)
        {!! Form::label($control_control, $control_texto) !!}
    @endif
    @php
        $opciones = ['class' => 'form-control','id'=>$control_id,'style'=>'width:100% !important'];
        if($control_multiple) {
            $opciones['multiple']="multiple";
            if(strpos($control_control,'[]') > 0) {
                //No pasa nada, ya tiene los corchetes
            }
            else {
                $opciones['name']=$control_control."[]"; //agregarle los corchetes
            }

        }
        else {
            $opciones['name']=$control_control;
        }
        if($control_requerido) {
            $opciones['required']="required";
        }
    @endphp
    @if($control_mostrar_grupo)
        {!! Form::select($control_control, \App\Models\marca_entrevista::listar_marcas_grupo(), $control_default,$opciones) !!}
    @else
        {!! Form::select($control_control, \App\Models\marca_entrevista::listar_marcas_entrevistador(), $control_default,$opciones) !!}
    @endif
    {!! $errors->first($control_control,'<span class="help-block" style="color:red;">:message</span>') !!}
</div>



@push('js')

    <script>
        var control ='#{!! $control_id !!}';

        @if($control_multiple)
            $(control).select2({
                placeholder: '{{ $control_placeholder }}',
                tags: {{ $control_nuevos ? 'true':'false' }},
                tokenSeparators: [',']
            });
        @else
            $(control).select2({
                placeholder: '{{ $control_placeholder }}',
                tags: true,
                tokenSeparators: [',', ' ']
            });
        @endif

        {{-- Para cuando son varios los seleccionados --}}
        @if(is_array($control_default))
            $("#{{ $control_id }}").val({!!   json_encode($control_default) !!});
            $("#{{ $control_id }}").trigger('change');
        @elseif(is_numeric($control_default))
            $("#{{ $control_id }}").val({{ $control_default }});
            $("#{{ $control_id }}").trigger('change');
        @endif

    </script>
@endpush

