{!! Form::hidden('id_entrevistador', $miCaso->id_entrevistador) !!}

{{--  Correlativo de la entrevista --}}
<div class="form-group col-sm-4">
    {!! Form::label('entrevista_numero', 'Código del caso: '.$miCaso->prefijo_codigo()) !!}
    {!! Form::number('entrevista_numero', null, ['class' => 'form-control','required'=>'required','maxlength'=>5, 'title'=>'Se sugiere utilizar este número, pero puede modificarlo si fuera el caso','data-toggle'=>"tooltip" ]) !!}
</div>

{{--  Macroterritorio --}}
<div class="form-group col-sm-8">
    @include('controles.cev2', ['control_control' => 'id_territorio'
                                                , 'control_territorio'=>$miCaso->id_territorio])
</div>
<div class="clearfix"></div>


{{--  Nombre --}}
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('nombre', 'Nombre corto para identificar el caso:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

{{-- Descripcion --}}
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('descripcion', 'Breve descripción:') !!}
    {!! Form::textarea('descripcion', null, ['class' => 'form-control','rows'=>3,'required'=>'required']) !!}
</div>

{{-- investigacion judicial --}}
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('investigacion_judicial', 'Referencias a investigaciones judiciales:') !!}
    {!! Form::textarea('investigacion_judicial', null, ['class' => 'form-control','rows'=>3]) !!}
</div>
{{-- medidas de reparacion --}}
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('medidas_reparacion', 'Referencias a medidas de reparación/restitución:') !!}
    {!! Form::textarea('medidas_reparacion', null, ['class' => 'form-control','rows'=>3]) !!}
</div>
{{-- tiempo --}}
<div class="form-group col-sm-4">
    <label>Período de tiempo que cubre el caso</label>
    <div class="form-group col-sm-6">
        {!! Form::label('anyo_inicio', 'Año inicial:') !!}
        {!! Form::number('anyo_inicio', null, ['class' => 'form-control','required'=>'required']) !!}
    </div>
    <div class="form-group  col-sm-6">
        {!! Form::label('anyo_fin', 'Año final:') !!}
        {!! Form::number('anyo_fin', null, ['class' => 'form-control','required'=>'required']) !!}
    </div>
</div>
{{-- espacio --}}
<div class="form-group col-sm-8">
    <div class="col-xs-12">
        <label>Ubicación espacial del caso</label>
    </div>
    <div class="form-group col-sm-4">
        @include('controles.catalogo', ['control_control' => 'id_ambito'
                                           ,'control_id_cat'=>102
                                           , 'control_default'=>$miCaso->id_ambito
                                           , 'control_multiple'=>false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Ámbito'])
    </div>
    <div class="form-group  col-sm-8">
        {!! Form::label('territorio', 'Describa la cobertura geográfica:') !!}
        {!! Form::text('territorio', null, ['class' => 'form-control','required'=>'required']) !!}
    </div>
</div>
{{-- tipo de caso --}}
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_tipo_victima'
                                       ,'control_id_cat'=>101
                                       , 'control_default'=>$miCaso->id_tipo_victima
                                       , 'control_multiple'=>false
                                       , 'control_requerido' => true
                                       ,'control_texto'=>'Tipo de sujeto (victima/actor armado/tercero civil) caso:'])
</div>
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_sector'
                                            ,'control_id_cat'=>18
                                            , 'control_default'=>$miCaso->arreglo_detalle(18)
                                            , 'control_multiple'=>true
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Sector/es con el que se puede identificar el caso:'])
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_violencia'
                                       ,'control_id_cat'=>5
                                       , 'control_default'=>$miCaso->arreglo_detalle(5)
                                       , 'control_multiple'=>true
                                       , 'control_requerido' => true
                                       ,'control_texto'=>'Violencia mencionada en el caso:'])
</div>
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_patron'
                                       ,'control_id_cat'=>280
                                       , 'control_default'=>$miCaso->arreglo_detalle(280)
                                       , 'control_multiple'=>true
                                       , 'control_requerido' => false
                                       ,'control_texto'=>'Patrones referidos dentro del caso (si aplica):'])
</div>
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_fr'
                                       ,'control_id_cat'=>4
                                       , 'control_default'=>$miCaso->arreglo_detalle(4)
                                       , 'control_multiple'=>true
                                       , 'control_requerido' => false
                                       ,'control_texto'=>'Referencias a Fuerzas Responsables (si aplica):'])
</div>
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_tc'
                                       ,'control_id_cat'=>10
                                       , 'control_default'=>$miCaso->arreglo_detalle(10)
                                       , 'control_multiple'=>true
                                       , 'control_requerido' => false
                                       ,'control_texto'=>'Referencias a Terceros Civiles (si aplica):'])
</div>
<div class="clearfix"></div>

{{-- Anotaciones --}}
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('observaciones', 'Anotaciones/Observaciones:') !!}
    {!! Form::textarea('observaciones', null, ['class' => 'form-control','rows'=>3]) !!}
</div>


<div class="clearfix"></div>


{{-- MARCAS --}}
{{--
<hr>
<div class="col-xs-12">
    <label class="text-primary">Criterio para asociar entrevistas con este caso</label>
    @include('controles.marca', ['control_control' => 'id_marca'
                                , 'control_nuevos' => false
                                , 'control_mostrar_grupo' => true
                                , 'control_default' => $miCaso->arreglo_marcas()
                                , 'control_resaltar' => false
                                ,'control_texto'=>'Incluir todas aquellas entrevistas que hayan sido marcadas como:'])
</div>
--}}


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ action('mis_casosController@show',$miCaso->id_mis_casos) }}" class="btn btn-default">Cancelar</a>
</div>
