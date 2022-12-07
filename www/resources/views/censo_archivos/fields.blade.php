{!! Form::hidden('id_entrevistador', $censoArchivos->id_entrevistador) !!}


<div class="box box-primary box-solid">
    <div class="box-header">
        <h3 class="box-title">
            Descripción del archivo
        </h3>
    </div>
    <div class="box-body">
        <div class="form-group col-sm-3">
            @include('controles.catalogo', ['control_control' => 'id_tipo'
                                                  ,'control_id_cat'=>355
                                                  , 'control_default'=>$censoArchivos->id_tipo
                                                  , 'control_multiple'=>false
                                                  , 'control_requerido' => true
                                                  ,'control_texto'=>'Tipo de archivo:'])

        </div>
        <div class="form-group col-sm-3">
            @include('controles.catalogo', ['control_control' => 'id_nivel_organizacion'
                                                  ,'control_id_cat'=>356
                                                  , 'control_default'=>$censoArchivos->id_nivel_organizacion
                                                  , 'control_multiple'=>false
                                                  , 'control_requerido' => true
                                                  ,'control_texto'=>'Nivel de organización:'])

        </div>
        <div class=" col-sm-6">
            <div class="col-sm-6">
                @include('controles.numero', ['control_control' => 'anio_del'
                                                           , 'control_default'=>$censoArchivos->anio_del
                                                           ,'control_resaltar' => false
                                                           ,'control_requerido' => true
                                                           , 'control_min' =>1800
                                                           , 'control_max' =>2020
                                                           ,'control_texto'=>'Información desde el año:'])

            </div>
            <div class="col-sm-6">
                @include('controles.numero', ['control_control' => 'anio_al'
                                                                           , 'control_default'=>$censoArchivos->anio_al
                                                                           ,'control_resaltar' => false
                                                                           ,'control_requerido' => true
                                                                           , 'control_min' =>1800
                                                                           , 'control_max' =>2020
                                                                           ,'control_texto'=>'Información hasta el año:'])
            </div>
        </div>
        <div class="clearfix"></div>
        <div class=" col-sm-6">
            <div class="form-group">
                {!! Form::label('perfil_productor', 'Perfil del productor:') !!}
                {!! Form::textarea('perfil_productor', null, ['class' => 'form-control', 'rows'=>3]) !!}
            </div>
        </div>
        <div class=" col-sm-6">
            <div class="form-group">
                {!! Form::label('sintesis', 'Breve síntesis / reseña del archivo:') !!}
                {!! Form::textarea('sintesis', null, ['class' => 'form-control', 'rows'=>3]) !!}
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-sm-5">
            <div class="form-group">
                {!! Form::label('direccion', 'Dirección donde se encuentra el archivo:') !!}
                {!! Form::textarea('direccion', null, ['class' => 'form-control','rows'=>3, 'required'=>'required']) !!}
            </div>
        </div>

        <div class="col-sm-7">
                    @include('controles.geo3', ['control_control' => 'id_geo'
                                               ,'control_texto' => 'Ubicación:'
                                               , 'control_default'=>$censoArchivos->id_geo])
        </div>

        <div class="col-xs-12">
            <h3 class="text-primary">Herramientas archivísticas</h3>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('cobertura_geografica', 'Cobertura geográfica. Describa el lugar o territorio al que hace referencia:') !!}
                {!! Form::textarea('cobertura_geografica', null, ['class' => 'form-control','rows'=>3]) !!}
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('indice', 'Si existiera, especificar índice del contenido:') !!}
                {!! Form::textarea('indice', null, ['class' => 'form-control','rows'=>3, 'required'=>'required']) !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('contenido_tematico', 'Breve descripción del contenido temático:') !!}
                {!! Form::textarea('contenido_tematico', null, ['class' => 'form-control','rows'=>3, 'required'=>'required']) !!}
            </div>
        </div>
        <div class="col-sm-12">
            @include('controles.catalogo', ['control_control' => 'id_opcion'
                                                ,'control_id' => 'id_opcion_18'
                                                ,'control_id_cat'=>18
                                                , 'control_default'=>$censoArchivos->elegidos(18)
                                                , 'control_multiple'=>true
                                                , 'control_requerido' => false
                                                ,'control_texto'=>'Sectores asociados al archivo:'])
        </div>
        <div class="col-sm-12">
            @include('controles.catalogo', ['control_control' => 'id_opcion'
                                                ,'control_id' => 'id_opcion_280'
                                                ,'control_id_cat'=>280
                                                , 'control_default'=>$censoArchivos->elegidos(280)
                                                , 'control_multiple'=>true
                                                , 'control_requerido' => false
                                                ,'control_texto'=>'Patrones referidos dentro del archivo (si aplica):'])
        </div>




        <div class="col-xs-12">
            <h3 class="text-primary">Composición</h3>
        </div>

        <!-- Archivo Fisico Field -->
        <div class="form-group col-sm-3">
            @include('controles.criterio_fijo', ['control_control' => 'archivo_fisico'
                                                   ,'control_default' => $censoArchivos->archivo_fisico
                                                   ,'control_grupo' => 2
                                                   ,'control_texto'=>"Archivo físico:"])
        </div>

        <!-- Archivo Fisico Volumen Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('archivo_fisico_volumen', 'Volúmen del archivo físico:') !!}
            {!! Form::text('archivo_fisico_volumen', null, ['class' => 'form-control', 'maxlength'=>200]) !!}
        </div>

        <!-- Archivo Fisico Ubicacion Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('archivo_fisico_ubicacion', 'Ubicación del archivo físico:') !!}
            {!! Form::text('archivo_fisico_ubicacion', null, ['class' => 'form-control', 'rows'=>3]) !!}
        </div>

        <div class="clearfix"></div>
        <!-- Archivo Electronico Field -->
        <div class="form-group col-sm-3">
            @include('controles.criterio_fijo', ['control_control' => 'archivo_electronico'
                                                   ,'control_default' => $censoArchivos->archivo_electronico
                                                   ,'control_grupo' => 2
                                                   ,'control_texto'=>"Archivo electrónico:"])
        </div>

        <!-- Archivo Electronico Volumen Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('archivo_electronico_volumen', 'Volúmen del archivo electrónico:') !!}
            {!! Form::text('archivo_electronico_volumen', null, ['class' => 'form-control', 'maxlength'=>200]) !!}
        </div>

        <!-- Archivo Electronico Ubicacion Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('archivo_electronico_ubicacion', 'Ubicación del archivo electrónico:') !!}
            {!! Form::text('archivo_electronico_ubicacion', null, ['class' => 'form-control', 'rows'=>3]) !!}
        </div>

        <div class="clearfix"></div>
        <!-- Archivo Virtual Field -->
        <div class="form-group col-sm-3">
            @include('controles.criterio_fijo', ['control_control' => 'archivo_virtual'
                                                   ,'control_default' => $censoArchivos->archivo_virtual
                                                   ,'control_grupo' => 2
                                                   ,'control_texto'=>"Archivo virtual:"])
        </div>

        <div class="form-group col-sm-3">
            {!! Form::label('archivo_virtual_volumen', 'Volúmen del archivo virtual:') !!}
            {!! Form::text('archivo_virtual_volumen', null, ['class' => 'form-control', 'maxlength'=>200]) !!}
        </div>

        <!-- Archivo Electronico Ubicacion Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('archivo_virtual_ubicacion', 'Ubicación del archivo virtual:') !!}
            {!! Form::text('archivo_virtual_ubicacion', null, ['class' => 'form-control', 'rows'=>3]) !!}
        </div>
        <div class="clearfix"></div>
    </div>
