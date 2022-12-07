@if (!(!isset($m_aut) ||  $m_aut == ""))
    <div class="pull-right" style="margin-bottom: 10px;">
        <a href="{{ action('entrevista_etnicaController@fichas',$entrevistaEtnica->id_entrevista_etnica) }}" class="btn btn-default">Volver</a>
    </div>
@endif

<div class="clearfix"></div>

   <div class="box box-warning box-solid ">

     <div class="box-header">
         <h3 class="box-title">CONSENTIMIENTO INFORMADO</h3>

       </div>
           <div class="box-body">

  <div class="content col-sm-6">

    {{-- Campos propios de consentimiento para entrevistas étnicas --}}
      @if ($entrevista->tipo_entrevista() == 'etnica')

        <div class="form-group col-sm-12">

            {!! Form::label('nombre_autoridad_etnica', 'Nombre de la autoridad étnica de la comunidad debidamente acreditado:') !!}
            {!! Form::text('nombre_autoridad_etnica', $entrevista->nombre_autoridad_etnica, ['class' => 'form-control']) !!}
        
        </div>

        <div class="form-group col-sm-12">

            {!! Form::label('nombre_identitario', 'Nombre identitario:') !!}
            {!! Form::text('nombre_identitario', $entrevista->nombre_identitario, ['class' => 'form-control']) !!}
        
        </div>

        <div class="form-group col-sm-12">
        
            @include('controles.catalogo', ['control_control' => 'id_pueblo_representado'
                                            ,'control_default' => (empty($entrevista->id_pueblo_representado) ? -1 : $entrevista->id_pueblo_representado)
                                            ,'control_id_cat' => 27
                                            ,'control_vacio' => '[Ninguno]'
                                            ,'control_otro' => true
                                            ,'control_texto'=>'Pueblo étnico/ comunidad que representa'])
        </div>        

      @endif
             <div class="form-group col-sm-12">

                 {!! Form::label('identificacion_consentimiento', 'Número de identificación:') !!}
                 {!! Form::text('identificacion_consentimiento', $entrevista->identificacion_consentimiento, ['class' => 'form-control', 'required']) !!}
             </div>

            <div class="form-group col-sm-12">
              @include('controles.radio_si_no_div', ['control_control' => 'conceder_entrevista'
                                                  ,'control_default' => $entrevista->conceder_entrevista
                                                  ,'control_div' => "ocultar_entrevista"
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

  </div>
   <div class="content col-sm-6">

      @if ($entrevista->tipo_entrevista() == 'etnica')
      <div class="form-group col-sm-12">
        @include('controles.radio_si_no', ['control_control' => 'grabar_video'
                                            ,'control_default' => $entrevista->grabar_video
                                            ,'control_texto'=>"¿Está de acuerdo en que la Comisión grabe el video de la participación de la comunidad para la entrevista?"])
      </div>
      
      <div class="form-group col-sm-12">
          @include('controles.radio_si_no', ['control_control' => 'tomar_fotografia'
                                              ,'control_default' => $entrevista->tomar_fotografia
                                              ,'control_texto'=>"¿Está de acuerdo en que la Comisión tome fotografías de la participación de la comunidad para la entrevista?"])
        </div>              
    @endif
        
     <div class="form-group col-sm-12">
         <label for="title">AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES</label>


     </div>
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

   @if (!(!isset($m_aut) ||  $m_aut == ""))    
    <div class="col-sm-12 text-center">
      {!! Form::submit('Grabar', ['class' => 'btn btn-primary', 'id' => 'btn_grabar']) !!}
      {{-- <a href="{{ action('entrevista_etnicaController@fichas',$entrevistaEtnica->id_entrevista_etnica) }}" class="btn btn-default">Cancelar</a> --}}
    </div>
   @endif

   </div>
   
 </div>


 @push('js')
<script>

    $("#btn_grabar").click(function(){

        if ($("#nombre_autoridad_etnica").length > 0) {

            if ($("#nombre_identitario").length > 0) {

                if ($("#nombre_autoridad_etnica").val().trim() == "" && $("#nombre_identitario").val().trim() == "") {

                    alert('Favor ingresar el nombre de la autoridad étnica o el nombre identitario');
                    $("#nombre_autoridad_etnica").focus();
                    return false;
                }
            }
        }

        return true;
    });
</script>
@endpush