<div class="col-xs-12">
    <div class="box box-info box-solid">
        <div class="box-header">
            <h1 class="box-title">Acerca del material</h1>
        </div>
        <div class="box-body">
            <!-- Titulo Field -->
            <div class="form-group col-sm-12">
                {!! Form::label('titulo', 'Titulo:') !!}
                <p>{!! $casosInformes->titulo !!}</p>
            </div>

            <!-- Autor Field -->
            <div class="form-group  col-sm-6">
                {!! Form::label('autor', 'Autor:') !!}
                <p>{!! $casosInformes->autor !!}</p>
            </div>
            <!-- Autor Id Tipo Organizacion  -->
            <div class="form-group  col-sm-6">
                {!! Form::label('autor', 'Tipo de organización - Autor:') !!}
                <p>{!! $casosInformes->fmt_autor_id_tipo_organizacion !!}</p>
            </div>

            <!-- Descripcion Field -->
            <div class="form-group col-sm-12">
                {!! Form::label('descripcion', 'Descripcion:') !!}
                <p>{!! $casosInformes->descripcion !!}</p>
            </div>

            <!-- Id Tipo Soporte Field -->
            <div class="form-group  col-sm-6">
                {!! Form::label('id_tipo_soporte', 'Medio de soporte:') !!}
                <p>{!! $casosInformes->fmt_id_tipo_soporte !!}</p>
            </div>
            <!-- Contenido Volumen Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('contenido_volumen', 'Volúmen recibido:') !!}
                <p>{!! $casosInformes->contenido_volumen !!}</p>
            </div>
            <div class="clearfix"></div>

            <!-- Contenido Texto Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('contenido_texto', 'Descripción del contenido, si incluye material de texto:') !!}
                <p>{!! $casosInformes->contenido_texto !!}</p>
            </div>

            <!-- Contenido Audiovisual Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('contenido_texto', 'Descripción del contenido, si incluye de material audiovisual:') !!}
                <p>{!! $casosInformes->contenido_audiovisual !!}</p>
            </div>

            <!-- Contenido Fotografia Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('contenido_texto', 'Descripción del contenido, si incluye material fotográfico:') !!}
                <p>{!! $casosInformes->contenido_fotografia !!}</p>
            </div>

            <!-- Contenido Sonoro Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('contenido_texto', 'Descripción del contenido, si incluye material sonoro:') !!}
                <p>{!! $casosInformes->contenido_sonoro !!}</p>
            </div>

            <!-- Contenido Base Datos Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('contenido_texto', 'Descripción del contenido, si incluye bases de datos:') !!}
                <p>{!! $casosInformes->contenido_base_datos !!}</p>
            </div>

            <!-- Contenido Otros Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('contenido_otros', 'Otros contenidos:') !!}
                <p>{!! $casosInformes->contenido_otros !!}</p>
            </div>



        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="col-sm-4">
    <div class="box box-default">
        <div class="box-header">
            <h1 class="box-title">Información del remitente</h1>
        </div>
        <div class="box-body">


            <!-- Remitente Nombre Field -->
            <div class="form-group">
                {!! Form::label('remitente_nombre', 'Nombre de quien entrega:') !!}
                <p>{!! $casosInformes->remitente_nombre !!}</p>
            </div>
            <!-- Remitente Cedula Field -->
            <div class="form-group">
                {!! Form::label('remitente_cedula', 'Cédula:') !!}
                <p>{!! $casosInformes->remitente_cedula !!}</p>
            </div>

            <!-- Remitente Organizacion Field -->
            <div class="form-group">
                {!! Form::label('remitente_organizacion', 'Organizacion que realiza la entrega:') !!}
                <p>{!! $casosInformes->remitente_organizacion !!}</p>
            </div>

            <!-- Remitente Id Tipo Organizacion Field -->
            <div class="form-group">
                {!! Form::label('remitente_id_tipo_organizacion', 'Tipo de organización:') !!}
                <p>{!! $casosInformes->fmt_remitente_id_tipo_organizacion !!}</p>
            </div>

            <!-- Remitente Correo Field -->
            <div class="form-group">
                {!! Form::label('remitente_correo', 'Correo-e de referencia:') !!}
                <p>{!! $casosInformes->remitente_correo !!}</p>
            </div>

            <!-- Remitente Telefono Field -->
            <div class="form-group">
                {!! Form::label('remitente_telefono', 'Teléfono para contacto:') !!}
                <p>{!! $casosInformes->remitente_telefono !!}</p>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-4">
    <div class="box box-default">
        <div class="box-header">
            <h1 class="box-title">Acerca de la recepción</h1>
        </div>
        <div class="box-body">
            <!-- Recepcion Fecha Field -->
            <div class="form-group">
                {!! Form::label('recepcion_fecha', 'Fecha de recepción:') !!}
                <p>{!! $casosInformes->fmt_recepcion_fecha !!}</p>
            </div>

            <!-- Entrega Id Geo Field -->
            <div class="form-group">
                {!! Form::label('entrega_id_geo', 'Ubicación de la recepción:') !!}
                <p>{!! $casosInformes->fmt_entrega_id_geo !!}</p>
            </div>

            <!-- Entrega Lugar Field -->
            <div class="form-group">
                {!! Form::label('entrega_lugar', 'Lugar de recepción:') !!}
                <p>{!! $casosInformes->entrega_lugar !!}</p>
            </div>

            <!-- Entrega Id Consentimiento Field -->
            <div class="form-group">
                {!! Form::label('entrega_id_consentimiento', 'Cuenta con consentimiento informado:') !!}
                <p>{!! $casosInformes->fmt_entrega_id_consentimiento !!}</p>
            </div>

            <!-- Entrega Id Tratamiento Field -->
            <div class="form-group">
                {!! Form::label('entrega_id_tratamiento', 'Cuenta con tratamiento de datos personales:') !!}
                <p>{!! $casosInformes->fmt_entrega_id_tratamiento !!}</p>
            </div>

        </div>
    </div>
