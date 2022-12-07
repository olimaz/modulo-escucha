@extends('layouts.app')
@include('layouts.js_contrae')

@section('content')
    <section class="content-header">
        <h1>
            Modificar: Exilio. {{ $expediente->entrevista_codigo }}
            <div class="pull-right">
                @if($id_hecho <= 0)
                    <a href="{{ action('exilioController@show',$exilio->id_exilio) }}" class="btn btn-default">Volver</a>
                @else
                    <a href="{{ action('hechoController@edit',$id_hecho) }}" class="btn btn-default">Volver</a>
                @endif
            </div>
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($exilio, ['route' => ['exilios.update', $exilio->id_exilio], 'method' => 'patch']) !!}

                        <input type="hidden" name="id_e_ind_fvt" value="{{ $exilio->id_e_ind_fvt }}">
                        <input type="hidden" name="id_exilio_movimiento" value="{{ $movimiento->id_exilio_movimiento }}">
                        {{-- Para regresar a la pantalla de hechos --}}
                        <input type="hidden" name="id_hecho" value="{{ $id_hecho }}">

                        @include('exilios.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection