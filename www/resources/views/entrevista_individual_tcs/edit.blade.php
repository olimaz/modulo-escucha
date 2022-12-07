@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Entrevista Individual Tc
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($entrevistaIndividualTc, ['route' => ['entrevistaIndividualTcs.update', $entrevistaIndividualTc->id], 'method' => 'patch']) !!}

                        @include('entrevista_individual_tcs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection