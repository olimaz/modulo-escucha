@php($colapsar_menu=true)
@php($flag_show=(isset($show) ? 1:0))
@extends('layouts.app')

@section('content_header')

        @if(isset($no_editar))
            <div class="col-xs-9">
                <h1 class="page-header">                    
                    Fichas diligenciadas - <a href="{{ action('entrevista_etnicaController@show',$expediente->id_entrevista_etnica) }}">Entrevista {{ $expediente->entrevista_codigo }}</a>
                </h1>
            </div>
            <div class="col-xs-3 text-right">
                <a href="{{ action('entrevista_etnicaController@index') }}" class="btn btn-default">Volver</a>
            </div>
        @else
        
            <h1 class="page-header">
                Diligenciar fichas - <a href="{{ action('entrevista_etnicaController@show',$expediente->id_entrevista_etnica) }}">Entrevista {{ $expediente->entrevista_codigo }}</a>                
            </h1>
            <ol class="breadcrumb">
                @if ($conteos->entrevista == 0)
                    <li><a href="{{ action('entrevista_etnicaController@edit',$expediente->id_entrevista_etnica) }}"> 
                        1. Metadatos
                        </a>
                    </li>
                @else
                    <li><a href="{{ action('entrevista_etnicaController@edit',$expediente->id_entrevista_etnica) }}"> 1. Metadatos</a></li>
                @endif
                
                <li><a href="{{ action('entrevista_etnicaController@gestionar_adjuntos',$expediente->id_entrevista_etnica) }}"> 2. Adjuntos</a></li>
                <li class="active"> 3. <i class="fa fa-send-o"></i> Fichas</li>
            </ol>
        @endif



@endsection

