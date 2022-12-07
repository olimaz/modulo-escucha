@php
        $default_fluidez = isset($default_fluidez) ? $default_fluidez : 1;
        $default_cierre = isset($default_cierre) ? $default_cierre : 1;
        $default_d_hecho = isset($default_d_hecho) ? $default_d_hecho : 1;
        $default_d_contexto = isset($default_d_contexto) ? $default_d_contexto : 1;
        $default_d_impacto = isset($default_d_impacto) ? $default_d_impacto : 1;
        $default_d_justicia = isset($default_d_justicia) ? $default_d_justicia : 1;
        $default_ahora_entiendo = isset($default_ahora_entiendo) ? $default_ahora_entiendo : "";
        $default_cambio_perspectiva = isset($default_cambio_perspectiva) ? $default_cambio_perspectiva : "";
@endphp

        <div class="col-md-6 ">
            <div class="form-group">
                @include('controles.criterio_fijo', ['control_control' => 'fluidez'
                                        , 'control_id' =>'p_fluidez'
                                       ,'control_grupo'=>25
                                       , 'control_default'=> $default_fluidez
                                       ,'control_texto'=>'La entrevista se desarrolla con fluidez:'])
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="form-group">
                @include('controles.criterio_fijo', ['control_control' => 'cierre'
                                        ,'control_id' => 'p_cierre'
                                       ,'control_grupo'=>25
                                       , 'control_default'=>$default_cierre
                                       ,'control_texto'=>'Se realiza un cierre al final de la entrevista:'])
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6 ">
            <div class="form-group">
                @include('controles.criterio_fijo', ['control_control' => 'd_hecho'
                                       ,'control_id' => 'p_d_hecho'
                                       ,'control_grupo'=>26
                                       , 'control_default'=>$default_d_hecho
                                       ,'control_texto'=>'Nivel de detalle de los hechos:'])
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="form-group">
                @include('controles.criterio_fijo', ['control_control' => 'd_contexto'
                                       ,'control_id' => 'p_d_contexto'
                                       ,'control_grupo'=>26
                                       , 'control_default'=>$default_d_contexto
                                       ,'control_texto'=>'Nivel de de detalle del contexto:'])
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6 ">
            <div class="form-group">
                @include('controles.criterio_fijo', ['control_control' => 'd_impacto'
                                       ,'control_id' => 'p_d_impacto'
                                       ,'control_grupo'=>26
                                       , 'control_default'=>$default_d_impacto
                                       ,'control_texto'=>'Nivel de de detalle de los impactos:'])
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="form-group">
                @include('controles.criterio_fijo', ['control_control' => 'd_justicia'
                                        ,'control_id' => 'p_d_justicia'
                                       ,'control_grupo'=>26
                                       , 'control_default'=>$default_d_justicia
                                       ,'control_texto'=>'Acceso a la justicia e iniciativas de no repetición:'])
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-md-12 ">
            <div class="form-group">
                {!! Form::label('ahora_entiendo','Opcional. Esta entrevista me permitió comprender lo siguiente:') !!}
                {!! Form::text('ahora_entiendo', $default_ahora_entiendo, ['class' => 'form-control','rows'=>3]) !!}
            </div>
        </div>
        <div class="col-md-12 ">
            <div class="form-group">
                <div class="form-group">
                    {!! Form::label('cambio_perspectiva','Opcional. Esta entrevista ofrece explicaciones alternativas acerca de: ') !!}
                    {!! Form::text('cambio_perspectiva', $default_cambio_perspectiva, ['class' => 'form-control','rows'=>3]) !!}
                </div>
            </div>
        </div>
