<?php
//Para que no truene nunca
if(!isset($filtros)) {
    $filtros = \App\Models\casos_informes::filtros_default();
}
?>
<div class="box box-default collapsed-box box-solid">
    <div class="box-header ">
        <h3 class="box-title"><i class="fa fa-filter" aria-hidden="true"></i> Casos e informes: Filtrar la informaci&oacute;n visualizada</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        {{ Form::model($filtros,array('url' =>"#",'method' => 'get')) }}



        {{-- Correlativo, codigo, entrevistador y macro --}}
        <div class="row">
            <div class="col-md-3 ">
                <div class="form-group">
                    <label>Código</label>
                    {!! Form::text('codigo', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="form-group">
                    <label>Título</label>
                    {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="form-group">
                    <label>Autor</label>
                    {!! Form::text('autor', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="form-group">
                    <label>Descripción</label>
                    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            {{-- Remitente --}}
            <div class="clearfix"></div>
            <div class="col-md-3 ">
                <div class="form-group">
                    <label>Organización que entrega</label>
                    {!! Form::text('remitente_organizacion', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-sm-3">

                @include('controles.catalogo', ['control_control' => 'remitente_id_tipo_organizacion'
                                                    ,'control_id_cat'=>12
                                                    , 'control_default'=>$filtros->remitente_id_tipo_organizacion
                                                    , 'control_multiple' => true
                                                    , 'control_requerido' => false
                                                    //, 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_texto'=>'Tipo de organización:'])
            </div>


            <div class="col-md-3 ">
                <div class="form-group">
                    @include('controles.entrevistador', ['control_control' => 'id_entrevistador'
                                           , 'control_default'=>$filtros->id_entrevistador
                                           , 'control_vacio' => '[Mostrar todos]'
                                           ,'control_texto'=>'Analista'])
                </div>
            </div>



            {{-- quien recibe --}}
            <div class="clearfix"></div>
            <div class="col-md-3 ">
                <div class="form-group">
                    <label>Nombre de quien recibe:</label>
                    {!! Form::text('receptor_nombre', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-3 ">
                @include('controles.catalogo', ['control_control' => 'receptor_id_area'
                                                      ,'control_id_cat'=>13
                                                      , 'control_default'=>$filtros->receptor_id_area
                                                      , 'control_multiple' => false
                                                      , 'control_requerido' => false
                                                      , 'control_vacio' => '[Mostrar todos]'
                                                      ,'control_texto'=>'Área  de la que hace parte:'])

            </div>
            <div class="col-md-6 ">
                <div class="form-group">
                    @include('controles.cev2', ['control_control' => 'id_territorio'
                                            ,'control_vacio' => "[Mostrar todos]"
                                           , 'control_territorio'=>$filtros->id_territorio
                                           , 'control_macroterritorio'=>$filtros->id_macroterritorio])
                </div>
            </div>

            {{-- caracterización --}}
            <div class="clearfix"></div>
            <div class="col-md-3 ">
                @include('controles.catalogo', ['control_control' => 'caracterizacion_id_tipo'
                                                       ,'control_id_cat'=>14
                                                       , 'control_default'=>$filtros->caracterizacion_id_tipo
                                                       , 'control_multiple' => false
                                                       , 'control_requerido' => false
                                                       , 'control_vacio' => '[Mostrar todos]'
                                                       ,'control_texto'=>'Clasificación:'])
            </div>

            <div class="col-md-3">
                    @include('controles.catalogo', ['control_control' => 'interes'
                                                         ,'control_id_cat'=>13
                                                         , 'control_default'=>$filtros->interes
                                                         , 'control_multiple' => true
                                                         , 'control_requerido' => false
                                                         //, 'control_vacio' => '[Mostrar todos]'
                                                         ,'control_texto'=>'De interés para:'])
            </div>
            <div class="col-md-6 ">
                @include('controles.catalogo', ['control_control' => 'mandato'
                                                     ,'control_id_cat'=>15
                                                     , 'control_default'=>$filtros->mandato
                                                     , 'control_multiple' => true
                                                     , 'control_requerido' => false
                                                     //, 'control_vacio' => '[Mostrar todos]'
                                                     ,'control_texto'=>'Aspectos del mandato:'])
            </div>
        </div>

        <div class="clearfix"></div>

            <div class="col-xs-6 ">
                <a href="{{ action('casos_informesController@index') }}" class="btn btn-default">Quitar filtros y mostrar todo</a>
            </div>
            <div class="col-xs-6">
                <button type="submit" class="btn btn-success pull-right">Aplicar filtros</button>
            </div>


        {{ Form::close() }}
    </div>
    <!-- /.box-body -->
</div>


