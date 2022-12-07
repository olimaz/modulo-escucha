@php
    //tipo: 1. Victima; 2. Persona entrevistada
    $tipo = isset($tipo) ? $tipo : 1;
@endphp
<div class="card card-info collapsed-card card-outline">
    <div class="card-header">

            <h3 class="card-title {{ count($filtros->id_impacto)>0 ? 'text-success': '' }}">
                @if($tipo==1)
                    Filtros según impactos
                @elseif($tipo>=2)
                    Filtros según impactos narrados
                @endif
            </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="col-sm-12">
            <div class="row">
                <h3 class="text-primary">A. Impactos de los hechos</h3>
                <div class="w-100"></div>
                <h4>1. Impactos individuales</h4>
                <div class="w-100"></div>
                <div class="form-group col">
                    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                            ,'control_id'=>'id_impacto_11'
                                                            ,'control_id_cat'=>132
                                                            , 'control_multiple' => true
                                                            , 'control_default' => $filtros->id_impacto
                                                            ,'control_texto'=>'1.1 ¿Qué cambió en su vida?'])
                </div>
                <div class="w-100"></div>
                <div class="form-group col">
                    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                              ,'control_id'=>'id_impacto_12'
                                                              ,'control_id_cat'=>133
                                                              , 'control_multiple' => true
                                                              , 'control_default' => $filtros->id_impacto
                                                              ,'control_texto'=>'1.2 Impactos emocionales que permanecen en el tiempo:'])
                </div>
                <div class="w-100"></div>
                <div class="form-group col">
                    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                              ,'control_id'=>'id_impacto_13'
                                                              ,'control_id_cat'=>134
                                                              , 'control_multiple' => true
                                                              , 'control_default' => $filtros->id_impacto
                                                              ,'control_texto'=>'1.3 Impactos en la salud (física y psicológica):'])
                </div>
                <div class="w-100"></div>
                <h4>2. Impactos relacionales</h4>
                <div class="w-100"></div>
                <div class="form-group col">
                    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                              ,'control_id'=>'id_impacto_21'
                                                              ,'control_id_cat'=>135
                                                              , 'control_multiple' => true
                                                              , 'control_default' => $filtros->id_impacto
                                                              ,'control_texto'=>'2.1 Impactos a los familiares de las víctimas'])
                </div>
                <div class="w-100"></div>
                <div class="form-group col">

                    @include('controles.autofill', ['control_control' => 'impacto_transgeneracional'
                                        ,'control_url' => 'autofill/impactos_transgeneracionales'
                                        ,'control_resaltar' => true
                                        ,'control_default' => $filtros->impacto_transgeneracional
                                        ,'control_texto'=>'2.2 Impactos transgeneracionales:'])

                </div>
                <div class="w-100"></div>
                <div class="form-group col">
                    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                              ,'control_id'=>'id_impacto_23'
                                                              ,'control_id_cat'=>136
                                                              , 'control_multiple' => true
                                                              , 'control_default' => $filtros->id_impacto
                                                              ,'control_texto'=>'2.3 Impactos en la red social personal (vecinos, amigos,  barrio, comunidad)'])
                </div>

                <div class="w-100"></div>
                <h4>3. Revictimización</h4>
                <div class="w-100"></div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                              ,'control_id'=>'id_impacto_3'
                                                              ,'control_id_cat'=>137
                                                              , 'control_multiple' => true
                                                              , 'control_default' => $filtros->id_impacto
                                                              ,'control_texto'=>'3.1 Indique si hubo formas de revictimización como consecuencia de los hechos:'])
                </div>

                <div class="w-100"></div>
                <h3 class="text-primary">B. Impactos colectivos</h3>
                <div class="w-100"></div>
                <div class="form-group col">
                    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                              ,'control_id'=>'id_impacto_b1'
                                                              ,'control_id_cat'=>138
                                                              , 'control_multiple' => true
                                                              , 'control_default' => $filtros->id_impacto
                                                              ,'control_texto'=>'1. Impactos colectivos derivados de los hechos'])
                </div>
                <div class="w-100"></div>
                <div class="form-group col">
                    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                             ,'control_id'=>'id_impacto_b2'
                                                             ,'control_id_cat'=>139
                                                             , 'control_multiple' => true
                                                             , 'control_default' => $filtros->id_impacto
                                                             ,'control_texto'=>'2. Impactos a sujetos colectivos étnicos-raciales'])
                </div>
                <div class="w-100"></div>
                <div class="form-group col">
                    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                             ,'control_id'=>'id_impacto_b3'
                                                             ,'control_id_cat'=>140
                                                             , 'control_multiple' => true
                                                            , 'control_default' => $filtros->id_impacto
                                                             ,'control_texto'=>'3. Impactos ambientales y al territorio'])
                </div>
                <div class="w-100"></div>
                <div class="form-group col">
                    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                            ,'control_id'=>'id_impacto_b4'
                                                            ,'control_id_cat'=>141
                                                            , 'control_multiple' => true
                                                            , 'control_default' => $filtros->id_impacto
                                                            ,'control_texto'=>'4. Impactos a los derechos sociales y económicos'])
                </div>
                <div class="w-100"></div>
                <div class="form-group col">
                    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                            ,'control_id'=>'id_impacto_b5'
                                                            ,'control_id_cat'=>142
                                                            , 'control_multiple' => true
                                                            , 'control_default' => $filtros->id_impacto
                                                            ,'control_texto'=>'5. Impactos culturales'])
                </div>
                <div class="w-100"></div>
                <div class="form-group col">
                    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                                            ,'control_id'=>'id_impacto_b6'
                                                            ,'control_id_cat'=>143
                                                            , 'control_multiple' => true
                                                            , 'control_default' => $filtros->id_impacto
                                                            ,'control_texto'=>'6. Impactos políticos y a la democracia'])
                </div>
                <div class="w-100"></div>


            </div>
        </div>
    </div>
</div>