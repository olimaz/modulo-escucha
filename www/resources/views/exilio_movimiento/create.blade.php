@extends('layouts.app')
@include('layouts.js_contrae')
@section('content_header')
    <h1 class="page-header">
        Nuevo: {{ \App\Models\criterio_fijo::describir(30,$movimiento->id_tipo_movimiento) }}. {{ $expediente->entrevista_codigo }}
        <div class="pull-right">
            <a href="{!! action('exilioController@show',$exilio->id_exilio) !!}" class="btn btn-default">Cancelar y volver</a>
        </div>
    </h1>
@endsection
@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::model($movimiento,['action' => ['exilio_movimientoController@store',$exilio->id_exilio]]) !!}
                        <input type="hidden" name="id_exilio" value="{{ $exilio->id_exilio }}">
                        <input type="hidden" name="id_tipo_movimiento" value="{{ $movimiento->id_tipo_movimiento }}">


                        @include('exilio_movimiento.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
