 <div class="clearfix"></div>


 <div class="box box-primary ">
     <div class="box-header">
         <h3 class="box-title">ESPECIFICACIONES DE LA ENTREVISTA </h3>
     </div>
     <div class="box-body">

         <div class="box box-solid box-default">
             <div class="box-header">
                 <h3 class="box-title">
                     Condiciones acordadas, preparación previa a la entrevista
                 </h3>
             </div>
             <div class="box-body">
                 <div class="form-group col-sm-4">
                     {!! Form::label('entrevista_condiciones', 'Acompañamiento:') !!}
                     <p>{!! $entrevista->fmt_entrevista_condiciones !!}</p>
                 </div>
                 <div class="form-group col-sm-4">
                     {!! Form::label('id_idioma', 'Lengua/Idioma del testimonio:') !!}
                     <p>{!! $entrevista->fmt_id_idioma !!}</p>
                 </div>
                 <div class="form-group"  {{ $entrevista->id_idioma!=178 ? ' style="display: none" ' : '' }} id="id_nativo_div">
                     @if($entrevista->id_idioma==178)
                         {!! Form::label('id_nativo', 'Idioma Nativo:') !!}
                         <p>{!! $entrevista->fmt_id_nativo !!}</p>
                     @endif
                 </div>
                 <!-- Nombre Interprete Field -->
                 @if($entrevista->id_idioma==177)
                     <div class="form-group col-sm-12"  id="nombre_interprete_div">
                         {!! Form::label('nombre_interprete', 'Indicar nombres y apellidos del interprete:') !!}
                         {!! Form::text('nombre_interprete',$entrevista->nombre_interprete, null, ['class' => 'form-control', 'maxlength' => 200]) !!}
                     </div>
                 @endif
             </div>
         </div> {{-- fin del box de condiciones --}}

         {{-- Anotaciones --}}

         <div class="box box-solid box-default">
             <div class="box-header">
                 <h3 class="box-title">
                     Anotaciones
                 </h3>
             </div>
             <div class="box-body">
                 <!-- Indicaciones Transcripcion Field -->
                 @if(!empty($entrevista->indicaciones_transcripcion))
                     <div class="form-group col-sm-12">
                         {!! Form::label('indicaciones_transcripcion', 'Si lo considera necesario, utilice el siguiente espacio para anotar indicaciones para la transcripción.:') !!}
                         <p>{!! $entrevista->indicaciones_transcripcion !!}</p>
                     </div>
                 @endif
                 @if(!empty($entrevista->observaciones))
                     <div class="form-group col-sm-12">
                         {!! Form::label('observaciones', 'Indicar en el espacio que sigue otras observaciones que tenga respecto a la entrevista.') !!}
                         <p>{!! $entrevista->observaciones !!}</p>
                     </div>
                 @endif
             <!-- Ampliar Relato Field -->
                 <div class="form-group col-sm-6">
                     {!! Form::label('ampliar_relato', 'Se recomienda ampliar el relato:') !!}
                     <p>{!! $entrevista->fmt_ampliar_relato !!}</p>
                 </div>

                 <!-- Ampliar Relato Temas Field -->
                 @if($entrevista->ampliar_relato==1)
                     <div class="form-group col-sm-6">
                         {!! Form::label('ampliar_relato_temas', 'En los siguientes temas:') !!}
                         <p>{!! $entrevista->ampliar_relato_temas !!}</p>
                     </div>
                 @endif
                 <div class="clearfix"></div>
                 <!-- Priorizar Entrevista Field -->
                 <div class="form-group col-sm-6">
                     {!! Form::label('priorizar_entrevista', 'Se recomienda priorizar la entrevista para el análisis:') !!}
                     <p>{!! $entrevista->fmt_priorizar_entrevista !!}</p>
                 </div>

                 <!-- Priorizar Entrevista Asuntos Field -->
                 @if($entrevista->priorizar_entrevista==1)
                     <div class="form-group col-sm-6">
                         {!! Form::label('priorizar_entrevista_asuntos', 'De los siguientes asuntos:') !!}
                         <p>{!! $entrevista->priorizar_entrevista_asuntos !!}</p>
                     </div>
                 @endif
                 <div class="clearfix"></div>
                <!-- Contiene Patrones Field -->
                 <div class="form-group col-sm-6">
                     {!! Form::label('contiene_patrones', 'A criterio del entrevistador/a ¿Cree que la entrevista realizada aporta elementos para identificar patrones de violencia o contextos explicativos?') !!}
                     <p>{!! $entrevista->fmt_contiene_patrones !!}</p>
                 </div>

                 <!-- Contiene Patrones Cuales Field -->
                 @if($entrevista->contiene_patrones==1)
                     <div class="form-group col-sm-6">
                         {!! Form::label('contiene_patrones_cuales', '¿Cuáles?') !!}
                         <p>{!! $entrevista->contiene_patrones_cuales !!}</p>
                     </div>
                 @endif
                 <div class="clearfix"></div>

                <!-- Contiene Patrones Field -->
                 <div class="form-group col-sm-6">
                     {!! Form::label('contiene_patrones_cuales', 'Esta entrevista menciona temas con escasa documentación en el territorio en el que ocurrieron los hechos.') !!}
                     <p>{!! $entrevistaIndividual->fmt_id_prioritario !!}</p>
                 </div>
                 <div class="form-group col-sm-6">
                     {!! Form::label('contiene_patrones_cuales', '¿Cuál?') !!}
                     <p>{!! $entrevistaIndividual->prioritario_tema !!}</p>
                 </div>
             </div>
         </div>


         <div class="box box-solid box-default">
             <div class="box-header">
                 <h3 class="box-title">
                     Información complementaria
                 </h3>
             </div>
             <div class="box-body">
                 <div class="form-group col-sm-6">
                     {!! Form::label('documentacion_aporta', 'Quien declara, ¿Aporta documentación relacionada con los hechos?') !!}
                     <p>{!! $entrevista->fmt_documentacion_aporta !!}</p>
                 </div>

                 <!-- Documentacion Especificar Field -->
                 @if($entrevista->documentacion_aporta==1)
                     <div class="form-group col-sm-6">
                         {!! Form::label('documentacion_especificar', 'Especificar cuál (por ejemplo, recortes de periódicos, cosas personales, documentos, fotos, denuncias, sentencias, etc.):') !!}
                         <p>{!! $entrevista->documentacion_especificar !!}</p>
                     </div>
                 @endif
             <!-- Identifica Testigos Field -->
                 <div class="form-group col-sm-6">
                     {!! Form::label('identifica_testigos', 'Conoce otros/as testigos de los hechos:') !!}
                     <p>{!! $entrevista->fmt_identifica_testigos !!}</p>
                 </div>

                 @if($entrevista->identifica_testigos==1)
                 <!-- información de los 2 testigos -->
                     <div class="form-group col-sm-6">
                         {!! Form::label('entrevista_testigo', 'Nombre y forma de contacto de esos/as otro/as testigos de los hechos:') !!}
                         <table class="table table-bordered table-condensed table-striped">
                             <thead>
                             <tr>
                                 <th>Nombre / Apellido / Apodo</th>
                                 <th>Forma de contacto</th>
                             </tr>
                             </thead>
                             <tbody>
                             <tr>
                                 <td>
                                     {!! $entrevista->fmt_entrevista_testigo !!}
                                 </td>
                             </tr>

                             </tbody>
                         </table>

                     </div>
                 @endif
             </div>
        </div>
    </div>
 </div>
 <div class="clearfix"></div>

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
