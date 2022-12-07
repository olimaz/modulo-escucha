{{-- Metadatos (información de la entrevista) --}}

<div class="card card-info collapsed-card card-outline">
    <div class="card-header">
        <h3 class="card-title">Filtros según metadatos y priorización </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <h4>Metadatos</h4>
        <div class="row">
            {{-- codigo de entrevista --}}
            <div class="col-md-6">
                @include('controles.texto', ['control_control' => 'entrevista_codigo'

                                           ,'control_resaltar' => true
                                           , 'control_default'=>$filtros->entrevista_codigo

                                           , 'control_requerido' => false
                                           //,'control_vacio' => "[Mostrar todos]"
                                           ,'control_texto'=>'Código de la entrevista:'])

            </div>
            {{-- Lugar de la entrevista --}}
            <div class="col-md-12 ">
                <label>Territorial</label>
                @include('controles.cev2', ['control_control' => 'id_territorio'
                                        ,'control_vacio' => "[Mostrar todos]"
                                        ,'control_resaltar' => true
                                       , 'control_territorio'=>$filtros->id_territorio
                                       , 'control_macroterritorio'=>$filtros->id_territorio_macro])
            </div>
            <div class="col-md-12">
                @include('controles.geo3', ['control_control' => 'id_entrevista_lugar'
                              ,'control_texto' => 'Lugar de la entrevista:'
                              ,'control_resaltar' => true
                              ,'control_vacio' => '[Mostrar todos]'
                              , 'control_default'=>$filtros->id_entrevista_lugar])
            </div>
            <div class="col-md-12">
                @include('controles.criterio_fijo', ['control_control' => 'id_etnico'
                                           ,'control_default' => $filtros->id_etnico
                                           ,'control_resaltar' => true
                                           ,'control_grupo' => 2
                                           ,'control_vacio' => "[Mostrar todos]"
                                           ,'control_texto'=>'Esta es una entrevista de interés étnico:'])
            </div>
            <div class="col-md-12 ">
                @include('controles.autofill', ['control_control' => 'titulo'
                                         ,'control_url' => 'autofill/vi_titulo'
                                         ,'control_default' => $filtros->titulo
                                         ,'control_texto'=>'Título:'])
            </div>

            <div class="col-md-12 ">
                @include('controles.autofill', ['control_control' => 'dinamica'
                                         ,'control_url' => 'autofill/vi_dinamica'
                                         ,'control_default' => $filtros->dinamica
                                         ,'control_texto'=>'Dinámicas:'])
            </div>
            <div class="col-md-12">
                @include('controles.catalogo', ['control_control' => 'id_sector'
                                           ,'control_id_cat'=>18
                                           ,'control_resaltar' => true
                                           , 'control_default'=>$filtros->id_sector
                                           , 'control_multiple'=>true
                                           , 'control_requerido' => false
                                           //,'control_vacio' => "[Mostrar todos]"
                                           ,'control_texto'=>'Sector con el que se puede identificar a las víctimas en el relato:'])
            </div>
            <div class="col-md-12">
                @include('controles.catalogo', ['control_control' => 'interes'
                                                     ,'control_id_cat'=>[13,19]
                                                     ,'control_resaltar' => true
                                                     , 'control_default'=>$filtros->interes
                                                     , 'control_multiple' => true
                                                     , 'control_requerido' => false
                                                     //, 'control_vacio' => '[Mostrar todos]'
                                                     ,'control_texto'=>'Es de utilidad para el/los núcleo/s de:'])
            </div>
            <div class="col-md-12">
                @include('controles.catalogo', ['control_control' => 'interes_area'
                                            ,'control_id_cat'=>85
                                            ,'control_resaltar' => true
                                            , 'control_default'=>$filtros->interes_area
                                            , 'control_multiple'=>true
                                            //, 'control_vacio'=>'Mostrar todos'
                                            , 'control_requerido' => false
                                            ,'control_texto'=>'Puede ser de utilidad para el/las área/s de:'])
            </div>
            <div class="col-md-12 ">
                @include('controles.catalogo', ['control_control' => 'mandato'
                                                     ,'control_id_cat'=>15
                                                     ,'control_resaltar' => true
                                                     , 'control_default'=>$filtros->mandato
                                                     , 'control_multiple' => true
                                                     , 'control_requerido' => false
                                                     ,'control_resaltar' => true
                                                     //, 'control_vacio' => '[Mostrar todos]'
                                                     ,'control_texto'=>'Aspectos del mandato:'])
            </div>
            {{-- Priorización --}}
            <div class="w-100"></div>
            <h4>Priorización</h4>
            <div class="w-100"></div>
            <div class="col-md-6 ">
                @include('controles.criterio_fijo', ['control_control' => 'fluidez'
                                       ,'control_grupo'=>25
                                       , 'control_resaltar' => true
                                       , 'control_vacio' => '[Mostrar todos]'
                                       , 'control_default'=> $filtros->fluidez
                                       ,'control_texto'=>'La entrevista se desarrolla con fluidez:'])
            </div>
            <div class="col-md-6 ">
                @include('controles.criterio_fijo', ['control_control' => 'cierre'
                                       ,'control_grupo'=>25
                                       , 'control_resaltar' => true
                                       , 'control_vacio' => '[Mostrar todos]'
                                       , 'control_default'=>$filtros->cierre
                                       ,'control_texto'=>'Se realiza un cierre al final de la entrevista:'])
            </div>


            <div class="col-md-12 ">
                @include('controles.criterio_fijo', ['control_control' => 'd_hecho'
                                       ,'control_grupo'=>26
                                       , 'control_resaltar' => true
                                       , 'control_vacio' => '[Mostrar todos]'
                                       , 'control_default'=>$filtros->d_hecho
                                       ,'control_texto'=>'Nivel de detalle de los hechos:'])
            </div>
            <div class="col-md-12 ">
                @include('controles.criterio_fijo', ['control_control' => 'd_contexto'
                                       ,'control_grupo'=>26
                                       , 'control_resaltar' => true
                                       , 'control_vacio' => '[Mostrar todos]'
                                       , 'control_default'=>$filtros->d_contexto
                                       ,'control_texto'=>'Nivel de de detalle del contexto:'])
            </div>
            <div class="col-md-12 ">
                @include('controles.criterio_fijo', ['control_control' => 'd_impacto'
                                       ,'control_grupo'=>26
                                       , 'control_resaltar' => true
                                       , 'control_vacio' => '[Mostrar todos]'
                                       , 'control_default'=>$filtros->d_impacto
                                       ,'control_texto'=>'Nivel de de detalle de los impactos:'])
            </div>
            <div class="col-md-12 ">
                @include('controles.criterio_fijo', ['control_control' => 'd_justicia'
                                       ,'control_grupo'=>26
                                       , 'control_resaltar' => true
                                       , 'control_vacio' => '[Mostrar todos]'
                                       , 'control_default'=>$filtros->d_justicia
                                       ,'control_texto'=>'Acceso a la justicia e iniciativas de no repetición:'])
            </div>
        </div>
    </div>
</div>