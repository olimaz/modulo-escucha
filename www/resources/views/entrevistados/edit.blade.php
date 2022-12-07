@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Entrevistado
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($entrevistado, ['route' => ['entrevistados.update', $entrevistado->id], 'method' => 'patch']) !!}

                        @include('entrevistados.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection