@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Modificar anotación
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($blog, ['route' => ['blogs.update', $blog->id_blog], 'method' => 'patch']) !!}
                        @if(isset($id_mis_casos))
                            {!! Form::hidden('id_mis_casos',$id_mis_casos) !!}
                        @endif

                        @include('blogs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection