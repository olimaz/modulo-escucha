@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Entrevista Individual Tv
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($entrevistaIndividualTv, ['route' => ['entrevistaIndividualTvs.update', $entrevistaIndividualTv->id], 'method' => 'patch']) !!}

                        @include('entrevista_individual_tvs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection