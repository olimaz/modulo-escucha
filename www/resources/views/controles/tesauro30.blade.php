{{--

Selector de tres niveles para codigos geograficos
    Parametros:
    $control_control: nombre del control/variable  (name='xxx')
    $control_texto: Etiqueta a desplegar
    $control_default: valor pre-seleccionado
    $control_vacio: Si se desea crear una opción con valor cero, en esta variable se coloca el texto a mostrar

    $control_resaltar: falso/verdadero.  si es verdadero muestra en otro color si tiene algo seleccionado (usado para los formularios de busqueda)

    //IMPORTANTE: el request del json es POST, por lo que es necesaria una excepción para el csrftoken
    // Mas info: https://stackoverflow.com/questions/46141705/the-page-has-expired-due-to-inactivity-laravel-5-5

--}}


{{-- DEFAULTS --}}
<?php
//Para la programación de agregar otro
$control_id = isset($control_control) ? $control_control : "tes3";
$control_otro = isset($control_otro) ? $control_otro : false; //Agregar otro a internacional

$control_select_2 = isset($control_select_2) ? $control_select_2 : true;

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
$tmp_id_lp=-1;

if($control_default>0) {
    $tmp_info=\App\Models\tesauro::find($control_default);
    if(!empty($tmp_info)) {
        if($tmp_info->nivel==1) {
            $tmp_id_depto=$control_default;
            $tmp_id_muni=-1;
            $tmp_id_lp=-1;
        }
        elseif($tmp_info->nivel==2) {
            $tmp_id_depto=$tmp_info->id_padre;
            $tmp_id_muni=$control_default;
            $tmp_id_lp=-1;

        }
        else {
            $tmp_id_lp=$control_default;
            $tmp_id_muni=$tmp_info->id_padre;
            $muni=\App\Models\tesauro::find($tmp_info->id_padre);
            if(!empty($muni)) {
                $tmp_id_depto=$muni->id_padre;
            }
            else { //No hay abuelo, todos a cero
                $tmp_id_depto=-1;
                $tmp_id_muni=-1;
                $tmp_id_lp=-1;
            }
        }
    }
}
else {
    $l1 = \App\Models\tesauro::listar_hijos(null,$control_vacio);
    $tmp_id_depto = array_key_first($l1);

    $l2 = \App\Models\tesauro::listar_hijos($tmp_id_depto,$control_vacio);
    $tmp_id_muni = array_key_first($l2);
    //dd($tmp_id_muni);

    $l3 = \App\Models\tesauro::listar_hijos($tmp_id_muni,$control_vacio);
    $tmp_id_lp = array_key_first($l3);
}
//dd("d: $tmp_id_depto, m:$tmp_id_muni, l:$tmp_id_lp");
//Resaltar el control con 'has-success'
$control_resaltar = isset($control_resaltar) ? $control_resaltar : false;
$texto_resaltar_n1='';
$texto_resaltar_n2='';
$texto_resaltar_n3='';
if($control_resaltar) {
    $texto_resaltar_n1 = $tmp_id_depto > 0 ? ' has-success ' : ' ';
    $texto_resaltar_n2 = $tmp_id_muni > 0 ? ' has-success ' : ' ';
    $texto_resaltar_n3 = $tmp_id_lp > 0 ? ' has-success ' : ' ';
}
?>

{{-- HTML de los select --}}
<div class="row">
    {{-- Desplegar los controles --}}
    <div class="col-xs-12">
        <label>{{ $control_texto }}</label>
    </div>

