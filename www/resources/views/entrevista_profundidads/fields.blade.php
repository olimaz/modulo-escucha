{!! Form::hidden('id_entrevistador', $entrevistaProfundidad->id_entrevistador) !!}

<!-- Correlativo de la entrevista -->

<div class="form-group col-sm-2">
    {!! Form::label('entrevista_numero', 'Código: '.$entrevistaProfundidad->prefijo_codigo()) !!}
    {!! Form::number('entrevista_numero', null, ['class' => 'form-control','required'=>'required','maxlength'=>5, 'title'=>'Se sugiere utilizar este número, pero puede modificarlo si fuera el caso','data-toggle'=>"tooltip" ]) !!}
</div>

<div class="form-group col-sm-4">
    @include('controles.criterio_fijo', ['control_control' => 'id_tipo'
                                           ,'control_default' => $entrevistaProfundidad->id_tipo
                                           ,'control_grupo' => 15
                                           //,'control_vacio' => '[Ninguno]'
                                           ,'control_texto'=>'Tipo de entrevista:'])
</div>


<!-- Macroterritorio -->
<div class="form-group col-sm-6">
    @include('controles.cev2', ['control_control' => 'id_territorio'
                                                , 'control_territorio'=>$entrevistaProfundidad->id_territorio])
</div>
<div class="clearfix"></div>

<!-- Fecha de la entrevista -->
<div class="form-group col-sm-3">
    @include('controles.fecha', ['control_control' => 'entrevista_fecha_inicio'
                                ,'control_texto' => 'Fecha de inicio la entrevista'
                                , 'control_default'=>$entrevistaProfundidad->entrevista_fecha_inicio])
</div>
<div class="form-group col-sm-3">
    @include('controles.fecha', ['control_control' => 'entrevista_fecha_final'
                                ,'control_texto' => 'Fecha de finalización de la entrevista'
                                , 'control_default'=>$entrevistaProfundidad->entrevista_fecha_final])
