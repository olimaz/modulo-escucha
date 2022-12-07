{{--

Control tipo radio
Parametros:
$control_control: nombre del control/variable  (name='xxx')
$control_texto: Etiqueta a desplegar
$control_div: el id del DIV que queremos mostrar/ocultar
$control_default: valor pre-seleccionado
$control_opciones: Arreglo con opciones a mostrar.  Si no se define, muestra Sí y No (1 y 2)

$control_inverso:  default false.  Si es true, el div se muestra cuando eligen NO (Para opciones tipo, ¿porqué no?

--}}
@php
        // Comportamiento por defecto: si,no
        if(!isset($control_opciones)) {
            $control_opciones=[1=>'Sí',2=>'No'];
            $control_default = isset($control_default) ? $control_default : 2;
        }
        $control_control_cual = isset($control_control_cual) ? $control_control_cual : -1;
        $control_rojo = isset($control_rojo) ? $control_rojo : -1;
        $control_texto_cual=isset($control_texto_cual) ? $control_texto_cual : "¿Cuál?";
        $control_div = isset($control_div) ? $control_div : -1;

        $control_inverso = isset($control_inverso) ? $control_inverso : false;

@endphp


<div class="form-group ">
    <p class="text-bold"> {!!   $control_texto !!}</p>
        @foreach($control_opciones as $id_item => $txt)
            <label class="radio-inline icheck icheck_{{ $control_control }}">
                <input class='opcion' type="radio" name="{{ $control_control }}" id="{{ $control_control."_".$id_item }}" value="{{ $id_item }}"  {{ $control_default == $id_item ? " checked " : "" }}>
                {!! $txt !!}
            </label>
        @endforeach
</div>

@push('js')
    <script>
        $(document).ready(function(){
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_square',
                radioClass: 'iradio_square-green',
                increaseArea: '20%' // optional
            });
        });

        $('.icheck').on('ifChanged', mostrar_cual_{{ $control_control }});

        @if($control_inverso)
        function mostrar_cual_{{ $control_control }}() {
            var si = $('#{{ $control_control }}_1').iCheck('update')[0].checked;
            if(si) {
                $('#{{ $control_div }}').addClass('hidden');
            }
            else {
                $('#{{ $control_div }}').removeClass('hidden');
            }
            return si;
        };
        @else

            function mostrar_cual_{{ $control_control }}() {
                var si = $('#{{ $control_control }}_1').iCheck('update')[0].checked;
                if(si) {
                    $('#{{ $control_div }}').removeClass('hidden');
                    // $('#{{ $control_control_cual }}').prop('required',true);
                }
                else {
                    $('#{{ $control_div }}').addClass('hidden');
                    // $('#{{ $control_control_cual }}').prop('required',false);
                }
                return si;
            };
        @endif

        mostrar_cual_{{ $control_control }}();

    </script>

@endpush
