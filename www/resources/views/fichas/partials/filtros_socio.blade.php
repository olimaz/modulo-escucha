@php
    //tipo: 1. Victima; 2. Persona entrevistada
    $tipo = isset($tipo) ? $tipo : 1;
@endphp
{{-- Datos sociodemograficos --}}
<div class="row">
    <div class="col-sm-3">
        @include('controles.texto', ['control_control' => 'apellido'
                                   , 'control_default'=>$filtros->apellido
                                   ,'control_resaltar' => true
                                   ,'control_texto'=>'Apellido:'])
    </div>
    <div class="col-sm-3">
        @include('controles.texto', ['control_control' => 'nombre'
                                   , 'control_default'=>$filtros->nombre
                                   ,'control_resaltar' => true
                                   ,'control_texto'=>'Nombre:'])
    </div>
    <div class="col-sm-3">
        @include('controles.texto', ['control_control' => 'alias'
                                   , 'control_default'=>$filtros->alias
                                   ,'control_resaltar' => true
                                   ,'control_texto'=>'Otros nombres:'])
    </div>

    <div class="w-100"></div>
    <div class="col-sm-3">
        @include('controles.catalogo', ['control_control' => 'id_sexo'
                                      ,'control_default' => $filtros->id_sexo
                                      ,'control_id_cat' => 24
                                      ,'control_vacio' => "[Mostrar todos]"
                                      ,'control_resaltar' => true
                                      ,'control_texto'=>'Sexo (asignado al nacer):'])
    </div>
    @if($tipo<>3)
        <div class="col-sm-3">
            @include('controles.catalogo', ['control_control' => 'id_orientacion'
                                          ,'control_default' => $filtros->id_orientacion
                                          ,'control_id_cat' => 25
                                          ,'control_vacio' => "[Mostrar todos]"
                                          ,'control_resaltar' => true
                                          ,'control_texto'=>'Orientación sexual (se siente atraído por):'])
        </div>
        <div class="col-sm-3">
            @include('controles.catalogo', ['control_control' => 'id_identidad'
                                          ,'control_default' => $filtros->id_identidad
                                          ,'control_id_cat' => 26
                                          ,'control_vacio' => "[Mostrar todos]"
                                          ,'control_resaltar' => true
                                          ,'control_texto'=>'Identidad de género (¿cómo se identifica?):'])
        </div>
        <div class="col-sm-3">
            <div class="row">
                <div class="col">
                    @include('controles.numero', ['control_control' => 'edad_del'
                                           , 'control_default'=>$filtros->edad_del
                                           ,'control_resaltar' => true
                                           ,'control_requerido' => false
                                           ,'control_texto'=>'Edad mínima:'])
                </div>
                <div class="col">
                    @include('controles.numero', ['control_control' => 'edad_al'
                                          , 'control_default'=>$filtros->edad_al
                                          ,'control_resaltar' => true
                                          ,'control_requerido' => false
                                          ,'control_texto'=>'Edad máxima:'])

                </div>
            </div>
        </div>
        <div class="w-100"></div>
    @else {{-- pri --}}
        <div class="col-sm-3">
                @include('controles.catalogo', ['control_control' => 'id_edad_aproximada'
                                     ,'control_default' => $filtros->id_edad_aproximada
                                     ,'control_id_cat' => 29
                                     ,'control_vacio' => "[Mostrar todos]"
                                     ,'control_resaltar' => true
                                     ,'control_texto'=>'Edad aproximada al momento de los hechos:'])
        </div>
    @endif


    <div class="col-sm-3">
        @include('controles.catalogo', ['control_control' => 'id_etnia'
                                        ,'control_default' => $filtros->id_etnia
                                        ,'control_id_cat' => 27
                                        , 'control_multiple' => true
                                        , 'control_requerido' => false
                                        ,'control_resaltar' => true
                                        ,'control_texto'=>'Pertenencia étnico-racial:'])
    </div>

    <div class="col-sm-3">
        @include('controles.catalogo', ['control_control' => 'id_etnia_indigena'
                                        ,'control_default' => $filtros->id_etnia_indigena
                                        ,'control_id_cat' => 28
                                        , 'control_multiple' => true
                                        , 'control_requerido' => false
                                        , 'control_resaltar' => true
                                        //,'control_vacio' => '[Mostrar todos]'
                                        ,'control_texto'=>'¿A cuál étnia indígena pertenece?'])

    </div>
    @if($tipo<>3)
        <div class="col-sm-3">
            @include('controles.catalogo', ['control_control' => 'id_nacionalidad'
                                            ,'control_default' => $filtros->id_nacionalidad
                                             ,'control_id_cat' => 42
                                              , 'control_multiple' => true
                                            , 'control_requerido' => false
                                            , 'control_resaltar' => true
                                            //,'control_vacio' => '[Mostrar todos]'
                                            ,'control_texto'=>'Nacionalidad:'])
        </div>
        <div class="col-sm-3">
            @include('controles.catalogo', ['control_control' => 'id_estado_civil'
                               ,'control_default' => $filtros->id_estado_civil
                               ,'control_id_cat' => 43
                               , 'control_multiple' => true
                                            , 'control_requerido' => false
                                            , 'control_resaltar' => true
                                            //,'control_vacio' => '[Mostrar todos]'
                               ,'control_texto'=>'Estado civil:'])
        </div>
    @else {{-- PRI --}}
        <div class="w-100"></div>

        <div class="col-sm-3">
                @include('controles.catalogo', ['control_control' => 'id_rango_cargo'
                                  ,'control_default' => $filtros->id_rango_cargo
                                  ,'control_id_cat' => 34
                                  ,'control_vacio' => '[Mostrar todos]'
                                  , 'control_requerido' => false
                                  , 'control_resaltar' => true
                                  ,'control_texto'=>'Actor armado del que hacía parte'])
            </div>
        <div class="col-sm-3">
                @include('controles.catalogo', ['control_control' => 'id_grupo_paramilitar'
                                                ,'control_default' => $filtros->id_grupo_paramilitar
                                                ,'control_id_cat' => 35
                                                , 'control_requerido' => false
                                                , 'control_resaltar' => true
                                                ,'control_vacio' => '[Mostrar todos]'
                                                ,'control_texto'=>'Rango/Cargo: Grupo paramilitar'])
            </div>

        <div class="col-sm-3">
                @include('controles.catalogo', ['control_control' => 'id_guerrilla'
                                                ,'control_default' => $filtros->id_guerrilla
                                                ,'control_id_cat' => 37
                                                , 'control_requerido' => false
                                                , 'control_resaltar' => true
                                                ,'control_vacio' => '[Mostrar todos]'
                                                ,'control_texto'=>'Rango/Cargo: Guerrillas'])
            </div>

        <div class="col-sm-3">
                @include('controles.catalogo', ['control_control' => 'id_fuerza_publica'
                                                ,'control_default' => $filtros->id_fuerza_publica
                                                ,'control_id_cat' => 38
                                                , 'control_requerido' => false
                                                , 'control_resaltar' => true
                                                ,'control_vacio' => '[Mostrar todos]'
                                                ,'control_texto'=>'Rango/Cargo: Fuerza pública'])
        </div>
        <div class="col-sm-3">
            @include('controles.catalogo', ['control_control' => 'id_otro'
                                            ,'control_default' => $filtros->id_otro
                                            ,'control_id_cat' => 174
                                            , 'control_requerido' => false
                                            , 'control_resaltar' => true
                                            ,'control_vacio' => '[Mostrar todos]'
                                            ,'control_texto'=>'Rango/Cargo: Otra fuerza'])
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                {!! Form::label('nombre_superior', 'Nombre del superior o el que mandaba en el momento de los hechos:') !!}
                {!! Form::text('nombre_superior', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
            </div>
        </div>
        <div class="col-sm-3">
            @include('controles.criterio_fijo', ['control_control' => 'conoce_info'
                                                , 'control_grupo'=>2
                                                , 'control_default'=>$filtros->conoce_info
                                                , 'control_multiple' => false
                                                , 'control_requerido' => false
                                                ,'control_resaltar' => true
                                                ,'control_vacio' => '[Mostrar todos]'
                                                //, 'control_vacio' => '[Ninguno]'
                                                , 'control_texto'=>'¿Sabe qué hace y dónde está el responsable ahora?:'])
        </div>
        <div class="col-sm-3">
            @include('controles.criterio_fijo', ['control_control' => 'otros_hechos'
                                                , 'control_grupo'=>2
                                                , 'control_default'=>$filtros->otros_hechos
                                                , 'control_multiple' => false
                                                , 'control_requerido' => false
                                                ,'control_resaltar' => true
                                                ,'control_vacio' => '[Mostrar todos]'
                                                //, 'control_vacio' => '[Ninguno]'
                                                , 'control_texto'=>'¿Sabe si participó en otros hechos de violencia?:'])
        </div>
        <div class="form-group col-sm-6">
            @include('controles.catalogo', ['control_control' => 'id_responsabilidad'
                                                    ,'control_id_cat'=>36
                                                    , 'control_default'=>$filtros->id_responsabilidad
                                                    , 'control_multiple'=>true
                                                    ,'control_otro' => true
                                                    ,'control_texto'=>'¿Cúal es la presunta responsabilidad en el hecho?'])
        </div>
    @endif
    <div class="w-100"></div>
    @if($tipo<>3)

        <div class="col-sm-3">
            @include('controles.catalogo', ['control_control' => 'id_discapacidad'
                                                    ,'control_id_cat'=>44
                                                    , 'control_default'=>$filtros->id_discapacidad
                                                    , 'control_multiple' => true
                                                    , 'control_requerido' => false
                                                    ,'control_resaltar' => true
                                                    //, 'control_vacio' => '[Ninguno]'
                                                    , 'control_texto'=>'Condición de discapacidad:'])
        </div>
        <div class="col-sm-3">
            @include('controles.catalogo', ['control_control' => 'id_edu_formal'
                                               ,'control_default' => $filtros->id_edu_formal
                                               ,'control_id_cat' => 46
                                              , 'control_multiple' => true
                                                , 'control_requerido' => false
                                                ,'control_resaltar' => true
                                               ,'control_texto'=>'Educación formal:'])
        </div>
    @endif
    @if($tipo==1)  {{-- Victima --}}
        <div class="col-sm-3">
            @include('controles.catalogo', ['control_control' => 'id_rel_victima'
                                   ,'control_id_cat'=>52
                                   , 'control_default'=>$filtros->id_rel_victima
                                   , 'control_multiple' => false
                                   , 'control_requerido' => false
                                   ,'control_resaltar' => true
                                   //, 'control_vacio' => '[Mostrar todos]'
                                   , 'control_texto'=>'Relación con la persona entrevistada'])
        </div>
        <div class="col-sm-3">
            @include('controles.criterio_fijo', ['control_control' => 'es_declarante'
                                   ,'control_grupo'=> 2
                                       ,'control_resaltar' => true
                                       , 'control_default'=>$filtros->es_declarante
                                       , 'control_vacio' => '[Mostrar todos]'
                                       ,'control_texto'=>'La víctima es la persona entrevistada:'])
        </div>
    @elseif($tipo==2)  {{-- Persona Entrevistada --}}
        <div class="col-sm-3">
            @include('controles.criterio_fijo', ['control_control' => 'es_victima'
                                   ,'control_grupo'=> 2
                                       ,'control_resaltar' => true
                                       , 'control_default'=>$filtros->es_victima
                                       , 'control_vacio' => '[Mostrar todos]'
                                       ,'control_texto'=>"La persona entrevistada, ¿es víctima de los hechos ($filtros->es_victima)?:"])
        </div>
        <div class="col-sm-3">
            @include('controles.criterio_fijo', ['control_control' => 'es_testigo'
                                  ,'control_grupo'=> 2
                                      ,'control_resaltar' => true
                                      , 'control_default'=>$filtros->es_testigo
                                      , 'control_vacio' => '[Mostrar todos]'
                                      ,'control_texto'=>'La persona entrevistada, ¿es testigo de los hechos?:'])


        </div>
    @elseif($tipo==3)  {{-- Presunto responsable individual --}}

        <div class="col-sm-3">

        </div>

    @endif


    <div class="w-100"></div>
</div>
