<div class="col-xs-12">
    <h4> Información de la evaluación</h4>
</div>
<!-- Fecha Entrevista Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_evaluacion', 'Fecha en que se realiza esta evaluación:') !!}
    {!! Form::text('fecha_evaluacion' , substr($nnaVulnerabiliad->fecha_evaluacion,0,10), ['class' => 'form-control pull-right datepicker2','data-value'=>substr($nnaVulnerabiliad->fecha_evaluacion,0,10)]) !!}
</div>
<div class="clearfix"></div>
<div class="col-xs-12">
    <div class="form-group">
        @include('controles.cev2', ['control_control' => 'id_territorio'
                                                        , 'control_territorio'=>$nnaVulnerabiliad->id_territorio])

    </div>
</div>


<div class="clearfix"></div>
<div class="col-xs-12">
    <h4> Información del niño, niña o adolescente</h4>
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

<!-- Edad Field -->
<div class="form-group col-sm-6">
    {!! Form::label('edad', 'Edad:') !!}
    {!! Form::number('edad', null, ['class' => 'form-control','required'=>'required','min'=>"1", 'max'=>"17"]) !!}
</div>

<!-- Menor 12 Field -->
<div class="form-group col-sm-6">
    @include('controles.radio_si_no', ['control_control' => 'menor_12'
                                            ,'control_default' => $nnaVulnerabiliad->menor_12
                                            ,'control_rojo' => 1
                                            ,'control_texto'=>'Menor de 12 años'])

</div>

<!-- Vive Familia Field -->
<div class="form-group col-sm-6">
        @include('controles.radio_si_no', ['control_control' => 'vive_familia'
                                            ,'control_default' => $nnaVulnerabiliad->vive_familia
                                            ,'control_rojo' => 2
                                            ,'control_texto'=>'El niño/a vive con padre y/o madre o familia extensa'])
</div>
<div class="clearfix"></div>

<div class="col-sm-6">
    <!-- Vive Con Field -->
    <div class="form-group ">
        {!! Form::label('vive_con', '¿Con quienes vive?') !!}
        {!! Form::textarea('vive_con', null, ['class' => 'form-control', 'rows'=>3]) !!}
    </div>

</div>
<div class="col-sm-6 hidden" id="grupo_familia">
    <!-- Vive Padre Madre Field -->
    <div class="form-group ">
        @include('controles.radio_si_no', ['control_control' => 'vive_padre_madre'
                                            ,'control_default' => $nnaVulnerabiliad->vive_padre_madre
                                            ,'control_texto'=>'El niño/a vive con padre y/o madre'])

    </div>

    <!-- Vive Rep Legal Field -->
    <div class="form-group ">

        @include('controles.radio_si_no', ['control_control' => 'vive_rep_legal'
                                            ,'control_default' => $nnaVulnerabiliad->vive_rep_legal
                                            ,'control_texto'=>'El niño/a vive con representante legal '])

    </div>

    <!-- Vive Familia Extensa Field -->
    <div class="form-group ">
        @include('controles.radio_si_no', ['control_control' => 'vive_familia_extensa'
                                                ,'control_default' => $nnaVulnerabiliad->vive_familia_extensa
                                                ,'control_texto'=>'El niño/a vive con su familia extensa '])
    </div>
</div>




<!-- Pariticipa Familia Field -->
<div class="form-group col-xs-12">
    @include('controles.radio_si_no', ['control_control' => 'pariticipa_familia'
                                           ,'control_default' => $nnaVulnerabiliad->pariticipa_familia
                                           ,'control_rojo' => 2
                                           ,'control_opciones' => [1=>'Participa en la vida familiar',2=>'No participa en la vida familiar']
                                           ,'control_texto'=>'Formas de participación del niño/a en la vida de su familia (cómo está compuesta su familia, actividades cotidianas, apoyo en el hogar, cuidado a otros/as, toma de decisiones, etc.)'])

</div>

<!-- Pariticipa Comunidad Field -->
<div class="form-group col-xs-12">
    @include('controles.radio_si_no', ['control_control' => 'pariticipa_comunidad'
                                           ,'control_default' => $nnaVulnerabiliad->pariticipa_comunidad
                                           ,'control_rojo' => 2
                                           ,'control_opciones' => [1=>'Participa en estos espacios',2=>'No participa en estos espacios']
                                           ,'control_texto'=>'Formas de participación del niño/a en la vida comunidad (actividades deportivas, culturales, tradicionales, religiosas, barriales, escolares, etc.)'])

</div>

<!-- Escuela Asiste Field -->
<div class="form-group col-xs-12">
    @include('controles.radio_si_no', ['control_control' => 'escuela_asiste'
                                            ,'control_default' => $nnaVulnerabiliad->escuela_asiste
                                            ,'control_rojo' => 2
                                            ,'control_opciones' => [1=>'Sí asiste o ya terminó la escuela',2=>'No atiende a la escuela']
                                            ,'control_texto'=>'Está el niño/a o adolescente asistiendo a la escuela o ya terminó la escuela? '])
</div>

<!-- Escuela Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('escuela_nombre', 'Nombre de la escuela:') !!}
    {!! Form::text('escuela_nombre', null, ['class' => 'form-control']) !!}
</div>

<!-- Escuela Grado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('escuela_grado', 'Grado:') !!}
    {!! Form::text('escuela_grado', null, ['class' => 'form-control']) !!}
