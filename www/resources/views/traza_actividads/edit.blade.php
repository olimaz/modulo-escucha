@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Traza Actividad
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($trazaActividad, ['route' => ['trazaActividads.update', $trazaActividad->id], 'method' => 'patch']) !!}

                        @include('traza_actividads.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection