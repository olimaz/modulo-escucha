{{--

Selector de dos niveles para codigos geograficos
    Parametros:
    $control_control: nombre del control/variable  (name='xxx')
    $control_texto: Etiqueta a desplegar
    $control_default: valor pre-seleccionado
    $control_vacio: Si se desea crear una opción con valor cero, en esta variable se coloca el texto a mostrar

    $control_resaltar: falso/verdadero.  si es verdadero muestra en otro color si tiene algo seleccionado (usado para los formularios de busqueda)

    //IMPORTANTE: el request del json es POST, por lo que es necesaria una excepción para el csrftoken
    // Mas info: https://stackoverflow.com/questions/46141705/the-page-has-expired-due-to-inactivity-laravel-5-5

--}}


<?php
    if(!isset($control_default)) {
        $control_default=null;
    };
    if(!isset($control_texto)) {
        $control_texto=null;
    };
    if(!isset($control_vacio)) {
        $control_vacio=null;
    };

    //Esta primera parte me sirve para el despliegue inicial
    $tmp_id_depto=-1;
    $tmp_id_muni=-1;


    if($control_default>0) {
        $tmp_info=\App\Models\geo::find($control_default);
        if(!empty($tmp_info)) {
            if($tmp_info->nivel==1) {
                $tmp_id_depto=$control_default;
                $tmp_id_muni=-1;

            }
            elseif($tmp_info->nivel==2) {
                $tmp_id_depto=$tmp_info->id_padre;
                $tmp_id_muni=$control_default;
            }
            else {  //Valor de nivel 3, inaceptable
                $tmp_id_depto=-1;
                $tmp_id_muni=-1;
            }
        }
    }

        //Resaltar el control con 'has-success'
        $control_resaltar = isset($control_resaltar) ? $control_resaltar : false;
        $texto_resaltar_n1='';
        $texto_resaltar_n2='';
        if($control_resaltar) {
            $texto_resaltar_n1 = $tmp_id_depto > 0 ? ' has-success ' : ' ';
            $texto_resaltar_n2 = $tmp_id_muni > 0 ? ' has-success ' : ' ';
        }
//dd("d: $tmp_id_depto, m:$tmp_id_muni, l:$tmp_id_lp");
?>

<div class="row">
    {{-- Desplegar los controles --}}

    <div class="col-xs-12">
        <label>{{ $control_texto }} </label>
    </div>

    <!-- Departamento -->
    <div class="form-group col-sm-6 {{ $texto_resaltar_n1 }}">
        {!! Form::label($control_control."_depto", "Departamento") !!}
        {!! Form::select($control_control."_depto", \App\Models\geo::listar_hijos(null,$control_vacio), $tmp_id_depto,['class' => 'form-control','style'=>'width:100% !important']) !!}
    </div>
    <!-- Municipio -->
    <div class="form-group col-sm-6 {{ $texto_resaltar_n2 }}">

        {!! Form::label($control_control, "Municipio") !!}
        {!! Form::select($control_control, \App\Models\geo::listar_hijos($tmp_id_depto,$control_vacio), $tmp_id_muni,['class' => 'form-control','style'=>'width:100% !important']) !!}
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
                url: '{{ url('json/geo_todo') }}',
                depends: ['{{ $control_control }}_depto'],
                initialize: {{ $tmp_id_depto==-1 ? "true" : "false" }},
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
                url: '{{ url('json/geo') }}',
                depends: ['{{ $control_control }}_depto'],
                initialize: {{ $tmp_id_depto==-1 ? "true" : "false" }},
                loadingText:'Cargando datos...',
                placeholder:false,
                emptyMsg:'Sin datos :-('
            });

        </script>
    @endif

    <script>
        var control ='#{!! $control_control !!}_depto';
        $(control).select2();
        var control ='#{!! $control_control !!}';
        $(control).select2();
    </script>

@endpush







