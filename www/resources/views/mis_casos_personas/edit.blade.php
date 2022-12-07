@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Modificar información de la persona
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($misCasosPersona, ['route' => ['misCasosPersonas.update', $misCasosPersona->id_mis_casos_persona], 'method' => 'patch']) !!}

                        @include('mis_casos_personas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection