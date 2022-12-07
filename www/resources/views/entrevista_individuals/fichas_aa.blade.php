@php($colapsar_menu=true)
@extends('layouts.app')

@section('content_header')

        @if(isset($no_editar))
            <div class="col-xs-9">
                <h1 class="page-header">
                    Fichas diligenciadas - <a href="{{ action('entrevista_individualController@show',$expediente->id_e_ind_fvt) }}">Entrevista {{ $expediente->entrevista_codigo }}</a>
                </h1>
            </div>
            <div class="col-xs-3 text-right">
                <a href="{{ action('entrevista_individualController@index') }}" class="btn btn-default">Volver</a>
            </div>
        @else
            <h1 class="page-header">
                Diligenciar fichas  - <a href="{{ action('entrevista_individualController@show',$expediente->id_e_ind_fvt) }}">Entrevista {{ $expediente->entrevista_codigo }}</a>
            </h1>

            @if($expediente->id_subserie != config('expedientes.aa'))
            <ol class="breadcrumb">
                <li ><a href="{{ action('entrevista_individualController@edit',$expediente->id_e_ind_fvt) }}"> 1. Metadatos</a></li>
                <li ><a href="{{ action('entrevista_individualController@gestionar_adjuntos',$expediente->id_e_ind_fvt) }}"> 2. Adjuntos</a></li>
                <li class="active"> 3. <i class="fa fa-send-o"></i> Fichas</li>
            </ol>
            @endif
        @endif



@endsection