</div>

<!-- Escuela Problemas Field -->
<div class="form-group col-sm-6">
    @include('controles.radio_si_no', ['control_control' => 'escuela_problemas'
                                            ,'control_default' => $nnaVulnerabiliad->escuela_problemas
                                            ,'control_rojo' => 1
                                            ,'control_opciones' => [1=>'Vive situaciones significativas en este momento en la escuela ',2=>'No']
                                            ,'control_texto'=>'Está el niño/a viviendo situaciones difíciles o problemas específicos en la escuela? (por ej: poca asistencia, problemas significativos de comportamiento, de concentración, relaciones con pares, etc.) '])
</div>

<!-- Escuela Progreso Field -->
<div class="form-group col-sm-6">
    @include('controles.radio_si_no', ['control_control' => 'escuela_problemas_progreso'
                                            ,'control_default' => $nnaVulnerabiliad->escuela_problemas_progreso
                                            ,'control_rojo' => 1
                                            ,'control_opciones' => [1=>'Vive situaciones significativas en este momento en la escuela ',2=>'No']
                                            ,'control_texto'=>'Progreso en la escuela: <br> ¿El niño o niña ha expresado dificultades para aprender u otra dificultad del contexto escolar? '])

</div>

<!-- Abuso Exposicion Field -->
<div class="form-group col-sm-6">
    @include('controles.radio_si_no', ['control_control' => 'abuso_exposicion'
                                           ,'control_default' => $nnaVulnerabiliad->abuso_exposicion
                                           ,'control_rojo' => 1
                                           ,'control_texto'=>'¿Ha estado el niño o niña expuesto/a a situaciones estresantes o violentas en casa, comunidad o escuela en los últimos seis meses?'])
</div>

<!-- Abuso Fisico Field -->
<div class="form-group col-sm-6" id="grupo_abuso">
    <br>
    <br>
    <br>
    @include('controles.radio_si_no', ['control_control' => 'abuso_fisico'
                                           ,'control_default' => $nnaVulnerabiliad->abuso_fisico
                                           ,'control_texto'=>'Abuso físico'])

    @include('controles.radio_si_no', ['control_control' => 'abuso_sexual'
                                           ,'control_default' => $nnaVulnerabiliad->abuso_sexual
                                           ,'control_texto'=>'Abuso sexual'])

    @include('controles.radio_si_no', ['control_control' => 'abuso_abandono'
                                          ,'control_default' => $nnaVulnerabiliad->abuso_abandono
                                          ,'control_texto'=>'Abandono o negligencia'])

    @include('controles.radio_si_no', ['control_control' => 'abuso_ajustes'
                                           ,'control_default' => $nnaVulnerabiliad->abuso_ajustes
                                           ,'control_texto'=>'Ajustes significativos en la vida familiar, escuela o comunidad '])


</div>

<div class="clearfix"></div>
<div class="col-xs-12">
    <h4> Información de la comunidad</h4>
</div>

<!-- Comunidad Conocimiento Field -->
<div class="form-group col-sm-6">
    @include('controles.radio_si_no', ['control_control' => 'comunidad_conocimiento'
                                           ,'control_default' => $nnaVulnerabiliad->comunidad_conocimiento
                                           ,'control_rojo' => 2
                                           ,'control_opciones' => [1=>'Sí ',2=>'La comunidad no ha escuchado nada acerca de la Comisión. ']
                                           ,'control_texto'=>'¿Cuenta la comunidad con una adecuada comprensión del mandato y objetivos de la Comisión?'])
</div>

<!-- Comunidad Mensajes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('comunidad_mensajes', '¿Qué tipo de mensajes ha recibido la comunidad sobre la Comisión? ') !!}
    {!! Form::textarea('comunidad_mensajes', null, ['class' => 'form-control', 'rows'=>3]) !!}
</div>
<div class="clearfix"></div>

<!-- Comunidad Reuniones Field -->
<div class="form-group col-sm-6">
    @include('controles.radio_si_no', ['control_control' => 'comunidad_reuniones'
                                          ,'control_default' => $nnaVulnerabiliad->comunidad_reuniones
                                          ,'control_rojo' => 2
                                          ,'control_texto'=>'¿Se han llevado a cabo reuniones informativas con padres, madres, profesores o lideres/as comunitarios?'])
</div>

<!-- Comunidad Apoyo Field -->
<div class="form-group col-sm-6">
    @include('controles.radio_si_no', ['control_control' => 'comunidad_apoyo'
                                          ,'control_default' => $nnaVulnerabiliad->comunidad_apoyo
                                          ,'control_rojo' => 2
                                          ,'control_opciones' => [1=>'Sí ',2=>'El niño o niña necesita protección especial después de dar el testimonio']
                                          ,'control_texto'=>'¿Está dispuesta la comunidad para brindar apoyo a la misión de la Comisión? '])

</div>



@section('scripts')
    <script type="text/javascript">
        $('#fecha_entrevista').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Observaciones Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    {!! Form::textarea('observaciones', null, ['class' => 'form-control', 'rows'=>3]) !!}
</div>



<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('nnaVulnerabiliads.index') !!}" class="btn btn-default pull-right">Cancelar</a>
</div>


@include("nna_vulnerabiliads.js_click")
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
