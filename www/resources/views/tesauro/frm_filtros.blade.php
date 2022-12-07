
{!!  Form::model($filtros, ['action' =>'tesauroController@reporte_comparativo', 'method' => 'get']) !!}
<div class="box box-default collapsed-box" id="frm_comparativo">
    <div class="box-header">
        <h1 class="box-title">Etiqueta base:</h1>
        <div class="box-tools pull-right">
            <button class="btn bg-purple " type="submit">Realizar la comparación <i class="fa fa-magic"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
        <div class="col-xs-12">
            @include('controles.tesauro3', ['control_control' => 'id_tesauro'
                                                , 'control_default'=>$filtros->id_tesauro
                                                , 'control_vacio' => '[Mostrar todos]'
                                               ,'control_texto'=>''])
        </div>

    </div>
    <div class="box-body">

        {{-- Interés, mandato --}}
        <div class="col-md-4 ">
            @include('controles.catalogo', ['control_control' => 'mandato'
                                                ,'control_id' => 'mandato'
                                                 ,'control_id_cat'=>15
                                                 ,'control_resaltar' => true
                                                 , 'control_default'=>$filtros->mandato
                                                 , 'control_multiple' => true
                                                 , 'control_requerido' => false
                                                 ,'control_resaltar' => true
                                                 //, 'control_vacio' => '[Mostrar todos]'
                                                 ,'control_texto'=>'Coincide con estos aspectos del mandato:'])
        </div>
        <div class="col-md-4 ">
            @include('controles.catalogo', ['control_control' => 'interes'
                                                ,'control_id' => 'interes'
                                                    ,'control_id_cat'=>[19,85]
                                                    ,'control_resaltar' => true
                                                    , 'control_default'=>$filtros->interes
                                                    , 'control_multiple' => true
                                                    , 'control_requerido' => false
                                                    //, 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_texto'=>'Puede ser de utilidad para:'])
        </div>
        <div class="col-md-4">
            @include('controles.catalogo', ['control_control' => 'id_sector'
                                    ,'control_id' => 'id_sector'
                                       ,'control_id_cat'=>18
                                       ,'control_resaltar' => true
                                       , 'control_default'=>$filtros->id_sector
                                       , 'control_multiple'=>true
                                       , 'control_requerido' => false
                                       //,'control_vacio' => "[Mostrar todos]"
                                       ,'control_texto'=>'Sector con el que se puede identificar a las víctimas en el relato:'])
        </div>
        <div class="clearfix"></div>

        {{-- Otros --}}




        {{-- PRIORIDAD --}}
        <hr>
        {{--
        <div class="col-md-6 ">
            @include('controles.autofill', ['control_control' => 'ahora_entiendo'
                                             ,'control_url' => "autofill/99/pri_comprendo"
                                             , 'control_resaltar' => true
                                             ,'control_default' => $filtros->ahora_entiendo
                                             ,'control_texto'=>'Esta entrevista me permitió comprender lo siguiente'])
        </div>
        <div class="col-md-6 ">
            @include('controles.autofill', ['control_control' => 'cambio_perspectiva'
                                             ,'control_url' => "autofill/99/pri_cambio"
                                             , 'control_resaltar' => true
                                             ,'control_default' => $filtros->cambio_perspectiva
                                             ,'control_texto'=>'Esta entrevista ofrece explicaciones alternativas acerca de'])

        </div>
        <div class="clearfix"></div>
        --}}
        <div class="col-md-3 ">
            @include('controles.criterio_fijo', ['control_control' => 'd_hecho_min'
                                   ,'control_id'=> 'd_hecho_min'
                                   ,'control_grupo'=>26
                                   , 'control_resaltar' => true
                                   , 'control_vacio' => '[Mostrar todos]'
                                   , 'control_default'=>$filtros->d_hecho_min
                                   ,'control_texto'=>'Nivel mínimo del detalle de los hechos:'])
        </div>
        <div class="col-md-3 ">
            @include('controles.criterio_fijo', ['control_control' => 'd_contexto_min'
                                   ,'control_id'=> 'd_contexto_min'
                                   ,'control_grupo'=>26
                                   , 'control_resaltar' => true
                                   , 'control_vacio' => '[Mostrar todos]'
                                   , 'control_default'=>$filtros->d_contexto_min
                                   ,'control_texto'=>'Nivel mínimo del detalle de contexto:'])
        </div>
        <div class="col-md-3 ">
            @include('controles.criterio_fijo', ['control_control' => 'd_impacto_min'
                                   ,'control_id'=> 'd_impacto_min'
                                   ,'control_grupo'=>26
                                   , 'control_resaltar' => true
                                   , 'control_vacio' => '[Mostrar todos]'
                                   , 'control_default'=>$filtros->d_impacto_min
                                   ,'control_texto'=>'Nivel mínimo del detalle de los impactos:'])
        </div>
        <div class="col-md-3 ">
            @include('controles.criterio_fijo', ['control_control' => 'd_justicia_min'
                                   ,'control_id'=> 'd_justicia_min'
                                   ,'control_grupo'=>26
                                   , 'control_resaltar' => true
                                   , 'control_vacio' => '[Mostrar todos]'
                                   , 'control_default'=>$filtros->d_justicia_min
                                   ,'control_texto'=>'Nivel mínimo del detalle de acceso a la justicia y no repetición:'])
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="box-footer text-center">
        <button class="btn bg-purple " type="submit">Realizar la comparación <i class="fa fa-magic"></i></button>
    </div>
</div>
{!! Form::close() !!}


@push("js")
    <script>
        $( "#id_tesauro_depto" ).change(function() {
            $('#frm_comparativo').boxWidget('expand')
        });
        $( "#id_tesauro_muni" ).change(function() {
            $('#frm_comparativo').boxWidget('expand')
        });
        $( "#id_tesauro" ).change(function() {
            $('#frm_comparativo').boxWidget('expand')
        });

    </script>

@endpush