<div class="col-xs-12">
    <h4> Selección del niño, niña o adolescente </h4>
</div>
<!-- Id Nna Vulnerabilidad Field -->
<div class="form-group col-sm-6">
    {!! Form::label('num_vulnerabilidad', 'Correlativo NNA:') !!}
    {!! Form::number('num_vulnerabilidad', null, ['class' => 'form-control']) !!}

</div>
<div class="form-group col-sm-6">
    {!! Form::label('vulnerabilidad', 'Código de evaluación de vulnerabilidad') !!}
    {!! Form::text('vulnerabilidad', null, ['class' => 'form-control', 'disabled'=>'disabled']) !!}
    <input type="hidden" name="id_nna_vulnerabilidad" id="id_nna_vulnerabilidad" value="0">
</div>

<div class="clearfix"></div>


<div  id="todos_campos" class="hidden" >
    <div class="col-xs-12">
        <h4> Información de la evaluación</h4>
    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('fecha_evaluacion', 'Fecha en que se realiza esta evaluación:') !!}
        {!! Form::text('fecha_evaluacion' , substr($nnaSeguridad->fecha_evaluacion,0,10), ['class' => 'form-control pull-right datepicker2','data-value'=>substr($nnaSeguridad->fecha_evaluacion,0,10)]) !!}
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12">
        <div class="form-group">
            @include('controles.cev2', ['control_control' => 'id_territorio'
                                                            , 'control_territorio'=>$nnaSeguridad->id_territorio])

        </div>
    </div>

    <!-- Id Quien Refiere Field -->
    <div class="form-group col-sm-6">
        @include('controles.catalogo', ['control_control' => 'id_quien_refiere'
                                            ,'control_id_cat'=>16
                                            , 'control_default'=>$nnaSeguridad->id_quien_refiere
                                            , 'control_multiple' => false
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'¿Quién ha referido al niño/a para la toma de testimonio?'])
    </div>

    <!-- Id Quien Refiere Otro Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('id_quien_refiere_otro', 'Si es otro, ¿Quién? :') !!}
        {!! Form::text('id_quien_refiere_otro', null, ['class' => 'form-control']) !!}
    </div>

    <div class="clearfix"></div>
    <div class="col-xs-12">
        <h4> Preparación de la entrevista </h4>
    </div>

    <!-- Revisar Proceso Field -->
    <div class="form-group col-sm-6">
        @include('controles.radio_si_no', ['control_control' => 'revisar_proceso'
                                            ,'control_default' => $nnaSeguridad->revisar_proceso
                                            ,'control_rojo' => 2
                                            ,'control_texto'=>'¿El profesional ha revisado junto al niño o niña y su representante legal, el proceso de participación en la toma de testimonio de la Comisión de la Verdad?'])

    </div>
    <div class="form-group col-sm-6">
        @include('controles.catalogo', ['control_control' => 'info'
                                            ,'control_id_cat'=>17
                                            , 'control_default'=>$nnaSeguridad->arreglo_info
                                            , 'control_multiple' => true
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Se ha brindado información sobre:'])
    </div>

    <div class="clearfix"></div>
    <!-- Firma Consentimiento Field -->
    <div class="form-group col-sm-6">
        @include('controles.radio_si_no', ['control_control' => 'firma_consentimiento'
                                            ,'control_default' => $nnaSeguridad->firma_consentimiento
                                            ,'control_rojo' => 2
                                            ,'control_texto'=>'¿El niño o niña y su representante legal han firmado el consentimiento informado?'])

    </div>

    <!-- Existe Entidad Field -->
    <div class="form-group col-sm-6">
        @include('controles.radio_si_no', ['control_control' => 'existe_entidad'
                                            ,'control_default' => $nnaSeguridad->existe_entidad
                                            ,'control_rojo' => 2
                                            ,'control_texto'=>'¿Existe en la comunidad alguna entidad u organización social que trabaje sobre el bienestar de niños/as y que apoye el trabajo de la Comisión y pueda brindar apoyo al NNA?'])

    </div>

    <!-- Lugar Privado Field -->
    <div class="form-group col-sm-6">
        @include('controles.radio_si_no', ['control_control' => 'lugar_privado'
                                            ,'control_default' => $nnaSeguridad->lugar_privado
                                            ,'control_rojo' => 2
                                            ,'control_texto'=>'¿Se cuenta con un lugar privado, confidencial y adecuado para el desarrollo de la entrevista con el niño/a?'])
    </div>
    <div class="clearfix"></div>
    <!-- Alguien Acompana Field -->
    <div class="form-group col-sm-6">
        @include('controles.radio_si_no', ['control_control' => 'alguien_acompana'
                                           ,'control_default' => $nnaSeguridad->alguien_acompana
                                           ,'control_rojo' => 2
                                           ,'control_texto'=>'¿Alguien acompañará al niño o niña durante la entrevista? '])

    </div>

    <!-- Alguien Acompana Padre Field -->
    <div class="form-group col-sm-6 hidden" id="grupo_acompana">
        @include('controles.radio_si_no', ['control_control' => 'alguien_acompana_padre'
                                          ,'control_default' => $nnaSeguridad->alguien_acompana_padre

                                          ,'control_texto'=>'Padre o madre o representante legal'])

        @include('controles.radio_si_no', ['control_control' => 'alguien_acompana_ts'
                                          ,'control_default' => $nnaSeguridad->alguien_acompana_ts

                                          ,'control_texto'=>'Trabajador social o profesional psicosocial'])


        @include('controles.radio_si_no', ['control_control' => 'alguien_acompana_otro'
                                          ,'control_default' => $nnaSeguridad->alguien_acompana_otro

                                          ,'control_texto'=>'Otro'])
    </div>

    <!-- Apoyo Identificado Field -->
    <div class="form-group col-sm-12">
        @include('controles.radio_si_no', ['control_control' => 'apoyo_identificado'
                                          ,'control_default' => $nnaSeguridad->apoyo_identificado
                                          ,'control_rojo' => 2
                                          ,'control_texto'=>'¿Se ha identificado alguna persona de apoyo en caso de alguna dificultad durante la entrevista? (Por ej: maestro/a, líder comunitario, organización social, etc.)'])

    </div>


    <div class="clearfix"></div>
    <div class="col-xs-12">
        <h4>Entrevista </h4>
    </div>

    <!-- Informado Presencia Field -->
    <div class="form-group col-sm-6">
        @include('controles.radio_si_no', ['control_control' => 'informado_presencia'
                                         ,'control_default' => $nnaSeguridad->informado_presencia
                                         ,'control_rojo' => 2
                                         ,'control_texto'=>'¿Se ha informado al niño o niña que puede solicitar la presencia de un familiar, representante legal o apoyo psicosocial durante la entrevista? '])


    </div>

    <!-- Entrevista Cierre Field -->
    <div class="form-group col-sm-6">
        @include('controles.radio_si_no', ['control_control' => 'informado_cev'
                                         ,'control_default' => $nnaSeguridad->informado_cev
                                         ,'control_rojo' => 2
                                         ,'control_texto'=>'¿La persona a cargo de la entrevista ha brindado información amplia sobre la Comisión y su importancia? '])
    </div>
    <div class="form-group col-sm-6">
        @include('controles.radio_si_no', ['control_control' => 'entrevista_cierre'
                                         ,'control_default' => $nnaSeguridad->entrevista_cierre
                                         ,'control_rojo' => 2
                                         ,'control_texto'=>'¿La persona a cargo ha realizado un cierre de la entrevista, agradeciendo al niño o niña su participación y se ha asegurado que esté tranquilo para finalizar ?'])
    </div>



    <!-- Entrevista Cierre Porque Field -->
    <div class="form-group col-sm-12 col-sm-6">
        {!! Form::label('entrevista_cierre_porque', 'Si no se hizo cierre, ¿Por qué?') !!}
        {!! Form::textarea('entrevista_cierre_porque', null, ['class' => 'form-control', 'rows'=>3]) !!}
    </div>


    <div class="clearfix"></div>
    <div class="col-xs-12">
        <h4>Seguimiento </h4>
    </div>

    <!-- Entrevista Seguimiento Field -->
    <div class="form-group col-sm-6">
        @include('controles.radio_si_no', ['control_control' => 'entrevista_seguimiento'
                                         ,'control_default' => $nnaSeguridad->entrevista_seguimiento
                                         ,'control_rojo' => 2
                                         ,'control_texto'=>'¿Se planea una visita o encuentro de seguimiento después de la entrevista por parte de la Comisión o una organización aliada? '])
    </div>


    <!-- Observaciones Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('observaciones', 'Observaciones:') !!}
        {!! Form::textarea('observaciones', null, ['class' => 'form-control', 'rows'=>3]) !!}
    </div>


    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Grabar nueva evaluación', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('nnaSeguridads.index') !!}" class="btn btn-default pull-right">Cancelar</a>
    </div>

</div>





@include("nna_seguridads.js_click")

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
            min: new Date(2019,0,1),
            max: true
        });
    </script>
@endpush