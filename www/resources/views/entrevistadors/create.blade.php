@extends('layouts.app')

@section('content_header')
    <h1>Bienvenido/a</h1>

    <p>Antes de utilizar la presente plataforma, es necesario que complete la  información de su perfil personal para poder clasificar y ubicar de mejor forma el trabajo realizado por usted.</p>
    <p>¡Gracias por su colaboración!</p>
@endsection



@section('content')


        <div class="row" >
            <div class="col-sm-12">
                @include("entrevistadors.ficha")
            </div>
        </div>


        <div class="clearfix"></div>



        @include('adminlte-templates::common.errors')

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Perfil del entrevistador</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'entrevistadors.store']) !!}

                        @include('entrevistadors.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

@endsection