</div>
<div class="col-sm-4">
    <div class="box box-default">
        <div class="box-header">
            <h1 class="box-title">Datos de quien recibe</h1>
        </div>
        <div class="box-body">
            <!-- Receptor Nombre Field -->
            <div class="form-group">
                {!! Form::label('receptor_nombre', 'Nombre de quien recibe:') !!}
                <p>{!! $casosInformes->receptor_nombre !!}</p>
            </div>
            <!-- Id Macroterritorio Field -->
            <div class="form-group">
                {!! Form::label('id_territorio', 'Territorio:') !!}
                <p>{!! $casosInformes->fmt_id_territorio !!}</p>
            </div>

            <!-- Receptor Id Area Field -->
            <div class="form-group">
                {!! Form::label('receptor_id_area', 'Area de la que hace parte:') !!}
                <p>{!! $casosInformes->fmt_receptor_id_area !!}</p>
            </div>

            <!-- Receptor Almacenaje Field -->
            <div class="form-group">
                {!! Form::label('receptor_almacenaje', 'Ubicación física donde se resguarda:') !!}
                <p>{!! $casosInformes->receptor_almacenaje !!}</p>
            </div>

            <!-- Receptor Anotaciones Field -->
            <div class="form-group">
                {!! Form::label('receptor_anotaciones', 'Anotaciones de quien recibe:') !!}
                <p>{!! $casosInformes->receptor_anotaciones !!}</p>
            </div>

        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="col-xs-12">
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h1 class="box-title">Caracterización</h1>
        </div>
        <div class="box-body">
            <!-- Caracterizacion Id Tipo Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('caracterizacion_id_tipo', 'Clasificación') !!}
                <p>{!! $casosInformes->fmt_caracterizacion_id_tipo !!}</p>
            </div>
            @if($casosInformes->caracterizacion_id_tipo == config('expedientes.caso_comision'))
                <div class="form-group col-sm-6">
                    {!! Form::label('cantidad_casos', 'Cantidad de casos') !!}
                    <p>{!! $casosInformes->cantidad_casos !!}</p>
                </div>

            @endif
            <div class="clearfix"></div>

            <!-- Caracterizacion Fecha Elaboracion Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('caracterizacion_fecha_elaboracion', 'Fecha de elaboracion:') !!}
                <p>{!! $casosInformes->fmt_caracterizacion_fecha_elaboracion !!}</p>
            </div>

            <!-- Caracterizacion Fecha Publicacion Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('caracterizacion_fecha_publicacion', 'Fecha de publicacion:') !!}
                <p>{!! $casosInformes->fmt_caracterizacion_fecha_publicacion !!}</p>
            </div>

            <!-- Caracterizacion Temporalidad Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('caracterizacion_temporalidad', 'Período de tiempo que cubre:') !!}
                <p>{!! $casosInformes->caracterizacion_temporalidad !!}</p>
            </div>

            <!-- Caracterizacion Cobertura Field -->
            @if($casosInformes->rel_casos_informes_geo()->count() == 0)
                <div class="form-group col-sm-6">
                    {!! Form::label('caracterizacion_cobertura', 'Cobertura geográfica:') !!}
                    <p>{!! $casosInformes->caracterizacion_cobertura !!}</p>
                </div>
            @else
                <div class="clearfix"></div>
                <div class="form-group col-sm-12">
                    {!! Form::label('caracterizacion_cobertura', 'Cobertura geográfica:') !!}
                    <ul>
                        @foreach($casosInformes->rel_casos_informes_geo as $tmp)
                            <li>{{ $tmp->fmt_id_geo }}</li>
                        @endforeach
                    </ul>
                </div>

            @endif

            <!-- Caracterizacion Sectores Field -->
            @if($casosInformes->rel_sectores()->count()==0)
                <div class="form-group col-xs-12">
                    {!! Form::label('caracterizacion_sectores', 'Sectores de la población que incluye:') !!}
                    <p>{!! $casosInformes->caracterizacion_sectores !!}</p>
                </div>
            @else
                <div class="form-group col-xs-12">
                    {!! Form::label('sectores', 'Actores armados:') !!}
                    <ul>
                        @foreach($casosInformes->arreglo_sectores(190) as $item)
                            <li> {{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="form-group col-xs-12">
                    {!! Form::label('sectores', 'Poblaciones:') !!}
                    <ul>
                        @foreach($casosInformes->arreglo_sectores(191) as $item)
                            <li> {{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="form-group col-xs-12">
                    {!! Form::label('sectores', 'Ocupaciones:') !!}
                    <ul>
                        @foreach($casosInformes->arreglo_sectores(192) as $item)
                            <li> {{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group col-xs-12">
                {!! Form::label('interes', 'Puede ser de interés para:') !!}
                <ul>
                    @foreach($casosInformes->rel_intereses as $item)
                        <li> {{ $item->fmt_id_interes }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group col-xs-12">
                {!! Form::label('interes', 'Coincidencia con el mandato de La Comisión:') !!}
                <ul>
                    @foreach($casosInformes->rel_mandato as $item)
                        <li> {{ $item->fmt_id_mandato }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="box-footer text-right">
            <i>
                Registrado el {!! $casosInformes->fmt_caracterizacion_fecha_caracterizacion !!}
            </i>
        </div>
    </div>
    @php($edicion=false)
    @include("casos_informes.tabla_adjuntos")

</div>

@include("casos_informes.clasificacion_show")