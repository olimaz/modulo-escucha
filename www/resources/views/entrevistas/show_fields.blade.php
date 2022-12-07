<!-- Id Entrevista Field -->
<!-- <div class="form-group">
    {!! Form::label('id_entrevista', 'Id Entrevista:') !!}
        <p>{!! $entrevista->id_entrevista !!}</p>
</div> -->

<!-- Id E Ind Fvt Field -->
<!-- <div class="form-group">
    {!! Form::label('id_e_ind_fvt', 'Id E Ind Fvt:') !!}
        <p>{!! $entrevista->id_e_ind_fvt !!}</p>
</div> -->

<!-- Id Idioma Field -->
<div class="content col-sm-6">
    <div class="box box-primary box-solid">

        <div class="box-header">
            <h3 class="box-title">ESPECIFICACIONES DE LA ENTREVISTA - {!! $entrevista->fmt_id_e_ind_fvt !!}  </h3>

        </div>
        <div class="box-body">
            <div class="form-group col-sm-6">
                {!! Form::label('entrevista_condiciones', 'Acompañamiento:') !!}
                <p>{!! $entrevista->fmt_entrevista_condiciones !!}</p>
            </div>

            <!-- Id Idioma Field -->
            <div class="form-group col-sm-3">
                {!! Form::label('id_idioma', 'Lengua/Idioma del testimonio:') !!}
                <p>{!! $entrevista->fmt_id_idioma !!}</p>
            </div>

            <!-- Id Nativo Field -->
            @if($entrevista->id_idioma==178)
                <div class="form-group col-sm-3">
                    {!! Form::label('id_nativo', 'Idioma Nativo:') !!}
                    <p>{!! $entrevista->fmt_id_nativo !!}</p>
                </div>
            @endif
            <div class="clearfix"></div>
            <!-- Nombre Interprete Field -->
            <div class="form-group col-sm-12">
                {!! Form::label('nombre_interprete', 'Nombres y apellidos del interprete:') !!}
                <p>{!! $entrevista->nombre_interprete !!}</p>
            </div>

            <!-- Documentacion Aporta Field -->
            <hr>
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
            <div class="clearfix"></div>
            <hr>
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
                        {!! $entrevista->fmt_entrevista_testigo !!}
                        </tbody>
                    </table>


                </div>

            @endif
            <div class="clearfix"></div>
            <hr>
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
            <hr>
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
        <!-- Contiene Patrones Field -->
            <div class="clearfix"></div>
            <hr>
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
            <hr>
            <!-- Indicaciones Transcripcion Field -->
            @if(!empty($entrevista->indicaciones_transcripcion))

                <div class="form-group col-sm-12">
                    {!! Form::label('indicaciones_transcripcion', 'Si lo considera necesario, utilice el siguiente espacio para anotar indicaciones para la transcripción.:') !!}
                    <p>{!! $entrevista->indicaciones_transcripcion !!}</p>
                </div>
            @endif
        <!-- Observaciones Field -->
            @if(!empty($entrevista->observaciones))
                <div class="form-group col-sm-12">
                    {!! Form::label('observaciones', 'Indicar en el espacio que sigue otras observaciones que tenga respecto a la entrevista.') !!}
                    <p>{!! $entrevista->observaciones !!}</p>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="content col-sm-6">
    <div class="box box-success box-solid ">

        <div class="box-header">
            <h3 class="box-title">CONSENTIMIENTO INFORMADO</h3>

        </div>
        <div class="box-body">
            <div class="form-group col-sm-12">

                {!! Form::label('identificacion_consentimiento', 'Número de identificación:') !!}
                <p>{!! $entrevista->identificacion_consentimiento !!}</p>
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('conceder_entrevista', '¿Está de acuerdo en conceder entrevistas a la Comisión de la Verdad?') !!}
                <p>{!! $entrevista->fmtconcederentrevista !!}</p>
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('grabar_audio', '¿Está de acuerdo en que la Comisión grabe el audio para la entrevista?') !!}
                <p>{!! $entrevista->fmtgrabaraudio !!}</p>
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('elaborar_informe', '¿Está de acuerdo en que su entrevista sea utilizada para elaborar el informe Final?') !!}
                <p>{!! $entrevista->fmtelaborarinforme !!}</p>
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
                        <td>{!! $entrevista->fmttratamientodatosanalizar !!}</td>
                        <td>{!! $entrevista->fmttratamientodatosanalizarsensible !!}</td>
                    </tr>
                    <tr>
                        <td> Utilizarlos para la elaboración del informe Final de la Comisión de la Verdad.</td>
                        <td>{!! $entrevista->fmttratamientodatosutilizar !!}</td>
                        <td>{!! $entrevista->fmttratamientodatosutilizarsensible !!}</td>
                    </tr>
                    <tr>
                        <td>Publicar su nombre en el informe Final.</td>
                        <td>{!! $entrevista->fmttratamientodatospublicar !!}</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Created At Field -->
<!-- <div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
        <p>{!! $entrevista->created_at !!}</p>
</div> -->

<!-- Updated At Field -->
<!-- <div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
        <p>{!! $entrevista->updated_at !!}</p>
</div> -->
