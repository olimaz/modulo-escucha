@extends('layouts.app')


@section('content_header')
    <h1 class="page-title">
        Autorizar el acceso a los archivos adjuntos de una  entrevista R-2 o R-3
    </h1>
@endsection

@section('content')
    @include('historia_vidas.tabla_accesos')

    <h1 class="page-title">
        (#{!! $historiaVida->entrevista_correlativo !!}) {!! $historiaVida->entrevista_codigo !!} <small> Historia de vida [R-{{ $historiaVida->clasificacion_nivel }}]</small>
    </h1>

    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body">
            @include('historia_vidas.show_fields')
        </div>
    </div>



@endsection