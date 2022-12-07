@extends('layouts.app')
@section('content_header')
    <h1>
        Registro de archivo en el exilio: {{ $censoArchivos->entrevista_codigo }}
    </h1>
    <a href="{{ route('censoArchivos.index') }}" class="btn btn-default pull-right">Volver al listado</a>
    <div class="clearfix"></div>
@endsection

@section('content')

        @include('censo_archivos.show_fields')




@endsection
