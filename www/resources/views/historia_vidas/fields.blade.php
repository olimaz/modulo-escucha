{!! Form::hidden('id_entrevistador', $historiaVida->id_entrevistador) !!}

<!-- Correlativo de la entrevista -->
<div class="form-group col-sm-2">
    {!! Form::label('entrevista_numero', 'Entrevista Código: '.$historiaVida->prefijo_codigo()) !!}
    {!! Form::number('entrevista_numero', null, ['class' => 'form-control','required'=>'required','maxlength'=>5, 'title'=>'Se sugiere utilizar este número, pero puede modificarlo si fuera el caso','data-toggle'=>"tooltip" ]) !!}
</div>

<div class="form-group col-sm-2">
    {!! Form::label('tiempo_entrevista', 'Duración de la entrevista: ') !!}
    {!! Form::number('tiempo_entrevista', null, ['class' => 'form-control','required'=>'required','maxlength'=>5,'data-toggle'=>"tooltip" ,'title'=>'Indicar un aproximado de la duración total (en minutos) de los audios  de la entrevista','min'=>0,'max'=>2400,'step'=>1, 'placeholder'=>'En minutos']) !!}
</div>



<!-- Macroterritorio -->
<div class="form-group col-sm-8">
    @include('controles.cev2', ['control_control' => 'id_territorio'
                                                , 'control_territorio'=>$historiaVida->id_territorio])
</div>
<div class="clearfix"></div>

<!-- Fecha de la entrevista -->
<div class="form-group col-sm-4">
    @include('controles.fecha', ['control_control' => 'entrevista_fecha_inicio'
                                ,'control_texto' => 'Fecha de inicio la entrevista'
                                , 'control_default'=>$historiaVida->entrevista_fecha_inicio])
</div>
<div class="form-group col-sm-4">
    @include('controles.fecha', ['control_control' => 'entrevista_fecha_final'
                                ,'control_texto' => 'Fecha de finalización de la entrevista'
                                , 'control_default'=>$historiaVida->entrevista_fecha_final])
