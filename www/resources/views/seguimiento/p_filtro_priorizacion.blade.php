@php
    $filtros->fluidez = isset($filtros->fluidez) ? $filtros->fluidez : -1;
    $filtros->cierre = isset($filtros->cierre) ? $filtros->cierre : -1;
    $filtros->d_hecho = isset($filtros->d_hecho) ? $filtros->d_hecho : -1;
    $filtros->d_contexto = isset($filtros->d_contexto) ? $filtros->d_contexto : -1;
    $filtros->d_impacto = isset($filtros->d_impacto) ? $filtros->d_impacto : -1;
    $filtros->d_justicia = isset($filtros->d_justicia) ? $filtros->d_justicia : -1;
    $filtros->ahora_entiendo = isset($filtros->ahora_entiendo) ? $filtros->ahora_entiendo : "";
    $filtros->cambio_perspectiva = isset($filtros->cambio_perspectiva) ? $filtros->cambio_perspectiva : "";
    $filtros->tipo_prioridad = isset($filtros->tipo_prioridad) ? $filtros->tipo_prioridad : -1;
    $filtros->id_subserie = isset($filtros->id_subserie) ? $filtros->id_subserie : 0;
@endphp
<div class="row">
    <div class="col-md-3 ">
        @include('controles.criterio_fijo', ['control_control' => 'tipo_prioridad'
                               ,'control_grupo'=>24
                               , 'control_vacio' => '[Mostrar todos]'
                               , 'control_resaltar' => true
                               , 'control_default'=> $filtros->tipo_prioridad
                               ,'control_texto'=>'Priorización establecida por:'])
    </div>
    <div class="col-md-3 ">
        @include('controles.criterio_fijo', ['control_control' => 'fluidez'
                               ,'control_grupo'=>25
                               , 'control_resaltar' => true
                               , 'control_vacio' => '[Mostrar todos]'
                               , 'control_default'=> $filtros->fluidez
                               ,'control_texto'=>'La entrevista se desarrolla con fluidez:'])
    </div>
    <div class="col-md-3 ">
        @include('controles.criterio_fijo', ['control_control' => 'cierre'
                               ,'control_grupo'=>25
                               , 'control_resaltar' => true
                               , 'control_vacio' => '[Mostrar todos]'
                               , 'control_default'=>$filtros->cierre
                               ,'control_texto'=>'Se realiza un cierre al final de la entrevista:'])
    </div>

    <div class="clearfix"></div>

    <div class="col-md-3 ">
            @include('controles.criterio_fijo', ['control_control' => 'd_hecho'
                                   ,'control_grupo'=>26
                                   , 'control_resaltar' => true
                                   , 'control_vacio' => '[Mostrar todos]'
                                   , 'control_default'=>$filtros->d_hecho
                                   ,'control_texto'=>'Nivel de detalle de los hechos:'])
    </div>
    <div class="col-md-3 ">
            @include('controles.criterio_fijo', ['control_control' => 'd_contexto'
                                   ,'control_grupo'=>26
                                   , 'control_resaltar' => true
                                   , 'control_vacio' => '[Mostrar todos]'
                                   , 'control_default'=>$filtros->d_contexto
                                   ,'control_texto'=>'Nivel de de detalle del contexto:'])
    </div>
    <div class="col-md-3 ">
            @include('controles.criterio_fijo', ['control_control' => 'd_impacto'
                                   ,'control_grupo'=>26
                                   , 'control_resaltar' => true
                                   , 'control_vacio' => '[Mostrar todos]'
                                   , 'control_default'=>$filtros->d_impacto
                                   ,'control_texto'=>'Nivel de de detalle de los impactos:'])
    </div>
    <div class="col-md-3 ">
            @include('controles.criterio_fijo', ['control_control' => 'd_justicia'
                                   ,'control_grupo'=>26
                                   , 'control_resaltar' => true
                                   , 'control_vacio' => '[Mostrar todos]'
                                   , 'control_default'=>$filtros->d_justicia
                                   ,'control_texto'=>'Acceso a la justicia e iniciativas de no repetición:'])
    </div>
    <div class="clearfix"></div>


    <div class="col-md-6 ">
        @include('controles.autofill', ['control_control' => 'ahora_entiendo'
                                         ,'control_url' => "autofill/$filtros->id_subserie/pri_comprendo"
                                         , 'control_resaltar' => true
                                         ,'control_default' => $filtros->ahora_entiendo
                                         ,'control_texto'=>'Esta entrevista me permitió comprender lo siguiente'])
    </div>
    <div class="col-md-6 ">
        @include('controles.autofill', ['control_control' => 'cambio_perspectiva'
                                         ,'control_url' => "autofill/$filtros->id_subserie/pri_cambio"
                                         , 'control_resaltar' => true
                                         ,'control_default' => $filtros->cambio_perspectiva
                                         ,'control_texto'=>'Esta entrevista ofrece explicaciones alternativas acerca de'])

    </div>
</div>
        
