<div class="form-group col-sm-4">
    <br>
    {!! Form::label('cantidad_victimas', 'Cantidad de víctimas que sufrieron este hecho:') !!}
    <div class="row col-sm-6">
        {!! Form::number('cantidad_victimas', null, ['class' => 'form-control', 'required'=>'required']) !!}
    </div>

</div>

<div class="form-group col-sm-8">
    @include('controles.geo3', ['control_control' => 'id_lugar'
                                ,'control_texto' => 'Lugar de ocurrencia de los hechos:'
                                , 'control_default'=>$hecho->id_lugar])

</div>

<!-- Sitio Especifico Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sitio_especifico', 'Sitio Específico:') !!}
    {!! Form::text('sitio_especifico', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Lugar Tipo Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_lugar_tipo'
                                           ,'control_id_cat'=>45
                                           , 'control_default'=>$hecho->id_lugar_tipo
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Zona:'])

</div>

<!-- Fecha Ocurencia D Field -->
<div class="form-group col-sm-4">
    @include('controles.fecha_incompleta', ['control_control' => 'fecha_ocurrencia'
                                         , 'control_default'=>$hecho->fecha_ocurrencia
                                         , 'control_texto'=>'Fecha de ocurrencia de los hechos'
                                         , 'required'])
</div>

<div class="form-group col-sm-4">
    @include('controles.fecha_incompleta', ['control_control' => 'fecha_fin'
                                         , 'control_default'=>$hecho->fecha_fin
                                         , 'control_vacio'=>"No aplica"
                                         , 'control_texto'=>'Si los hechos son continuados,¿cuándo finalizaron? '
                                         , 'required'])
</div>

<div class="form-group col-sm-4">
    @include('controles.radio_si_no', ['control_control' => 'aun_continuan'
                                   ,'control_default' => $hecho->aun_continuan

                                   ,'control_texto'=>"Los hechos aún continuan"])
</div>

{{--
<div class="form-group col-sm-12">
    {!! Form::label('observaciones', 'Observaciones sobre las dinámicas:') !!}
    {!! Form::textarea('observaciones', null, ['class' => 'form-control','rows'=>3]) !!}
</div>
--}}

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}

</div>
