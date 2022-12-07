@php
    $colapsar_menu=true;
@endphp
@extends('layouts.app')

@section('content')
    <div class="pull-right">


    </div>
    <h1 class="page-title">
        {!! $misCasos->entrevista_codigo !!} <small> {{ $misCasos->nombre }}</small>
    </h1>
    <section>
        <span class="text-muted">
            {!! $misCasos->fmt_descripcion !!}
        </span>

    </section>
    <br>

    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom">
                {{-- ETIQUETAS --}}
                <ul class="nav nav-tabs">
                    <li class="{{ $activar=="m" ? 'active' : '' }}"><a href="#b-metadatos" data-toggle="tab">
                            <span class="text-primary"><i class="fa fa-briefcase"></i></span> Metadatos</a>
                    </li>
                    <li class="{{ $activar=="e" ? 'active' : '' }}"><a href="#b-entrevistas" data-toggle="tab">
                            <i class="fa fa-flag"></i> Entrevistas</a>
                    </li>
                    @if(in_array($misCasos->privilegios,[1,5]))
                        <li class="{{ $activar=="p" ? 'active' : '' }}"><a href="#b-personas" data-toggle="tab">
                                <i class="fa fa-users"></i> Personas</a>
                        </li>
                        <li class="{{ $activar=="t" ? 'active' : '' }}"><a href="#b-tareas" data-toggle="tab">
                                <i class="fa fa-check-square-o"></i> Tareas</a>
                        </li>
                    @endif
                    @if(in_array($misCasos->privilegios,[1,5,3])) {{-- 3:Administrador --}}
                        {{-- Todos acceden --}}
                        <li class="{{ $activar=="b" ? 'active' : '' }}"><a href="#b-blog" data-toggle="tab">
                                <i class="fa fa-file-text-o"></i> Notas</a>
                        </li>
                    @endif
                    @foreach($misCasos->secciones_permitidas() as $id=>$txt)
                        <li class="{{ $activar=="s$id" ? 'active' : '' }}">
                            <a href="#b-{{ $id }}" data-toggle="tab" >
                                <span class="text-success"><i class="fa fa-paperclip fa-rotate-90"></i></span> {{ $txt }}</a>
                        </li>
                    @endforeach
                    @if(in_array($misCasos->privilegios,[1]))
                        <li class="{{ $activar=="a" ? 'active' : '' }}"><a href="#b-acceso" data-toggle="tab">
                                <i class="fa fa-lock"></i> Seguridad</a>
                        </li>
                    @endif
                    @if(count($misCasos->listado_adjuntos_compartidos(true)) > 0 )
                        <li ><a href="#b-compartidos" data-toggle="tab">
                                <i class="fa fa-share-alt"></i> Anexos compartidos para mí</a>
                        </li>
                    @endif
                </ul>
                {{-- CONTENIDO DE CADA ETIQUETA --}}
                <div class="tab-content" >
                    {{-- Metadatos --}}
                    <div class="tab-pane {{ $activar=="m" ? 'active' : '' }} " id="b-metadatos">
                        <div class="box box-info">
                            <div class="box-body ">
                                @include("mis_casos.show_fields")
                            </div>

                                <div class="box-footer">
                                    @can('sistema-abierto')
                                        @if(in_array($misCasos->privilegios,[1]))
                                            <a data-toggle="tooltip" title="Modificar caso" href="{!! action('mis_casosController@edit', [$misCasos->id_mis_casos]) !!}" class='btn btn-default pull-right '><i class="glyphicon glyphicon-edit"></i> Modificar estos metadatos</a>
                                        @endif
                                    @endcan
                                    <div class="pull-left">
                                        <span class="text-muted">Nivel de avance: </span> {{ $misCasos->fmt_id_avance }}
                                    </div>
                                </div>

                        </div>
                    </div>
                    {{-- Entrevistas --}}
                    <div class="tab-pane {{ $activar=="e" ? 'active' : '' }} " id="b-entrevistas">
                        <div class="box box-info">
                            <div class="box-header">
                                @if(count($misCasos->listado_entrevistas)==0)
                                    <h3 class="text-danger">No existen entrevistas asociadas a este caso</h3>
                                @endif
                                @can('sistema-abierto')
                                    @if(in_array($misCasos->privilegios,[1,5]))
                                        <div class="clearfix"></div>
                                        {!! Form::open(['action' => 'mis_casos_entrevistaController@agregar']) !!}
                                        <input type="hidden" name="id_mis_casos" value="{{ $misCasos->id_mis_casos }}">
                                        <div class=" pull-right col-sm-12" >
                                            {{-- Por codigo --}}
                                            <div class="col-sm-6">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" id='listado_codigos' name='listado_codigos' class="form-control" placeholder="Asociar por listado de códigos separados por comas" >
                                                    <span class="input-group-btn">
                                                  <button type="submit" class="btn btn-info btn-flat">Agregar estas entrevistas</button>
                                                </span>
                                                </div>
                                            </div>

                                            {{-- Por marca --}}
                                            <div class="col-sm-6">
                                                <div class="input-group input-group-sm">
                                                    @include('controles.marca', ['control_control' => 'id_marca'
                                                               , 'control_nuevos' => false
                                                               , 'control_mostrar_grupo' => true
                                                              // , 'control_default' => $misCasos->arreglo_marcas()
                                                               , 'control_resaltar' => false
                                                               , 'control_mostrar_grupo' => false
                                                               , 'control_placeholder' => 'Asociar por marcas aplicadas'
                                                               ,'control_texto'=>''])
                                                    <span class="input-group-btn">
                                                  <button type="submit" class="btn btn-info btn-flat" style="margin-top: -15px">Agregar estas entrevistas</button>
                                                </span>
                                                </div>
                                            </div>


                                            <br>
                                        </div>
                                        {!! Form::close() !!}
                                    @endif
                                @endcan
                            </div>
                            <div class="box-body table-responsive no-padding">
                                @if($ocultar > 1)
                                    @include("mis_casos.tabla_entrevistas")
                                @endif
                            </div>
                        </div>


                            <div class="clearfix"></div>
                    </div>
                    @if(in_array($misCasos->privilegios,[1,5,3]))
                        {{-- Personas --}}
                        <div class="tab-pane {{ $activar=="p" ? 'active' : '' }} " id="b-personas">
                            @if($ocultar>2)
                                @include("mis_casos.tabla_personas")
                            @endif
                        </div>
                        {{-- Tareas --}}
                        <div class="tab-pane {{ $activar=="t" ? 'active' : '' }} " id="b-tareas">
                            @if($ocultar>3)
                                @include("mis_casos.tabla_tareas")
                            @endif
                        </div>
                        {{-- Blog --}}
                        <div class="tab-pane {{ $activar=="b" ? 'active' : '' }} bg-gray no-padding" id="b-blog">
                            <br>
                            @if($ocultar>4)
                                @include("mis_casos.blog")
                            @endif
                        </div>
                    @endif

                    {{-- Secciones --}}
                    @foreach($misCasos->secciones_permitidas() as $id=>$txt)
                        <div class="tab-pane {{ $activar=="s$id" ? ' active ' : '' }}" id="b-{{ $id }}" >
                            @php
                                $expediente = $misCasos;
                                $llave_primaria = 'id_mis_casos_adjunto';
                                $action = 'mis_casosController@quitar_adjunto';
                                $edicion= $misCasos->puede_modificar;
                                $listado_adjuntos = $misCasos->listar_seccion($id);
                            @endphp
                            <div class="box box-info">
                                <div class="box-header">
                                    @if($misCasos->puede_modificar_adjuntos($id))
                                        <h4 class="text-success">Archivos adjuntos para la sección {{$txt}} <small>{{ count($listado_adjuntos) }} archivos adjuntos</small>
                                            <a href="{!! action('mis_casosController@gestionar_adjuntos', [$misCasos->id_mis_casos]) !!}?id_seccion={{ $id }}" class="btn btn-xs btn-info pull-right"><i class="fa fa-paperclip"></i> Adjuntar archivos</a>
                                        </h4>
                                    @endif
                                </div>
                                <div class="box-body">
                                    @if($ocultar>5)
                                        @include('mis_casos.tabla_seccion',['id_seccion'=>$id])
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach

                    {{-- Seguridad: accesos --}}
                    @if(in_array($misCasos->privilegios,[1]))
                        <div class="tab-pane {{ $activar=="a" ? 'active' : '' }} " id="b-acceso">
                            @if($ocultar>4)
                                @include("mis_casos.tabla_accesos")
                            @endif
                        </div>
                    @endif

                    {{--  Compartidos conmigo --}}
                    @if(count($misCasos->listado_adjuntos_compartidos(true)) > 0 )
                        <div class="tab-pane " id="b-compartidos">
                            @php($misCasosAdjuntoCompartirs = $misCasos->listado_adjuntos_compartidos(true))
                            <div class="col-sm-12">
                                <div class="box box-default">
                                    <div class="box-body">
                                        @if($ocultar>4)
                                            @include("mis_casos_adjunto_compartirs.table")
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    @endif



                </div>
            </div>
        </div>

    </div>

    @if($ocultar>4)
        @include('traza_actividads.por_expediente',['control_codigo'=>$misCasos->entrevista_codigo])
    @endif


    {{-- Para compartir --}}
    @include("mis_casos.frm_compartir")

@endsection

@push("js")
    <script>
        function compartir(id,texto) {
            $("#compartir_nombre").html(texto);
            $("#id_mis_casos_adjunto").val(id);
            $("#modal_compartir_general").modal('toggle');

        }
    </script>

@endpush

