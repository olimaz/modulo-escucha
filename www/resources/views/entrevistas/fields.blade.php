  <div class="content col-sm-6">
<div class="box box-primary box-solid">

  <div class="box-header">
      <h3 class="box-title">ESPECIFICACIONES DE LA ENTREVISTA </h3>

    </div>
        <div class="box-body">
<div class="form-group col-sm-6">
    <label for="title">CONDICIONES ACORDADAS/PREPARACIÓN PREVIA DE LA ENTREVISTA</label>
</div>
<div class="clearfix"></div>
<!-- Condiciones field -->
<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'id_condicion'
                                            ,'control_id_cat'=>40
                                            , 'control_default'=>$entrevista->arreglo_acompanamiento
                                            , 'control_multiple'=>true
                                            , 'control_requerido' => false
                                            ,'control_otro' => true
                                            , 'control_vacio' => 'Ninguno'
                                            ,'control_texto'=>'Acompañamiento'])
</div>
<div class="clearfix"></div>

<!-- Id Idioma Field -->
<div class="form-group col-sm-6">
   @include('controles.catalogo', ['control_control' => 'id_idioma'
                                          ,'control_default' => $entrevista->id_idioma
                                          ,'control_id_cat' => 22
                                          ,'control_otro' => true
                                          //,'control_vacio' => '[Ninguno]'
                                          ,'control_texto'=>'Lengua/Idioma del testimonio:'])
</div>

<!-- Id Nativo Field -->
@if($entrevista->id_idioma!=178)
<div class="form-group" style="display: none" id="id_nativo_div">
  @elseif($entrevista->id_idioma==178)
<div class="form-group" id="id_nativo_div">
@endif

<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_nativo'
                                         ,'control_default' => $entrevista->id_nativo
                                         ,'control_id_cat' => 23
                                         ,'control_texto'=>'Idiomas nativos:'])

</div>
</div>

<!-- Nombre Interprete Field -->
@if($entrevista->id_idioma==177)
<div class="form-group col-sm-12"  style="display: none" id="nombre_interprete_div">
  @elseif($entrevista->id_idioma!=177)
<div class="form-group col-sm-12" id="nombre_interprete_div">

