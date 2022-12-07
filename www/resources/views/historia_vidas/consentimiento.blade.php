@extends('layouts.app')

@section('content_header')
    <h1>
        Consentimiento informado, historia de vida <a href="{{ action('historia_vidaController@show',$entrevista->id_historia_vida) }}">{{ $entrevista->entrevista_codigo }}</a>
    </h1>
@endsection

@section('content')

    @include('adminlte-templates::common.errors')

    {!! Form::model($consentimiento,['action' => ['entrevistaController@crear_actualizar_ci',$entrevista->id_historia_vida]]) !!}
    {!! Form::hidden('id_historia_vida',$entrevista->id_historia_vida) !!}

        @include('partials.consentimiento')


    {!! Form::close() !!}

    <div class="box box-info box-solid">
        <div class="box-header">
            <h3 class="box-title">
                Información de la entrevista {{ $entrevista->entrevista_codigo }}
            </h3>

        </div>
        <div class="box-body">
            @include("historia_vidas.show_fields")
        </div>
    </div>

@endsection