</div>
<div class="form-group col-sm-3">
    @include('controles.catalogo', ['control_control' => 'entrevista_avance'
                                           ,'control_id_cat'=>20
                                           , 'control_default'=>$entrevistaProfundidad->entrevista_avance
                                           , 'control_multiple'=>false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Situación actual de la entrevista:'])
</div>
<div class="form-group col-sm-3">
    {!! Form::label('tiempo_entrevista', 'Duración total de la entrevista: ') !!}
    {!! Form::number('tiempo_entrevista', null, ['class' => 'form-control','required'=>'required','maxlength'=>5,'data-toggle'=>"tooltip" ,'title'=>'Indicar un aproximado de la duración total (en minutos) de los audios  de la entrevista','min'=>0,'max'=>2400,'step'=>1, 'placeholder'=>'En minutos']) !!}

</div>


<!-- Entrevista Lugar Field -->
<div class="form-group col-sm-9">
    @include('controles.geo3', ['control_control' => 'entrevista_lugar'
                                ,'control_texto' => 'Lugar de la entrevista <span class=text-muted>(Si es por medios virtuales, indicar la ubicación de la persona entrevistada)</span>'
                                , 'control_default'=>$entrevistaProfundidad->entrevista_lugar])
</div>
{{--  entrevista virtual --}}
<div class="form-group col-sm-3">
    @include('controles.radio_si_no', ['control_control' => 'es_virtual'
                                        ,'control_default' => $entrevistaProfundidad->es_virtual
                                        ,'control_texto'=>'Esta entrevista se realizó por medios virtuales'])
</div>
<div class="clearfix"></div>

<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('entrevista_objetivo', 'Objetivo de la entrevista:') !!}
    {!! Form::textarea('entrevista_objetivo', null, ['class' => 'form-control','rows'=>3,'required'=>'required']) !!}
</div>

{{-- Entrevistado --}}
<div class="form-group col-sm-4">
    {!! Form::label('entrevistado_nombres', 'Nombre de la persona entrevistada: ') !!}
    {!! Form::text('entrevistado_nombres', null, ['class' => 'form-control','maxlength'=>100 ]) !!}
</div>
<div class="form-group col-sm-4">
    {!! Form::label('entrevistado_apellidos', 'Nombre identitario / otros nombres de la persona entrevistada: ') !!}
    {!! Form::text('entrevistado_apellidos', null, ['class' => 'form-control','maxlength'=>100 ]) !!}
</div>

<!-- Id Sector Field -->
<div class="form-group col-sm-4">
    @include('controles.catalogo', ['control_control' => 'id_sector'
                                            ,'control_id_cat'=>18
                                            , 'control_default'=>$entrevistaProfundidad->id_sector
                                            , 'control_multiple'=>false
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Sector al que pertenece:'])
</div>
<div class="clearfix"></div>
{{-- Nuevos metadatos --}}
<div class="form-group col-sm-4">
    @include('controles.radio_si_no_div', ['control_control' => 'id_policia_parte'
                                            , 'control_default'=>$entrevistaProfundidad->id_policia_parte
                                            , 'control_multiple'=>false
                                            , 'control_requerido' => true
                                            , 'control_div' => 'div_policia'
                                            ,'control_texto'=>'Hizo parte de la Policía:'])
</div>
<div class="form-group col-sm-8" id="div_policia">
    @include('controles.catalogo', ['control_control' => 'id_policia_rango'
                                               ,'control_id_cat'=>230
                                               , 'control_default'=>$entrevistaProfundidad->id_policia_rango
                                               , 'control_multiple'=>false
                                               , 'control_requerido' => false
                                               , 'control_vacio' => '[No aplica, No sabe, No responde]'
                                               , 'control_otro' => 'Otro, ¿Cuál?'
                                               ,'control_texto'=>'Rango/Grado que alcanzó:'])
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-4">
    @include('controles.radio_si_no_div', ['control_control' => 'id_paramilitar_parte'
                                            , 'control_default'=>$entrevistaProfundidad->id_paramilitar_parte
                                            , 'control_multiple'=>false
                                            , 'control_requerido' => true
                                            , 'control_div' => 'div_paramilitar'
                                            ,'control_texto'=>'Hizo parte de algún grupo paramilitar:'])
</div>
<div class="form-group col-sm-8" id="div_paramilitar">
    @include('controles.catalogo', ['control_control' => 'id_paramilitar_rango'
                                               ,'control_id_cat'=>231
                                               , 'control_default'=>$entrevistaProfundidad->id_paramilitar_rango
                                               , 'control_multiple'=>false
                                               , 'control_requerido' => false
                                               , 'control_vacio' => '[No aplica, No sabe, No responde]'
                                               , 'control_otro' => 'Otro, ¿Cuál?'
                                               ,'control_texto'=>'Rango/Grado que alcanzó:'])
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-4">
    @include('controles.radio_si_no_div', ['control_control' => 'id_guerrilla_parte'
                                            , 'control_default'=>$entrevistaProfundidad->id_guerrilla_parte
                                            , 'control_multiple'=>false
                                            , 'control_requerido' => true
                                            , 'control_div' => 'div_guerrilla'
                                            ,'control_texto'=>'Hizo parte de algún grupo guerrillero:'])
</div>
<div class="form-group col-sm-8" id="div_guerrilla">
    @include('controles.catalogo', ['control_control' => 'id_guerrilla_rango'
                                               ,'control_id_cat'=>232
                                               , 'control_default'=>$entrevistaProfundidad->id_guerrilla_rango
                                               , 'control_multiple'=>false
                                               , 'control_requerido' => false
                                               , 'control_vacio' => '[No aplica, No sabe, No responde]'
                                               , 'control_otro' => 'Otro, ¿Cuál?'
                                               ,'control_texto'=>'Rango/Grado que alcanzó:'])
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-4">
    @include('controles.radio_si_no_div', ['control_control' => 'id_ejercito_parte'
                                            , 'control_default'=>$entrevistaProfundidad->id_ejercito_parte
                                            , 'control_multiple'=>false
                                            , 'control_requerido' => true
                                            , 'control_div' => 'div_ejercito'
                                            ,'control_texto'=>'Hizo parte del ejército:'])
</div>
<div class="form-group col-sm-8" id="div_ejercito">
    @include('controles.catalogo', ['control_control' => 'id_ejercito_rango'
                                               ,'control_id_cat'=>235
                                               , 'control_default'=>$entrevistaProfundidad->id_ejercito_rango
                                               , 'control_multiple'=>false
                                               , 'control_requerido' => false
                                               , 'control_vacio' => '[No aplica, No sabe, No responde]'
                                               , 'control_otro' => 'Otro, ¿Cuál?'
                                               ,'control_texto'=>'Rango/Grado que alcanzó:'])
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-4">
    @include('controles.radio_si_no_div', ['control_control' => 'id_fuerza_aerea_parte'
                                            , 'control_default'=>$entrevistaProfundidad->id_fuerza_aerea_parte
                                            , 'control_multiple'=>false
                                            , 'control_requerido' => true
                                            , 'control_div' => 'div_fuerza_aerea'
                                            ,'control_texto'=>'Hizo parte de la fuerza aérea:'])
</div>
<div class="form-group col-sm-8" id="div_fuerza_aerea">
    @include('controles.catalogo', ['control_control' => 'id_fuerza_aerea_rango'
                                               ,'control_id_cat'=>233
                                               , 'control_default'=>$entrevistaProfundidad->id_fuerza_aerea_rango
                                               , 'control_multiple'=>false
                                               , 'control_requerido' => false
                                               , 'control_vacio' => '[No aplica, No sabe, No responde]'
                                               , 'control_otro' => 'Otro, ¿Cuál?'
                                               ,'control_texto'=>'Rango/Grado que alcanzó:'])
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-4">
    @include('controles.radio_si_no_div', ['control_control' => 'id_fuerza_naval_parte'
                                            , 'control_default'=>$entrevistaProfundidad->id_fuerza_naval_parte
                                            , 'control_multiple'=>false
                                            , 'control_requerido' => true
                                            , 'control_div' => 'div_fuerza_naval'
                                            ,'control_texto'=>'Hizo parte de la fuerza naval:'])
</div>
<div class="form-group col-sm-8" id="div_fuerza_naval">
    @include('controles.catalogo', ['control_control' => 'id_fuerza_naval_rango'
                                               ,'control_id_cat'=>233
                                               , 'control_default'=>$entrevistaProfundidad->id_fuerza_naval_rango
                                               , 'control_multiple'=>false
                                               , 'control_requerido' => false
                                               , 'control_vacio' => '[No aplica, No sabe, No responde]'
                                               , 'control_otro' => 'Otro, ¿Cuál?'
                                               ,'control_texto'=>'Rango/Grado que alcanzó:'])
</div>

<div class="clearfix"></div>
<div class="form-group col-sm-12">
    @include('controles.radio_si_no_cual', ['control_control' => 'id_tercero_civil_parte'
                                            , 'control_default'=>$entrevistaProfundidad->id_tercero_civil_parte
                                            , 'control_control_cual' => 'id_tercero_civil_cual'
                                            , 'control_default_cual' => $entrevistaProfundidad->id_tercero_civil_cual
                                            , 'control_requerido' => false
                                            ,'control_texto'=>'Hizo parte de algún tercero civil:'])
</div>
<div class="form-group col-sm-12">
    @include('controles.radio_si_no_cual', ['control_control' => 'id_agente_estado_parte'
                                            , 'control_default'=>$entrevistaProfundidad->id_agente_estado_parte
                                            , 'control_control_cual' => 'id_agente_estado_cual'
                                            , 'control_default_cual' => $entrevistaProfundidad->id_agente_estado_cual
                                            , 'control_requerido' => false
                                            ,'control_texto'=>'Hizo parte de algún agente del estado (no armado):'])
</div>

<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_violencia_victima'
                                                ,'control_id_cat'=>5
                                                , 'control_default'=>$entrevistaProfundidad->arreglo_violencia_victima
                                                , 'control_multiple'=>true
                                                , 'control_requerido' => false
                                                , 'control_vacio' => '[No aplica, No sabe, No responde]'
                                                ,'control_texto'=>'Hechos víctimizantes mencionados por la víctima, familiar, testigo o experto:'])
</div>
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_violencia_actor'
                                                ,'control_id_cat'=>5
                                                , 'control_default'=>$entrevistaProfundidad->arreglo_violencia_actor
                                                , 'control_multiple'=>true
                                                , 'control_requerido' => false
                                                , 'control_vacio' => '[No aplica, No sabe, No responde]'
                                                ,'control_texto'=>'Hechos víctimizantes reconocidos por el actor:'])
