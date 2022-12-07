@extends('layouts.app')
@section('content_header')
    <ol class="breadcrumb">
        <li class="active"> 1. <i class="fa fa-folder-open-o"></i> Metadatos</li>
        <li>2. Adjuntos</li>
        <li>3. Fichas</li>
    </ol>
    <div class="clearfix"></div><br>
    <h1 class="page-header">
        Nueva: {{ \App\Models\cat_item::find($entrevistaIndividual->id_subserie)->descripcion }}
        <small class="text-primary">
            {{ \App\Models\entrevistador::find($entrevistaIndividual->id_entrevistador)->fmt_numero_nombre }}
        </small>
    </h1>

@endsection
@section('content')

    <div class="content">
        @include('adminlte-templates::common.errors')
        {!! Form::model($entrevistaIndividual,['route' => 'entrevistaIndividuals.store','id'=>'frm_nuevo','autocomplete'=>'off']) !!}
        @include('entrevista_individuals.fields_concentimiento')

<div id='ocultar_entrevista'>

        <div class="box box-primary">

            <div class="box-body">
                <div class="row">

                        {{--
                        @include('entrevista_individuals.adjuntos')
                        <div class="col-xs-12 text-purple text-center">
                            <i class="fa fa-cog fa-spin  fa-fw"></i> Si fuera necesario, puede anexar más archivos después de grabar el expediente.
                        </div>

                        <hr>
                        --}}
                          @include('entrevista_individuals.fields')
                          @include('entrevista_individuals.fields_especs')
                          @include('partials.clasificacion_r1')
                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Grabar entrevista', ['class' => 'btn btn-primary','id'=>'btn_grabar']) !!}
                            <a href="{!! route('entrevistaIndividuals.index') !!}" class="btn btn-default">Cancelar</a>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
              </div>
        </div>
    </div>

    @include("entrevista_individuals.paciencia")
@endsection


@push('js')
    <script>
        $('#frm_nuevo').submit(function() {
            var pendientes = false;
            {{--
            if($("#archivo_1_filename").val().length < 1) {
                pendiente = true;
            }
            if($("#archivo_2_filename").val().length < 1) {
                pendiente = true;
            }
            if($("#archivo_3_filename").val().length < 1) {
                pendiente = true;
            }
            if($("#archivo_5_filename").val().length < 1) {
                pendiente = true;
            }
            --}}

            var grabar=false;
            if(pendiente) {
                if(confirm("No cargó todos los archivos, ¿Desea grabar aunque falte cargar algunos archivos?")) {
                    grabar=true;
                }
                else {
                    grabar = false;
                }
            }
            else {
                grabar = true;
            }

            if(grabar) {
                $("#modal_paciencia").modal({backdrop: 'static', keyboard: false});
                return true;
            }
            else {
                return false;
            }


        });
    </script>
@endpush
