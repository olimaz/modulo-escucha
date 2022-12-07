<?php
//Para que no truene nunca
if(!isset($filtros)) {
    $filtros = \App\Models\transcribir_asignacion::filtros_default();
}
?>
<div class="box box-default  box-solid">
    <div class="box-header ">
        <h3 class="box-title"><i class="fa fa-filter" aria-hidden="true"></i> Etiquetado: Filtrar la informaci&oacute;n visualizada</h3>
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
            <div class="col-md-4 ">
                <div class="form-group">
                    <label>Asignado desde:</label>
                    @include('controles.fecha', ['control_control' => 'asignado_del'
                                 ,'control_default' => $filtros->asignacion_del
                                       ,'control_texto'=>'Del:'])
                </div>
            </div>
            <div class="col-md-4">
                <label>Asignado hasta:</label>
                @include('controles.fecha', ['control_control' => 'asignado_al'
                                 ,'control_default' => $filtros->asignacion_al
                                       ,'control_texto'=>'Al:'])
            </div>
            <div class="col-md-4 ">
                @include('controles.radio_si_no', ['control_control' => 'urgente'
                                        ,'control_opciones'=>[-1=>'Indiferente',1=>'Sí',2=>'No']
                                        ,'control_default'=>$filtros->urgente
                                        ,'control_texto'=>'Urgente'])

            </div>
            <div class="clearfix"></div>

            {{--
            <div class="col-md-4 ">
                <div class="form-group">
                    <label># Entrevista</label>
                    {!! Form::number('entrevista_correlativo', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            --}}
            <div class="col-md-4 ">
                <div class="form-group">
                    <label>Código Entrevista</label>
                    {!! Form::text('entrevista_codigo', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-4">
                @include('controles.transcriptor', ['control_control' => 'id_transcriptor'
                                            ,'control_vacio' => 'Mostrar todos'
                                            ,'control_default' => $filtros->id_transcriptor
                                            ,'control_con_deshabilitados' => true
                                            ,'control_texto'=>'Etiquetador asignado'])
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    @include('controles.criterio_fijo', ['control_control' => 'id_situacion'
                                           ,'control_grupo'=>9
                                           , 'control_default'=>$filtros->id_situacion
                                           , 'control_vacio' => '[Mostrar todos]'
                                           ,'control_texto'=>'Estado'])
                </div>
            </div>


            <div class="col-md-4">
                @include('controles.catalogo', ['control_control' => 'id_causa'
                                                    ,'control_id_cat'=>86
                                                    , 'control_default'=>$filtros->id_causa
                                                    , 'control_multiple' => false
                                                    , 'control_requerido' => false
                                                    , 'control_vacio' => 'Mostrar todos'
                                                    ,'control_texto'=>'No etiquetado por:'])
            </div>
            <div class="col-md-4 ">
                <div class="form-group">
                    <label>Observaciones:</label>
                    {!! Form::text('observaciones', null, ['class' => 'form-control']) !!}
                </div>

            </div>

        </div>

        <div class="clearfix"></div>



        <div class="row">
            <div class="col-xs-6 ">
                <a href="{{ Request::url() }}"  class="btn btn-default">Quitar filtros y mostrar todo</a>
            </div>
            <div class="col-xs-6">
                <button type="submit" class="btn btn-success pull-right">Aplicar filtros</button>
            </div>

        </div>
        {{ Form::close() }}
    </div>
    <!-- /.box-body -->
</div>


