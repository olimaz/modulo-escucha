{{--

Control tipo radio
Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_id: para diferenciar el id, si necesito varios controles con el mismo nombre
$control_control_cual: nombre del control/variable de cual?
$control_texto: Etiqueta a desplegar
$control_default: valor pre-seleccionado
$control_default_cual: valor pre-seleccionado para cual?
$control_opciones: Arreglo con opciones a mostrar.  Si no se define, muestra Sí y No (1 y 2)
$control_tipo: 1 = input text, 2 = textarea
$control_rojo: mostrar alguna opcion en rojo

--}}
@php
        // Comportamiento por defecto: si,no
        if(!isset($control_opciones)) {
            $control_opciones=[1=>'Sí',2=>'No'];
            $control_default = isset($control_default) ? $control_default : 2;
        }
        $control_id = isset($control_id) ? $control_id : $control_control;
        $control_rojo = isset($control_rojo) ? $control_rojo : -1;
        $control_texto_cual=isset($control_texto_cual) ? $control_texto_cual : "¿Cuál?";
        $control_tipo = isset($control_tipo) ? $control_tipo : 1;
        $control_default_cual = isset($control_default_cual) ? $control_default_cual : null;
@endphp

<div class="clearfix"></div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group  ">
            <label> {!!   $control_texto !!}</label><br>


            @foreach($control_opciones as $id_item => $txt)
                <label class="radio-inline icheck">
                    <input class='opcion' type="radio" name="{{ $control_control }}" id="{{ $control_id."_".$id_item }}" value="{{ $id_item }}"  {{ $control_default == $id_item ? " checked " : "" }}>
                    {!! $txt !!}
                </label>
            @endforeach
        </div>

    </div>
    <div class="col-sm-8" id="{{ $control_id }}_div">
        <div class="form-group  ">
            <label>{{ $control_texto_cual}}</label>
            @if($control_tipo==1)
                <input type="text" name="{{ $control_control_cual }}" id="{{ $control_control_cual }}" value="{{ $control_default_cual }}" class="form-control" maxlength="100">
            @else
                <textarea name="{{ $control_control_cual }}" id="{{ $control_control_cual }}" class="form-control" rows="3">{{ $control_default_cual }}</textarea>
            @endif

        </div>
    </div>
</div>
<div class="clearfix"></div>


@push('js')
    <script>
        $(document).ready(function(){
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_square',
                radioClass: 'iradio_square-green',
                increaseArea: '20%' // optional
            });
        });

        $('.icheck').on('ifChanged', mostrar_cual_{{ $control_id }});

        function mostrar_cual_{{ $control_id }}() {
            var si = $('#{{ $control_id }}_1').iCheck('update')[0].checked;
            if(si) {
                $('#{{ $control_id }}_div').removeClass('hidden');
                $('#{{ $control_control_cual }}').prop('required',true);
            }
            else {
                $('#{{ $control_control }}_div').addClass('hidden');
                $('#{{ $control_control_cual }}').prop('required',false);
            }
            return si;
        };
        mostrar_cual_{{ $control_id }}();

    </script>

@endpush
