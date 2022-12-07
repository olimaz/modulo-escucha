<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                            ,'control_id_cat'=>208
                                            , 'control_default'=>$exilio->arreglo_impacto(208)
                                            , 'control_multiple' => true
                                            , 'control_requerido' => false
                                            , 'control_otro' => true
                                            ,'control_texto'=>'Impactos en la primera salida / primera llegada:'])
</div>

<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                            ,'control_id'=>'pregunta_2'
                                            ,'control_id_cat'=>209
                                            , 'control_default'=>$exilio->arreglo_impacto(209)
                                            , 'control_multiple' => true
                                            , 'control_requerido' => false
                                            , 'control_otro' => true
                                            ,'control_texto'=>'Afrontamiento en la primera llegada:'])
</div>
<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                            ,'control_id'=>'pregunta_3'
                                            ,'control_id_cat'=>210
                                            , 'control_default'=>$exilio->arreglo_impacto(210)
                                            , 'control_multiple' => true
                                            , 'control_requerido' => false
                                            , 'control_otro' => true
                                            ,'control_texto'=>'Impactos de largo plazo del exilio:'])
</div>

<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'id_impacto'
                                            ,'control_id'=>'pregunta_4'
                                            ,'control_id_cat'=>211
                                            , 'control_default'=>$exilio->arreglo_impacto(211)
                                            , 'control_multiple' => true
                                            , 'control_requerido' => false
                                            , 'control_otro' => true
                                            ,'control_texto'=>'Afrontamiento en el largo plazo:'])
</div>



<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}
</div>