</div>




<div class="col-sm-12">
    <fieldset id="buildyourform">
        <legend>Temas de la entrevista</legend>
        @foreach($entrevistaProfundidad->rel_tema as $tema)
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
    <button class="btn btn-info btn-xs pull-right"  type="button" onclick="agregar()">Agregar más temas</button>

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
    {!! Form::text('dinamica[]', $entrevistaProfundidad->arreglo_dinamica[0], ['class' => 'form-control','required'=>'required' ]) !!}
    <br>
    {!! Form::text('dinamica[]', $entrevistaProfundidad->arreglo_dinamica[1], ['class' => 'form-control' ]) !!}
    <br>
    {!! Form::text('dinamica[]', $entrevistaProfundidad->arreglo_dinamica[2], ['class' => 'form-control' ]) !!}

</div>

{{-- Intereses --}}
<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'interes'
                                            ,'control_id_cat'=>19
                                            , 'control_default'=>$entrevistaProfundidad->arreglo_interes
                                            , 'control_multiple'=>true
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Puede ser de interés para los siguientes núcleos temáticos :'])
</div>


<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'mandato'
                                            ,'control_id_cat'=>15
                                            , 'control_default'=>$entrevistaProfundidad->arreglo_mandato
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

@include("partials.clasificacion_r1",['nna'=>$entrevistaProfundidad->clasificacion_nna, 'res'=>$entrevistaProfundidad->clasificacion_res, 'sex'=>$entrevistaProfundidad->clasificacion_sex, 'r1'=>$entrevistaProfundidad->clasificacion_r1, 'r2'=>$entrevistaProfundidad->clasificacion_r2 ])




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
            var nombre = $("#entrevistado_nombres").val().trim();
            var otro_nombre = $("#entrevistado_apellidos").val().trim();


            if(nombre.length == 0 && otro_nombre.length==0) {
                event.preventDefault();
                Swal.fire({
                    type: 'error',
                    title: 'Nombre en blanco',
                    text: 'El valor ingresado en el nombre del entrevistado es incorrecto',
                    footer: '<a href>Debe especificar el nombre real o el nombre identitario dle entrevistado</a>'
                })
            }

            var tema_del = $("#entrevista_fecha_inicio").pickadate('picker');
            var tema_al = $("#entrevista_fecha_final").pickadate('picker');
            if(tema_al !== null) {
                if(tema_al.get('select').pick < tema_del.get('select').pick ) {
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
