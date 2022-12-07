{{-- Esta seccion se muestra solo en el create, no en el update --}}
<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_1'

                                            //,'control_default' => $entrevistaIndividual->archivo_ci
                                               , 'control_texto'=>"<i class='fa fa-files-o' aria-hidden='true'></i> Consentimiento informado"])
</div>
<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_3'
                                            //,'control_default' => $entrevistaIndividual->archivo_fichas
                                               , 'control_texto'=>"<i class='fa fa-file-pdf-o' aria-hidden='true'></i> Ficha corta - soporte en papel"])
</div>
<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_5'
                                        //,'control_default' => $entrevistaIndividual->archivo_otro
                                               , 'control_texto'=>"<i class='fa fa-file-pdf-o' aria-hidden='true'></i> Ficha larga - soporte en papel"])
</div>
<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_2'
                                            //,'control_default' => $entrevistaIndividual->archivo_audio
                                               , 'control_texto'=>'<i class="fa fa-file-audio-o" aria-hidden="true"></i> Audio de la entrevista'])
</div>

<div class="clearfix"></div>

<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_4'

                                               , 'control_texto'=>"<i class='fa fa-tag' aria-hidden='true'></i> Otros archivos"])
</div>
<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_6'

                                               , 'control_texto'=>"<i class='fa fa-file-word-o' aria-hidden='true'></i> Transcripción final"])
</div>

<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_25'

                                               , 'control_texto'=>"<i class='fa fa-tags' aria-hidden='true'></i> Etiquetado"])
</div>
<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_10'

                                               , 'control_texto'=>"<i class='fa fa-file-text-o' aria-hidden='true'></i> Retroalimentación"])
</div>
<div class="clearfix"></div>

@if($entrevistaIndividual->nna==1)
    <div class="col-sm-3">
        @include('controles.carga_archivo', ['control_control' => 'archivo_13'

                                                   , 'control_texto'=>"<i class='fa fa-file-text-o' aria-hidden='true'></i> NNA: Evaluación de vulnerabilidad"])
    </div>
    <div class="col-sm-3">
        @include('controles.carga_archivo', ['control_control' => 'archivo_14'

                                                   , 'control_texto'=>"<i class='fa fa-file-text-o' aria-hidden='true'></i> NNA: Evaluación de seguridad"])
    </div>
@endif
@if($entrevistaIndividual->id_remitido>0)
    <div class="col-sm-3">
        @include('controles.carga_archivo', ['control_control' => 'archivo_12'

                                                   , 'control_texto'=>"<i class='fa fa-file-text-o' aria-hidden='true'></i>Certificaciones"])
    </div>
@endif
<div class="clearfix"></div>
