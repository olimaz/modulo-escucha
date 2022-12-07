
{!! Form::hidden('id_entrevistador', $entrevistaIndividual->id_entrevistador) !!}
{!! Form::hidden('id_subserie', $entrevistaIndividual->id_subserie) !!}

<!-- Entrevista Numero Field -->
<div class="form-group col-sm-2">
   {!! Form::label('entrevista_numero', 'Entrevista Código: '.$entrevistaIndividual->prefijo_codigo()) !!}
    {!! Form::number('entrevista_numero', null, ['class' => 'form-control','required'=>'required','maxlength'=>5, 'title'=>'Se sugiere utilizar este número, pero puede modificarlo si fuera el caso','data-toggle'=>"tooltip" ]) !!}
</div>

<div class="form-group col-sm-2">
    {!! Form::label('tiempo_entrevista', 'Duración de la entrevista: ') !!}
    {!! Form::number('tiempo_entrevista', null, ['class' => 'form-control','required'=>'required','maxlength'=>5,'data-toggle'=>"tooltip" ,'title'=>'Indicar un aproximado de la duración total (en minutos) de los audios  de la entrevista','min'=>0,'max'=>2400,'step'=>1, 'placeholder'=>'En minutos']) !!}
</div>


<!-- Id Macroterritorio Field -->
<div class="form-group col-sm-8">
    @include('controles.cev2', ['control_control' => 'id_territorio'
                                            , 'control_territorio'=>$entrevistaIndividual->id_territorio])
</div>


<div class="clearfix"></div>

<!-- Entrevista Fecha Field -->
<div class="form-group col-sm-3">
    {!! Form::label('entrevista_fecha', 'Fecha de la entrevista:') !!}
    {!! Form::text('entrevista_fecha' , substr($entrevistaIndividual->entrevista_fecha,0,10), ['class' => 'form-control pull-right datepicker2','data-value'=>substr($entrevistaIndividual->entrevista_fecha,0,10)]) !!}
</div>

<div class="form-group col-sm-3">
    @include('controles.catalogo', ['control_control' => 'id_remitido'
                                           ,'control_default' => $entrevistaIndividual->id_remitido
                                           ,'control_id_cat' => 33
                                           ,'control_vacio' => '[Ninguno]'
                                           ,'control_texto'=>'Esta es una entrevista remitida por:'])
</div>

@if($entrevistaIndividual->id_subserie == config('expedientes.vi'))
    <!-- Nna Field -->
    <div class="form-group col-sm-3">
        @include('controles.radio_si_no', ['control_control' => 'nna'
                                            ,'control_default' => $entrevistaIndividual->nna
                                            ,'control_texto'=>'Esta es una entrevista de niño, niña o adolescente (NNA)'])
    </div>
@else
    {!! Form::hidden('nna', 0) !!}
@endif

<div class="form-group col-sm-3">
    @include('controles.radio_si_no', ['control_control' => 'id_etnico'
                                           ,'control_default' => $entrevistaIndividual->id_etnico

                                           //,'control_vacio' => '[Ninguno]'
                                           ,'control_texto'=>'Esta es una entrevista de interés étnico <b class="text-primary" title="La entrevista incluye información sobre Pueblos Étnicos (Indígenas, Negros, Afrocolombianos, Raizales, Palenqueros o Rrom) o se realiza a uno de sus miembros." data-toggle="tooltip"> <i class="fa fa-question-circle" aria-hidden="true"></i> </b>:'])
</div>



<div class="clearfix"></div>



<!-- Entrevista Lugar Field -->
<div class="form-group col-sm-9">
    @include('controles.geo3', ['control_control' => 'entrevista_lugar'
                                ,'control_texto' => 'Lugar de la entrevista <span class=text-muted>(Si es por medios virtuales, indicar la ubicación de la persona entrevistada)</span>'
                                , 'control_default'=>$entrevistaIndividual->entrevista_lugar])
</div>

