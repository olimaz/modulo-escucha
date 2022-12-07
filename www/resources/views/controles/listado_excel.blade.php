{{--

    Control tipo dropdown para listados de códigos en excel
    Parametros:
    $control_control: nombre del control/variable  (name='xxx')
    $control_id: identificador del control (id='xx').  Si no se especifica, utiliza el valor de $control_control
    $control_texto: Etiqueta a desplegar
    $control_default: valor pre-seleccionado
    $control_vacio: Si se desea crear una opción con valor cero, en esta variable se coloca el texto a mostrar
    $control_resaltar: falso/verdadero.  si es verdadero muestra en otro color si tiene algo seleccionado (usado para los formularios de busqueda)
--}}

@php
        //Por si no lo definen
        $control_default = $control_default ?? -1;
        $control_vacio = $control_vacio ?? "No aplicar filtro";
        $control_requerido = $control_requerido ?? false;
        $control_otro = $control_otro ?? false;
        $control_resaltar = $control_resaltar ?? false;
        $control_id = $control_id ?? $control_control;





        //Resaltar el control con 'has-success'
        $elegido=false;
        if($control_resaltar) {
            if($control_default>0) {
                $elegido=true;
            }
        }
        $texto_resaltar = $elegido ? ' has-success  text-success' : '';



@endphp

<!-- Control SELECT  -->
<div class="form-group  {{ $errors->has($control_control) ? 'has-error' :'' }} {{ $texto_resaltar }}">



        <div class="col-xs-12">
            {!! Form::label($control_control, $control_texto,['class'=>$texto_resaltar, 'title'=>'La cifra entre parentesis inidica la cantidad de códigos válido en el listado','data-toggle'=>'tooltip']) !!}
        </div>

    <div class="row">
        <div class="col-sm-10">
            @php
                $opciones = ['class' => "form-control $texto_resaltar",'id'=>$control_id,'style'=>'width:100% !important'];
                $opciones['name']=$control_control;
                //$opciones['title']="La cifra entre parentesis inidica la cantidad de códigos válido en el listado";
                //$opciones['data-toggle']="tooltip";
                if($control_requerido) {
                    $opciones['required']="required";
                }
            @endphp

            {!! Form::select($control_control, \App\Models\excel_listados::arreglo_opciones($control_vacio), $control_default,$opciones) !!}

            {!! $errors->first($control_control,'<span class="help-block" style="color:red;">:message</span>') !!}
        </div>
        <div class="col-sm-2 text-center">
            <a href="{{ action('excel_listadosController@index') }}" class="btn btn-default btn-sm" title="Gestionar listados" data-toggle="tooltip"><i class="fa fa-file-excel-o fas fa-file-excel"></i></a>
        </div>
    </div>



</div>



@push('js')

    <script>
        var control ='#{!! $control_id !!}';
        $(control).select2({
            placeholder: 'Seleccione una opción'
        });

        {{-- Para cuando son varios los seleccionados --}}
        @if(is_numeric($control_default))
            $("#{{ $control_id }}").val({{ $control_default }});
            $("#{{ $control_id }}").trigger('change');
        @endif
    </script>
@endpush

