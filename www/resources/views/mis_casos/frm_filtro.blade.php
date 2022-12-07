<?php
    //Para que no truene nunca
    if(!isset($filtros)) {
        $filtros = \App\Models\mis_casos::filtros_default();
    }
?>
{!! Form::model($filtros,['url' => '#', 'method'=>'get']) !!}
<div class="box box-default box-solid collapsed-box">
    <div class="box-header with-border">
        <h3 class="box-title">Filtrar información mostrada
            @if(isset($total_entrevistas))
                <small> Mostrando datos para un total de {{ number_format($total_entrevistas) }} casos.</small>
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

        {{-- Codigo, entrevistador, territorio --}}
        <div class="row">
            <div class="col-md-3 ">
                <div class="form-group">
                    <label>Código caso</label>
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
                <div class="col-md-6 ">
                    <div class="form-group">
                        @include('controles.cev2', ['control_control' => 'id_territorio'
                                               ,'control_vacio' => "[Mostrar todos]"
                                              , 'control_territorio'=>$filtros->id_territorio
                                              ,'control_resaltar' => true
                                              , 'control_macroterritorio'=>$filtros->id_macroterritorio])
                    </div>
                </div>
        </div>

        {{-- Nombre descripcion --}}
        <div class="row">
            <div class="col-md-6 ">
                <label>Nombre</label>
                {!! Form::text('nombre', null, ['class' => 'form-control']) !!}

            </div>
            <div class="col-md-6 ">
                <label>Descripción</label>
                {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}

            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3 ">
                @include('controles.criterio_fijo', ['control_control' => 'id_avance'
                                     ,'control_grupo'=>52
                                     , 'control_default'=>$filtros->id_avance
                                     , 'control_vacio' => '[Mostrar todos]'
                                     ,'control_resaltar' => true
                                     ,'control_texto'=>'Nivel de avance'])

            </div>
            <div class="col-md-3 ">
                @include('controles.catalogo', ['control_control' => 'id_sector'
                                                    ,'control_id_cat'=>18
                                                    , 'control_default'=>$filtros->id_sector
                                                    , 'control_multiple' => true
                                                    , 'control_requerido' => false
                                                    ,'control_resaltar' => true
                                                    //, 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_texto'=>'Sector/es con el que se puede identificar el caso:'])

            </div>
            <div class="form-group col-sm-3">
                {!! Form::label('del', 'Período de tiempo, del:') !!}
                {!! Form::number('del', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-sm-3">
                {!! Form::label('al', 'Período de tiempo, al:') !!}
                {!! Form::number('al', null, ['class' => 'form-control']) !!}
            </div>

        </div>

        <div class="row">
            <div class="col-md-6 ">
                @include('controles.catalogo', ['control_control' => 'id_tipo_victima'
                                                    ,'control_id_cat'=>101
                                                    , 'control_default'=>$filtros->id_tipo_victima
                                                    , 'control_multiple' => true
                                                    , 'control_requerido' => false
                                                    ,'control_resaltar' => true
                                                    //, 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_texto'=>'Tipo de caso:'])

            </div>
            <div class="col-md-6 ">
                @include('controles.catalogo', ['control_control' => 'id_violencia'
                                                    ,'control_id_cat'=>5
                                                    , 'control_default'=>$filtros->id_violencia
                                                    , 'control_multiple' => true
                                                    , 'control_requerido' => false
                                                    ,'control_resaltar' => true
                                                    //, 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_texto'=>'Violencia:'])

            </div>
            <div class="clearfix"></div>
            <div class="col-md-6 ">
                @include('controles.catalogo', ['control_control' => 'id_fr'
                                                    ,'control_id_cat'=>4
                                                    , 'control_default'=>$filtros->id_fr
                                                    , 'control_multiple' => true
                                                    , 'control_requerido' => false
                                                    ,'control_resaltar' => true
                                                    //, 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_texto'=>'Fuerzas responsables:'])

            </div>
            <div class="col-md-6 ">
                @include('controles.catalogo', ['control_control' => 'id_tc'
                                                    ,'control_id_cat'=>10
                                                    , 'control_default'=>$filtros->id_tc
                                                    , 'control_multiple' => true
                                                    , 'control_requerido' => false
                                                    ,'control_resaltar' => true
                                                    //, 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_texto'=>'Terceros civiles:'])

            </div>
            <div class="clearfix"></div>
            <div class="col-md-12 ">
                @include('controles.catalogo', ['control_control' => 'id_patron'
                                                    ,'control_id_cat'=>280
                                                    , 'control_default'=>$filtros->id_patron
                                                    , 'control_multiple' => true
                                                    , 'control_requerido' => false
                                                    ,'control_resaltar' => true
                                                    //, 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_texto'=>'Patrones referidos:'])

            </div>
        </div>




        <div class="row">
            <div class="col-xs-4 ">
                <a href="{{ Request::url() }}"  class="btn btn-default">Quitar filtros y mostrar todo</a>
            </div>
            <div class="col-xs-4 text-center">
                <a href="{{ Request::url()."?id_entrevistador=".\Auth::user()->id_entrevistador }}" class="btn btn-info">Mostrar mis casos</a>
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-success pull-right">Aplicar filtros</button>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
{!! Form::close() !!}


