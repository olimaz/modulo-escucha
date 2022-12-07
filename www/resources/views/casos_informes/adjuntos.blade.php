{{-- Esta seccion se muestra solo en el create, no en el update --}}
<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_1'
                                        , 'control_texto'=>"<i class='fa fa-files-o' aria-hidden='true'></i> Autorizaciones"])
</div>


<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_15'
                                               , 'control_texto'=>"<i class='fa fa-file-pdf-o' aria-hidden='true'></i> Casos / Informes"])
</div>


<div class="col-sm-3">
    @include('controles.carga_archivo', ['control_control' => 'archivo_4'
                                               , 'control_texto'=>"<i class='fa fa-tag' aria-hidden='true'></i> Otros archivos"])
</div>




