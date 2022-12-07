{{-- Esta seccion se muestra solo en el create, no en el update --}}
<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_1'

                                            //,'control_default' => $entrevistaIndividual->archivo_ci
                                               , 'control_texto'=>"<i class='fa fa-pencil-square-o' aria-hidden='true'></i> Autorizaciones"])
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
                                               , 'control_texto'=>'<i class="fa fa-headphones" aria-hidden="true"></i> Audio de la entrevista'])
</div>
{{--
<div class="clearfix"></div>
<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_4'
                                        ,'control_collapse' => true
                                               , 'control_texto'=>"<i class='fa fa-tag' aria-hidden='true'></i> Otros archivos"])
</div>
--}}
<div class="clearfix"></div>