@endif

    {!! Form::label('nombre_interprete', 'Indicar nombres y apellidos del interprete:') !!}
    {!! Form::text('nombre_interprete', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
</div>
<div class="clearfix"></div>
<!-- Documentacion Aporta Field -->
<hr>
<hr>
<div class="form-group col-sm-12">
  @include('controles.radio_si_no_cual', ['control_control' => 'documentacion_aporta'
                                         ,'control_control_cual' => 'documentacion_especificar'
                                         ,'control_texto' => 'Quien declara, ¿Aporta documentación relacionada con los hechos?'
                                         ,'control_default' => $entrevista->documentacion_aporta
                                         ,'control_default_cual' => $entrevista->documentacion_especificar
                                         ,'control_tipo' => 2
                                         ,'control_texto_cual'=>"Especificar cuál (por ejemplo, recortes de periódicos, cosas personales, documentos, fotos, denuncias, sentencias, etc.):"])
</div>
<!-- Documentacion Especificar Field -->

<div class="clearfix"></div>
<hr>
<!-- Identifica Testigos Field -->
<div class="form-group col-sm-12">
    @include('controles.radio_si_no_div', ['control_control' => 'identifica_testigos'
                                        ,'control_default' => $entrevista->identifica_testigos
                                        ,'control_div' => "testigos_div"
                                       ,'control_texto'=>"Conoce otros/as testigos de los hechos"])
</div>
<div class="clearfix"></div>
<div class="form-group" id="testigos_div">
<div class="form-group col-sm-12">
<label for="title">Nombre y forma de contacto de esos/as otro/as testigos de los hechos:</label>
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-6">
    {!! Form::label('testigo_nombre[]', 'Nombre testigo:') !!}
    {!! Form::text('testigo_nombre[]', $entrevista->arreglo_testigo[0]->nombre, ['class' => 'form-control',  'rows' => 3,'maxlength' => 200]) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('testigo_contacto[]', 'Forma de contacto:') !!}
    {!! Form::text('testigo_contacto[]', $entrevista->arreglo_testigo[0]->contacto, ['class' => 'form-control',  'rows' => 3,'maxlength' => 200]) !!}
</div>

<div class="clearfix"></div>
<div class="form-group col-sm-6">
    {!! Form::label('testigo_nombre[]', 'Nombre testigo:') !!}
    {!! Form::text('testigo_nombre[]', $entrevista->arreglo_testigo[1]->nombre, ['class' => 'form-control',  'rows' => 3,'maxlength' => 200]) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('testigo_contacto[]', 'Forma de contacto:') !!}
    {!! Form::text('testigo_contacto[]', $entrevista->arreglo_testigo[1]->contacto, ['class' => 'form-control',  'rows' => 3,'maxlength' => 200]) !!}
</div>
</div>

<div class="clearfix"></div>
<hr>


<!-- Ampliar Relato Field -->
<div class="form-group col-sm-12">
  @include('controles.radio_si_no_cual', ['control_control' => 'ampliar_relato'
                                         ,'control_control_cual' => 'ampliar_relato_temas'
                                         ,'control_texto' => 'Se recomienda ampliar el relato:'
                                         ,'control_default' => $entrevista->ampliar_relato
                                         ,'control_default_cual' => $entrevista->ampliar_relato_temas
                                         ,'control_tipo' => 2
                                         ,'control_texto_cual'=>"En los siguientes temas:"])


</div>


<div class="clearfix"></div>
<hr>
<!-- Priorizar Entrevista Field -->
<div class="form-group col-sm-12">
  @include('controles.radio_si_no_cual', ['control_control' => 'priorizar_entrevista'
                                         ,'control_control_cual' => 'priorizar_entrevista_asuntos'
                                         ,'control_texto' => 'Se recomienda priorizar la entrevista para el análisis:'
                                         ,'control_default' => $entrevista->priorizar_entrevista
                                         ,'control_default_cual' => $entrevista->priorizar_entrevista_asuntos
                                         ,'control_tipo' => 2
                                         ,'control_texto_cual'=>"De los siguientes asuntos:"])

</div>

<div class="clearfix"></div>
<hr>
<!-- Contiene Patrones Field -->
<div class="form-group col-sm-12">
  @include('controles.radio_si_no_cual', ['control_control' => 'contiene_patrones'
                                         ,'control_control_cual' => 'contiene_patrones_cuales'
                                         ,'control_texto' => 'A criterio del entrevistador/a ¿Cree que la entrevista realizada aporta elementos para identificar patrones de violencia o contextos explicativos?'
                                         ,'control_default' => $entrevista->contiene_patrones
                                         ,'control_default_cual' => $entrevista->contiene_patrones_cuales
                                         ,'control_tipo' => 2
                                         ,'control_texto_cual'=>"¿Cuáles?"])
</div>

<div class="clearfix"></div>
<hr>
<!-- Indicaciones Transcripcion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('indicaciones_transcripcion', 'Si lo considera necesario, utilice el siguiente espacio para anotar indicaciones para la transcripción.') !!}
    {!! Form::textarea('indicaciones_transcripcion', null, ['class' => 'form-control',  'rows' => 3]) !!}
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('observaciones', 'Indicar en el espacio que sigue otras observaciones que tenga respecto a la entrevista.') !!}
    {!! Form::textarea('observaciones', null, ['class' => 'form-control',  'rows' => 3]) !!}
</div>






