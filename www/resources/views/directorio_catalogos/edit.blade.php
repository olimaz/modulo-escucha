@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Directorio Catalogo
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($directorioCatalogo, ['route' => ['directorioCatalogos.update', $directorioCatalogo->id], 'method' => 'patch']) !!}

                        @include('directorio_catalogos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection