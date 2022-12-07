<?php
    //Para que no truene nunca
    if(!isset($filtros)) {
        $filtros = \App\Models\entrevista_etnica::filtros_default();
    }
?>
{!! Form::model($filtros,['url' => '#', 'method'=>'get']) !!}
<div class="box box-default box-solid collapsed-box">
    <div class="box-header with-border">
        <h3 class="box-title">Filtrar información mostrada
            @if(isset($total_entrevistas))
                <small> Mostrando datos para un total de {{ number_format($total_entrevistas) }} entrevistas.</small>
            @endif
        </h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{-- Codigo, entrevistador, grupo, situacion --}}
        <div class="row">
            <div class="col-md-3 ">
                <div class="form-group">
                    <label>Código Entrevista</label>
                    {!! Form::text('entrevista_codigo', null, ['class' => 'form-control']) !!}
                </div>
            </div>



                <div class="col-md-3 ">
                    <div class="form-group">
                        @include('controles.entrevistador_todos', ['control_control' => 'id_entrevistador'
                                               , 'control_default'=>$filtros->id_entrevistador
                                               , 'control_vacio' => '[Mostrar todos]'
                                               ,'control_resaltar' => true
                                               ,'control_texto'=>'Entrevistador'])
                    </div>
                </div>

            <div class="col-md-3 ">
                <div class="form-group">
                    @include('controles.criterio_fijo', ['control_control' => 'id_grupo'
                                      ,'control_grupo'=>5
                                      , 'control_default'=>$filtros->id_grupo
                                      , 'control_vacio' => '[Mostrar todos]'
                                      ,'control_resaltar' => true
                                      ,'control_texto'=>'Grupo'])
                </div>
            </div>
            <div class="col-md-3">
                @include('controles.catalogo', ['control_control' => 'entrevista_avance'
                                                     ,'control_id_cat'=>20
                                                     , 'control_default'=>$filtros->entrevista_avance
                                                     , 'control_multiple' => false
                                                     , 'control_requerido' => false
                                                     ,'control_resaltar' => true
                                                     , 'control_vacio' => '[Mostrar todos]'
                                                     ,'control_texto'=>'Situación actual:'])
            </div>
        </div>


        {{-- Terrtorio,  sector, transcrita--}}
        <div class="row">

                <div class="col-md-6 ">
                    <div class="form-group">
                        @include('controles.cev2', ['control_control' => 'id_territorio'
                                               ,'control_vacio' => "[Mostrar todos]"
                                               ,'control_resaltar' => true
                                              , 'control_territorio'=>$filtros->id_territorio
                                              , 'control_macroterritorio'=>$filtros->id_macroterritorio])
                    </div>
                </div>
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
            <div class="clearfix"></div>
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


            <div class="col-md-3 ">
                @include('controles.catalogo', ['control_control' => 'id_sector'
                                                 ,'control_id_cat'=>18
                                                 , 'control_default'=>$filtros->id_sector
                                                 , 'control_multiple' => true
                                                 , 'control_requerido' => false
                                                 ,'control_resaltar' => true
                                                 //, 'control_vacio' => '[Mostrar todos]'
                                                 ,'control_texto'=>'Sector:'])
            </div>

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
        {{-- Fila 2: fecha y lugar del tema --}}
        <div class="row">
            <div class="col-md-2 ">
                <div class="form-group">
                    <label>Período de tiempo</label>
                    @include('controles.fecha', ['control_control' => 'tema_del'
                                 ,'control_default' => $filtros->tema_del
                                 ,'control_resaltar' => true
                                 ,'control_texto'=>'Del:'])
                </div>
            </div>
            <div class="col-md-2">
                <label>Período de tiempo</label>
                @include('controles.fecha', ['control_control' => 'tema_al'
                                 ,'control_default' => $filtros->tema_al
                                 ,'control_resaltar' => true
                                       ,'control_texto'=>'Al:'])
            </div>
            <div class="col-md-8">
                @include('controles.geo3', ['control_control' => 'tema_lugar'
                               ,'control_texto' => 'Ubicación de los eventos de la entrevista:'
                               ,'control_vacio' => '[Mostrar todos]'
                               ,'control_resaltar' => true
                               , 'control_default'=>$filtros->tema_lugar])
            </div>
        </div>
        {{-- Fila : criterios específicos --}}

        <hr>


        <div class="row">
            <div class="col-md-2 ">
                @include('controles.catalogo', ['control_control' => 'id_tipo_entrevista'
                                                 ,'control_id_cat'=>90
                                                 , 'control_default'=>$filtros->id_tipo_entrevista
                                                 , 'control_multiple' => false
                                                 , 'control_requerido' => false
                                                 ,'control_resaltar' => true
                                                 , 'control_vacio' => '[Mostrar todos]'
                                                 ,'control_texto'=>'Tipo de entrevista:'])
            </div>
            <div class="col-md-2 ">
                @include('controles.catalogo', ['control_control' => 'id_tipo_sujeto'
                                                 ,'control_id_cat'=>93
                                                 , 'control_default'=>$filtros->id_tipo_sujeto
                                                 , 'control_multiple' => false
                                                 , 'control_requerido' => false
                                                 ,'control_resaltar' => true
                                                 , 'control_vacio' => '[Mostrar todos]'
                                                 ,'control_texto'=>'Tipo de sujeto:'])
            </div>
            <div class="col-md-3 ">
                @include('controles.catalogo', ['control_control' => 'id_indigena'
                                                 ,'control_id_cat'=>28
                                                 , 'control_default'=>$filtros->id_indigena
                                                 , 'control_multiple' => true
                                                 , 'control_requerido' => false
                                                 ,'control_resaltar' => true
                                                 //, 'control_vacio' => '[Mostrar todos]'
                                                 ,'control_texto'=>'Pueblos indígenas:'])
            </div>
            <div class="col-md-3 ">
                @include('controles.catalogo', ['control_control' => 'id_narp'
                                                 ,'control_id_cat'=>91
                                                 , 'control_default'=>$filtros->id_narp
                                                 , 'control_multiple' => true
                                                 , 'control_requerido' => false
                                                 ,'control_resaltar' => true
                                                 //, 'control_vacio' => '[Mostrar todos]'
                                                 ,'control_texto'=>'Pueblos afro:'])
            </div>
            <div class="col-md-2 ">
                @include('controles.catalogo', ['control_control' => 'id_rrom'
                                                 ,'control_id_cat'=>92
                                                 , 'control_default'=>$filtros->id_rrom
                                                 , 'control_multiple' => true
                                                 , 'control_requerido' => false
                                                 ,'control_resaltar' => true
                                                 //, 'control_vacio' => '[Mostrar todos]'
                                                 ,'control_texto'=>'Kumpany rrom:'])
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-3 ">
                @include('controles.autofill', ['control_control' => 'titulo'
                                         ,'control_url' => 'autofill/ee_titulo'
                                         ,'control_default' => $filtros->titulo
                                         ,'control_resaltar' => true
                                         ,'control_texto'=>'Título:'])

            </div>
            <div class="col-md-3 ">
                @include('controles.autofill', ['control_control' => 'tema_descripcion'
                                         ,'control_url' => 'autofill/ee_tema_descripcion'
                                         ,'control_default' => $filtros->tema_descripcion
                                         ,'control_resaltar' => true
                                         ,'control_texto'=>'Tema de la entrevista:'])

            </div>
            <div class="col-md-3 ">
                @include('controles.autofill', ['control_control' => 'tema_objetivo'
                                         ,'control_url' => 'autofill/ee_tema_objetivo'
                                         ,'control_default' => $filtros->tema_objetivo
                                         ,'control_resaltar' => true
                                         ,'control_texto'=>'Objetivo de la entrevista:'])

            </div>
            <div class="col-md-3 ">
                @include('controles.autofill', ['control_control' => 'eventos_descripcion'
                                        ,'control_url' => 'autofill/ee_eventos_descripcion'
                                        ,'control_default' => $filtros->eventos_descripcion
                                        ,'control_resaltar' => true
                                        ,'control_texto'=>'Descripción de los eventos:'])
            </div>

        </div>
        {{-- Fila 4: titulo, observaciones, dinamica  --}}
        <div class="row">
            <div class="col-md-3 ">
                @include('controles.autofill', ['control_control' => 'dinamica'
                                        ,'control_url' => 'autofill/ee_dinamica'
                                        ,'control_default' => $filtros->dinamica
                                        ,'control_resaltar' => true
                                        ,'control_texto'=>'Dinámicas identificadas:'])
            </div>
            <div class="col-md-3 ">
                @include('controles.autofill', ['control_control' => 'observaciones'
                                       ,'control_url' => 'autofill/ee_observaciones'
                                       ,'control_default' => $filtros->observaciones
                                       ,'control_resaltar' => true
                                       ,'control_texto'=>'Observaciones:'])
            </div>
            <div class="col-md-3 ">
                @include('controles.catalogo', ['control_control' => 'mandato'
                                                 ,'control_id_cat'=>15
                                                 , 'control_default'=>$filtros->mandato
                                                 , 'control_multiple' => true
                                                 , 'control_requerido' => false
                                                 ,'control_resaltar' => true
                                                 //, 'control_vacio' => '[Mostrar todos]'
                                                 ,'control_texto'=>'Aspectos del mandato:'])
            </div>
            <div class="col-md-3">
                @include('controles.catalogo', ['control_control' => 'interes'
                                                     ,'control_id_cat'=>19
                                                     , 'control_default'=>$filtros->interes
                                                     , 'control_multiple' => true
                                                     , 'control_requerido' => false
                                                     ,'control_resaltar' => true
                                                     //, 'control_vacio' => '[Mostrar todos]'
                                                     ,'control_texto'=>'De interés para:'])
            </div>

        </div>
        <div class="row">
            <div class="col-md-4">
                @include('controles.texto', ['control_control' => 'fts'
                                                          ,'control_resaltar' => true
                                                          , 'control_default'=>$filtros->fts
                                                          , 'control_requerido' => false
                                                          ,'control_texto'=>'Buscadora. Buscar en la transcripción:'])
            </div>
            <div class="col-md-4">
                @include('controles.marca', ['control_control' => 'marca'
                                                         , 'control_id'=>"marca_frm_filtro"
                                                         , 'control_nuevos' => false
                                                         , 'control_mostrar_grupo' => true
                                                         ,'control_resaltar' => true
                                                         , 'control_default' => $filtros->marca
                                                        ,'control_texto'=>'Marcadas como:'])
            </div>
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



        <div class="row">
            <div class="col-xs-4 ">
                <a href="{{ Request::url() }}"  class="btn btn-default">Quitar filtros y mostrar todo</a>
            </div>
            <div class="col-xs-4 text-center">
                <a href="{{ Request::url()."?id_entrevistador=".\Auth::user()->id_entrevistador }}" class="btn btn-info">Mostrar mis entrevistas</a>
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-success pull-right">Aplicar filtros</button>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
{!! Form::close() !!}


