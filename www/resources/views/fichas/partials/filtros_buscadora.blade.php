<div class="card card-outline card-info collapsed-card">
    <div class="card-header">
        <h3 class="card-title">
            Buscadora: transcripción, etiquetado, marcas, listados
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>

    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                @include('controles.texto', ['control_control' => 'fts'
                                                          ,'control_resaltar' => true
                                                          , 'control_default'=>$filtros->fts
                                                          , 'control_requerido' => false
                                                          ,'control_texto'=>'Buscar en la transcripción:'])
                <div class="text-center" style="margin-top: -15px; margin-bottom: 10px">
                    <span class="text-muted text-sm"><b>Tip:</b>  Para búsquedas exactas indicar la frase entre comillas.  Ej.: "líder sindical".  </span>
                </div>

            </div>
            <div class="col-md-12">
                <label>Buscar según el etiquetado:</label>
                @include('controles.tesauro3', ['control_control' => 'id_tesauro'
                                            , 'control_default'=>$filtros->id_tesauro
                                            , 'control_resaltar'=> true
                                            , 'control_vacio' => '[Mostrar todos]'
                                           //,'control_texto'=>'Buscadora. Buscar por etiquetado'
                                           ])

            </div>

            {{-- Marcas --}}
            <div class="col-md-12">
                @include('controles.marca', ['control_control' => 'marca'
                                                         , 'control_id'=>"marca_frm_filtro"
                                                         , 'control_nuevos' => false
                                                         , 'control_mostrar_grupo' => true
                                                         , 'control_default' => $filtros->marca
                                                        ,'control_texto'=>'Marcadas como:'])
            </div>
            {{-- Listados  --}}
            <div class="col-md-12">
                @include('controles.listado_excel', ['control_control' => 'id_excel_listados'
                                                    ,'control_default' => $filtros->id_excel_listados
                                                    , 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_resaltar' => true
                                                    ,'control_select2' => true
                                                   ,'control_texto'=>'Utilizar listados de códigos'])
            </div>
        </div>

    </div>
</div>