</div>
<div class="row">
    <!-- Departamento -->
    <div class="col-sm-4">
        <div class="form-group {{ $texto_resaltar_n1 }}">
            {!! Form::label($control_control."_depto", "Grupo") !!}<br>
            {!! Form::select($control_control."_depto", \App\Models\tesauro::listar_hijos(null,$control_vacio), $tmp_id_depto,['class' => 'form-control','style'=>'width:100% !important']) !!}
        </div>

    </div>
    <!-- Municipio -->
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label($control_control."_muni", "Categoría",['id'=>$control_control."_label_muni"]) !!} <br>
            {!! Form::select($control_control."_muni", \App\Models\tesauro::listar_hijos($tmp_id_depto,$control_vacio), $tmp_id_muni,['class' => 'form-control','style'=>'width:100% !important']) !!}
        </div>
    </div>
    <!-- Lugar Poblado -->
    <div class="col-sm-4">
        <div class="form-group">
            {!! Form::label($control_control, "Subcategoría",['id'=>$control_control."_label"]) !!}<br>
            {!! Form::select($control_control, \App\Models\tesauro::listar_hijos($tmp_id_muni,$control_vacio), $tmp_id_lp,['class' => 'form-control','style'=>'width:100% !important']) !!}
        </div>
    </div>
</div>





{{-- Javascript para controles dependientes --}}


@push('js')
    {{--
        Convertirlo en controles dependientes con depdrop() https://plugins.krajee.com/dependent-dropdown
       La llamada al controller del JSON depende de si pide "Mostrar todos" o no
    --}}
    @if(strlen($control_vacio)>0)
        <script>
            // Controles dependientes, con 'mostrar todos'
            //Municipio
            $("#{{ $control_control }}_muni").depdrop({
                url: '{{ url('json/geo_todo_tesauro') }}',
                depends: ['{{ $control_control }}_depto'],
                //initialize: {{ $tmp_id_depto==-1 ? "true" : "false" }}, //Si tienen valor predeterminado, se cargan con dichos valores, De lo contrario, initialize=true para que cargue los valores iniciales
                //initialize: true,
                loadingText:'Cargando datos...',
                placeholder:false,
                emptyMsg:'Sin datos :-('
            });
            // Lugar poblado
            $("#{{ $control_control }}").depdrop({
                url: '{{ url('json/geo_todo_tesauro') }}',
                depends: ['{{ $control_control }}_muni'],
                initialize: {{ $tmp_id_muni==-1 ? "true" : "false" }}, //Si tienen valor predeterminado, se cargan con dichos valores, De lo contrario, initialize=true para que cargue los valores iniciales
                loadingText:'Cargando datos...',
                placeholder:false,
                emptyMsg:'Sin datos :-('
            });
        </script>
    @else
        <script>
            // Controles dependientes, sin 'mostrar todos'
            //Municipio
            $("#{{ $control_control }}_muni").depdrop({
                url: '{{ url($control_otro ? 'json/geo_tesauro' : 'json/geo') }}',
                depends: ['{{ $control_control }}_depto'],
                initialize: {{ $tmp_id_depto <= 0 ? "true" : "false" }}, //Si tienen valor predeterminado, se cargan con dichos valores, De lo contrario, initialize=true para que cargue los valores iniciales
                loadingText:'Cargando datos...',
                placeholder:false,
                emptyMsg:'Sin datos :-('
            });
            // Lugar poblado
            $("#{{ $control_control }}").depdrop({
                url: '{{ url($control_otro ? 'json/geo_tesauro' : 'json/geo') }}',
                depends: ['{{ $control_control }}_muni'],
                initialize: {{ $tmp_id_lp <= 0 ? "true" : "false" }}, //Si tienen valor predeterminado, se cargan con dichos valores, De lo contrario, initialize=true para que cargue los valores iniciales
                loadingText:'Cargando datos...',
                placeholder:false,
                emptyMsg:'Sin datos :-('
            });

            @if($tmp_id_muni == -1)
            $(function () {
                //console.log('inicializar');
                $("#{{ $control_control }}").depdrop('init');
            });
            @endif
        </script>
    @endif

    {{-- convertirlo en select_2 para que sean mas chileros --}}
    @if($control_select_2)
        <script>
            var control ='#{!! $control_control !!}_depto';
            $(control).select2();
            var control ='#{!! $control_control !!}_muni';
            $(control).select2();
            var control ='#{!! $control_control !!}';
            $(control).select2();
        </script>
    @endif

@endpush




