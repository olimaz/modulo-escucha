@extends('layouts.app')

@section('content_header')
    <h1>
        Consentimiento informado, entrevista <a href="{{ action('entrevista_profundidadController@show',$entrevista->id_entrevista_profundidad) }}">{{ $entrevista->entrevista_codigo }}</a>
    </h1>
@endsection

@section('content')

    @include('adminlte-templates::common.errors')

    {!! Form::model($consentimiento,['action' => ['entrevistaController@crear_actualizar_ci',$entrevista->id_entrevista_profundidad]]) !!}
    {!! Form::hidden('id_entrevista_profundidad',$entrevista->id_entrevista_profundidad) !!}

        @include('partials.consentimiento')


    {!! Form::close() !!}

    <div class="box box-info box-solid">
        <div class="box-header">
            <h3 class="box-title">
                Información de la entrevista {{ $entrevista->entrevista_codigo }}
            </h3>

        </div>
        <div class="box-body">
            @include("entrevista_profundidads.show_fields")
        </div>
    </div>

@endsection
