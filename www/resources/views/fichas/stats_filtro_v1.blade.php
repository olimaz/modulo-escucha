{{-- Filtro para el dashboard de fichas --}}

<?php
//Para que no truene nunca
if(!isset($filtros)) {
    $filtros = \App\Models\victima::filtros_default();
}
?>
{{ Form::model($filtros,array('url' =>"#",'method' => 'get')) }}
{{ Form::hidden('fecha_corte',null) }}
<div class="card collapsed-card   {{ $filtros->hay_filtro >0 ? ' card-success' : ' card-info ' }}">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-filter"></i> Aplicar filtros a la información mostrada {{ $filtros->hay_filtro>0 ? ($filtros->hay_filtro==1 ? "($filtros->hay_filtro filtro aplicado)" : "($filtros->hay_filtro filtros aplicados)") : "" }}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas {{ $filtros->hay_filtro>0 ? 'fa-plus' : 'fa-minus'}} "></i>
            </button>
        </div>
    </div>
    <div class="card-body text-sm">
        <div class="row">

            <div class="w-100"></div>
            <div class="col-md-4 ">
                <label>Lugar de la entrevista</label>
                @include('controles.cev2', ['control_control' => 'id_territorio'
                                        ,'control_vacio' => "[Mostrar todos]"
                                        ,'control_resaltar' => true
                                        ,'control_select2' => true
                                       , 'control_territorio'=>$filtros->id_territorio
                                       , 'control_macroterritorio'=>$filtros->id_macroterritorio])
            </div>
            <div class="col-md-6 ">
                @include('controles.geo3', ['control_control' => 'entrevista_lugar'
                                       ,'control_resaltar' => true
                                       , 'control_default'=>$filtros->entrevista_lugar
                                       , 'control_vacio' => '[Mostrar todos]'
                                       ,'control_texto'=>'Lugar de la entrevista'])
            </div>





            <div class="w-100"></div>

            <div class="col-md-4 ">
                @include('controles.tipo_violencia', ['control_control' => 'violencia_tipo'
                                       ,'control_resaltar' => true
                                       , 'control_default'=>$filtros->violencia_tipo
                                       ,'control_select2' => true
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
            <div class="col-md-2 ">
                <div class="row">
                    <label>Fecha de la violencia</label>
                    <div class="w-100"></div>
                    <div class="col">
                        @include('controles.numero', ['control_control' => 'violencia_anio_del'
                                                           , 'control_default'=>$filtros->violencia_anio_del
                                                           ,'control_resaltar' => true
                                                           ,'control_requerido' => false
                                                           , 'control_min' =>1900
                                                           , 'control_max' =>2020
                                                           ,'control_texto'=>'Año de la violencia a partir de'])
                    </div>
                    <div class="col">
                        @include('controles.numero', ['control_control' => 'violencia_anio_al'
                                                         , 'control_default'=>$filtros->violencia_anio_al
                                                         ,'control_resaltar' => true
                                                         ,'control_requerido' => false
                                                         , 'control_min' =>1900
                                                          , 'control_max' =>2020
                                                         ,'control_texto'=>'Año de la violencia hasta'])
                    </div>
                </div>
            </div>

            <div class="w-100"></div>

            <div class="col-md-4">
                @include('controles.tipo_aa', ['control_control' => 'violencia_aa'
                                                    ,'control_default' => $filtros->violencia_aa
                                                    , 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_resaltar' => true
                                                    ,'control_select2' => true
                                                   ,'control_texto'=>'Responsabilidad colectiva, Actor Armado:'])
            </div>

            <div class="col-md-4">
                @include('controles.tipo_tc', ['control_control' => 'violencia_tc'
                                                    ,'control_default' => $filtros->violencia_tc
                                                    , 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_resaltar' => true
                                                    ,'control_select2' => true
                                                   ,'control_texto'=>'Responsabilidad colectiva, Tercero Civil:'])
            </div>
            <div class="col-md-4">
                @include('controles.listado_excel', ['control_control' => 'id_excel_listados'
                                                    ,'control_default' => $filtros->id_excel_listados
                                                    , 'control_vacio' => '[Mostrar todos]'
                                                    ,'control_resaltar' => true
                                                    ,'control_select2' => true
                                                   ,'control_texto'=>'Utilizar listados de códigos'])
            </div>
        </div>


    </div>
    <div class="card-footer ">
        <div class="row">
            <div class="col">
                <a href="{{ Request::url() }}"  class="btn btn-secondary">Quitar filtros y mostrar todo</a>
            </div>

            <div class="col text-right">
                <button type="submit" class="btn btn-success ">Aplicar filtros</button>
            </div>
        </div>


    </div>
</div>
{{ Form::close() }}

