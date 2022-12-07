@extends('layouts.app')

@section('content_header')
    <h1 class="page-title">
        {{ $entrevista->entrevista_codigo }} - Nueva: Ficha de hechos y tipos de violencia
        <div class="pull-right">
            <a href="{!! action('entrevista_individualController@fichas',$hecho->id_e_ind_fvt) !!}" class="btn btn-default pull-right">Cancelar y volver</a>
        </div>
    </h1>
@endsection

@section('content')
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::model($hecho,['route' => 'hechos.store']) !!}
                        {!! Form::hidden('id_e_ind_fvt',$hecho->id_e_ind_fvt) !!}

                        @include('hechos.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
@endsection
