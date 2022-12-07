@extends('layouts.app')



@section('content_header')
    <h1>Prueba de controles </h1>
@stop


@section('content')
    <div class="row">
        <div class="col-sm-12">

            @include('controles.tesauro3', ['control_control' => 'id_tesauro3'
                                                , 'control_default'=>3815
                                                //, 'control_vacio' => '(Sin especificar)'
                                               ,'control_texto'=>'Etiqueta del tesauro:'])

        </div>
        <div class="col-sm-12">

            @include('controles.tesauro3', ['control_control' => 'id_tesauro31'
                                                , 'control_default'=>3815
                                                , 'control_vacio' => '[Mostrar todos]'
                                               ,'control_texto'=>'Etiqueta del tesauro (con sin especificar):'])

        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            @include('controles.tipo_violencia', ['control_control' => 'id_violencia'
                                                ,'control_default' => 25
                                               ,'control_texto'=>'Tipo de violencia :'])
        </div>
        <div class="col-sm-6">
            @include('controles.tipo_aa', ['control_control' => 'id_aa'
                                                ,'control_default' => 4
                                                , 'control_vacio' => '[Mostrar todos]'
                                               ,'control_texto'=>'Actor armado :'])
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            @include('controles.tipo_tc', ['control_control' => 'id_tc'
                                                ,'control_default' => 12
                                                , 'control_vacio' => '[Mostrar todos]'
                                               ,'control_texto'=>'Tercero Civil:'])
        </div>



    </div>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-sm-6">
            @include('controles.marca', ['control_control' => 'marca'
                                                , 'control_default'=>['1'=>'hugo']
                                                , 'control_vacio' => '(Sin especificar)'
                                               ,'control_texto'=>'Marca:'])
        </div>

        <div class="col-sm-6">
            @include('controles.autofill', ['control_control' => 'prioridad_tema'
                                          ,'control_url' => 'autofill/vi_prioridad'
                                          ,'control_requerido' => true
                                          ,'control_texto'=>'Responsable/Participante:'])
        </div>
    </div>



    <div class="col-sm-6">
        @include('controles.catalogo', ['control_control' => 'frfr'
                                           ,'control_id' => 'fr_x'
                                           ,'control_id_cat'=>4
                                           //, 'control_default'=>$entrevistaIndividual->arreglo_fr
                                           , 'control_multiple' => true
                                           , 'control_requerido' => true
                                           , 'control_otro' => true
                                           ,'control_texto'=>'Responsable/Participante:'])
    </div>


    <div class="col-sm-3">
        @include('controles.catalogo', ['control_control' => 'fr_24'
                                           ,'control_id_cat'=>35
                                           //, 'control_default'=>$entrevistaIndividual->arreglo_fr
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           , 'control_otro' => true
                                           ,'control_texto'=>'Cargo:'])
    </div>
    <div class="col-sm-3">
        @include('controles.catalogo', ['control_control' => 'fr_24_bis'
                                           ,'control_id_cat'=>35
                                           //, 'control_default'=>$entrevistaIndividual->arreglo_fr
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           , 'control_otro' => true
                                           ,'control_texto'=>'Otro Cargo:'])
    </div>
    <hr>
    <div class="clearfix"></div>

    <div class="col-sm-6">
        @include('controles.geo2', ['control_control' => 'id_lugar_nacimiento'

                                           ,'control_texto'=>'Lugar de nacimiento:'])
    </div>



    <div class="col-sm-6">
        @include('controles.geo2', ['control_control' => 'id_lugar_nacimiento2'
                                            , 'control_default'=>9219
                                           ,'control_texto'=>'Lugar de nacimiento (argentina):'])
    </div>



    <div class="col-sm-6">
        @include('controles.geo2', ['control_control' => 'id_lugar_nacimiento3'
                                            , 'control_default'=>9176

                                           ,'control_texto'=>'Lugar de nacimiento (internacional):'])
    </div>



    <div class="col-sm-6">
        @include('controles.geo2', ['control_control' => 'id_lugar_nacimiento4'
                                            , 'control_default'=>9176
                                            , 'control_vacio' => '(Sin especificar)'
                                           ,'control_texto'=>'Lugar de nacimiento (internacional):'])
    </div>

    <div class="clearfix"></div>

    <div class="col-sm-6">
        @include('controles.geo2', ['control_control' => 'id_lugar_nacimiento5'
                                            , 'control_default'=>9219
                                            , 'control_vacio' => '(Sin especificar)'
                                           ,'control_texto'=>'Lugar de nacimiento (argentina):'])
    </div>
    <div class="col-sm-12">
        @include('controles.geo3', ['control_control' => 'id_lugar_nacimiento6'
                                            , 'control_default'=>9219
                                            , 'control_vacio' => '(Sin especificar)'
                                           ,'control_texto'=>'Lugar de nacimiento (sin especificar):'])
    </div>
    <div class="col-sm-12">
        @include('controles.geo3', ['control_control' => 'id_lugar_nacimiento7'
                                            , 'control_default'=>9219
                                            , 'control_otro' => true
                                            //, 'control_vacio' => '(Sin especificar)'
                                           ,'control_texto'=>'Lugar de nacimiento:'])
    </div>
    <hr>
    <div class="clearfix"></div>

    <div class="col-sm-6">
        @include('controles.fecha_incompleta', ['control_control' => 'fecha_nacimiento'
                                            , 'control_default'=>null

                                           ,'control_texto'=>'Fecha de nacimiento (d-m-y):'])
    </div>

    <div class="col-sm-6">
        @include('controles.fecha_incompleta', ['control_control' => 'fecha_nacimiento2'
                                            , 'control_default'=>'1984-01-31'

                                           ,'control_texto'=>'Fecha de nacimiento (01-04-1976):'])
    </div>


    <div class="col-sm-6">
        @include('controles.radio_si_no_cual', ['control_control' => 'tiene_esposa'
                                                ,'control_texto' =>'¿tiene esposa?'
                                                ,'control_control_cual' =>'tiene_esposa_especifique'
                                                ,'control_texto_cual' =>'Indique el nombre'
                                                ,'control_tipo' =>2

                                                ])
    </div>

    <div class="col-sm-6">
        @include('controles.radio_si_no_div', ['control_control' => 'tiene_esposa2'
                                                ,'control_texto' =>'¿tiene esposa?'
                                                ,'control_div' =>'div_detalle'
                                                ])
        <div id="div_detalle">
            <br>
            bla bla bla
            <br>Nombre:
            <br>edad:
        </div>
    </div>





@stop


