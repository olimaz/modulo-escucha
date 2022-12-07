@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Adjunto
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($adjunto, ['route' => ['adjuntos.update', $adjunto->id], 'method' => 'patch']) !!}

                        @include('adjuntos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection