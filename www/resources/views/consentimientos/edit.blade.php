@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Consentimiento
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($consentimiento, ['route' => ['consentimientos.update', $consentimiento->id], 'method' => 'patch']) !!}

                        @include('consentimientos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection