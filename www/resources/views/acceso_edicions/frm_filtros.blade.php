<?php
//Para que no truene nunca
if(!isset($filtros)) {
    $filtros = \App\Models\acceso_edicion::filtros_default();
}
?>
<div class="box box-default  box-solid">
    <div class="box-header ">
        <h3 class="box-title"><i class="fa fa-filter" aria-hidden="true"></i> Accesos para modificar: Filtrar la informaci&oacute;n visualizada</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        {{ Form::model($filtros,array('url' =>"#",'method' => 'get')) }}
        {!! Form::hidden('id_subserie', null) !!}

        {{-- Fecha y lugar de la entrevista --}}
        <div class="row">
            <div class="col-md-3 ">
                <div class="form-group">
                    <label>Código Entrevista</label>
                    {!! Form::text('entrevista_codigo', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            @can('nivel-1-2')
            <div class="col-md-3">
                @include('controles.entrevistador', ['control_control' => 'id_autoriza'
                                            ,'control_vacio' => 'Mostrar todos'
                                            ,'control_default' => $filtros->id_autoriza
                                            ,'control_texto'=>'Quién autoriza'])
            </div>
            @endcan
            <div class="col-md-3">
                @include('controles.entrevistador', ['control_control' => 'id_autorizado'
                                            ,'control_vacio' => 'Mostrar todos'
                                            ,'control_default' => $filtros->id_autorizado
                                            ,'control_texto'=>'Entrevistador autorizado'])
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    @include('controles.criterio_fijo', ['control_control' => 'id_situacion'
                                           ,'control_grupo'=>11
                                           , 'control_default'=>$filtros->id_situacion
                                           , 'control_vacio' => '[Mostrar todos]'
                                           ,'control_texto'=>'Estado de la autorizacion'])
                </div>
            </div>



            <div class="col-md-3 ">
                <div class="form-group">
                    <label>Observaciones:</label>
                    {!! Form::text('observaciones', null, ['class' => 'form-control']) !!}
                </div>

            </div>

        </div>

        <div class="clearfix"></div>



        <div class="row">
            <div class="col-xs-4 ">
                <a href="{{ Request::url() }}"  class="btn btn-default">Quitar filtros y mostrar todo</a>
            </div>
            <div class="col-xs-4 text-center">
                <a href="{{ Request::url()."?id_autoriza=".\Auth::user()->id_entrevistador }}" class="btn btn-info">Mostrar mis autorizaciones</a>
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-success pull-right">Aplicar filtros</button>
            </div>

        </div>
        {{ Form::close() }}
    </div>
    <!-- /.box-body -->
</div>


