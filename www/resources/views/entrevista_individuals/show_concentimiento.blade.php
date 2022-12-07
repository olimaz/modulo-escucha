{{-- Consentimeinto informado --}}
@php
    $consentimiento = $entrevistaIndividual->rel_consentimiento;
@endphp
@include('partials.consentimiento_show')



{{--@php--}}
{{--    $entrevista = $entrevistaIndividual->rel_consentimiento;--}}
{{--@endphp--}}

{{--<div class="clearfix"></div>--}}


{{--<div class="box box-info ">--}}

{{--    <div class="box-header">--}}
{{--        <h3 class="box-title">Consentimiento Informado </h3>--}}

{{--    </div>--}}
{{--    <div class="box-body">--}}

{{--        <div class="content col-sm-6">--}}
{{--            <div class="form-group col-sm-12">--}}

{{--                {!! Form::label('identificacion_consentimiento', 'Número de identificación:') !!}--}}
{{--                <p>{!! $entrevista->identificacion_consentimiento !!}</p>--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-12">--}}
{{--                {!! Form::label('conceder_entrevista', '¿Está de acuerdo en conceder entrevistas a la Comisión de la Verdad?') !!}--}}
{{--                <p>{!! $entrevista->fmtconcederentrevista !!}</p>--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-12">--}}
{{--                {!! Form::label('grabar_audio', '¿Está de acuerdo en que la Comisión grabe el audio para la entrevista?') !!}--}}
{{--                <p>{!! $entrevista->fmtgrabaraudio !!}</p>--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-12">--}}
{{--                {!! Form::label('elaborar_informe', '¿Está de acuerdo en que su entrevista sea utilizada para elaborar el informe Final?') !!}--}}
{{--                <p>{!! $entrevista->fmtelaborarinforme !!}</p>--}}
{{--            </div>--}}
{{--            @if($entrevista->divulgar_material > 0)--}}
{{--                <div class="form-group col-sm-12">--}}
{{--                    {!! Form::label('divulgar_material', '¿Está de acuerdo en que sus datos sean utilizados en la divulgación de material audiovisual y otros (Texto, datos, audio, vídeo y fotografía)?') !!}--}}
{{--                    <p>{!! $entrevista->fmt_divulgar_material !!}</p>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--            @if($entrevista->traslado_info > 0)--}}
{{--                <div class="form-group col-sm-12">--}}
{{--                    {!! Form::label('traslado_info', '¿Está de acuerdo en que sus datos sean trasladados a terceros?') !!}--}}
{{--                    <p>{!! $entrevista->fmt_traslado_info !!}</p>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--            @if($entrevista->compartir_info > 0)--}}
{{--                <div class="form-group col-sm-12">--}}
{{--                    {!! Form::label('compartir_info', '¿Está de acuerdo en que sus datos sean compartidos con terceros?') !!}--}}
{{--                    <p>{!! $entrevista->fmt_compartir_info !!}</p>--}}
{{--                </div>--}}
{{--            @endif--}}


{{--        </div>--}}
{{--        <div class="content col-sm-6">--}}
{{--            <div class="form-group col-sm-12">--}}
{{--                <label for="title">AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES</label>--}}


{{--            </div>--}}
{{--            <table class="table table-striped">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th scope="col">¿Autoriza el tratamiento de sus datos para las siguientes finalidades?</th>--}}
{{--                    <th scope="col">Datos personales</th>--}}
{{--                    <th scope="col">Datos sensibles</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                <tr>--}}
{{--                    <td>Analizarlos, compararlos, contrastarlos con otros datos e información recolectada.</td>--}}
{{--                    <td>{!! $entrevista->fmttratamientodatosanalizar !!}</td>--}}
{{--                    <td>{!! $entrevista->fmttratamientodatosanalizarsensible !!}</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td> Utilizarlos para la elaboración del informe Final de la Comisión de la Verdad.</td>--}}
{{--                    <td>{!! $entrevista->fmttratamientodatosutilizar !!}</td>--}}
{{--                    <td>{!! $entrevista->fmttratamientodatosutilizarsensible !!}</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td>Publicar su nombre en el informe Final.</td>--}}
{{--                    <td>{!! $entrevista->fmttratamientodatospublicar !!}</td>--}}
{{--                    <td></td>--}}
{{--                </tr>--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
