{{--

Control tipo radio
Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_id: identificador del control (id='xx').  Si no se especifica, utiliza el valor de $control_control
$control_texto: Etiqueta a desplegar
$control_default: valor pre-seleccionado
$control_opciones: Arreglo con opciones a mostrar.  Si no se define, muestra Sí y No (1 y 2)

$control_rojo: mostrar alguna opcion en rojo

--}}
@php
        // Comportamiento por defecto: si,no

        if(!isset($control_opciones)) {
            $control_opciones=[1=>'Sí',2=>'No'];
            $control_default = isset($control_default) ? $control_default : 2;
        }

        $control_rojo = isset($control_rojo) ? $control_rojo : -1;

        //Cambiar manualmente el ID
        $control_id = isset($control_id) ? $control_id : $control_control;


@endphp
@if($control_texto!=-1)
<div class="form-group  ">
    <p class="text-bold">{!!   $control_texto !!} </p>
@endif
    @foreach($control_opciones as $id_item => $txt)

        <label class="radio-inline icheck">
            <input type="radio" name="{{ $control_control }}" id="{{ $control_id."_".$id_item }}" value="{{ $id_item }}"  {{ $control_default == $id_item ? " checked " : "" }}>
            {!! $txt !!}
        </label>
        @if($control_texto==-1)
            <br>
        @endif

    @endforeach
        @if($control_texto!=-1)
    </div>
@endif

@push('js')
    <script>
        $(document).ready(function(){
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%' // optional
            });
        });
    </script>

@endpush
