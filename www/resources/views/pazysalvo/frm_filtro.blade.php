<?php
    //Para que no truene nunca
    if(!isset($filtros)) {
        $filtros = \App\Models\mis_casos::filtros_default();
    }
?>
{!! Form::model($filtros,['url' => '#', 'method'=>'get']) !!}
<div class="box box-default box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Mostrar listado de acuerdo a los criterios indicados a continuación:
        </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        {{-- Codigo, entrevistador, territorio --}}

            <div class="col-md-3 ">
                <div class="form-group">
                    @include('controles.entrevistador_todos', ['control_control' => 'id_entrevistador'
                                           , 'control_default'=>$filtros->id_entrevistador
                                           , 'control_vacio' => '[Mostrar todos]'
                                           ,'control_resaltar' => true
                                           ,'control_texto'=>'Entrevistador'])
                </div>
            </div>

            <div class="col-md-3 ">
                <div class="form-group">
                    @include('controles.select_generico', ['control_control' => 'id_completo'
                                           , 'control_default'=>$filtros->id_completo
                                           , 'control_vacio' => '[Mostrar todos]'
                                           , 'control_listado' => [-1=>'Mostrar todas',1=>'Completa',2=>'Incompleta']
                                           ,'control_resaltar' => true
                                           ,'control_texto'=>'Estado de la entrevista'])
                </div>
            </div>
    </div>







    <div class="box-footer text-center">
        <div class=" text-center">
            <a href="{{ Request::url() }}"  class="btn btn-default">Quitar filtros y mostrar mis entrevistas</a>
            <button type="submit" class="btn btn-primary ">Aplicar filtros</button>
        </div>



    </div>

</div>
{!! Form::close() !!}


