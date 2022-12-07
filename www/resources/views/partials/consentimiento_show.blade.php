<div class="clearfix"></div>


@if(empty($consentimiento))
    <div class="box box-danger ">
        <div class="box-header">
            <h3 class="box-title">Consentimiento Informado</h3>
        </div>
        <div class="box-body">
            <h4 class="text-danger"><i class="icon fa fa-warning"></i>  No se ha diligenciado la información del consentimiento informado</h4>

        </div>
    </div>

@else
    <div class="box box-info ">
        <div class="box-header">
            <h3 class="box-title">Consentimiento Informado <a href=" {!! $consentimiento->enlace_entrevista !!}">{{ $entrevista->entrevista_codigo }}</a></h3>
        </div>
        <div class="box-body">
            <div class="content col-sm-6">
                <div class="form-group col-sm-12">

                    {!! Form::label('identificacion_consentimiento', 'Número de identificación:') !!}
                    <p>{!! $consentimiento->identificacion_consentimiento !!}</p>
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('conceder_entrevista', '¿Está de acuerdo en conceder entrevistas a la Comisión de la Verdad?') !!}
                    <p>{!! $consentimiento->fmtconcederentrevista !!}</p>
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('grabar_audio', '¿Está de acuerdo en que la Comisión grabe el audio para la entrevista?') !!}
                    <p>{!! $consentimiento->fmtgrabaraudio !!}</p>
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('elaborar_informe', '¿Está de acuerdo en que su entrevista sea utilizada para elaborar el informe Final?') !!}
                    <p>{!! $consentimiento->fmtelaborarinforme !!}</p>
                </div>
                @if($consentimiento->id_entrevista_etnica > 0)
                    <div class="form-group col-sm-12">
                        {!! Form::label('grabar_video', '¿Está de acuerdo en que la Comisión grabe el video de la participación de la comunidad para la entrevista? ') !!}
                        <p>{!! $consentimiento->fmt_grabar_video !!}</p>
                    </div>
                    <div class="form-group col-sm-12">
                        {!! Form::label('tomar_fotografia', '¿Está de acuerdo en que la Comisión tome fotografías de la participación de la comunidad para la entrevista? ') !!}
                        <p>{!! $consentimiento->fmt_tomar_fotografia !!}</p>
                    </div>
                @endif

                @if($consentimiento->divulgar_material > 0)
                    <div class="form-group col-sm-12">
                        {!! Form::label('divulgar_material', '¿Está de acuerdo en que sus datos sean utilizados en la divulgación de material audiovisual y otros (Texto, datos, audio, vídeo y fotografía)?') !!}
                        <p>{!! $consentimiento->fmt_divulgar_material !!}</p>
                    </div>
                @endif
                @if($consentimiento->traslado_info > 0)
                    <div class="form-group col-sm-12">
                        {!! Form::label('traslado_info', '¿Está de acuerdo en que sus datos sean trasladados a terceros?') !!}
                        <p>{!! $consentimiento->fmt_traslado_info !!}</p>
                    </div>
                @endif
                @if($consentimiento->compartir_info > 0)
                    <div class="form-group col-sm-12">
                        {!! Form::label('compartir_info', '¿Está de acuerdo en que sus datos sean compartidos con terceros?') !!}
                        <p>{!! $consentimiento->fmt_compartir_info !!}</p>
                    </div>
                @endif


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
                        <td>{!! $consentimiento->fmttratamientodatosanalizar !!}</td>
                        <td>{!! $consentimiento->fmttratamientodatosanalizarsensible !!}</td>
                    </tr>
                    <tr>
                        <td>  Utilizarlos para la elaboración del informe Final de la Comisión de la Verdad.</td>
                        <td>{!! $consentimiento->fmttratamientodatosutilizar !!}</td>
                        <td>{!! $consentimiento->fmttratamientodatosutilizarsensible !!}</td>
                    </tr>
                    <tr>
                        <td>Publicar su nombre en el informe Final.</td>
                        <td>{!! $consentimiento->fmttratamientodatospublicar !!}</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
<div class="clearfix"></div>