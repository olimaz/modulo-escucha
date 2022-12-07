@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Mis Casos Adjunto Compartir
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($misCasosAdjuntoCompartir, ['route' => ['misCasosAdjuntoCompartirs.update', $misCasosAdjuntoCompartir->id], 'method' => 'patch']) !!}

                        @include('mis_casos_adjunto_compartirs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection