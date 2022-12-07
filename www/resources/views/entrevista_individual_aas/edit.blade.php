@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Entrevista Individual Aa
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($entrevistaIndividualAa, ['route' => ['entrevistaIndividualAas.update', $entrevistaIndividualAa->id], 'method' => 'patch']) !!}

                        @include('entrevista_individual_aas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection