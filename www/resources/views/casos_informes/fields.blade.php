{!! Form::hidden('id_entrevistador', $casosInformes->id_entrevistador) !!}
{!! Form::hidden('id_subserie', $casosInformes->id_subserie) !!}

<div class="col-xs-12">
    {{-- Acerca del documento --}}
    <div class="box box-solid box-info">
        <div class="box-header">
            Acerca del material recibido
        </div>
        <div class="box-body">
            <!-- Titulo Field -->
            <div class="form-group col-sm-12">
                {!! Form::label('titulo', 'Titulo:') !!}
                {!! Form::text('titulo', null, ['class' => 'form-control','required'=>'required']) !!}
            </div>

            <!-- Autor Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('autor', 'Autor:') !!}
                {!! Form::text('autor', null, ['class' => 'form-control','required'=>'required','maxlength'=>'200']) !!}
            </div>

            <!-- Autor Id Tipo Organizacion  -->
            <div class="form-group col-sm-6">
                @include('controles.catalogo', ['control_control' => 'autor_id_tipo_organizacion'
                                            ,'control_id_cat'=>12
                                            , 'control_default'=>$casosInformes->autor_id_tipo_organizacion
                                            , 'control_multiple' => false
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Tipo de organización - Autor:'])
            </div>

            <!-- Descripcion Field -->
            <div class="form-group col-sm-12 col-lg-12">
                {!! Form::label('descripcion', 'Descripción:') !!}
                {!! Form::textarea('descripcion', null, ['class' => 'form-control','rows'=>3,'required'=>'required']) !!}
            </div>


            <!-- Contenido Texto Field -->
            <div class="form-group col-sm-6 ">
                {!! Form::label('contenido_texto', 'Describir el contenido, si se trata de texto:') !!}
                {!! Form::textarea('contenido_texto', null, ['class' => 'form-control','rows'=>3]) !!}
            </div>

            <!-- Contenido Audiovisual Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('contenido_audiovisual', 'Describir el contenido, si es audiovisual:') !!}
                {!! Form::textarea('contenido_audiovisual', null, ['class' => 'form-control','rows'=>3]) !!}
            </div>

            <!-- Contenido Fotografia Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('contenido_fotografia', 'Describir el contenido, si es fotográfico:') !!}
                {!! Form::textarea('contenido_fotografia', null, ['class' => 'form-control','rows'=>3]) !!}
            </div>

            <!-- Contenido Sonoro Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('contenido_sonoro', 'Describir el contenido, si es sonoro:') !!}
                {!! Form::textarea('contenido_sonoro', null, ['class' => 'form-control','rows'=>3]) !!}
            </div>

            <!-- Contenido Base Datos Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('contenido_base_datos', 'Describir el contenido, si es base de datos:') !!}
                {!! Form::textarea('contenido_base_datos', null, ['class' => 'form-control','rows'=>3]) !!}
            </div>

            <!-- Contenido Otros Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('contenido_otros', 'Describir el contenido, si fuera de otro tipo:') !!}
                {!! Form::textarea('contenido_otros', null, ['class' => 'form-control','rows'=>3]) !!}
            </div>

            <!-- Id Tipo Soporte Field -->

            <div class="form-group col-sm-6">
                @include('controles.catalogo', ['control_control' => 'id_tipo_soporte'
                                           ,'control_id_cat'=>11
                                           , 'control_default'=>$casosInformes->id_tipo_soporte
                                           //, 'control_vacio' => '[Mostrar todos]'
                                           ,'control_texto'=>'Medio en el que se entrega (soporte)'])

            </div>

            <!-- Contenido Volumen Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('contenido_volumen', 'Volumen (cantidad) recibida:') !!}
                {!! Form::text('contenido_volumen', null, ['class' => 'form-control']) !!}
            </div>

        </div>

    </div>

    {{-- Sobre la recepción --}}
    <div class="box box-solid box-default">
        <div class="box-header">
            Acerca de la recepción
        </div>
        <div class="box-body">
            <!-- Entrega Id Geo Field -->
            <div class="form-group col-sm-12">
                @include('controles.geo3', ['control_control' => 'entrega_id_geo'
                                            ,'control_texto' => 'Ubicación donde se recibe:'
                                            , 'control_default'=>$casosInformes->entrega_id_geo])
            </div>
            <!-- Recepcion Fecha Field -->
            <div class="form-group col-sm-6">
                @include('controles.fecha', ['control_control' => 'recepcion_fecha'
                                        , 'control_default'=>substr($casosInformes->recepcion_fecha,0,10)
                                        ,'control_texto'=>'Fecha de recepción'])
            </div>
            <!-- Entrega Lugar Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('entrega_lugar', 'Lugar donde se recibe:') !!}
                {!! Form::text('entrega_lugar', null, ['class' => 'form-control']) !!}
            </div>
            <!-- Entrega Id Consentimiento Field -->
            <div class="form-group col-sm-6">
                @include('controles.radio_si_no', ['control_control' => 'entrega_id_consentimiento'
                                            ,'control_default' => $casosInformes->entrega_id_consentimiento
                                            ,'control_texto'=>'Cuenta con consentimiento informado:'])
            </div>

            <!-- Entrega Id Tratamiento Field -->
            <div class="form-group col-sm-6">
                @include('controles.radio_si_no', ['control_control' => 'entrega_id_tratamiento'
                                            ,'control_default' => $casosInformes->entrega_id_tratamiento
                                            ,'control_texto'=>'Cuenta con autorización de tratamiento de datos:'])
            </div>
        </div>
    </div>

    {{-- Sobre el remitente --}}
    <div class="box box-solid box-default">
        <div class="box-header">
            Acerca del remitente
        </div>
        <div class="box-body">
            <!-- Remitente Nombre Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('remitente_nombre', 'Nombre de quien entrega:') !!}
                {!! Form::text('remitente_nombre', null, ['class' => 'form-control','required'=>'required']) !!}
            </div>
            <!-- Remitente Cedula Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('remitente_cedula', 'Cédula de quien entrega:') !!}
                {!! Form::text('remitente_cedula', null, ['class' => 'form-control']) !!}
            </div>

            <!-- Remitente Organizacion Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('remitente_organizacion', 'Organizacion que hace la entrega:') !!}
                {!! Form::text('remitente_organizacion', null, ['class' => 'form-control']) !!}
            </div>

            <!-- Remitente Id Tipo Organizacion Field -->
            <div class="form-group col-sm-6">
                @include('controles.catalogo', ['control_control' => 'remitente_id_tipo_organizacion'
                                            ,'control_id_cat'=>12
                                            , 'control_default'=>$casosInformes->remitente_id_tipo_organizacion
                                            , 'control_multiple' => false
                                            , 'control_requerido' => true
                                            ,'control_texto'=>'Tipo de organización:'])
            </div>

            <!-- Remitente Correo Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('remitente_correo', 'Correo-E de contacto:') !!}
                {!! Form::text('remitente_correo', null, ['class' => 'form-control']) !!}
            </div>

            <!-- Remitente Telefono Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('remitente_telefono', 'Teléfono de contacto:') !!}
                {!! Form::text('remitente_telefono', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    {{-- Sobre el remitente --}}
    <div class="box box-solid box-default">
        <div class="box-header">
            Acerca de quien recibe
        </div>
        <div class="box-body">
            <!-- Id Macroterritorio Field -->
            <div class="form-group col-sm-6">
                @include('controles.cev2', ['control_control' => 'id_territorio'
                                                , 'control_territorio'=>$casosInformes->id_territorio])

            </div>
            <div class="col-sm-6"></div><div class="clearfix"></div>

            <!-- Receptor Nombre Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('receptor_nombre', 'Nombre de quien recibe:') !!}
                {!! Form::text('receptor_nombre', null, ['class' => 'form-control','required'=>'required']) !!}
            </div>

            <!-- Receptor Id Area Field -->
            <div class="form-group col-sm-6">
                @include('controles.catalogo', ['control_control' => 'receptor_id_area'
                                                        ,'control_id_cat'=>13
                                                        , 'control_default'=>$casosInformes->receptor_id_area
                                                        //, 'control_vacio' => '[Mostrar todos]'
                                                        ,'control_texto'=>'Area de la que hace parte:'])
            </div>

            <!-- Receptor Almacenaje Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('receptor_almacenaje', 'Ubicación física donde se resguarda:') !!}
                {!! Form::textarea('receptor_almacenaje', null, ['class' => 'form-control','rows'=>3,'required'=>'required']) !!}
            </div>

            <!-- Receptor Anotaciones Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('receptor_anotaciones', 'Anotaciones de quien recibe:') !!}
                {!! Form::textarea('receptor_anotaciones', null, ['class' => 'form-control','rows'=>3]) !!}
            </div>

        </div>
    </div>
    <div class="box box-solid box-primary">
        <div class="box-header">
            Caracterización del material recibido
        </div>
        <div class="box-body">
            <!-- Caracterizacion Id Tipo Field -->
            <div class="form-group col-sm-6">
                @include('controles.catalogo', ['control_control' => 'caracterizacion_id_tipo'
                                                        ,'control_id_cat'=>14
                                                        , 'control_default'=>$casosInformes->caracterizacion_id_tipo
                                                        //, 'control_vacio' => '[Mostrar todos]'
                                                        ,'control_texto'=>'Clasificación del material recibido:'])
            </div>
            <div class="form-group col-sm-6 " id="div_cantidad_casos">
                <label>Cantidad de casos:</label>
                {!! Form::number('cantidad_casos',null,['class' => 'form-control','max'=>10000,'min'=>1,'id'=>'cantidad_casos']) !!}

            </div>
            <div class="col-sm-6"></div><div class="clearfix"></div>

            <!-- Caracterizacion Fecha Elaboracion Field -->
            <div class="form-group col-sm-6">
                @include('controles.fecha', ['control_control' => 'caracterizacion_fecha_elaboracion'
                                        , 'control_default'=>substr($casosInformes->caracterizacion_fecha_elaboracion,0,10)
                                        ,'control_texto'=>'Fecha de elaboración (del material recibido)'])

            </div>

            <!-- Caracterizacion Fecha Publicacion Field -->
            <div class="form-group col-sm-6">
                @include('controles.fecha', ['control_control' => 'caracterizacion_fecha_publicacion'
                                        , 'control_default'=>substr($casosInformes->caracterizacion_fecha_publicacion,0,10)
                                        ,'control_texto'=>'Fecha de publicación (del material recibido)'])
            </div>


            <!-- Caracterizacion Temporalidad Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('caracterizacion_temporalidad', 'Período de tiempo que cubre:') !!}
                {!! Form::text('caracterizacion_temporalidad', null, ['class' => 'form-control']) !!}
            </div>

            @if($casosInformes->id_casos_informes && strlen($casosInformes->caracterizacion_cobertura) >0) {{-- Edicion y con info en cobertura --}}
                <!-- Caracterizacion Cobertura Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('caracterizacion_cobertura', 'Cobertura geográfica:') !!}
                    {!! Form::text('caracterizacion_cobertura', null, ['class' => 'form-control','disabled'=>'disabled']) !!}
                </div>
                <div class="clearfix"></div>
            @endif

            {{-- Opciones múltiples para escoger cobertura geográfica --}}
            {{-- Editar valores previos --}}
            @php($inicio=0)
            @foreach($casosInformes->rel_casos_informes_geo as $tmp)
                <div class="form-group col-sm-10">
                    @include('controles.geo3', ['control_control' => 'id_geo[]'
                                                , 'control_id' => 'id_geo_'.$inicio
                                                ,'control_texto' => 'Cobertura geográfica:'
                                                ,'control_vacio' =>'(Sin especificar)'
                                                ,'control_default' => $tmp->id_geo
                                                ])
                    @php($inicio++)
                    <p class="text-sm text-info">Tip: el sistema ignora las coberturas geográficas cuyo departamento no se especifica</p>
                </div>
                <div class="clearfix"></div>
            @endforeach
            {{-- Nuevos campos --}}
            @php($max=25)
            @for($i=$inicio; $i<=$max; $i++)
                <div id="oculto_{{ $i }}" class="{{ $i>$inicio ? 'hidden' : '' }}">  {{-- Ocultar todos menos el primero --}}
                    <div class="form-group col-sm-10">
                        @include('controles.geo3', ['control_control' => 'id_geo[]'
                                                    , 'control_id' => 'id_geo_'.$i
                                                    ,'control_texto' => 'Cobertura geográfica: '
                                                    ,'control_vacio' =>'(Sin especificar)'

                                                    ])
                        <p class="text-sm text-info">Tip: el sistema ignora las coberturas geográficas cuyo departamento no se especifica</p>
                    </div>
                    @if($i < $max)  {{-- No mostrarlo en el último --}}
                        <div class="form-group col-sm-2 " style="padding-top: 50px">
                            <button class="btn btn-info btn-xs pull-right" onclick="$('#oculto_{{ $i+1 }}').removeClass('hidden');$(this).addClass('hidden')" type="button" >Especificar otra cobertura</button>

                        </div>
                    @endif
                    <div class="clearfix"></div>

                </div>
            @endfor





            @if($casosInformes->id_casos_informes && strlen($casosInformes->caracterizacion_sectores) >0) {{-- Edicion --}}
                <!-- Caracterizacion Sectores Field -->
                <div class="form-group col-sm-12">
                    {!! Form::label('caracterizacion_sectores', 'Sectores de la población que incluye:') !!}
                    {!! Form::text('caracterizacion_sectores', null, ['class' => 'form-control','title'=>'Ejemplo: indígenas, afrocolombianos, mujeres, etc.','data-toggle'=>'tooltip','disabled'=>'disabled']) !!}
                </div>
            @endif

            {{-- Campos nuevos: 2021-10-22 --}}
            <div class="clearfix"></div>
            <div class="form-group col-sm-6">
                @include('controles.catalogo', ['control_control' => 'id_item'
                                                        ,'control_id_cat'=>190
                                                        ,'control_id'=>'id_item_190'
                                                        , 'control_default'=>array_keys($casosInformes->arreglo_sectores(190))
                                                        , 'control_multiple'=>true
                                                        , 'control_requerido' => false
                                                        ,'control_texto'=>'Actores armados:'])
            </div>
            <div class="form-group col-sm-6">
                @include('controles.catalogo', ['control_control' => 'id_item'
                                                        ,'control_id_cat'=>191
                                                        ,'control_id'=>'id_item_191'
                                                        , 'control_default'=>array_keys($casosInformes->arreglo_sectores(191))
                                                        , 'control_multiple'=>true
                                                        , 'control_requerido' => false
                                                        ,'control_texto'=>'Poblaciones:'])
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-sm-6">
                @include('controles.catalogo', ['control_control' => 'id_item'
                                                        ,'control_id_cat'=>192
                                                        ,'control_id'=>'id_item_192'
                                                        , 'control_default'=>array_keys($casosInformes->arreglo_sectores(192))
                                                        , 'control_multiple'=>true
                                                        , 'control_requerido' => false
                                                        ,'control_texto'=>'Ocupaciones:'])
            </div>
            <div class="clearfix"></div>


            <div class="col-sm-6"></div><div class="clearfix"></div>
            {{-- Intereses --}}
            <div class="form-group col-sm-12">
                @include('controles.catalogo', ['control_control' => 'interes'
                                                        ,'control_id_cat'=>19
                                                        , 'control_default'=>$casosInformes->arreglo_intereses
                                                        , 'control_multiple'=>true
                                                        , 'control_requerido' => true
                                                        ,'control_texto'=>'Puede ser de interés para :'])
            </div>
            {{-- Manadato --}}
            <div class="form-group col-sm-12">
                @include('controles.catalogo', ['control_control' => 'mandato'
                                                        ,'control_id_cat'=>15
                                                        , 'control_default'=>$casosInformes->arreglo_mandato
                                                        , 'control_multiple'=>true
                                                        , 'control_requerido' => true
                                                        ,'control_texto'=>'Coincide con los siguientes puntos del mandato:'])
            </div>

        </div>
    </div>


    @include("partials.clasificacion_r1",['nna'=>$casosInformes->clasificacion_nna, 'res'=>$casosInformes->clasificacion_res, 'sex'=>$casosInformes->clasificacion_sex, 'r1'=>$casosInformes->clasificacion_r1, 'r2'=>$casosInformes->clasificacion_r2 ])




</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary pull-right']) !!}
    <a href="{!! route('casosInformes.index') !!}" class="btn btn-default">Cancelar</a>
</div>


@push("js")
    <script>
        var control = $('#caracterizacion_id_tipo').select2();
        var caso_para_comision = {{ config('expedientes.caso_comision') }};
        control.on('select2:select', function (e) {
            mostrar_cantidad_casos();
        });

        function mostrar_cantidad_casos() {
            if ($('#caracterizacion_id_tipo').val() == caso_para_comision) {
                $("#div_cantidad_casos").removeClass('hidden')
            }
            else {
                $("#div_cantidad_casos").addClass('hidden')
            }
        }
        $(function() {
            mostrar_cantidad_casos();
        });


    </script>



@endpush