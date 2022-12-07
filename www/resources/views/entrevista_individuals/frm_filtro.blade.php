<?php
    //Para que no truene nunca
    if(!isset($filtros)) {
        $filtros = \App\Models\entrevista_individual::filtros_default();
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
        <div class="row">
            @if(in_array(\Auth::user()->id_nivel,[1,2]))
                <div class="col-md-6">
                    <div class="form-group">
                        @include('controles.cev2', ['control_control' => 'id_territorio'
                                               ,'control_vacio' => "[Mostrar todos]"
                                              , 'control_territorio'=>$filtros->id_territorio
                                              , 'control_macroterritorio'=>$filtros->id_macroterritorio])
                    </div>
                </div>
            @endif
            @if(in_array(\Auth::user()->id_nivel,[1,2,3]))
                <div class="col-md-3 ">
                    <div class="form-group">
                        @include('controles.entrevistador', ['control_control' => 'id_entrevistador'
                                               , 'control_default'=>$filtros->id_entrevistador
                                               , 'control_vacio' => '[Mostrar todos]'
                                               ,'control_texto'=>'Entrevistador'])
                    </div>
                </div>
            @endif
                <div class="col-md-3 ">
                    <div class="form-group">
                        @include('controles.criterio_fijo', ['control_control' => 'id_grupo'
                                          ,'control_grupo'=>5
                                          , 'control_default'=>$filtros->id_grupo
                                          , 'control_vacio' => '[Mostrar todos]'
                                          ,'control_texto'=>'Grupo'])
                    </div>
                </div>
        </div>
        <div class="row" >
            <div class="col-md-3 ">
                <div class="form-group">
                    <label>Fecha de la entrevista:</label>
                    @include('controles.fecha', ['control_control' => 'entrevista_del'
                                 ,'control_default' => $filtros->entrevista_del
                                 ,'control_resaltar' => true
                                       ,'control_texto'=>'Del:'])
                </div>
            </div>
            <div class="col-md-3">
                <label>Fecha de la entrevista:</label>
                @include('controles.fecha', ['control_control' => 'entrevista_al'
                                 ,'control_default' => $filtros->entrevista_al
                                 ,'control_resaltar' => true
                                       ,'control_texto'=>'Al:'])
            </div>
        </div>

        <div class="row" style="padding-top: 5px">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success pull-right">Aplicar filtros</button>
                {{--
                <a href="{{ Request::url() }}" class="btn btn-default">Último año</a>
                <a href="{{ Request::url()."?del_submit=".date("Y-m-01") }}" class="btn btn-default">Este mes</a>
                <a href="{{ Request::url()."?del_submit=".date("Y-01-01") }}" class="btn btn-default">Este año</a>
                --}}
                <a href="{{ Request::url() }}" class="btn btn-warning">Quitar los filtros</a>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
{!! Form::close() !!}


