@extends('layouts.app')
@section('content_header')
    <h1>
        Modificar registro de censo de archivos: {{ $censoArchivos->entrevista_codigo }}
    </h1>
@endsection


@section('content')

       @include('adminlte-templates::common.errors')

                   {!! Form::model($censoArchivos, ['route' => ['censoArchivos.update', $censoArchivos->id_censo_archivos], 'method' => 'patch','id'=>'frm_adjunto','files' => true]) !!}

                        @include('censo_archivos.fields')

                   {!! Form::close() !!}
    <div class="clearfix"></div>

@endsection