@extends('layouts.app')

@section('content_header')

    <h1 class="page-header">
        Gestión de archivos adjuntos,  <a href=" {{ action('entrevista_individualController@show',$entrevistaIndividual->id_e_ind_fvt) }}">Entrevista  {!! $entrevistaIndividual->entrevista_codigo !!}  </a><small># {!! $entrevistaIndividual->entrevista_correlativo !!}</small>
    </h1>

    @if($entrevistaIndividual->id_subserie == config('expedientes.vi'))
        <ol class="breadcrumb">
            <li ><a href="{{ action('entrevista_individualController@edit',$entrevistaIndividual->id_e_ind_fvt) }}"> 1. Metadatos</a></li>
            <li class="active"> 2. <i class="fa fa-paperclip"></i> Adjuntos</li>
            <li><a href="{{ action('entrevista_individualController@fichas',$entrevistaIndividual->id_e_ind_fvt) }}">3. Fichas</a></li>
        </ol>
    @endif
@endsection



@section('content')
    <div class="row">
        <div class="col-xs-12" id="div_tabla_adjuntos">
            @include("entrevista_individuals.tabla_adjuntos")
        </div>
    </div>

    {{-- Boton morado para diligenciar fichas --}}
    @if($entrevistaIndividual->id_subserie == config('expedientes.vi'))
        <div class="row">
            <div class="col-xs-12 text-center">
                <div id="btn_no" class="hidden">
                    <button class="btn btn-lg  bg-purple" disabled title="Por favor, adjunte el consentimiento informado." data-toggle="tooltip"><i class="fa fa-send-o"></i> Diligenciar ficha digital </button>
                </div>
                <div id="btn_si"  class="hidden">
                    <a href="{{ action('entrevista_individualController@fichas',$entrevistaIndividual->id_e_ind_fvt) }}" class="btn btn-lg  bg-purple"><i class="fa fa-send-o"></i> Diligenciar ficha digital </a>
                </div>
            </div>
        </div>
        <br>
    @endif



    <div class="box box-primary box-solid">
        <div class="box-header ">
            <h3 class="box-title"> Adjuntar archivos </h3>
        </div>
        <div class="box-body">

            {!! Form::open( ['action' => ['entrevista_individualController@agregar_adjuntos', $entrevistaIndividual->id_e_ind_fvt]]) !!}
                @include("entrevista_individuals.adjuntos_otros")
                <a href="{{ action("entrevista_individualController@index") }}" class="btn btn-default">Cancelar</a>
               {{--
                {!! Form::submit('Actualizar expediente', ['class' => 'btn btn-primary pull-right','id'=>'btn_grabar']) !!}
                --}}

            {!! Form::close() !!}
        </div>

    </div>






    <div class="box box-info  collapsed-box box-solid">
        <div class="box-header ">
            <h3 class="box-title"> Detalles de la entrevista: {!! $entrevistaIndividual->entrevista_codigo !!}</h3>

                <div class="box-tools pull-right">
                    @if($entrevistaIndividual->nna == 1)
                        <span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="Entrevista a niño, niña o adolescente">NNA</span>
                    @endif
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>

        </div>
        <div class="box-body">
            <div class="row" style="padding-left: 20px">
                @include('entrevista_individuals.show_fields')
                <a href="{!! route('entrevistaIndividuals.index') !!}" class="btn btn-default">Listado general</a>
            </div>
        </div>
    </div>

@endsection


@include("controles.js_cargar_adjuntar_generico",
                [
                    'id_primaria' => $entrevistaIndividual->id_e_ind_fvt,
                    'url_upload' => "upload_adjuntar",
                    'url_adjuntos' => "tabla_adjuntos",
                    //Para la traza de fallas
                    'codigo' => $entrevistaIndividual->entrevista_codigo
                ])


@push("js")
    <script>
        function transcribir(id) {
            var destino = "{{ url('/entrevistaIndividualAdjuntos/') }}/"+id+"/trans";
            $.ajax({
                url: destino,
                type: 'GET',
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    actualizar_tabla();

                },
                error: function (xhr, status, error) {
                    actualizar_tabla();
                }
            });
        }

        function transcribir_revisar(id) {
            var destino = "{{ url('/entrevistaIndividualAdjuntos/') }}/"+id+"/trans_revisar";
            $.ajax({
                url: destino,
                type: 'GET',
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if(data.transcrito) {
                        Swal.fire(
                            'Archivo transcrito exitosamente',
                            'El sistema ya adjuntó dicho archivo al expediente',
                            'success'
                        );
                        actualizar_tabla();

                    }
                    else {
                        Swal.fire(
                            'Archivo pendiente de transcribir',
                            'La tarea de transcripcion se encuentra en cola, su procesamiento no ha sido finalizado.'
                        );
                    }
                    //console.log(data.mensaje);
                    //console.log(data.detalle);
                },
                error: function (xhr, status, error) {
                    Swal.fire('Problemas al consultar el servicio.','Algo extraño pasó al revisar la tarea, favor de reportar este problema.','error');
                }
            });
        }
        $(function() {
            @if(empty($entrevistaIndividual->archivo_ci))
                @if($entrevistaIndividual->es_virtual==1)
                    $("#btn_si").removeClass('hidden');
                @else
                    $("#btn_no").removeClass('hidden');
                @endif
            @else
                $("#btn_si").removeClass('hidden');
            @endif
        });

    </script>

@endpush