<!-- Submit Field -->
<div class="form-group col-sm-12">
    <div id="boton_guardar_div"  style="display: none" >
    {!! Form::submit('Guardar entrevista', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('entrevistaindividual.fichas', [$entrevista->id_e_ind_fvt]) !!}" class="btn btn-default">Cancelar</a>
  </div>
  <div id="mensaje_conceder_entrevista_div">
  <div class="alert alert-danger">Para poder continuar, la persona entrevistada debe conceder permiso para realizar la entrevista.</div>
  <a href="{!! route('entrevistaindividual.fichas', [$entrevista->id_e_ind_fvt]) !!}" class="btn btn-default">Cancelar</a>
  </div>


</div>

</div>
</div>
</div>

<!--  BLOQUE DE COSENTIMIENTO INFORMADO-->
  <div class="content col-sm-6">
<div class="box box-success box-solid ">

  <div class="box-header">
      <h3 class="box-title">CONSENTIMIENTO INFORMADO</h3>

    </div>
        <div class="box-body">
          <div class="form-group col-sm-12">

              {!! Form::label('identificacion_consentimiento', 'Número de identificación:') !!}
              {!! Form::text('identificacion_consentimiento', null, ['class' => 'form-control', 'required']) !!}
          </div>
<div class="form-group col-sm-12">
  @include('controles.radio_si_no', ['control_control' => 'conceder_entrevista'
                                      ,'control_default' => $entrevista->conceder_entrevista
                                      ,'control_texto'=>"¿Está de acuerdo en conceder entrevistas a la Comisión de la Verdad?"])
</div>
<div class="form-group col-sm-12">
  @include('controles.radio_si_no', ['control_control' => 'grabar_audio'
                                      ,'control_default' => $entrevista->grabar_audio
                                      ,'control_texto'=>"¿Está de acuerdo en que la Comisión grabe el audio para la entrevista?"])
</div>
<div class="form-group col-sm-12">
  @include('controles.radio_si_no', ['control_control' => 'elaborar_informe'
                                      ,'control_default' => $entrevista->elaborar_informe
                                      ,'control_texto'=>"¿Está de acuerdo en que su entrevista sea utilizada para elaborar el informe Final?"])
</div>
<div class="form-group col-sm-12">
    <label for="title">AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES</label>
    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">¿Autoriza el tratamiento de sus datos para las siguientes finalidades?</th>
      <th scope="col">Datos personales</th>
      <th scope="col">Datos sensibles</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Analizarlos, compararlos, contrastarlos con otros datos e información recolectada.</td>

          <td>  @include('controles.radio_si_no', ['control_control' => 'tratamiento_datos_analizar'
                                            ,'control_default' => $entrevista->tratamiento_datos_analizar
                                            ,'control_texto'=>"-1"])  </td>

      <td>       @include('controles.radio_si_no', ['control_control' => 'tratamiento_datos_analizar_sensible'
                                                ,'control_default' => $entrevista->tratamiento_datos_analizar_sensible
                                                ,'control_texto'=>"-1"])</td>
    </tr>
    <tr>
      <td>  Utilizarlos para la elaboración del informe Final de la Comisión de la Verdad.</td>
      <td>@include('controles.radio_si_no', ['control_control' => 'tratamiento_datos_utilizar'
                                         ,'control_default' => $entrevista->tratamiento_datos_utilizar
                                         ,'control_texto'=>"-1"])</td>
      <td>@include('controles.radio_si_no', ['control_control' => 'tratamiento_datos_utilizar_sensible'
                                         ,'control_default' => $entrevista->tratamiento_datos_utilizar_sensible
                                         ,'control_texto'=>"-1"])</td>
    </tr>
    <tr>
      <td>Publicar su nombre en el informe Final.</td>
      <td>@include('controles.radio_si_no', ['control_control' => 'tratamiento_datos_publicar'
                                         ,'control_default' => $entrevista->tratamiento_datos_publicar
                                         ,'control_texto'=>"-1"])</td>
      <td></td>
    </tr>
  </tbody>
</table>

</div>
</div>

</div>

</div>

<div class="clearfix"></div>
@push('js')
<script type="text/javascript">
$( "#id_idioma" ).change(function() {
  if(this.value==178)
  {$( "#id_nativo_div").show();}
  else
  {$( "#id_nativo_div").hide();}

  if(this.value!=177)
  {$( "#nombre_interprete_div").show();}
  else
  {$( "#nombre_interprete_div").hide();}

});

$('.icheck').on('ifChanged',function() {
  var si = $('#conceder_entrevista_1').iCheck('update')[0].checked;
  if(si) {
    $( "#boton_guardar_div").show();
    $( "#mensaje_conceder_entrevista_div").hide();
  }
  else {
        $( "#boton_guardar_div").hide();
        $( "#mensaje_conceder_entrevista_div").show();
  }

});

$( document ).ready(function() {
  var si = $('#conceder_entrevista_1').iCheck('update')[0].checked;
  if(si) {
    $( "#boton_guardar_div").show();
    $( "#mensaje_conceder_entrevista_div").hide();
  }
  else {
        $( "#boton_guardar_div").hide();
        $( "#mensaje_conceder_entrevista_div").show();
  }
});


</script>
@endpush


@section('scripts')
    <script type="text/javascript">
        $('#updated_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection
