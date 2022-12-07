@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Censo Archivos Permisos
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($censoArchivosPermisos, ['route' => ['censoArchivosPermisos.update', $censoArchivosPermisos->id], 'method' => 'patch']) !!}

                        @include('censo_archivos_permisos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection