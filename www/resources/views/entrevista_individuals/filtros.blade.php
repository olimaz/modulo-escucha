<?php
//Para que no truene nunca
if(!isset($filtros)) {
    $filtros = \App\Models\entrevista_individual::filtros_default();
}
?>
<div class="box box-default collapsed-box box-solid">
    <div class="box-header ">
        <h3 class="box-title"><i class="fa fa-filter" aria-hidden="true"></i> Entrevistas: Filtrar la informaci&oacute;n visualizada</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        {{ Form::model($filtros,array('url' =>"#",'method' => 'get')) }}
        {!! Form::hidden('id_subserie', null) !!}

        {{-- Correlativo, codigo, entrevistador y macro --}}
        <div class="row">
            <div class="col-md-3 ">
                <div class="form-group {{ $filtros->entrevista_correlativo ? ' has-success ' : '' }}">
                    <label># Entrevista</label>
                    {!! Form::number('entrevista_correlativo', null, ['class' => 'form-control','max'=>10000000]) !!}
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="form-group {{ $filtros->entrevista_codigo ? ' has-success ' : '' }}">
                    <label>Código Entrevista</label>
                    {!! Form::text('entrevista_codigo', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-md-3 ">
                    @include('controles.entrevistador_todos', ['control_control' => 'id_entrevistador'
                                           , 'control_default'=>$filtros->id_entrevistador
                                           , 'control_vacio' => '[Mostrar todos]'
                                           ,'control_resaltar' => true
                                           , 'control_deshabilitados' => true
                                           ,'control_texto'=>'Entrevistador'])
            </div>
            <div class="col-md-3 ">
                <div class="form-group">
                    @include('controles.criterio_fijo', ['control_control' => 'id_grupo'
                                           ,'control_grupo'=>5
                                           ,'control_resaltar' => true
                                           , 'control_default'=>$filtros->id_grupo
                                           , 'control_vacio' => '[Mostrar todos]'
                                           ,'control_texto'=>'Grupo'])
                </div>
            </div>


                <div class="col-md-6 ">
                    <div class="form-group">
                        @include('controles.cev2', ['control_control' => 'id_territorio'
                                                ,'control_vacio' => "[Mostrar todos]"
                                                ,'control_resaltar' => true
                                               , 'control_territorio'=>$filtros->id_territorio
                                               , 'control_macroterritorio'=>$filtros->id_macroterritorio])
                    </div>
                </div>
                @if($filtros->id_subserie==config('expedientes.vi'))
                    <div class="col-md-3">
                        @include('controles.criterio_fijo', ['control_control' => 'nna'
                                                ,'control_default' => $filtros->nna
                                                ,'control_grupo' => 2
                                                ,'control_resaltar' => true
                                                ,'control_vacio' => "Mostrar todos"
                                                ,'control_texto'=>'Esta es una entrevista NNA'])
                    </div>
                @endif
            <div class="col-md-3">
                @include('controles.criterio_fijo', ['control_control' => 'con_problemas'
                                           ,'control_default' => $filtros->con_problemas
                                           ,'control_grupo' => 2
                                           ,'control_resaltar' => true
                                           ,'control_vacio' => "[Mostrar todos]"
                                           ,'control_texto'=>"Reportan algún problema de procesamiento"])

            </div>



            <div class="clearfix"></div>
            @can('nivel-10')
                <div class="col-md-3">
                    @include('controles.criterio_fijo', ['control_control' => 'transcrita'
                                               ,'control_default' => $filtros->transcrita
                                               ,'control_grupo' => 8
                                               ,'control_resaltar' => true
                                               ,'control_vacio' => "Mostrar todos"
                                               ,'control_nulo' => "Sin asignar"
                                               ,'control_texto'=>"Asignación para transcribir"])

                </div>
                <div class="col-md-3">
                    @include('controles.criterio_fijo', ['control_control' => 'etiquetada'
                                               ,'control_default' => $filtros->etiquetada
                                               ,'control_grupo' => 9
                                               ,'control_resaltar' => true
                                               ,'control_vacio' => "Mostrar todos"
                                               ,'control_nulo' => "Sin asignar"
                                               ,'control_texto'=>"Asignación para etiquetar"])

                </div>
            @endcan
            <div class="col-md-3">
                @include('controles.criterio_fijo', ['control_control' => 'con_transcripcion'
                                           ,'control_default' => $filtros->con_transcripcion
                                           ,'control_grupo' => 2
                                           ,'control_resaltar' => true
                                           ,'control_vacio' => "Mostrar todos"
                                           ,'control_texto'=>"Entrevista transcrita"])

            </div>
            <div class="col-md-3">
                @include('controles.criterio_fijo', ['control_control' => 'con_etiquetado'
                                           ,'control_default' => $filtros->con_etiquetado
                                           ,'control_grupo' => 2
                                           ,'control_resaltar' => true
                                           ,'control_vacio' => "Mostrar todos"
                                           ,'control_texto'=>"Entrevista etiquetada"])

            </div>
            <div class="col-md-3">
                @include('controles.criterio_fijo', ['control_control' => 'fichas_estado'
                                           ,'control_default' => $filtros->fichas_estado
                                           ,'control_grupo' => 40
                                           ,'control_resaltar' => true
                                           ,'control_vacio' => "Mostrar todos"
                                           //,'control_nulo' => "Sin asignar"
                                           ,'control_texto'=>"Fichas  diligenciadas"])

            </div>
            <div class="col-md-3">
                @include('controles.criterio_fijo', ['control_control' => 'id_cerrado'
                                           ,'control_default' => $filtros->id_cerrado
                                           ,'control_grupo' => 2
                                           ,'control_resaltar' => true
                                           ,'control_vacio' => "[Mostrar todos]"
                                           ,'control_texto'=>"Procesamiento finalizado"])

            </div>
            @can('nivel-1')
                <div class="col-md-3">
                    @include('controles.criterio_fijo', ['control_control' => 'id_activo'
                                           ,'control_default' => $filtros->id_activo
                                           ,'control_grupo' => 2
                                           ,'control_resaltar' => true
                                           ,'control_vacio' => "[Mostrar todos]"
                                           ,'control_texto'=>"Entrevista vigente (No: anulada)"])
                </div>
            @endcan
        </div>

        {{-- Priorización --}}
        <hr>
        @include("seguimiento.p_filtro_priorizacion")
        <hr>

        {{-- Fecha y lugar de la entrevista --}}
        <div class="row">
            <div class="col-md-2 ">
                <div class="form-group">
                    <label>F. de la entrevista:</label>
                    @include('controles.fecha', ['control_control' => 'entrevista_del'
                                 ,'control_default' => $filtros->entrevista_del
                                 ,'control_resaltar' => true
                                       ,'control_texto'=>'Del:'])
                </div>
            </div>
            <div class="col-md-2">
                <label>F. de la entrevista:</label>
                @include('controles.fecha', ['control_control' => 'entrevista_al'
                                 ,'control_default' => $filtros->entrevista_al
                                 ,'control_resaltar' => true
                                       ,'control_texto'=>'Al:'])
            </div>
            <div class="col-md-8">
                @include('controles.geo3', ['control_control' => 'entrevista_lugar'
                               ,'control_texto' => 'Lugar de la entrevista:'
                               ,'control_resaltar' => true
                               ,'control_vacio' => '[Mostrar todos]'
                               , 'control_default'=>$filtros->entrevista_lugar])
            </div>
        </div>
        {{-- Fecha y lugar de los hechos --}}
        <div class="row">
            <div class="col-md-2 ">
                <div class="form-group">
                    <label>F. de los hechos</label>
                    @include('controles.fecha', ['control_control' => 'hechos_del'
                                 ,'control_default' => $filtros->hechos_del
                                 ,'control_resaltar' => true
                                 ,'control_texto'=>'Del:'])
                </div>
            </div>
            <div class="col-md-2">
                <label>F. de los hechos</label>
                @include('controles.fecha', ['control_control' => 'hechos_al'
                                 ,'control_default' => $filtros->hechos_al
                                 ,'control_resaltar' => true
                                       ,'control_texto'=>'Al:'])
            </div>
            <div class="col-md-8">
                @include('controles.geo3', ['control_control' => 'hechos_lugar'
                               ,'control_texto' => 'Lugar de los hechos'
                               ,'control_resaltar' => true
                               ,'control_vacio' => '[Mostrar todos]'
                               , 'control_default'=>$filtros->hechos_lugar])
            </div>
        </div>
        {{-- Periodo de los hechos --}}
        <div class="row">
            <div class="col-md-6">
                @include('controles.criterio_fijo', ['control_control' => 'id_periodo'
                                           ,'control_default' => $filtros->id_periodo
                                           ,'control_grupo' => 60
                                           ,'control_resaltar' => true
                                           ,'control_vacio' => "[Mostrar todos]"
                                           ,'control_texto'=>"Período de ocurrencia de los hechos"])

            </div>
        </div>

        <div class="clearfix"></div>

        <hr>

        <div class="row">
            {{--
            <div class="col-md-3 ">
                @include('controles.catalogo', ['control_control' => 'id_remitido'
                                              ,'control_default' => $filtros->id_remitido
                                              ,'control_id_cat' => 33
                                              ,'control_vacio' => "[Mostrar todos]"
                                              ,'control_resaltar' => true
                                              ,'control_texto'=>'Esta es una entrevista remitida por:'])
            </div>
            --}}
            <div class="col-md-3">
                @include('controles.criterio_fijo', ['control_control' => 'id_etnico'
                                           ,'control_default' => $filtros->id_etnico
                                           ,'control_resaltar' => true
                                           ,'control_grupo' => 2
                                           ,'control_vacio' => "[Mostrar todos]"
                                           ,'control_texto'=>'Esta es una entrevista de interés étnico:'])
            </div>
            <div class="col-md-3">
                @include('controles.catalogo', ['control_control' => 'id_sector'
                                           ,'control_id_cat'=>18
                                           ,'control_resaltar' => true
                                           , 'control_default'=>$filtros->id_sector
                                           , 'control_multiple'=>true
                                           , 'control_requerido' => false
                                           //,'control_vacio' => "[Mostrar todos]"
                                           ,'control_texto'=>'Sector con el que se puede identificar a las víctimas en el relato:'])
            </div>
            <div class="col-md-3">
                @include('controles.criterio_fijo', ['control_control' => 'id_prioritario'
                                           ,'control_default' => $filtros->id_prioritario
                                           ,'control_grupo' => 2
                                           ,'control_resaltar' => true
                                           ,'control_vacio' => "Mostrar todos"
                                           ,'control_texto'=>"Incluye temas poco documentados"])

            </div>
            <div class="col-md-3 ">
                @include('controles.autofill', ['control_control' => 'prioritario_tema'
                                         ,'control_url' => 'autofill/vi_prioridad'
                                         ,'control_default' => $filtros->prioritario_tema
                                         ,'control_texto'=>'Temas con escasa documentación:'])
            </div>
        </div>
        <div class="row">
            <div class="clearfix"></div>

            <div class="col-md-3 ">
                @include('controles.autofill', ['control_control' => 'titulo'
                                         ,'control_url' => 'autofill/vi_titulo'
                                         ,'control_default' => $filtros->titulo
                                         ,'control_texto'=>'Título:'])
            </div>
            <div class="col-md-3 ">
                @include('controles.autofill', ['control_control' => 'anotaciones'
                                         ,'control_url' => 'autofill/vi_anotaciones'
                                         ,'control_default' => $filtros->anotaciones
                                         ,'control_texto'=>'Anotaciones:'])
            </div>
            <div class="col-md-3 ">
                @include('controles.autofill', ['control_control' => 'dinamica'
                                         ,'control_url' => 'autofill/vi_dinamica'
                                         ,'control_default' => $filtros->dinamica
                                         ,'control_texto'=>'Dinámicas:'])
            </div>
            <div class="col-md-3 ">
                @include('controles.autofill', ['control_control' => 'observaciones_diligenciada'
                                         ,'control_url' => 'autofill/vi_observaciones_diligenciada'
                                         ,'control_default' => $filtros->observaciones_diligenciada
                                         ,'control_texto'=>'Anotaciones al diligenciar fichas:'])
            </div>




        </div>
        <div class="row">


            @if($filtros->id_subserie==config('expedientes.vi'))

                <div class="col-sm-3">
                    @include('controles.catalogo', ['control_control' => 'fr'
                                                        ,'control_id_cat'=>4
                                                        ,'control_resaltar' => true
                                                        , 'control_default'=>$filtros->fr
                                                        , 'control_multiple' => true
                                                        , 'control_requerido' => false

                                                        ,'control_texto'=>'Responsable/Participante:'])
                </div>

                <div class="col-sm-3">
                    @include('controles.catalogo', ['control_control' => 'tv'
                                                        ,'control_id_cat'=>5
                                                        ,'control_resaltar' => true
                                                        , 'control_default'=>$filtros->tv
                                                        , 'control_multiple' => true
                                                        , 'control_requerido' => false

                                                        ,'control_texto'=>'Violencia registrada:'])
                </div>
            @elseif($filtros->id_subserie==config('expedientes.aa'))
                <div class="col-sm-3">
                    @include('controles.catalogo', ['control_control' => 'fr'
                                                        ,'control_id_cat'=>4
                                                        ,'control_resaltar' => true
                                                        , 'control_default'=>$filtros->fr
                                                        , 'control_multiple' => true
                                                        , 'control_requerido' => false

                                                        ,'control_texto'=>'Fuerzas en las que hace/hacía parte:'])
                </div>
                <div class="col-sm-3">
                    @include('controles.catalogo', ['control_control' => 'aa'
                                                        ,'control_id_cat'=>8
                                                        ,'control_resaltar' => true
                                                        , 'control_default'=>$filtros->aa
                                                        , 'control_multiple' => true
                                                        , 'control_requerido' => false
                                                        ,'control_texto'=>'Temas abordados:'])
                </div>
            @elseif($filtros->id_subserie==config('expedientes.tc'))
                <div class="col-sm-3">
                    @include('controles.catalogo', ['control_control' => 'stc'
                                                        ,'control_id_cat'=>10
                                                        ,'control_resaltar' => true
                                                        , 'control_default'=>$filtros->stc
                                                        , 'control_multiple' => true
                                                        , 'control_requerido' => false
                                                        ,'control_texto'=>'Sectores en los que hace/hacía parte:'])
                </div>
                <div class="col-sm-3">
                    @include('controles.catalogo', ['control_control' => 'tc'
                                                        ,'control_id_cat'=>9
                                                        ,'control_resaltar' => true
                                                        , 'control_default'=>$filtros->tc
                                                        , 'control_multiple' => true
                                                        , 'control_requerido' => false
                                                        ,'control_texto'=>'Temas abordados:'])
                </div>
            @endif
            <div class="col-md-6 ">
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




        </div>
        <div class="clearfix"></div>
        <div class="row">


            <div class="col-md-6">
                @include('controles.catalogo', ['control_control' => 'interes'
                                                     ,'control_id_cat'=>[13,19]
                                                     ,'control_resaltar' => true
                                                     , 'control_default'=>$filtros->interes
                                                     , 'control_multiple' => true
                                                     , 'control_requerido' => false
                                                     //, 'control_vacio' => '[Mostrar todos]'
                                                     ,'control_texto'=>'Es de utilidad para el/los núcleo/s de:'])
            </div>
            <div class="col-md-6">
                @include('controles.catalogo', ['control_control' => 'interes_area'
                                            ,'control_id_cat'=>85
                                            ,'control_resaltar' => true
                                            , 'control_default'=>$filtros->interes_area
                                            , 'control_multiple'=>true
                                            //, 'control_vacio'=>'Mostrar todos'
                                            , 'control_requerido' => false
                                            ,'control_texto'=>'Puede ser de utilidad para el/las área/s de:'])
            </div>
        </div>
        {{-- FULL TEXT SEARCH --}}
        <div class="clearfix"></div>
        <div class="row">
            {{-- Buscadora --}}
            <div class="col-md-4">
                @include('controles.texto', ['control_control' => 'fts'
                                                          ,'control_resaltar' => true
                                                          , 'control_default'=>$filtros->fts
                                                          , 'control_requerido' => false
                                                          ,'control_texto'=>'Buscadora. Buscar en la transcripción:'])
            </div>
            {{-- Marcas --}}
            <div class="col-md-4">
                @include('controles.marca', ['control_control' => 'marca'
                                                         , 'control_id'=>"marca_frm_filtro"
                                                         , 'control_nuevos' => false
                                                         , 'control_mostrar_grupo' => true
                                                         , 'control_default' => $filtros->marca
                                                        ,'control_texto'=>'Marcadas como:'])
            </div>
            {{-- Listados  --}}
            <div class="col-md-4">
                @include('controles.listado_excel', ['control_control' => 'id_excel_listados'
                                                    ,'control_default' => $filtros->id_excel_listados
                                                    , 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_resaltar' => true
                                                    ,'control_select2' => true
                                                   ,'control_texto'=>'Utilizar listados de códigos'])
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('controles.tesauro3', ['control_control' => 'id_tesauro'
                                                    , 'control_default'=>$filtros->id_tesauro
                                                    , 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_texto'=>'Etiquetadas con:'
                                                    ])


            </div>
        </div>



        <div class="clearfix"></div>


        <div class="row">
            <div class="col-xs-4 ">
                <a href="{{ Request::url() }}"  class="btn btn-default">Quitar filtros y mostrar todo</a>
            </div>
            <div class="col-xs-4 text-center">
                <a href="{{ Request::url()."?id_subserie=$filtros->id_subserie&id_entrevistador=".\Auth::user()->id_entrevistador }}" class="btn btn-info">Mostrar mis entrevistas</a>
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-success pull-right">Aplicar filtros</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
    <!-- /.box-body -->
</div>


