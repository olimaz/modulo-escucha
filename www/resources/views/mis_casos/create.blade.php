@extends('layouts.app')

@section('content_header')
    <h1>
        Crear nuevo caso transversal
    </h1>
@endsection

@section('content')

        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($miCaso,['route' => 'misCasos.store','id'=>'frm_abc']) !!}

                        @include('mis_casos.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

@endsection
