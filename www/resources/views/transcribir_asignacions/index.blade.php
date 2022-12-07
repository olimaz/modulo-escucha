@extends('layouts.app')

@section('content_header')
    @include("transcribir_asignacions.frm_filtros")
@endsection
@section('content')
        <h1 >Asignación de transcripciones <small>{{ $transcribirAsignacions->total() }} asignaciones</small>


        </h1>


            <a class='btn btn-info btn-xs pull-right' href="#" id="b_tabla_datos"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>



        {{--
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('transcribirAsignacions.create') !!}">Nueva Asignación</a>
        </h1>
        --}}


        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('transcribir_asignacions.table')
            </div>
        </div>
        <div class="text-center">
            <div class="no-print">
                {!! $transcribirAsignacions->appends(Request::all())->render() !!}
            </div>
        
        </div>

@endsection

