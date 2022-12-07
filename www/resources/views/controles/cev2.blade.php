{{--

Selector de dos niveles para codigos geograficos, tabla cev
    Parametros:
    $control_control: nombre del control/variable  (name='xxx')
    $control_texto: Etiqueta a desplegar
    $control_territorio: valor pre-seleccionado en el segundo nivel de territorio
    $control_macroterritorio: valor pre-seleccionado en el primer nivel de territorio
    $control_vacio: Si se desea crear una opción con valor cero, en esta variable se coloca el texto a mostrar
    $control_resaltar: falso/verdadero.  si es verdadero muestra en otro color si tiene algo seleccionado (usado para los formularios de busqueda)

    //IMPORTANTE: el request del json es POST, por lo que es necesaria una excepción para el csrftoken
    // Mas info: https://stackoverflow.com/questions/46141705/the-page-has-expired-due-to-inactivity-laravel-5-5

--}}


<?php
        if(!isset($control_territorio)) {
            $control_territorio=null;
        };
        if(!isset($control_macroterritorio)) {
            $control_macroterritorio=null;
        };

        $control_select2 = isset($control_select2) ? $control_select2 : false;
        $control_texto = isset($control_texto) ? $control_texto : null;
        $control_vacio = isset($control_vacio) ? $control_vacio : null;


        //Esta primera parte me sirve para el despliegue inicial
        $tmp_id_depto=-1;
        $tmp_id_muni=-1;

        //Determinar el macro, si solo tengo el territorio
        if($control_territorio > 0 && $control_macroterritorio < 1) {
            $tmp_info=\App\Models\cev::find($control_territorio);
            if($tmp_info) {
                $control_macroterritorio=$tmp_info->id_padre;
            }
            else {
                $control_territorio=null;  //Porque no existe
            }
        }

        //Resaltar el control con 'has-success'
        $control_resaltar = isset($control_resaltar) ? $control_resaltar : false;
        $texto_resaltar_n1='';
        $texto_resaltar_n2='';
        if($control_resaltar) {
            $texto_resaltar_n1 = $control_macroterritorio > 0 ? ' has-success text-success' : ' ';
            $texto_resaltar_n2 = $control_territorio > 0 ? ' has-success text-success' : ' ';
        }

?>

<div class="row">
{{-- Desplegar los controles --}}
    @if(strlen($control_texto)>0)
        <div class="col-xs-12">
            <label>{{ $control_texto }}</label>
        </div>
    @endif

    <!-- Macroterritorio -->
    <div class="form-group col-sm-6 {{ $texto_resaltar_n1 }}">
        {!! Form::label($control_control."_macro", "Macroterritorio", ['class'=>$texto_resaltar_n1]) !!}
        {!! Form::select($control_control."_macro", \App\Models\cev::listar_hijos(null,$control_vacio), $control_macroterritorio,['class' => 'form-control']) !!}
    </div>
    <!-- Territorial -->
    <div class="form-group col-sm-6 {{ $texto_resaltar_n2 }}">
        {!! Form::label($control_control, "Territorial", ['class'=>$texto_resaltar_n1]) !!}
        {!! Form::select($control_control, \App\Models\cev::listar_hijos($control_macroterritorio,$control_vacio), $control_territorio,['class' => 'form-control']) !!}
    </div>


</div>




{{--
 Si tienen valor predeterminado, se cargan con dichos valores
 De lo contrario, initialize=true para que cargue los valores iniciales
--}}

@push('js')
    @if(strlen($control_vacio)>0)
        <script>
            // Controles dependientes
            //Municipio
            $("#{{ $control_control }}").depdrop({
                url: '{{ url('json/geo_todo_cev') }}',
                depends: ['{{ $control_control }}_macro'],
                //initialize: {{ $tmp_id_depto==-1 ? "true" : "false" }},
                loadingText:'Cargando datos...',
                placeholder:false,
                emptyMsg:'Sin datos :-('
            });


        </script>
    @else
        <script>
            // Controles dependientes
            //Municipio
            $("#{{ $control_control }}").depdrop({
                url: '{{ url('json/geo_cev') }}',
                depends: ['{{ $control_control }}_macro'],
                initialize: {{ $tmp_id_depto==-1 ? "true" : "false" }},
                loadingText:'Cargando datos...',
                placeholder:false,
                emptyMsg:'Sin datos :-('
            });
        </script>
    @endif

    <script>
        var control ='#{!! $control_control !!}_macro';
        @if($control_select2)
            $(control).select2();
        @endif
        var control ='#{!! $control_control !!}';
        @if($control_select2)
            $(control).select2();
        @endif
    </script>

@endpush







