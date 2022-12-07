<?php
    //Para que no truene nunca
    if(!isset($filtros)) {
        $filtros = \App\Models\traza_actividad::filtros_default();
    }
?>
{!! Form::open(['url' => '#', 'method'=>'get']) !!}
<div class="box box-default box-solid ">
    <div class="box-header with-border">
        <h3 class="box-title">Filtrar información mostrada

                <small> Mostrando datos para un total de {{ $trazaActividads->total() }} registros.</small>

        </h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            @can('nivel-1')
            <div class="col-md-3 ">
                <div class="form-group">
                    @include('controles.usuario', ['control_control' => 'id_usuario'
                                           , 'control_default'=>$filtros->id_usuario
                                           , 'control_vacio' => '[Mostrar todos]'
                                           ,'control_texto'=>'Usuario'])
                </div>
            </div>
            @endcan
            <div class="col-md-3 ">
                <div class="form-group">
                    @include('controles.criterio_fijo', ['control_control' => 'id_accion'
                                      ,'control_grupo'=>21
                                      , 'control_default'=>$filtros->id_accion
                                      , 'control_vacio' => '[Mostrar todos]'
                                      ,'control_texto'=>'Acción realizada'])
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="form-group">
                    @include('controles.criterio_fijo', ['control_control' => 'id_objeto'
                                      ,'control_grupo'=>22
                                      , 'control_default'=>$filtros->id_objeto
                                      , 'control_vacio' => '[Mostrar todos]'
                                      ,'control_texto'=>'Destino de la acción'])
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="form-group">
                    <label>Código </label>
                    {!! Form::text('codigo', null, ['class' => 'form-control']) !!}
                </div>
            </div>



        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success pull-right">Aplicar filtros</button>

                <a href="{{ Request::url() }}" class="btn btn-warning">Quitar los filtros</a>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
{!! Form::close() !!}


