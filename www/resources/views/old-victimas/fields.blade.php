<!-- Nombres Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombres', 'Nombres:') !!}
    {!! Form::text('nombres', null, ['class' => 'form-control']) !!}
</div>

<!-- Apellidos Field -->
<div class="form-group col-sm-6">
    {!! Form::label('apellidos', 'Apellidos:') !!}
    {!! Form::text('apellidos', null, ['class' => 'form-control']) !!}
</div>

<!-- Otros Nombres Field -->
<div class="form-group col-sm-6">
    {!! Form::label('otros_nombres', 'Otros Nombres:') !!}
    {!! Form::text('otros_nombres', null, ['class' => 'form-control']) !!}
</div>

<!-- Nacimiento Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nacimiento_fecha', 'Fecha de nacimiento:') !!}
    {!! Form::text('nacimiento_fecha' , substr($victima->nacimiento_fecha,0,10), ['class' => 'form-control pull-right datepicker2','data-value'=>substr($victima->nacimiento_fecha,0,10)]) !!}
</div>


<!-- Nacimiento Lugar Field -->
<div class="form-group col-sm-12">
    @include('controles.geo3', ['control_control' => 'nacimiento_lugar'
                                ,'control_texto' => 'Lugar de nacimiento'
                                , 'control_default'=>$victima->nacimiento_lugar])
</div>

<!-- Sexo Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'sexo'
                                           ,'control_id_cat'=>24
                                           , 'control_default'=>$victima->sexo
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Sexo (asignado al nacer):'])
</div>


<!-- Orientacion Sexual Field -->
<div class="form-group col-sm-6">

    @include('controles.catalogo', ['control_control' => 'orientacion_sexual'
                                           ,'control_id_cat'=>25
                                           , 'control_default'=>$victima->orientacion_sexual
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Orientación sexual (se siente atraído/a por):'])
</div>

<!-- Identidad Genero Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'identidad_genero'
                                           ,'control_id_cat'=>26
                                           , 'control_default'=>$victima->identidad_genero
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Identidad de género (cómo se identifica):'])

</div>
<div class="clearfix"></div>
<!-- Pertenencia Etnico Racial Field -->
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'pertenencia_etnico_racial'
                                           ,'control_id_cat'=>27
                                           , 'control_default'=>$victima->pertenencia_etnico_racial
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Pertenencia étnico-racial:'])
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