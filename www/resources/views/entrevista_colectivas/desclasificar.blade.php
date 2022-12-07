@extends('layouts.app')


@section('content_header')
    <h1 class="page-title">
        Autorizar el acceso a los archivos adjuntos de una  entrevista R-2 o R-3
    </h1>
@endsection

@section('content')
    @include('entrevista_colectivas.tabla_accesos')

    <h1 class="page-title">
        (#{!! $entrevistaColectiva->entrevista_correlativo !!}) {!! $entrevistaColectiva->entrevista_codigo !!} <small> Entrevista colectiva [R-{{ $entrevistaColectiva->clasificacion_nivel }}]</small>
    </h1>

    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body">
            @include('entrevista_colectivas.show_fields')
        </div>
    </div>



@endsection