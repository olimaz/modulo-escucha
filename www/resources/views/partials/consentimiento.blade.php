@php($mostrar_btn_grabar = isset($mostrar_btn_grabar) ? $mostrar_btn_grabar : true)
<div class="box box-warning box-solid ">

    <div class="box-header">
        <h3 class="box-title">CONSENTIMIENTO INFORMADO - {{ $entrevista->fmt_nombre_entrevistado }}</h3>

    </div>
    <div class="box-body">

        <div class="content col-sm-6">

            <div class="form-group col-sm-12">

                {!! Form::label('identificacion_consentimiento', 'Número de identificación:') !!}
                {!! Form::text('identificacion_consentimiento', $consentimiento->identificacion_consentimiento, ['class' => 'form-control', 'required'=>'required']) !!}
            </div>

            <div class="form-group col-sm-12">
                @include('controles.radio_si_no_div', ['control_control' => 'conceder_entrevista'
                                                    ,'control_default' => $consentimiento->conceder_entrevista
                                                    ,'control_div' => "ocultar_entrevista"
                                                    ,'control_texto'=>"¿Está de acuerdo en conceder entrevistas a la Comisión de la Verdad?"])
            </div>

            <div class="form-group col-sm-12">
                @include('controles.radio_si_no', ['control_control' => 'grabar_audio'
                                                    ,'control_default' => $consentimiento->grabar_audio
                                                    ,'control_texto'=>"¿Está de acuerdo en que la Comisión grabe el audio para la entrevista?"])
            </div>

            <div class="form-group col-sm-12">
                @include('controles.radio_si_no', ['control_control' => 'elaborar_informe'
                                                    ,'control_default' => $consentimiento->elaborar_informe
                                                    ,'control_texto'=>"¿Está de acuerdo en que su entrevista sea utilizada para elaborar el informe Final?"])
            </div>

        </div>
        <div class="content col-sm-6">



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
                                           ,'control_default' => $consentimiento->tratamiento_datos_analizar
                                           ,'control_texto'=>"-1"])  </td>

                    <td>       @include('controles.radio_si_no', ['control_control' => 'tratamiento_datos_analizar_sensible'
                                               ,'control_default' => $consentimiento->tratamiento_datos_analizar_sensible
                                               ,'control_texto'=>"-1"])</td>
                </tr>
                <tr>
                    <td>  Utilizarlos para la elaboración del informe Final de la Comisión de la Verdad.</td>
                    <td>@include('controles.radio_si_no', ['control_control' => 'tratamiento_datos_utilizar'
                                        ,'control_default' => $consentimiento->tratamiento_datos_utilizar
                                        ,'control_texto'=>"-1"])</td>
                    <td>@include('controles.radio_si_no', ['control_control' => 'tratamiento_datos_utilizar_sensible'
                                        ,'control_default' => $consentimiento->tratamiento_datos_utilizar_sensible
                                        ,'control_texto'=>"-1"])</td>
                </tr>
                <tr>
                    <td>Publicar su nombre en el informe Final.</td>
                    <td>@include('controles.radio_si_no', ['control_control' => 'tratamiento_datos_publicar'
                                        ,'control_default' => $consentimiento->tratamiento_datos_publicar
                                        ,'control_texto'=>"-1"])</td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
        @if($mostrar_btn_grabar)

            <div class="col-sm-12 text-center">
                {!! Form::submit('Grabar', ['class' => 'btn btn-primary', 'id' => 'btn_grabar']) !!}
                {{-- <a href="{{ action('entrevista_etnicaController@fichas',$entrevistaEtnica->id_entrevista_etnica) }}" class="btn btn-default">Cancelar</a> --}}
            </div>
        @endif

    </div>

</div>

