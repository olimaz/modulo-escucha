<div class="col-sm-6  {{ $nnaVulnerabiliad->dictamen==1 ? 'bg-success' : 'bg-danger' }}">
        <h1 class="text-center"># NNA: {{ $nnaVulnerabiliad->correlativo }}</h1>
        <p class="text-center  text-bold  {{ $nnaVulnerabiliad->dictamen==1 ? 'text-success' : 'text-danger' }}">{{ $nnaVulnerabiliad->fmt_dictamen }}</p>
        <ul>
            <li>Código: {{ $nnaVulnerabiliad->codigo }}</li>
            <li>Fecha de evaluación: {{ $nnaVulnerabiliad->fmt_fecha_evaluacion }}</li>
            <li>Territorio: {{ $nnaVulnerabiliad->fmt_id_territorio }}</li>

        </ul>
</div>
<br>
<br>

<div class="clearfix"></div>
<div class="col-xs-12" style="margin-top: 20px">
    <div class="box box-primary  box-solid">
        <div class="box-header">
            <h3 class="box-title">
                Información de la evaluación
            </h3>
        </div>
        <div class="box-body">
            <!-- Fecha Entrevista Field -->
            <div class="form-group  col-sm-6">
                {!! Form::label('fecha_evaluacion', 'Fecha en que se realiza la evaluación:') !!}
                <p>{!! $nnaVulnerabiliad->fmt_fecha_evaluacion !!}</p>
            </div>
            <div class="form-group  col-sm-6">
                {!! Form::label('territorio', 'Territorio en que se realiza la evaluación:') !!}
                <p>{!! $nnaVulnerabiliad->fmt_id_territorio !!}</p>
            </div>


            <!-- Nombres Field -->
            <div class="form-group  col-xs-12">
                {!! Form::label('nombres', 'Nombre completo:') !!}
                <p>{!! $nnaVulnerabiliad->fmt_nombres !!} {{ $nnaVulnerabiliad->fmt_apellidos  }}</p>
            </div>


            <!-- Edad Field -->
            <div class="form-group col-xs-12">
                {!! Form::label('edad', 'Edad:') !!}
                <p>
                    {!! $nnaVulnerabiliad->edad !!}
                    @if( $nnaVulnerabiliad->menor_12 ==1)
                        <span class="text-danger">(menor de 12 años)</span>
                    @endif
                </p>
            </div>



            <!-- Vive Familia Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('vive_familia', 'El niño/a vive con padre y/o madre o familia extensa:') !!}
                <p>{!! $nnaVulnerabiliad->fmt_vive_familia !!}</p>
            </div>
            <!-- Vive Con Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('vive_con', '¿Con quienes vive?') !!}
                <p>{!! $nnaVulnerabiliad->vive_con !!}</p>
            </div>

            <!-- Vive Padre Madre Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('vive_padre_madre', 'El niño/a vive con padre y/o madre:') !!}
                <p>{!! $nnaVulnerabiliad->fmt_vive_padre_madre !!}</p>
            </div>

            <!-- Vive Rep Legal Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('vive_rep_legal', 'El niño/a vive con representante legal ') !!}
                <p>{!! $nnaVulnerabiliad->fmt_vive_rep_legal !!}</p>
            </div>

            <!-- Vive Familia Extensa Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('vive_familia_extensa', 'El niño/a vive con su familia extensa ') !!}
                <p>{!! $nnaVulnerabiliad->fmt_vive_familia_extensa !!}</p>
            </div>

            <div class="clearfix"></div>


            <!-- Pariticipa Familia Field -->
            <div class="form-group col-xs-12">
                {!! Form::label('pariticipa_familia', 'Formas de participación del niño/a en la vida de su familia (cómo está compuesta su familia, actividades cotidianas, apoyo en el hogar, cuidado a otros/as, toma de decisiones, etc.)') !!}
                <p>{!! $nnaVulnerabiliad->fmt_participa_familia !!}</p>
            </div>

            <!-- Pariticipa Comunidad Field -->
            <div class="form-group col-xs-12">
                {!! Form::label('pariticipa_comunidad', 'Formas de participación del niño/a en la vida comunidad (actividades deportivas, culturales, tradicionales, religiosas, barriales, escolares, etc.)') !!}
                <p>{!! $nnaVulnerabiliad->fmt_participa_comunidad !!}</p>
            </div>

            <!-- Escuela Asiste Field -->
            <div class="form-group col-xs-12">
                {!! Form::label('escuela_asiste', 'Está el niño/a o adolescente asistiendo a la escuela o ya terminó la escuela?') !!}
                <p>{!! $nnaVulnerabiliad->fmt_escuela_asiste !!}</p>
            </div>

            <!-- Escuela Nombre Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('escuela_nombre', 'Nombre de la escuela:') !!}
                <p>{!! $nnaVulnerabiliad->escuela_nombre !!}</p>
            </div>

            <!-- Escuela Grado Field -->
            <div class="form-group  col-sm-6">
                {!! Form::label('escuela_grado', 'Grado:') !!}
                <p>{!! $nnaVulnerabiliad->escuela_grado !!}</p>
            </div>

            <!-- Escuela Problemas Field -->
            <div class="form-group  col-sm-6">
                {!! Form::label('escuela_problemas', 'Está el niño/a viviendo situaciones difíciles o problemas específicos en la escuela? (por ej: poca asistencia, problemas significativos de comportamiento, de concentración, relaciones con pares, etc.)') !!}
                <p>{!! $nnaVulnerabiliad->fmt_escuela_problemas !!}</p>
            </div>

            <!-- Escuela Progreso Field -->
            <div class="form-group  col-sm-6">
                {!! Form::label('escuela_progreso', 'Progreso en la escuela:¿El niño o niña ha expresado dificultades para aprender u otra dificultad del contexto escolar?') !!}
                <p>{!! $nnaVulnerabiliad->fmt_escuela_problemas_progreso !!}</p>
            </div>
            <div class="clearfix"></div>

            <!-- Abuso Exposicion Field -->
            <div class="form-group  col-xs-12">
                {!! Form::label('abuso_exposicion', '¿Ha estado el niño o niña expuesto/a a situaciones estresantes o violentas en casa, comunidad o escuela en los últimos seis meses?') !!}
                <p>{!! $nnaVulnerabiliad->fmt_abuso_exposicion !!}</p>
            </div>

            <!-- Abuso Fisico Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('abuso_fisico', 'Abuso físico:') !!}
                <p>{!! $nnaVulnerabiliad->fmt_abuso_fisico !!}</p>
            </div>

            <!-- Abuso Sexual Field -->
            <div class="form-group  col-sm-6">
                {!! Form::label('abuso_sexual', 'Abuso sexual:') !!}
                <p>{!! $nnaVulnerabiliad->fmt_abuso_sexual !!}</p>
            </div>

            <!-- Abuso Abandono Field -->
            <div class="form-group  col-sm-6">
                {!! Form::label('abuso_abandono', 'Abandono o negligencia:') !!}
                <p>{!! $nnaVulnerabiliad->fmt_abuso_abandono !!}</p>
            </div>

            <!-- Abuso Ajustes Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('abuso_ajustes', 'Ajustes significativos en la vida familiar, escuela o comunidad :') !!}
                <p>{!! $nnaVulnerabiliad->fmt_abuso_ajustes !!}</p>
            </div>
            <div class="clearfix"></div>
            <hr>

            <!-- Comunidad Conocimiento Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('comunidad_conocimiento', '¿Cuenta la comunidad con una adecuada comprensión del mandato y objetivos de la Comisión?') !!}
                <p>{!! $nnaVulnerabiliad->fmt_comunidad_conocimiento !!}</p>
            </div>

            <!-- Comunidad Mensajes Field -->
            <div class="form-group  col-sm-6">
                {!! Form::label('comunidad_mensajes', '¿Qué tipo de mensajes ha recibido la comunidad sobre la Comisión?:') !!}
                <p>{!! nl2br($nnaVulnerabiliad->comunidad_mensajes)  !!}</p>
            </div>
            <div class="clearfix"></div>

            <!-- Comunidad Reuniones Field -->
            <div class="form-group  col-sm-6">
                {!! Form::label('comunidad_reuniones', '¿Se han llevado a cabo reuniones informativas con padres, madres, profesores o lideres/as comunitarios?') !!}
                <p>{!! $nnaVulnerabiliad->fmt_comunidad_reuniones !!}</p>
            </div>

            <!-- Comunidad Apoyo Field -->
            <div class="form-group  col-sm-6">
                {!! Form::label('comunidad_apoyo', '¿Está dispuesta la comunidad para brindar apoyo a la misión de la Comisión?') !!}
                <p>{!! $nnaVulnerabiliad->fmt_comunidad_apoyo !!}</p>
            </div>

            <hr>

            <!-- Observaciones Field -->
            <div class="form-group col-xs-12">
                {!! Form::label('observaciones', 'Observaciones:') !!}
                <p>{!! nl2br($nnaVulnerabiliad->observaciones) !!}</p>
            </div>


        </div>
    </div>
</div>
