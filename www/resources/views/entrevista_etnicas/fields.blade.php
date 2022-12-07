{!! Form::hidden('id_entrevistador', $entrevistaEtnica->id_entrevistador) !!}
{!! Form::hidden('id_subserie', $entrevistaEtnica->id_subserie) !!}

<!-- Correlativo de la entrevista -->
<div class="form-group col-sm-2">
    {!! Form::label('entrevista_numero', 'Entrevista Código: '.$entrevistaEtnica->prefijo_codigo()) !!}
    {!! Form::number('entrevista_numero', null, ['class' => 'form-control','required'=>'required','maxlength'=>5, 'title'=>'Se sugiere utilizar este número, pero puede modificarlo si fuera el caso','data-toggle'=>"tooltip" ]) !!}
</div>

<div class="form-group col-sm-2">
    {!! Form::label('tiempo_entrevista', 'Duración de la entrevista: ') !!}
    {!! Form::number('tiempo_entrevista', null, ['class' => 'form-control','required'=>'required','maxlength'=>5,'data-toggle'=>"tooltip" ,'title'=>'Indicar un aproximado de la duración total (en minutos) de los audios  de la entrevista','min'=>0,'max'=>2400,'step'=>1, 'placeholder'=>'En minutos']) !!}
</div>



<!-- Macroterritorio -->
<div class="form-group col-sm-8">
    @include('controles.cev2', ['control_control' => 'id_territorio'
                                                , 'control_territorio'=>$entrevistaEtnica->id_territorio])
</div>
<div class="clearfix"></div>

<!-- Fecha de la entrevista -->
<div class="form-group col-sm-4">

    @include('controles.fecha', ['control_control' => 'entrevista_fecha_inicio'
                                , 'control_requerido' => true
                                ,'control_texto' => 'Fecha de inicio la entrevista'
                                , 'control_default'=>$entrevistaEtnica->entrevista_fecha_inicio])
</div>
<div class="form-group col-sm-4">
    @include('controles.fecha', ['control_control' => 'entrevista_fecha_final'
                                ,'control_texto' => 'Fecha de finalización de la entrevista'
                                , 'control_default'=>$entrevistaEtnica->entrevista_fecha_final])
</div>
<div class="form-group col-sm-4">
    @include('controles.catalogo', ['control_control' => 'entrevista_avance'
                                           ,'control_id_cat'=>20
                                           , 'control_default'=>$entrevistaEtnica->entrevista_avance
                                           , 'control_multiple'=>false
                                           , 'control_requerido' => true
                                           ,'control_texto'=>'Situación actual de la entrevista:'])
</div>


<!-- Entrevista Lugar Field -->
<div class="form-group col-sm-9">
    @include('controles.geo3', ['control_control' => 'entrevista_lugar'
                                ,'control_texto' => 'Lugar de la entrevista <span class=text-muted>(Si es por medios virtuales, indicar la ubicación de la persona entrevistada)</span>'
                                , 'control_default'=>$entrevistaEtnica->entrevista_lugar])
</div>
{{--  entrevista virtual --}}
<div class="form-group col-sm-3">
    @include('controles.radio_si_no', ['control_control' => 'es_virtual'
                                        ,'control_default' => $entrevistaEtnica->es_virtual
                                        ,'control_texto'=>'Esta entrevista se realizó por medios virtuales'])
</div>
<div class="clearfix"></div>


<!-- Equipo Facilitador Field -->
<div class="col-sm-12">
    <h4>Miembros del equipo que realizan la entrevista</h4>
</div>

<div class="form-group col-sm-4">
    {!! Form::label('equipo_facilitador', ' Facilitador:') !!}
    {!! Form::text('equipo_facilitador', null, ['class' => 'form-control','required'=>'required','maxlength'=>100]) !!}
</div>

<!-- Equipo Memorista Field -->
<div class="form-group col-sm-4">
    {!! Form::label('equipo_memorista', 'Memorista:') !!}
    {!! Form::text('equipo_memorista', null, ['class' => 'form-control','required'=>'required','maxlength'=>100]) !!}
</div>
<div class="form-group col-sm-4">
    {!! Form::label('equipo_otros', 'Otros:') !!}
    {!! Form::text('equipo_otros', null, ['class' => 'form-control','maxlength'=>100]) !!}
</div>

<div class="clearfix"></div>
<!-- Equipo Facilitador Field -->
<div class="col-sm-12">
    <h4>Caracterización de la entrevista</h4>
