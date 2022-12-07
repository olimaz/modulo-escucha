@php
    //tipo: 1. Victima; 2. Persona entrevistada
    $tipo = isset($tipo) ? $tipo : 1;
@endphp

<div class="card card-info collapsed-card card-outline">
    <div class="card-header">

            <h3 class="card-title {{ count($filtros->id_impacto)>0 ? 'text-success': '' }}">
                @if($tipo==1)
                    Filtros según contexto de los hechos
                @elseif($tipo>=2)
                    Filtros según contexto de los hechos narrados
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
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_contexto'
                                                              ,'control_id'=>'id_contexto_1'
                                                              ,'control_id_cat'=>127
                                                              , 'control_multiple' => true
                                                              , 'control_resaltar' => false
                                                              , 'control_requerido' => false
                                                              , 'control_default' => $filtros->id_contexto
                                                              ,'control_texto'=>'1. Motivos específicos por los cuales cree que ocurrieron los hechos:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_contexto'
                                                              ,'control_id'=>'id_contexto_2'
                                                              ,'control_id_cat'=>128
                                                              , 'control_multiple' => true
                                                              , 'control_resaltar' => false
                                                              , 'control_requerido' => false
                                                              , 'control_default' => $filtros->id_contexto
                                                              ,'control_texto'=>'2. Contexto de control territorial y/o de la población:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_contexto'
                                                              ,'control_id'=>'id_contexto_3'
                                                              ,'control_id_cat'=>129
                                                              , 'control_multiple' => true
                                                              , 'control_resaltar' => false
                                                              , 'control_requerido' => false
                                                              , 'control_default' => $filtros->id_contexto
                                                              ,'control_texto'=>'3. Si los hechos ocurrieron en lugares públicos, indique si dicho espacio es significativo para:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_contexto'
                                                              ,'control_id'=>'id_contexto_4'
                                                              ,'control_id_cat'=>130
                                                              , 'control_multiple' => true
                                                              , 'control_resaltar' => false
                                                              , 'control_requerido' => false
                                                              , 'control_default' => $filtros->id_contexto
                                                              ,'control_texto'=>'4. Factores externos que influenciaron en los hechos:'])
                </div>
                <div class="form-group col-xs-12">
                    @include('controles.catalogo', ['control_control' => 'id_contexto'
                                                              ,'control_id'=>'id_contexto_5'
                                                              ,'control_id_cat'=>131
                                                              , 'control_multiple' => true
                                                              , 'control_resaltar' => false
                                                              , 'control_requerido' => false
                                                              , 'control_default' => $filtros->id_contexto
                                                              ,'control_texto'=>'5. La persona entrevistada considera que estos hechos violentos beneficiaron a:'])
                </div>
            </div>
        </div>
    </div>
</div>