</div>

{{-- nivel de acceso --}}
<div class="box box-info box-solid">
    <div class="box-header">
        <h3 class="box-title">
            Nivel de acceso
        </h3>
    </div>
    <div class="box-body">

        {{-- consultado por --}}
        <div class="col-sm-12">
            @include('controles.catalogo', ['control_control' => 'id_opcion'
                                                ,'control_id' => 'id_opcion_1'
                                                ,'control_id_cat'=>351
                                                , 'control_default'=>$censoArchivos->elegidos(351)
                                                , 'control_multiple'=>true
                                                , 'control_requerido' => false
                                                ,'control_texto'=>'Consultado por'])
        </div>

        <!-- Acceso Publico Field -->
        <div class="form-group col-sm-3">
            @include('controles.catalogo', ['control_control' => 'acceso_publico'
                                                  ,'control_id_cat'=>350
                                                  , 'control_default'=>$censoArchivos->acceso_publico
                                                  , 'control_multiple'=>false
                                                  , 'control_requerido' => true
                                                  ,'control_texto'=>'Acceso público:'])
        </div>

        <!-- Acceso Publico Volumen Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('acceso_publico_volumen', 'Volúmen:') !!}
            {!! Form::number('acceso_publico_volumen', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Acceso Publico Descripcion Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('acceso_publico_descripcion', 'Descripción (unidad de medida):') !!}
            {!! Form::text('acceso_publico_descripcion', null, ['class' => 'form-control','rows'=>3]) !!}
        </div>

        <div class="clearfix"></div>
        <!-- Acceso Clasificado Field -->
        <div class="form-group col-sm-3">
            @include('controles.catalogo', ['control_control' => 'acceso_clasificado'
                                                 ,'control_id_cat'=>350
                                                 , 'control_default'=>$censoArchivos->acceso_clasificado
                                                 , 'control_multiple'=>false
                                                 , 'control_requerido' => true
                                                 ,'control_texto'=>'Acceso clasificado:'])
        </div>

        <!-- Acceso Clasificado Volumen Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('acceso_clasificado_volumen', 'Volúmen:') !!}
            {!! Form::number('acceso_clasificado_volumen', null, ['class' => 'form-control','maxlength'=>200]) !!}
        </div>

        <!-- Acceso Clasificado Descripcion Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('acceso_clasificado_descripcion', 'Descripción (unidad de medida):') !!}
            {!! Form::text('acceso_clasificado_descripcion', null, ['class' => 'form-control','rows'=>3]) !!}
        </div>

        <div class="clearfix"></div>
        <!-- Acceso Reservado Field -->
        <div class="form-group col-sm-3">
            @include('controles.catalogo', ['control_control' => 'acceso_reservado'
                                                 ,'control_id_cat'=>350
                                                 , 'control_default'=>$censoArchivos->acceso_reservado
                                                 , 'control_multiple'=>false
                                                 , 'control_requerido' => true
                                                 ,'control_texto'=>'Acceso reservado:'])

        </div>

        <!-- Acceso Reservado Volumen Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('acceso_reservado_volumen', 'Volúmen:') !!}
            {!! Form::number('acceso_reservado_volumen', null, ['class' => 'form-control','maxlength'=>200]) !!}
        </div>

        <!-- Acceso Reservado Descripcion Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('acceso_reservado_descripcion', 'Descripción (unidad de medida):') !!}
            {!! Form::text('acceso_reservado_descripcion', null, ['class' => 'form-control','rows'=>3]) !!}
        </div>
    </div>
