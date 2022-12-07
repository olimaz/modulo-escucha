

<!-- Id Entrevistador Field -->
<div class="form-group col-sm-5">
        @include('controles.entrevistador_todos', ['control_control' => 'id_entrevistador'
                            , 'control_mi_mismo'=>false
                            ,'control_texto'=>'Autorizar acceso al usuario:'])
</div>

<!-- Id Perfil Field -->
<div class="form-group col-sm-4">
    @include('controles.criterio_fijo', ['control_control' => 'id_perfil'
                                               ,'control_grupo'=>51
                                               ,'control_default'=>5
                                               ,'control_texto'=>'Perfil autorizado:'])
</div>

<!-- Submit Field -->
<div class="form-group col-sm-3">
    <br>
    {!! Form::submit('Otorgar acceso', ['class' => 'btn btn-primary']) !!}
</div>
