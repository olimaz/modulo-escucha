@extends('layouts.app')



@section('content_header')
    <h1>Controles predefinidos en carpeta /views/controles</h1>
@stop


@section('content')



    <div class="col-sm-6">
        @include('controles.catalogo', ['control_control' => 'id_mterritorio'
                                            ,'control_id_cat'=>3
                                            , 'control_default'=>0
                                            //, 'control_vacio' => '[Mostrar todos]'
                                            ,'control_texto'=>'Territorio'])
    </div>
    <div class="col-sm-6">
        @include('controles.catalogo', ['control_control' => 'id_mterritorio_m'
                                            ,'control_id_cat'=>3
                                            , 'control_default'=>0
                                            , 'control_multiple' => true
                                            ,'control_texto'=>'Territorio'])
    </div>

    <div class="clearfix"></div>
    <div class="col-sm-6">

        @include('controles.cev2', ['control_control' => 'id_territorio'
                                               , 'control_territorio'=>23])
    </div>
    <div class="col-sm-6">

        @include('controles.cev2', ['control_control' => 'id_territorio_pre'
                                               , 'control_macroterritorio'=>4])
    </div>
    <div class="col-sm-6">

        @include('controles.cev2', ['control_control' => 'id_territorio_vacio'
                                                ,'control_vacio' => "[Sin especificar]"
                                               , 'control_territorio'=>23])
    </div>
    <div class="clearfix"></div>


    <div class="col-sm-6">
        @include('controles.catalogo', ['control_control' => 'id_territorio_p'
                                            ,'control_id_cat'=>3
                                            , 'control_default'=>19
                                            //, 'control_vacio' => '[Mostrar todos]'
                                            ,'control_texto'=>'Territorio'])
    </div>
    <div class="col-sm-6">
        @include('controles.catalogo', ['control_control' => 'id_territorio_m_p'
                                            ,'control_id_cat'=>3
                                            , 'control_default'=>[19,26]
                                            , 'control_multiple' => true
                                            ,'control_texto'=>'Territorio'])
    </div>


    <div class="col-sm-12">

        @include('controles.geo3', ['control_control' => 'id_lp'
                                               , 'control_default'=>1182])
    </div>
    <div class="col-sm-12">

        @include('controles.geo3', ['control_control' => 'id_lp2'
                                               , 'control_default'=>0])
    </div>
    <div class="col-sm-4">

        @include('controles.carga_archivo', ['control_control' => 'archivo_1'
                                               , 'control_texto'=>"Prueba de carga"])
    </div>

    <div class="col-sm-4">

        @include('controles.carga_archivo', ['control_control' => 'archivo_2'
                                              ,'control_default' =>"abc.jpg"
                                               , 'control_texto'=>" Otra Prueba de carga"])
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-6">
        @include('controles.fecha', ['control_control' => 'fecha'
                                        , 'control_default'=>'2017-09-20'
                                        ,'control_texto'=>'Fecha de nacimiento'])
    </div>
    <div class="col-sm-6">
        @include('controles.radio_si_no', ['control_control' => 'si_no'
                                        ,'control_texto'=>'Te gusta el control?'])
    </div>



    @include("controles.js_carga_archivo")
    <div class="clearfix"></div>

@stop
