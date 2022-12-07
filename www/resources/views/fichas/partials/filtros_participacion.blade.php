{{-- Participación social --}}

    <div class="card card-info collapsed-card card-outline">
        <div class="card-header">
            <h3 class="card-title">Filtros según participación social</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    @include('controles.criterio_fijo', ['control_control' => 'cargo_publico'
                            ,'control_grupo'=> 2
                            ,'control_resaltar' => true
                            ,'control_default' => $filtros->cargo_publico
                            ,'control_vacio' =>'[Mostrar todos]'
                            ,'control_texto'=>"Ejerce autoridad o cargo público"])
                </div>
                <div class="col-sm-6">
                    @include('controles.autofill', ['control_control' => 'cargo_publico_cual'
                          ,'control_url' => 'autofill/persona_cargo_publico'
                          ,'control_default' => $filtros->cargo_publico_cual
                          ,'control_resaltar' => true
                          ,'control_max' =>100
                          ,'control_texto'=>'Cargo público que ejerce'])
                </div>
                <div class="col-sm-12">
                    @include('controles.catalogo', ['control_control' => 'autoridad_etnico_territorial'
                            ,'control_id_cat'=>47
                            , 'control_default'=>$filtros->autoridad_etnico_territorial
                            , 'control_multiple' => true
                            , 'control_requerido' => false
                            ,'control_resaltar' => true
                            ,'control_texto'=>'Es autoridad étnico territorial'])
                </div>
                <div class="col-sm-6">
                    @include('controles.catalogo', ['control_control' => 'id_fuerza_publica'
                            ,'control_default' => $filtros->id_fuerza_publica
                            ,'control_id_cat' => 49
                            ,'control_resaltar' => true
                            , 'control_multiple' => true
                            ,'control_texto'=>'Es miembro de la fuerza pública'])
                </div>
                <div class="col-sm-6">
                    @include('controles.catalogo', ['control_control' => 'id_fuerza_publica_estado'
                       ,'control_default' => $filtros->id_fuerza_publica_estado
                       ,'control_id_cat' => 48
                       ,'control_vacio' => '[Mostrar todos]'
                       ,'control_resaltar' => true
                       ,'control_texto'=>'Estado'])

                </div>
                <div class="col-sm-12">
                    @include('controles.autofill', ['control_control' => 'fuerza_publica_especificar'
                                                           ,'control_url' => 'autofill/persona_fuerza_publica'
                                                           ,'control_default' => $filtros->fuerza_publica_especificar
                                                           ,'control_resaltar' => true
                                                           ,'control_max' =>250
                                                           ,'control_texto'=>'Especificar fuerza pública'])
                </div>

                <div class="col-sm-6">
                    @include('controles.catalogo', ['control_control' => 'id_actor_armado'
                                                        ,'control_default' => $filtros->id_actor_armado
                                                        ,'control_id_cat' => 50
                                                        //,'control_vacio' => '[Mostrar todos]'
                                                        , 'control_multiple' => true
                                                        ,'control_resaltar' => true
                                                        ,'control_requerido' => false
                                                        ,'control_texto'=>'Fue miembro de un actor armado ilegal'])
                </div>
                <div class="col-sm-6">
                    @include('controles.autofill', ['control_control' => 'actor_armado_especificar'
                                                          ,'control_url' => 'autofill/persona_actor_armado'
                                                          ,'control_default' => $filtros->actor_armado_especificar
                                                          ,'control_resaltar' => true
                                                          ,'control_max' =>250
                                                          ,'control_texto'=>'Especificar actor armado ilegal'])
                </div>
                <div class="col-sm-6">
                    @include('controles.criterio_fijo', ['control_control' => 'organizacion_colectivo'
                                                            ,'control_grupo'=> 2
                                                            ,'control_resaltar' => true
                                                            ,'control_default' => $filtros->organizacion_colectivo
                                                            ,'control_vacio' =>'[Mostrar todos]'
                                                            ,'control_texto'=>"Participa o participaba en alguna organización/colectivo/grupo/pueblo"])
                </div>
                <div class="col-sm-6">
                    @include('controles.catalogo', ['control_control' => 'id_tipo_organizacion'
                                            , 'control_id_cat'=>51
                                            , 'control_default'=>$filtros->id_tipo_organizacion
                                             , 'control_multiple' => true
                                            ,'control_resaltar' => true
                                            ,'control_requerido' => false

                                            , 'control_texto'=>'24.2 Tipo de organización / sector'])

                </div>
                <div class="col-sm-6">
                    @include('controles.autofill', ['control_control' => 'organizacion_nombre'
                                                           ,'control_url' => 'autofill/persona_nombre_organizacion'
                                                           ,'control_default' => $filtros->organizacion_nombre
                                                           ,'control_resaltar' => true
                                                           ,'control_placeholder' =>'Nombre de la Organización'
                                                           ,'control_max' =>250
                                                           ,'control_texto'=>'Especificar organización:'])
                </div>
                <div class="col-sm-6">
                    @include('controles.autofill', ['control_control' => 'rol'
                                                           ,'control_url' => 'autofill/persona_rol_organizacion'
                                                           ,'control_default' => $filtros->rol
                                                           ,'control_resaltar' => true
                                                           ,'control_placeholder' =>'Rol en la Organización'
                                                           ,'control_max' =>250
                                                           ,'control_texto'=>'Rol:'])
                </div>

            </div>
        </div>
    </div>
