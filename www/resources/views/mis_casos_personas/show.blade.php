@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Mis Casos Persona
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('mis_casos_personas.show_fields')
                    <a href="{{ route('misCasosPersonas.index') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
