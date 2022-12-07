@extends('layouts.app')
@section('content_header')
    <h1>
        Censo de archivos en el exilio: nuevo registro
    </h1>
@endsection

@section('content')

        @include('adminlte-templates::common.errors')

                    {!! Form::model($censoArchivos,['route' => 'censoArchivos.store']) !!}

                        @include('censo_archivos.fields')

                    {!! Form::close() !!}

    <div class="clearfix"></div>
@endsection
