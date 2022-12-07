<!-- Nombres Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombres', 'Nombres:') !!}
    {!! Form::text('nombres', null, ['class' => 'form-control']) !!}
</div>

<!-- Apellidos Field -->
<div class="form-group col-sm-6">
    {!! Form::label('apellidos', 'Apellidos:') !!}
    {!! Form::text('apellidos', null, ['class' => 'form-control']) !!}
</div>

<!-- Otros Nombres Field -->
<div class="form-group col-sm-6">
    {!! Form::label('otros_nombres', 'Otros Nombres:') !!}
    {!! Form::text('otros_nombres', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'sexo'
                                           ,'control_id_cat'=>24
                                           , 'control_default'=>$responsable->sexo
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Sexo (asignado al nacer):'])
</div>


<!-- Orientacion Sexual Field -->
<div class="form-group col-sm-6">

    @include('controles.catalogo', ['control_control' => 'id_edad'
                                           ,'control_id_cat'=>29
                                           , 'control_default'=>$responsable->id_edad
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Edad:'])
</div>


<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'pertenencia_etnico_racial'
                                           ,'control_id_cat'=>27
                                           , 'control_default'=>$responsable->pertenencia_etnico_racial
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Pertenencia étnico-racial:'])
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! action('entrevista_individualController@fichas',$expediente->id_e_ind_fvt) !!}" class="btn btn-default">Cancelar</a>
</div>
