 <div class="clearfix"></div>

 <div class="content col-sm-12">
  <div class="box box-primary box-solid">

    <div class="box-header">
      <h3 class="box-title">ESPECIFICACIONES DE LA ENTREVISTA </h3>

    </div>
    <div class="box-body">

 <div class="form-group col-sm-12">
   <label for="title">CONDICIONES ACORDADAS/PREPARACIÓN PREVIA DE LA ENTREVISTA</label>
 </div>
 <!-- <div class="clearfix"></div> -->
 <!-- Condiciones field -->
 <div class="content col-sm-6">
 <div class="form-group col-sm-12">
   @include('controles.catalogo', ['control_control' => 'id_condicion'
                                           ,'control_id_cat'=>40
                                           , 'control_default'=>$entrevista->arreglo_acompanamiento
                                           , 'control_multiple'=>true
                                           , 'control_requerido' => false
                                           ,'control_otro' => true
                                           ,'control_texto'=>'Acompañamiento'])
 </div>
 <!-- <div class="clearfix"></div> -->

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
   {!! Form::text('nombre_interprete',$entrevista->nombre_interprete, null, ['class' => 'form-control', 'maxlength' => 200]) !!}
 </div>
 <!-- <div class="clearfix"></div> -->
 <!-- Documentacion Aporta Field -->

 <!-- Indicaciones Transcripcion Field -->
 <div class="form-group col-sm-12 col-lg-12">
   {!! Form::label('indicaciones_transcripcion', 'Si lo considera necesario, utilice el siguiente espacio para anotar indicaciones para la transcripción.') !!}
   {!! Form::textarea('indicaciones_transcripcion', $entrevista->indicaciones_transcripcion, null, ['class' => 'form-control  text-expand',  'rows' => 3]) !!}
 </div>

 <!-- Observaciones Field -->
 <div class="form-group col-sm-12 col-lg-12">
   {!! Form::label('observaciones', 'Indicar en el espacio que sigue otras observaciones que tenga respecto a la entrevista.') !!}
   {!! Form::textarea('observaciones',$entrevista->observaciones, null, ['class' => 'form-control text-expand',  'rows' => 3]) !!}
 </div>
 </div>
 <div class="form-group col-sm-6">
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

<hr>
<hr>
 <!-- Identifica Testigos Field -->
 <div class="form-group col-sm-12">
   <hr>
   @include('controles.radio_si_no_div', ['control_control' => 'identifica_testigos'
                                       ,'control_default' => $entrevista->identifica_testigos
                                       ,'control_div' => "testigos_div"
                                      ,'control_texto'=>"Conoce otros/as testigos de los hechos"])
 </div>
 <!-- <div class="clearfix"></div> -->
 <div class="form-group" id="testigos_div">
 <div class="form-group col-sm-12">
 <label for="title">Nombre y forma de contacto de esos/as otro/as testigos de los hechos:</label>
 </div>
 <!-- <div class="clearfix"></div> -->
 <div class="form-group col-sm-6">
   {!! Form::label('testigo_nombre[]', 'Nombre testigo:') !!}
   {!! Form::text('testigo_nombre[]', $entrevista->arreglo_testigo[0]->nombre, ['class' => 'form-control',  'rows' => 3,'maxlength' => 200]) !!}
 </div>
 <div class="form-group col-sm-6">
   {!! Form::label('testigo_contacto[]', 'Forma de contacto:') !!}
   {!! Form::text('testigo_contacto[]', $entrevista->arreglo_testigo[0]->contacto, ['class' => 'form-control',  'rows' => 3,'maxlength' => 200]) !!}
 </div>

 <!-- <div class="clearfix"></div> -->
 <div class="form-group col-sm-6">
   {!! Form::label('testigo_nombre[]', 'Nombre testigo:') !!}
   {!! Form::text('testigo_nombre[]', $entrevista->arreglo_testigo[1]->nombre, ['class' => 'form-control',  'rows' => 3,'maxlength' => 200]) !!}
 </div>
 <div class="form-group col-sm-6">
   {!! Form::label('testigo_contacto[]', 'Forma de contacto:') !!}
   {!! Form::text('testigo_contacto[]', $entrevista->arreglo_testigo[1]->contacto, ['class' => 'form-control',  'rows' => 3,'maxlength' => 200]) !!}
 </div>
 </div>



 <!-- Ampliar Relato Field -->
 <div class="form-group col-sm-12">
   <hr>
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
 <!-- Contiene Patrones Field -->
 <div class="form-group col-sm-12">
     @include('controles.radio_si_no_cual', ['control_control' => 'id_prioritario'
                                         ,'control_control_cual' => 'prioritario_tema'
                                         ,'control_default' => $entrevistaEtnica->id_prioritario
                                         ,'control_default_cual' => $entrevistaEtnica->prioritario_tema
                                         ,'control_texto'=>"Esta entrevista menciona temas con escasa documentación en el territorio en el que ocurrieron los hechos."])
 </div>
 </div>

<div class="clearfix"></div>


 </div>

 </div>
 </div>

 @push('js')
 <script type="text/javascript">
 $( "#nombre_interprete_div").hide();
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
</script>
 @endpush
  @push('css')
  <style>
  textarea
  {
    width: 100%;
    height: 100px;
  }
  </style>
  @endpush
