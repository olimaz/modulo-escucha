@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Criterio Fijo
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($criterioFijo, ['route' => ['criterioFijos.update', $criterioFijo->id], 'method' => 'patch']) !!}

                        @include('criterio_fijos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection