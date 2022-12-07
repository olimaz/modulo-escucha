@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Evaluación de  Vulnerabiliad
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($nnaVulnerabiliad, ['route' => ['nnaVulnerabiliads.update', $nnaVulnerabiliad->id_nna_vulnerabilidad], 'method' => 'patch']) !!}

                        @include('nna_vulnerabiliads.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection