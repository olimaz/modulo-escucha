<?php
//Para que no truene nunca
if(!isset($filtros)) {
    $filtros = \App\Models\entrevista_prioridad::filtros_default();
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
           {{--
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
            --}}
                <div class="col-md-5 ">
                    <div class="form-group">
                        @include('controles.cev2', ['control_control' => 'id_territorio'
                                                ,'control_vacio' => "[Mostrar todos]"
                                                ,'control_resaltar' => true
                                               , 'control_territorio'=>$filtros->id_territorio
                                               , 'control_macroterritorio'=>$filtros->id_macroterritorio])
                    </div>
                </div>

            <div class="col-md-2">
                @include('controles.criterio_fijo', ['control_control' => 'transcrita'
                                           ,'control_default' => $filtros->transcrita
                                           ,'control_grupo' => 8
                                           ,'control_resaltar' => true
                                           ,'control_vacio' => "Mostrar todos"
                                           ,'control_nulo' => "Sin asignar"
                                           ,'control_texto'=>"Entrevista transcrita"])

            </div>
            <div class="col-md-3">
                @include('controles.transcriptor', ['control_control' => 'id_transcriptor'
                                            ,'control_vacio' => 'Mostrar todos'
                                            ,'control_default' => $filtros->id_transcriptor
                                            ,'control_texto'=>'Quien transcribió'])
            </div>
            <div class="col-md-2">
                @include('controles.criterio_fijo', ['control_control' => 'etiquetada'
                                           ,'control_default' => $filtros->etiquetada
                                           ,'control_grupo' => 9
                                           ,'control_resaltar' => true
                                           ,'control_vacio' => "Mostrar todos"
                                           ,'control_nulo' => "Sin asignar"
                                           ,'control_texto'=>"Entrevista etiquetada"])

            </div>

        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-xs-4 ">
                <a href="{{ Request::url() }}"  class="btn btn-info">Quitar filtros y mostrar asignables</a>
            </div>

            <div class="col-xs-4 text-center">
                <a href="{{ Request::url()."?transcrita=-1&etiquetada=-1" }}"  class="btn btn-default">Quitar filtros y mostrar todo</a>
            </div>

            <div class="col-xs-4 text-right">
                <button type="submit" class="btn btn-success pull-right">Aplicar filtros</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
    <!-- /.box-body -->
</div>


