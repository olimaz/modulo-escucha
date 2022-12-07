@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Entrevista Individual Adjunto
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($entrevistaIndividualAdjunto, ['route' => ['entrevistaIndividualAdjuntos.update', $entrevistaIndividualAdjunto->id], 'method' => 'patch']) !!}

                        @include('entrevista_individual_adjuntos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection