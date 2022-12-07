@extends('layouts.app')
@section('content_header')
    @include('entrevista_prioridad.filtros')
@endsection
@section('content')

        <h3 >
            Asignación de entrevistas a procesar
            <small>Todas tienen consentimiento y audio, ordenadas por prioridad. -{{ count($listado) }} en total- </small>

        </h3>



        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body table-responsive">
                    @include('entrevista_prioridad.table')
            </div>
        </div>

@endsection