@section('content')

    {{-- FILA 0: alertas --}}
    @if($expediente->id_subserie != config('expedientes.aa'))

    @include("entrevista_individuals.p_fichas_conteo")
    <div class="clearfix"></div>

    @if(isset($no_editar))
        <div class="row">
            <div class="col-sm-12">

                @include("hechos.timeline")

            </div>
        </div>
        <br>
        <br>
    @endif
    @endif
    <div class="clearfix"></div>

    {{-- FILA 1:Persona entrevistada y víctimas --}}
    <div class="col-xs-12">
        <div class="box {{ $conteos->entrevistado > 0 && $conteos->victimas > 0 ? 'box-success' : 'box-danger'  }}">
            <div class="box-header">
                <h3 class="box-title">
                  @if($expediente->id_subserie == config('expedientes.aa'))
                    <i class="fa fa-user"></i> 1. Persona entrevistada
                    @else
                    <i class="fa fa-user"></i> 1. Persona entrevistada y víctimas
                    @endif
                </h3>
            </div>
            <div class="box-body no-padding table-responsive">
                @if($conteos->entrevistado > 0 && $conteos->victimas > 0)
                    <div class="col-sm-12">
                        @else
                            <div class="col-sm-8">
                                @endif
                                <table class="table table-hover table-condensed table-bordered table-responsive">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Otros nombres</th>
                                        <th>Sexo</th>
                                        <th>Fecha nac</th>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{-- Persona entrevistada --}}
                                    @php($personas = \App\Models\persona::where('persona_entrevistada.id_e_ind_fvt',$expediente->id_e_ind_fvt)
                                                                    ->join('fichas.persona_entrevistada','persona.id_persona','=','persona_entrevistada.id_persona')->get())
                                    @php($i=1)
                                    @foreach($personas as $persona)
                                        <tr class="bg-info">
                                            <td> {{ $i++ }}</td>
                                            <td>{!! $persona->nombre !!}</td>
                                            <td>{!! $persona->apellido !!}</td>
                                            <td>{!! $persona->alias !!}</td>
                                            <td>{!! $persona->sexo !!}</td>
                                            <td>{!! $persona->fechaNacimiento !!}</td>
                                            <td class="text-primary text-center ">Persona entrevistada</td>
                                            <td class="text-center">
                                                @if(isset($no_editar))
                                                    <a href="{!! route('personas.show', [$persona->id_persona, $persona->id_e_ind_fvt])."?ficha_show=1" !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                                @else
                                                    {!! Form::open(['route' => ['personas.destroy', $persona->id_persona], 'method' => 'delete']) !!}
                                                    {!! Form::hidden('id_e_ind_fvt', $persona->id_e_ind_fvt) !!}
                                                    <div class='btn-group'>
                                                        <a href="{!! route('personas.show', [$persona->id_persona, $persona->id_e_ind_fvt]) !!}{{ isset($no_editar) ? '' : '?edicion=1' }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                                        <a href="{!! route('personas.edit', [$persona->id_persona, $persona->id_e_ind_fvt]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                                        @if($expediente->id_subserie != config('expedientes.aa'))
                                                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Desea borrar la persona entrevistada?')"]) !!}
                                                        @endif
                                                    </div>
                                                    {!! Form::close() !!}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($expediente->id_subserie != config('expedientes.aa'))

                                    {{-- Victimas --}}
                                    @php($personas = \App\Models\persona::listar_victimas_entrevista($expediente->id_e_ind_fvt))
                                    @php($i=1)
                                    @foreach($personas as $persona)
                                        <tr>
                                            <td> {{ $i++ }}</td>
                                            <td>{!! $persona->nombre !!}</td>
                                            <td>{!! $persona->apellido !!}</td>
                                            <td>{!! $persona->alias !!}</td>
                                            <td>{!! $persona->sexo !!}</td>
                                            <td>{!! $persona->fechaNacimiento !!}</td>
                                            <td class="text-primary text-center">Víctima {{ \App\Models\hecho_victima::where('id_victima',$persona->id_victima)->count() > 0 ? "" : "(hecho no especificado)" }}</td>
                                            <td class="text-center ">
                                                @if(isset($no_editar))
                                                    <a href="{!! route('victimas.show', [$persona->id_persona, $persona->id_e_ind_fvt])."?ficha_show=1" !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                                @else
                                                    {!! Form::open(['route' => ['victimas.destroy', $persona->id_persona], 'method' => 'delete']) !!}
                                                    {!! Form::hidden('id_e_ind_fvt', $persona->id_e_ind_fvt) !!}
                                                    <div class='btn-group'>
                                                        <a href="{!! route('victimas.show', [$persona->id_persona, $persona->id_e_ind_fvt]) !!}{{ isset($no_editar) ? '' : '?edicion=1' }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                                        <a href="{!! route('victimas.edit', [$persona->id_persona, $persona->id_e_ind_fvt]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Desea borrar la víctima?')"]) !!}
                                                    </div>
                                                    {!! Form::close() !!}
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            @if($conteos->entrevistado > 0 && $conteos->victimas > 0)
                                {{-- nO PASA NADA --}}
                            @else
                                <div class="col-sm-4">
                                    <div class="text-yellow text-center">
                                        <h4><i class="icon fa fa-warning"></i> Atención</h4>
                                        @if($conteos->entrevistado == 0)
                                            <p>No se ha diligenciado la información de la persona entrevistada</p>
                                        @elseif($conteos->victimas == 0)

                                            <p>No se ha diligenciado la información de la víctimas</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                    </div>

                    @if(isset($no_editar))
                        {{-- no mostrar botones de agregar --}}
                    @else
                        <div class="box-footer text-center">
                            @if($conteos->entrevistado == 0)
                                <a href="{{ url('personas/create')."?id_e_ind_fvt=$expediente->id_e_ind_fvt"  }}" class="btn btn-success"><i class="fa fa-comments"></i> Agregar persona entrevistada</a>
                            @else

                                @if($conteos->entrevistado == 0)
                                    <a href="{{ url('personas/create')."?id_e_ind_fvt=$expediente->id_e_ind_fvt"  }}" class="btn btn-success"><i class="fa fa-comments"></i> Información de la persona entrevistada</a>
                                @else
                                    @if($expediente->id_subserie != config('expedientes.aa'))
                                    <a href="{{ url('victimas/create')."?id_e_ind_fvt=$expediente->id_e_ind_fvt"  }}" class="btn btn-success"><i class="fa fa-users"></i> Agregar nuevas víctimas</a>
                                    @endif
                                @endif
                            @endif
                        </div>
                    @endif
            </div>
    </div>

    <div class="clearfix"></div>


        {{-- Fila 1a. (opcional) Repsonsables--}}
        @if($conteos->responsables > 0)
            <div class="col-sm-12">
                <div class="box {{ $conteos->responsables_pendientes > 0 ? 'box-warning' : ' box-success' }}">
                    <div class="box-header">
                        <h3 class="box-title">
                            <i class="fa fa-user-o"></i> 1a. Presuntos responsables individuales
                        </h3>
                    </div>
                    <div class="box-body table-responsive">
                        {{-- Responsables --}}
                        @php($personas = \App\Models\persona::listar_responsables_entrevista($expediente->id_e_ind_fvt))
                        <div class="table-responsive">
                            <table class="table" id="personas-table">
                                <thead>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Otros nombres</th>
                                    <th>Participación</th>
                                    <th colspan="3"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($personas as $persona)
                                    <tr>
                                        <td>{!! $persona->nombre !!}</td>
                                        <td>{!! $persona->apellido !!}</td>
                                        <td>{!! $persona->alias !!}</td>
                                        <td>
                                            @if(count($persona->responsable_hechos)==0)
                                                <span class="text-red">
                                                    Sin asignar
                                                </span>

                                            @else
                                                @foreach($persona->responsable_hechos as $responsabilidad)
                                                    <a href="{{ url('hechos/'.$responsabilidad->id_hecho."?edicion=1") }}" class="btn btn-sm btn-default"><i class="fa fa-user-circle"></i></a>
                                                @endforeach
                                            @endif

                                        </td>
                                        <td>
                                            {!! Form::open(['route' => ['persona_responsable.destroy', $persona->id_persona], 'method' => 'delete']) !!}
                                            {!! Form::hidden('id_e_ind_fvt', $persona->id_e_ind_fvt) !!}

                                            <div class='btn-group'>
                                                <a href="{!! route('persona_responsable.show', [$persona->id_persona, $persona->id_e_ind_fvt]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                                <a href="{!! route('persona_responsable.edit', [$persona->id_persona, $persona->id_e_ind_fvt]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Desea borrar el responsable?')"]) !!}

                                            </div>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="clearfix"></div>
        @if($expediente->id_subserie == config('expedientes.aa'))

    {{-- FILA 2: Pertenencia Actor Armado - Vida intrafila --}}

    {{-- Pertenencia Actor Armado --}}
    <div class="col-sm-12">
        <div class="box {{ $conteos->color_hechos_box }}">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-comment"></i> 2. Pertenencia Actor Armado - Vida intrafila
                </h3>
            </div>
            <div class="box-body table-responsive">

                @if($conteos->hechos  > 0)
                    @php($hechos = \App\Models\hecho::where('id_e_ind_fvt',$expediente->id_e_ind_fvt)->ordenado()->get())
                        @include("entrevista_individuals.ficha_actorarmado_show_inline")
                    @else
                        <div class="text-yellow text-center">
                            <h4><i class="icon fa fa-warning"></i> Atención</h4>
                            No se ha ingresado ninguna ficha de pertenencia actor armado - vida intrafilas
                        </div>

                @endif
            </div>
            @if(isset($no_editar))
                {{-- no mostrar botones de agregar --}}
            @else
                <div class="box-footer text-center">


                    @if($conteos->victimas > 0)
                        <div class="text-center">
                            <a href="{{ action('hechoController@create') }}?id_e_ind_fvt={{$expediente->id_e_ind_fvt}}" class="btn btn-success"><i class="fa fa-sitemap"></i> Agregar pertenencia actor armado</a>

                        </div>
                    @else
                        <div class="text-center">
                            <button class="btn btn-default " disabled><i class="fa fa-hand-o-right"></i> Debe completar primero la ficha de persona entrevistada</button>
                        </div>
                    @endif

                </div>
            @endif
        </div>
    </div>
@endif
    {{-- FILA 2: hechos y violaciones --}}


    @can('revisar-m-nivel',[[1,2,10,11]])
        {{-- Hechos --}}
        <div class="col-sm-12">
            <div class="box {{ $conteos->color_hechos_box }}">
                <div class="box-header">
                    <h3 class="box-title">
                        <i class="fa fa-comment"></i> 2. Hechos y tipos de violencia
                    </h3>
                </div>
                <div class="box-body table-responsive">

                    @if($conteos->hechos  > 0)
                        @php($hechos = \App\Models\hecho::where('id_e_ind_fvt',$expediente->id_e_ind_fvt)->ordenado()->get())
                            @include("hechos.table")
                        @else
                            <div class="text-yellow text-center">
                                <h4><i class="icon fa fa-warning"></i> Atención</h4>
                                No se ha ingresado ninguna ficha de hechos
                            </div>

                    @endif
                </div>
                @if(isset($no_editar))
                    {{-- no mostrar botones de agregar --}}
                @else
                    <div class="box-footer text-center">
                      @if($expediente->id_subserie == config('expedientes.aa'))
                      <div class="text-center">
                          <a href="{{ action('hechoController@create') }}?id_e_ind_fvt={{$expediente->id_e_ind_fvt}}" class="btn btn-success"><i class="fa fa-sitemap"></i> Agregar pertenencia actor armado</a>

                      </div>
                      @else
                        @if($conteos->victimas > 0)
                            <div class="text-center">
                                <a href="{{ action('hechoController@create') }}?id_e_ind_fvt={{$expediente->id_e_ind_fvt}}" class="btn btn-success"><i class="fa fa-sitemap"></i> Agregar hechos</a>

                            </div>
                        @else
                            <div class="text-center">
                                <button class="btn btn-default " disabled><i class="fa fa-hand-o-right"></i> Debe completar primero al menos una ficha de víctima</button>
                            </div>
                        @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="col-sm-12">
            <div class="box box-default box-solid">
                <div class="box-header">
                    <h3 class="box-title">
                        <i class="fa fa-comment"></i> 2. Hechos y tipos de violencia
                    </h3>
                </div>
                <div class="box-body text-center">
                    <h4 class="text-muted">Esta sección será completada por personal del Sistema de Información Misional</h4>
                </div>
            </div>
        </div>
    @endcan
    <div class="clearfix"></div>



    {{-- EXILIO --}}
    @include('hechos.p_exilio')





    {{-- FILA 4: Impactos, afrontamientos, acceso a la justicia --}}
    @if(isset($no_editar))
            <div class="col-sm-12">
                <div class="box {{ $conteos->impactos == 0 ? 'box-danger' : 'box-success' }}">
                    <div class="box-header collapsed-box">
                        <h3 class="box-title">
                            <i class="fa fa-street-view"></i> 3. Impactos de los hechos, afrontamientos, acceso a la justicia
                        </h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>

                    </div>
                    <div class="box-body no-padding">
                        @include("entrevista_individuals.ficha_impactos_show_inline")
                    </div>
                </div>
            </div>
    @else
        <div class="col-sm-12">
            <div class="box {{ $conteos->impactos == 0 ? 'box-danger' : 'box-success' }}">
                <div class="box-header">
                    <h3 class="box-title">
                        <i class="fa fa-street-view"></i> 3. Impactos de los hechos, afrontamientos, acceso a la justicia
                    </h3>
                </div>
                <div class="box-body">
                    @if($conteos->impactos==0)
                        <div class="text-yellow text-center">
                            <h4><i class="icon fa fa-warning"></i> Atención</h4>
                            No se ha completado la información de impactos
                        </div>
                    @else
                        @include('entrevista_individuals.p_ficha_impactos_mini')
                    @endif
                </div>
                <div class="box-footer text-center">
                    @if(isset($no_editar))
                        @if($conteos->impactos>0)
                            <a href="{{ action('entrevista_impactoController@show',$expediente->id_e_ind_fvt)}}" class="btn btn-success"><i class="fa fa-eye"></i> Ver información de impactos</a>
                        @endif
                    @else
                        @if($conteos->impactos==0)
                            <a href="{{ action('entrevista_impactoController@especificar',$expediente->id_e_ind_fvt)}}" class="btn btn-success"><i class="fa fa-users"></i> Agregar información de impactos</a>
                        @else
                            <a href="{{ action('entrevista_impactoController@show',$expediente->id_e_ind_fvt)}}" class="btn btn-success"><i class="fa fa-eye"></i> Ver información de impactos</a>
                            <a href="{{ action('entrevista_impactoController@especificar',$expediente->id_e_ind_fvt)}}" class="btn btn-default"><i class="fa fa-edit"></i> Modificar información de impactos</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endif






    {{-- Comentarios de la diligenciada --}}
        @if($expediente->observaciones_diligenciada)
            <div class="col-xs-12">
                <span class="text-primary text-bold">Anotaciones: </span> {{ $expediente->observaciones_diligenciada }}
            </div>
        @endif

    <div class="col-xs-12">
        @if(isset($no_editar))

        @else
            <div class="text-center">
                <button class="btn btn-primary" onclick="$('#modal_comentarios').modal('show')">{{ $expediente->observaciones_diligenciada ? "Modificar" : "Agregar" }}  comentarios del proceso de diligenciamiento</button>
                <br>
            </div>
        @endif
    </div>







    {{-- Fila 5: Time line --}}
    <div class="clearfix"></div>
    @if(!isset($no_editar))
        <div class="row">
            <div class="col-sm-12">
                @include("hechos.timeline")
            </div>
        </div>
    @endif
    <div class="clearfix"></div>


        {{-- AGERGAR COMENTARIOS --}}
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_comentarios">
            <div class="modal-dialog " role="document">
                {!! Form::open(['action' => ['entrevista_individualController@grabar_comentarios']]) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Comentarios del ejercicio de diligenciar las fichas</h4>
                    </div>

                    <input type="hidden" name="id_e_ind_fvt" value="{{ $expediente->id_e_ind_fvt }}">
                    <div class="modal-body">
                        <div class="form-group col-xs-12">
                            {!! Form::label('observaciones_diligenciada', 'Comentarios del usuario:') !!}
                            {!! Form::textarea('observaciones_diligenciada', $expediente->observaciones_diligenciada, ['class' => 'form-control','rows'=>'3']) !!}

                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" >Grabar comentarios</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div><!-- /.modal-content -->
                {!! Form::close() !!}
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->



    <div class="modal fade" id="buscar_duplicados" tabindex="-1" role="dialog" aria-labelledby="buscar_duplicados" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buscador de víctimas</h5>
                <button type="button" class="cerrar_duplicados close"  data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

                {!! Form::open(['route' => 'victimas.buscar_duplicado', 'id'=>'form-buscar-duplicados']) !!}
                <div id="s-form-campos">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                {!! Form::label('nombre', 'Nombres') !!}
                                {!! Form::text('nombre', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('apellido', 'Apellidos') !!}
                                {!! Form::text('apellido', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                {!! Form::label('num_documento', 'Número de documento') !!}
                                {!! Form::number('num_documento', null, ['class' => 'form-control', 'maxlength' => 20]) !!}
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('alias', 'Alias') !!}
                                {!! Form::text('alias', null, ['class' => 'form-control', 'maxlength' => 200]) !!}
                            </div>

                            <div class="form-group col-sm-12">
                                @include('controles.fecha_incompleta', ['control_control' => 'fec_nac'
                                                                    , 'control_vacio' => '[Ninguno]'
                                                                    , 'control_texto'=>'Fecha de nacimiento'])
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cerrar_duplicados" data-dismiss="modal">Cerrar</button>
                        <a href="{{ url('victimas/create')."?id_e_ind_fvt=$expediente->id_e_ind_fvt"  }}" style="display:none" id="btn_vic_no_encontrada" class="btn btn-primary">Víctima no encontrada</a>
                    <button type="button" id="buscar_duplicados" onclick="fbuscar_duplicados('{{$expediente->id_e_ind_fvt}}')" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
                {!! Form::close() !!}

                <div id="s-resultado-busqueda">

                </div>

            </div>
          </div>
      </div>


@endsection

@push("js")
    <script src="{{ asset('js/validar_persona.js') }}"></script>
    <script>
        $(function(){
            //$('[data-toggle="push-menu"]').pushMenu('toggle');

            $(".cerrar_duplicados").click(function(){
                $("#nombre").val("");
                $("#apellido").val("");
                $("#num_documento").val("");
                $("#alias").val("");

                $("#fec_nac_d").val('00');
                $("#fec_nac_d").trigger('change');

                $("#fec_nac_m").val('00');
                $("#fec_nac_m").trigger('change');

                $("#s-resultado-busqueda").html("");
                $("#btn_vic_no_encontrada").hide(500);
            });

        });

       function fbuscar_duplicados(id_e_ind_fvt){

            this.quitar_comentarios_minimos();

           if(!this.datos_minimos_buscar_duplicados()) return false;

           var param = $('#form-buscar-duplicados').serialize();

           $.ajax({
               type:'post',
               url: '{{route('victimas.buscar_duplicado')}}',
               data:param+"&id_e_ind_fvt="+id_e_ind_fvt,
               success:function(datos){
                    $("#s-resultado-busqueda").html(datos);
                    $("#btn_vic_no_encontrada").show(500);
                    //$("#s-form-campos").hide(200);
               }
           });
       }

       function datos_minimos_buscar_duplicados() {

            var respuesta = true;
            if (esVacio($("#num_documento").val())) {

                if (esVacio($("#nombre").val())) {

                    $('#nombre').parent().addClass('has-error');
                    $('#nombre').parent().find('.help-block').html('Obligatorio.');
                    respuesta = false;
                }

                if (esVacio($("#apellido").val())) {
                    $('#apellido').parent().addClass('has-error');
                    $('#apellido').parent().find('.help-block').html('Obligatorio.');
                    respuesta = false;
                }

            } else if(minimoCaracteres($("#num_documento").val(), 5)) {
                $('#num_documento').parent().addClass('has-error');
                $('#num_documento').parent().find('.help-block').html('Mínimo 5 caracteres.');
                respuesta = false;
            }

            return respuesta;
       }

       function quitar_comentarios_minimos() {
            $("#nombre").parent().removeClass("has-error");
            $('#nombre').parent().find('.help-block').html('');
            $("#apellido").parent().removeClass("has-error");
            $('#apellido').parent().find('.help-block').html('');
            $("#num_documento").parent().removeClass("has-error");
            $('#num_documento').parent().find('.help-block').html('');
       }
    </script>
@endpush
