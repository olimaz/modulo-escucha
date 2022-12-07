@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            NNA: Nueva evaluación de vulnerabiliad
        </h1>
        <p><span class="text-danger">Atención: </span>Si se elige alguna de las opciones marcadas en rojo,  es necesaria una mayor revisión antes de la toma del testimonio. </p>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::model( $nnaVulnerabiliad, ['route' => 'nnaVulnerabiliads.store']) !!}

                        @include('nna_vulnerabiliads.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
