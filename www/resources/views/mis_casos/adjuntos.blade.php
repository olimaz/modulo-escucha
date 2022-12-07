
<div class="col-xs-4">
    <div class="form-group ">
        @include('controles.carga_archivo', ['control_control' => 'archivo_4'
                                            ,'control_default' => $adjuntado->nombre_archivo
                                               , 'control_texto'=>"<i class='fa fa-tag' aria-hidden='true'></i> Archivos adjuntos"])
    </div>
</div>

<div class="col-sm-8">
    <div class="form-group col-sm-6">
        <label>Sección</label> <br>
        <p> {{ \App\Models\criterio_fijo::describir(50,$id_seccion) }}</p>

    </div>
    <div class="form-group col-sm-6">
        @include('controles.catalogo', ['control_control' => 'id_categoria'
                                          ,'control_id_cat'=>\App\Models\mis_casos_adjunto::catalogo_seccion($id_seccion)
                                          , 'control_default'=>$adjuntado->id_categoria
                                          , 'control_multiple' => false
                                          , 'control_requerido' => true
                                          ,'control_texto'=>'Categoría:'])
    </div>
    <div class="clearfix"></div>
    <div class="form-group col-xs-12">
        @include('controles.radio_si_no', ['control_control' => 'clasificacion_nivel'
                                          ,'control_opciones'=>[1=>'Reservado 1', 2=>'Reservado 2', 3=>'Reservado 3', 4=>'Reservado 4']
                                          , 'control_default'=> $adjuntado->clasificacion_nivel
                                          , 'control_multiple' => false
                                          , 'control_requerido' => true
                                          ,'control_texto'=>'Clasificación:'])
    </div>
    <div class="form-group col-xs-12">
        {!! Form::label('descripcion', 'Descripción para este archivo:') !!}
        {!! Form::text('descripcion', null, ['class' => 'form-control ','required'=>'required','maxlength'=>190]) !!}
    </div>
    <div class="form-group col-xs-12">
        {!! Form::label('anotaciones', 'Anotaciones (opcional):') !!}
        {!! Form::textarea('anotaciones', null, ['class' => 'form-control ','rows'=>3]) !!}
    </div>

    <div class="form-group col-xs-12 text-center">
        <button type="submit" class="btn btn-success">Grabar y adjuntar</button>
        <a href="{!! action('mis_casosController@show',$miCaso->id_mis_casos) !!}" class="btn btn-default pull-right">Regresar a la vista del caso</a>
    </div>

</div>



