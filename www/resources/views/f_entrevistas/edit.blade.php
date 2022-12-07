@extends('layouts.app')
@section('content_header')
    <h1>
        Modificar las condiciones de la entrevista {{ $entrevistaIndividual->entrevista_codigo }}
    </h1>
@endsection

@section('content')
    @include('adminlte-templates::common.errors')
    {!! Form::model($fEntrevista, ['route' => ['f_entrevistas.update', $fEntrevista->id_entrevista], 'method' => 'patch']) !!}


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