<!-- Es Victima Field -->

<style>
    .seccion{
        background-color: #fafafa;
        border-radius: 10px;
        padding-top: 1%;
    }
    @media screen and (min-width: 800px) {
        .seccion{
            width: 97%;
        }
        .complementaria{
            margin-top:2%;
            margin-bottom: 1%;
        }
    }
    @media screen and (max-width: 800px) {
        .seccion{
            width: 89%;
            margin-left:4%;
        }

        .complementaria{
            margin-top:10%;
            margin-bottom: 4%;
        }
    }
    .borderinferior{
        border-bottom: 1px #EEE solid;
    }

</style>

<div class="form-group col-sm-12 borderinferior"></div>

<div class="form-group col-sm-12 seccion" >

<!-- Alias Field -->
<div class="form-group col-sm-6">
    {!! Form::label('alias', 'Nombre identitario/otros nombres/apodo') !!}
    <p>{!! $persona->alias !!}</p>
</div>

<div class="clearfix"></div>

<div class="form-group col-sm-4">
    {!! Form::label('id_sexo', 'Sexo del presunto responsable') !!}
    <p>{!! $persona->sexo !!}</p>
</div>
<div class="form-group col-sm-4">
    {!! Form::label('id_etnia', 'Pertenencia étnico-racial') !!}
    <p>{!! $persona->etnia !!}</p>
</div>
<div class="form-group col-sm-4">
    {!! Form::label('id_edad_aproximada', 'Edad aproximada al momento de los hechos') !!}
    <p>{!! $persona->fmt_id_edad_aproximada !!}</p>
</div>

<div class="clearfix"></div>

<div class="clearfix form-group col-sm-12"></div>
<div class="form-group col-sm-6">
  {!! Form::label('id_rango_cargo', 'Actor armado del que hacía parte') !!}
  <p>{!! $persona->fmt_id_rango_cargo !!}</p>
</div>
<div class="form-group col-sm-6">
@if($persona->id_rango_cargo==276)

  {!! Form::label('id_grupo_paramilitar', 'Grupo paramilitar') !!}
  <p>{!! $persona->fmt_id_grupo_paramilitar !!}</p>

@endif

@if($persona->id_rango_cargo==278)
  {!! Form::label('id_guerrilla', 'Guerrillas') !!}
  <p>{!! $persona->fmt_id_guerrilla !!}</p>
@endif

@if($persona->id_rango_cargo==279)
  {!! Form::label('id_fuerza_publica', 'Fuerza pública') !!}
  <p>{!! $persona->fmt_id_fuerza_publica !!}</p>
@endif

@if($persona->id_rango_cargo==174)
  {!! Form::label('id_otro', 'Otro') !!}
  <p>{!! $persona->fmt_id_otro !!}</p>
@endif
</div>
<div class="clearfix"></div>

<div class="form-group col-sm-12">

  {!! Form::label('fmtResponsabilidad', '¿Cúal es la presunta responsabilidad en el hecho?') !!}
  <p>{!! $persona->fmtResponsabilidad !!}</p>

</div>

<div class="clearfix"></div>

<div class="form-group col-sm-12">
    {!! Form::label('nombre_superior', 'Nombre del superior o el que mandaba en el momento de los hechos:') !!}
    <p>{!! $persona->nombre_superior !!}</p>
</div>

<div class="clearfix"></div>

<div class="form-group col-sm-12">
  {!! Form::label('conoce_info', '¿Sabe qué hace y dónde está el responsable ahora?') !!}
  <p>{!! $persona->fmtconoceinfo !!}</p>


</div>
<div class="clearfix"></div>
@if($persona->conoce_info==1)
<div class="form-group">
<div class="clearfix"></div>
<div class="form-group col-sm-6">
  {!! Form::label('que_hace', '¿Qué hace?') !!}
  <p>{!! $persona->que_hace !!}</p>
</div>
<div class="form-group col-sm-6">
  {!! Form::label('donde_esta', '¿Dónde está?') !!}
  <p>{!! $persona->donde_esta !!}</p>
</div>
</div>

@endif
<div class="clearfix"></div>

<div class="form-group col-sm-12">
  {!! Form::label('otros_hechos', '¿Sabe si participó en otros hechos de violencia?') !!}
  <p>{!! $persona->fmtotroshechos !!}</p>
</div>
<div class="clearfix"></div>
@if($persona->otros_hechos==1)
<div class="form-group">
<div class="clearfix"></div>
<div class="form-group col-sm-12">
  {!! Form::label('cuales', '¿En cuáles?') !!}
  <p>{!! $persona->donde_esta !!}</p>
</div>
</div>
@endif
