
<div class="col-xs-4">
    <div class="form-group ">
        @include('controles.carga_archivo', ['control_control' => 'archivo_4'
                                            ,'control_default' => $adjuntado->nombre_archivo
                                               , 'control_texto'=>"<i class='fa fa-tag' aria-hidden='true'></i> Archivos adjuntos"])
    </div>
</div>

<div class="col-sm-8">
    <br>
    <br>
    <br>
    <br>


    <div class="form-group col-xs-12">
        {!! Form::label('descripcion', 'Descripción para este archivo:') !!}
        {!! Form::text('descripcion', null, ['class' => 'form-control ','required'=>'required','maxlength'=>190]) !!}
    </div>

    <div class="form-group col-xs-12 text-center">
        <button type="submit" class="btn btn-success">Grabar y adjuntar</button>
        <a href="{!! action('censo_archivosController@show',$censoArchivo->id_censo_archivos) !!}" class="btn btn-default pull-right">Regresar a la vista del registro</a>
    </div>

</div>