</div>
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_tipo_entrevista'
                                            ,'control_id_cat'=>90
                                            , 'control_default'=>$entrevistaEtnica->id_tipo_entrevista
                                            , 'control_multiple'=>false
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Tipo de entrevista:'])
</div>
<div class="form-group col-sm-6">
    @include('controles.catalogo', ['control_control' => 'id_tipo_sujeto'
                                            ,'control_id_cat'=>93
                                            , 'control_default'=>$entrevistaEtnica->id_tipo_sujeto
                                            , 'control_multiple'=>false
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Tipo de sujeto colectivo:'])
</div>


<div class="clearfix"></div>

<div class="form-group col-sm-4">
    @include('controles.catalogo', ['control_control' => 'indigena'
                                            ,'control_id_cat'=>28
                                            , 'control_default'=>$entrevistaEtnica->arreglo_indigena
                                            , 'control_multiple'=>true
                                            , 'control_vacio' => '[Ninguno / No aplica]'
                                            ,'control_texto'=>'Pueblos indígenas participantes:'])
</div>
<div class="form-group col-sm-4">
    @include('controles.catalogo', ['control_control' => 'narp'
                                            ,'control_id_cat'=>91
                                            , 'control_default'=>$entrevistaEtnica->arreglo_narp
                                            , 'control_multiple'=>true
                                            , 'control_vacio' => '[Ninguno / No aplica]'
                                            ,'control_texto'=>'Pueblos afro participantes:'])
</div>
<div class="form-group col-sm-4">
    @include('controles.catalogo', ['control_control' => 'rrom'
                                            ,'control_id_cat'=>92
                                            , 'control_default'=>$entrevistaEtnica->arreglo_rrom
                                            , 'control_multiple'=>true
                                            , 'control_vacio' => '[Ninguno / No aplica]'
                                            ,'control_texto'=>'Kumpañy participantes:'])
</div>


<div class="clearfix"></div>

<!-- Cantidad Participantes Field -->
<div class="form-group col-sm-4">
    {!! Form::label('cantidad_participantes', 'Cantidad de participantes:') !!}
    {!! Form::number('cantidad_participantes', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Id Sector Field -->
<div class="form-group col-sm-8">
    @include('controles.catalogo', ['control_control' => 'id_sector'
                                            ,'control_id_cat'=>18
                                            , 'control_default'=>$entrevistaEtnica->id_sector
                                            , 'control_multiple'=>false
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Sector al que pertenecen:'])
</div>
<div class="clearfix"></div>

<!-- Tema Descripcion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('tema_descripcion', 'Tema de la entrevista (¿de qué hablaron?):') !!}
    {!! Form::textarea('tema_descripcion', null, ['class' => 'form-control','rows'=>3,'required'=>'required']) !!}
</div>

<!-- Tema Objetivo Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('tema_objetivo', 'Objetivo de la entrevista (¿para qué hablaron del tema?):') !!}
    {!! Form::textarea('tema_objetivo', null, ['class' => 'form-control','rows'=>3,'required'=>'required']) !!}
</div>


<!-- Tema rango de fechas-->
<div class="form-group col-sm-4">
    <label>Período de tiempo que cubre la entrevista</label>
    <div class="form-group col-sm-6">
        {!! Form::label('tema_anio_del', 'Año inicial:') !!}
        {!! Form::number('tema_anio_del', null, ['class' => 'form-control','required'=>'required']) !!}
    </div>
    <div class="form-group  col-sm-6">
        {!! Form::label('tema_anio_al', 'Año final:') !!}
        {!! Form::number('tema_anio_al', null, ['class' => 'form-control','required'=>'required']) !!}
    </div>

</div>

<!-- Tema Lugar Field -->
<div class="form-group col-sm-8">
    @include('controles.geo3', ['control_control' => 'tema_lugar'
                               ,'control_texto' => 'Ubicacion geográfica de los eventos la entrevista'
                               , 'control_default'=>$entrevistaEtnica->tema_lugar])
</div>

<div class="clearfix"></div>
<!-- Eventos Descripcion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('eventos_descripcion', 'Descripción de los eventos:') !!}
    {!! Form::textarea('eventos_descripcion', null, ['class' => 'form-control','rows'=>3,'required'=>'required']) !!}
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
    {!! Form::text('dinamica[]', $entrevistaEtnica->arreglo_dinamica[0], ['class' => 'form-control','required'=>'required' ]) !!}
    <br>
    {!! Form::text('dinamica[]', $entrevistaEtnica->arreglo_dinamica[1], ['class' => 'form-control' ]) !!}
    <br>
    {!! Form::text('dinamica[]', $entrevistaEtnica->arreglo_dinamica[2], ['class' => 'form-control' ]) !!}
</div>

{{-- Intereses --}}
<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'interes'
                                            ,'control_id_cat'=>19
                                            , 'control_default'=>$entrevistaEtnica->arreglo_interes
                                            , 'control_multiple'=>true
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Puede ser de interés para los siguientes núcleos temáticos :'])
</div>


<div class="form-group col-sm-12">
    @include('controles.catalogo', ['control_control' => 'mandato'
                                            ,'control_id_cat'=>15
                                            , 'control_default'=>$entrevistaEtnica->arreglo_mandato
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

@include("partials.clasificacion_r1",['nna'=>$entrevistaEtnica->clasificacion_nna, 'res'=>$entrevistaEtnica->clasificacion_res, 'sex'=>$entrevistaEtnica->clasificacion_sex, 'r1'=>$entrevistaEtnica->clasificacion_r1, 'r2'=>$entrevistaEtnica->clasificacion_r2 ])





@push("js")
    <script>
        //Validaciones
        $("#frm_abc").submit( function(event) {
            var anio_del = parseInt($("#tema_anio_del").val());
            var anio_al = parseInt($("#tema_anio_al").val());
            var d = new Date();
            var n = d.getFullYear();

            if(anio_del < 1492 ) {
                event.preventDefault();
                Swal.fire({
                    type: 'error',
                    title: 'Año inicial incorrecto',
                    text: 'El valor ingresado en el período de tiempo cubierto por la entrevista es incorrecto',
                    footer: '<a href>Debe especificar un valor superior al año 1950</a>'
                })

            }
            if(anio_al > n ) {
                event.preventDefault();
                Swal.fire({
                    type: 'error',
                    title: 'Año final incorrecto',
                    text: 'El valor ingresado en el período de tiempo cubierto por la entrevista es incorrecto',
                    footer: '<a href>No puede especificar años posteriores al actual.</a>'
                })

            }
            if(anio_al < anio_del) {
                event.preventDefault();
                Swal.fire({
                    type: 'error',
                    title: 'Año final incorrecto',
                    text: 'El valor ingresado en el período de tiempo cubierto por la entrevista es incorrecto',
                    footer: '<a href>Revise el año final, es menor que el inicial.</a>'
                });
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
