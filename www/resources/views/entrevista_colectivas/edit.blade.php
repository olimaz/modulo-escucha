@extends('layouts.app')
@section('content_header')
    <h1>
        Entrevista Colectiva {{ $entrevistaColectiva->entrevista_codigo }}
    </h1>
@endsection
@section('content')

   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($entrevistaColectiva, ['route' => ['entrevistaColectivas.update', $entrevistaColectiva->id_entrevista_colectiva], 'method' => 'patch','id'=>'frm_abc']) !!}

                        @include('entrevista_colectivas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection