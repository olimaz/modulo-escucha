
<div class="clearfix"></div>
<div class="row">
    <div class="col-sm-12">
        <div class="box {{ $expediente->clasificacion_nivel==4 ? "box-success" : "" }} {{ $expediente->clasificacion_nivel==3 ? "box-warning" : "" }} {{ $expediente->clasificacion_nivel<=2 ? "box-danger" : "" }}  box-solid">
            <div class="box-header">
                <h3 class="box-title ">
                    Clasificación del acceso: Reservado-{{ $expediente->clasificacion_nivel }}

                </h3>
            </div>
            <div class="box-body">
                <div class="col-sm-12">
                    <ol>
                        <li>Esta entrevista, ¿incluye declaraciones de algún <span class="text-green">niño, niña o adolescente</span>? <b> {!! \App\Models\entrevista_individual::clasificacion_rojo($expediente->clasificacion_nna)  !!}</b></li>
                        <li>Esta entrevista, ¿incluye información de <span class="text-green">violencia sexual</span>? <b>{!! \App\Models\entrevista_individual::clasificacion_rojo($expediente->clasificacion_sex) !!} </b></li>
                        <li>Esta entrevista, ¿incluye <span class="text-green">reconocimiento de responsabilidades individuales</span>? <b>{!! \App\Models\entrevista_individual::clasificacion_rojo($expediente->clasificacion_res) !!} </b></li>
                        @if(isset($expediente->id_subserie))
                            <li>Esta entrevista, ¿es una entrevista a  <span class="text-green">Actores Armados o Terceros Civiles</span>? <b>{!! $expediente->fmt_clasifica_aa_tc !!} </b></li>
                        @endif
                        <li>Esta entrevista, ¿ha sido clasificada con  <span class="text-green">nivel de acceso R-2</span>? <b>{!! \App\Models\entrevista_individual::clasificacion_rojo($expediente->clasificacion_r2) !!} </b></li>
                        <li>Esta entrevista, ¿ha sido clasificada con  <span class="text-green">nivel de acceso R-1</span>? <b>{!! \App\Models\entrevista_individual::clasificacion_rojo($expediente->clasificacion_r1) !!} </b></li>
                    </ol>
                </div>
            </div>
            @if($expediente->clasifica_nivel==3)
                <div class="box-footer">
                    Entrevistadores con acceso a los archivos adjuntos: {{ $expediente->accesos_autorizados }}
                </div>
            @endif
        </div>
    </div>
</div>
<div class="clearfix"></div>
