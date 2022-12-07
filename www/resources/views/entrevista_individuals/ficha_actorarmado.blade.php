@extends('layouts.app')

@section('content_header')
    <h1 class="page-header">
        Nueva: Ficha de impactos de los hechos - {{ $entrevista->entrevista_codigo }}

    </h1>

@endsection

@section('content')
        @include('adminlte-templates::common.errors')
        {!! Form::model($entrevista_justicia, ['action' => ['entrevista_impactoController@grabar', $entrevista->id_e_ind_fvt]]) !!}
        <div class="col-sm-6">
            <div class="box box-primary box-solid">
                <div class="box-header">
                    <h3 class="box-title">A. Impactos de los hechos</h3>
                </div>
                <div class="box-body">

                    <h3>1. Impactos individuales</h3>
                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                  ,'control_id'=>'id_impacto_11'
                                                                  ,'control_id_cat'=>132
                                                                  , 'control_multiple' => true
                                                                  , 'control_otro' => true
                                                                  //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                  , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,132)
                                                                  , 'control_vacio' => '[Ninguno / No aplica]'
                                                                  ,'control_texto'=>'1.1 ¿Qué cambió en su vida?'])
                    </div>
                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                  ,'control_id'=>'id_impacto_12'
                                                                  ,'control_id_cat'=>133
                                                                  , 'control_multiple' => true
                                                                  , 'control_otro' => true
                                                                  , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,133)
                                                                  , 'control_vacio' => '[Ninguno / No aplica]'
                                                                  ,'control_texto'=>'1.2 Impactos emocionales que permanecen en el tiempo:'])
                    </div>
                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                  ,'control_id'=>'id_impacto_13'
                                                                  ,'control_id_cat'=>134
                                                                  , 'control_multiple' => true
                                                                  , 'control_otro' => true
                                                                  , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,134)
                                                                  , 'control_vacio' => '[Ninguno / No aplica]'
                                                                  ,'control_texto'=>'1.3 Impactos en la salud (física y psicológica):'])
                    </div>

                    <h3>2. Impactos relacionales</h3>
                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                  ,'control_id'=>'id_impacto_21'
                                                                  ,'control_id_cat'=>135
                                                                  , 'control_multiple' => true
                                                                  , 'control_otro' => true
                                                                  , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,135)
                                                                  , 'control_vacio' => '[Ninguno / No aplica]'
                                                                  ,'control_texto'=>'2.1 Impactos a los familiares de las víctimas'])
                    </div>
                    <div class="form-group col-xs-12">
                        {!! Form::label('transgeneracionales', '2.2 Impactos transgeneracionales: ') !!}
                        <p class="text-green">Diligencie esta parte si los hechos han tenido influencia en algún miembro de la familia que no había nacido o era menor de edad</p>
                        <label>Describa los impactos:</label>
                        {!! Form::text('transgeneracionales', $impacto->transgeneracionales, ['class' => 'form-control','maxlength'=>200 ]) !!}
                    </div>

                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                  ,'control_id'=>'id_impacto_23'
                                                                  ,'control_id_cat'=>136
                                                                  , 'control_multiple' => true
                                                                  , 'control_otro' => true
                                                                  , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,136)
                                                                  , 'control_vacio' => '[Ninguno / No aplica]'
                                                                  ,'control_texto'=>'2.3 Impactos en la red social personal (vecinos, amigos,  barrio, comunidad)'])
                    </div>

                    <h3>3. Revictimización</h3>

                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                  ,'control_id'=>'id_impacto_3'
                                                                  ,'control_id_cat'=>137
                                                                  , 'control_multiple' => true
                                                                  , 'control_otro' => false
                                                                  , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,137)
                                                                  , 'control_vacio' => '[Ninguno / No aplica]'
                                                                  ,'control_texto'=>'3.1 Indique si hubo formas de revictimización como consecuencia de los hechos:'])
                    </div>


                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box box-primary box-solid">
                <div class="box-header">
                    <h3 class="box-title">B. Impactos colectivos</h3>
                </div>
                <div class="box-body">


                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                  ,'control_id'=>'id_impacto_b1'
                                                                  ,'control_id_cat'=>138
                                                                  , 'control_multiple' => true
                                                                  , 'control_otro' => true
                                                                  //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                  , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,138)
                                                                  , 'control_vacio' => '[Ninguno / No aplica]'
                                                                  ,'control_texto'=>'1. Impactos colectivos derivados de los hechos'])
                    </div>
                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                 ,'control_id'=>'id_impacto_b2'
                                                                 ,'control_id_cat'=>139
                                                                 , 'control_multiple' => true
                                                                 , 'control_otro' => true
                                                                 //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                 , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,139)
                                                                 , 'control_vacio' => '[Ninguno / No aplica]'
                                                                 ,'control_texto'=>'2. Impactos a sujetos colectivos étnicos-raciales'])
                    </div>
                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                 ,'control_id'=>'id_impacto_b3'
                                                                 ,'control_id_cat'=>140
                                                                 , 'control_multiple' => true
                                                                 , 'control_otro' => true
                                                                 //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                 , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,140)
                                                                 , 'control_vacio' => '[Ninguno / No aplica]'
                                                                 ,'control_texto'=>'3. Impactos ambientales y al territorio'])
                    </div>


                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_impacto_b4'
                                                                ,'control_id_cat'=>141
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,141)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'4. Impactos a los derechos sociales y económicos'])
                    </div>
                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_impacto_b5'
                                                                ,'control_id_cat'=>142
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,142)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'5. Impactos culturales'])
                    </div>
                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_impacto_b6'
                                                                ,'control_id_cat'=>143
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,143)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'6. Impactos políticos y a la democracia'])
                    </div>



                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">C. Afrontamiento y resistencia</h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-6">
                        <h3>1. Afrontamiento individual</h3>
                        <div class="form-group col-xs-12">
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_c1'
                                                                    ,'control_id_cat'=>144
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => true
                                                                    //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,144)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>'Cuando ocurrieron los hechos, ¿que hizo para afrontar/manejar la situación?'])
                        </div>

                        <h3>2. Afrontamiento familiar</h3>
                        <div class="form-group col-xs-12">
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_c2'
                                                                    ,'control_id_cat'=>145
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => true
                                                                    //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,145)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>'Como familia, ¿Hicieron algo para afrontar/manejar la situación?'])
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <h3>3. Afrontamiento colectivo</h3>
                        <div class="form-group col-xs-12">
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_c31'
                                                                    ,'control_id_cat'=>146
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => true
                                                                    //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,146)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>'3.1 Para manejar la situación, participó o participa en:'])
                        </div>
                        <div class="form-group col-xs-12">
                            {!! Form::label('afrentamiento_proceso', 'Indique el nombre del proceso colectivo/iniciativa: ') !!}
                            {!! Form::text('afrentamiento_proceso', $impacto->afrentamiento_proceso, ['class' => 'form-control','maxlength'=>200 ]) !!}
                        </div>

                        <div class="form-group col-xs-12">
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_c32'
                                                                    ,'control_id_cat'=>147
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => true
                                                                    //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,147)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>'3.2 Durante su participación en el proceso colectivo, tuvo/tiene dificultades:'])
                        </div>
                        <div class="form-group col-xs-12">
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_c33'
                                                                    ,'control_id_cat'=>148
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => true
                                                                    //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,148)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>'3.3 El proceso / La inciativa fortaleció:'])
                        </div>


                    </div>
                </div>
            </div>

        </div>

        <div class="clearfix"></div>
        <div class="col-xs-12">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">D. Acceso a la justicia, reparación y no repetición</h3>
                </div>
                <div class="box-body">

                    <div class="form-group col-sm-6">
                        @include('controles.radio_si_no_div', ['control_control' => 'id_denuncio'
                                ,'control_default' => $entrevista_justicia->id_denuncio
                                ,'control_inverso' => true
                                ,'control_div' => 'div_denuncio'
                                ,'control_texto'=>"1. ¿Puso en conocimiento a alguna entidad o autoridad?"])
                    </div>
                    <div class="form-group col-sm-6" id="div_denuncio">
                        <label>¿Por qué no?:</label>
                        {!! Form::text('porque_no', $entrevista_justicia->porque_no, ['class' => 'form-control','maxlength'=>200 ]) !!}


                    </div>
                    <div class="clearfix"></div>
                        <div class="col-sm-12">
                            <h4 >Estatal</h4>
                        </div>
                        <div class="col-sm-4">
                            @include('controles.catalogo', ['control_control' => 'id_j_institucion_1'
                                                                ,'control_id_cat'=>150
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\justicia_institucion::arreglo_institucion($entrevista->id_e_ind_fvt,1)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'Entidad o autoridad:'])
                        </div>
                        <div class="col-sm-4">
                            @include('controles.catalogo', ['control_control' => 'id_j_porque_1'
                                                                ,'control_id_cat'=>153
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\justicia_porque::arreglo_porque($entrevista->id_e_ind_fvt,1)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'¿Por qué accedió a esta entidad o autoridad?:'])
                        </div>
                        <div class="col-sm-4">
                            @include('controles.catalogo', ['control_control' => 'id_j_objetivo_1'
                                                                ,'control_id_cat'=>154
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\justicia_objetivo::arreglo_objetivo($entrevista->id_e_ind_fvt,1)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'¿Cuál era su objetivo principal al acceder a esta vía?:'])
                        </div>
                    <div class="clearfix"></div>


                    {{-- COMUNITARIO --}}
                    <div class="col-sm-12">
                        <h4 >Comunitario</h4>
                    </div>
                    <div class="col-sm-4">
                        @include('controles.catalogo', ['control_control' => 'id_j_institucion_2'
                                                            ,'control_id_cat'=>151
                                                            , 'control_multiple' => true
                                                            , 'control_otro' => true
                                                            //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                            , 'control_default' => \App\Models\justicia_institucion::arreglo_institucion($entrevista->id_e_ind_fvt,2)
                                                            , 'control_vacio' => '[Ninguno / No aplica]'
                                                            ,'control_texto'=>'Entidad o autoridad:'])
                    </div>
                    <div class="col-sm-4">
                        @include('controles.catalogo', ['control_control' => 'id_j_porque_2'
                                                            ,'control_id_cat'=>153
                                                            , 'control_multiple' => true
                                                            , 'control_otro' => true
                                                            //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                            , 'control_default' => \App\Models\justicia_porque::arreglo_porque($entrevista->id_e_ind_fvt,2)
                                                            , 'control_vacio' => '[Ninguno / No aplica]'
                                                            ,'control_texto'=>'¿Por qué accedió a esta entidad o autoridad?:'])
                    </div>
                    <div class="col-sm-4">
                        @include('controles.catalogo', ['control_control' => 'id_j_objetivo_2'
                                                            ,'control_id_cat'=>154
                                                            , 'control_multiple' => true
                                                            , 'control_otro' => true
                                                            //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                            , 'control_default' => \App\Models\justicia_objetivo::arreglo_objetivo($entrevista->id_e_ind_fvt,2)
                                                            , 'control_vacio' => '[Ninguno / No aplica]'
                                                            ,'control_texto'=>'¿Cuál era su objetivo principal al acceder a esta vía?:'])
                    </div>
                    <div class="clearfix"></div>


                    {{-- Internacional --}}
                    <div class="col-sm-12">
                        <h4 >Internacional</h4>
                    </div>

                    <div class="col-sm-4">
                        @include('controles.catalogo', ['control_control' => 'id_j_institucion_3'
                                                            ,'control_id_cat'=>152
                                                            , 'control_multiple' => true
                                                            , 'control_otro' => true
                                                            , 'control_default' => \App\Models\justicia_institucion::arreglo_institucion($entrevista->id_e_ind_fvt,3)
                                                            , 'control_vacio' => '[Ninguno / No aplica]'
                                                            ,'control_texto'=>'Entidad o autoridad:'])
                    </div>
                    <div class="col-sm-4">
                        @include('controles.catalogo', ['control_control' => 'id_j_porque_3'
                                                            ,'control_id_cat'=>153
                                                            , 'control_multiple' => true
                                                            , 'control_otro' => true
                                                            , 'control_default' => \App\Models\justicia_porque::arreglo_porque($entrevista->id_e_ind_fvt,3)
                                                            , 'control_vacio' => '[Ninguno / No aplica]'
                                                            ,'control_texto'=>'¿Por qué accedió a esta entidad o autoridad?:'])
                    </div>
                    <div class="col-sm-4">
                        @include('controles.catalogo', ['control_control' => 'id_j_objetivo_3'
                                                            ,'control_id_cat'=>154
                                                            , 'control_multiple' => true
                                                            , 'control_otro' => true
                                                            , 'control_default' => \App\Models\justicia_objetivo::arreglo_objetivo($entrevista->id_e_ind_fvt,3)
                                                            , 'control_vacio' => '[Ninguno / No aplica]'
                                                            ,'control_texto'=>'¿Cuál era su objetivo principal al acceder a esta vía?:'])
                    </div>

                    <div class="clearfix"></div>



                    {{-- Resto del formulario --}}


                    <div class="form-group col-sm-6">
                        @include('controles.radio_si_no_div', ['control_control' => 'id_apoyo'
                                ,'control_default' => $entrevista_justicia->id_apoyo
                                ,'control_div' => 'div_apoyo'
                                ,'control_texto'=>"2. ¿Ha recibido apoyo para su caso?"])
                    </div>

                    <div class="form-group col-sm-6" id="div_apoyo">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_impacto_j2'
                                                                ,'control_id_cat'=>155
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,155)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'Especifique'])
                    </div>
                    <div class="form-group col-xs-12" >
                        <h4>3. ¿Qué avances ha tenido su caso?</h4>
                    </div>

                    <div class="form-group col-sm-6" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_impacto_j31'
                                                                ,'control_id_cat'=>160
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,160)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'3.1 Responsable sancionado'])
                    </div>
                    <div class="form-group col-sm-6" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_impacto_j32'
                                                                ,'control_id_cat'=>161
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,161)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'3.2 Verdad esclarecida'])
                    </div>
                    <div class="form-group col-sm-6" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_impacto_j34'
                                                                ,'control_id_cat'=>163
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,163)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'3.3 Reparación'])
                    </div>
                    <div class="form-group col-sm-6" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_impacto_j33'
                                                                ,'control_id_cat'=>162
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,162)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'3.4 Si no hubo avances, ¿Por qué?'])
                    </div>

                    <div class="form-group col-xs-12" >
                        <h4>4. ¿Qué medidas de reparación individual ha recibido?</h4>
                    </div>

                    <div class="form-group col-sm-6" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_41'
                                                                ,'control_id_cat'=>164
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,164)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'4.1 Indemnización individual'])
                    </div>
                    <div class="form-group col-sm-6" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_42'
                                                                ,'control_id_cat'=>165
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,165)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'4.2 Medidas de restablecimiento de derechos'])
                    </div>
                    <div class="form-group col-sm-6" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_43'
                                                                ,'control_id_cat'=>166
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,166)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'4.3 Medidas de rehabilitación'])
                    </div>
                    <div class="form-group col-sm-6" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_44'
                                                                ,'control_id_cat'=>167
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,167)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'4.4 Medidas de satisfacción'])
                    </div>
                    <div class="form-group col-sm-6" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_45'
                                                                ,'control_id_cat'=>168
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,168)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'4.5 Otras medidas'])
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_5'
                                                                ,'control_id_cat'=>169
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,169)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'5. Estado de avance de la reparación colectiva'])
                    </div>

                    <div class="form-group col-sm-6">
                        @include('controles.radio_si_no_div', ['control_control' => 'id_adecuado'
                                ,'control_default' => $entrevista_justicia->id_adecuado
                                ,'control_inverso' => true
                                ,'control_div' => 'div_adecuado'
                                ,'control_texto'=>"6. Las medidas de reparación, ¿han sido adecuadas?"])
                    </div>

                    <div class="form-group col-sm-6" id="div_adecuado" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_61'
                                                                ,'control_id_cat'=>170
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,170)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'¿Por qué?'])
                    </div>

                    <div class="form-group col-sm-12" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_7'
                                                                ,'control_id_cat'=>171
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_e_ind_fvt,171)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'7. ¿Qué se necesita para que estos hechos no se vuelvan a repetir?'])
                    </div>


                </div>
                <div class="box-footer">
                    {!! Form::submit('Grabar ficha', ['class' => 'btn btn-primary']) !!}
                    <a href="{!! action('entrevista_individualController@fichas',$entrevista->id_e_ind_fvt) !!}" class="btn btn-default">Cancelar</a>


                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        {!! Form::close() !!}

@endsection

