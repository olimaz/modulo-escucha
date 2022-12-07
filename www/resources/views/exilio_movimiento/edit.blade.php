@extends('layouts.app')
@include('layouts.js_contrae')
@section('content')
    <section class="content-header">
        <h1>
            Modificar: {{ \App\Models\criterio_fijo::describir(30,$movimiento->id_tipo_movimiento) }}. {{ $expediente->entrevista_codigo }}
            <div class="pull-right">
                <a href="{!! action('exilioController@show',$movimiento->id_exilio) !!}" class="btn btn-default">Cancelar y volver</a>
            </div>
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($exilio, ['action' => ['exilio_movimientoController@update', $movimiento->id_exilio_movimiento], 'method' => 'patch']) !!}
                        @include('exilio_movimiento.fields')
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection