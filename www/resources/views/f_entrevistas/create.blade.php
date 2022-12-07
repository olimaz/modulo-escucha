@extends('layouts.app')

@section('content_header')
    <h1>
        Condiciones de la entrevista {{ $entrevistaIndividual->entrevista_codigo }}
    </h1>
@endsection

@section('content')

        @include('adminlte-templates::common.errors')
        {!! Form::open(['route' => 'f_entrevistas.store']) !!}
        <input type="hidden" name="id_e_ind_fvt" value="{{ $entrevistaIndividual->id_e_ind_fvt }}">

        <div class="col-sm-12">
            @include('entrevista_individuals.fields_concentimiento')
        </div>

        @include('entrevista_individuals.fields_especs')

        <div class="col-sm-12 text-center">
            <button class="btn btn-primary" type="submit">Grabar</button>
            <a href="{{ action('entrevista_individualController@fichas',$entrevistaIndividual->id_e_ind_fvt) }}" class="btn btn-default">Cancelar</a>
        </div>

        {!! Form::close() !!}

@endsection
