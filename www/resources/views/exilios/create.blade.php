@extends('layouts.app')
@include('layouts.js_contrae')
@section('content_header')
    <h1 class="page-header">
        Nueva: Ficha de exilio. {{ $expediente->entrevista_codigo }}
        <div class="pull-right">
            @if($id_hecho <= 0)
                <a href="{!! action('entrevista_individualController@fichas',$expediente->id_e_ind_fvt) !!}" class="btn btn-default">Cancelar y volver</a>
            @else
                <a href="{!! action('hechoController@edit',$id_hecho) !!}" class="btn btn-default">Cancelar y volver</a>
            @endif
        </div>
    </h1>
@endsection
@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::model($exilio,['route' => 'exilios.store']) !!}
                        <input type="hidden" name="id_e_ind_fvt" value="{{ $expediente->id_e_ind_fvt }}">

                        {{-- Para regresar a la pantalla de hechos --}}
                        <input type="hidden" name="id_hecho" value="{{ $id_hecho }}">


                        @include('exilios.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
