@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Casos Informes Interes
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'casosInformesInteres.store']) !!}

                        @include('casos_informes_interes.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
