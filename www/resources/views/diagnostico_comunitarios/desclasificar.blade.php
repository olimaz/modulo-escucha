@extends('layouts.app')


@section('content_header')
    <h1 class="page-title">
        Autorizar el acceso a los archivos adjuntos de una  entrevista R-2 o R-3
    </h1>
@endsection

@section('content')
    @include('diagnostico_comunitarios.tabla_accesos')

    <h1 class="page-title">
        (#{!! $diagnosticoComunitario->entrevista_correlativo !!}) {!! $diagnosticoComunitario->entrevista_codigo !!} <small> Diagnóstico comunitario [R-{{ $diagnosticoComunitario->clasificacion_nivel }}]</small>
    </h1>

    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body">
            @include('diagnostico_comunitarios.show_fields')
        </div>
    </div>



@endsection