@section('content')

    {{-- FILA 0: alertas --}}
    @include("entrevista_etnicas.p_fichas_conteo")
    <div class="clearfix"></div>

    @if(isset($no_editar))
        <div class="row">
            <div class="col-sm-12">

                {{-- @include("hechos.timeline") --}}

            </div>
        </div>
        <br>
        <br>
    @endif
    <div class="clearfix"></div>

    {{-- FILA 1:Persona entrevistada y víctimas --}}



    
    <div class="col-xs-12">
        <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Autorizaciones</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
            <div class="box-body">
                
                <div class="col-sm-6">
                    <h4 class="text-primary">Consentimiento informado</h4>
                    <table class="table ">
                        <tbody>
                            {{-- <tr>
                                <td style="width:50%">Nombre de la autoridad étnica de la comunidad debidamente acreditado:</td>
                                <td>{{$entrevista->fmt_nombre_autoridad_etnica}}</td>
                            </tr>                    

                            <tr>
                                <td style="width:50%">Nombre identitario</td>
                                <td>{{$entrevista->fmt_nombre_identitario}} ({{$entrevista->fmt_id_pueblo_representado}})</td>
                            </tr>                                                 --}}

                            <tr>
                                <td>¿Está de acuerdo en conceder entrevistas a la Comisión de la Verdad?</td>
                                <td class="text-center">{{$entrevista->fmt_conceder_entrevista}}</td>
                            </tr>
                            <tr>
                                <td>¿Está de acuerdo en que la Comisión grabe el audio para la entrevista? </td>
                                <td class="text-center">{{$entrevista->fmt_grabar_audio}}</td>
                            </tr>
                            <tr>
                                <td>¿Está de acuerdo en que su entrevista sea utilizada para elaborar el informe Final? </td>
                                <td class="text-center">{{$entrevista->fmt_elaborar_informe}}</td>
                            </tr>

                            <tr>
                                <td>¿Está de acuerdo en que la Comisión grabe el video de la participación de la comunidad para la entrevista? </td>
                                <td class="text-center">{{$entrevista->fmt_grabar_video}}</td>
                            </tr>
                            <tr>
                                <td> 
                                    ¿Está de acuerdo en que la Comisión tome fotografías de la participación de la comunidad para la entrevista?
                                </td>
                                <td class="text-center">{{$entrevista->fmt_tomar_fotografia}}</td>
                            </tr>                                                            
                        </tbody>
                    </table>

                </div>


                <div class="col-sm-6">
                        <h4 class="text-primary">Tratamiento de datos personales</h4>
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>¿Autoriza el tratamiento de sus datos para las siguientes finalidades?</th>
                                    <th>Datos personales</th>
                                    <th>Datos sensibles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Analizarlos, compararlos, contrastarlos con otros datos e información recolectada.</td>
                                    <td class="text-center">{{$entrevista->fmt_tratamiento_datos_analizar}}</td>
                                    <td class="text-center">{{$entrevista->fmt_tratamiento_datos_analizar_sensible}}</td>
                                </tr>
                                <tr>
                                    <td>Utilizarlos para la elaboración del informe Final de la Comisión de la Verdad.</td>
                                    <td class="text-center">{{$entrevista->fmt_tratamiento_datos_utilizar}}</td>
                                    <td class="text-center">{{$entrevista->fmt_tratamiento_datos_utilizar_sensible}}</td>
                                </tr>
                                <tr>
                                    <td>Publicar su nombre en el informe Final.</td>
                                    <td class="text-center">{{$entrevista->fmt_tratamiento_datos_publicar}}</td>
                                    <td class="text-center">-</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>                

            </div>

            @if (!isset($show))
                <div class="box-footer text-center" style="">
                    <a href="{{ action('entrevista_etnicaController@edit',$expediente->id_entrevista_etnica) }}?m_aut" class="btn btn-success">Modificar las autorizaciones</a>
                </div>                
            @endif


        </div>
    </div>

    <div class="clearfix"></div>

        {{-- Fila 1a. (opcional) Repsonsables--}}
        @if($conteos->responsables > 0 && $conteos->hechos > 0)
            <div class="col-sm-12">
                <div class="box {{ $conteos->responsables_pendientes > 0 ? 'box-warning' : ' box-success' }}">
                    <div class="box-header">
                        <h3 class="box-title">
                            <i class="fa fa-user-o"></i> 1a. Presuntos responsables individuales
                        </h3>
                    </div>
                    <div class="box-body table-responsive">
                        {{-- Responsables --}}
                        {{-- @php($personas = \App\Models\persona::listar_responsables_entrevista($expediente->id_e_ind_fvt)) --}}
                        @php($personas = \App\Models\persona::listar_responsables_entrevista_etnica($expediente->id_entrevista_etnica))
                        
                        <div class="table-responsive">
                            <table class="table" id="personas-table">
                                <thead>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Otros nombres</th>
                                    {{-- <th>Participación</th> --}}
                                    <th colspan="3"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($personas as $persona)
                                    <tr>
                                        <td>{!! $persona->nombre !!}</td>
                                        <td>{!! $persona->apellido !!}</td>
                                        <td>{!! $persona->alias !!}</td>
                                        {{-- <td>
                                            @if(count($persona->responsable_hechos)==0)
                                                <span class="text-red">
                                                    Sin asignar
                                                </span>

                                            @else
                                                @foreach($persona->responsable_hechos as $responsabilidad)
                                                    <a href="{{ url('hechos/'.$responsabilidad->id_hecho."?edicion=1") }}" class="btn btn-sm btn-default"><i class="fa fa-user-circle"></i></a>
                                                @endforeach
                                            @endif

                                        </td> --}}
                                        <td>
                                            {!! Form::open(['route' => ['persona_responsable.destroy', $persona->id_persona], 'method' => 'delete']) !!}
                                            {!! Form::hidden('id_entrevista_etnica', $persona->id_entrevista_etnica) !!}

                                            <div class='btn-group'>
                                                    
                                                @if (!isset($show))
                                                    <a href="{!! route('persona_responsable.show', [$persona->id_persona, $persona->id_entrevista_etnica]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>    
                                                @else
                                                    <a href="{!! route('persona_responsable.show', [$persona->id_persona, $persona->id_entrevista_etnica]) !!}?fs" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                                @endif
                                                

                                                @if (!isset($show))
                                                    <a href="{!! route('persona_responsable.edit', [$persona->id_persona, $persona->id_entrevista_etnica]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Desea borrar el responsable?')"]) !!}                                                    
                                                @endif


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
                        @php($hechos = \App\Models\hecho::where('id_entrevista_etnica',$expediente->id_entrevista_etnica)->ordenado()->get())
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
                        {{-- @if($conteos->victimas > 0) --}}

                        @if ($conteos->hechos == 0) 
                            @if (!isset($show))
                                <div class="text-center">
                                    <a href="{{ action('hechoController@create') }}?id_entrevista_etnica={{$expediente->id_entrevista_etnica}}" class="btn btn-success"><i class="fa fa-sitemap"></i> Agregar hecho</a>
                                </div>                                                    
                            @endif
                        @endif

                        {{-- @else
                            <div class="text-center">
                                <button class="btn btn-default " disabled><i class="fa fa-hand-o-right"></i> Debe completar primero al menos una ficha de víctima</button>
                            </div>
                        @endif --}}
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




    {{-- FILA 4: Impactos, afrontamientos, acceso a la justicia --}}
    @if(isset($no_editar))
            <div class="col-sm-12">
                <div class="box {{ $conteos->impactos == 0 ? 'box-danger' : 'box-success' }}">
                    <div class="box-header collapsed-box">
                        <h3 class="box-title">
                            <i class="fa fa-street-view"></i> 3. Impactos de los hechos, afrontamientos, acceso a la justicia 1
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
                            <a href="{{ action('entrevista_impactoController@show',$expediente->id_entrevista_etnica)}}" class="btn btn-success"><i class="fa fa-eye"></i> Ver información de impactos</a>
                        @endif
                    @else
                        @if($conteos->impactos==0)
                            {{-- <a href="{{ action('entrevista_impactoController@especificar',$expediente->id_e_ind_fvt)}}" class="btn btn-success"><i class="fa fa-users"></i> Agregar información de impactos</a> --}}
                            <a href="{{ action('entrevista_impactoController@especificar',$expediente->id_entrevista_etnica)}}?tipo=etnica" class="btn btn-success"><i class="fa fa-users"></i> Agregar información de impactos</a>
                        @else
                            <a href="{{ action('entrevista_impactoController@show',$expediente->id_entrevista_etnica)}}?tipo=etnica" class="btn btn-success"><i class="fa fa-eye"></i> Ver información de impactos</a>
                            <a href="{{ action('entrevista_impactoController@especificar',$expediente->id_entrevista_etnica)}}?tipo=etnica" class="btn btn-default"><i class="fa fa-edit"></i> Modificar información de impactos</a>
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
                {{-- @include("hechos.timeline") --}}
            </div>
        </div>
    @endif
    <div class="clearfix"></div>


        {{-- AGERGAR COMENTARIOS --}}
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_comentarios">
            <div class="modal-dialog " role="document">
                {!! Form::open(['action' => ['entrevista_etnicaController@grabar_comentarios']]) !!}                
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Comentarios del ejercicio de diligenciar las fichas</h4>
                    </div>

                    <input type="hidden" name="id_entrevista_etnica" value="{{ $expediente->id_entrevista_etnica }}">
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