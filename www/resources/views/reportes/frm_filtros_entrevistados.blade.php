<?php
//Para que no truene nunca
if(!isset($filtros)) {
    $filtros = \App\Models\excel_personas_entrevistadas::filtros_default();
}
?>
{!! Form::model($filtros,['url' => '#', 'method'=>'get']) !!}
<div class="box box-default box-solid ">
    <div class="box-header with-border">
        <h3 class="box-title">Filtrar información mostrada
                <small> Mostrando datos para un total de {{ number_format($listado->total()) }} registros.</small>
        </h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        {{-- Codigo, nombres, sexo --}}
        <div class="col-md-3 ">
            <div class="form-group">
                <label>Código entrevista</label>
                {!! Form::text('codigo_entrevista', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-9 ">
            <div class="form-group">
                @include('controles.cev2', ['control_control' => 'id_territorio'
                                        ,'control_vacio' => "[Mostrar todos]"
                                        ,'control_resaltar' => true
                                       , 'control_territorio'=>$filtros->id_territorio
                                       , 'control_macroterritorio'=>$filtros->id_macroterritorio])
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-8 ">
            <div class="form-group">
                <label>Nombre / Apellidos / Otros nombres</label>
                {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-4 ">
            @include('controles.catalogo', ['control_control' => 'id_sexo'
                                               ,'control_id_cat'=>24
                                               , 'control_default'=>$filtros->id_sexo
                                               , 'control_multiple' => false
                                               , 'control_requerido' => false
                                               ,'control_resaltar' => true
                                               , 'control_vacio' => '[Mostrar todos]'
                                               ,'control_texto'=>'Sexo:'])
        </div>
        {{-- Sector, clasificacion --}}
        <div class="clearfix"></div>
        <div class="col-md-8 ">
            @include('controles.catalogo', ['control_control' => 'id_sector'
                                               ,'control_id_cat'=>18
                                               , 'control_default'=>$filtros->id_sector
                                               , 'control_multiple' => true
                                               , 'control_requerido' => false
                                               ,'control_resaltar' => true
                                               ,'control_texto'=>'Sector:'])
        </div>
        <div class="col-md-4 ">
            @include('controles.criterio_fijo', ['control_control' => 'clasificacion_nivel'
                                 ,'control_grupo'=>13
                                 , 'control_default'=>$filtros->clasificacion_nivel
                                 //, 'control_vacio' => '[Mostrar todos]'
                                 ,'control_resaltar' => true
                                 , 'control_multiple' => true
                                 ,'control_texto'=>'Clasificación de acceso'])

        </div>

        {{-- Botones --}}
    </div><!-- /.box-body -->

    <div class="box-footer">
        <div class="col-xs-4 ">
            <a href="{{ Request::url() }}"  class="btn btn-default">Quitar filtros y mostrar todo</a>
        </div>

        <div class="col-xs-4">
            <button type="submit" class="btn btn-success pull-right">Aplicar filtros</button>
        </div>
    </div>
</div>
{!! Form::close() !!}


