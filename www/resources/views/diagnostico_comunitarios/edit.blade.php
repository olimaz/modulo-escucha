@extends('layouts.app')
@section('content_header')
    <h1>
        Diagnóstico Comunitario {{ $diagnosticoComunitario->entrevista_codigo }}
    </h1>
@endsection
@section('content')

   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($diagnosticoComunitario, ['route' => ['diagnosticoComunitarios.update', $diagnosticoComunitario->id_diagnostico_comunitario], 'method' => 'patch','id'=>'frm_abc']) !!}

                        @include('diagnostico_comunitarios.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection