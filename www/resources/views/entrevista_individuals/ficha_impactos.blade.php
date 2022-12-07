@extends('layouts.app')

@section('content_header')
    <h1 class="page-header">

        @if ($tipo_entrevista=='individual')
            Nueva: Ficha de impactos de los hechos - {{ $entrevista->entrevista_codigo }}    
        @else 
            Nueva: Ficha de impactos relacionales y sobre la salud colectiva - {{ $entrevista->entrevista_codigo }}    
        @endif
        

    </h1>

@endsection

@section('content')
        @include('adminlte-templates::common.errors')
        {{-- {!! Form::model($entrevista_justicia, ['action' => ['entrevista_impactoController@grabar', $entrevista->id_e_ind_fvt]]) !!} --}}
        {!! Form::model($entrevista_justicia, ['action' => ['entrevista_impactoController@grabar', $entrevista->id_entrevista]]) !!}     
        <input type="hidden" name="tipo_entrevista" id="tipo_entrevista" value="{{$tipo_entrevista}}">   

        <div class="col-sm-6">
            @php 
                $titulo = ($tipo_entrevista=='individual' ? '1. Impactos individuales' : '1. Impactos sobre las comunidades');
                $titulo_impacto = ($tipo_entrevista=='individual' ? 'A. Impactos de los hechos' : 'A. Impactos relacionales y sobre la salud colectiva');
            @endphp            
            <div class="box box-primary box-solid">
                <div class="box-header">
                <h3 class="box-title">{{$titulo_impacto}}</h3>
                </div>
                <div class="box-body">

                    <h3>{{$titulo}}</h3>

                    @if ($tipo_entrevista == 'individual')
                        <div class="form-group col-xs-12">
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_11'
                                                                    ,'control_id_cat'=>132
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => false   //ajuste del 17/abr
                                                                    //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,132, $tipo_entrevista)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>'1.1 ¿Qué cambió en su vida?'])
                        </div>  

                        <div class="form-group col-xs-12">
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                      ,'control_id'=>'id_impacto_12'
                                                                      ,'control_id_cat'=>133
                                                                      , 'control_multiple' => true
                                                                      , 'control_otro' => true
                                                                      , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,133, $tipo_entrevista)
                                                                      , 'control_vacio' => '[Ninguno / No aplica]'
                                                                      ,'control_texto'=>'1.2 Impactos emocionales que permanecen en el tiempo:'])
                        </div>

                    @endif

                    @if ($tipo_entrevista == 'etnica')

                        <div class="form-group col-xs-12">
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_12'
                                                                    ,'control_id_cat'=>133
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => true
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,133, $tipo_entrevista)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>'1.1 Impactos emocionales que permanecen en el tiempo:'])
                        </div>

                        <div class="form-group col-xs-12">
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_11'
                                                                    ,'control_id_cat'=>276
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => true
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,276, $tipo_entrevista)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>'1.2 Impactos en salud colectiva (física y psicológica)'])
                        </div>                        
                    @endif

                    @if ($tipo_entrevista == 'individual')
                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                  ,'control_id'=>'id_impacto_13'
                                                                  ,'control_id_cat'=>134
                                                                  , 'control_multiple' => true
                                                                  , 'control_otro' => false //ajuste del 17/abr
                                                                  , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,134, $tipo_entrevista)
                                                                  , 'control_vacio' => '[Ninguno / No aplica]'
                                                                  ,'control_texto'=>'1.3 Impactos en la salud (física y psicológica):'])
                    </div>
                    @endif

                    <h3>2. Impactos relacionales</h3>

                    @php
                        $etiqueta = ($tipo_entrevista == 'individual' ? '2.1 Impactos a los familiares de las víctimas' : '2.1 Impactos a las familias de la comunidad');
                    @endphp
                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                  ,'control_id'=>'id_impacto_21'
                                                                  ,'control_id_cat'=>135
                                                                  , 'control_multiple' => true
                                                                  , 'control_otro' => true
                                                                  , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,135, $tipo_entrevista)
                                                                  , 'control_vacio' => '[Ninguno / No aplica]'
                                                                  ,'control_texto'=>$etiqueta])
                    </div>
                                        
                    <div class="form-group col-xs-12">
                        {!! Form::label('transgeneracionales', '2.2 Impactos transgeneracionales: ') !!}

                        @if ($tipo_entrevista == 'individual')

                            <p class="text-green">Diligencie esta parte si los hechos han tenido influencia en algún miembro de la familia que no había nacido o era menor de edad</p>    
                            @php
                                $etiqueta = 'Describa los impactos:';
                            @endphp                            
                        @else 

                            <p class="text-green">Diligencie esta parte si los hechos han tenido influencia en I) miembros de la comunidad que no habían nacido, II) eran menores de edad, III) en la transmisión de conocimiento y diálogo intergeneracional en el marco de la cultura de cada pueblo, IV) en los mayores, sabios y ancianos.</p>    
                            @php
                                $etiqueta = '¿Cuáles? ¿Cómo?';
                            @endphp
                        @endif
                        
                        <label>{{$etiqueta}}</label>
                        {!! Form::text('transgeneracionales', $impacto->transgeneracionales, ['class' => 'form-control','maxlength'=>200 ]) !!}
                    </div>

                    @php
                        $etiqueta = ($tipo_entrevista == 'individual' ? 'personal' : 'comunitaria');
                    @endphp

                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                  ,'control_id'=>'id_impacto_23'
                                                                  ,'control_id_cat'=>136
                                                                  , 'control_multiple' => true
                                                                  , 'control_otro' => true
                                                                  , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,136, $tipo_entrevista)
                                                                  , 'control_vacio' => '[Ninguno / No aplica]'
                                                                  ,'control_texto'=>'2.3 Impactos en la red social ' . $etiqueta . ' (vecinos, amigos,  barrio, comunidad)'])
                    </div>

                    <h3>3. Revictimización</h3>

                    <div class="form-group col-xs-12">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                  ,'control_id'=>'id_impacto_3'
                                                                  ,'control_id_cat'=>137
                                                                  , 'control_multiple' => true
                                                                  , 'control_otro' => false
                                                                  , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,137, $tipo_entrevista)
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
                                                                  , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,138, $tipo_entrevista)
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
                                                                 , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,139, $tipo_entrevista)
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
                                                                 , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,140, $tipo_entrevista)
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
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,141, $tipo_entrevista)
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
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,142, $tipo_entrevista)
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
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,143, $tipo_entrevista)
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
                        @php
                            $etiqueta = ($tipo_entrevista == 'individual' ? 'Afrontamiento individual' : 'Afrontamientos colectivos');
                            $pregunta = ($tipo_entrevista == 'individual' ? 'Cuando ocurrieron los hechos, ¿qué hizo para afrontar/manejar la situación?' : 'Cuando ocurrieron los hechos, ¿qué hicieron para afrontar/manejar la situación?');
                        @endphp
                        <h3>1. {{$etiqueta}}</h3>
                        <div class="form-group col-xs-12">
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_c1'
                                                                    ,'control_id_cat'=>144
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => false
                                                                    //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,144, $tipo_entrevista)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>$pregunta])
                        </div>

                        @if ($tipo_entrevista == 'individual')
                            <h3>2. Afrontamiento familiar</h3>
                            <div class="form-group col-xs-12">
                                @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                        ,'control_id'=>'id_impacto_c2'
                                                                        ,'control_id_cat'=>145
                                                                        , 'control_multiple' => true
                                                                        , 'control_otro' => true
                                                                        //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                        , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,145, $tipo_entrevista)
                                                                        , 'control_vacio' => '[Ninguno / No aplica]'
                                                                        ,'control_texto'=>'Como familia, ¿Hicieron algo para afrontar/manejar la situación?'])
                            </div>
                        @endif


                    </div>
                    <div class="col-sm-6">
                        @if ($tipo_entrevista == 'individual')
                            <h3>3. Afrontamiento colectivo</h3>
                            @php
                                $etiqueta = '3.1 Para manejar la situación, participó o participa en:';
                            @endphp
                        @else                             
                            <h3>2. Para manejar/afrontar la situación, la comunidad participó o participa en:</h3>
                            @php
                                $etiqueta = ' ';
                            @endphp                            
                        @endif
                        <div class="form-group col-xs-12">
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_c31'
                                                                    ,'control_id_cat'=>146
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => true
                                                                    //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,146, $tipo_entrevista)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>$etiqueta])
                        </div>
                        <div class="form-group col-xs-12">
                            @php
                                $etiqueta = ($tipo_entrevista=='individual' ? 'Indique el nombre del proceso colectivo/iniciativa: ' : '2.1 Menciona el nombre del proceso colectivo/iniciativa: '); 
                            @endphp                            
                            {!! Form::label('afrentamiento_proceso', $etiqueta) !!}
                            {!! Form::text('afrentamiento_proceso', $impacto->afrentamiento_proceso, ['class' => 'form-control','maxlength'=>200 ]) !!}
                        </div>

                        <div class="form-group col-xs-12">
                            @php
                                $etiqueta = ($tipo_entrevista=='individual' ? '3.2 Durante su participación en el proceso colectivo, tuvo/tiene dificultades:' : '2.2 El proceso colectivo, tuvo/tiene dificultades:'); 
                            @endphp                                                        
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_c32'
                                                                    ,'control_id_cat'=>147
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => true
                                                                    //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,147, $tipo_entrevista)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>$etiqueta])
                        </div>
                        <div class="form-group col-xs-12">
                            @php
                                $etiqueta = ($tipo_entrevista=='individual' ? '3.3 El proceso / La inciativa fortaleció:' : '2.3 El proceso / La inciativa colectiva fortaleció:'); 
                            @endphp                             
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_c33'
                                                                    ,'control_id_cat'=>148
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => true
                                                                    //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,148, $tipo_entrevista)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>$etiqueta])
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
                                                                , 'control_default' => \App\Models\justicia_institucion::arreglo_institucion($entrevista->id_entrevista,1, $tipo_entrevista)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'Entidad o autoridad:'])
                        </div>
                        <div class="col-sm-4">
                            @include('controles.catalogo', ['control_control' => 'id_j_porque_1'
                                                                ,'control_id_cat'=>153
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\justicia_porque::arreglo_porque($entrevista->id_entrevista,1, $tipo_entrevista)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'¿Por qué accedió a esta entidad o autoridad?:'])
                        </div>
                        <div class="col-sm-4">
                            @include('controles.catalogo', ['control_control' => 'id_j_objetivo_1'
                                                                ,'control_id_cat'=>154
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\justicia_objetivo::arreglo_objetivo($entrevista->id_entrevista,1, $tipo_entrevista)
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
                                                            , 'control_default' => \App\Models\justicia_institucion::arreglo_institucion($entrevista->id_entrevista,2, $tipo_entrevista)
                                                            , 'control_vacio' => '[Ninguno / No aplica]'
                                                            ,'control_texto'=>'Entidad o autoridad:'])
                    </div>
                    <div class="col-sm-4">
                        @include('controles.catalogo', ['control_control' => 'id_j_porque_2'
                                                            ,'control_id_cat'=>153
                                                            , 'control_multiple' => true
                                                            , 'control_otro' => true
                                                            //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                            , 'control_default' => \App\Models\justicia_porque::arreglo_porque($entrevista->id_entrevista,2, $tipo_entrevista)
                                                            , 'control_vacio' => '[Ninguno / No aplica]'
                                                            ,'control_texto'=>'¿Por qué accedió a esta entidad o autoridad?:'])
                    </div>
                    <div class="col-sm-4">
                        @include('controles.catalogo', ['control_control' => 'id_j_objetivo_2'
                                                            ,'control_id_cat'=>154
                                                            , 'control_multiple' => true
                                                            , 'control_otro' => true
                                                            //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                            , 'control_default' => \App\Models\justicia_objetivo::arreglo_objetivo($entrevista->id_entrevista,2, $tipo_entrevista)
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
                                                            , 'control_default' => \App\Models\justicia_institucion::arreglo_institucion($entrevista->id_entrevista,3, $tipo_entrevista)
                                                            , 'control_vacio' => '[Ninguno / No aplica]'
                                                            ,'control_texto'=>'Entidad o autoridad:'])
                    </div>
                    <div class="col-sm-4">
                        @include('controles.catalogo', ['control_control' => 'id_j_porque_3'
                                                            ,'control_id_cat'=>153
                                                            , 'control_multiple' => true
                                                            , 'control_otro' => true
                                                            , 'control_default' => \App\Models\justicia_porque::arreglo_porque($entrevista->id_entrevista,3, $tipo_entrevista)
                                                            , 'control_vacio' => '[Ninguno / No aplica]'
                                                            ,'control_texto'=>'¿Por qué accedió a esta entidad o autoridad?:'])
                    </div>
                    <div class="col-sm-4">
                        @include('controles.catalogo', ['control_control' => 'id_j_objetivo_3'
                                                            ,'control_id_cat'=>154
                                                            , 'control_multiple' => true
                                                            , 'control_otro' => true
                                                            , 'control_default' => \App\Models\justicia_objetivo::arreglo_objetivo($entrevista->id_entrevista,3, $tipo_entrevista)
                                                            , 'control_vacio' => '[Ninguno / No aplica]'
                                                            ,'control_texto'=>'¿Cuál era su objetivo principal al acceder a esta vía?:'])
                    </div>

                    <div class="clearfix"></div>



                    {{-- Resto del formulario --}}


                    <div class="form-group col-sm-6">
                        @php 
                            $etiqueta = ($tipo_entrevista == 'individual' ? '2. ¿Ha recibido apoyo para su caso?' : '2. ¿La comunidad ha recibido apoyo para su caso?');
                        @endphp                        
                        @include('controles.radio_si_no_div', ['control_control' => 'id_apoyo'
                                ,'control_default' => $entrevista_justicia->id_apoyo
                                ,'control_div' => 'div_apoyo'
                                ,'control_texto'=>$etiqueta])
                    </div>

                    <div class="form-group col-sm-6" id="div_apoyo">
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_impacto_j2'
                                                                ,'control_id_cat'=>155
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,155, $tipo_entrevista)
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
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,160, $tipo_entrevista)
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
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,161, $tipo_entrevista)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'3.2 Verdad esclarecida'])
                    </div>

                    @if ($tipo_entrevista=='individual') 
                        <div class="form-group col-sm-6" >
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_j34'
                                                                    ,'control_id_cat'=>163
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => true
                                                                    //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,163, $tipo_entrevista)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>'3.3 Reparación'])
                        </div>
                        <div class="form-group col-sm-6" >
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_j33'
                                                                    ,'control_id_cat'=>162
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => false
                                                                    //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,162, $tipo_entrevista)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>'3.4 Si no hubo avances, ¿Por qué?'])
                        </div>                    
                    @else 
                        {{-- Orden invertido para entrevista étnica y cat_cat diferente en reperación --}}
                        <div class="form-group col-sm-6" >
                            @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                    ,'control_id'=>'id_impacto_j33'
                                                                    ,'control_id_cat'=>162
                                                                    , 'control_multiple' => true
                                                                    , 'control_otro' => true
                                                                    //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                    , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,162, $tipo_entrevista)
                                                                    , 'control_vacio' => '[Ninguno / No aplica]'
                                                                    ,'control_texto'=>'3.3 Si no hubo avances, ¿Por qué?'])
                        </div> 
                        
                        <div class="form-group col-sm-6" >
                                                                        
                                    @include('controles.catalogo', ['control_control' => 'id_reparacion_etnica'
                                                                        ,'control_default' => $impacto->id_reparacion_etnica
                                                                        ,'control_id_cat' => 269
                                                                        ,'control_vacio' => '[Ninguno / No aplica]'
                                                                        //, 'control_otro' => true
                                                                        ,'control_texto'=>'3.4 Reparación']) 
                                                                        
                            </div>                        
                    @endif


                    <div class="form-group col-xs-12" >
                        @php
                         $titulo = ($tipo_entrevista=='individual' ? '4. ¿Qué medidas de reparación individual ha recibido?' : '4. ¿Qué medidas de reparación han recibido?');
                        @endphp
                        <h4>{{$titulo}}</h4>
                    </div>

                    @if($tipo_entrevista=='individual')
                    <div class="form-group col-sm-6" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_41'
                                                                ,'control_id_cat'=>164
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,164, $tipo_entrevista)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'4.1 Indemnización individual'])
                    </div>
                    @endif 

                    @php
                        $etiqueta = ($tipo_entrevista=='individual' ? '4.2 Medidas de restablecimiento de derechos' : '4.1 Medidas de restablecimiento de derechos');
                    @endphp
                    <div class="form-group col-sm-6" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_42'
                                                                ,'control_id_cat'=>165
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,165, $tipo_entrevista)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>$etiqueta])
                    </div>

                    @if ($tipo_entrevista=='individual')
                    <div class="form-group col-sm-6" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_43'
                                                                ,'control_id_cat'=>166
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,166, $tipo_entrevista)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'4.3 Medidas de rehabilitación'])
                    </div>
                    @endif

                    @php
                        $etiqueta = ($tipo_entrevista=='individual' ? '4.4 Medidas de satisfacción' : '4.2 Medidas de satisfacción');
                    @endphp                    
                    <div class="form-group col-sm-6" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_44'
                                                                ,'control_id_cat'=>167
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,167, $tipo_entrevista)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>$etiqueta])
                    </div>
                    @if ($tipo_entrevista=='individual')
                    <div class="form-group col-sm-6" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_45'
                                                                ,'control_id_cat'=>168
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,168, $tipo_entrevista)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'4.5 Otras medidas'])
                    </div>
                    @endif
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_5'
                                                                ,'control_id_cat'=>169
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                //, 'control_vacio' => '[Ninguno / Sin especificar]  '
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,169, $tipo_entrevista)
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
                                                                , 'control_otro' => false
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,170, $tipo_entrevista)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'¿Por qué?'])
                    </div>

                    <div class="form-group col-sm-12" >
                        @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                                ,'control_id'=>'id_medida_7'
                                                                ,'control_id_cat'=>171
                                                                , 'control_multiple' => true
                                                                , 'control_otro' => true
                                                                , 'control_default' => \App\Models\entrevista_impacto::arreglo_impacto($entrevista->id_entrevista,171, $tipo_entrevista)
                                                                , 'control_vacio' => '[Ninguno / No aplica]'
                                                                ,'control_texto'=>'7. ¿Qué se necesita para que estos hechos no se vuelvan a repetir?'])
                    </div>


                </div>
                <div class="box-footer">
                    {!! Form::submit('Grabar ficha', ['class' => 'btn btn-primary']) !!}

                    @if ($tipo_entrevista=='individual')
                        <a href="{!! action('entrevista_individualController@fichas',$entrevista->id_entrevista) !!}" class="btn btn-default">Cancelar</a>    
                    @else 
                        <a href="{!! action('entrevista_etnicaController@fichas',$entrevista->id_entrevista) !!}" class="btn btn-default">Cancelar</a>    
                    @endif
                    

                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        {!! Form::close() !!}

@endsection

