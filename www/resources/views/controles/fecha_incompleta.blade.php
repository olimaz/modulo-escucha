{{--

Control para pedir fecha incompleta
Parametros:
$control_control: nombre del control/variable  (name='xxx')
    Al nombre le agrega _a, _m, _d para año, mes, dia
$control_texto: Etiqueta a desplegar
$control_default: fecha predeterminada en formato YYYY-MM-DD
$control_min: anio mínimo que se acepta
$control_max. anio máximo que se acepta
$control_vacio. Se muestra en el año

--}}

@php

    $control_min = isset($control_min) ? $control_min : 1900;
    $control_max = isset($control_max) ? $control_max : date('Y');
    $control_default = isset($control_default) ? $control_default : null;
    $control_texto = isset($control_texto) ? $control_texto : "&nbsp;";
    $control_requerido = isset($control_requerido) ? $control_requerido : false;
    $control_vacio = isset($control_vacio) ? $control_vacio : false;

    $defa_anio=null;
    $defa_mes=null;
    $defa_dia=null;

    if(strlen($control_default)>=4) {
        $defa_anio = substr($control_default,0,4);
        $defa_mes = substr($control_default,5,2);
        $defa_dia = substr($control_default,8,2);
    }

    $a_anios=array();
    if(strlen($control_vacio)>0) {
        $a_anios[0]=$control_vacio;
    }
    $anio=$control_min;
    while($anio <= $control_max) {
        $a_anios[$anio]=$anio;
        $anio++;
    }

    $a_meses = [
                '00' => strlen($control_vacio) > 0 ? $control_vacio :'-- Desconocido',
                '01' => '1 - Enero',
                '02' => '2 - Febrero',
                '03' => '3 - Marzo',
                '04' => '4 - Abril',
                '05' => '5 - Mayo',
                '06' => '6 - Junio',
                '07' => '7 - Julio',
                '08' => '8 - Agosto',
                '09' => '9 - Septiembre',
                '10' => '10 - Octubre',
                '11' => '11 - Noviembre',
                '12' => '12 - Diciembre',
                ];
    $a_dias = array();
    for($i=0 ; $i<=31 ; $i++) {
        $a_dias[str_pad($i,2,"0",STR_PAD_LEFT)]=$i;
    }
    $a_dias['00']='--';

    $opciones = ['class' => 'form-control','style'=>'width:100% !important'];
    $opciones_anio = $opciones;
    $opciones_mes = $opciones;
    $opciones_dia = $opciones;

    $opciones_anio['id'] = $control_control."_a";
    $opciones_mes['id']  = $control_control."_m";
    $opciones_dia['id']  = $control_control."_d";

    if($control_requerido) {
        $opciones_anio['required']="required";
    }





@endphp


<div class="row form-group">
    <div class="col-xs-12">
        <label> {!! $control_texto !!}</label>
    </div>



    <div class="col-xs-3 form-group">
        {!! Form::select($control_control."_d",$a_dias, $defa_dia,$opciones_dia) !!}
    </div>
    <div class="col-xs-5">
        {!! Form::select($control_control."_m",$a_meses, $defa_mes,$opciones_mes) !!}
    </div>
    <div class="col-xs-4">
        {!! Form::select($control_control."_a",$a_anios, $defa_anio,$opciones_anio) !!}
    </div>
</div>


@push("js")
    <script>
        var control_{{$control_control}}_d ='#{!! $control_control !!}_d';
        $(control_{{$control_control}}_d).select2();
        var control_{{$control_control}}_m ='#{!! $control_control !!}_m';
        $(control_{{$control_control}}_m).select2();
        var control_{{$control_control}}_a ='#{!! $control_control !!}_a';
        $(control_{{$control_control}}_a).select2();

        //Si escoge mes sin especificar, resetear dia a 0



        $(control_{{$control_control}}_m).change(function(){
            var a_meses_30=['04','06','09','11'];

            if($(this).val()=='00') {

                $(control_{{$control_control}}_d).val('00');
                $(control_{{$control_control}}_d).trigger('change');
            }
            else {
                if($(control_{{$control_control}}_d).val()=="31") {
                    if($(this).val()=='02') {
                        $(control_{{$control_control}}_d).val('28').trigger('change');
                    }

                    if(a_meses_30.indexOf($(this).val())>=0) {
                        $(control_{{$control_control}}_d).val('30').trigger('change');
                    }
                }
                else {
                    if($(control_{{$control_control}}_d).val()=="30") {
                        if ($(this).val() == '02') {
                            $(control_{{$control_control}}_d).val('28').trigger('change');
                        }
                    }
                }
            }
        })



    </script>



@endpush