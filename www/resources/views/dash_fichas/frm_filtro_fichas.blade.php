{{-- Filtro para el dashboard de fichas --}}

<?php
//Para que no truene nunca
if(!isset($filtros)) {
    $filtros = \App\Models\entrevista_individual::filtros_default();
}
?>
{{ Form::model($filtros,array('url' =>"#",'method' => 'get')) }}
<div class="box box-default {{ $filtros->hay_filtro ? " " : " collapsed-box " }} box-solid">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-filter" aria-hidden="true"></i> Procesamiento de entrevistas a víctimas: Filtrar la informaci&oacute;n visualizada</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="btn_box_filtros"><i class="fa  {{ $filtros->hay_filtro ? " fa-minus " : " fa-plus " }} "></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="col-xs-12">
            <label>Lugar de la entrevista</label>
        </div>

        <div class="clearfix"></div>
        <div class="col-md-6 ">
                @include('controles.cev2', ['control_control' => 'id_territorio'
                                        ,'control_vacio' => "[Mostrar todos]"
                                        ,'control_resaltar' => true
                                       , 'control_territorio'=>$filtros->id_territorio
                                       , 'control_macroterritorio'=>$filtros->id_macroterritorio])
        </div>
        {{--
        <div class="col-md-2 ">
                @include('controles.criterio_fijo', ['control_control' => 'id_grupo'
                                       ,'control_grupo'=>5
                                       ,'control_resaltar' => true
                                       , 'control_default'=>$filtros->id_grupo
                                       , 'control_vacio' => '[Mostrar todos]'
                                       ,'control_texto'=>'Grupo del entrevistador'])
        </div>
        --}}
        <div class="col-md-3 ">
            <div class="form-group {{ $filtros->violencia_anio_del > 0 ? 'has-success' : '' }}">
                {!! Form::label('violencia_anio_del', 'Año de la violencia, desde:') !!}
                {!! Form::number('violencia_anio_del', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group {{ $filtros->violencia_anio_al > 0 ? 'has-success' : '' }}">
                {!! Form::label('violencia_anio_al', 'Año de la violencia, hasta:') !!}
                {!! Form::number('violencia_anio_al', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-md-6 ">
            @include('controles.tipo_violencia', ['control_control' => 'violencia_tipo'
                                   ,'control_resaltar' => true
                                   , 'control_default'=>$filtros->violencia_tipo
                                   , 'control_vacio' => '[Mostrar todos]'
                                   ,'control_texto'=>'Violencia registrada'])
        </div>
        <div class="col-md-6 ">
            @include('controles.geo3', ['control_control' => 'violencia_lugar'
                                   ,'control_resaltar' => true
                                   , 'control_default'=>$filtros->violencia_lugar
                                   , 'control_vacio' => '[Mostrar todos]'
                                   ,'control_texto'=>'Lugar de la violencia'])
        </div>

        <div class="clearfix"></div>

        <div class="col-sm-6">
            @include('controles.tipo_aa', ['control_control' => 'violencia_aa'
                                                ,'control_default' => $filtros->violencia_aa
                                                , 'control_vacio' => '[Mostrar todos]'
                                                ,'control_resaltar' => true
                                               ,'control_texto'=>'Responsabilidad colectiva:'])
        </div>

        <div class="col-sm-6">
            @include('controles.tipo_tc', ['control_control' => 'violencia_tc'
                                                ,'control_default' => $filtros->violencia_tc
                                                , 'control_vacio' => '[Mostrar todos]'
                                                ,'control_resaltar' => true
                                               ,'control_texto'=>'Responsabilidad colectiva:'])
        </div>

        {{--

        <div class="clearfix"></div>
        <div class="col-md-3 ">
            <div class="form-group">
                <label>F. de los hechos</label>
                @include('controles.fecha', ['control_control' => 'hechos_del'
                             ,'control_default' => $filtros->hechos_del
                             ,'control_resaltar' => true
                             ,'control_texto'=>'Del:'])
            </div>
        </div>
        <div class="col-md-3">
            <label>F. de los hechos</label>
            @include('controles.fecha', ['control_control' => 'hechos_al'
                             ,'control_default' => $filtros->hechos_al
                             ,'control_resaltar' => true
                                   ,'control_texto'=>'Al:'])
        </div>
        <div class="col-md-6">
            @include('controles.geo3', ['control_control' => 'hechos_lugar'
                           ,'control_texto' => 'Lugar de los hechos'
                           ,'control_resaltar' => true
                           ,'control_vacio' => '[Mostrar todos]'
                           , 'control_default'=>$filtros->hechos_lugar])
        </div>
        --}}
    </div>
    <div class="box-footer">
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
</div>
{{ Form::close() }}

