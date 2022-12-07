@php($frm_id = isset($frm_id) ? $frm_id : "frm_avanzado")
@php($ocultar_tes = isset($ocultar_tes) ? $ocultar_tes : false)
@php($mostrar_filtro_excel = isset($mostrar_filtro_excel) ? $mostrar_filtro_excel : false)
<div class="box box-default  {{ $filtros->hay_filtro_buscadora ? "  " : " collapse " }}" id="{{ $frm_id }}">
    <div class="box-body">
        @if(!$ocultar_tes)
            <div class="col-sm-12">
                @include('controles.tesauro3', ['control_control' => 'id_tesauro_2'
                                                    ,'control_id' => 'id_tesauro_2'.$frm_id
                                                    , 'control_default'=>$filtros->id_tesauro_2
                                                    , 'control_vacio' => '[Sin especificar]'
                                                    ,'control_resaltar' => true
                                                   ,'control_texto'=>'Etiquetadas con:'])
            </div>
            <div class="col-sm-12">
                @include('controles.tesauro3', ['control_control' => 'id_tesauro_3'
                                                    ,'control_id' => 'id_tesauro_3'.$frm_id
                                                    , 'control_default'=>$filtros->id_tesauro_3
                                                    , 'control_vacio' => '[Sin especificar]'
                                                    ,'control_resaltar' => true
                                                   ,'control_texto'=>'Etiquetadas con:'.$filtros->id_tesauro_3])
            </div>
            <div class="clearfix"></div>
            <hr>
        @endif
        {{-- Interés, mandato --}}
        <div class="col-md-6 ">
            @include('controles.catalogo', ['control_control' => 'mandato'
                                                ,'control_id' => 'mandato'.$frm_id
                                                 ,'control_id_cat'=>15
                                                 ,'control_resaltar' => true
                                                 , 'control_default'=>$filtros->mandato
                                                 , 'control_multiple' => true
                                                 , 'control_requerido' => false
                                                 ,'control_resaltar' => true
                                                 //, 'control_vacio' => '[Mostrar todos]'
                                                 ,'control_texto'=>'Coincide con estos aspectos del mandato:'])
        </div>
        <div class="col-md-6 ">
            @include('controles.catalogo', ['control_control' => 'interes'
                                                ,'control_id' => 'interes'.$frm_id
                                                    ,'control_id_cat'=>[19,85]
                                                    ,'control_resaltar' => true
                                                    , 'control_default'=>$filtros->interes
                                                    , 'control_multiple' => true
                                                    , 'control_requerido' => false
                                                    //, 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_texto'=>'Puede ser de utilidad para:'])
        </div>

        <div class="clearfix"></div>
        <div class="col-md-4">
                @include('controles.criterio_fijo', ['control_control' => 'id_etnico'
                                            ,'control_id' => 'id_etnico'.$frm_id
                                           ,'control_default' => $filtros->id_etnico
                                           ,'control_resaltar' => true
                                           ,'control_grupo' => 2
                                           ,'control_vacio' => "[Mostrar todos]"
                                           ,'control_texto'=>'Esta es una entrevista de interés étnico (aplica a entrevistas a VI, AA, TC):'])
        </div>
        <div class="col-md-4">
            @include('controles.catalogo', ['control_control' => 'id_sector'
                                    ,'control_id' => 'id_sector'.$frm_id
                                       ,'control_id_cat'=>18
                                       ,'control_resaltar' => true
                                       , 'control_default'=>$filtros->id_sector
                                       , 'control_multiple'=>true
                                       , 'control_requerido' => false
                                       //,'control_vacio' => "[Mostrar todos]"
                                       ,'control_texto'=>'Sector con el que se puede identificar a las víctimas en el relato:'])
        </div>
            @if($mostrar_filtro_excel)
            {{-- Listados  --}}
            <div class="col-md-4">
                @include('controles.listado_excel', ['control_control' => 'id_excel_listados'
                                                    ,'control_default' => $filtros->id_excel_listados
                                                    , 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_resaltar' => true
                                                    ,'control_select2' => true
                                                   ,'control_texto'=>'Utilizar listados de códigos'])
            </div>
            @endif
        <div class="clearfix"></div>

        {{-- Otros --}}




        {{-- PRIORIDAD --}}
        <hr>
        {{--
        <div class="col-md-6 ">
            @include('controles.autofill', ['control_control' => 'ahora_entiendo'
                                             ,'control_url' => "autofill/99/pri_comprendo"
                                             , 'control_resaltar' => true
                                             ,'control_default' => $filtros->ahora_entiendo
                                             ,'control_texto'=>'Esta entrevista me permitió comprender lo siguiente'])
        </div>
        <div class="col-md-6 ">
            @include('controles.autofill', ['control_control' => 'cambio_perspectiva'
                                             ,'control_url' => "autofill/99/pri_cambio"
                                             , 'control_resaltar' => true
                                             ,'control_default' => $filtros->cambio_perspectiva
                                             ,'control_texto'=>'Esta entrevista ofrece explicaciones alternativas acerca de'])

        </div>
        <div class="clearfix"></div>
        --}}
        <div class="col-md-3 ">
            @include('controles.criterio_fijo', ['control_control' => 'd_hecho_min'
                                   ,'control_id'=> 'd_hecho_min'.$frm_id
                                   ,'control_grupo'=>26
                                   , 'control_resaltar' => true
                                   , 'control_vacio' => '[Mostrar todos]'
                                   , 'control_default'=>$filtros->d_hecho_min
                                   ,'control_texto'=>'Nivel mínimo del detalle de los hechos:'])
        </div>
        <div class="col-md-3 ">
            @include('controles.criterio_fijo', ['control_control' => 'd_contexto_min'
                                   ,'control_id'=> 'd_contexto_min'.$frm_id
                                   ,'control_grupo'=>26
                                   , 'control_resaltar' => true
                                   , 'control_vacio' => '[Mostrar todos]'
                                   , 'control_default'=>$filtros->d_contexto_min
                                   ,'control_texto'=>'Nivel mínimo del detalle de contexto:'])
        </div>
        <div class="col-md-3 ">
            @include('controles.criterio_fijo', ['control_control' => 'd_impacto_min'
                                   ,'control_id'=> 'd_impacto_min'.$frm_id
                                   ,'control_grupo'=>26
                                   , 'control_resaltar' => true
                                   , 'control_vacio' => '[Mostrar todos]'
                                   , 'control_default'=>$filtros->d_impacto_min
                                   ,'control_texto'=>'Nivel mínimo del detalle de los impactos:'])
        </div>
        <div class="col-md-3 ">
            @include('controles.criterio_fijo', ['control_control' => 'd_justicia_min'
                                   ,'control_id'=> 'd_justicia_min'.$frm_id
                                   ,'control_grupo'=>26
                                   , 'control_resaltar' => true
                                   , 'control_vacio' => '[Mostrar todos]'
                                   , 'control_default'=>$filtros->d_justicia_min
                                   ,'control_texto'=>'Nivel mínimo del detalle de acceso a la justicia y no repetición:'])
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="box-footer text-center">
        <button class="btn bg-purple " type="submit">¡Búscamelo! <i class="fa fa-magic"></i></button>
    </div>
</div>