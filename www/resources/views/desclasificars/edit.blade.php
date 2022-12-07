@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Desclasificar
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($desclasificar, ['route' => ['desclasificars.update', $desclasificar->id_reservado_acceso], 'method' => 'patch']) !!}

                        @include('desclasificars.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection