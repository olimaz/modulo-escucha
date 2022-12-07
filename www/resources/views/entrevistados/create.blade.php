@extends('layouts.app')

@section('content_header')
        <h1>
            Datos de la persona entrevistada
        </h1>
@endsection
@section('content')

    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::model($entrevistado,['action' => ['entrevistadoController@store',$expediente->id_e_ind_fvt]]) !!}
                        @include('entrevistados.fields')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
