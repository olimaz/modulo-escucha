{{-- Esta seccion se muestra solo en el create, no en el update --}}
<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_1'

                                            //,'control_default' => $entrevistaIndividual->archivo_ci
                                               , 'control_texto'=>"<i class='fa fa-files-o' aria-hidden='true'></i> Autorizaciones"])
</div>

<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_2'
                                            //,'control_default' => $entrevistaIndividual->archivo_audio
                                               , 'control_texto'=>'<i class="fa fa-file-audio-o" aria-hidden="true"></i> Audio de la entrevista'])
</div>


<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_11'
                                            //,'control_default' => $entrevistaIndividual->archivo_audio
                                               , 'control_texto'=>'<i class="fa fa-file-word-o" aria-hidden="true"></i> Relatoría de la entrevista'])
</div>




<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_6'

                                               , 'control_texto'=>"<i class='fa fa-file-word-o' aria-hidden='true'></i> Transcripción final"])
</div>
<div class="clearfix"></div>
@if($entrevistaProfundidad->id_tipo==5)
    <div class="col-sm-3">
        @include('controles.carga_archivo', ['control_control' => 'archivo_21'
                                                   , 'control_texto'=>"<i class='fa fa-file-word-o' aria-hidden='true'></i> Plan de trabajo"])
    </div>
    <div class="col-sm-3">
        @include('controles.carga_archivo', ['control_control' => 'archivo_17'
                                                   , 'control_texto'=>"<i class='fa fa-file-pdf-o' aria-hidden='true'></i> Certificación inicial"])
    </div>
    <div class="col-sm-3">
        @include('controles.carga_archivo', ['control_control' => 'archivo_18'
                                                   , 'control_texto'=>"<i class='fa fa-file-pdf-o' aria-hidden='true'></i> Certificación final"])
    </div>
    <div class="col-sm-3">
        @include('controles.carga_archivo', ['control_control' => 'archivo_22'
                                                   , 'control_texto'=>"<i class='fa fa-file-word-o' aria-hidden='true'></i> Valoración"])
    </div>
    <div class="col-sm-3">
        @include('controles.carga_archivo', ['control_control' => 'archivo_23'
                                                   , 'control_texto'=>"<i class='fa fa-file-pdf-o' aria-hidden='true'></i> Comunicación oficial"])
    </div>
    <div class="clearfix"></div>
@endif

<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_25'

                                               , 'control_texto'=>"<i class='fa fa-tags' aria-hidden='true'></i> Etiquetado"])
</div>


<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_4'

                                               , 'control_texto'=>"<i class='fa fa-tag' aria-hidden='true'></i> Otros archivos"])
</div>