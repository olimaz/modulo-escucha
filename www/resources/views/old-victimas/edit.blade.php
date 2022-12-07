@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Victima
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($victima, ['route' => ['victimas.update', $victima->id], 'method' => 'patch']) !!}

                        @include('victimas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection