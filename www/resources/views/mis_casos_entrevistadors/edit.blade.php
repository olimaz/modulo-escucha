@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Mis Casos Entrevistador
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($misCasosEntrevistador, ['route' => ['misCasosEntrevistadors.update', $misCasosEntrevistador->id_mis_casos_entreivstador], 'method' => 'patch']) !!}

                        @include('mis_casos_entrevistadors.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection