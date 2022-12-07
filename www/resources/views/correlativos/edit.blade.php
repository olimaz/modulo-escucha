@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Correlativo
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($correlativo, ['route' => ['correlativos.update', $correlativo->id], 'method' => 'patch']) !!}

                        @include('correlativos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection