@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Responsable
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($responsable, ['route' => ['responsables.update', $responsable->id], 'method' => 'patch']) !!}

                        @include('responsables.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection