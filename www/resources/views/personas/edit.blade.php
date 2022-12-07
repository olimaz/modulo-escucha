@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Modificar: Datos de la persona entrevistada - {!! $entrevistaIndividual->entrevista_codigo !!}
            <div class="pull-right">
                <a href="{!! route('entrevistaindividual.fichas', [$persona->id_e_ind_fvt]) !!}" class="btn btn-default pull-right">Volver</a>
            </div>              
        </h1>        
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">


                   {!! Form::model($persona, ['route' => ['personas.update', $persona->id_persona], 'name'=>'persona_entrevistada', 'id'=>'persona_entrevistada', 'method' => 'patch']) !!}    
                        <input type="hidden" id="updt" name="updt" value="">
                        <input type="hidden" id="pendiente_entrevista" name="pendiente_entrevista" value="{{$pendiente_entrevista}}">

                        @include('personas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection