@extends('layouts.app')
@section('content_header')
    <h1 class="page-header">
        Impactos y afrontamientos específicos del exilio. {{ $expediente->entrevista_codigo }}
        <div class="pull-right">
            <a href="{{ action('exilioController@show',$exilio->id_exilio) }}" class="btn btn-default">Volver</a>
        </div>
    </h1>
@endsection
@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::model($exilio,['action' => ['exilio_impactoController@update',$exilio->id_exilio], 'method' => 'patch']) !!}
                    <input type="hidden" name="id_exilio" value="{{ $exilio->id_exilio }}">
                    @include('exilio_impacto.fields')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
