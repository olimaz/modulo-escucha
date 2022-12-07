<?php
//Para que no truene nunca
if(!isset($filtros)) {
    $filtros = \App\Models\desclasificar::filtros_default();
}
?>
<div class="box box-default  box-solid">
    <div class="box-header ">
        <h3 class="box-title"><i class="fa fa-filter" aria-hidden="true"></i> Desclasificar: Filtrar la informaci&oacute;n visualizada</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        {{ Form::model($filtros,array('url' =>"#",'method' => 'get')) }}
            <div class="col-md-3 ">
                <div class="form-group">
                    <label>Código Entrevista</label>
                    {!! Form::text('entrevista_codigo', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Clasificación dela entrevista</label>
                    {!! Form::select('entrevista_nivel', array(-1=>"[Mostrar todos]", 2=>'R-2', 3=>'R-3') , null,['class' => 'form-control']) !!}
                </div>


            </div>
            <div class="col-md-3">
                @include('controles.entrevistador', ['control_control' => 'id_autorizado'
                                            ,'control_vacio' => 'Mostrar todos'
                                            ,'control_default' => $filtros->id_autorizado
                                            ,'control_texto'=>'Acceso otorgado a'])
            </div>
            <div class="col-md-3">
                @include('controles.entrevistador', ['control_control' => 'id_autorizador'
                                            ,'control_vacio' => 'Mostrar todos'
                                            ,'control_default' => $filtros->id_autorizador
                                            ,'control_texto'=>'Autorizado por'])
            </div>

            <div class="clearfix"></div>


            <div class="col-xs-6 ">
                <a href="{{ Request::url() }}"  class="btn btn-default">Quitar filtros y mostrar todo</a>
            </div>
            <div class="col-xs-6">
                <button type="submit" class="btn btn-success pull-right">Aplicar filtros</button>
            </div>
        {{ Form::close() }}
    </div>
    <!-- /.box-body -->
</div>


