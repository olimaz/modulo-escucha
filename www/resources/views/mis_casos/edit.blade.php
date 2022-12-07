@extends('layouts.app')

@section('content_header')
    <h1>
        Modificar caso transversal {{ $miCaso->entrevista_codigo }}
    </h1>
@endsection


@section('content')

       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($miCaso, ['route' => ['misCasos.update', $miCaso->id_mis_casos], 'method' => 'patch']) !!}

                        @include('mis_casos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>

@endsection