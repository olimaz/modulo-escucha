<?php
    //Para que no truene nunca
    if(!isset($filtros)) {
        $filtros = \App\Models\seguimiento::filtros_default();
    }
?>
{!! Form::model($filtros,['url' => '#', 'method'=>'get']) !!}
<div class="box box-default box-solid collapsed-box">
    <div class="box-header with-border">
        <h3 class="box-title">Filtrar información mostrada
                <small> Mostrando datos para un total de {{ number_format($listado->total()) }} items.</small>
        </h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
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
                                           ,'control_texto'=>'Responsable'])
            </div>
            <div class="col-md-3">
                @include('controles.criterio_fijo', ['control_control' => 'id_cerrado'
                                            ,'control_default' => $filtros->id_cerrado
                                            ,'control_grupo' => 2
                                            ,'control_resaltar' => true
                                            ,'control_vacio' => "Mostrar todos"
                                            ,'control_texto'=>'El procesamiento ha finalizado'])
            </div>
            <div class="col-md-3">
                <div class="form-group {{ $filtros->anotaciones ? ' has-success ' : '' }}">
                    <label>Anotaciones</label>
                    {!! Form::text('anotaciones', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                @include('controles.criterio_fijo', ['control_control' => 'tiene_problema'
                                            ,'control_default' => $filtros->tiene_problema
                                            ,'control_grupo' => 2
                                            ,'control_resaltar' => true
                                            ,'control_vacio' => "[Mostrar todos]"
                                            ,'control_texto'=>'Al cierre, requiere de algún seguimiento'])
            </div>
            <div class="col-md-3">
                @include('controles.criterio_fijo', ['control_control' => 'cerrado_id_estado'
                                            ,'control_default' => $filtros->cerrado_id_estado
                                            ,'control_grupo' => 2
                                            ,'control_resaltar' => true
                                            ,'control_vacio' => "[Mostrar todos]"
                                            ,'control_texto'=>'El seguimiento ya fué finalizado'])
            </div>

            <div class="col-md-3">
                @include('controles.catalogo', ['control_control' => 'id_tipo_problema'
                                             ,'control_default' => $filtros->id_tipo_problema
                                             ,'control_id_cat' => 75
                                             ,'control_vacio' => "[Mostrar todos]"
                                             ,'control_resaltar' => true
                                             ,'control_texto'=>'Tipo de seguimiento:'])

            </div>
            <div class="col-md-3">
                <div class="form-group {{ $filtros->descripcion ? ' has-success ' : '' }}">
                    <label>Descripción del seguimiento</label>
                    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-xs-4 ">
                <a href="{{ Request::url()."?cerrado_id_estado=-1" }}"  class="btn btn-default">Quitar filtros y mostrar todo</a>
            </div>
            <div class="col-xs-4 text-center">
                <a href="{{ Request::url()."?cerrado_id_estado=2" }}" class="btn btn-info">Mostrar pendientes de resolver</a>
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-success pull-right">Aplicar filtros</button>
            </div>
        </div>


    </div>
    <!-- /.box-body -->
</div>
{!! Form::close() !!}


