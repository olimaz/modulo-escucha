@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Entrevista Individual Fr
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'entrevistaIndividualFrs.store']) !!}

                        @include('entrevista_individual_frs.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
