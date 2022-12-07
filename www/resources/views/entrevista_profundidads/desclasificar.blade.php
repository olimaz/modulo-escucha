@extends('layouts.app')


@section('content_header')
    <h1 class="page-title">
        Autorizar el acceso a los archivos adjuntos de una  entrevista R-2 o R-3
    </h1>
@endsection

@section('content')
    @include('entrevista_profundidads.tabla_accesos')

    <h1 class="page-title">
        (#{!! $entrevistaProfundidad->entrevista_correlativo !!}) {!! $entrevistaProfundidad->entrevista_codigo !!} <small> Entrevista a profundidad [R-{{ $entrevistaProfundidad->clasificacion_nivel }}]</small>
    </h1>

    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body">
            @include('entrevista_profundidads.show_fields')
        </div>
    </div>



@endsection