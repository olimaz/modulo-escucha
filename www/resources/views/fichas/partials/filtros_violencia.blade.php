@php
    //tipo: 1. Victima; 2. Persona entrevistada
    $tipo = isset($tipo) ? $tipo : 1;
@endphp
<div class="card card-info collapsed-card card-outline">
    <div class="card-header">
        <h3 class="card-title">
            @if($tipo==1)
                Filtros según violencia sufrida
            @elseif($tipo==2)
                Filtros según violencia narrada
            @elseif($tipo==3)
                Filtros según violencia ejercida
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
                <div class="col">
                    @include('controles.numero', ['control_control' => 'violencia_anio_del'
                                           , 'control_default'=>$filtros->violencia_anio_del
                                           ,'control_resaltar' => true
                                           ,'control_requerido' => false
                                           , 'control_min' =>1900
                                           , 'control_max' =>2020
                                           ,'control_texto'=>'Año de la violencia a partir de'])
                </div>
                <div class="col">
                    @include('controles.numero', ['control_control' => 'violencia_anio_al'
                                          , 'control_default'=>$filtros->violencia_anio_al
                                          ,'control_resaltar' => true
                                          ,'control_requerido' => false
                                          , 'control_min' =>1900
                                           , 'control_max' =>2020
                                          ,'control_texto'=>'Año de la violencia hasta'])

                </div>
            </div>
        </div>
        <div class="col-sm-12">
            @include('controles.tipo_violencia', ['control_control' => 'violencia_id_subtipo_violencia'
                   ,'control_resaltar' => true
                   , 'control_select2' => true
                   , 'control_default'=>$filtros->violencia_id_subtipo_violencia
                   , 'control_default_n1'=>$filtros->violencia_id_subtipo_violencia_depto
                   , 'control_vacio' => '[Mostrar todos]'
                   ,'control_texto'=>'Violencia'])
        </div>
        <div class="col-sm-12">
            @include('controles.geo3', ['control_control' => 'violencia_id_lugar'
                   ,'control_resaltar' => true
                   , 'control_default'=>$filtros->violencia_id_lugar

                   , 'control_vacio' => '[Mostrar todos]'
                   ,'control_texto'=>'Lugar de la violencia'])
        </div>
        <div class="w-100"></div>
        <div class="col-sm-12">
            @include('controles.tipo_aa', ['control_control' => 'violencia_id_subtipo_aa'
                                ,'control_default' => $filtros->violencia_id_subtipo_aa
                                , 'control_default_n1'=>$filtros->violencia_id_subtipo_aa_depto
                                , 'control_vacio' => '[Mostrar todos]'
                                ,'control_resaltar' => true
                               ,'control_texto'=>'Responsabilidad colectiva:'])
        </div>
        <div class="col-sm-12">
            @include('controles.tipo_tc', ['control_control' => 'violencia_id_subtipo_tc'
                                ,'control_default' => $filtros->violencia_id_subtipo_tc
                                 , 'control_default_n1'=>$filtros->violencia_id_subtipo_tc_depto
                                , 'control_vacio' => '[Mostrar todos]'
                                ,'control_resaltar' => true
                               ,'control_texto'=>'Responsabilidad colectiva:'])
        </div>
        <div class="w-100"></div>
        <div class="row">
            <div class="col-sm-6">
                @include('controles.criterio_fijo', ['control_control' => 'identifica_pri'
                                       ,'control_grupo'=> 2
                                           ,'control_resaltar' => true
                                           , 'control_default'=>$filtros->identifica_pri
                                           , 'control_vacio' => '[Mostrar todos]'
                                           ,'control_texto'=>'Identifica algún presunto responsable individual:'])
            </div>
            <div class="col-sm-6">
                @include('controles.criterio_fijo', ['control_control' => 'hay_ficha_exilio'
                                       ,'control_grupo'=> 2
                                           ,'control_resaltar' => true
                                           , 'control_default'=>$filtros->hay_ficha_exilio
                                           , 'control_vacio' => '[Mostrar todos]'
                                           ,'control_texto'=>'Incluye ficha de exilio:'])
            </div>
        </div>
    </div>
</div>