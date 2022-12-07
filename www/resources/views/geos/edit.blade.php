@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Geo
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($geo, ['route' => ['geos.update', $geo->id], 'method' => 'patch']) !!}

                        @include('geos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection