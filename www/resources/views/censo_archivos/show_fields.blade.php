


    <div class="nav-tabs-custom">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs pull-right"  role="tablist">

            @if( in_array($censoArchivos->privilegios,[1]))
                <li role="presentation" class="{{ $activar=="a" ? 'active' : '' }}"><a href="#permisos" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-lock"></i> Seguridad</a></li>
            @endif


            @if( in_array($censoArchivos->privilegios,[1,5]))
                <li role="presentation"  class="{{ $activar=="d" ? 'active' : '' }}"><a href="#about" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-info-circle"></i> Acerca de</a></li>
            @endif
            <li role="presentation"  class="{{ $activar=="x" ? 'active' : '' }}"><a href="#adjuntos" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-paperclip"></i> Adjuntos</a></li>

            @if( in_array($censoArchivos->privilegios,[1,5]))
                <li role="presentation"  class="{{ $activar=="c" ? 'active' : '' }}"><a href="#custodio" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Custodio</a></li>
                <li role="presentation"  class="{{ $activar=="r" ? 'active' : '' }}"><a href="#riesgos" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-bolt"></i> Riesgos</a></li>
            @endif
                <li role="presentation"  class="{{ $activar=="n" ? 'active' : '' }}"><a href="#acceso" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-eye"></i> Nivel de acceso</a></li>
                <li role="presentation"  class="{{ $activar=="m" ? 'active' : '' }}"><a href="#descripcion" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-briefcase"></i> Descripción</a></li>


        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            {{-- adjuntos --}}
            <div role="tabpanel" class="tab-pane {{ $activar=="x" ? 'active' : '' }}" id="adjuntos">
                @php
                    $expediente = $censoArchivos;
                    $llave_primaria = 'id_censo_archivos_adjunto';
                    $action = 'censo_archivosController@quitar_adjunto';
                    $edicion= $expediente->puede_modificar;
                    $listado_adjuntos = $censoArchivos->listar_adjuntos();
                @endphp
                <div class="box box-info">
                    <div class="box-header">
                        @if($censoArchivos->puede_modificar_adjuntos())
                            <a href="{!! action('censo_archivosController@gestionar_adjuntos', [$censoArchivos->id_censo_archivos]) !!}" class="btn btn-xs btn-info pull-right"><i class="fa fa-paperclip"></i> Adjuntar archivos</a>
                        @endif
                    </div>
                    <div class="box-body">
                            @include('censo_archivos.tabla_seccion')
                    </div>
                </div>

            </div>
            {{-- Descripcion --}}
            <div role="tabpanel" class="tab-pane {{ $activar=="m" ? 'active' : '' }}" id="descripcion">
                <!-- Id Tipo Field -->
                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('id_tipo', 'Tipo de archivo:') !!}
                        <p>{{ $censoArchivos->fmt_id_tipo }}</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('id_tipo', 'Nivel de organización:') !!}
                        <p>{{ $censoArchivos->fmt_id_nivel_organizacion }}</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('periodo', 'Período de tiempo que cubre:') !!}
                        <p>{{ $censoArchivos->anio_del }} - {{ $censoArchivos->anio_al }}</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('perfil_productor', 'Perfil del productor:') !!}
                        <p>{{ nl2br($censoArchivos->perfil_productor) }} </p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('sintesis', 'Síntesis / Reseña del archivo:') !!}
                        <p>{{ nl2br($censoArchivos->sintesis) }} </p>
                    </div>
                </div>
                {{-- Direccion y ubicacion --}}
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('direccion', 'Dirección donde se encuentra el archivo:') !!}
                        <p>{{ $censoArchivos->direccion }}</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('id_geo', 'Ubicación:') !!}
                        <p>{{ $censoArchivos->fmt_id_geo }}</p>
                    </div>
                </div>

                <div class="col-xs-12">
                    <h3 class="text-primary">Herramientas archivísticas</h3>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('cobertura_geográfica', 'Cobertura geográfica:') !!}
                        <p>{!!   nl2br($censoArchivos->cobertura_geografica) !!}</p>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('indice', 'Índice del contenido:') !!}
                        <p>{!!   nl2br($censoArchivos->indice) !!}</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('id_geo', 'Contenido temático:') !!}
                        <p>{!!   nl2br($censoArchivos->contenido_tematico) !!}</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('id_sector', 'Sectores asociados:') !!}
                        <ul>
                        @foreach($censoArchivos->elegidos(18) as $id)
                            <li>{{ \App\Models\cat_item::describir($id) }}</li>
                        @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('id_patron', 'Patrones referidos dentro del archivo (si aplica):') !!}
                        <ul>
                            @foreach($censoArchivos->elegidos(280) as $id)
                                <li>{{ \App\Models\cat_item::describir($id) }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>



                <div class="col-xs-12">
                    <h3 class="text-primary">Composición</h3>
                </div>



                <div class="col-sm-3">
                    <div class="form-group">
                        {!! Form::label('archivo_fisico', 'Archivo Fisico:') !!}
                        <p>{{ $censoArchivos->fmt_archivo_fisico }}</p>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        {!! Form::label('archivo_fisico_volumen', 'Volúmen del archivo físico:') !!}
                        <p>{{ $censoArchivos->archivo_fisico_volumen }}</p>
                    </div>

                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        {!! Form::label('archivo_fisico_ubicacion', 'Ubicación del archivo físico:') !!}
                        <p>{{ $censoArchivos->archivo_fisico_ubicacion }}</p>
                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="col-sm-3">
                    <div class="form-group">
                        {!! Form::label('archivo_electronico', 'Archivo electrónico:') !!}
                        <p>{{ $censoArchivos->fmt_archivo_electronico }}</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        {!! Form::label('archivo_electronico_volumen', 'Volúmen del archivo electrónico:') !!}
                        <p>{{ $censoArchivos->archivo_electronico_volumen }}</p>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        {!! Form::label('archivo_electronico_ubicacion', 'Ubicación del archivo electrónico:') !!}
                        <p>{{ $censoArchivos->archivo_electronico_ubicacion }}</p>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-3">
                    <div class="form-group">
                        {!! Form::label('archivo_virtual', 'Archivo virtual:') !!}
                        <p>{{ $censoArchivos->fmt_archivo_virtual }}</p>
                    </div>

                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        {!! Form::label('archivo_virtual_volumen', 'Volúmen del archivo virtual:') !!}
                        <p>{{ $censoArchivos->archivo_virtual_volumen }}</p>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        {!! Form::label('archivo_virutal_ubicacion', 'Ubicación del archivo virtual:') !!}
                        <p>{{ $censoArchivos->archivo_virtual_ubicacion }}</p>
                    </div>
                </div>
                <div class="clearfix"></div>




            </div>
            {{-- Nivel de acceso --}}
            <div role="tabpanel" class="tab-pane {{ $activar=="n" ? 'active' : '' }}" id="acceso">

                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::label('consultado_por', 'Consultado por:') !!}
                        <ul>
                            @foreach($censoArchivos->elegidos(351) as $id)
                                <li>{{ \App\Models\cat_item::describir($id) }}</li>
                            @endforeach
                        </ul>

                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        {!! Form::label('acceso_publico', 'Acceso público:') !!}
                        <p>{{ $censoArchivos->fmt_acceso_publico }}</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        {!! Form::label('acceso_publico_volumen', 'Volúmen:') !!}
                        <p>{{ $censoArchivos->acceso_publico_volumen }}</p>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        {!! Form::label('acceso_publico_descripcion', 'Descripción:') !!}
                        <p>{{ $censoArchivos->acceso_publico_descripcion }}</p>
                    </div>

                </div>

                <div class="clearfix"></div>
                <div class="col-sm-3">
                    <div class="form-group">
                        {!! Form::label('acceso_clasificado', 'Acceso clasificado:') !!}
                        <p>{{ $censoArchivos->fmt_acceso_clasificado }}</p>
                    </div>

                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        {!! Form::label('acceso_clasificado_volumen', 'Volúmen:') !!}
                        <p>{{ $censoArchivos->acceso_clasificado_volumen }}</p>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        {!! Form::label('acceso_clasificado_descripcion', 'Descripción:') !!}
                        <p>{{ $censoArchivos->acceso_clasificado_descripcion }}</p>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-3">
                    <div class="form-group">
                        {!! Form::label('acceso_reservado', 'Acceso reservado:') !!}
                        <p>{{ $censoArchivos->fmt_acceso_reservado }}</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        {!! Form::label('acceso_reservado_volumen', 'Volúmen:') !!}
                        <p>{{ $censoArchivos->acceso_reservado_volumen }}</p>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        {!! Form::label('acceso_reservado_descripcion', 'Descripción:') !!}
                        <p>{{ $censoArchivos->acceso_reservado_descripcion }}</p>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
            @if( in_array($censoArchivos->privilegios,[1,5]))
                {{-- riesgos --}}
                <div role="tabpanel " class="tab-pane {{ $activar=="r" ? 'active' : '' }}" id="riesgos">


                    <div class="col-sm-12">
                        <div class="form-group">
                            {!! Form::label('riesgo_socio', 'Riesgo sociopolítico:') !!}
                            <ul>
                                @foreach($censoArchivos->elegidos(352) as $id)
                                    <li>{{ \App\Models\cat_item::describir($id) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            {!! Form::label('riesgo_amb', 'Riesgo ambiental:') !!}
                            <ul>
                                @foreach($censoArchivos->elegidos(353) as $id)
                                    <li>{{ \App\Models\cat_item::describir($id) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                {{-- Custodio --}}
                <div role="tabpanel" class="tab-pane {{ $activar=="c" ? 'active' : '' }}" id="custodio">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {!! Form::label('custodio', 'Nombre del custodio:') !!}
                            <p>{{ $censoArchivos->custodio }}</p>
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('contacto_nombre', 'Nombre de persona de contacto::') !!}
                            <p>{{ $censoArchivos->contacto_nombre }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('contacto_correo', 'Correo electrónico:') !!}
                            <p>{{ $censoArchivos->contacto_correo }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('contacto_telefono', 'Teléfono:') !!}
                            <p>{{ $censoArchivos->contacto_telefono }}</p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('contacto_url', 'Dirección web (URL):') !!}
                            <p>{{ $censoArchivos->contacto_url }}</p>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <h3 class="text-primary">Autorizaciones</h3>
                    </div>


                    <div class="col-xs-12">
                        <div class="form-group">
                            {!! Form::label('auto_uno', '¿Está de acuerdo en la publicación de este repositorio a lo interno de La Comisión? ') !!}
                            {{ $censoArchivos->fmt_consentimiento_repositorio }}
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            {!! Form::label('auto_dos', '¿Está de acuerdo en el traslado de la presente publicación hacia terceros? ') !!}
                            {{ $censoArchivos->fmt_consentimiento_publicar }}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                {{-- Acerca de --}}
                <div role="tabpanel" class="tab-pane {{ $activar=="d" ? 'active' : '' }}" id="about">


                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('ficha_diligenciada_nombre', 'Nombre de quien diligencia la información:') !!}
                        <p>{{ $censoArchivos->ficha_diligenciada_nombre }}</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('ficha_diligenciada_telefono', 'Teléfono:') !!}
                        <p>{{ $censoArchivos->ficha_diligenciada_telefono }}</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('ficha_diligenciada_correo', 'Correo electrónico:') !!}
                        <p>{{ $censoArchivos->ficha_diligenciada_correo }}</p>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::label('id_territorio', 'Territorio:') !!}
                        <p>{{ $censoArchivos->fmt_id_territorio }}</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('anotaciones', 'Anotaciones:') !!}
                        <p>{{ $censoArchivos->anotaciones }}</p>
                    </div>

                </div>
                <div class="clearfix"></div>
            </div>
            @endif

            @if( in_array($censoArchivos->privilegios,[1]))
                {{-- seguridad --}}
                <div role="tabpanel" class="tab-pane {{ $activar=="a" ? 'active' : '' }}" id="permisos">
                    @include("censo_archivos.tabla_accesos")
                    <div class="clearfix"></div>
                </div>
            @endif
        </div>

    </div>







