@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Evaluación de seguridad
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($nnaSeguridad, ['route' => ['nnaSeguridads.update', $nnaSeguridad->id_nna_seguridad], 'method' => 'patch']) !!}

                        @include('nna_seguridads.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection