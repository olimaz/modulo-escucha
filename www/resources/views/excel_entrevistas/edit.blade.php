@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Excel Entrevista
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($excelEntrevista, ['route' => ['excelEntrevistas.update', $excelEntrevista->id], 'method' => 'patch']) !!}

                        @include('excel_entrevistas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection