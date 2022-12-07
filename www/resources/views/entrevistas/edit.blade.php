@extends('layouts.app')

@section('content')

   <div class="content">
       @include('adminlte-templates::common.errors')
       <section class="content-header">
               <h1 class="page-header">
                   Modificar: ESPECIFICACIONES de las Entrevista
                   <small class="text-primary">
                           Código entrevista: {{$entrevista->fmt_id_e_ind_fvt}}
                   </small>
               </h1>
           </section>

       <!-- <div class="box box-primary">
           <div class="box-body">
               <div class="row"> -->
                   {!! Form::model($entrevista, ['route' => ['entrevistas.update', $entrevista->id_entrevista], 'method' => 'patch']) !!}

                        @include('entrevistas.fields')

                   {!! Form::close() !!}
               <!-- </div>
           </div>
       </div> -->
    </div>
@endsection
