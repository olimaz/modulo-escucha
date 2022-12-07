@php($entrevistador = isset($entrevistador) ? $entrevistador : \Auth::user())

<!-- Id Territorial Field -->
<div class="form-group col-sm-6">
    @include('controles.cev2', ['control_control' => 'id_territorio'
                                                ,'control_territorio' =>$entrevistador->id_territorio
                                                , 'control_default'=>0])
</div>
<!-- Id Ubicacion Field -->
<div class="form-group col-sm-12">
    {!! Form::label('yyz', 'Ubicación predeterminada') !!}

    @include('controles.geo3', ['control_control' => 'id_ubicacion'
                                               , 'control_default'=>$entrevistador->id_ubicacion])
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    <a class="btn btn-default" href="{{ action('entrevistadorController@show',$entrevistador->id_entrevistador) }}">Cancelar</a>
    {!! Form::submit('Grabar cambios', ['class' => 'btn btn-primary pull-right']) !!}


</div>
