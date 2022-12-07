

<!-- Id Autoriza Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fmt_id_autoriza', 'Autorizado por') !!}
    {!! Form::text('fmt_id_autoriza', null, ['class' => 'form-control','disabled'=>'disabled']) !!}
</div>
<div class="clearfix"></div>
<!-- Id Autorizado Field -->
<br>
<br>
<div class="form-group col-sm-6">
    <p>Por este medio autorizo el acceso para la <b>modificación</b> y <b>consulta de archivos adjuntos</b> de la entrevista <span class="text-danger text-bold">{{ $asignacion->codigo_entrevista }}</span>, al usuario indicado.</p>
    @include('controles.entrevistador_todos', ['control_control' => 'id_autorizado'
                                           ,'control_default' => $asignacion->id_autorizado
                                           ,'control_texto'=>"Usuario autorizado:"])
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('observaciones', 'Observaciones / Anotaciones:') !!}
    {!! Form::textarea('observaciones', null, ['class' => 'form-control', 'rows'=>3]) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Autorizar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ url('/') }}" class="btn btn-default">Cancelar</a>
</div>
