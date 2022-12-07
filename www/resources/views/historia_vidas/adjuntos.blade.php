{{-- Esta seccion se muestra solo en el create, no en el update --}}
<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_1'
                                               , 'control_texto'=>"<i class='fa fa-files-o' aria-hidden='true'></i> Autorizaciones"])
</div>

<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_2'
                                               , 'control_texto'=>'<i class="fa fa-file-audio-o" aria-hidden="true"></i> Audio de la entrevista'])
</div>


<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_11'
                                               , 'control_texto'=>'<i class="fa fa-file-word-o" aria-hidden="true"></i> Relatoría de la entrevista'])
</div>

<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_6'
                                               , 'control_texto'=>"<i class='fa fa-file-word-o' aria-hidden='true'></i> Transcripción final"])
</div>
<div class="clearfix"></div>
<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_25'

                                               , 'control_texto'=>"<i class='fa fa-tags' aria-hidden='true'></i> Etiquetado"])
</div>

<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_4'
                                               , 'control_texto'=>"<i class='fa fa-tag' aria-hidden='true'></i> Otros archivos"])
</div>

