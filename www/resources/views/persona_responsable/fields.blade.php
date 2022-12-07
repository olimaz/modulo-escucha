<!-- Es Victima Field -->

    <style>

        #mas
        {
            background-color: #3c8dbc;
            font-size: 2rem;
            color: white;
            font-weight: bold;
            width: 40px;
            height: 40px;
            margin-bottom: 0;
            float:left;
            border-radius: 10px;
            text-align: center;
            padding-top: 6px;
            cursor: pointer;
        }
        #otraOrganizacion{
            width:10%;
            float:left;
            margin-left:1%;
            padding-top: 9px;

        }
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

    <div class="form-group col-sm-12 seccion" >
    <!-- Nombre Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('nombre', 'Nombres') !!}
        {!! Form::text('nombre', null, ['class' => 'form-control', 'maxlength' => 200 ]) !!}
    </div>

    <!-- Apellido Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('apellido', 'Apellidos') !!}
        {!! Form::text('apellido', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
    </div>

    <!-- Alias Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('alias', 'Nombre identitario, otros nombres, apodo, alias') !!}
        {!! Form::text('alias', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
    </div>

<div class="clearfix form-group col-sm-12"></div>
<!-- Fec Nac A Field -->

<div class="form-group col-sm-4">
  @include('controles.catalogo', ['control_control' => 'id_sexo'
                                  ,'control_default' => $persona->id_sexo
                                  ,'control_id_cat' => 24
                                  ,'control_vacio' => '[Ninguno]'
                                  ,'control_texto'=>'Sexo del presunto responsable'])
</div>

<div class="form-group col-sm-4">
    @include('controles.catalogo', ['control_control' => 'id_etnia'
                                    ,'control_default' => $persona->id_etnia
                                    ,'control_id_cat' => 27
                                    ,'control_otro' => true
                                    ,'control_vacio' => '[Ninguno]'
                                    ,'control_texto'=>'Pertenencia étnico-racial'])
    <div id="id_pertenencia_indigena" style="display: none"  class="form-group col-sm-12">
      {!! Form::label('nombre_indigena', 'Nombre grupo pertenencia indigena.') !!}
      {!! Form::text('nombre_indigena', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
    </div>
</div>

<div class="form-group col-sm-4">
  @include('controles.catalogo', ['control_control' => 'id_edad_aproximada'
                                  ,'control_default' => $persona->id_edad_aproximada
                                  ,'control_id_cat' => 29
                                  ,'control_vacio' => '[Ninguno]'
                                  ,'control_texto'=>'Edad aproximada al momento de los hechos'])
</div>

<div class="clearfix form-group col-sm-12"></div>
<div class="form-group col-sm-6">
  @include('controles.catalogo', ['control_control' => 'id_rango_cargo'
                                  ,'control_default' => $persona->id_rango_cargo
                                  ,'control_id_cat' => 34
                                  ,'control_vacio' => '[Ninguno]'
                                  ,'control_texto'=>'Actor armado del que hacía parte'])
</div>

<div id="id_grupo_paramilitar_div" style="display: none"  class="form-group col-sm-6">
  @include('controles.catalogo', ['control_control' => 'id_grupo_paramilitar'
                                  ,'control_default' => $persona->id_grupo_paramilitar
                                  ,'control_id_cat' => 35
                                  ,'control_otro' => true
                                  ,'control_vacio' => '[Ninguno]'
                                  ,'control_texto'=>'Grupo paramilitar'])
</div>

<div id="id_guerrilla_div" style="display: none"  class="form-group col-sm-6">
  @include('controles.catalogo', ['control_control' => 'id_guerrilla'
                                  ,'control_default' => $persona->id_guerrilla
                                  ,'control_id_cat' => 37
                                  ,'control_otro' => true
                                  ,'control_vacio' => '[Ninguno]'
                                  ,'control_texto'=>'Guerrillas'])
</div>

<div id="id_fuerza_publica_div" style="display: none"  class="form-group col-sm-6">
  @include('controles.catalogo', ['control_control' => 'id_fuerza_publica'
                                  ,'control_default' => $persona->id_fuerza_publica
                                  ,'control_id_cat' => 38
                                  ,'control_otro' => true
                                  ,'control_vacio' => '[Ninguno]'
                                  ,'control_texto'=>'Fuerza pública'])
</div>

<div id="id_otro_div" style="display: none"  class="form-group col-sm-6">
  @include('controles.catalogo', ['control_control' => 'id_otro'
                                  ,'control_default' => $persona->id_fuerza_publica
                                  ,'control_id_cat' => 174
                                  ,'control_otro' => true
                                  ,'control_vacio' => '[Ninguno]'
                                  ,'control_texto'=>'Otro'])
</div>

<div class="clearfix"></div>

<div class="form-group col-sm-12">
  @include('controles.catalogo', ['control_control' => 'presunta_responsabilidad'
                                          ,'control_id_cat'=>36
                                          , 'control_default'=>$persona->fmtArregloResponsabilidad
                                          , 'control_multiple'=>true
                                          ,'control_otro' => true
                                          ,'control_texto'=>'¿Cúal es la presunta responsabilidad en el hecho?'])
</div>

<div class="clearfix"></div>

<div class="form-group col-sm-12">
    {!! Form::label('nombre_superior', 'Nombre del superior o el que mandaba en el momento de los hechos:') !!}
    {!! Form::text('nombre_superior', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
</div>

<div class="clearfix"></div>

<div class="form-group col-sm-12">
    @include('controles.radio_si_no_div', ['control_control' => 'conoce_info'
                                        ,'control_default' => $persona->conoce_info
                                        ,'control_div' => "conoce_info_div"
                                       ,'control_texto'=>"¿Sabe qué hace y dónde está el responsable ahora?"])
</div>
<div class="clearfix"></div>
<div class="form-group" id="conoce_info_div">
<div class="clearfix"></div>
<div class="form-group col-sm-6">
  {!! Form::label('que_hace', '¿Qué hace?') !!}
  {!! Form::text('que_hace', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
</div>
<div class="form-group col-sm-6">
  {!! Form::label('donde_esta', '¿Dónde está?') !!}
  {!! Form::text('donde_esta', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
</div>
</div>


<div class="clearfix"></div>

<div class="form-group col-sm-12">
    @include('controles.radio_si_no_div', ['control_control' => 'otros_hechos'
                                        ,'control_default' => $persona->otros_hechos
                                        ,'control_div' => "otros_hechos_div"
                                       ,'control_texto'=>"¿Sabe si participó en otros hechos de violencia?"])
</div>
<div class="clearfix"></div>
<div class="form-group" id="otros_hechos_div">
<div class="clearfix"></div>
<div class="form-group col-sm-12">
  {!! Form::label('cuales', '¿En cuáles?') !!}
  {!! Form::text('cuales', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
</div>

</div>

</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary', 'id'=>'btn_guardar_responsable']) !!}
    @if($persona->id_hecho)
      <a href="{!! action('hechoController@edit', [$persona->id_hecho]) !!}" class="btn btn-default">Volver</a>
    @else

      @if ($tipo_entrevista=='individual')
          <a href="{!! route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default">Volver</a>
      @else
          <a href="{!! route('entrevistaEtnica.fichas', [$persona->id_entrevista_etnica]) !!}" class="btn btn-default">Volver</a>
      @endif

    @endif

</div>

@push('js')
<script type="text/javascript">
$( "#id_rango_cargo" ).change(function() {
  // alert({{config('expedientes.aa_gp')}});
  if(this.value=={{ config('expedientes.aa_gp')}})
  {
    $( "#id_grupo_paramilitar_div").show();
    $( "#id_guerrilla_div").hide();
    $( "#id_fuerza_publica_div").hide();
    $( "#id_otro_div").hide();
  }
  else if(this.value=={{ config('expedientes.aa_gu')}})
  {
    $( "#id_grupo_paramilitar_div").hide();
    $( "#id_guerrilla_div").show();
    $( "#id_fuerza_publica_div").hide();
    $( "#id_otro_div").hide();
  }
  else if(this.value=={{ config('expedientes.aa_fp')}})
  {
    $( "#id_grupo_paramilitar_div").hide();
    $( "#id_guerrilla_div").hide();
    $( "#id_fuerza_publica_div").show();
    $( "#id_otro_div").hide();
  }
  else {
    $( "#id_grupo_paramilitar_div").hide();
    $( "#id_guerrilla_div").hide();
    $( "#id_fuerza_publica_div").hide();
    $( "#id_otro_div").show();
  }



});
$( "#id_etnia" ).change(function() {
  if(this.value== {{ config('expedientes.indigena') }})
  {$( "#id_pertenencia_indigena").show();}
  else
  {$( "#id_pertenencia_indigena").hide();}

});

$( document ).ready(function() {
  //  if("#id_etnia_1").checked())
  if( $('#id_etnia').value== {{ config('expedientes.indigena') }} )
  {$( "#id_pertenencia_indigena").show();}




  if($('#id_rango_cargo').val()=={{ config('expedientes.aa_gp')}})
  {
    $( "#id_grupo_paramilitar_div").show();
    $( "#id_guerrilla_div").hide();
    $( "#id_fuerza_publica_div").hide();
    $( "#id_otro_div").hide();
  }
  else if($('#id_rango_cargo').val()=={{ config('expedientes.aa_gu')}})
  {
    $( "#id_grupo_paramilitar_div").hide();
    $( "#id_guerrilla_div").show();
    $( "#id_fuerza_publica_div").hide();
    $( "#id_otro_div").hide();
  }
  else if($('#id_rango_cargo').val()=={{ config('expedientes.aa_fp')}})
  {
    $( "#id_grupo_paramilitar_div").hide();
    $( "#id_guerrilla_div").hide();
    $( "#id_fuerza_publica_div").show();
    $( "#id_otro_div").hide();
  }

  $("#btn_guardar_responsable").click(function() {

    if ($("#nombre").val().trim() == "" && $("#apellido").val().trim() == ""  && $("#alias").val().trim() == "") {
        
        alert('Favor ingresar por lo menos uno de estos tres datos: Nombres, Apellidos o Nombre identitario');
        $("#nombre").focus();
        return false;
    }

    return true;
  });

});
</script>
@endpush