{{--  entrevista virtual --}}
<div class="form-group col-sm-3">
    @include('controles.radio_si_no', ['control_control' => 'es_virtual'
                                        ,'control_default' => $entrevistaIndividual->es_virtual
                                        ,'control_texto'=>'Esta entrevista se realizó por medios virtuales'])
</div>

<div class="clearfix"></div>
<hr>


<div class="form-group col-sm-6">

    @include('controles.fecha_rango', ['control_control' => 'hechos_rango'
                                        ,'control_default' => $entrevistaIndividual->fecha_rango
                                        ,'control_requerido' => true
                                        ,'control_texto'=>'Período en que ocurrieron los hechos:'])



</div>


<div class="clearfix"></div>

{{-- dinamicas --}}
<div class="form-group col-sm-12">
    {!! Form::label('titulo', 'Título: ') !!}
    <p class="text-primary"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Describa la entrevista con un texto que le facilite ubicarla posteriormente. (No se permiten nombres propios de personas.)</p>
    {!! Form::text('titulo', null, ['class' => 'form-control','required'=>'required' ]) !!}
</div>

<!-- Hechos Lugar Field -->
<div class="form-group col-sm-12">
    @include('controles.geo3', ['control_control' => 'hechos_lugar'
                                ,'control_texto' => 'Lugar de los hechos'
                                , 'control_default'=>$entrevistaIndividual->hechos_lugar])
</div>

<div class="clearfix"></div>

