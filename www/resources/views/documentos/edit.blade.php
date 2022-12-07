@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Modificar documento existente
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($documento, ['route' => ['documentos.update', $documento->id_documento], 'method' => 'patch','id'=>'frm_nuevo']) !!}

                        @include('documentos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection