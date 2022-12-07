

<!-- Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'required'=>'required','maxlength'=>'200']) !!}
</div>

<!-- Id Sexo Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_sexo'
                                    ,'control_default' => $misCasosPersona->id_sexo
                                    ,'control_id_cat' => 24
                                    //,'control_vacio' => '[Ninguno]'
                                    ,'control_texto'=>'Sexo'])
</div>

<!-- Contacto Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('contacto', 'Forma de contactarlo (telefono, correo, instrucciones):') !!}
    {!! Form::textarea('contacto', null, ['class' => 'form-control','rows'=>3]) !!}
</div>

<!-- Id Contactado Field -->
<div class="form-group col-sm-4">
    @include('controles.radio_si_no', ['control_control' => 'id_contactado'
                                   ,'control_texto'=>'Ya fué contactada'])
</div>

<!-- Id Contactado Field -->
<div class="form-group col-sm-4">
    @include('controles.radio_si_no', ['control_control' => 'id_entrevistado'
                                   ,'control_texto'=>'Ya fué entrevistada'])
</div>
<!-- Id Entrevistado Field -->
<div class="form-group col-sm-4">
    {!! Form::label('codigo', 'Código de entrevista:') !!}
    {!! Form::text('codigo', null, ['class' => 'form-control']) !!}
</div>
<div class="clearfix"></div>

<div class="form-group col-sm-6">
    @include('controles.fecha', ['control_control' => 'entrevista_fecha'
                                        , 'control_default'=>$misCasosPersona->editar_fecha
                                        , 'control_requerido' => false
                                        , 'control_max' => 'false'
                                        ,'control_texto'=>'Fecha de entrevista'])
</div>

<div class="form-group col-sm-6">
    @include('controles.hora', ['control_control' => 'entrevista_hora'
                                        , 'control_default'=>$misCasosPersona->editar_hora
                                        , 'control_requerido' => false
                                        ,'control_texto'=>'Hora de entrevista'])
</div>


<!-- Anotaciones Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('anotaciones', 'Anotaciones:') !!}
    {!! Form::textarea('anotaciones', null, ['class' => 'form-control', 'rows'=>3]) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ action('mis_casosController@show',$misCasosPersona->id_mis_casos) }}" class="btn btn-default">Cancelar</a>
</div>