@if($entrevistaIndividual->id_subserie == config('expedientes.vi'))
    <div class="col-sm-4">
        @include('controles.catalogo', ['control_control' => 'fr'
                                            ,'control_id_cat'=>4
                                            , 'control_default'=>$entrevistaIndividual->arreglo_fr
                                            , 'control_multiple' => true
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Responsable/Participante:'])
    </div>

    <div class="col-sm-4">
        @include('controles.catalogo', ['control_control' => 'tv'
                                            ,'control_id_cat'=>5
                                            , 'control_default'=>$entrevistaIndividual->arreglo_tv
                                            , 'control_multiple' => true
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Violencia registrada:'])
    </div>

    <div class="form-group col-sm-4">
        @include('controles.catalogo', ['control_control' => 'id_sector'
                                                ,'control_id_cat'=>18
                                                , 'control_default'=>$entrevistaIndividual->id_sector
                                                , 'control_multiple'=>false
                                                , 'control_requerido' => true
                                                , 'control_vacio' => 'Ninguno / No aplica/ Sin identificar'
                                                ,'control_texto'=>'Sector con el que se puede identificar a la organización de víctimas en el relato:'])
    </div>
@elseif($entrevistaIndividual->id_subserie == config('expedientes.aa'))
    <div class="col-sm-6">
        @include('controles.catalogo', ['control_control' => 'fr'
                                            ,'control_id_cat'=>4
                                            , 'control_default'=>$entrevistaIndividual->arreglo_fr
                                            , 'control_multiple' => true
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Actor armado del que hace/hacía parte:'])
    </div>
    <div class="col-sm-6">
        @include('controles.catalogo', ['control_control' => 'aa'
                                            ,'control_id_cat'=>8
                                            , 'control_default'=>$entrevistaIndividual->arreglo_aa
                                            , 'control_multiple' => true
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Temas abordados:'])
    </div>
@elseif($entrevistaIndividual->id_subserie == config('expedientes.tc'))
    <div class="col-sm-6">
        @include('controles.catalogo', ['control_control' => 'stc'
                                            ,'control_id_cat'=>10
                                            , 'control_default'=>$entrevistaIndividual->arreglo_stc
                                            , 'control_multiple' => true
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Sectores en los que hace/hacía parte:'])
    </div>
    <div class="col-sm-6">
        @include('controles.catalogo', ['control_control' => 'tc'
                                            ,'control_id_cat'=>9
                                            , 'control_default'=>$entrevistaIndividual->arreglo_tc
                                            , 'control_multiple' => true
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Temas abordados:'])
    </div>
@endif

<div class="clearfix"></div>

{{-- Analisis preliminar --}}
<hr>
{{-- Intereses --}}
<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'interes'
                                            ,'control_id_cat'=>19
                                            , 'control_default'=>$entrevistaIndividual->arreglo_interes
                                            , 'control_multiple'=>true
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Es de utilidad para el/los núcleo/s de:'])
</div>
<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'interes_area'
                                            ,'control_id_cat'=>85
                                            , 'control_default'=>$entrevistaIndividual->arreglo_interes_area
                                            , 'control_multiple'=>true
                                            , 'control_requerido' => true
                                            , 'control_vacio' => 'Ninguno / No Aplica'
                                            ,'control_texto'=>'Puede ser de utilidad para el/las área/s de:'])
</div>
{{-- Manadato --}}
<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'mandato'
                                            ,'control_id_cat'=>15
                                            , 'control_default'=>$entrevistaIndividual->arreglo_mandato
                                            , 'control_multiple'=>true
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Coincide con los siguientes puntos del mandato:'])
</div>
{{-- dinamicas --}}
<div class="form-group col-sm-12">
    {!! Form::label('dinamica', 'Señale hasta 3 dinámicas que le hayan llamado la atención a partir de lo narrado en la entrevista: ') !!}
    <p class="text-primary"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Por favor ingrese en este espacio, posibles temas, preguntas, o  tendencias clave que haya identificado durante la entrevista y que  ayuden a documentar los diferentes mandatos.</p>
    {!! Form::text('dinamica[]', $entrevistaIndividual->arreglo_dinamica[0], ['class' => 'form-control','required'=>'required' ]) !!}
    <br>
    {!! Form::text('dinamica[]', $entrevistaIndividual->arreglo_dinamica[1], ['class' => 'form-control' ]) !!}
    <br>
    {!! Form::text('dinamica[]', $entrevistaIndividual->arreglo_dinamica[2], ['class' => 'form-control' ]) !!}

</div>

{{-- Priorización --}}


<!-- Id Sector Field -->

<div class="clearfix"></div>
<!-- Anotaciones Field -->
 <div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('anotaciones', 'Anotaciones:') !!}
    {!! Form::textarea('anotaciones', null, ['class' => 'form-control','rows'=>'3']) !!}
</div>





@include("controles.js_carga_archivo")


@push('js')
    {{-- Scripts para seleccionar  los radio de la clasificacion--}}
    <script>
        $("input[name='nna']").change(function() {
            var valor = $('input[name=nna]:checked').val();
            if(valor==1) {
                $("#clasifica_nna_1").iCheck('check');
            }
            else {
                $("#clasifica_nna_2").iCheck('check')
            }
        });

        $("#tv").change(function() {
            if(jQuery.inArray("{{ config('expedientes.vs') }}", $("#tv").val()) >= 0) {
                $("#clasifica_sex_1").iCheck('check');
            }
        });

    </script>
@endpush

@push('js')
    <script>
        $('.datepicker2').pickadate({
            selectMonths: true // Creates a dropdown to control month
            , selectYears: 75 // Creates a dropdown of 15 years to control year
            //The format to show on the `input` element
            , format: 'dd-mmmm-yyyy'   //Como se muestra al usuario
            , formatSubmit: 'yyyy-mm-dd',  //IMPORTANTE: para el submit
            //The title label to use for the month nav buttons
            labelMonthNext: 'Mes siguiente',
            labelMonthPrev: 'Mes anterior',
            //The title label to use for the dropdown selectors
            labelMonthSelect: 'Elegir mes',
            labelYearSelect: 'Elegir año',
            //Months and weekdays
            monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            //Materialize modified
            weekdaysLetter: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            //Today and clear
            today: 'Hoy',
            clear: 'Limpiar',
            close: 'Cerrar',
            //Limites
            min: new Date(2018,0,1),
            max: true
        });
    </script>
@endpush
