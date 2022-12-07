@extends('layouts.app')

@section('content_header')
    @include("desclasificars.frm_filtros")
@endsection
@section('content')
    <h1 class="pull-left">Desclasificación de archivos adjuntos a instrumentos</h1>
    @can('sistema-abierto')
    <h1 class="pull-right">
        <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{{ route('desclasificars.create') }}">Nuevo permiso</a>
    </h1>
    @endcan

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('desclasificars.table')
            </div>
        </div>
        <div class="text-center">
            <div class="no-print">
                {!! $desclasificars->appends(Request::all())->render() !!}
            </div>
        </div>

@endsection