</div>




{{-- RIESGOS --}}
<div class="box box-warning box-solid">
    <div class="box-header">
        <h3 class="box-title">
            Riesgos
        </h3>
    </div>
    <div class="box-body">

        <div class="col-sm-6">
            @include('controles.catalogo', ['control_control' => 'id_opcion'
                                                ,'control_id' => 'id_opcion_2'
                                                ,'control_id_cat'=>352
                                                , 'control_default'=>$censoArchivos->elegidos(352)
                                                , 'control_multiple'=>true
                                                , 'control_requerido' => false
                                                ,'control_texto'=>'Riesgo sociopolítico:'])
        </div>
        <div class="col-sm-6">
            @include('controles.catalogo', ['control_control' => 'id_opcion'
                                                ,'control_id' => 'id_opcion_3'
                                                ,'control_id_cat'=>353
                                                , 'control_default'=>$censoArchivos->elegidos(353)
                                                , 'control_multiple'=>true
                                                , 'control_requerido' => false
                                                ,'control_texto'=>'Riesgo ambiental:'])
        </div>

    </div>
</div>

{{-- CUSTODIO --}}
@if($censoArchivos->privilegios==1)
<div class="box box-info box-solid">
    <div class="box-header">
        <h3 class="box-title">
            Información del custodio
        </h3>
    </div>
    <div class="box-body">
        <div class="form-group col-sm-12">
            {!! Form::label('custodio', 'Nombre del custodio:') !!}
            {!! Form::textarea('custodio', null, ['class' => 'form-control','rows'=>3, 'required'=>'required']) !!}
        </div>


        <div class="form-group col-sm-6">
            {!! Form::label('contacto_nombre', 'Nombre de persona de contacto:') !!}
            {!! Form::text('contacto_nombre', null, ['class' => 'form-control', 'maxlength'=>200,  'required'=>'required']) !!}
        </div>


        <div class="form-group col-sm-6">
            {!! Form::label('contacto_correo', 'Correo electrónico:') !!}
            {!! Form::text('contacto_correo', null, ['class' => 'form-control', 'maxlength'=>200]) !!}
        </div>

        <!-- Contacto Telefono Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('contacto_telefono', 'Teléfono:') !!}
            {!! Form::text('contacto_telefono', null, ['class' => 'form-control', 'maxlength'=>200]) !!}
        </div>

        <!-- Contacto Url Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('contacto_url', 'Dirección web (URL):') !!}
            {!! Form::text('contacto_url', null, ['class' => 'form-control', 'maxlength'=>200]) !!}
        </div>

        <div class="col-sm-6">
            @include('controles.radio_si_no', ['control_control' => 'consentimiento_repositorio'
                                                    ,'control_default' => $censoArchivos->consentimiento_repositorio
                                                    ,'control_texto'=>"¿Está de acuerdo en la publicación de este repositorio a lo interno de La Comisión?"])
        </div>
        <div class="col-sm-6">
            @include('controles.radio_si_no', ['control_control' => 'consentimiento_publicar'
                                                    ,'control_default' => $censoArchivos->consentimiento_publicar
                                                    ,'control_texto'=>"¿Está de acuerdo en el traslado de la presente publicación hacia terceros?"])
        </div>



    </div>
