@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Acceso Edicion
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($accesoEdicion, ['route' => ['accesoEdicions.update', $accesoEdicion->id], 'method' => 'patch']) !!}

                        @include('acceso_edicions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection