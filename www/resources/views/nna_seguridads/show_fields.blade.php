

<div class="col-sm-6  {{ $nnaSeguridad->dictamen==1 ? 'bg-success' : 'bg-danger' }}">
    <h1 class="text-center"># NNA: {{ $nnaSeguridad->rel_id_nna_vulnerabilidad->correlativo }}</h1>
    <p class="text-center  text-bold  {{ $nnaSeguridad->dictamen==1 ? 'text-success' : 'text-danger' }}">{{ $nnaSeguridad->fmt_dictamen }}</p>
    <ul>
        <li>Código de evaluación de vulnerabilidad: {{ $nnaSeguridad->rel_id_nna_vulnerabilidad->codigo }}</li>
        <li>Fecha de evaluación de vulnerabilidad: {{ $nnaSeguridad->rel_id_nna_vulnerabilidad->fmt_fecha_evaluacion }}</li>
        <li>Código de evaluación de seguridad: {{ $nnaSeguridad->codigo }}</li>
        <li>Fecha de evaluación de seguridad: {{ $nnaSeguridad->fmt_fecha_evaluacion }}</li>
        <li>Territorio de la evaluación de seguridad: {{ $nnaSeguridad->fmt_id_territorio }}</li>

    </ul>
</div>


<div class="clearfix"></div>
<div class="col-xs-12" style="margin-top: 20px">
    <div class="box box-primary  box-solid">
        <div class="box-header">
            <h3 class="box-title">
                Información de la evaluación:   {{ $nnaSeguridad->codigo }}
            </h3>
        </div>
        <div class="box-body">
            <div class="form-group  col-sm-6">
                {!! Form::label('fecha_evaluacion', 'Fecha en que se realiza la evaluación:') !!}
                <p>{!! $nnaSeguridad->fmt_fecha_evaluacion !!}</p>
            </div>
            <div class="form-group  col-sm-6">
                {!! Form::label('territorio', 'Territorio en que se realiza la evaluación:') !!}
                <p>{!! $nnaSeguridad->fmt_id_territorio !!}</p>
            </div>



            <!-- Id Quien Refiere Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('id_quien_refiere', '¿Quién ha referido al niño/a para la toma de testimonio?') !!}
                <p>{!! $nnaSeguridad->fmt_id_quien_refiere !!}</p>
            </div>

            <!-- Id Quien Refiere Otro Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('id_quien_refiere_otro', 'Si es otro, ¿Quién? ') !!}
                <p>{!! $nnaSeguridad->id_quien_refiere_otro !!}</p>
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-12">
                <h4 class="text-primary">Preparación de la entrevista </h4>
            </div>

            <!-- Revisar Proceso Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('revisar_proceso', '¿El profesional ha revisado junto al niño o niña y su representante legal, el proceso de participación en la toma de testimonio de la Comisión de la Verdad?') !!}
                <p>{!! $nnaSeguridad->fmt_revisar_proceso !!}</p>
            </div>

            <div class="form-group col-sm-6">
                {!! Form::label('info', 'Se ha brindado información sobre:') !!}
                <p>{!! $nnaSeguridad->fmt_info !!}</p>
            </div>
            <div class="clearfix"></div>

            <!-- Firma Consentimiento Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('firma_consentimiento', '¿El niño o niña y su representante legal han firmado el consentimiento informado?') !!}
                <p>{!! $nnaSeguridad->fmt_firma_consentimiento !!}</p>
            </div>
            <div class="clearfix"></div>

            <!-- Existe Entidad Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('existe_entidad', '¿Existe en la comunidad alguna entidad u organización social que trabaje sobre el bienestar de niños/as y que apoye el trabajo de la Comisión y pueda brindar apoyo al NNA?') !!}
                <p>{!! $nnaSeguridad->fmtexiste_entidad !!}</p>
            </div>

            <!-- Lugar Privado Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('lugar_privado', '¿Se cuenta con un lugar privado, confidencial y adecuado para el desarrollo de la entrevista con el niño/a?') !!}
                <p>{!! $nnaSeguridad->fmt_lugar_privado !!}</p>
            </div>

            <div class="clearfix"></div>

            <!-- Alguien Acompana Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('alguien_acompana', '¿Alguien acompañará al niño o niña durante la entrevista? ') !!}
                <p>{!! $nnaSeguridad->fmt_alguien_acompana !!}</p>
            </div>

            <!-- Alguien Acompana Padre Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('alguien_acompana_padre', 'Padre o madre o representante legal:') !!}
                <p>{!! $nnaSeguridad->fmt_alguien_acompana_padre !!}</p>

                {!! Form::label('alguien_acompana_padre', 'Trabajador social o profesional psicosocial:') !!}
                <p>{!! $nnaSeguridad->fmt_alguien_acompana_ts !!}</p>

                {!! Form::label('alguien_acompana_otro', 'Otro:') !!}
                <p>{!! $nnaSeguridad->fmt_alguien_acompana_otro !!}</p>
            </div>



            <!-- Apoyo Identificado Field -->
            <div class="form-group col-sm-12">
                {!! Form::label('apoyo_identificado', '¿Se ha identificado alguna persona de apoyo en caso de alguna dificultad durante la entrevista? (Por ej: maestro/a, líder comunitario, organización social, etc.)') !!}
                <p>{!! $nnaSeguridad->fmt_apoyo_identificado !!}</p>
            </div>

            <div class="col-xs-12">
                <h4 class="text-primary">Entrevista </h4>
            </div>
            <!-- Informado Presencia Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('informado_presencia', '¿Se ha informado al niño o niña que puede solicitar la presencia de un familiar, representante legal o apoyo psicosocial durante la entrevista? ') !!}
                <p>{!! $nnaSeguridad->fmt_informado_presencia !!}</p>
            </div>
            <div class="form-group col-sm-6">
                {!! Form::label('informado_cev', '¿La persona a cargo de la entrevista ha brindado información amplia sobre la Comisión y su importancia?') !!}
                <p>{!! $nnaSeguridad->fmt_informado_cev !!}</p>
            </div>

            <div class="clearfix"></div>




            <!-- Entrevista Cierre Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('entrevista_cierre', '¿La persona a cargo ha realizado un cierre de la entrevista, agradeciendo al niño o niña su participación y se ha asegurado que esté tranquilo para finalizar ?') !!}
                <p>{!! $nnaSeguridad->fmt_entrevista_cierre !!}</p>
            </div>

            <!-- Entrevista Cierre Porque Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('entrevista_cierre_porque', 'Si no se hizo cierre, ¿Por qué?') !!}
                <p>{!! nl2br($nnaSeguridad->entrevista_cierre_porque) !!}</p>
            </div>

            <div class="clearfix"></div>
            <div class="col-xs-12">
                <h4 class="text-primary">Seguimiento </h4>
            </div>
            <!-- Entrevista Seguimiento Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('entrevista_seguimiento', '¿Se planea una visita o encuentro de seguimiento después de la entrevista por parte de la Comisión o una organización aliada?') !!}
                <p>{!! $nnaSeguridad->fmt_entrevista_seguimiento !!}</p>
            </div>

            <!-- Observaciones Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('observaciones', 'Observaciones:') !!}
                <p>{!! nl2br($nnaSeguridad->observaciones) !!}</p>
            </div>


        </div>
    </div>
</div>
<div class="clearfix"></div>



