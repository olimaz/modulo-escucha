@extends('layouts.app')

@section('content_header')
    @include("etiquetar_asignacions.frm_filtros")
@endsection
@section('content')
    <h1 >Asignación de etiquetado <small>{{ $etiquetarAsignacions->total() }} asignaciones.   <a  class='btn btn-default  ' target="_blank" href="{{ substr(env('TURK_URL'),0,strpos(env('TURK_URL'),'/dtAPI/')) }}"><i class="fa fa-external-link" aria-hidden="true"></i> Interfaz de etiquetado</a></small>


    </h1>

    <a class='btn btn-info btn-xs pull-right' href="#" id="b_tabla_datos"><i class="fa fa-download" aria-hidden="true"></i> Exportar a excel</a>


    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            @include('etiquetar_asignacions.table')
        </div>
    </div>
    <div class="text-center">
        <div class="no-print">
            {!! $etiquetarAsignacions->appends(Request::all())->render() !!}
        </div>

    </div>

@endsection