</div>
@endif
{{-- diligenciamiento --}}
@if($censoArchivos->privilegios==1)
<div class="box box-info box-solid">
    <div class="box-header">
        <h3 class="box-title">
            Información del diligenciamiento de esta ficha
        </h3>
    </div>
    <div class="box-body">
        <!-- Ficha Diligenciada Nombre Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('ficha_diligenciada_nombre', 'Nombre de quien diligencia la información:') !!}
            {!! Form::text('ficha_diligenciada_nombre', null, ['class' => 'form-control','maxlength'=>200, 'required'=>'required']) !!}
        </div>

        <!-- Ficha Diligenciada Telefono Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('ficha_diligenciada_telefono', 'Teléfono:') !!}
            {!! Form::text('ficha_diligenciada_telefono', null, ['class' => 'form-control','maxlength'=>200]) !!}
        </div>

        <!-- Ficha Diligenciada Correo Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('ficha_diligenciada_correo', 'Correo electrónico:') !!}
            {!! Form::text('ficha_diligenciada_correo', null, ['class' => 'form-control','maxlength'=>200]) !!}
        </div>
        <div class="clearfix"></div>
        {{--  Macroterritorio --}}
        <div class="form-group col-sm-8">
            @include('controles.cev2', ['control_control' => 'id_territorio'
                                                        , 'control_territorio'=>$censoArchivos->id_territorio])
        </div>
        <!-- Anotaciones Field -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('anotaciones', 'Anotaciones:') !!}
            {!! Form::textarea('anotaciones', null, ['class' => 'form-control','rows'=>3]) !!}
        </div>
    </div>
</div>
@endif

<!-- Submit Field -->

<div class="form-group col-sm-12">
    {!! Form::submit('Grabar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('censoArchivos.index') }}" class="btn btn-default">Cancelar</a>
</div>


@push("js")
    <script>
        function agregar() {
            var html = $("#tema_html").html();
            $("#mas_temas").append(html);
        }

    </script>
@endpush
