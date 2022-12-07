@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Actualizar información del entrevistador
        </h1>
   </section>
   <div class="content">


       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($entrevistador, ['action' => ['entrevistadorController@update', $entrevistador->id_entrevistador], 'method' => 'patch']) !!}
                        @include('entrevistadors.fields')


                   {!! Form::close() !!}

               </div>
           </div>
       </div>
       <div class="row" >
           <div class="col-sm-12">
               @include("entrevistadors.ficha",['usuario'=>$entrevistador->rel_usuario])
           </div>
       </div>
   </div>
@endsection