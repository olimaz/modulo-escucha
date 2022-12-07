
<!-- Es Victima Field -->
<div class="form-group col-sm-6">
    @include('controles.radio_si_no', ['control_control' => 'es_victima'
                                            , 'control_default'=>$entrevistado->es_victima
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'La persona entrevistada, ¿Es víctima de los hechos?'])
</div>

<!-- Es Testigo Field -->
<div class="form-group col-sm-6">
    @include('controles.radio_si_no', ['control_control' => 'es_testigo'
                                            , 'control_default'=>$entrevistado->es_testigo
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'La persona entrevistada, ¿Ha sido testigo/a presencial de los hechos?'])
</div>

<!-- Nombres Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombres', 'Nombres:') !!}
    {!! Form::text('nombres', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Apellidos Field -->
<div class="form-group col-sm-6">
    {!! Form::label('apellidos', 'Apellidos:') !!}
    {!! Form::text('apellidos', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Otros Nombres Field -->
<div class="form-group col-sm-6">
    {!! Form::label('otros_nombres', 'Otros Nombres:') !!}
    {!! Form::text('otros_nombres', null, ['class' => 'form-control']) !!}
</div>

<!-- Nacimiento Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nacimiento_fecha', 'Fecha de nacimiento:') !!}
    {!! Form::text('nacimiento_fecha' , substr($entrevistado->nacimiento_fecha,0,10), ['class' => 'form-control pull-right datepicker2','data-value'=>substr($entrevistado->nacimiento_fecha,0,10)]) !!}
</div>


<!-- Nacimiento Lugar Field -->
<div class="form-group col-sm-12">
    @include('controles.geo3', ['control_control' => 'nacimiento_lugar'
                                ,'control_texto' => 'Lugar de nacimiento'
                                , 'control_default'=>$entrevistado->nacimiento_lugar])
</div>

<!-- Sexo Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'sexo'
                                           ,'control_id_cat'=>24
                                           , 'control_default'=>$entrevistado->sexo
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Sexo (asignado al nacer):'])
</div>


<!-- Orientacion Sexual Field -->
<div class="form-group col-sm-6">

    @include('controles.catalogo', ['control_control' => 'orientacion_sexual'
                                           ,'control_id_cat'=>25
                                           , 'control_default'=>$entrevistado->orientacion_sexual
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Orientación sexual (se siente atraído/a por):'])
</div>

<!-- Identidad Genero Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'identidad_genero'
                                           ,'control_id_cat'=>26
                                           , 'control_default'=>$entrevistado->identidad_genero
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Identidad de género (cómo se identifica):'])

</div>
<div class="clearfix"></div>
<!-- Pertenencia Etnico Racial Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'pertenencia_etnico_racial'
                                           ,'control_id_cat'=>27
                                           , 'control_default'=>$entrevistado->pertenencia_etnico_racial
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Pertenencia étnico-racial:'])
</div>
{{-- Consentiemiento informado --}}
<div class="clearfix"></div>
<div class="col-sm-4">
    <div class="box box-solid box-info">
        <div class="box-header">
            <h3 class="box-title">Consentimiento informado</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('fecha', 'Fecha en que se firma el documento:') !!}
                {!! Form::text('fecha' , substr($entrevistado->fecha,0,10), ['class' => 'form-control pull-right datepicker2','data-value'=>substr($entrevistado->fecha,0,10)]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('identificacion', 'Identificación con que se firma el documento:') !!}
                {!! Form::text('identificacion' , null, ['class' => 'form-control ','required'=>'required']) !!}
            </div>

            @include('controles.radio_si_no', ['control_control' => 'acuerdo_entrevista'
                                            , 'control_default'=>2
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'¿Está de acuerdo en conceder entrevistas a la Comisión de la Verdad? '])

            @include('controles.radio_si_no', ['control_control' => 'acuerdo_audio'
                                            , 'control_default'=>2
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'¿Está de acuerdo en que la Comisión grabe el audio de la entrevista? '])
            @include('controles.radio_si_no', ['control_control' => 'acuerdo_informe'
                                            , 'control_default'=>2
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'¿Está de acuerdo en que su entrevista sea utilizada para elaborar el Informe Final? '])

        </div>
    </div>
</div>
{{-- Tratamiento de datos personales --}}
<div class="col-sm-8">
    <div class="box box-solid box-info">
        <div class="box-header">
            <h3 class="box-title">Autorización para el tratamiento de datos personales</h3>
        </div>
        <div class="box-body">
            <p>¿Autoriza el tratamiento de sus datos para las siguientes finalidades?</p>
            <div class="col-sm-6">
                <h4>Datos Personales</h4>
                @include('controles.radio_si_no', ['control_control' => 'personales_analisis'
                                            , 'control_default'=>2
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Analizarlos, compararlos, contrastarlos con otros datos e información recolectada.'])

                @include('controles.radio_si_no', ['control_control' => 'personales_informe'
                                                , 'control_default'=>2
                                                , 'control_requerido' => true
                                                ,'control_texto'=>'Utilizarlos para la elaboración del Informe Final de la Comisión de la Verdad.'])
                @include('controles.radio_si_no', ['control_control' => 'personales_publicar'
                                                , 'control_default'=>2
                                                , 'control_requerido' => true
                                                ,'control_texto'=>'Publicar su nombre en el Informe Final.'])
            </div>
            <div class="col-sm-6">
                <h4>Datos Sensibles</h4>
                @include('controles.radio_si_no', ['control_control' => 'sensibles_analisis'
                                            , 'control_default'=>2
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Analizarlos, compararlos, contrastarlos con otros datos e información recolectada.'])

                @include('controles.radio_si_no', ['control_control' => 'sensibles_informe'
                                                , 'control_default'=>2
                                                , 'control_requerido' => true
                                                ,'control_texto'=>'Utilizarlos para la elaboración del Informe Final de la Comisión de la Verdad.'])
                @include('controles.radio_si_no', ['control_control' => 'sensibles_publicar'
                                                , 'control_default'=>2
                                                , 'control_requerido' => true
                                                ,'control_texto'=>'Publicar su nombre en el Informe Final.'])
            </div>


        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! action('entrevista_individualController@fichas',$expediente->id_e_ind_fvt) !!}" class="btn btn-default">Cancelar</a>
</div>


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
            //min: new Date(2019,0,1),
            max: true
        });
    </script>
@endpush