</div>
<div class="form-group col-sm-4">
    @include('controles.catalogo', ['control_control' => 'entrevista_avance'
                                           ,'control_id_cat'=>20
                                           , 'control_default'=>$historiaVida->entrevista_avance
                                           , 'control_multiple'=>false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Situación actual de la entrevista:'])
</div>

<!-- Entrevista Lugar Field -->
<div class="form-group col-sm-9">
    @include('controles.geo3', ['control_control' => 'entrevista_lugar'
                                ,'control_texto' => 'Lugar de la entrevista <span class=text-muted>(Si es por medios virtuales, indicar la ubicación de la persona entrevistada)</span>'
                                , 'control_default'=>$historiaVida->entrevista_lugar])
</div>
{{--  entrevista virtual --}}
<div class="form-group col-sm-3">
    @include('controles.radio_si_no', ['control_control' => 'es_virtual'
                                        ,'control_default' => $historiaVida->es_virtual
                                        ,'control_texto'=>'Esta entrevista se realizó por medios virtuales'])
</div>
<div class="clearfix"></div>

<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('entrevista_objetivo', 'Objetivo de la entrevista:') !!}
    <p class="text-muted">Describa brevemente las razones por las cuales se elige a esta persona para la realización de la historia de vida.</p>
    {!! Form::textarea('entrevista_objetivo', null, ['class' => 'form-control','rows'=>3,'required'=>'required']) !!}
</div>

{{-- Entrevistado --}}
<div class="form-group col-sm-8">
    {!! Form::label('entrevistado_nombres', 'Nombres y apellidos de la persona entrevistada: ') !!}
    {!! Form::text('entrevistado_nombres', null, ['class' => 'form-control','required'=>'required','maxlength'=>200 ]) !!}
</div>
{{--
<div class="form-group col-sm-4">
    {!! Form::label('entrevistado_apellidos', 'Apellidos de la persona entrevistada: ') !!}
    {!! Form::text('entrevistado_apellidos', null, ['class' => 'form-control','required'=>'required','maxlength'=>100 ]) !!}
</div>
--}}
<div class="form-group col-sm-4">
    {!! Form::label('entrevistado_otros_nombres', 'Otros Nombres: ') !!}
    {!! Form::text('entrevistado_otros_nombres', null, ['class' => 'form-control','maxlength'=>100 ]) !!}
</div>

<div class="clearfix"></div>
<div class="form-group col-sm-4">
    @include('controles.catalogo', ['control_control' => 'id_sexo'
                                           ,'control_id_cat'=>24
                                           , 'control_default'=>$historiaVida->id_sexo
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Sexo (asignado al nacer):'])
</div>


<!-- Orientacion Sexual Field -->
<div class="form-group col-sm-4">

    @include('controles.catalogo', ['control_control' => 'id_orientacion_sexual'
                                           ,'control_id_cat'=>25
                                           , 'control_default'=>$historiaVida->id_orientacion_sexual
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Orientación sexual (se siente atraído/a por):'])
</div>

<!-- Identidad Genero Field -->
<div class="form-group col-sm-4">
    @include('controles.catalogo', ['control_control' => 'id_identidad_genero'
                                           ,'control_id_cat'=>26
                                           , 'control_default'=>$historiaVida->id_identidad_genero
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Identidad de género (cómo se identifica):'])

</div>
<div class="clearfix"></div>
<!-- Pertenencia Etnico Racial Field -->
<div class="form-group col-sm-4">
    @include('controles.catalogo', ['control_control' => 'id_pertenencia_etnico_racial'
                                           ,'control_id_cat'=>27
                                           , 'control_default'=>$historiaVida->id_pertenencia_etnico_racial
                                           , 'control_multiple' => false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Pertenencia étnico-racial:'])
</div>

<!-- Id Sector Field -->
<div class="form-group col-sm-4">
    @include('controles.catalogo', ['control_control' => 'id_sector'
                                            ,'control_id_cat'=>18
                                            , 'control_default'=>$historiaVida->id_sector
                                            , 'control_multiple'=>false
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Sector al que pertenece:'])
</div>
<div class="clearfix"></div>
<div class="col-sm-12">
    <fieldset id="buildyourform">
        <legend>Temas de la entrevista</legend>
        @foreach($historiaVida->rel_tema as $tema)
            <div class="form-group col-sm-12">
                {!! Form::label('tema[]', 'Tema:') !!}
                {!! Form::text('tema[]', $tema->tema, ['class' => 'form-control']) !!}
            </div>
        @endforeach
        <div id="tema_html">
            <div class="form-group col-sm-12">
                {!! Form::label('tema[]', 'Tema:') !!}
                {!! Form::text('tema[]', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div id="mas_temas">
        </div>
    </fieldset>
    <button class="btn btn-info btn-xs pull-right"  type="button" onclick="agregar()">Agregar mas temas</button>

</div>




{{-- titulo --}}
<div class="form-group col-sm-12">
    {!! Form::label('titulo', 'Título: ') !!}
    <p class="text-primary"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Describa la entrevista con un texto que le facilite ubicarla posteriormente.</p>
    {!! Form::text('titulo', null, ['class' => 'form-control','required'=>'required' ]) !!}
</div>

{{-- dinamicas --}}
<div class="form-group col-sm-12">
    {!! Form::label('dinamica', 'Señale hasta 3 dinámicas que le hayan llamado la atención a partir de lo narrado en la entrevista: ') !!}
    <p class="text-primary"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Por favor ingrese en este espacio, posibles temas, preguntas, o  tendencias clave que haya identificado durante la entrevista y que  ayuden a documentar los diferentes mandatos.</p>
    {!! Form::text('dinamica[]', $historiaVida->arreglo_dinamica[0], ['class' => 'form-control','required'=>'required' ]) !!}
    <br>
    {!! Form::text('dinamica[]', $historiaVida->arreglo_dinamica[1], ['class' => 'form-control' ]) !!}
    <br>
    {!! Form::text('dinamica[]', $historiaVida->arreglo_dinamica[2], ['class' => 'form-control' ]) !!}

</div>

{{-- Intereses --}}
<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'interes'
                                            ,'control_id_cat'=>19
                                            , 'control_default'=>$historiaVida->arreglo_interes
                                            , 'control_multiple'=>true
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Puede ser de interés para los siguientes núcleos temáticos :'])
</div>




<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'mandato'
                                            ,'control_id_cat'=>15
                                            , 'control_default'=>$historiaVida->arreglo_mandato
                                            , 'control_multiple'=>true
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Coincide con los siguientes puntos del mandato:'])
</div>


<div class="clearfix"></div>
<!-- Observaciones Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    {!! Form::textarea('observaciones', null, ['class' => 'form-control','rows'=>3]) !!}
</div>

@include("partials.clasificacion_r1",['nna'=>$historiaVida->clasificacion_nna, 'res'=>$historiaVida->clasificacion_res, 'sex'=>$historiaVida->clasificacion_sex, 'r1'=>$historiaVida->clasificacion_r1, 'r2'=>$historiaVida->clasificacion_r2 ])





<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('entrevistaProfundidads.index') !!}" class="btn btn-default">Cancelar</a>
</div>


@push("js")
    <script>
        function agregar() {
            var html = $("#tema_html").html();
            $("#mas_temas").append(html);
        }
    </script>
@endpush


@push("js")
    <script>
        //Validaciones
        $("#frm_abc").submit( function(event) {
            var entrevsita_del = $("#entrevista_fecha_inicio").pickadate('picker');
            var entrevsita_al = $("#entrevista_fecha_final").pickadate('picker');
            if(entrevsita_al !== null) {
                if(entrevsita_al.get('select').pick < entrevsita_del.get('select').pick ) {
                    event.preventDefault();
                    Swal.fire({
                        type: 'error',
                        title: 'Fecha de finalización de la entrevista incorrecto',
                        //text: 'El valor ingresado en el período de tiempo cubierto por la entrevista es incorrecto',
                        footer: '<a href>Revise la fecha final, es menor que el inicial.</a>'
                    });
                }
            }
        });
    </script>
@endpush
